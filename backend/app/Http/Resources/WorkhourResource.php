<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WorkhourResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
            // return parent::toArray($request);
        return [
            'id' => $this->id,
            'datum' => $this->datum,
            'zaciatok' => $this->zaciatok,
            'koniec' => $this->koniec,
            'alias' => $this->alias,
            'employee_id' => $this->employee_id,
            'alias' => $this->employee->alias,
            'sadzba' => $this->sadzba,
            'mzda' => $this->mzda,
            'odpracovane' => $this->odpracovane,
        ];
    }
}
