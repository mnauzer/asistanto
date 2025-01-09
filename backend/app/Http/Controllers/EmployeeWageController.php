<?php

namespace App\Http\Controllers;

use App\EmployeeWage;
use Illuminate\Http\Request;
use App\Http\Resources\EmployeeWageResource;
use Validator;


class EmployeeWageController extends Controller
{
    public function index()
    {
         $employeeWages = EmployeeWage::all();
        return EmployeeWageResource::collection($employeeWages);
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
                'platnost' => ['required'],
                'sadzba' => ['required'],
                'employee_id' => ['required'],
            ]
        );

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 403);
        } else {

            $employeeWage = EmployeeWage::create($request->all());

         
        }
    }

    public function show(EmployeeWage $employeeWage)
    {
       return new EmployeeWageResource($employeeWage);
    }

    public function edit(EmployeeWage $employeeWage)
    {
        //
    }

    public function update(Request $request, EmployeeWage $employeeWage)
    {
        if ($employeeWage === null) {
            return response()->json(['error' => 'employeeWage not found'], 404);
        }
        else {
           
            $employeeWage->employee_id = $request->employee_id;
            $employeeWage->platnost = $request->platnost;
            $employeeWage->sadzba = $request->sadzba;
            $employeeWage->user_id = $request->user_id;
            $employeeWage->save();
            return new EmployeeWageResource($employeeWage);
        }
    }

    public function destroy(EmployeeWage $employeeWage)
    {
        try {
            $employeeWage->delete();
        } catch (\Exception $ex) {
            response()->json(['error' => $ex->getMessage()], 403);
        }

        return response()->json(null, 204);
    }
}
 