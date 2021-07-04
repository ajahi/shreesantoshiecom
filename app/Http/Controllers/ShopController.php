<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProductCategory;
use App\Product;
use Session;
use App\Cart;
use App\Post;
use App\Slider;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        $children=ProductCategory::query()->whereHas('children',function($q){
            $q->where('parent_id','');
        })->get();
        
        $procat=ProductCategory::where('parent_id',NULL)->get();
        //cart
        $oldCart=Session::get('cart');
        $cart= new Cart($oldCart);
        return view('shop.shophome',[
            'sidemenu'=>$procat,
            'posts'=>Post::orderBy('id', 'DESC')->get(),
            'prod'=>ProductCategory::all(),
           'children'=>$children,
           'latest'=>Product::orderBy('id','DESC')->get(),
           'bestsale'=>Product::orderBy('counts','DESC')->get(),
           'onsale'=>Product::where('discount','!=',null)->get(),
           'slider'=>Slider::all(),
           'featured'=>Product::where('featured',true)->get(),
           'procat'=>$procat,
           'blogs'=>Post::where(function($q){
               $q->where('Status','published');
               $q->where('category_id',2);
           })->limit(4)->get(),
           
                //cart
           'items'=>$cart->items,
           'totalPrice'=>$cart->totalPrice
            ]);
    }
   
    public function details($slug){
        //cart
        $oldCart=Session::get('cart');
        $cart= new Cart($oldCart);
        return view ('shop.product-detail',
        [
            'product'=>Product::where('slug',$slug)->firstOrFail(),
                //cart
           'items'=>$cart->items,
           'totalPrice'=>$cart->totalPrice
        ]);
    }

    public function getCart(){
        $oldCart=Session::get('cart');
        $cart= new Cart($oldCart);
        return response()->json($cart);
    }

    public function shop(Request $request){
        //cart
        $oldCart=Session::get('cart');
        $cart= new Cart($oldCart);
        //product        
        $procat=ProductCategory::where('parent_id','!=',null)->get();
        $pro=Product::where('quantity','>',1)->paginate(20);
        return view('shop.shopshop',[
            //cart
            'items'=>$cart->items,
           'totalPrice'=>$cart->totalPrice,
           //products
           'pro'=>$pro,
           'procat'=>$procat,
           'procat2'=>$procat
           
        ]);
    }
    public function shopcat($slug){
        $procat=ProductCategory::where('slug',$slug)->firstOrFail();
         //cart
         $oldCart=Session::get('cart');
         $cart= new Cart($oldCart);
        return view('shop.shopcategory',[
            'pro'=>$procat->products,
            'procat'=>$procat,
            'count'=>count($procat->products),
            //cart
            'items'=>$cart->items,
           'totalPrice'=>$cart->totalPrice
        ]);
    }
    public function contact(){
         //cart
         $oldCart=Session::get('cart');
         $cart= new Cart($oldCart);
        return view('shop.contact',[
            //cart
            'items'=>$cart->items,
           'totalPrice'=>$cart->totalPrice
        ]);
    }
    public function aboutus(){
         //cart
         $oldCart=Session::get('cart');
         $cart= new Cart($oldCart);
        return view('shop.aboutus',[
            //cart
            'items'=>$cart->items,
           'totalPrice'=>$cart->totalPrice
        ]);
    }
    public function blogs(){
         //cart
         $oldCart=Session::get('cart');
         $cart= new Cart($oldCart);
         

         return view('shop.blogs',[
             'blogs'=>Post::where(function($q){
                 $q->where('category_id',2);
                 $q->where('status','published');
             })->paginate(20),
             'popular'=>Post::orderBy('counts','DESC')->where(function($q){
                 $q->where('status','published');
             })->limit(5)->get(),
             

             //cart
                 'items'=>$cart->items,
                'totalPrice'=>$cart->totalPrice
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
