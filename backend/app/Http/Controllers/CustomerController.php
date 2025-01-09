<?php

namespace App\Http\Controllers;

use App\Customer;
use Illuminate\Http\Request;
use App\Http\Resources\CustomerResource;
use Validator;

class CustomerController extends Controller
{

    public function index()
    {
        return CustomerResource::collection(Customer::all());
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
                'alias' => ['required','unique:customers'],
            ]
        );

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 403);
        } else {

            $customer = Customer::create($request->all());

            return new CustomerResource($customer);
        }
    }

    public function show(Customer $customer)
    {
         return new CustomerResource($customer);
    }

    public function edit(Customer $customer)
    {
        //
    }

    public function update(Request $request, Customer $customer)
    {
             if ($customer === null) {
            return response()->json(['error' => 'customer not found'], 404);
        }
        else {
           
            $customer->alias = $request->alias;
            $customer->meno = $request->meno;
            $customer->priezvisko = $request->priezvisko;
            $customer->titul = $request->titul;
            $customer->firma_nazov = $request->firma_nazov;
            $customer->poznamka = $request->poznamka;
            $customer->aktivny = $request->aktivny;
            $customer->fo = $request->fo;
            $customer->user_id = $request->user_id;
            $customer->save();
            return new CustomerResource($customer);
        }
    }

    public function destroy(Customer $customer)
    {
        try {
            $customer->delete();
        } catch (\Exception $ex) {
            response()->json(['error' => $ex->getMessage()], 403);
        }

        return response()->json(null, 204);
    }
}
