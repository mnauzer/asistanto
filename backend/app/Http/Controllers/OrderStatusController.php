<?php

namespace App\Http\Controllers;

use App\OrderStatus;
use Illuminate\Http\Request;
use App\Http\Resources\OrderStatusResource;
use Validator;


class OrderStatusController extends Controller
{
    public function index()
    {
        return OrderStatusResource::collection(OrderStatus::all());
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
            ]
        );

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 403);
        } else {

            $orderStatus = OrderStatus::create($request->all());

            return new OrderStatusResource($orderStatus);
        }
    }

    public function show(OrderStatus $orderStatus)
    {
     return new OrderStatusResource($orderStatus);
    }

    public function edit(OrderStatus $orderStatus)
    {
        //
    }

    public function update(Request $request, OrderStatus $orderStatus)
    {
        if ($orderStatus === null) {
            return response()->json(['error' => 'orderStatus not found'], 404);
        }

        $validator = Validator::make(
            $request->all(),
            [
                'nazov' => ['required'],
                'popis' => ['required'],
            ]
        );

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 403);
        } else {
            $params = $request->all();
            $orderStatus->nazov = $params['nazov'];
            $orderStatus->popis = $params['popis'];
            $orderStatus->icon = $params['icon'];
            $orderStatus->color = $params['color'];
            $orderStatus->save();

        return new OrderStatusResource($orderStatus);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OrderStatus $orderStatus)
    {
        try {
            $orderStatus->delete();
        } catch (\Exception $ex) {
            response()->json(['error' => $ex->getMessage()], 403);
        }

        return response()->json(null, 204);
    }
}
