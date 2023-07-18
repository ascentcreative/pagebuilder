@extends('pagebuilder::components.element.edit')

@php
    $formclass = \AscentCreative\PageBuilder\Forms\ThirdPartyCodeSettings::class;
@endphp

@section('content')
    
    {!! $value->code ?? '[No Code Entered]' !!}

@overwrite
