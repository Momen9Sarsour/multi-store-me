<?php

namespace App\Http\Controllers\employeeVendor;
use App\Models\Delivery;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DeliveriesController extends Controller
{
    public function index(Request $request)
    {
        $del = Delivery::all();
        $query = Delivery::query();

        // Apply name filter
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->input('search') . '%');
        }

        $deliveries = $query->get();
        $search = $request->search;
        return view('employeeVendor.delivery.index', compact('del','search'));
    }


}
