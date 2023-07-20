@extends('pagebuilder::components.element.edit')

@php
    $formclass = \AscentCreative\PageBuilder\Forms\ImageSettings::class;
@endphp

@section('content')
    @if($value->image->hashed_filename ?? false)
        <img src="/image/max/{{ $value->image->hashed_filename }}" class="preview image-element" style="{{ $inner_style ?? '' }}"/>
    @endif
    <x-files-fields-fileupload :value="$value->image ?? ''" placeholder="" label="" wrapper="none" name="{{$path}}[image]" />
@overwrite
