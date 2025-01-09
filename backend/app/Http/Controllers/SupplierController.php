<?php

namespace App\Http\Controllers;

use App\Supplier;
use Illuminate\Http\Request;
use App\Http\Resources\SupplierResource;
use Validator;


class SupplierController extends Controller
{

    public function index()
    {
        return SupplierResource::collection(Supplier::all());
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
                'alias' => ['required','unique:suppliers'],
            ]
        );

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 403);
        } else {

            $supplier = Supplier::create($request->all());

            return new SupplierResource($supplier);
        }
    }


    public function show(Supplier $supplier)
    {
             return new SupplierResource($supplier);

    }


    public function edit(Supplier $supplier)
    {
        //
    }


    public function update(Request $request, Supplier $supplier)
    {
                if ($supplier === null) {
            return response()->json(['error' => 'supplier not found'], 404);
        }
        else {
           
            $supplier->alias = $request->alias;
            $supplier->meno = $request->meno;
            $supplier->priezvisko = $request->priezvisko;
            $supplier->titul = $request->titul;
            $supplier->firma_nazov = $request->firma_nazov;
            $supplier->poznamka = $request->poznamka;
            $supplier->aktivny = $request->aktivny;
            $supplier->fo = $request->fo;
            $supplier->user_id = $request->user_id;
            $supplier->save();
            return new SupplierResource($supplier);
        }
    }
    

    public function destroy(Supplier $supplier)
    {
             try {
            $supplier->delete();
        } catch (\Exception $ex) {
            response()->json(['error' => $ex->getMessage()], 403);
        }

        return response()->json(null, 204);
    }
}
