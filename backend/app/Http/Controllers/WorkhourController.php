<?php

namespace App\Http\Controllers;

use App\Workhour;
use Illuminate\Http\Request;
use App\Http\Resources\WorkhourResource;
use Validator;

class WorkhourController extends Controller
{
    public function index()
    {
        $workhours = Workhour::orderBy('datum', 'desc')->Paginate(15);

        return WorkhourResource::collection($workhours);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        error_log($request);
        $validator = Validator::make(
            $request->all(),
            [
                'datum' => ['required'],
                'zaciatok' => ['required'],
                'koniec' => ['required'],
                'employee_id' => ['required'],
            ]
        );

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 403);
        } else{
            if (is_array($request->employee_id)) {
                foreach ($request->employee_id as $employee) {
                    $workhour = Workhour::create([
                        'datum' => $request->datum,
                        'zaciatok' => $request->zaciatok,
                        'koniec' => $request->koniec,
                        'poznamka' => $request->poznamky,
                        'employee_id' => $employee
                    ]);
                }
            } else {
                $workhour = Workhour::create($request->all());
            }

            return new WorkhourResource($workhour);
        }
    }
  
    public function show(Workhour $workhour)
    {
        return new WorkhourResource($workhour);
    }

    public function edit(Workhour $workhour)
    {
        //
    }

    public function update(Request $request, Workhour $workhour)
    {
        if ($workhour === null) {
            return response()->json(['error' => 'workhour not found'], 404);
        }

        $validator = Validator::make(
            $request->all(),
            [
                'datum' => ['required'],
                'zaciatok' => ['required'],
                'koniec' => ['required'],
                'employee_id' => ['required'],
            ]
        );

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 403);
        } else {

            $workhour->datum = $request->datum;
            $workhour->zaciatok = $request->zaciatok;
            $workhour->koniec = $request->koniec;
            $workhour->employee_id = $request->employee_id;
            $workhour->poznamka = $request->poznamka;
            $workhour->save();
        }

        return new WorkhourResource($workhour);
    }

    public function destroy(Workhour $workhour)
    {
        try {
            $workhour->delete();
        } catch (\Exception $ex) {
            response()->json(['error' => $ex->getMessage()], 403);
        }
        return response()->json(null, 204);
    }
}
