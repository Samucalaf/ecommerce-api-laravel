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
            return $categories->sortBy('name');
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

            if (!$data) {
                throw new \InvalidArgumentException('Invalid data provided for category creation');
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

            if (!$data) {
                throw new \InvalidArgumentException('Invalid data provided for category update');
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
            if (!$id) {
                return response()->json(['message' => 'Invalid category ID provided for deletion'], 400);
            }

            $deleted = $this->categoryRepository->delete($id);

            if (!$deleted) {
                throw new \Exception('Category not found for deletion');
            }
            return true;
        } catch (\Exception $e) {
            Log::error('Category deletion failed: ' . $e->getMessage());
            throw $e;
        }
    }
}
