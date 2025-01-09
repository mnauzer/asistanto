<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ JsonResource;

class EmployeeWageResource extends  JsonResource

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
            'alias' => $this->alias,
            'platnost' => $this->platnost,
            'sadzba' => $this->sadzba,
            'employee_id' => $this->employee_id,
        ];
    }
}

