<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'cislo' => $this->cislo,
            'datum' => $this->datum,
            'customer_id' => $this->customer_id,
            'alias' => $this->alias,
            'nazov' => $this->nazov,
            'popis' => $this->popis,
            'type_id' => $this->type_id,
            'status_id' => $this->status_id,
            'miesto' => $this->miesto,
            'vzdialenost' => $this->vzdialenost,
            'uctovanie_typ' => $this->uctovanie_typ,
            'uctovanie_dopravy' => $this->uctovanie_dopravy,
            'offer_id' => $this->offer_id,
            'sadzba_dph' => $this->sadzba_dph,
            'suma_zaklad' => $this->suma_zaklad,
            'suma_dph' => $this->suma_dph,
            'suma_celkom' => $this->suma_celkom,
            'zacatie' => $this->zacatie,
            'ukoncenie' => $this->ukoncenie,
            'poznamka' => $this->poznamka,
            'short' => $this->short,
            'info' => [
                'sum_jobs' => $this->jobs->sum('odpracovane'),
                'sum_expenses' => $this->expenses->sum('suma_bez_dph'),
                'sum_incomes' => $this->incomes->sum('suma_bez_dph'),
                'customer_full_name' => $this->customer->full_name,
                'customer_alias' => $this->customer->alias,
                'type_name' => $this->type->nazov,
                'type_color' => $this->type->color,
                'type_icon' => $this->type->icon,
                'status_name' => $this->status->nazov,
                'status_color' => $this->status->color,
                'status_icon' => $this->status->icon,
                'expenses' => $this->expenses,
            ]
          
   
        ];
    }
    }

