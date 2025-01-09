<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ExpenseSubcategoryResource extends JsonResource
{
    public function toArray($request)
    {
    return [
            'id' => $this->id,
            'nazov' => $this->nazov,
            'text' => $this->text,
            'icon' => $this->icon,
            'color' => $this->color,
            'model' => $this->model,
            'category_id' => $this->expense_category_id,
            'category_name' =>  $this->category->nazov,
            'category_color' =>  $this->category->color,
            'category_color_text' =>  $this->category->color_text,
            'category_icon' =>  $this->category->icon,
        ];
    }
}
