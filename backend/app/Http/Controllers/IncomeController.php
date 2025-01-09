<?php

namespace App\Http\Controllers;

use App\Income;
use Illuminate\Http\Request;
use App\Http\Resources\IncomeResource;
use Validator;

class IncomeController extends Controller
{
    public function index()
    {
        $incomes = Income::all();

        return IncomeResource::collection($incomes);
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
                // 'datum' => ['required'],
                // 'popis' => ['required'],
                // 'sadzba_dph' => ['required'],
                // 'suma_zakald' => ['required'],
                // 'suma_dph' => ['required'],
                // 'suma_celkom' => ['required'],
                // 'doklad' => ['required'],
                // 'ucto' => ['required'],
                // 'category_id' => ['required'],
                // 'subcategory_id' => ['required'],
                // 'account_id' => ['required'],
                // 'incomeable_id' => ['required'],
                // 'incomeable_type' => ['required'],
            ]
        );


        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 403);
        } else {

            $income = Income::create($request->all());
        }

        return new IncomeResource($income);
    }

    public function show(Income $income)
    {
        return new IncomeResource($income);
    }

    public function edit(Income $income)
    {
        //
    }
    public function update(Request $request, Income $income)
    {
        if ($income === null) {
            return response()->json(['error' => 'income not found'], 404);
        }

        $validator = Validator::make(
            $request->all(),
            [
                'datum' => ['required'],
            ]
        );

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 403);
        } else {
            $income->datum = $request->datun;
            $income->popis = $request->popis;
            $income->text = $request->text;
            $income->sadzba_dph = $request->sadba_dph;
            $income->suma_zakad = $request->suma_zakad;
            $income->suma_dph = $request->suma_dph;
            $income->suma_celkom = $request->suma_celkom;
            $income->doklad = $request->doklad;
            $income->ucto = $request->ucto;
            $income->category_id = $request->category_id;
            $income->subcategory_id = $request->subcategory_id;
            $income->account_id = $request->account_id;
            $income->incomeable_id = $request->incomeable_id;
            $income->incomeable_type = $request->incomeable_type;
            $income->related_id = $request->related_id;
            $income->related_type = $request->related_type;
            $income->save();
        }

        return new IncomeResource($income);
    }

    public function destroy(Income $income)
    {
        try {
            $income->delete();
        } catch (\Exception $ex) {
            response()->json(['error' => $ex->getMessage()], 403);
        }

        return response()->json(null, 204);
    }
}
