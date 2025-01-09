<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class JobResource extends JsonResource
{
    /**
     * Transform the resource into an array.
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
            'employee_id' => $this->employee_id,
            'employee' => $this->employee->alias,
            'order_id' => $this->order_id,
            'zakazka' => $this->zakazka,
            'odpracovane' => $this->odpracovane,
            'popis' => $this->popis,
            'info' => [
                'jobs'=>$this->jobs,
                'expenses' => $this->expenses,
            ]
        ];
    }
}
