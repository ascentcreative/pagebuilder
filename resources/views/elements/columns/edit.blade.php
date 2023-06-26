@extends('pagebuilder::components.element.edit')

@php

    // if(count($value->e) == 0) {
    //     $value->e = [
    //         uniqid() => [
    //             't'=>'column',
    //         ],
    //         uniqid() => [
    //             't'=>'column',
    //         ]
    //     ];
    // }
    
@endphp

@section('content')
    @include('pagebuilder::elements', ['listtype'=>'columns'])
@overwrite