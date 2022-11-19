<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class SelectionController extends Controller
{
    public function getProductsAjax()
    {
        $products = Product::when(\request('except'), function ($q) {
            $q->where('id', '<>', \request('except'));
        })
            ->when(\request('search'), function ($q) {
                $search = '%' . \request('search') . '%';
                $q->where('name', 'LIKE', $search);
            })
            ->limit(10)->get();

        return response()->json(['products' => $products]);
    }
}
