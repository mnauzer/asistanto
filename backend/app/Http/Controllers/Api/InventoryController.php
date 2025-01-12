<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\InventoryItem;
use App\Http\Resources\InventoryResource;
use App\Http\Requests\InventoryRequest;
use Illuminate\Http\Request;



class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $query = InventoryItem::query();

        if ($request->has('category')) {
            $query->where('category', $request->category);
        }

        if ($request->has('is_active')) {
            $query->where('is_active', $request->boolean('is_active'));
        }

        $items = $query->paginate(15);

        return InventoryResource::collection($items);
    }

    // Ďalšie CRUD metódy...
}
