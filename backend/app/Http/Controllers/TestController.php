<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employee;
use App\EmployeeWage;
use App\Workhour;
use App\Job;

class TestController extends Controller
{
   
   public function index(){

       $value = Wor::first();
    
        $value =  $value->employee_wages;

       return $value;
    
   }
}
