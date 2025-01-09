<?php

namespace App\Http\Controllers;

use App\OrderType;
use Illuminate\Http\Request;
use App\Http\Resources\OrderTypeResource;
use Validator;

class OrderTypeController extends Controller
{
    public function index()
    {
        return OrderTypeResource::collection(OrderType::all());
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nazov' => ['required'],
                'popis' => ['required'],
                'prefix' => ['required'],
            ]
        );

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 403);
        } else {

            $orderType = OrderType::create($request->all());

            return new OrderTypeResource($orderType);
        }
    }

    public function show(OrderType $orderType)
    {
           return new OrderTypeResource($orderType);

    }

    public function edit(OrderType $orderType)
    {
        //
    }

    public function update(Request $request, OrderType $orderType)
    {
        if ($orderType === null) {
            return response()->json(['error' => 'orderType not found'], 404);
        }

        $validator = Validator::make(
            $request->all(),
            [
                'nazov' => ['required'],
                'popis' => ['required'],
                'prefix' => ['required'],
            ]
        );

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 403);
        } else {
            $params = $request->all();
            $orderType->nazov = $params['nazov'];
            $orderType->popis = $params['popis'];
            $orderType->prefix = $params['prefix'];
            $orderType->icon = $params['icon'];
            $orderType->color = $params['color'];
            $orderType->save();
        }

        return new OrderTypeResource($orderType);
    }

    public function destroy(OrderType $orderType)
    {
        try {
            $orderType->delete();
        } catch (\Exception $ex) {
            response()->json(['error' => $ex->getMessage()], 403);
        }

        return response()->json(null, 204);
    }
}
