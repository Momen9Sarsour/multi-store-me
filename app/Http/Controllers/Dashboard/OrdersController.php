<?php

namespace App\Http\Controllers\Dashboard;

use Exception;
use App\Models\User;
use App\Models\Order;
use App\Models\Store;
use App\Models\Product;
use App\Models\Category;
use App\Models\Delivery;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class OrdersController extends Controller
{
    //
    public function index(Request $request)
    {
        $store = Auth::user()->store;

        $category = Category::all();
        $product = Product::all();
        $user = User::all();
        $delivery = Delivery::all();

        $query = Order::where('store_id', $store->id);
        $status = $request->input('status');
        if ($status && in_array(strtolower($status), ['pending', 'processing', 'delivering', 'completed', 'cancelled', 'refunded'])) {
            $query->where('status', strtolower($status));
        }
        $search = $request->input('search');
        if ($search) {
            $query->whereHas('products', function ($query) use ($search) {
                $query->where('product_name', 'like', '%' . $search . '%');
            });
        }
        $orders = $query->with(['products', 'user', 'delivery'])->get();

        return view('dashboard.VendorAdmin.orders.index', compact('category', 'product', 'store', 'user', 'delivery', 'orders', 'search', 'status'));
    }

    public function create()
    {
        $user = User::all();
        $users = Auth::user();
        $store = $users->store;
        $product = $store->products;
        $delivery = Delivery::all();
        $order = new Order();
        return view('dashboard.VendorAdmin.orders.create', compact('user', 'product', 'delivery', 'order'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'nullable',
            'store_id' => 'nullable',
            'delivery_id' => 'nullable',
            'product_id' => 'nullable',
            'total' => 'required',
            'address' => 'nullable',
            'status' => 'nullable',
        ]);
        // store data
        $store = Auth::user()->store;
        $order = new Order();
        $order->user_id = $request->user_id;
        $order->store_id = $store->id;
        $order->delivery_id = $request->delivery_id;
        $order->product_id = $request->product_id;
        $order->total = $request->total;
        // $order->address = $request->address;
        $order->payment_method = "Payment";
        $order->status = $request->status;
        $order->save();
        // dd($request->all());
        //PRG
        return redirect()->route('VendorAdminOrders.index')->with('success', 'Order created!');
    }

    public function edit(string $id)
    {
        try {
            $order = Order::findorfail($id);
        } catch (Exception $e) {
            return redirect()->route('adminOrder.index')
                ->with('info', 'Record not found');
        }
        $user = User::all();
        $users = Auth::user();
        //   $store=Store::findOrFail($id);
        $store = $users->store; // Assuming you have a relationship set up between User and Store models
        $product = $store->products;
        $delivery = Delivery::all();
        $order = Order::findOrFail($id);

        return view('dashboard.VendorAdmin.orders.edit', compact('user', 'product', 'delivery', 'order'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'user_id' => 'nullable',
            'store_id' => 'nullable',
            'delivery_id' => 'nullable',
            'product_id' => 'nullable',
            'total' => 'required',
            'address' => 'nullable',
            'status' => 'nullable',
        ]);
        //store data
        $store = Auth::user()->store;
        $order = Order::find($id);
        $order->user_id = $request->user_id;
        $order->store_id = $store->id;
        $order->delivery_id = $request->delivery_id;
        $order->product_id = $request->product_id;
        $order->total = $request->total;
        // $order->address = $request->address;
        $order->payment_method = "Payment";
        $order->status = $request->status;
        $order->save();

        return redirect()->route('VendorAdminOrders.index')->with('success', 'Order updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $order = Order::findOrFail($id);
        $order->delete();
        return redirect()->route('VendorAdminOrders.index')->with('success', 'Order deleted!');
    }
}
