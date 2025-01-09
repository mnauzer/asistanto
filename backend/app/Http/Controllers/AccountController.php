<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Http\Resources\AccountResource;
use App\Account;

class AccountController extends Controller
{
    public function index()
    {
        $accounts = Account::all();

        return AccountResource::collection($accounts);
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
                // 'datum' => ['required'],
                // 'popis' => ['required'],
                // 'sadzba_dph' => ['required'],
                // 'suma_zakald' => ['required'],
                // 'suma_dph' => ['required'],
                // 'suma_celkom' => ['required'],
                // 'doklad' => ['required'],
                // 'ucto' => ['required'],
                // 'category_id' => ['required'],
                // 'subcategory_id' => ['required'],
                // 'account_id' => ['required'],
                // 'accountable_id' => ['required'],
                // 'accountable_type' => ['required'],
            ]
        );


        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 403);
        } else {

            $account = Account::create($request->all());
        }

        return new AccountResource($account);
    }

    public function show(Account $account)
    {
        return new AccountResource($account);
    }

    public function edit(Account $account)
    {
        //
    }
    public function update(Request $request, Account $account)
    {
        if ($account === null) {
            return response()->json(['error' => 'account not found'], 404);
        }

        $validator = Validator::make(
            $request->all(),
            [
      
            ]
        );

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 403);
        } else {
            $account->employee_id = $request->employee_id;
            $account->typ = $request->typ;
            $account->ucel  = $request->ucel;
            $account->nazov  = $request->nazov;
            $account->zostatok  = $request->zostatok;
            $account->prefix  = $request->prefix;
            $account->aktivny  = $request->aktivny;
            $account->icon  = $request->icon;
            $account->color  = $request->color;
            $account->color_text  = $request->color_text;
    
            $account->save();
        }

        return new AccountResource($account);
    }

    public function destroy(account $account)
    {
        try {
            $account->delete();
        } catch (\Exception $ex) {
            response()->json(['error' => $ex->getMessage()], 403);
        }

        return response()->json(null, 204);
    }
}
