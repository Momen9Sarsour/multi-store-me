<?php

namespace App\Http\Controllers\DeliveryDashboard;

use App\Http\Controllers\Controller;
use App\Models\Delivery;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class DeliveryMenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $request = request();
        $query = Delivery::query();
        $name = $request->query('name');
        if ($name) {
            $query->where('name', 'LIKE', "%{$name}%");
        }

        $DeliveryMan = $query->paginate(2);

        return view('DeliveryDashboard.DeliveryMen.index', compact('DeliveryMan'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $delivery = new Delivery();
        return view('DeliveryDashboard.DeliveryMen.create', compact('delivery'));
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
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'phone' => 'required|string|max:255',
            'ipan' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif',
        ]);
        $data = $request->except('image');
        if ($request->image) {
            $data['image'] = $this->uploadImage($request);
        } else {
            $data['image'] = "";
        }
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'image' => $data['image'],
            'store_id' => null,
            'type' => "deliveryMen",
        ]);

        $delivery = Delivery::create([
            'user_id' => $user->id,
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'image' => $data['image'],
            'ipan' => $request->ipan,
            'address' => $request->address,
        ]);
        return redirect()->route('deliveries.index')->with('success', 'Delivery Man Created!');
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
        //
        try {
            $delivery = Delivery::findorfail($id);
        } catch (Exception $e) {
            return redirect()->route('deliveries.index')
                ->with('info', 'Record not found');
        }
        return view('DeliveryDashboard.DeliveryMen.edit', compact('delivery'));
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
        $request->validate(Delivery::rules($id));

        $delivery = Delivery::findOrFail($id);
        $user = User::findOrFail($delivery->user_id);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            $new_image = $this->uploadImage($request);
            if ($new_image) {
                if ($delivery->image) {
                    Storage::disk('public')->delete($delivery->image);
                }
                $data['image'] = $new_image;
            }
        }

        $user->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($request->password),
            'store_id' => null,
            'type' => "deliveryMen",
        ]);

        unset($data['password']);
        $delivery->update($data);

        return redirect()->route('deliveries.index')->with('success', 'Delivery Man updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
      $delivery = Delivery::findOrFail($id);
      $delivery->delete();
      if ($delivery->user) {     
        $delivery->user->delete();
    }

    return redirect()->route('deliveries.index')->with('success', 'Delivery deleted!');
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
