<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Delivery;
use App\Models\Order;
use App\Models\Product;
use App\Models\Store;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $store = Store::all();
        $category = Category::all();
        $product = Product::all();
        $user = User::all();
        $order = Order::all();
        $delivery = Delivery::all();

        $query = Order::query();

        // Apply name filter
        // if ($request->has('search')) {
        //     $query->where('name', 'like', '%' . $request->input('search') . '%');
        // }

        $status = $request->input('status');
        if ($status === 'Pending') {
            $query->where('status', 'pending');
        } elseif ($status === 'processing') {
            $query->where('status', 'processing');
        } elseif ($status === 'delivering') {
            $query->where('status', 'delivering');
        } elseif ($status === 'completed') {
            $query->where('status', 'completed');
        } elseif ($status === 'cancelled') {
            $query->where('status', 'cancelled');
        } elseif ($status === 'refunded') {
            $query->where('status', 'refunded');
        }

        $orders = $query->get();
        $search = $request->search;
        $status = $request->status;

        return view('adminStore.order.index', compact('category', 'product', 'store', 'user', 'order', 'delivery', 'orders', 'search', 'status'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $store = Store::all();
        $user = User::all();
        $product = Product::all();
        $delivery = Delivery::all();
        $order = new Order();
        return view('adminStore.order.create', compact('store', 'user', 'product', 'delivery', 'order'));
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
        $order = new Order();
        $order->user_id = $request->user_id;
        $order->store_id = $request->store_id;
        $order->delivery_id = $request->delivery_id;
        $order->product_id = $request->product_id;
        $order->total = $request->total;
        // $order->address = $request->address;
        $order->payment_method = "Payment";
        $order->status = $request->status;
        $order->save();
        // dd($request->all());
        //PRG
        return redirect()->route('adminOrder.index')->with('success', 'Order created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $order = Order::findorfail($id);
        } catch (Exception $e) {
            return redirect()->route('adminOrder.index')
                ->with('info', 'Record not found');
        }
        $user = User::all();
        //   $store=Store::findOrFail($id);
        $store = Store::all();
        $product = Product::all();
        $delivery = Delivery::all();
        $order = Order::findOrFail($id);

        return view('adminStore.order.edit', compact('user', 'store', 'product', 'delivery', 'order'));
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
        $order = Order::find($id);
        $order->user_id = $request->user_id;
        $order->store_id = $request->store_id;
        $order->delivery_id = $request->delivery_id;
        $order->product_id = $request->product_id;
        $order->total = $request->total;
        // $order->address = $request->address;
        $order->payment_method = "Payment";
        $order->status = $request->status;
        $order->save();

        return redirect()->route('adminOrder.index')->with('success', 'Order updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $order = Order::findOrFail($id);
        $order->delete();
        return redirect()->route('adminOrder.index')->with('success', 'Order deleted!');
    }








    // employee function
    public function empOrderList(Request $request)
    {
        $store = Store::all();
        $category = Category::all();
        $product = Product::all();
        $user = User::all();
        $delivery = Delivery::all();

        $query = Order::query();

        $status = $request->input('status');
        if ($status === 'Pending') {
            $query->where('status', 'pending');
        } elseif ($status === 'Delivered') {
            $query->where('status', 'delivered');
        } elseif ($status === 'Accepted') {
            $query->where('status', 'accepted');
        }

        $orders = $query->with('user')->get(); // Eager load the user relationship
        $search = $request->search;
        $status = $request->status;

        return view('employeeAdmin.order.index', compact('category', 'product', 'store', 'user', 'delivery', 'orders', 'search', 'status'));
    }



    public function empCreateOrder()
    {
        $store = Store::all();
        $user = User::all();
        $product = Product::all();
        $delivery = Delivery::all();
        $order = new Order();
        return view('employeeAdmin.order.create', compact('store', 'user', 'product', 'delivery', 'order'));
    }
    public function empStore(Request $request)
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
        $order = new Order();
        $order->user_id = $request->user_id;
        $order->store_id = $request->store_id;
        $order->delivery_id = $request->delivery_id;
        $order->product_id = $request->product_id;
        $order->total = $request->total;
        $order->payment_method = "Payment";
        // $order->address = $request->address;
        $order->status = $request->status;
        $order->save();
        //PRG
        return redirect()->route('employeeAdmin/order')->with('success', 'Order created!');
    }
    //edit
    public function empEdit($id)
    {
        try {
            $order = Order::findorfail($id);
        } catch (Exception $e) {
            return redirect()->route('employeeAdmin/order')->with('info', 'Record not found');
        }
        $user = User::all();
        //   $store=Store::findOrFail($id);
        $store = Store::all();
        $product = Product::all();
        $delivery = Delivery::all();
        $order = Order::findOrFail($id);

        return view('employeeAdmin.order.edit', compact('user', 'store', 'product', 'delivery', 'order'));
    }
    //update
    public function empUpdate(Request $request, $id)
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
        $order = Order::find($id);
        $order->user_id = $request->user_id;
        $order->store_id = $request->store_id;
        $order->delivery_id = $request->delivery_id;
        $order->product_id = $request->product_id;
        $order->total = $request->total;
        $order->payment_method = "Payment";
        // $order->address = $request->address;
        $order->status = $request->status;
        $order->save();

        return redirect()->route('employeeAdmin/order')->with('success', 'Order updated!');
    }
    //delete
    public function empDelete($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();
        return redirect()->route('employeeAdmin/order')->with('success', 'Order deleted!');
    }
}
