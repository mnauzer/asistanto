<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class IncomeCategoryResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [

            'id' => $this->id,
            'nazov' => $this->nazov,
            'text' => $this->text,
            'icon' => $this->icon,
            'color' => $this->color,
            'color_text' => $this->color_text,
            'model' => $this->model,
        ];
    }
}
