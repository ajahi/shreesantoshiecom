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
use Illuminate\View\Middleware\ShareErrorsFromSession;
use App\SellDetail;

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
            'product'=>Product::orderBy('id', 'DESC')->get()
        ]);
    }

    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   $procat=ProductCategory::where('parent_id','!=',null)->get();
        return view('cms.product.productcreate',
        ['productcategory'=>$procat,
        'tag'=>Tag::all(),
        'count'=>count($procat)]);
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
                'sell_price' => 'required',
                'categories_id' => 'required|array|present',
                'categories_id.*' => 'required|exists:product_categories,id',
                'user_id' => 'exists:users,id',
                'quantity' => 'required|numeric',
                'tags.*' => 'exists:tags,id',
                'image' => 'required',
                'status'=>'boolean',
                'featured'=>'boolean',
                'offer'=>'boolean'
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
            if($request->quantity==0){
                $input_product['InStock']=0;
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
            
            return redirect()->next();

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
        return view('cms.product.productedit',
        [
        'product'=>Product::findOrFail($id),
        'productcategory'=>ProductCategory::where('parent_id','!=',null)->get(),
        'tag'=>Tag::all()
        ]);
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
            if($request['quantity']==0){
                $product->InStock=0;
            }     
            $product['quantity'] = $request->quantity;
            $product['offer']=$request->offer;
            $product['featured']=$request->featured;
            $product['sell_price']=$request->sell_price;
            if ($request->has('image')) {
                
                $product->clearMediaCollection('images');  
                $product->addMediaFromRequest('image')->toMediaCollection('images');
            }  
            if($request->has('addition-image')){
                $product->addMediaFromRequest('addition-image')->toMediaCollection('images');
            }
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
        $product->increment('counts');
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
        $order->status='ordered';
        $order->message=$request->message;
        $order->save();
        foreach($cart as $cart){
            $selldetail['product_id']=$cart['item']['id'];
            $selldetail['order_id']=$order->id;
            $selldetail['price']=$cart['price'];
            $selldetail['quantity']=$cart['qty'];
            $product=Product::find($cart['item']['id']);
            $product->quantity=$product->quantity-$cart['qty'];
            $product->save();
            SellDetail::create($selldetail);
        }
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
    
    // public function buyNow(Request $request,$id){
    //     $this->getAddToCart()
    // }
}
