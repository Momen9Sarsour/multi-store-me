<?php

namespace App\Http\Controllers\DeliveryDashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    //
   
    public function __construct(){
        $this->middleware(['auth']);
    }
    public function index(){
        return view('DeliveryDashboard.dashboard');
    }
}
