<?php 

namespace App\Services;
use App\Models\Product;
use App\Repositories\CartItemRepository;
class CartItemService
{
    protected $cartItemRepository;

    public function __construct(CartItemRepository $cartItemRepository)
    {
        $this->cartItemRepository = $cartItemRepository;
    }

        public function addProductToCart($idUser, $productId, $quantity)
    {
        $product = Product::find($productId);
        if (!$product ) {
            throw new \InvalidArgumentException("Invalid product ID.");
        }

        if ($product->is_active === false){
            throw new \InvalidArgumentException("Product is inactive.");
        }

        if ($product->stock < $quantity) {
            throw new \InvalidArgumentException("Insufficient stock for the product.");
        }

        return $this->cartItemRepository->postProductToCart($idUser, $productId, $quantity);
    }

        public function updateProductInCart($userId, $productId, $quantity)
    {
        $product = Product::find($productId);
        if (!$product) {
            throw new \InvalidArgumentException("Product does not exist in cart.");
        }

        if ($product->is_active === false){
            throw new \InvalidArgumentException("Product is inactive.");
        }

        if ($product->stock < $quantity) {
            throw new \InvalidArgumentException("Insufficient stock for the product.");
        }
        return $this->cartItemRepository->updateProduct($userId, $product, $quantity);
    }

        public function removeProductFromCart($userId, $productId)
    {
        $product = Product::find($productId);

        if (!$product) {
            throw new \InvalidArgumentException("Product does not exist in cart");
        }
        if ($product->is_active === false){
            throw new \InvalidArgumentException("Product is inactive.");
        }

        return $this->cartItemRepository->removeProduct($userId, $product);
    }


}