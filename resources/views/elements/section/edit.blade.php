@extends('pagebuilder::components.element.edit')

@php
    $formclass = \AscentCreative\PageBuilder\Forms\SectionSettings::class;
@endphp

@section('content')
    {{-- <section style="display: flex; {{ $style }}">     --}}
        <div class="centralise">
            @include('pagebuilder::elements')
        </div>
    {{-- </section> --}}
@overwrite