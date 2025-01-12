<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;


class EmployeeResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'person' => new PersonResource($this->person),
            'position' => $this->position,
            'hire_date' => $this->hire_date,
            'termination_date' => $this->termination_date,
            'current_rate' => $this->rates()->latest()->first()?->hourly_rate,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
}
