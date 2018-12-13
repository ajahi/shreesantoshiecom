<?php

namespace App\Http\Controllers;

use App\Role as RoleModel;
use Illuminate\Http\Request;
use App\Http\Resources\Role as RoleResource;
use Illuminate\Support\Facades\Auth;

use Validator;


class Role extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->hasRole('admin')) {

            return RoleResource::collection(RoleModel::all());
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
     * @return void
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return RoleResource
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        if ($user->hasRole('admin')) {

            $validation = Validator::make($request->all(), [
                'name' => 'required|min:3|unique:roles',
                'display_name' => 'required|min:3',
                'description' => 'required|min:3',
                'permission_list' => 'sometimes'
            ]);


            if ($validation->fails()) {
                return response()->json($validation->errors());

            }

            $role_name = snake_case($request->input('name'));
            $role_input_initial = collect($request->all());
            $role_input = $role_input_initial->merge(['name' => $role_name]);

            $role_input_table = $role_input->all();
            $role = RoleModel::create($role_input_table);

            if (isset($request->permission_list)) {
                $perm_list = $role_input->permission_list;
                $role->perms()->attach($perm_list);
            }

            return new  RoleResource($role);


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
     * @return RoleResource
     */
    public function show($id)
    {
        $user = Auth::user();

        if ($user->hasRole('admin')) {
            return new RoleResource(RoleModel::find($id));
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
     * @return void
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
     * @return void
     */
    public function update(Request $request, $id)
    {
//        return $request;
        $user = Auth::user();
        if ($user->hasRole('admin')) {
            $role = RoleModel::findOrFail($id);

            $validation = Validator::make($request->all(), [
                'name' => 'sometimes|min:3',
                'display_name' => 'sometimes|min:3',
                'description' => 'sometimes|min:3',
                'permission_list' => 'sometimes'
            ]);


            if ($validation->fails()) {
                return response()->json($validation->errors());

            }


            $role_input_initial = collect($request->all());
            if (isset($request->name)) {
                $role_name = snake_case($request->input('name'));
                $role_input_initial = $role_input_initial->merge(['name' => $role_name]);

            }

            $role_input_table = $role_input_initial->all();
            $role->fill($role_input_table)->save();

            if (isset($request->permission_list)) {
                $perms_list = $role_input_initial->pop();
                $role->perms()->sync($perms_list);
            }
            return new  RoleResource($role);

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
     * @return void
     */
    public function destroy($id)
    {
        $user = Auth::user();
        if ($user->hasRole('admin')) {
            RoleModel::whereId($id)->delete();
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
