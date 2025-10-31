<?php


namespace App\Services;

use App\Models\Product;
use App\Repositories\ProductRepository;
use App\Repositories\CategoryRepository;

class ProductService
{
    protected $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function listProducts(array $filters, $perPage = 15)
    {
        try {
            return $this->productRepository->getFilteredProducts($filters, $perPage);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function searchProducts(string $term)
    {
        try {
            $term = trim($term);
            if (empty($term)) {
                return [];
            }

            return $this->productRepository->search($term);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function createProduct(array $data)
    {
        try {
            $existingSlug = $this->productRepository->findBySlug($data['slug']);
            if ($existingSlug) {
                throw new \Exception("Product with slug {$data['slug']} already exists");
            }

            if ($data['price'] < 0) {
                throw new \Exception("Price cannot be negative");
            }

            if ($data['stock'] < 0) {
                throw new \Exception("Stock cannot be negative");
            }

            if ($data['category_id']) {
                $category = app(CategoryRepository::class)->findById($data['category_id']);
                if (!$category) {
                    throw new \Exception("Category not found");
                }
            }
            return $this->productRepository->create($data);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function getProductById($id)
    {
        try {
            $product = $this->productRepository->findById($id);
            if (!$product) {
                throw new \Exception("Product not found");
            }
            return $product;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function updateProduct($id, array $data)
    {
        try {
            $product = $this->productRepository->findById($id);
            if (!$product) {
                throw new \Exception("Product not found");
            }
            if (isset($data['price']) && $data['price'] < 0) {
                throw new \Exception("Price cannot be negative");
            }

            if (isset($data['stock']) && $data['stock'] < 0) {
                throw new \Exception("Stock cannot be negative");
            }

            if (!$this->productRepository->isActive($product->id)) {
                throw new \Exception("Cannot update inactive product");
            }

            $updatedProduct = $this->productRepository->update($product, $data);
            return $updatedProduct;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function deleteProduct($id)
    {
        try {
            $product = $this->productRepository->findById($id);
            if (!$product) {    
                return false;
            }
            if ($this->productRepository->stockCount($id) > 0) {
                throw new \Exception("Cannot delete product with stock available");
            }
            $product = $this->productRepository->delete($id);
            return true;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
