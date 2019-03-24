<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\Menu;
use App\Http\Resource\MenuResource;
use Illuminate\Support\Facades\Auth;

class MenuController extends Controller
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
            $menu = Menu::where('title', 'like', '%' . $request->title . '%')->orderBy('id', $request->sort)->paginate($request->input('limit'));
            return MenuResource::collection($menu);
        } elseif ($request->has('title') && $request->has('limit') && $request->has('sort') && $request->has('parent_id')) {
            $menu = Menu::where('title', 'like', '%' . $request->title . '%')->where('parent_id', null)->orderBy('id', $request->sort)->paginate($request->input('limit'));
            return MenuResource::collection($menu);
        } elseif ($request->has('parent_id')) {
            $menu = Menu::where('parent_id', null)->orderBy('position')->get();

            return MenuResource::collection($menu);
        }
        return MenuResource::collection(Menu::all());
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
     * @return MenuResource
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        if ($user->hasRole(['admin','super_admin'])) {


            $validation = Validator::make($request->all(), [
                'title' => 'required|unique:menus',
                'description' => 'required',
                'parent_id' => 'numeric',
                'url'=>'required'
            ]);

            if ($validation->fails()) {
                return response()->json($validation->errors() , 422);

            }

            $data  = collect($request->all());

            $data = $data->toArray();


            if($request->parent_id){
                $position = Menu::where('parent_id','=',$request->parent_id)->count();
            }else{
                $position = Menu::count();
            }
            $data['position'] = $position +1 ;


            $menu = Menu::create($data);

            if ($request['image'] != null) {
                $menu->clearMediaCollection('photo');
                $menu->addMediaFromRequest('image')->toMediaCollection('photo');

            }

//            return $menu;

            return new  MenuResource($menu);


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
     * @return MenuResource
     */
    public function show($id)
    {
        $user = Auth::user();

        if ($user->hasRole(['admin','super_admin'])) {
            return new MenuResource(Menu::find($id));
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
     * @return MenuResource
     */
    public function update(Request $request, $id)
    {
        $user = Auth::user();
        if ($user->hasRole(['admin','super_admin'])) {
            $menu = Menu::findOrFail($id);

            if ($request->parent_id) {
                $menu = Menu::findOrFail($request->parent_id);

                if ($menu->parent_id == $id) {

                } else {
                    $menu->fill($request->all())->save();

                }
            } else {
                $menu->fill($request->all())->save();

            }
            if ($request['image'] != null) {
                $menu->clearMediaCollection('photo');
                $menu->addMediaFromRequest('image')->toMediaCollection('photo');

            }
            $menu = Menu::findOrFail($id);

            return new MenuResource($menu);

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
            Menu::whereId($id)->delete();
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
