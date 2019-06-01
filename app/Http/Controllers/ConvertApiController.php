<?php

namespace App\Http\Controllers;

use App\Helpers\ConvertHelper;
use App\Helpers\ConvertorEx;
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
        return ConvertHelper::getQuantities();
    }

    function getCompatibleUnits($unit){
        $quantities = ConvertHelper::getQuantities();
        /*
         از آنجایی که آرایه واحد های اندازه گیری، بر اساس کمیت دسته بندی شده است
         واحد $unit در هر دسته بندی ای که باشد،‌ با کل آن دسته بندی سازگار است
         */
        foreach ($quantities as $values){
            if(in_array($unit, array_keys($values)))
                return $values;
        }
        return [];
    }

    function convert(Request $request)
    {
        // validate inputs
        $parameters = request()->validate([
            'quantity' => 'required',
            'first_unit' => 'required',
            'second_unit' => 'required',
            'value' => 'required|numeric',
        ]);
        $successful = false;
        // convert values
        try {
            $converter = new Convertor($parameters['value'], $parameters['first_unit']);
            $convertedValue = $converter->to($parameters['second_unit']);
            $successful = true;
        } catch(ConvertorInvalidUnitException $exception){
            $errorDescription = 'واحد های وارد شده نامعتبر هستند.';
        } catch(ConvertorDifferentTypeException $exception){
            $errorDescription = 'واحد های وارد شده از کمیت های مختلف هستند.';
        }
        // create result array
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
