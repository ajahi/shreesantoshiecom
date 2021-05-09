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

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('productindex',['product'=>Product::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('productcreate',['productcategory'=>ProductCategory::all(),'tag'=>Tag::all()]);
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
                // 'image' => 'required',
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
            if ($request['image'] != null) {
                /*$product->addMediaFromRequest('image')->toMediaCollection('image');*/
                foreach ($request->image as $img){
                    $product->addMedia($img)->toMediaCollection('image');
                }
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
    {
        return view('productshow',['product'=>Product::findOrFail($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('productedit',['product'=>Product::findOrFail($id),'productcategory'=>ProductCategory::all(),'tag'=>Tag::all()]);
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
            Product::whereId($id)->delete();
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
}
