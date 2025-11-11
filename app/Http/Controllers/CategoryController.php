<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Category;
use App\Models\Store;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //

        $category= Category::all();
        $store= Store::all();

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
        return view('adminStore.category.index', compact('categories', 'search', 'status'));


        //  return view('adminStore.category.index',compact('category'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $store = Store::all();
        $category = new Category();
        return view('adminStore.category.create', compact('category','store'));
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
            'image' => 'nullable',
            'store_id' => 'nullable',
            'description' => 'nullable',
            'status' => 'nullable',
        ]);
        // image add path
        // if ($request->has('image')) {
        //     $image = rand() . time() . $request->file('image')->getClientOriginalName();
        //     $request->file('image')->move(public_path('images/uploads'), $image);
        // } else {
        //     $image = "";
        // };
        $data = $request->except('image');
        if($request->image){
            $data['image']= $this->uploadImage($request);
        }else{
            $data['image']= "";
        }

        // store data
        $category = new Category();
        $category->name = $request->name;

        // $category->slug = Str::slug($request->input('name'));
        $baseSlug = Str::slug($request->input('name'));
        $uniqueSlug = $this->makeUniqueSlug($baseSlug); // Corrected this line
        $category->slug = $uniqueSlug; // Set the unique slug

        $category->description = $request->description;
        $category->image = $data['image'];
        $category->store_id = $request->store_id;
        $category->status = $request->status;
        $category->save();

        // $request->merge([
        //     'slug'=> Str::slug($request->post('name'))
        // ]);
        // $data = $request->except('image');
        // $data['image']= $this->uploadImage($request);

        // //mass assigment
        // $category = Category::create($data);
        //PRG
        return redirect()->route('adminCategory.index')->with('success','Category created!');
        // return  redirect()->back()->with('success','Category created successfully');

    }

    private function makeUniqueSlug($baseSlug)
    {
        $slug = $baseSlug;
        $counter = 1;

        while (Category::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){
        try{
            $category = Category::findorfail($id);
            }catch(Exception $e){
                return redirect()->route('adminCategory.index')
                ->with('info','Record not found');
            }
            $category=Category::findOrFail($id);
            $products = $category->products()->with('store')->paginate(44);
            return view('adminStore.category.show', compact('category','products'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        try {
            $category = Category::findorfail($id);
            }catch(Exception $e){
                return redirect()->route('adminCategory.index')
                ->with('info','Record not found');
              }
              $category=Category::findOrFail($id);
              $store=Store::all();
              $parents = Store::all();
            //   $parents= Category::where('id','<>',$id)
            //     ->where(function($query) use($id){
            //   $query->whereNull('store_id')
            //  ->orwhere('store_id','<>',$id);
            // dd($category);
        //   })
        // ->get();
        return view('adminStore.category.edit', compact('category','store'));
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
            'image' => 'nullable',
            'store_id' => 'nullable',
            'description' => 'nullable',
            'status' => 'nullable',
        ]);
        $category = Category::findOrFail($id);
        // image add path
        // if ($request->has('image')) {
        //     $image = rand() . time() . $request->file('image')->getClientOriginalName();
        //     $request->file('image')->move(public_path('images/uploads'), $image);
        // } else {
        //     $image = $category->image;
        // };
        $data = $request->except('image');
        if($request->image){
            $data['image']= $this->uploadImage($request);
        }else{
            $data['image']= $category->image;
        }
        //store data
        $category->name = $request->name;

        // $category->slug = Str::slug($request->input('name'));
        $baseSlug = Str::slug($request->input('name'));
        $uniqueSlug = $this->makeUniqueSlug($baseSlug); // Corrected this line
        $category->slug = $uniqueSlug; // Set the unique slug
        
        $category->description = $request->description;
        $category->image = $data['image'];
        $category->store_id = $request->store_id;
        $category->status = $request->status;
        // dd($request->all());
        $category->save();

        // $category=Category::findOrFail($id);
        // $old_image =$category->image;
        // $data = $request->except('image');
        //  $new_image= $this->uploadImage($request);
        //  if($new_image){
        //     $data['image']=$new_image;
        //   }
        //   $category->update($data);
        //   if($old_image && $new_image){
        //     Storage::disk('public')->delete($old_image);
        // }

        return redirect()->route('adminCategory.index')->with('success','Category updated!');
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
        $category = Category::findOrFail($id);
        $category->delete();
        if ($category->image) {
            // Storage::disk('public')->delete($category->image);
          }
        return redirect()->route('adminCategory.index')->with('success','Category deleted!');
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
}
