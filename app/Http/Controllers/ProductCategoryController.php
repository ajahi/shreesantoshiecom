<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProductCategory;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Validation\Rule;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('productcategoryindex',['productcategory'=>ProductCategory::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('productcategorycreate',['productcategory'=>ProductCategory::all()]);
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
        if ($user->hasRole(['admin','super_admin'])) {
            $validation = Validator::make($request->all(), [
                'title' => 'required|min:3',
                'description' => 'required|min:5',
                'parent_id' => 'exists:product_categories,id'
            ]);
            if ($validation->fails()) {
                return response()->json($validation->errors(), 422);
            }
            $position = ProductCategory::count();
            $product_category = new ProductCategory();
            $product_category->title = $request->title;
            $product_category->slug = slug(strtolower($request->title));
            $product_category->description = $request->description;
            $product_category->position = $position +1;
            if($request->parent_id){
                $product_category->parent_id = $request->parent_id;
            }
            
            $product_category->save();
            
            return redirect('/productcategory');
            // return new  ProductCategoryResource($product_category);
        }else{
            return response()->json(['error'=>'Forbidden request'], 403);
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
        return view('productcategoryshow',['productcategory'=>ProductCategory::findOrFail($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('productcategoryedit',['productcategory'=>ProductCategory::findOrFail($id),'parent'=>ProductCategory::all()]);
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
        if ($user->hasRole(['admin','super_admin'])) {
            $validation = Validator::make($request->all(), [
                'title' => 'required',
                'description'=>'required|min:5',
                'parent_id' => 'exists:product_categories,id',
                
            ]);
            if ($validation->fails()) {
                return response()->json($validation->errors() , 422);
            }
            $product_category = ProductCategory::findOrFail($id);
            $product_category->title = $request->title;
            $product_category->slug = slug(strtolower($request->title));
            $product_category->description = $request->description;
            $product_category->parent_id = $request->parent_id;
          
            $product_category->save();
            if ($request->has('image')) {
                $product_category->clearMediaCollection('image');
                $product_category->addMediaFromRequest('image')->toMediaCollection('image');
            }
            return redirect('/productcategory');
            return new  ProductCategoryResource($product_category);

        } else {
            return response()->json(['error'=>'Forbidden request'], 403);
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
        if ($user->hasRole(['admin','super_admin'])) {
            $product_category = ProductCategory::findOrFail($id);
            if(count($product_category->products)>0){
                return response()->json(['error'=>'Cannot delete. One or many Products are attached to this category.'], 403);
            }
            $product_category->products()->detach();
            $product_category->delete();
            return redirect('/productcategory');
        }
        else {
            return response()->json(['error'=>'Forbidden request'], 403);
        }
    }
}
