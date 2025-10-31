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



    /**
     * List categories with pagination.
     *
     * @param int $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function listCategories($perPage = 10)
    {
        try {
            return $this->categoryRepository->paginateWithRelations($perPage);
        } catch (\Exception $e) {
            Log::error('Category listing failed for perPage=' . $perPage . ': ' . $e->getMessage());
            throw $e;
        }
    }

    public function filterActiveCategories()
    {
        try {
            return $this->categoryRepository->allActive();
        } catch (\Exception $e) {
            Log::error('Filtering active categories failed', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    public function createCategory(array $data)
    {
        try {
            $existingCategory = $this->categoryRepository->findByName($data['name']);

            if ($existingCategory) {
                throw new \InvalidArgumentException('The category with this name already exists');
            }

            return $this->categoryRepository->create($data);
        } catch (\Exception $e) {
            Log::error('Category creation failed: ' . $e->getMessage());
            throw new \Exception('Failed to create category.');
        }
    }

    public function updateCategory(Category $category, array $data)
    {
        try {
            if (isset($data['name']) && $data['name'] !== $category->name) {
                $existingCategory = $this->categoryRepository->findByName($data['name']);
                if ($existingCategory) {
                    throw new \InvalidArgumentException('Category name already exists.');
                }
            }

            if (isset($data['slug']) && $data['slug'] !== $category->slug) {
                $existingCategoryBySlug = $this->categoryRepository->findBySlug($data['slug']);
                if ($existingCategoryBySlug) {
                    throw new \InvalidArgumentException('Category slug already exists.');
                }
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
            Log::warning('Category retrieval failed', ['id' => $id, 'error' => $e->getMessage()]);
            throw $e;
        }
    }

    public function deleteCategory(string $id)
    {
        try {
            $category = $this->categoryRepository->findById($id);

            if (!$category) {
                return false;
            }

            if ($category->products()->count() > 0) {
                throw new \DomainException(
                    'Cannot delete category with associated products'
                );
            }

            $this->categoryRepository->delete($id);
            return true;
        } catch (\Exception $e) {
            Log::error('Category deletion failed: ' . $e->getMessage());
            throw $e;
        }
    }
}
