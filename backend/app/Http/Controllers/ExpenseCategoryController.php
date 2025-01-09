<?php

namespace App\Http\Controllers;

use App\ExpenseCategory;
use Illuminate\Http\Request;
use App\Http\Resources\ExpenseCategoryResource;
use Validator;


class ExpenseCategoryController extends Controller
{ 
    public function index()
    {
        $expenseCategories = ExpenseCategory::all();
        return ExpenseCategoryResource::collection($expenseCategories);
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
                'text' => ['required'],
                'model' => ['required'],
            ]
        );


        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 403);
        } else {

            $expenseCategory = ExpenseCategory::create($request->all());
        }

        return new ExpenseCategoryResource($expenseCategory);
    }


    public function show(ExpenseCategory $expenseCategory)
    {
        return new ExpenseCategoryResource($expenseCategory);
    }

 
    public function edit(ExpenseCategory $expenseCategory)
    {
        //
    }


    public function update(Request $request, ExpenseCategory $expenseCategory)
    {
        if ($expenseCategory === null) {
            return response()->json(['error' => 'employeeWage not found'], 404);
        }

        $validator = Validator::make(
            $request->all(),
            [
                'nazov' => ['required'],
                'text' => ['required'],
                'model' => ['required'],
            ]
        );

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 403);
        } else {

            $expenseCategory->nazov = $request->nazov;
            $expenseCategory->text = $request->text;
            $expenseCategory->model = $request->model;
            $expenseCategory->color = $request->color;
            $expenseCategory->icon = $request->icon;
            $expenseCategory->color_text = $request->color_text;
            $expenseCategory->save();
        }

        return new ExpenseCategoryResource($expenseCategory);
    }

    public function destroy(ExpenseCategory $expenseCategory)
    {
        try {
            $expenseCategory->delete();
        } catch (\Exception $ex) {
            response()->json(['error' => $ex->getMessage()], 403);
        }

        return response()->json(null, 204);
    }
}
