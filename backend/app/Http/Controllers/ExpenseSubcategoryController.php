<?php

namespace App\Http\Controllers;

use App\ExpenseSubcategory;
use Illuminate\Http\Request;
use App\Http\Resources\ExpenseSubcategoryResource;
use Validator;

class ExpenseSubcategoryController extends Controller
{
    public function index()
    {
        $expenseSubcategories = ExpenseSubcategory::all();
        return ExpenseSubcategoryResource::collection($expenseSubcategories);
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

            $expenseSubcategory = ExpenseSubcategory::create($request->all());
        }

        return new ExpenseSubcategoryResource($expenseSubcategory);
    }

    public function show(ExpenseSubcategory $expenseSubcategory)
    {
        return new ExpenseSubcategoryResource($expenseSubcategory);
    }

    public function edit(ExpenseSubcategory $expenseSubcategory)
    {
        //
    }

    public function update(Request $request, ExpenseSubcategory $expenseSubcategory)
    {
        if ($expenseSubcategory === null) {
            return response()->json(['error' => 'subcategoria not found'], 404);
        }

        $validator = Validator::make(
            $request->all(),
            [
                'nazov' => ['required'],
                'text' => ['required'],
                'category_id' => ['required'],
                'model' => ['required'],
            ]
        );

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 403);
        } else {

            $expenseSubcategory->nazov = $request->nazov;
            $expenseSubcategory->text = $request->text;
            $expenseSubcategory->model = $request->model;
            $expenseSubcategory->category_id = $request->category_id;
            $expenseSubcategory->color = $request->color;
            $expenseSubcategory->color_text = $request->color_text;
            $expenseSubcategory->icon = $request->icon;
            $expenseSubcategory->save();
        }

        return new ExpenseSubcategoryResource($expenseSubcategory);
    }

    public function destroy(ExpenseSubcategory $expenseSubcategory)
    {
        try {
            $expenseSubcategory->delete();
        } catch (\Exception $ex) {
            response()->json(['error' => $ex->getMessage()], 403);
        }

        return response()->json(null, 204);
    }
}
