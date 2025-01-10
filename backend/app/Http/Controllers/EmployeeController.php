<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::all();
        return response()->json($employees, 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_number' => 'required|unique:employees,employee_number',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'nickname' => 'required|unique:employees,nickname',
            'position' => 'required|in:manager,employee,intern,external',
            'is_active' => 'boolean',
            'address_id' => 'nullable|integer',
        ]);

        $employee = Employee::create($validated);
        return response()->json($employee, 201);
    }

    public function show($id)
    {
        $employee = Employee::findOrFail($id);
        return response()->json($employee, 200);
    }

    public function update(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);

        $validated = $request->validate([
            'employee_number' => 'sometimes|unique:employees,employee_number,' . $id,
            'first_name' => 'sometimes|string|max:255',
            'last_name' => 'sometimes|string|max:255',
            'nickname' => 'sometimes|unique:employees,nickname,' . $id,
            'position' => 'sometimes|in:manager,employee,intern,external',
            'is_active' => 'boolean',
            'address_id' => 'nullable|integer',
        ]);

        $employee->update($validated);
        return response()->json($employee, 200);
    }

    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->delete();
        return response()->json(['message' => 'Deleted'], 204);
    }
}
