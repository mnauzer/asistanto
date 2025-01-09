<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ExpenseResource extends JsonResource
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
            'popis' => $this->popis,
            'text' => $this->text,
            'sadzba_dph' => $this->sadzba_dph,
            'suma_zaklad' => $this->suma_zaklad,
            'suma_dph' => $this->suma_dph,
            'suma_celkom' => $this->suma_celkom,
            'doklad' => $this->doklad,
            'ucto' => $this->ucto,

            'subcategory_id' => $this->subcategory_id,
            'account_id' => $this->account_id,
            'expenseable_type' => $this->expenseable_type,
            'expenseable_id' => $this->expenseable_id,
            'ralateable_type' => $this->relateable_type,
            'ralateable_id' => $this->relateable_id,
            'user_id' => $this->user_id,
            'info' => [
                'account_name' => $this->account->nazov,
                'subcategory' => $this->subcategory->nazov,
             'recipient' => $this->expenseable->alias,
                // TODO: nechápem prečo tieto dve nefungujú
              'relateable' => $this->relateable->nazov,

            ]
        ];
    }
}
