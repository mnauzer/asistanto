<?php

namespace App\Http\Controllers;

use App\Employee;
use Illuminate\Http\Request;
use App\Http\Resources\EmployeeResource;
use Validator;

class EmployeeController extends Controller
{
    public function index()
    {

        return EmployeeResource::collection(Employee::all());
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
                'alias' => ['required','unique:employees'],
                'meno' => ['required'],
                'priezvisko' => ['required'],
                'zaradenie' => ['required'],
            ]
        );

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 403);
        } else {

            $employee = Employee::create($request->all());

            return new EmployeeResource($employee);
        }
    }

    public function show(Employee $employee)
    {
        return new EmployeeResource($employee);
    }

    public function edit(Employee $employee)
    {
        //
    }

    public function update(Request $request, Employee $employee)
    {
              if ($employee === null) {
            return response()->json(['error' => 'employee not found'], 404);
        }
        else {
           
            $employee->alias = $request->alias;
            $employee->meno = $request->meno;
            $employee->priezvisko = $request->priezvisko;
            $employee->zaradenie = $request->zaradenie;
            $employee->poznamka = $request->poznamka;
            $employee->aktivny = $request->aktivny;
            $employee->user_id = $request->user_id;
            $employee->save();
            return new EmployeeResource($employee);
        }
    }

    public function destroy(Employee $employee)
    {
        try {
            $employee->delete();
        } catch (\Exception $ex) {
            response()->json(['error' => $ex->getMessage()], 403);
        }

        return response()->json(null, 204);
    }
}
