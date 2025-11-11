<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Store;
use App\Models\Category;

class CategoryStoreController extends Controller
{
    //

    public function index()
    {

        return view('front.categories.show');

    }

    // public function show($slug,Request $request) {
    //     $category = Category::with('store')->where('slug', $slug)->firstOrFail();
    //     $categories = Category::where('name', $category->name)->with('store')->get();

    //     // $categories = Store::where('category_id', $category->id)->with('products')->get();

    //     return view('front.categories.show', compact('category', 'categories'));
    // }

    // هذا بدو حذف الملف لانو موجود نفسو في كنترولر ستورز
    
    public function show($slug, Request $request) {
        $category = Category::with('store')->where('slug', $slug)->firstOrFail();

        $query = Category::where('name', $category->name)->with('store');

        if ($request->has('searchName')) {
            $query->whereHas('store', function ($subQuery) use ($request) {
                $subQuery->where('name', 'like', '%' . $request->input('searchName') . '%');
            });
        }

        $categories = $query->paginate(6);
        $searchName = $request->searchName;

        return view('front.categories.show', compact('category', 'categories', 'searchName'));
    }


}
