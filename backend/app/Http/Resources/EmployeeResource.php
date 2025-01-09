<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        //return parent::toArray($request);
        //TODO: resources : https://laravel.com/docs/7.x/eloquent-resources

        return [
            'id' => $this->id,
            'alias' => $this->alias,
            'meno' => $this->meno,
            'priezvisko' => $this->priezvisko,
            'titul' => $this->titul,
            'zaradenie' => $this->zaradenie,
            'aktivny' => $this->aktivny,
            'poznamka' => $this->poznamka,
            'full_name' => $this->full_name,
            'summary' => [
                'zarobene' => $this->workhours->sum('mzda'),
                'odpracovane' => $this->workhours->sum('odpracovane'),
                'zakazky' => $this->jobs->sum('odpracovane'),
                'platby' => $this->expenses->sum('suma_bez_dph'),
            ]
   
        ];
    }
}
