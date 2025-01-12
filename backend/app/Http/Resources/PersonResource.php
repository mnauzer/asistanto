<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PersonResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'nick' => $this->nick,
            'title' => $this->title,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'company_name' => $this->company_name,
            'ico' => $this->ico,
            'dic' => $this->dic,
            'is_vat_payer' => $this->is_vat_payer,
            'is_company' => $this->is_company,
            'is_active' => $this->is_active,
            'email' => $this->email,
            'phone' => $this->phone,
            'place' => new PlaceResource($this->whenLoaded('place')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}

