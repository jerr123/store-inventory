<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\Api\CategoryRequest;

use App\Transformers\CategoryTransformer;

class CategoriesController extends Controller
{
    public function index(Request $request)
    {
        return $this->response->collection(Category::all(), new CategoryTransformer());
    }

    public function store(CategoryRequest $request, Category $category)
    {
        $category->fill($request->all());
        $category->save();
        return $this->response->item($category, new CategoryTransformer())->setStatusCode(201);
    }
}
