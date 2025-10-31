<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
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
        $this->authorize('viewAny', Category::class);
        if ($request->has('active') && filter_var($request->active, FILTER_VALIDATE_BOOLEAN)) {
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
        $this->authorize('create', Category::class);
        $category = $this->categoryService->createCategory($request->validated());

        return new CategoryResource($category);
    }
    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        $this->authorize('view', $category);
        return new CategoryResource($category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $this->authorize('update', $category);  
        $category = $this->categoryService->updateCategory($category, $request->all());
        return new CategoryResource($category);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->authorize('delete', Category::class);    
        $category = $this->categoryService->deleteCategory($id);

        if ($category === true) {
            return response()->json([
                'message' => 'Category deleted successfully',
            ], 200);
        }

        return response()->json([
            'message' => 'Category not found or could not be deleted'
        ], 404);
    }
}
