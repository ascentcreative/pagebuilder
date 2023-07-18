@extends('pagebuilder::components.element.show')

@section('content')
    {!! $value->code ?? '' !!}
@overwrite