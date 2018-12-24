<?php

namespace App\Http\Resource;

use App\Category as CategoryModel;
use Illuminate\Http\Resources\Json\JsonResource;


use App\Http\Resources\Media as MediaResource;
class Post extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,

            'status'=> $this->status,
            'icon' => $this->icon,
            'category' => CategoryModel::find($this->category_id),
             'category_id' => $this->category_id,
            'featured' => $this->when(1, function () {
                if (count($this->getMedia('featured')) > 0) {
                    return $this->getMedia('featured')[0]->getFullUrl();
                }
            }),
            'gallery' => MediaResource::collection($this->getMedia('gallery')),

        ];
    }
}
