@extends('pagebuilder::components.element.edit')

@php
    // $formclass = \AscentCreative\PageBuilder\Forms\VideoSettings::class;
@endphp

@section('content')
    <x-cms-form-videoembed label="" name="{{ $path }}[video]" value="{!! isset($value->video) ? $value->video : '' !!} " wrapper="none"></x-cms-form-videoembed>
@overwrite
