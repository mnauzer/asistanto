<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class IncomeSubcategoryResource extends JsonResource
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
            'model' => $this->model,
            'category_id' => $this->category_id,
            'category_name' =>  $this->category->nazov,
            'category_color' =>  $this->category->color,
            'category_color_text' =>  $this->category->color_text,
            'category_icon' =>  $this->category->icon,
        ];
    }
}
