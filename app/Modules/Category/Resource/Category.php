<?php

namespace App\Modules\Category\Resource;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Modules\Category\Resource\TempCategory as TempCategoryResource;
class Category extends JsonResource
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
            'position' => $this->position,
            'photo' => $this->when(1, function () {
                if (count($this->getMedia('photo')) > 0) {
                    return $this->getMedia('photo')[0]->getFullUrl();

                } else {
                    return "https://kcl-mrcdtp.com/wp-content/uploads/sites/201/2017/05/person_icongray-300x300.png";
                }
            }),
        ];
    }
}
