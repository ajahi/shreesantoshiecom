<?php

namespace App\Http\Controllers;

use App\Permission as PermissionModel;

use App\Http\Resources\Permission as PermissionResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class Permission extends Controller
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

            return PermissionResource::collection(PermissionModel::all());
        }
        else {
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
     * @return PermissionResource
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        if ($user->hasRole('admin')) {

            $validation = Validator::make($request->all(), [
                'name' => 'required|min:3|unique:roles',
                'display_name' => 'required|min:3',
                'description' => 'required|min:3',
            ]);


            if ($validation->fails()) {
                return response()->json($validation->errors());

            }

            $permission_name = snake_case($request->input('name'));
            $permission_input_initial = collect($request->all());
            $permission_input = $permission_input_initial->merge(['name' => $permission_name]);

            $permission_input_table = $permission_input->all();
            $permission = PermissionModel::create($permission_input_table);


            return new  PermissionResource($permission);


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
     * @return PermissionResource
     */
    public function show($id)
    {
        $user = Auth::user();

        if ($user->hasRole('admin')) {
            return new PermissionResource(PermissionModel::find($id));
        }
        else {
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
     * @return PermissionResource
     */
    public function update(Request $request, $id)
    {
        $user = Auth::user();
        if ($user->hasRole('admin') ) {
            $permission = PermissionModel::findOrFail($id);

            $validation = Validator::make($request->all(), [
                'name' => 'sometimes|min:3',
                'display_name' => 'sometimes|min:3',
                'description' => 'sometimes|min:3',
            ]);


            if ($validation->fails()) {
                return response()->json($validation->errors());

            }



            $permission_input = collect($request->all());

            if(isset($request->name)){
                $permission_name = snake_case($request->input('name'));
                $permission_input = $permission_input->merge(['name' => $permission_name]);

            }

            $permission_input_table = $permission_input->all();
            $permission->fill($permission_input_table)->save();


            return new  PermissionResource($permission);

        }
        else{
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
        $user=Auth::user();
        if ($user->hasRole('admin')) {
            PermissionModel::whereId($id)->delete();
            $return = ["status" => "Success",
                "error" => [
                    "code" => 200,
                    "errors" => 'Deleted'
                ]];
            return response()->json($return, 200);

        }
        else{
            $return = ["status" => "error",
                "error" => [
                    "code" => 403,
                    "errors" => 'Forbidden'
                ]];
            return response()->json($return, 403);
        }
    }
}
