<?php

namespace App\Modules\User\Controllers;

use App\Modules\User\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\User\Resource\Role as RoleResource;
use Illuminate\Support\Facades\Auth;


class RoleController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->hasRole('admin')) {

//            return Role::all();
            return RoleResource::collection(Role::all());
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
     * @return void
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
            $role = Role::create($role_input_table);

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
     * @return void
     */
    public function show($id)
    {
        $user = Auth::user();

        if ($user->hasRole('admin')) {
            return new RoleResource(Role::find($id));
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
            $role = Role::findOrFail($id);

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
            Role::whereId($id)->delete();
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
