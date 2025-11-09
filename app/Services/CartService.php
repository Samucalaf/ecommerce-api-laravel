<?php

namespace App\Services;

use App\Models\Product;
use App\Repositories\CartRepository;

class CartService
{

    protected $cartRepository;

    public function __construct(CartRepository $cartRepository)
    {
        $this->cartRepository = $cartRepository;
    }

    public function showCartUser($idUser)
    {
        if (!$idUser) {
            throw new \InvalidArgumentException("Invalid user ID.");
        }

        return $this->cartRepository->getCartByUserId($idUser);
    }

    public function clearUserCart($userId)
    {
        $userCart = $this->cartRepository->getCartByUserId($userId);
        if (!$userCart) {
            return true;
        }

        if (isset($userCart->is_active) && $userCart->is_active === false) {
            throw new \InvalidArgumentException("Cart is inactive.");
        }


        return $this->cartRepository->clearCart($userId);
    }
}
