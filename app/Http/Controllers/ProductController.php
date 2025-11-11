<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Store;
use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $store = Store::all();
        $category = Category::all();
        $product = Product::all();

        $query = Product::query();
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

        $products = $query->get();
        $search = $request->search;
        $status = $request->status;

        return view('adminStore.product.index', compact('products', 'product', 'store', 'search', 'status'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $store = Store::all();
        $category = Category::all();
        // $product= Product::all();
        $product = new Product();
        return view('adminStore.product.create', compact('store', 'category', 'product'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name' => 'required',
            'store_id' => 'nullable',
            'category_id' => 'nullable',
            'description' => 'nullable',
            'image' => 'nullable',
            'price' => 'required',
            'compare_price' => 'nullable',
            'storgeQuantity' => 'nullable',
            'status ' => 'nullable'
        ]);
        // image add path
        // if ($request->has('image')) {
        //     $image = rand() . time() . $request->file('image')->getClientOriginalName();
        //     $request->file('image')->move(public_path('images/uploads'), $image);
        // } else {
        //     $image = "";
        // };
        $data = $request->except('image');
        if ($request->image) {
            $data['image'] = $this->uploadImage($request);
        } else {
            $data['image'] = "";
        }

        // store data
        $product = new product();
        $product->name = $request->name;
        $product->slug = Str::slug($request->input('name'));
        $product->store_id = $request->store_id;
        $product->category_id = $request->category_id;
        $product->description = $request->description;
        $product->image = $data['image'];
        $product->price = $request->price;
        $product->compare_price = $request->compare_price;
        $product->storgeQuantity = $request->storgeQuantity;
        $product->status = $request->status;
        $product->save();
        //PRG
        return redirect()->route('adminProduct.index')->with('success', 'Product created!');
        // return  redirect()->back()->with('success','Category created successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $product = Product::findorfail($id);
        } catch (Exception $e) {
            return redirect()->route('adminProduct.index')
                ->with('info', 'Record not found');
        }
        $product = Product::findOrFail($id);
        $store = Store::all();
        $category = Category::all();

        return view('adminStore.product.edit', compact('product', 'category', 'store'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //validate data
        // dd($request->all());
        $request->validate([
            'name' => 'required',
            'store_id' => 'nullable',
            'category_id' => 'nullable',
            'description' => 'nullable',
            'image' => 'nullable',
            'price' => 'required',
            'compare_price' => 'nullable',
            'storgeQuantity' => 'nullable',
            'status ' => 'nullable'
        ]);
        $product = Product::find($id);
        // image add path
        // if($request->has('image')){
        //     $image=rand() .time().$request->file('image')->getClientOriginalName();
        //     $request->file('image')->move(public_path('images/uploads'),$image);
        // }else{
        //     $image=$product->image;
        // };
        $data = $request->except('image');
        if ($request->image) {
            $data['image'] = $this->uploadImage($request);
        } else {
            $data['image'] = $product->image;
        }
        //store data
        $product->name = $request->name;
        $product->slug = Str::slug($request->input('name'));
        $product->store_id = $request->store_id;
        $product->category_id = $request->category_id;
        $product->description = $request->description;
        $product->image = $data['image'];
        $product->price = $request->price;
        $product->compare_price = $request->compare_price;
        $product->storgeQuantity = $request->storgeQuantity;
        $product->status = $request->status;
        $product->save();

        return redirect()->route('adminProduct.index')->with('success', 'Product updated!');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $product = Product::findOrFail($id);
        $product->delete();
        if ($product->image) {
            // Storage::disk('public')->delete($category->image);
        }
        return redirect()->route('adminProduct.index')->with('success', 'Product deleted!');
    }
    protected function uploadImage(Request $request)
    {

        if (!$request->hasFile('image')) {
            return;
        }
        $file =  $request->file('image');
        $path =  $file->store('uploads', [
            'disk' => 'public'
        ]);
        return $path;
    }






    // employee function
    public function empProductList(Request $request)
    {
        $store = Store::all();
        $category = Category::all();
        $products = Product::with('store')->get(); // Eager load the 'store' relationship

        $query = Product::query();

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->input('search') . '%');
        }

        $status = $request->input('status');
        if ($status === 'active') {
            $query->where('status', 'active');
        } elseif ($status === 'archived') {
            $query->where('status', 'archived');
        }

        $products = $query->get();
        $search = $request->search;
        $status = $request->status;

        return view('employeeAdmin.product.index', compact('products', 'store', 'search', 'status'));
    }


    public function empCreateProduct()
    {
        $store = Store::all();
        $category = Category::all();
        // $product= Product::all();
        $product = new Product();
        return view('employeeAdmin.product.create', compact('store', 'category', 'product'));
    }
    public function empStore(Request $request)
    {
        //validate data
        $request->validate([
            'name' => 'required',
            'store_id' => 'nullable',
            'category_id' => 'nullable',
            'description' => 'nullable',
            'image' => 'nullable',
            'price' => 'required',
            'compare_price' => 'nullable',
            'storgeQuantity' => 'nullable',
            'status ' => 'nullable'
        ]);
        // image add path
        // if ($request->has('image')) {
        //     $image = rand() . time() . $request->file('image')->getClientOriginalName();
        //     $request->file('image')->move(public_path('images/uploads'), $image);
        // } else {
        //     $image = "";
        // };
        $data = $request->except('image');
        if ($request->image) {
            $data['image'] = $this->uploadImage($request);
        } else {
            $data['image'] = "";
        }

        // store data
        $product = new product();
        $product->name = $request->name;
        $product->slug = Str::slug($request->input('name'));
        $product->store_id = $request->store_id;
        $product->category_id = $request->category_id;
        $product->description = $request->description;
        $product->image = $data['image'];
        $product->price = $request->price;
        $product->compare_price = $request->compare_price;
        $product->storgeQuantity = $request->storgeQuantity;
        $product->status = $request->status;
        $product->save();

        //session message
        // session()->flash('message', 'Store added!');
        // return redirect
        return redirect()->route('employeeAdmin/product')->with('success', 'Product created!');
    }
    //edit
    public function empEdit($id)
    {
        try {
            $product = Product::findorfail($id);
        } catch (Exception $e) {
            return redirect()->route('adminProduct.index')
                ->with('info', 'Record not found');
        }
        $product = Product::findOrFail($id);
        $store = Store::all();
        $category = Category::all();
        return view('employeeAdmin.product.edit', compact('product', 'store', 'category'));
    }
    //update
    public function empUpdate(Request $request, $id)
    {
        //validate data
        $request->validate([
            'name' => 'required',
            'store_id' => 'nullable',
            'category_id' => 'nullable',
            'description' => 'nullable',
            'image' => 'nullable',
            'price' => 'required',
            'compare_price' => 'nullable',
            'storgeQuantity' => 'nullable',
            'status ' => 'nullable'
        ]);
        $product = Product::find($id);
        // image add path
        // if($request->has('image')){
        //     $image=rand() .time().$request->file('image')->getClientOriginalName();
        //     $request->file('image')->move(public_path('images/uploads'),$image);
        // }else{
        //     $image=$product->image;
        // };
        $data = $request->except('image');
        if ($request->image) {
            $data['image'] = $this->uploadImage($request);
        } else {
            $data['image'] = "";
        }
        //store data
        $product->name = $request->name;
        $product->slug = Str::slug($request->input('name'));
        $product->store_id = $request->store_id;
        $product->category_id = $request->category_id;
        $product->description = $request->description;
        $product->image = $data['image'];
        $product->price = $request->price;
        $product->compare_price = $request->compare_price;
        $product->storgeQuantity = $request->storgeQuantity;
        $product->status = $request->status;
        $product->save();
        //session message
        // return back
        return redirect()->route('employeeAdmin/product')->with('success', 'Product Updated!');
    }
    //delete
    public function empDelete($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        if ($product->image) {
            // Storage::disk('public')->delete($category->image);
        }
        return redirect()->route('employeeAdmin/product')->with('success', 'Product Deleted!');
    }
}
