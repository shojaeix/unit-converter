<?php
/**
 * Created by PhpStorm.
 * User: Amin
 * Date: 5/19/2019
 * Time: 16:42
 */

namespace App\Helpers;


use Olifolkerd\Convertor\Convertor;

class ConvertHelper
{
    public static function getQuantities(){
        $quantities = [];
        $convertor = new Convertor;
        $units = $convertor->getAllUnits();
        foreach ($units as $key=>$values){
            if(!isset($quantities[$values['base']])) $quantities[$values['base']] = [];

            $quantities[$values['base']][$key] = $values;
        }

        return $quantities;
    }
}