<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function register(Request $request){

        dd($request->all());    
    }
    
}