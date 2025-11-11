<?php

namespace App\Http\Controllers\employeeVendor;
use App\Models\Product;
use App\Models\Store;
use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\employeeVendor\Str;

class ProductesController extends Controller
{
    public function index(Request $request)
    {
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

        return view('employeeVendor.product.index', compact('product', 'search', 'status'));
    }


    public function create()
    {
        $store = Store::all();
        $category = Category::all();
        // $product= Product::all();
        $product = new Product();
        return view('employeeVendor.product.create', compact('store', 'category', 'product'));
    }


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

    $data = $request->except('image');
    if($request->image){
        $data['image']= $this->uploadImage($request);
    }else{
        $data['image']= "";
    }

    // store data
    $product = new product();
    $product->name = $request->name;
    $product->slug = "trty";
    $product->store_id = $request->store_id;
    $product->category_id = $request->category_id;
    $product->description = $request->description;
    $product->image = $data['image'];
    $product->price = $request->price;
    $product->compare_price = $request->compare_price;
    $product->storgeQuantity = $request->storgeQuantity;
    $product->status = $request->status;
    // dd($request->all());
    $product->save();
    //PRG
    return redirect()->route('employeeVendor/product')->with('success', 'Product created!');


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
        return redirect()->route('product.index')
            ->with('info', 'Record not found');
    }
    $product = Product::findOrFail($id);
    $store = Store::all();
    $category = Category::all();

    return view('employeeVendor.product.edit', compact('product', 'category', 'store'));
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
    // dd($request->all());
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

    $data = $request->except('image');
    if($request->image){
        $data['image']= $this->uploadImage($request);
    }else{
        $data['image']= "";
    }
    //store data
    $product->name = $request->name;
    $product->slug = $request->name;
    $product->store_id = $request->store_id;
    $product->category_id = $request->category_id;
    $product->description = $request->description;
    $product->image = $data['image'];
    $product->price = $request->price;
    $product->compare_price = $request->compare_price;
    $product->storgeQuantity = $request->storgeQuantity;
    $product->status = $request->status;
    $product->save();

    return redirect()->route('employeeVendor/product')->with('success', 'Product updated!');
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
    $product=Product::findOrFail($id);
    $product->delete();
    if($product->image){
        // Storage::disk('public')->delete($category->image);
      }
    return redirect()->route('employeeVendor/product')->with('success','Product deleted!');
}
protected function uploadImage(Request $request){

    if(!$request->hasFile('image')){
      return;
    }
    $file =  $request->file('image');
    $path =  $file->store('uploads',[
          'disk'=>'public'
    ]);
    return $path;
}
}

