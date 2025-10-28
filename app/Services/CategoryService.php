<?php

namespace App\Services;

use App\Models\Category;
use App\Repositories\CategoryRepository;
use Illuminate\Support\Facades\Log;


class CategoryService
{
    protected $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }



    public function listCategories($perPage = 10)
    {
        try {
            $categories = $this->categoryRepository->paginateWithRelations($perPage);
            return $categories;
        } catch (\Exception $e) {
            Log::error('Category listing failed: ' . $e->getMessage());
            throw $e;
        }
    }

    public function filterActiveCategories()
    {
        try {
            return $this->categoryRepository->allActive();
        } catch (\Exception $e) {
            Log::error('Filtering active categories failed: ' . $e->getMessage());
            throw $e;
        }
    }

    public function createCategory(array $data)
    {
        try {
            $existingCategory = $this->categoryRepository->findByName($data['name']);

            if ($existingCategory) {
                throw new \InvalidArgumentException('The category exists');
            }

            return $this->categoryRepository->create($data);
        } catch (\Exception $e) {
            Log::error('Category creation failed: ' . $e->getMessage());
            throw $e;
        }
    }

    public function updateCategory(Category $category, array $data)
    {
        try {
            $existingCategory = $this->categoryRepository->findByName($data['name']);
            $existingCategoryBySlug = $this->categoryRepository->findBySlug($data['slug']);

            if ($existingCategory) {
                throw new \InvalidArgumentException('The category name exists');
            }

            if ($existingCategoryBySlug) {
                throw new \InvalidArgumentException('The category slug exists');
            }



            return $this->categoryRepository->update($category, $data);
        } catch (\Exception $e) {
            Log::error('Category update failed: ' . $e->getMessage());
            throw $e;
        }
    }

    public function showCategory(string $id)
    {
        try {
            $category = $this->categoryRepository->findById($id);
            if (!$category) {
                throw new \Exception('Category not found');
            }
            return $category;
        } catch (\Exception $e) {
            Log::error('Category retrieval failed: ' . $e->getMessage());
            throw $e;
        }
    }

    public function deleteCategory(string $id)
    {
        try {
            $category = $this->categoryRepository->findById($id);

            if (!$category) {
                return response()->json(['message' => 'Category does not exist'], 400);
            }

            if ($category->products()->count() > 0) {
                throw new \DomainException(
                    'not possible delete this category, because there are products associate'
                );
            }

            $deleted = $this->categoryRepository->delete($id);

            return true;
        } catch (\Exception $e) {
            Log::error('Category deletion failed: ' . $e->getMessage());
            throw $e;
        }
    }
}
