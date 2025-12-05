<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use Illuminate\Http\Request;
use App\Services\ProductService;
use App\Http\Resources\ProductResource;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    protected $productService;
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }
    public function index(Request $request)
    {
        $this->authorize('viewAny', Product::class);
        $searchTerm = $request->query('search');

        if ($searchTerm) {
            $products = $this->productService->searchProducts($searchTerm);
            return ProductResource::collection($products);
        }
        $filters = $request->only(['category_id', 'min_price', 'max_price']);
        $products = $this->productService->listProducts($filters, $request->get('per_page', 15));
        return ProductResource::collection($products);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $this->authorize('create', Product::class);
        $product = $this->productService->createProduct($request->validated());

        return new ProductResource($product);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $this->authorize('view', $product);
        return new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $this->authorize('update', $product);
        $updatedProduct = $this->productService->updateProduct($product->id, $request->validated());
        return new ProductResource($updatedProduct);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $product = $this->productService->getProductById($id);


        if (!$product) {
            return response()->json([
                'message' => 'Product not found or cannot be deleted',
            ], 404);
        }

        $this->authorize('delete', $product);
        
        $this->productService->deleteProduct($id);
        return response()->json([
            'message' => 'Product deleted successfully',
        ], 200);
    }
}
