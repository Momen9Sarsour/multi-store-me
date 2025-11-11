<?php

namespace App\Http\Controllers\api;


use App\Models\Store;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

// HomeController.php
class ApiFirstScreen extends Controller
{

    use ApiResponseTrait;

    public function index()
    {
        $products = Product::with('category')->active()->limit(6)->get();
        $productBest = Product::with('category')->active()->quantity()->featured()->get();
        $productFeatured = Product::with('category')->active()->quantity()->featured()->get();
        $highPricedProducts = Product::with('category')->orderByDesc('price')->limit(1)->active()->quantity()->get();
        $storeRated = Store::leftJoin('orders', 'stores.id', '=', 'orders.store_id')
            ->select(
                'stores.id',
                'stores.name',
                'stores.image',
                DB::raw('COUNT(orders.id) as order_count')
            )
            ->groupBy('stores.id', 'stores.name', 'stores.image')
            ->orderByDesc('order_count')
            ->get();

            $categories = Category::with('store')->get();
            $groupedCategories = $categories->groupBy('name');

        $groups = [

            [
                'name' => 'categories',
                'type' => 'slider',
                'items' => $groupedCategories
            ],
            [
                'name' => 'products',
                'type' => 'slider',
                'items' => $products
            ],

            [
                'name' => 'product Best',
                'type' => 'products',
                'items' => $productBest
            ],
            [
                'name' => 'product Featured',
                'type' => 'slider',
                'items' => $productFeatured
            ],
            [
                'name' => 'high Priced Products',
                'type' => 'slider',
                'items' => $highPricedProducts
            ],
            [
                'name' => 'store Rated',
                'type' => 'stores',
                'items' => $storeRated
            ],
    ];
        return $this->apiResponse([
            $groups
        ],
        'ok', 200);
    }
}
