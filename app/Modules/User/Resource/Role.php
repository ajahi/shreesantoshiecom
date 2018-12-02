<?php

namespace App\Modules\User\Resource;

use Illuminate\Http\Resources\Json\JsonResource;

class Role extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name ,
            'display_name' => $this->display_name,
            'description' => $this->description ,
            'permission' => Permission::collection($this->perms)
        ];
    }
}
