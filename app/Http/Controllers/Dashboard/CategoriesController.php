<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\CategoryRequest;
use Illuminate\Support\Facades\Auth;
use Exception;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $request = request();
        $user = Auth::user();
        $isAdmin = empty($user->store_id);
        $categories = Category::when(!$isAdmin, function ($query) use ($user) {
                return $query->where('store_id', $user->store_id);
            })
        ->with('parent')
        ->select('categories.*')
        ->selectRaw('(SELECT count(*) FROM products WHERE status = "active" AND category_id=categories.id) as products_count')
        //->withCount('products as products_number')
        ->filter($request->query())->paginate(3);
         return view('dashboard.VendorAdmin.categories.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        //
        $user = User::find(Auth::id());
        $parents = Category::where('store_id', $user->store_id)->get();
        $category = new Category();
        return view('dashboard.VendorAdmin.categories.create', compact('parents', 'category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate(Category::rules(),[
          'required'=>'This field(:attribute) is required',
          //'name.unique'=>'This name is already exists!'
        ]);
        $request->merge([
            'slug'=> Str::slug($request->post('name'))
        ]);

        $data = $request->all();
        $data = $request->except('image');
        if($request->image){
            $data['image']= $this->uploadImage($request);
        }else{
            $data['image']= "";
        }

        $user = User::find(Auth::id());
        $category = new Category();
        $category->name = $request->name;
        $baseSlug = Str::slug($request->input('name'));
        $uniqueSlug = $this->makeUniqueSlug($baseSlug); // Corrected this line
        $category->slug = $uniqueSlug; // Set the unique slug
        $category->parent_id = $request->parent_id;
        $category->description = $request->description;
        $category->image = $data['image'];
        $category->user_id = $user->id;
        $category->store_id = $user->store_id;
        $category->status = $request->status;
        $category->save();

        // $user = Auth::user();
        // $data['store_id']=$user->store_id;
        // $category = $user->categories()->create($data);
        // dd($category);
        //PRG
        return redirect()->route('categories.index')
       ->with('success','Category created!');

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
    public function show(Category $category)
    {
        //
        return view('dashboard.VendorAdmin.categories.show',[
          'category'=>$category
        ]);
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
            $category = Category::findOrFail($id);
        } catch (Exception $e) {
            return redirect()->route('categories.index')
                ->with('info', 'Record not found');
        }

        $user = Auth::user();
        $isAdmin = empty($user->store_id);

        $parents = Category::where('id', '<>', $id)
            ->where(function ($query) use ($id, $user, $isAdmin) {
                $query->whereNull('parent_id')
                    ->orWhere(function ($subQuery) use ($id, $user, $isAdmin) {
                        $subQuery->where('parent_id', '<>', $id);
                        if (!$isAdmin) {
                            $subQuery->where('user_id', $user->id);
                        }
                    });

                if ($isAdmin) {
                    $query->orWhereNull('parent_id');
                }
            });

        if (!$isAdmin) {
            $parents->where('user_id', $user->id);
        }

        $parents = $parents->get();

        return view('dashboard.VendorAdmin.categories.edit', compact('category', 'parents'));
    }





    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, $id)
    {
        //
        $category = Category::findOrFail($id);
        $request->validate(Category::rules($id));
        $old_image =$category->image;
        $data = $request->except('image');
        $category->slug = Str::slug($request->input('name'));
        $new_image= $this->uploadImage($request);
         if($new_image){
            $data['image']=$new_image;
          }
          // Check for unique slug
    if ($category->slug !== $category->getOriginal('slug')) {
        $category->slug = $this->makeUniqueSlug($category->slug);
    }
          $category->update($data);
          if($old_image && $new_image){
            Storage::disk('public')->delete($old_image);
        }
        return redirect()->route('categories.index')
          ->with('success','Category updated!');
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
        $category=Category::findOrFail($id);
        $category->delete();
        /*if($category->image){
            Storage::disk('public')->delete($category->image);
          } */
        return redirect()->route('categories.index')
        ->with('success','Category deleted!');
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
    public function trash(){
      $categories= Category::onlyTrashed()->paginate();
      return view('dashboard.VendorAdmin.categories.trash',compact('categories'));
     }

     public function restore(Request $request,$id){
        $category = Category::onlyTrashed()->findOrfail($id);
        $category->restore();
        return redirect()->route('categories.trash')
        ->with('success','category restored!');
      }

      public function forceDelete($id){
       $category = Category::onlyTrashed()->findOrfail($id);
       $category->forceDelete();
       if($category->image){
         Storage::disk('public')->delete($category->image);
       }
       return redirect()->route('categories.trash')
       ->with('success','category deleted forever!');
     }
    }

