@extends('pagebuilder::components.element.edit')

@php
    // $formclass = \AscentCreative\PageBuilder\Forms\AudioSettings::class;
@endphp

@section('content')
    <x-files-fields-fileupload :value="$value->audio ?? ''" placeholder="" label="" wrapper="none" name="{{$path}}[audio]" 
        :accept="['audio/*']"
        />
@overwrite
