<?php

namespace App\Http\Controllers;

use App\Category as CategoryModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resource\Category as CategoryResource;

use Validator;

class Category extends Controller
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
            $category = CategoryModel::where('title', 'like', '%' . $request->title . '%')->orderBy('id', $request->sort)->paginate($request->input('limit'));
            return CategoryResource::collection($category);
        } elseif ($request->has('limit') && $request->has('sort')) {
            $category = CategoryModel::orderBy('id', $request->sort)->paginate($request->input('limit'));
            return CategoryResource::collection($category);
        }
        return CategoryResource::collection(CategoryModel::all());

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
            ]);


            if ($validation->fails()) {
                return response()->json($validation->errors());

            }
            $data = collect($request->all());

            $data = $data->toArray();

            $position = CategoryModel::count();
            $data['position'] = $position + 1;
            $category = CategoryModel::create($data);

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
        return new CategoryResource(CategoryModel::find($id));

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

        $user = Auth::user();
        if ($user->hasRole('admin')) {
            $category = CategoryModel::findOrFail($id);
            $category->fill($request->all())->save();


            if ($request['image'] != null) {
                $category->clearMediaCollection('photo');
                $category->addMediaFromRequest('image')->toMediaCollection('photo');

            }
            $category = CategoryModel::findOrFail($id);

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
            CategoryModel::whereId($id)->delete();
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
