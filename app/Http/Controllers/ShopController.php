<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProductCategory;
use App\Product;
use Session;
use App\Cart;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   $procat=ProductCategory::where('parent_id',NULL)->get();
        $children=ProductCategory::query()->whereHas('children',function($q){
            $q->where('parent_id','');
        })->get();
        $products=Product::all();
        //cart
        $oldCart=Session::get('cart');
        $cart= new Cart($oldCart);
        
        return view('shop.shophome',[
            'sidemenu'=>$procat,
            'prod'=>ProductCategory::all(),
           'children'=>$children,
           'products'=>$products,
                //cart
           'items'=>$cart->items,
           'totalPrice'=>$cart->totalPrice
            ]);
    }
   
    public function details($id){
        return view ('shop.product-detail',
        [
            'product'=>Product::findOrFail($id)
        ]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        //
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
    }
}
