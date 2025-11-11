<?php

namespace App\Http\Controllers\DeliveryDashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\delivery_area;
use Exception;
use Illuminate\Support\Facades\Storage;

class DeliveryArea extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $request = request();
        $query = delivery_area::query();
        $name = $request->query('name');
        if ($name) {
            $query->where('name', 'LIKE', "%{$name}%");
        }

        $DeliveryArea = $query->paginate(7);

        return view('DeliveryDashboard.DeliveryArea.index', compact('DeliveryArea'));
       // $DeliveryArea = $query->paginate(2);

       // return view('DeliveryDashboard.DeliveryArea.index', compact('DeliveryArea'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $deliveryarea = new delivery_area();
        return view('DeliveryDashboard.DeliveryArea.create', compact('deliveryarea'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'city' => 'required|string|max:255|unique:delivery_areas',
            'DeliverPrice' => 'required|numeric|min:0',
        ]);

        $deliveryarea = new delivery_area();
        $deliveryarea->city = $request->city;
        $deliveryarea->DeliverPrice = $request->DeliverPrice;
        $deliveryarea->save();

        return redirect()->route('deliveriesArea.index')
            ->with('success', 'Delivery area created successfully!');
     //   ->with('success', 'Delivery area created successfully!');
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
            $deliveryarea  = delivery_area::findorfail($id);
        } catch (Exception $e) {
            return redirect()->route('deliveries.index')
                ->with('info', 'Record not found');
        }
        return view('DeliveryDashboard.DeliveryArea.edit', compact('deliveryarea'));
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

        $request->validate([
            'city' => 'required|string|max:255|unique:delivery_areas,city,' . $id,
            'DeliverPrice' => 'required|numeric|min:0',
        ]);

        $deliveryarea = delivery_area::findOrFail($id);

        $deliveryarea->update([
            'city' => $request->input('city'),
            'DeliverPrice' => $request->input('DeliverPrice'),
        ]);
        return redirect()->route('deliveriesArea.index')->with('success', 'Delivery Area updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deliveryarea = delivery_area::findOrFail($id);
        $deliveryarea->delete();
        return redirect()->route('deliveriesArea.index')->with('success', 'Delivery Area deleted!');
    }
}
