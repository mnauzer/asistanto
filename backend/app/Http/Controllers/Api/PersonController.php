<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Person;
use App\Http\Resources\PersonResource;
use App\Http\Requests\PersonRequest;
use Illuminate\Http\Request;

class PersonController extends Controller
{
    public function index(Request $request)
    {
        $query = Person::query();

        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        if ($request->has('is_active')) {
            $query->where('is_active', $request->boolean('is_active'));
        }

        $persons = $query->paginate(15);

        return PersonResource::collection($persons);
    }

    public function store(PersonRequest $request)
    {
        $person = Person::create($request->validated());

        return new PersonResource($person);
    }

    public function show(Person $person)
    {
        return new PersonResource($person);
    }

    public function update(PersonRequest $request, Person $person)
    {
        $person->update($request->validated());

        return new PersonResource($person);
    }

    public function destroy(Person $person)
    {
        $person->delete();

        return response()->noContent();
    }
}
