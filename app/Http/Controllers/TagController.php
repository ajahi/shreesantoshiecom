<?php

namespace App\Http\Controllers;

use App\Tag;
use App\Http\Resources\TagResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Validator;
use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has('title')) {
            $tag = Tag::where('title', 'like', '%' . $request->title . '%')->orWhere('description', 'like', '%' . $request->title . '%')->orderBy('id', $request->sort)->paginate($request->input('limit'));
            return TagResource::collection($tag);
        }

        return TagResource::collection(Tag::orderBy('id', $request->sort)->paginate($request->input('limit')));

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
        $user = Auth::user();

        if ($user->hasRole(['admin','super_admin'])) {
            $validation = Validator::make($request->all(), [
                'title' => 'required|unique:tags'
            ]);
            if ($validation->fails()) {
                return response()->json($validation->errors(), 422);
            }
            $tag = Tag::create($request->all());

            return new  TagResource($tag);

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
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new TagResource(Tag::find($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function edit(Tag $tag)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $user = Auth::user();
        if ($user->hasRole(['admin','super_admin'])) {

            $validation = Validator::make($request->all(), [
                'title' => 'required'
            ]);
            if ($validation->fails()) {
                return response()->json($validation->errors(), 422);
            }

            $tag = Tag::findOrFail($id);
            $tag->fill($request->all())->save();

            $tag = Tag::findOrFail($id);
            return new  TagResource($tag);

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
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {
        $user = Auth::user();
        if ($user->hasRole(['admin','super_admin'])) {
            Tag::whereId($tag)->delete();
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
