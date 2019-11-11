<?php

namespace App\Http\Controllers;

use Validator;
use App\Site;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\SiteResource;
use App\Http\Resources\MediaResource;
use Illuminate\Support\Facades\Storage;


class SiteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $site = Site::firstOrFail();
        return new SiteResource($site);
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
            'title' => 'required|min:6'
        ]);
        if ($validation->fails()) {
            return response()->json($validation->errors(), 422);
        }

        $user = Auth::user();
        if ($user->hasRole(['admin','super_admin'])) {
            $site = Site::first();
            $data = collect($request->all());
            $data= $data->except(['logo']);

//            $data['attributes']  = $data['attributes'];
            $site->fill($data->toArray())->save();

            if ($request['logo'] != null) {
                $site->clearMediaCollection('logo');
                $site->addMediaFromRequest('logo')->toMediaCollection('logo');
            }

            $site = Site::firstOrFail();
            if (count($site->getMedia('logo')) > 0) {
                $site['logo'] = $site->getMedia('logo')[0]->getFullUrl();
            } else {
                $site['logo'] = "";
            }

            if($request['banner'] != null){
                $site->clearMediaCollection('banner');
                $site->addMediaFromRequest('banner')->toMediaCollection('banner');
            }

            if (count($site->getMedia('banner')) > 0) {
                $site['banner'] = $site->getMedia('banner')[0]->getFullUrl();

            } else {
                $site['banner'] = "";
            }

            $site->attributes = json_decode($site->attributes);

            return new SiteResource($site);

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

    public function uploadsGallery(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'site' => 'required|numeric',
        ]);

        if ($validation->fails()) {
            return response()->json($validation->errors(), 422);

        }

        $site = Site::findOrFail($request->site);

        if ($request['file'] != null) {

            $site->addMediaFromRequest('file')->toMediaCollection('gallery');

        }
        $site = Site::findOrFail($request->site);
        return MediaResource::collection($site->getMedia('gallery'));

    }

    public function deleteMediaGallery($id, $mediaID)
    {
        $site = Site::findOrFail($id);
        $media = $site->getMedia('gallery');

        $delete = $media->where('id', $mediaID)->first();
        $delete->delete();

        $site = Site::findOrFail($id);
        return MediaResource::collection($site->getMedia('gallery'));
    }


    public function uploadMedia(Request $request)
    {
        $max_size = (int)ini_get('upload_max_filesize') * 1000;

        $validation = Validator::make($request->all(), [
            'file' => 'required|file|max:' . $max_size

        ]);

        if ($validation->fails()) {
            return response()->json($validation->errors(), 422);
        }

        $path = $request->file('file')->store('public/uploads');
        $data['file'] = $path;
        // url('/') give root url and storage link give full path
        $data['url'] = url('/').Storage::url($path);
        return $data;

    }

    public function deleteMedia(Request $request)
    {
        if ($request->has('file')) {
            if ((string)Storage::delete($request->file) == '1') {
                return 1;
            }else{
                return 0;
            }

        }
    }

}
