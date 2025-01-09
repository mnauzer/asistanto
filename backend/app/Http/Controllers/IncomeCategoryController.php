<?php

namespace App\Http\Controllers;

use App\IncomeCategory;
use Illuminate\Http\Request;
use App\Http\Resources\IncomeCategoryResource;
use Validator;


class IncomeCategoryController extends Controller
{ 
    public function index()
    {
        $incomeCategories = incomeCategory::all();
        return incomeCategoryResource::collection($incomeCategories);
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

            $incomeCategory = IncomeCategory::create($request->all());
        }

        return new IncomeCategoryResource($incomeCategory);
    }


    public function show(IncomeCategory $incomeCategory)
    {
        return new IncomeCategoryResource($incomeCategory);
    }

 
    public function edit(IncomeCategory $incomeCategory)
    {
        //
    }


    public function update(Request $request, IncomeCategory $incomeCategory)
    {
        if ($incomeCategory === null) {
            return response()->json(['error' => 'incomeCategory not found'], 404);
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

            $incomeCategory->nazov = $request->nazov;
            $incomeCategory->text = $request->text;
            $incomeCategory->model = $request->model;
            $incomeCategory->color = $request->color;
            $incomeCategory->color_text = $request->color_text;
            $incomeCategory->icon = $request->icon;
            $incomeCategory->save();
        }

        return new IncomeCategoryResource($incomeCategory);
    }

    public function destroy(IncomeCategory $incomeCategory)
    {
        try {
            $incomeCategory->delete();
        } catch (\Exception $ex) {
            response()->json(['error' => $ex->getMessage()], 403);
        }

        return response()->json(null, 204);
    }
}
