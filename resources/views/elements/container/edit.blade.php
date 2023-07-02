@extends('pagebuilder::components.element.edit')

@php
    $formclass = \AscentCreative\PageBuilder\Forms\ContainerSettings::class;
@endphp

@section('content')
    @include('pagebuilder::elements')
@overwrite