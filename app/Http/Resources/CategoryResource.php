<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request, $lang)
    {
        return [

            'id' => $this->id,
            'name' => $this->lang($lang)->name,
            'description' => $this->lang($lang)->description,
            'parent_id' => $this->parent_id,

        ];
    }
}
