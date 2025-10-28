<?php

namespace App\Repositories;

use App\Models\Category;

class CategoryRepository
{
    protected $model;

    public function __construct(Category $category)
    {
        $this->model = $category;
    }

    public function paginateWithRelations($perPage = 10)
    {
        return $this->model->with('products')->paginate($perPage);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function findById($id)
    {
        return $this->model->find($id);
    }
    public function update(Category $category, array $data)
    {
        $category->update($data);
        return $category;
    }

    public function delete(string $id)
    {
        $category = $this->findById($id);
        if (!$category) {
            return null;
        }
        return $category->delete();
    }

    public function allActive()
    {
        return $this->model->where('is_active', true)->get();
    }
}
