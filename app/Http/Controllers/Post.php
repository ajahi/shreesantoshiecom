<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Post as PostModel;
use App\Http\Resource\Post as PostResource;
use App\Http\Resources\Media as MediaResource;

use Illuminate\Support\Facades\Auth;

use Illuminate\Validation\Rule;
use Validator;

class Post extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {


        if ($request->has('name')) {
            $post = PostModel::where('name', 'like', '%' . $request->name . '%')->orWhere('description', 'like', '%' . $request->name . '%')->orderBy('id', $request->sort)->paginate($request->input('limit'));

            if ($request->has('status')) {
                $post = PostModel::orWhere([['name', 'like', '%' . $request->name . '%'], ['description', 'like', '%' . $request->name . '%']])->where('status', $request->status)->orderBy('id', $request->sort)->paginate($request->input('limit'));
            }

            return PostResource::collection($post);
        } elseif ($request->has('status')) {
            $post = PostModel::where('status', $request->status)->orderBy('id', $request->sort)->paginate($request->input('limit'));
            return PostResource::collection($post);

        }
        return PostResource::collection(PostModel::orderBy('id', $request->sort)->paginate($request->input('limit')));

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

        if ($user->hasRole(['admin','super_admin'])) {

            $validation = Validator::make($request->all(), [
                'title' => 'required|unique:posts',
                'slug' => 'required|unique:posts',

                'description' => 'required',
                'status' => 'required|in:published,draft',
                'category_id' => 'required',
            ]);


            if ($validation->fails()) {
                return response()->json($validation->errors(), 422);

            }


            $post = PostModel::create($request->all());

            if ($request['featured'] != null) {
                $post->clearMediaCollection('featured');
                $post->addMediaFromRequest('featured')->toMediaCollection('featured');

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
     * @return PostResource
     */
    public function show($id)
    {
        return new PostResource(PostModel::find($id));

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
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $id)
    {

        $user = Auth::user();
        if ($user->hasRole(['admin','super_admin'])) {

            $this->validate($request, [
                'title' => ['sometimes', Rule::unique('posts')->ignore($id)],
                'slug' => ['sometimes', Rule::unique('posts')->ignore($id)],
            ]);

            $post = PostModel::findOrFail($id);
            $post->fill($request->all())->save();


            if ($request['featured'] != null) {
                $post->clearMediaCollection('featured');
                $post->addMediaFromRequest('featured')->toMediaCollection('featured');

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
        if ($user->hasRole(['admin','super_admin'])) {
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

    public function uploads(Request $request)
    {
        $user = Auth::user();

        if ($user->hasRole(['admin','super_admin'])) {

            $validation = Validator::make($request->all(), [
                'post' => 'required|numeric',
            ]);


            if ($validation->fails()) {
                return response()->json($validation->errors(), 422);

            }

            $post = PostModel::findOrFail($request->post);

            if ($request['file'] != null) {

                $post->addMediaFromRequest('file')->toMediaCollection('gallery');


            }
            $post = PostModel::findOrFail($request->post);
            return MediaResource::collection($post->getMedia('gallery'));

        }
    }


    public function deleteMedia($id, $mediaID)
    {
        $user = Auth::user();

        if ($user->hasRole(['admin','super_admin'])) {

            $post = PostModel::findOrFail($id);
        $media = $post->getMedia('gallery');

        $delete = $media->where('id', $mediaID)->first();
        $delete->delete();

        $post = PostModel::findOrFail($id);
        return MediaResource::collection($post->getMedia('gallery'));
        }
    }


}
