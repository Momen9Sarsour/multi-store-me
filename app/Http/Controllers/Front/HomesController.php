<?php

namespace App\Http\Controllers\Front;

use App\Models\User;
use App\Models\Store;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;

class HomesController extends Controller
{
    //

        //$categories = Category::all();
        //return view('front.homes', compact('categories'));
        public function index() {
            $products = Product::with('category')->active()
            //->latest()
            ->limit(6)
            ->get();
            $productBest = Product::with('category')->active()
            ->quantity()
            ->featured()
            ->limit(8)
            ->get();
            $productFeatured = Product::with('category')->active()
            ->quantity()
            ->featured()
            ->get();
            $highPricedProducts = Product::with('category')
            ->orderByDesc('price')->limit(1)->active()->quantity()->get();
            $storeRated =  Store::leftJoin('orders', 'stores.id', '=', 'orders.store_id')
            ->select(
                'stores.id',
                'stores.name',
                'stores.image',
                'stores.slug',
                DB::raw('COUNT(orders.id) as order_count')
            )
            ->groupBy('stores.id', 'stores.name', 'stores.image','stores.slug')
            ->orderByDesc('order_count')
            ->get();

           // return    $productRated ;
           return view('front.homes', compact('products','productBest','productFeatured','storeRated','highPricedProducts'));
    }
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

    // Add store New

    public function create()
    {
        return view('front.createStore');
    }
    public function store(Request $request){
        // dd($request->all());
        $request->validate([
            'name' =>'required',
            'slug'=>'nullable',
            'image'=>'nullable',
            'description'=>'nullable',
            'email' =>'required',
            'password' =>'required',
            'phone' =>'required',
        ]);

        $data = $request->all();
        $data = $request->except('image');
        if($request->image){
            $data['image']= $this->uploadImage($request);
        }else{
            $data['image']= "";
        };

        // store data
        $store = new Store();
        $store->name = $request->name;
        $store->slug = Str::slug($request->input('name'));
        $store->image = $data['image'];
        $store->description = $request->description;
        $store->email = $request->email;
        $store->password = $request->password;
        $store->phone = $request->phone;
        $store->status = $request->status;
        $store->save();

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->store_id = $store->id;
        $user->type = "vendor";
        $user->save();

        session()->flash('message', 'Store added!');
        return redirect()->route('vendor');
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
