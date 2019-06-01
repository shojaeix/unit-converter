<?php

namespace App\Http\Controllers;

use App\Helpers\ConvertHelper;
use Illuminate\Http\Request;

class ConvertController extends Controller
{
    function form(){

        $quantities = ConvertHelper::getQuantities();
        return view('converter.form', [
            'quantities' => $quantities,

        ]);
    }
}
