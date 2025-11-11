<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Store;
use Illuminate\Http\Request;

class ApiProductDetails extends Controller
{
    use ApiResponseTrait;
    public function index(Request $request)
    {
        $productName = $request->input('product_name');
        $storeName = $request->input('store_name');

        // Find the store by name
        $store = Store::where('name', $storeName)->first();

        if (!$store) {
            return response()->json(['error' => 'Store not found'], 404);
        }

        // Find the product by name and store ID
        $product = Product::where('name', $productName)
            ->where('store_id', $store->id)
            ->first();

        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }
        $product = [
            'name' => $product->name,
            'description' => $product->description,
            'price' => $product->price,
            'compare_price' => $product->compare_price,
            'photo' => $product->image_url,
            'store_name' => $store->name,
        ];

        $groups = [
            [
                'name' => 'product',
                'type' => 'products',
                'items' => $product
            ],
        ];
        return $this->apiResponse([
            $groups
        ], 'ok', 200);
    }
}
