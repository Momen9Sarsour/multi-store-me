<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    // index
    public function index(Request $request)
    {
        $delivery = Delivery::all();
        $query = Delivery::query();

        // Apply name filter
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->input('search') . '%');
        }

        $deliveries = $query->get();
        $search = $request->search;
        return view('adminStore.delivery.index', compact('deliveries', 'search'));

    }
    //create
    public function create()
    {
        return view('adminStore.delivery.create');
    }
    //store
    public function store(Request $request)
    {
        //validate data
        $request->validate([
            'name' => 'required',
            'image' => 'nullable',
            'phone' => 'required',
            'address' => 'nullable',
            'deliveryEmail' => 'required',
            'ipan' => 'nullable',
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
        };

        //store data
        $delivery = new Delivery();
        $delivery->name = $request->name;
        $delivery->image = $data['image'];
        $delivery->phone = $request->phone;
        $delivery->address = $request->address;
        $delivery->email = $request->deliveryEmail;
        $delivery->ipan = $request->ipan;
        $delivery->save();

        //session message
        // session()->flash('message', 'Delivery added!');
        //redirect
        return redirect()->route('adminDelivery.index')->with('success','Delivery created!');
    }
    //edit
    public function edit($id)
    {
        //find object
        $delivery = Delivery::findOrFail($id);
        //return view and pass object
        return view('adminStore.delivery.edit', compact('delivery'));
    }
    //update
    public function update(Request $request, $id)
    {
        //validate data
        $this->validate($request, [
            'name' => 'required',
            'image' => 'nullable',
            'phone' => 'required',
            'address' => 'nullable',
            'deliveryEmail' => 'required|email',
            'ipan' => 'nullable',
        ]);
        $delivery = Delivery::find($id);
        // image add path
        // if ($request->has('image')) {
        //     $image = rand() . time() . $request->file('image')->getClientOriginalName();
        //     $request->file('image')->move(public_path('images/uploads'), $image);
        // } else {
        //     $image = $delivery->image;
        // };
        $data = $request->except('image');
        if($request->image){
            $data['image']= $this->uploadImage($request);
        }else{
            $data['image']= $delivery->image;
        };
        //update data
        $delivery->name = $request->name;
        $delivery->image = $data['image'];
        $delivery->phone = $request->phone;
        $delivery->address = $request->address;
        $delivery->email = $request->deliveryEmail;
        $delivery->ipan = $request->ipan;
        $delivery->save();

        //session message
        // session()->flash('message', 'delivery updated!');
        //redirect
        return redirect()->route('adminDelivery.index')->with('success','Delivery Updated!');
    }
    //delete
    public function destroy($id)
    {
        // delete delivery
        Delivery::destroy($id);
        //delete image
        if ($image = Delivery::find($id)) {
            unlink(public_path(). $image);
        }
        //session message
        // session()->flash('message', 'delivery deleted! & image deleted!');
        //redirect
        return redirect()->route('adminDelivery.index')->with('success','Delivery Deleted!');
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








    // index
    public function empDeliveryList(Request $request)
    {
        $delivery = Delivery::all();
        $query = Delivery::query();

        // Apply name filter
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->input('search') . '%');
        }

        $deliveries = $query->get();
        $search = $request->search;
        return view('employeeAdmin.delivery.index', compact('deliveries', 'search'));
    }
    //create
    public function empCreateDelivery()
    {
        return view('employeeAdmin.delivery.create');
    }
    //store
    public function empStore(Request $request)
    {
        //validate data
        $request->validate([
            'name' => 'required',
            'image' => 'nullable',
            'phone' => 'required',
            'address' => 'nullable',
            'deliveryEmail' => 'required',
            'ipan' => 'nullable',
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
        };

        //store data
        $delivery = new Delivery();
        $delivery->name = $request->name;
        $delivery->image = $data['image'];
        $delivery->phone = $request->phone;
        $delivery->address = $request->address;
        $delivery->email = $request->deliveryEmail;
        $delivery->ipan = $request->ipan;
        $delivery->save();

        //session message
        session()->flash('message', 'Delivery added!');
        //redirect
        return redirect()->route('employeeAdmin/delivery');
    }
    //edit
    public function empEdit($id)
    {
        //find object
        $delivery = Delivery::findOrFail($id);
        //return view and pass object
        return view('employeeAdmin.delivery.edit', compact('delivery'));
    }
    //update
    public function empUpdate(Request $request, $id)
    {
        //validate data
        $this->validate($request, [
            'name' => 'required',
            'image' => 'nullable',
            'phone' => 'required',
            'address' => 'nullable',
            'deliveryEmail' => 'required|email',
            'ipan' => 'nullable',
        ]);
        $delivery = Delivery::find($id);
        // image add path
        // if ($request->has('image')) {
        //     $image = rand() . time() . $request->file('image')->getClientOriginalName();
        //     $request->file('image')->move(public_path('images/uploads'), $image);
        // } else {
        //     $image = $delivery->image;
        // };
        $data = $request->except('image');
        if($request->image){
            $data['image']= $this->uploadImage($request);
        }else{
            $data['image']= "";
        };
        //update data
        $delivery->name = $request->name;
        $delivery->image = $data['image'];
        $delivery->phone = $request->phone;
        $delivery->address = $request->address;
        $delivery->email = $request->deliveryEmail;
        $delivery->ipan = $request->ipan;
        $delivery->save();

        //session message
        session()->flash('message', 'delivery updated!');
        //redirect
        return redirect()->route('employeeAdmin/delivery');
    }
    //delete
    public function empDelete($id)
    {
        // delete delivery
        Delivery::destroy($id);
        //delete image
        if ($image = Delivery::find($id)) {
            unlink(public_path(). $image);
        }
        //session message
        session()->flash('message', 'delivery deleted! & image deleted!');
        //redirect
        return redirect()->route('employeeAdmin/delivery');
    }

}

