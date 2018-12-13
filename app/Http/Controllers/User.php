<?php

namespace App\Http\Controllers;

use App\User as UserModel;
use Illuminate\Http\Request;

use App\Http\Resources\User as UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


use Validator;

class User extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {

        $user = Auth::user();
        if ($user->hasRole('admin')) {
            if ($request->has('name')) {
                $user = UserModel::where('name', 'like', '%' . $request->name . '%')->orWhere('email', 'like', '%' . $request->name . '%')->orderBy('id', $request->sort)->paginate($request->input('limit'));

                if ($request->has('status')) {
                    $user = UserModel::orWhere([['name', 'like', '%' . $request->name . '%'], ['email', 'like', '%' . $request->name . '%']])->where('active', $request->status)->orderBy('id', $request->sort)->paginate($request->input('limit'));
                }

                return UserResource::collection($user);
            } elseif ($request->has('status')) {
                $user = UserModel::where('active', $request->status)->orderBy('id', $request->sort)->paginate($request->input('limit'));
                return UserResource::collection($user);

            }
            return UserResource::collection(UserModel::orderBy('id', $request->sort)->paginate($request->input('limit')));
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
                'name' => 'required|min:3',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:6|confirmed',
                'role_id' => 'required'
            ]);


            if ($validation->fails()) {
                return response()->json($validation->errors());

            }

            $user_input = $request->all();
            $user_input['password'] = bcrypt($user_input['password']);
            $created_user = UserModel::create($user_input);
            $created_user->roles()->attach($request['role_id']);
            return new  UserResource($created_user);


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
     * @return UserResource
     */
    public function show($id)
    {
        $user = Auth::user();
        if ($user->hasRole('admin') || $user->id == $id) {
            return new  UserResource(UserModel::find($id));
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
     * @return UserResource
     */
    public function update(Request $request, $id)
    {

        $user = Auth::user();

        if ($user->hasRole('admin') || $user->id == $id) {

            $user_update = UserModel::findOrFail($id);


            $validation = Validator::make($request->all(), [
                'name' => 'sometimes|min:3',
                'email' => 'sometimes|email',
                'role_id' => 'sometimes'
            ]);


            if ($validation->fails()) {
                return response()->json($validation->errors());

            }

            $user_input = $request->all();
            if ($request['password'] != null) {
                $this->validate($request, [
                    'password' => 'required|confirmed|min:6',
                ]);
                $user_input['password'] = bcrypt($user_input['password']);

            } else {
                unset($user_input['password']);

            }
            if ($request['image'] != null) {

                $user->clearMediaCollection('profile');
                $user->addMediaFromRequest('image')->toMediaCollection('profile');

            }
            $user_update->fill($user_input)->save();
            if ($request['role_id'] != null) {
                $user_update->roles()->sync($request['role_id']);
            }
            if ($user_update->token()) {
                $accessToken = $user_update->token();
                DB::table('oauth_refresh_tokens')
                    ->where('access_token_id', $accessToken->id)
                    ->update(['revoked' => true]);
                $accessToken->revoke();
            }
            return new  UserResource($user_update);


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
        $user_delete = UserModel::findOrFail($id);
        if ($user->hasRole('admin')) {
            if ($user_delete->token()) {
                $accessToken = $user_delete->token();
                DB::table('oauth_refresh_tokens')
                    ->where('access_token_id', $accessToken->id)
                    ->update(['revoked' => true]);
                $accessToken->revoke();
            }
            $user_delete->delete();
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
