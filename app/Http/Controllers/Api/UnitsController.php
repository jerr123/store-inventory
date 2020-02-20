<?php

namespace App\Http\Controllers\Api;

use App\Models\Unit;
use Illuminate\Http\Request;
use App\Transformers\UnitTransformer;

class UnitsController extends Controller
{
    public function index(Request $request)
    {
        return $this->response->collection(Unit::all(), new UnitTransformer());
    }
}
