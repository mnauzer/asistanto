<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index()
    {
        $attendance = Attendance::with('employee')->get();
        return response()->json($attendance, 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'date' => 'required|date',
            'check_in' => 'required|date_format:H:i:s',
            'check_out' => 'nullable|date_format:H:i:s',
            'hours_worked' => 'nullable|numeric',
        ]);

        $attendance = Attendance::create($validated);
        return response()->json($attendance, 201);
    }

    public function show($id)
    {
        $attendance = Attendance::with('employee')->findOrFail($id);
        return response()->json($attendance, 200);
    }

    public function update(Request $request, $id)
    {
        $attendance = Attendance::findOrFail($id);

        $validated = $request->validate([
            'employee_id' => 'sometimes|exists:employees,id',
            'date' => 'sometimes|date',
            'check_in' => 'sometimes|date_format:H:i:s',
            'check_out' => 'nullable|date_format:H:i:s',
            'hours_worked' => 'nullable|numeric',
        ]);

        $attendance->update($validated);
        return response()->json($attendance, 200);
    }

    public function destroy($id)
    {
        $attendance = Attendance::findOrFail($id);
        $attendance->delete();
        return response()->json(['message' => 'Deleted'], 204);
    }
}
