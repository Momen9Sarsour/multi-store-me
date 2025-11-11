<?php

namespace App\Http\Controllers\employeeVendor;
use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function index(Request $request)
    {
        $category = Category::all();

        $query = Category::query();

        // Apply name filter
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->input('search') . '%');
        }

        $status = $request->input('status');
        if ($status === 'active') {
            $query->where('status', 'active');
        } elseif ($status === 'archived') {
            $query->where('status', 'archived');
        }

        $categories = $query->get();
        $search = $request->search;
        $status = $request->status;

        return view('employeeVendor.category.index', compact('category','search'));
    }
}
