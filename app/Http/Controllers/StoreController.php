<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\Store;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StoreController extends Controller
{
    public function index(Request $request)
    {
        $store = Store::all();

        $query = Store::query();

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

        $stores = $query->get();
        $search = $request->search;
        $status = $request->status;

        return view('adminStore.stores.index', compact('stores','search','status'));
    }

    public function create()
    {
        return view('adminStore.stores.create');
    }
    public function store(Request $request){
        //validate data
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
        // image add path
        // if($request->has('image')){
        //     $image=rand() .time().$request->file('image')->getClientOriginalName();
        //     $request->file('image')->move(public_path('images/uploads'),$image);
        // }else{
        //     $image="";
        // };

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

        //session message
        session()->flash('message', 'Store added!');
        // return redirect
        // return redirect(view('adminStore.stores.storesList'));
        return redirect()->route('adminStores.index');
    }
    public function show($id){
        try{
            $store = Store::findorfail($id);
            }catch(Exception $e){
                return redirect()->route('adminStores.index')
                ->with('info','Record not found');
        }
            $store=Store::findOrFail($id);
            //   $categories = $store->category()->with('Category')->paginate(44);
            // $categories = Store::with('category')->paginate(44);
            // $categories = Category::whereHas('store')->with('store')->paginate(44);
            $categories = $store->categories()->paginate(44);

            //   dd( $store->category()->with('category'));
            return view('adminStore.stores.show', compact('store','categories'));
    }
    //edit
    public function edit($id){
        $store=Store::findOrFail($id);
        return view('adminStore.stores.edit',compact('store'));
    }
    //update
    public function update(Request $request, $id){
        //validate data
        // dd($request->all());
        $request->validate([
            'name' =>'required',
            'slug'=>'nullable',
            'image'=>'nullable',
            'description'=>'nullable',
            // 'email' =>'required',
            // 'password' =>'required',
            'phone' =>'required',
        ]);
        $store=Store::findOrFail($id);
        // image add path
        // if($request->has('image')){
        //     $image=rand() .time().$request->file('image')->getClientOriginalName();
        //     $request->file('image')->move(public_path('images/uploads'),$image);
        // }else{
        //     $image=$store->image;
        // };
        $data = $request->except('image');
        if($request->image){
            $data['image']= $this->uploadImage($request);
        }else{
            $data['image']= $store->image;
        }
        //store data
        $store->name = $request->name;
        $store->slug = Str::slug($request->input('name'));
        $store->image = $data['image'];
        $store->description = $request->description;
        $store->email = $store->email;
        $store->password = $store->password;
        $store->phone = $request->phone;
        $store->status = $request->status;
        $store->save();
        //session message
        session()->flash('message', 'Employee updated!');
        // return back
        return redirect()->route('adminStores.index');
    }
    //delete
    public function destroy($id){
        // delete employee
        Store::destroy($id);
        //delete image
        if ($image = Store::find($id)) {
            unlink(public_path(). $image);
        }
        //session message
        session()->flash('message', 'Store deleted! & image deleted!');
        //redirect
        return redirect()->route('adminStores.index');
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






    // employee function
    public function empStoresList()
    {
        $store = Store::all();
        return view('employeeAdmin.stores.index', compact('store'));
    }
    public function empCreateStore()
    {
        return view('employeeAdmin.stores.create');
    }
    public function empStore(Request $request){
        //validate data
        $request->validate([
            'name' =>'required',
            'slug'=>'nullable',
            'image'=>'nullable',
            'description'=>'nullable',
            'email' =>'required',
            'password' =>'required',
            'phone' =>'required',
        ]);
        // image add path
        // if($request->has('image')){
        //     $image=rand() .time().$request->file('image')->getClientOriginalName();
        //     $request->file('image')->move(public_path('images/uploads'),$image);
        // }else{
        //     $image="";
        // };

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
        $user->type = "empA";
        $user->save();

        //session message
        // session()->flash('message', 'Store added!');
        // return redirect
        return redirect()->route('employeeAdmin/stores')->with('success','Store created!');
    }
    //edit
    public function empEdit($id){
        $store=Store::findOrFail($id);
        return view('employeeAdmin.stores.edit',compact('store'));
    }
    //update
    public function empUpdate(Request $request, $id){
        //validate data
        $request->validate([
            'name' =>'required',
            'slug'=>'nullable',
            'image'=>'nullable',
            'description'=>'nullable',
            // 'email' =>'required',
            // 'password' =>'required',
            'phone' =>'required',
        ]);
        $store=Store::findOrFail($id);
        // image add path
        // if($request->has('image')){
        //     $image=rand() .time().$request->file('image')->getClientOriginalName();
        //     $request->file('image')->move(public_path('images/uploads'),$image);
        // }else{
        //     $image=$store->image;
        // };
        $data = $request->except('image');
        if($request->image){
            $data['image']= $this->uploadImage($request);
        }else{
            $data['image']= "";
        }
        //store data
        $store->name = $request->name;
        $store->slug = Str::slug($request->input('name'));
        $store->image = $data['image'];
        $store->description = $request->description;
        $store->email = $store->email;
        $store->password = $store->password;
        $store->phone = $request->phone;
        $store->status = $request->status;
        $store->save();
        //session message
        // return back
        return redirect()->route('employeeAdmin/stores')->with('success','Store Updated!');
    }
    //delete
    public function empDelete($id){
        // delete employee
        Store::destroy($id);
        //delete image
        if ($image = Store::find($id)) {
            unlink(public_path(). $image);
        }
        //session message
        // session()->flash('message', 'Employee deleted! & image deleted!');
        //redirect
        return redirect()->route('employeeAdmin/stores')->with('success','Store Deleted!');
    }
}
