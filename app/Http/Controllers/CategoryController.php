<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resource\CategoryResource;
use Validator;

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

        if ($user->hasRole(['admin','super_admin'])) {


            $validation = Validator::make($request->all(), [
                'title' => 'required|unique:categories',
                'description' => 'required',
            ]);


            if ($validation->fails()) {
                return response()->json($validation->errors(),422);

            }
            $data = collect($request->all());

            $data = $data->toArray();

            $position = Category::count();
            $data['position'] = $position + 1;
            $category = Category::create($data);

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
        return new CategoryResource(Category::find($id));

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
        if ($user->hasRole(['admin','super_admin'])) {
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
        if ($user->hasRole(['admin','super_admin'])) {
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
