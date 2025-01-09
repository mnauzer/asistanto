<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AccountResource extends JsonResource
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
            'typ' => $this->typ,
            'ucel' => $this->ucel,
            'employee_id' => $this->employee_id,
            'nazov' => $this->nazov,
            'zostatok' => $this->zostatok,
            'aktivny' => $this->aktivny,
            'prefix' => $this->prefix,
            'icon' => $this->icon,
            'color' => $this->color,
            'color_text' => $this->color_text,
            'model' => $this->model,
        ];
    }
}
