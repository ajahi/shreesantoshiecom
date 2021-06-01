<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\ProductCategory;
use App\Tag;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Validator;
use Session;
use App\Cart;
use App\Order;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('cms.product.productindex',[
            'product'=>Product::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cms.product.productcreate',['productcategory'=>ProductCategory::all(),'tag'=>Tag::all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $user = Auth::user();

        if ($user->hasRole(['super_admin','admin'])){
            if($request->categories_id){
                if(!is_array($request->categories_id)){
                    $request['categories_id'] = explode(",", $request->categories_id);
                }
            }
            
            if($request->tags_id){
                if(!is_array($request->tags_id)){
                    $request['tags'] = explode(",",$request->tags_id);
                }
            }
            $validation = Validator::make($request->all(), [
                'title' => 'required|unique:products',
                'description'=>'required',
                'purchase_price' => 'required',
                'categories_id' => 'required|array|present',
                'categories_id.*' => 'required|exists:product_categories,id',
                'user_id' => 'exists:users,id',
                'quantity' => 'required|numeric',
                'tags.*' => 'exists:tags,id',
                'image' => 'required',
                'status'=>'boolean'
            ]);

            if($request->user_id){
                $ItemOwner = User::find($request->user_id);
                if(!$ItemOwner->hasRole(['admin','merchant'])){
                    return $validation->errors()->add('item_id','Product Owner can only be either merchant or admin');
                }
            }

            if ($validation->fails()) {
                return response()->json($validation->errors() , 422);
            }
            // if($user->hasRole('city_manager') && !(count($request->cities_id) == 1 && in_array($user->city_id,$request->cities_id))){
            //     return response()->json(['error'=>'Invalid city entry'], 422);
            // }
            $input_product = collect($request->all());
            if($request->user_id){
                $input_product['user_id'] = $request->user_id;
            }else {
                $input_product['user_id'] = $user->id;
            }
            /*for slug generating from backend*/
            $input_product['slug'] = strtolower(slug($request->title));
            $input_product['position']=Product::count()+1;
       
            $product = Product::create($input_product->toArray());
            if(empty($request->categories_id)) {
                $product->categories()->detach();
            }else {
                if(is_array($request->categories_id)){
                    $product->categories()->sync($request->categories_id);
                }else {
                    $product->categories()->sync(explode(",", $request->categories_id));
                }
            }
            if(empty($request->tags_id)){
                $product->tags()->detach();
            }else {
                if(is_array($request->tags_id)){
                    $product->tags()->sync($request->tags_id);
                }else {
                    $product->tags()->sync(explode(",", $request->tags_id));
                }
            }
            if ($request['image']) {
                /*$product->addMediaFromRequest('image')->toMediaCollection('image');*/
                $product->addMediaFromRequest('image')->toMediaCollection('images');
                // dd('image is availeble');
            }
            
            return redirect('/product');

        } else {
            $return = ["status" => "success",
                "error" => [
                    "code" => 403,
                    "errors" => 'Forbidden'
                ]];
            return response()->json($return, 403);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {$product=Product::find($id);
        return view('cms.product.productshow',[
            'product'=>$product,
            'image'=>$product->getMedia()
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
        return view('cms.product.productedit',['product'=>Product::findOrFail($id),'productcategory'=>ProductCategory::all(),'tag'=>Tag::all()]);
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
        $user = Auth::user();
        $product = Product::findOrFail($id);
      
      
        if ($user->hasRole(['admin','super_admin']) 
        ) {
            $validation = Validator::make($request->all(), [
                'title' => 'unique:products,title,'.$id,
                'description'=>'required',
                'purchase_price' => 'required',
                'categories_id' => 'required|array|present',
                'categories_id.*' => 'exists:product_categories,id',
                'user_id' => 'exists:users,id',
                'tags.*' => 'exists:tags,id',
                'quantity' => 'numeric',             
                'status'=>'required'             
            ]);          
            if ($validation->fails()) {
                return response()->json($validation->errors() , 422);
            }           
            $request['slug'] = slug($request->title);
            $product->fill($request->all())->save();
            $product->categories()->detach();
            $product->tags()->detach();
            $product->categories()->sync($request->categories_id);
            $product->tags()->sync($request->tags_id);
            
            if ($request['image'] != null) {
                $product->addMediaFromRequest('image')->toMediaCollection('image');
            }       
            $product['quantity'] = $request->quantity;
            $product->save();
            return redirect('/product');
        } else {
            $return = ["status" => "error",
                "error" => [
                    "code" => 403,
                    "errors" => 'Forbidden'
                ]];
            return response()->json($return, 403);
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = Auth::user();
        $product = Product::findOrFail($id);

        if (($user->hasRole(['vendor','admin','super_admin']) ||
            ($user->hasRole('merchant') && $user->active =='active'))
            && $product->user_id == $user->id) {
            $pro=Product::find($id);
            $pro->clearMediaCollection();
            $pro->delete();
            $return = ["status" => "Success",
                "error" => [
                    "code" => 200,
                    "errors" => 'Deleted'
                ]];
            return redirect('/product');

        } else {
            $return = ["status" => "error",
                "error" => [
                    "code" => 403,
                    "errors" => 'Forbidden'
                ]];
            return response()->json($return, 403);
        }
    }

    public function buy(Request $request){
        return view('purchase',['products'=>Product::all()]);
    }

    public function getAddToCart(Request $request, $id) {
        $product = Product::find($id);
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->add($product, $product->id);

        $request->session()->put('cart', $cart);
        return redirect()->back();
    }

    public function getCheckout(){
        if(!Session::has('cart')){
            return redirect('/');
        }
        $oldCart=Session::get('cart');
        $cart=new Cart($oldCart);
        $totalprice=0;
        
        return view('shop.checkout',[
            'cart'=>$cart,'totalprice'=>$totalprice
        ]);
    }
    public function order(Request $request){
        
        $validation = Validator::make($request->all(), [
            'firstname'=>'required',
            'lastname'=>'required',
            'phone'=>'required',
            'email'=>'required|email'
        ]);
        if ($validation->fails()) {
            return response()->json($validation->errors() , 422);
        }
        $cart=Session::get('cart')->items;
        $order=new Order();
        $order->firstname=$request->firstname;
        $order->lastname=$request->lastname;
        $order->phone=$request->phone;
        $order->email=$request->email;
        $order->cart=serialize($cart);
        $order->message=$request->message;
        $order->save();
        return redirect('/newcart');
    }
   public function getReduceByOne($id){
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->reduceByOne($id);

        if (count($cart->items) > 0) {
            Session::put('cart', $cart);
        } else {
            Session::forget('cart');
        }
        return redirect()->back();
   }
   public function remove($id) {
    $oldCart = Session::has('cart') ? Session::get('cart') : null;
    $cart = new Cart($oldCart);
    $cart->removeItem($id);

    if (count($cart->items) > 0) {
        Session::put('cart', $cart);
    } else {
        Session::forget('cart');
    }

    return redirect()->back();
    }
    public function deleteMedia($id){

    }
}
