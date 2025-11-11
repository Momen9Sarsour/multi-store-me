<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\EmployeeAdmin;
use App\Models\EemployeeAdmin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class EmployeeAdminController extends Controller
{
    public function index(Request $request)
    {
        // $employee = EmployeeAdmin::all();
        $query = EmployeeAdmin::query();

        // Apply name filter
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->input('search') . '%');
        }
        $employees = $query->get();
        $search = $request->search;
        return view('adminStore.employee.index', compact('employees', 'search'));

        // return view('adminStore.employee.index',compact('employee'));
    }
    //create
    public function create()
    {
        return view('adminStore.employee.create');
    }
    //store
    public function store(Request $request)
    {
        //validate data
        $request->validate([
            'name' => 'required',
            'image' => 'nullable',
            'phone' => 'required',
            'address' => 'required',
            'employeeEmail' => 'required|email',
            'ipan' => 'required',
        ]);
        // image add path
        // if($request->has('image')){
        //     $image=rand() .time().$request->file('image')->getClientOriginalName();
        //     $request->file('image')->move(public_path('images/uploads'),$image);
        // }else{
        //     $image="";
        // };
        $data = $request->except('image');
        if($request->image){
            $data['image']= $this->uploadImage($request);
        }else{
            $data['image']= "";
        };
        //store data
        $employee = new EmployeeAdmin();
        $employee->name = $request->name;
        $employee->phone = $request->phone;
        $employee->address = $request->address;
        $employee->email = $request->employeeEmail;
        $employee->image = $data['image'];
        $employee->ipan = $request->ipan;
        $employee->save();

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->employeeEmail;
        $user->password = Hash::make($request->password);
        $user->store_id = null;
        $user->type = "employeeAdmin";
        $user->save();

        //session message
        // session()->flash('message', 'Employee added!');
        //redirect
        return redirect()->route('adminEmployee.index')->with('success','Employee created!');
    }
    //edit
    public function edit($id)
    {
        //find object
        $employee = EmployeeAdmin::findOrFail($id);
        //return view and pass object
        return view('adminStore.employee.edit', compact('employee'));
    }
    //update
    public function update(Request $request, $id)
    {
        //validate data
        $request->validate([
            'name' => 'required',
            'image' => 'nullable',
            'phone' => 'required',
            'address' => 'required',
            'employeeEmail' => 'required|email',
            'ipan' => 'required',
        ]);
        $employee=EmployeeAdmin::findOrFail($id);
        // image add path
        // if($request->has('image')){
        //     $image=rand() .time().$request->file('image')->getClientOriginalName();
        //     $request->file('image')->move(public_path('images/uploads'),$image);
        // }else{
        //     $image=$employee->image;
        // };
        $data = $request->except('image');
        if($request->image){
            $data['image']= $this->uploadImage($request);
        }else{
            $data['image']= $employee->image;
        };
        //update data
        $employee->name = $request->name;
        $employee->image = $data['image'];
        $employee->phone = $request->phone;
        $employee->address = $request->address;
        $employee->email = $request->employeeEmail;
        $employee->ipan = $request->ipan;
        $employee->save();

        //session message
        session()->flash('message', 'Employee updated!');
        //redirect
        return redirect()->route('adminEmployee.index')->with('success','Employee Updated!');
    }
    //delete
    public function destroy($id)
    {
        // delete employee
        EmployeeAdmin::destroy($id);
        //delete image
        if ($image = EmployeeAdmin::find($id)) {
            unlink(public_path(). $image);
        }
        //session message
        // session()->flash('message', 'Employee deleted! & image deleted!');
        //redirect
        return redirect()->route('adminEmployee.index')->with('success','Employee deleted!');
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
