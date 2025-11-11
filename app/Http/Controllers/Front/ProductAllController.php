<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Store;

class ProductAllController extends Controller
{
        public function index() {
            $products = Product::active()->paginate(12);
            return view('front.all-products', compact('products'));
        }

        public function showproduct() {
            $productsBest = Product::with('category')->active()
            ->quantity()
            ->featured()
            ->paginate(4);
            return view('front.best-products', compact('productsBest'));
        }
        public function showproductStore(Store $store) {
            $productstore = Product::where('store_id', $store->id)->active()
                ->get();
          //  dd( Product::where('store_id', $store->id)->active());
            return view('front.all-productstore', compact('productstore'));
        }
}
