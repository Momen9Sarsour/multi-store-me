<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Repositories\Cart\CartModelRepository;
use App\Repositories\Cart\CartRepository;
use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;

class CartController extends Controller
{
    protected $cart;
    public function __construct(CartRepository $cart){
      $this->cart=$cart;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('front.cart',[
            'cart'=>$this->cart,
        ]);
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
          'product_id'=>['required','int','exists:products,id'],
          'quantity'=>['nullable','int','min:1'],  
        ]);
        $product = Product::findOrFail($request->post('product_id'));
        $storeId = $product->store_id;

       if ($this->cart->isEmpty()) {
        $this->cart->add($product, $request->post('quantity'));
        return redirect()->route('home')->with('success', 'Product added to cart!');
       } else {
        $cartStoreId = $this->cart->get()->first()->product->store_id;

         if ($storeId === $cartStoreId) {
          $this->cart->add($product, $request->post('quantity'));
          return redirect()->route('home')->with('success', 'Product added to cart!');
       } else {
        return redirect()->back()->with('error', 'Please empty your cart before adding products from another store.');
        }
  }}

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        //
        $request->validate([
            'quantity'=>['required','int','min:1'],      
          ]);     
          $this->cart->update($id,$request->post('quantity')); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {  
      $this->cart->delete($id); 
      return [
    //    'cartCount' => $this->cart->count(), // Update cart count
       'message'=> 'item deleted!',
      ];
      
    }
    
}
