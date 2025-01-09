<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;
use App\Http\Resources\OrderResource;

use Validator;

class OrderController extends Controller
{
    public function index()
    {
        return OrderResource::collection(Order::all());
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
                'cislo' => ['required', 'unique:orders'],
                'nazov' => ['required'],
                'popis' => ['required'],
            ]
        );

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 403);
        } else {

            $order = Order::create($request->all());

            return new OrderResource($order);
        }
    }

    public function show(Order $order)
    {
             return new OrderResource($order);
    }

    public function edit(Order $order)
    {
        //
    }

    public function update(Request $request, Order $order)
    {
      if ($order === null) {
            return response()->json(['error' => 'order not found'], 404);
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
          
            $order->cislo = $request->cislo;
            $order->alias = $request->alias;
            $order->nazov = $request->nazov;
            $order->popis = $request->popis;
            $order->datum = $request->datum;
            $order->zacatie = $request->zacatie;
            $order->ukoncenie = $request->ukoncenie;
            $order->sadzba_dph = $request->sadzba_dph;
            $order->suma_zaklad = $request->suma_zaklad;
            $order->suma_dph = $request->suma_dph;
            $order->suma_celkom = $request->suma_celkom;
            $order->poznamka = $request->poznamka;
            $order->miesto = $request->miesto;
            $order->vzdialenost = $request->vzdialenost;
            $order->uctovanie_typ = $request->uctovanie_typ;
            $order->uctovanie_dopravy = $request->uctovanie_dopravy;
            $order->customer_id = $request->customer_id;
            $order->type_id = $request->type_id;
            $order->status_id = $request->status_id;
            $order->save(); 

        return new OrderResource($order);
        }

    }


    public function destroy(Order $order)
    {
        try {
            $order->delete();
        } catch (\Exception $ex) {
            response()->json(['error' => $ex->getMessage()], 403);
        }

        return response()->json(null, 204);
    }
}
