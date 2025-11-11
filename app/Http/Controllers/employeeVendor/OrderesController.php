<?php

namespace App\Http\Controllers\employeeVendor;
use App\Models\Category;
use App\Models\Delivery;
use App\Models\Order;
use App\Models\Product;
use App\Models\Store;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;

class OrderesController extends Controller
{
    public function index(Request $request)
    {
        $order = Order::all();
        $store = Store::all();
        $category = Category::all();
        $product = Product::all();
        $user = User::all();
        $order = Order::all();
        $delivery = Delivery::all();
        $query = Order::query();


        $status = $request->input('status');
        if ($status === 'Pending') {
            $query->where('status', 'pending');
        } elseif ($status === 'Delivered') {
            $query->where('status', 'delivered');
        }elseif ($status === 'Accepted') {
            $query->where('status', 'accepted');
        }

        $orders = $query->get();
        $search = $request->search;
        $status = $request->status;


        return view('employeeVendor.order.index', compact('category', 'product', 'store', 'user', 'order', 'delivery', 'search', 'status'));





    }


    public function create()
    {
        $store = Store::all();
        $user = User::all();
        $product = Product::all();
        $delivery = Delivery::all();
        $order = new Order();
        return view('employeeVendor.order.create', compact('store', 'user', 'product', 'delivery', 'order'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'nullable',
            'store_id' => 'nullable',
            'delivery_id' => 'nullable',
            'product_id' => 'nullable',
            'total_price' => 'required',
            'address' => 'nullable',
            'status' => 'nullable',
        ]);

        // store data
        $order = new Order();
        $order->user_id = $request->user_id;
        $order->store_id = $request->store_id;
        $order->delivery_id = $request->delivery_id;
        $order->product_id = $request->product_id;
        $order->price_total = $request->total_price;
        $order->address = $request->address;
        $order->status = $request->status;
        $order->save();
        //PRG
        return redirect()->route('employeeVendor/order')->with('success', 'Order created!');
    }

    public function edit(string $id)
    {
        try {
            $order = Order::findorfail($id);
        } catch (Exception $e) {
            return redirect()->route('employeeVendor/order')
                ->with('info', 'Record not found');
        }
        $user = User::all();
        //   $store=Store::findOrFail($id);
        $store = Store::all();
        $product = Product::all();
        $delivery = Delivery::all();
        $order = Order::findOrFail($id);

        return view('employeeVendor/order/edit', compact('user', 'store', 'product', 'delivery', 'order'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'user_id' =>'nullable',
            'store_id' =>'nullable',
            'delivery_id' =>'nullable',
            'product_id' =>'nullable',
            'total_price' =>'required',
            'address' =>'nullable',
            'status' =>'nullable',
        ]);
        //store data
        $order = Order::find($id);
        $order->user_id = $request->user_id;
        $order->store_id = $request->store_id;
        $order->delivery_id = $request->delivery_id;
        $order->product_id = $request->product_id;
        $order->price_total = $request->total_price;
        $order->address = $request->address;
        $order->status = $request->status;
        $order->save();

        return redirect()->route('employeeVendor/order')->with('success','Order updated!');
    }
    public function destroy(string $id)
    {
        $order=Order::findOrFail($id);
        $order->delete();
        return redirect()->route('employeeVendor/order')->with('success','Order deleted!');

    }
}
