<?php

namespace App\Modules\Post\Resource;

use App\Modules\Category\Models\Category;
use Illuminate\Http\Resources\Json\JsonResource;
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
            'category' => Category::find($this->category_id),
            'image' => $this->when(1, function () {
                if (count($this->getMedia('image')) > 0) {
                    return $this->getMedia('image')[0]->getFullUrl();

                } else {
                    return "https://kcl-mrcdtp.com/wp-content/uploads/sites/201/2017/05/person_icongray-300x300.png";
                }
            }),
        ];
    }
}
