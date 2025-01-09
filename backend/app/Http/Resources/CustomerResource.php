<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
      //TODO: resources : https://laravel.com/docs/7.x/eloquent-resources

        return [
            'id' => $this->id,
            'alias' => $this->alias,
            'meno' => $this->meno,
            'priezvisko' => $this->priezvisko,
            'titul' => $this->titul,
            'fo'=> $this->fo,
            'firma_nazov' => $this->firma_nazov,
            'aktivny' => $this->aktivny,
            'poznamka' => $this->poznamka,
            'full_name' => $this->full_name,
            'summary' => [
             
            ]
   
        ];
    }
}
