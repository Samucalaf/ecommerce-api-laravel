<?php

namespace App\Repositories;

use App\Models\Product;

class ProductRepository
{

    protected $model;
    public function __construct(protected Product $product)
    {
        $this->model = $product;
    }

    public function search(string $term)
    {
        return $this->model->where('name', 'LIKE', "%$term%")
            ->orWhere('description', 'LIKE', "%$term%")
            ->get();
    }
    public function getFilteredProducts(array $filters, $perPage)
    {
        $query = $this->model->with('category')->orderBy('name');

        if (isset($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }

        if (isset($filters['min_price'])) {
            $query->where('price', '>=', $filters['min_price']);
        }

        if (isset($filters['max_price'])) {
            $query->where('price', '<=', $filters['max_price']);
        }

        return $query->paginate($perPage);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function findById($id)
    {
        return $this->model->find($id);
    }

    public function findByName($name)
    {
        return $this->model->where('name', $name)->first();
    }

    public function findBySlug($slug)
    {
        return $this->model->where('slug', $slug)->first();
    }

    public function stockCount($id)
    {
        $product = $this->findById($id);
        return $product ? $product->stock : null;
    }

    public function isActive($id)
    {
        $product = $this->findById($id);
        return $product ? $product->is_active : null;
    }

    public function update(Product $product, array $data)
    {
        $product->update($data);
        return $product->fresh();
    }

    public function delete(string $id)
    {
        $product = $this->findById($id);
        return $product?->delete();
    }
}
