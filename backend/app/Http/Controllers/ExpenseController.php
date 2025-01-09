<?php

namespace App\Http\Controllers;

use App\Expense;
use Illuminate\Http\Request;
use App\Http\Resources\ExpenseResource;
use Validator;



class ExpenseController extends Controller
{
    public function index()
    {
        $expenses = Expense::all();

        return ExpenseResource::collection($expenses);
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
                // 'expenseable_id' => ['required'],
                // 'expenseable_type' => ['required'],
            ]
        );


        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 403);
        } else {

            $expense = Expense::create($request->all());
        }

        return new ExpenseResource($expense);
    }

    public function show(Expense $expense)
    {
        return new ExpenseResource($expense);
    }

    public function edit(Expense $expense)
    {
        //
    }
    public function update(Request $request, Expense $expense)
    {
        if ($expense === null) {
            return response()->json(['error' => 'employeeWage not found'], 404);
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
            $expense->datum = $request->datun;
            $expense->popis = $request->popis;
            $expense->text = $request->text;
            $expense->sadzba_dph = $request->sadba_dph;
            $expense->suma_zakad = $request->suma_zakad;
            $expense->suma_dph = $request->suma_dph;
            $expense->suma_celkom = $request->suma_celkom;
            $expense->doklad = $request->doklad;
            $expense->ucto = $request->ucto;
            $expense->subcategory_id = $request->subcategory_id;
            $expense->account_id = $request->account_id;
            $expense->expenseable_id = $request->expenseable_id;
            $expense->expenseable_type = $request->expenseable_type;
            $expense->relateable_id = $request->relateable_id;
            $expense->relateable_type = $request->relateable_type;
            $expense->save();
        }

        return new ExpenseResource($expense);
    }

    public function destroy(Expense $expense)
    {
        try {
            $expense->delete();
        } catch (\Exception $ex) {
            response()->json(['error' => $ex->getMessage()], 403);
        }

        return response()->json(null, 204);
    }
}
