<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Store;
use Illuminate\Http\Request;

class ApiThirdScreen extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use ApiResponseTrait;
    public function index(Request $request)
    {

        $storeName = $request->input('store_name');
        $productName = $request->input('product_name');
        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');

        $store = Store::where('name', $storeName)->first();
        if (!$store) {
            return response()->json(['error' => 'Store not found'], 404);
        }
        $productQuery = Product::where('store_id', $store->id)
        ->where('name', 'like', '%' . $productName . '%')
        ->active();

    if (!empty($minPrice) && is_numeric($minPrice)) {
        $productQuery->where('price', '>=', $minPrice);
    }

    if (!empty($maxPrice) && is_numeric($maxPrice)) {
        $productQuery->where('price', '<=', $maxPrice);
    }

    $productstore = $productQuery->paginate(6);

        $groups = [
            [
                'name' => 'product',
                'type' => 'products',
                'items' => $productstore
            ],
        ];

        return $this->apiResponse([
           $groups
        ], 'ok', 200);
    }


}
