<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Olifolkerd\Convertor\Convertor;
use Olifolkerd\Convertor\Exceptions\ConvertorDifferentTypeException;
use Olifolkerd\Convertor\Exceptions\ConvertorInvalidUnitException;

class ConvertApiController extends Controller
{
    protected $quantities = [
        'weight' => [
            'title' => "وزن",
            'units' => [
                'Ton' => 'تن',
                'kg' => 'کیلوگرم',
            ]
        ],
        'force' => [
            'title' => "نیرو",
            'units' => [
                'N' => 'نیوتن',
                'gf' => 'گرم-نیرو',
            ]
        ],
    ];

    function getQuantities()
    {
        return $this->quantities;
    }

    function convert(Request $request)
    {
        $parameters = request()->validate([
            'quantity' => 'required',
            'first_unit' => 'required',
            'second_unit' => 'required',
            'value' => 'required|numeric',
        ]);

        $successful = false;
        try {
            $converter = new Convertor($parameters['value'], $parameters['first_unit']);
            $convertedValue = $converter->to($parameters['second_unit']);
            $successful = true;
        } catch(ConvertorInvalidUnitException $exception){
            $errorDescription = 'واحد های وارد شده نامعتبر هستند.';
        } catch(ConvertorDifferentTypeException $exception){
            $errorDescription = 'واحد های وارد شده از کمیت های مختلف هستند.';
        }


        $result = [
            'successful' => $successful,
        ];
        if($successful) {
            $result['result'] = $convertedValue;
            $result['formula'] = 'دودوتا چهار تا';
        } else {
            $result['error_description'] = $errorDescription;
        }
        // array will encode automatically
        return $result;
    }
}
