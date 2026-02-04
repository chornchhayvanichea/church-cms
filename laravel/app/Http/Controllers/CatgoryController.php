<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CatgoryController extends Controller
{
    public function show(Category $category): CategoryResource
    {
        return new CategoryResource($category);
    }

    public function index(): AnonymousResourceCollection
    {
        $categories = Category::paginate(15);

        return CategoryResource::collection($categories);
    }

    public function store(Request $request): CategoryResource
    {
        $validated = $request->validate(['name' => ['required', 'string', 'max:255']]);
        $category = Category::create($validated);

        return new CategoryResource($category);
    }

    public function update(Request $request, Category $category): CategoryResource
    {
        $validate = $request->validate(['name' => ['sometimes', 'string', 'max:255']]);
        $category->update($validate);

        return new CategoryResource($category);
    }

    public function destroy(Category $category): JsonResponse
    {
        $category->delete();

        return response()->json([
            'message' => 'category has been deleted successfully',
        ]);
    }
}
