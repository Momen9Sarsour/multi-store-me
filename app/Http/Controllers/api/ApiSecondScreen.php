<?php

namespace App\Http\Controllers\api;

use App\Models\Cart;
use App\Models\Store;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ApiSecondScreen extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use ApiResponseTrait;

    public function index(Request $request)
    {
        $categoryName = $request->input('category_name');
        $category = Category::with('store')->where('name', $categoryName)->firstOrFail();

        $query = Store::whereHas('categories', function ($query) use ($category) {
            $query->where('name', $category->name);
        });

        if ($request->has('store')) {
            $store = $request->input('store');
            $query->where('name', 'like', '%' . $store . '%');
        } else {
            $store = null;
        }

        // Retrieve the filtered stores
        $stores = $query->get();

        // Show all categories in all stores
        $categories = Category::with('store')->get();
        $groupedCategories = $categories->groupBy('name');

        $groups = [
            [
                'name' => 'searchstore',
                'type' => 'stores',
                'items' => $stores
            ],
            [
                'name' => 'categories',
                'type' => 'categories',
                'items' => $groupedCategories
            ]
        ];
        return $this->apiResponse([
            'stores' => $groups
        ], 'ok', 200);
    }
}
