<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Services\CategoryService;
use Illuminate\Http\Request;
use App\Models\Category;



class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }
    public function index(Request $request)
    {
        if (isset($request->active) && $request->active) {
            $categories = $this->categoryService->filterActiveCategories();
            return CategoryResource::collection($categories);
        }

        $categories = $this->categoryService->listCategories($request->get('per_page', 10));

        return CategoryResource::collection($categories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $category = $this->categoryService->createCategory($request->validated());

        return new CategoryResource($category);
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = $this->categoryService->showCategory($id);
        return new CategoryResource($category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {   
        $category = $this->categoryService->updateCategory($category, $request->all());
        return new CategoryResource($category);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
            $category = $this->categoryService->deleteCategory($id);

            return response()->json([
                'message' => 'Category deleted successfully',
                'category' => $category
            ], 200);
    }
}
