<?php

namespace App\Http\Controllers;

use App\Job;
use Illuminate\Http\Request;
use App\Http\Resources\JobResource;
use Validator;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jobs = Job::orderBy('datum', 'desc')->Paginate(15);

        return JobResource::collection($jobs);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'datum' => ['required'],
                'zaciatok' => ['required'],
                'koniec' => ['required'],
                'employee_id' => ['required'],
                'order_id' => ['required'],
                'popis' => ['required'],
            ]
        );

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 403);
        } else {

                $job = Job::create([
                    'datum' => $request->datum,
                    'zaciatok' => $request->zaciatok,
                    'koniec' => $request->koniec,
                    'employee_id' => $request->employee_id,
                    'order_id' => $request->order_id,
                    'popis' => $request->popis

                ]);
            return new JobResource($job);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Job $job)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Job $job)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Job $job)
    {
        if ($job === null) {
            return response()->json(['error' => 'job not found'], 404);
        }

        $validator = Validator::make(
            $request->all(),
            [
                'datum' => ['required'],
                'zaciatok' => ['required'],
                'koniec' => ['required'],
                'employee_id' => ['required'],
                'order_id' => ['required'],
                'popis' => ['required'],
            ]
        );

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 403);
        } else {
            $params = $request->all();
            $job->datum = $params['datum'];
            $job->zaciatok = $params['zaciatok'];
            $job->koniec = $params['koniec'];
            $job->employee_id = $params['employee_id'];
            $job->order_id = $params['order_id'];
            $job->popis = $params['popis'];
            $job->save();
        }

        return new JobResource($job);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Job $job)
    {
        try {
            $job->delete();
        } catch (\Exception $ex) {
            response()->json(['error' => $ex->getMessage()], 403);
        }

        return response()->json(null, 204);
    }
}
