@extends('pagebuilder::components.element.edit')

@php
    // dump($value);
    if(is_null($value->e)) { // || (is_array($value->e) && count($value->e) == 0)) {
        $value->e = [
            uniqid() => [
                't'=>'column',
            ],
            uniqid() => [
                't'=>'column',
            ]
        ];
    }

@endphp

@section('content')
    {{-- @dd($value) --}}
    @include('pagebuilder::elements', ['listtype'=>'columns'])
@overwrite