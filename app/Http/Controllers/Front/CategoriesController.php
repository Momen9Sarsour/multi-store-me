<?php

namespace App\Http\Controllers\Front;
use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    //
    public function show(Category $category)
    {
     //   $store = $category->store;

       /// return view('front.categories.show', compact('store', 'category'));
    }
}
