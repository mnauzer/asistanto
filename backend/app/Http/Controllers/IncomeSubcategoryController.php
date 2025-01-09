<?php

namespace App\Http\Controllers;

use App\IncomeSubcategory;
use Illuminate\Http\Request;
use App\Http\Resources\SubcategoryResource;
use Validator;


class IncomeSubcategoryController extends Controller
{

    public function index()
    {
        $expenseSubcategories = incomeSubcategory::all();
        return SubcategoryResource::collection($expenseSubcategories);
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

            $incomeSubcategory = IncomeSubcategory::create($request->all());
        }

        return new SubcategoryResource($incomeSubcategory);
    }

    public function show(IncomeSubcategory $incomeSubcategory)
    {
        return new SubcategoryResource($incomeSubcategory);
    }


    public function edit(IncomeSubcategory $incomeSubcategory)
    {
        //
    }


    public function update(Request $request, IncomeSubcategory $incomeSubcategory)
    {
   if ($incomeSubcategory === null) {
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

            $incomeSubcategory->nazov = $request->nazov;
            $incomeSubcategory->text = $request->text;
            $incomeSubcategory->model = $request->model;
            $incomeSubcategory->category_id = $request->category_id;
            $incomeSubcategory->color = $request->color;
            $incomeSubcategory->color_text = $request->color_text;
            $incomeSubcategory->icon = $request->icon;
            $incomeSubcategory->save();
        }

        return new SubcategoryResource($incomeSubcategory);
    }

    public function destroy(IncomeSubcategory $incomeSubcategory)
    {
          try {
            $incomeSubcategory->delete();
        } catch (\Exception $ex) {
            response()->json(['error' => $ex->getMessage()], 403);
        }

        return response()->json(null, 204);
    }
}
