<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Post as PostModel;
use App\Http\Resource\Post as PostResource;
use Illuminate\Support\Facades\Auth;

class Post extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has('title') && $request->has('limit') && $request->has('sort')) {
            $post = PostModel::where('title', 'like', '%' . $request->title . '%')->orderBy('id', $request->sort)->paginate($request->input('limit'));
            return PostResource::collection($post);
        }
        return PostResource::collection(PostModel::all());
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
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        if ($user->hasRole('admin')) {

            $validation = Validator::make($request->all(), [
                'title' => 'required|unique:categories',
                'description' => 'required',
                'status' => 'required|in:published,draft',
                'category_id' => 'required',
                'icon' => 'required'
            ]);


            if ($validation->fails()) {
                return response()->json($validation->errors());

            }


            $post = PostModel::create($request->all());
            if ($request['image'] != null) {
                $post->clearMediaCollection('image');
                $post->addMediaFromRequest('image')->toMediaCollection('image');

            }
            return new  PostResource($post);

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
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = Auth::user();

        if ($user->hasRole('admin')) {
            return new PostResource(PostModel::find($id));
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
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $user = Auth::user();
        if ($user->hasRole('admin')) {
            $post = PostModel::findOrFail($id);
            $post->fill($request->all())->save();


            if ($request['image'] != null) {
                $post->clearMediaCollection('image');
                $post->addMediaFromRequest('image')->toMediaCollection('image');

            }
            $post = PostModel::findOrFail($id);

            return new  PostResource($post);

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
            PostModel::whereId($id)->delete();
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
