<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Store;

class ProductStoreController extends Controller
{
    public function index(Store $store) {
        $productstore = Product::where('store_id', $store->id)->active()->paginate(12);
        return view('front.all-productstore', compact('productstore'));
    }
    
}
