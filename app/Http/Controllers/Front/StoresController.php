<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Store;
use App\Models\Product;

class StoresController extends Controller
{

    public function showProducts(Store $store){
        $products = Product::where('store_id', $store->id)->latest()
        ->limit(8)->active()->Quantity()->get();
        $categories = Category::where('store_id', $store->id)->limit(6)->get();
        $discountedProducts =  Product::where('store_id', $store->id)
        ->limit(3)->active() ->quantity() ->discounted()->get();
        $fiftyPercentOfferProducts =  Product::where('store_id', $store->id)
        ->limit(1)->active() ->quantity() ->fiftyPercentOffer()->get();
        $featuredProducts = Product::where('store_id', $store->id)
        ->latest()->limit(2)->active()->quantity()->featured()->get();
        $largeDiscountProducts = Product::where('store_id', $store->id)
        ->limit(2)->active()->quantity()->largediscounted()->get();
        $highestPricedProducts = Product::where('store_id', $store->id)
        ->orderByDesc('price')->limit(1)->active()->quantity()->get();

        return view('front.home', compact('store', 'products', 'categories', 'discountedProducts', 'fiftyPercentOfferProducts', 'featuredProducts','largeDiscountProducts','highestPricedProducts'));
    }

    public function showCategories(Store $store){
    $categorystore = Category::where('store_id', $store->id)->paginate(12);
    return view('front.CategoryStore', compact('categorystore'));
    }

}
