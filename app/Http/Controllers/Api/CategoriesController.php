<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Transformers\CategoryTransformer;

class CategoriesController extends Controller
{
    public function index(Request $request)
    {
        return $this->response->collection(Category::all(), new CategoryTransformer());
    }
}
