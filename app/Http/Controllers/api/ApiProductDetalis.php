<?php

namespace App\Http\Controllers\api;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ApiProductDetalis extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use ApiResponseTrait;

    public function productDetails($product){
        $product = Product::with('category')->where('slug', $product)->firstOrFail();
        if ($product->status !== 'active' || $product->storgeQuantity <= 0) {
            // dd($product->storageQuantity);
            return $this->apiResponse([
                ''
            ],'Product not found', 404);
        }
        $relatedProducts = Product::where('category_id', $product->category_id)
        ->where('id', '!=', $product->id) // Exclude the current product
        ->where('status', 'active')
        ->where('storgeQuantity', '>', 0)
        ->limit(5)
        ->get();

        $groups = [
            [
                'name' => 'product Details',
                'type' => 'product',
                'items' => $product
            ],
            [
                'name' => 'Related Products',
                'type' => 'product',
                'items' => $relatedProducts
            ],
        ];
        return $this->apiResponse([
            $groups
        ], 'ok', 200);

    }

    public function addToCart(Request $request)
    {
        $request->validate([
            'product_slug' => ['required', 'string'],
            // 'user_id' => [ 'required'],
            'quantity' => ['nullable', 'integer', 'min:1'],
        ]);

        $productSlug = $request->input('product_slug');
        $quantity = $request->input('quantity', 1);
        // $userId = $request->input('user_id');
        $token = $request->bearerToken();
        $user = Auth::userFromToken($token);
        $product = Product::where('slug', $productSlug)->first();

        if (!$product) {
            return $this->apiResponse([
                ''
            ], 'Product not found or unavailable', 404);
        }
        // if (!Cart::isEmpty()) {
        //     $firstCartItem = Cart::get()->first();
        //     $storeId = $firstCartItem->product->store_id;

        //     if ($product->store_id !== $storeId) {
        //         return $this->apiResponse([
        //             ''
        //         ], 'Do you want to empty your cart? You cannot add products from different stores.', 400);

        //     }
        // }

        // $userId = Auth::user();
        // $user = Auth::user();
        $userId = $user->id;
        // $userId = Auth::id();
        $cart = new Cart();
        $cart->user_id =$userId;
        $cart->product_id = $product->id;
        $cart->quantity = $quantity;
        $cart->save();

        // Cart::add($product, $quantity);

        return $this->apiResponse([
            $userId
        ], 'Product added to cart', 200);
    }
}

