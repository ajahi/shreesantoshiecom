<?php

namespace App\Http\Controllers;

use App\Site as SiteModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Validator;

class Site extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $site = SiteModel::first();
        if (count($site->getMedia('logo')) > 0) {
            $site['logo'] = $site->getMedia('logo')[0]->getFullUrl();

        } else {
            $site['logo'] = "https://kcl-mrcdtp.com/wp-content/uploads/sites/201/2017/05/person_icongray-300x300.png";
        }

        return response()->json($site);
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

        $validation = Validator::make($request->all(), [
            'email' => 'email',
            'title' => 'min:6'
        ]);


        if ($validation->fails()) {
            return response()->json($validation->errors());

        }

        $user = Auth::user();
        if ($user->hasRole('admin')) {
            $site = SiteModel::first();
            $site->fill($request->all())->save();


            if ($request['logo'] != null) {
                $site->clearMediaCollection('logo');
                $site->addMediaFromRequest('logo')->toMediaCollection('logo');
            }


            $site = SiteModel::first();
            if (count($site->getMedia('logo')) > 0) {
                $site['logo'] = $site->getMedia('logo')[0]->getFullUrl();

            } else {
                $site['logo'] = "https://kcl-mrcdtp.com/wp-content/uploads/sites/201/2017/05/person_icongray-300x300.png";
            }

            return response()->json($site);


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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
