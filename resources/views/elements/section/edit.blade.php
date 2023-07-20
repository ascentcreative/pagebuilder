@extends('pagebuilder::components.element.edit')

@php
    $formclass = \AscentCreative\PageBuilder\Forms\SectionSettings::class;
@endphp

@section('content')
    @include('pagebuilder::elements')
@overwrite