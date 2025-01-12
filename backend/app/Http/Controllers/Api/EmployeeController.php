<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Http\Resources\EmployeeResource;
use App\Http\Requests\EmployeeRequest;
use Illuminate\Http\Request;


class EmployeeController extends Controller
{

    public function index(Request $request)
    {
        $query = Employee::with('person')->whereHas('person', function($q) {
            $q->where('type', 'employee');
        });

        if ($request->has('position')) {
            $query->where('position', $request->position);
        }

        $employees = $query->paginate(15);

        return EmployeeResource::collection($employees);
    }

    public function store(EmployeeRequest $request)
    {
        $personData = $request->validated()['person'];
        $personData['type'] = 'employee';

        $person = Person::create($personData);

        $employee = $person->employee()->create($request->validated()['employee']);

        return new EmployeeResource($employee);
    }

    // Ďalšie CRUD metódy...
}
