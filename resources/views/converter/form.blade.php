<?php
/**
 * Created by PhpStorm.
 * User: Amin
 * Date: 5/18/2019
 * Time: 10:19
 */
?>
@extends('layouts.main')
@section('content')

    <form >
        <div class="container ">

            <div class="">
                <div>
                    <label for="QuantitySelector" >کمیت</label>
                    <select class="form-control" name="quantity" id="QuantitySelector">
                        @foreach($quantities as $quantity=>$units)
                            @foreach($units as $unit=>$values)
                                <option name="{{ $unit }}" >{{ $unit }} - بدون عنوان </option>
                            @endforeach
                        @endforeach
                    </select>
                </div>

            </div>
            <hr>
            <div class=" ">

                <div class=" ">
                    تبدیل از
                    <input class="form-control">
                    <select name="first_unit" class="form-control">
                        <option>کیلو</option>
                        <option>گرم</option>
                    </select>
                </div>
                <hr>
                <div class=" ">
                    تبدیل به
                    <input class="form-control">
                    <select name="second_unit"   class="form-control">
                        <option>کیلو</option>
                        <option>گرم</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <button type="submit" class="btn btn-primary" >
                    تبدیل
                </button>
            </div>

        </div>
    </form>
@endsection
