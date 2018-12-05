<?php

namespace App\Modules\Category\Controllers;

use App\Modules\Category\Models\Category;
use App\Modules\Product\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Modules\Category\Resource\Category as CategoryResource;
use App\Modules\Product\Resource\Product as ProductResource;

class CategoryController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {

        if ($request->has('title') && $request->has('limit') && $request->has('sort')) {
            $category = Category::where('title', 'like', '%' . $request->title . '%')->orderBy('id', $request->sort)->paginate($request->input('limit'));
            return CategoryResource::collection($category);
        }
        return CategoryResource::collection(Category::all());

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
     * @param  \Illuminate\Http\Request $request
     * @return CategoryResource
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        if ($user->hasRole('admin')) {


            $validation = Validator::make($request->all(), [
                'title' => 'required|unique:categories',
                'description' => 'required',
                'position' => 'required'
            ]);


            if ($validation->fails()) {
                return response()->json($validation->errors());

            }


            $category = Category::create($request->all());
            if ($request['image'] != null) {
                $category->clearMediaCollection('photo');
                $category->addMediaFromRequest('image')->toMediaCollection('photo');

            }
            return new  CategoryResource($category);

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
     * Display the specified resource.
     *
     * @param  int $id
     * @return CategoryResource
     */
    public function show($id)
    {
        $user = Auth::user();

        if ($user->hasRole('admin')) {
            return new CategoryResource(Category::find($id));
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
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return CategoryResource
     */
    public function update(Request $request, $id)
    {
//        $category = Category::findOrFail($id);
//
        $user = Auth::user();
        if ($user->hasRole('admin')) {
            $category = Category::findOrFail($id);
            $category->fill($request->all())->save();


            if ($request['image'] != null) {
                $category->clearMediaCollection('photo');
                $category->addMediaFromRequest('image')->toMediaCollection('photo');

            }
            $category = Category::findOrFail($id);

            return new  CategoryResource($category);

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
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = Auth::user();
        if ($user->hasRole('admin')) {
            Category::whereId($id)->delete();
            $return = ["status" => "Success",
                "error" => [
                    "code" => 200,
                    "errors" => 'Deleted'
                ]];
            return response()->json($return, 200);

        } else {
            $return = ["status" => "error",
                "error" => [
                    "code" => 403,
                    "errors" => 'Forbidden'
                ]];
            return response()->json($return, 403);
        }
    }


}
