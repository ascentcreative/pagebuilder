@extends('pagebuilder::components.element.edit')

@php
    $formclass = \AscentCreative\PageBuilder\Forms\ImageSettings::class;
@endphp

@section('content')
    <div class="image-element" style="{{ $style }}">
        <div class="image-element-image">
            @if($value->image->hashed_filename ?? false)
                <img src="/image/max/{{ $value->image->hashed_filename }}" class="preview"/>
            @endif
        </div>
        <x-files-fields-fileupload :value="$value->image ?? ''" placeholder="Enter some text" label="" wrapper="none" name="{{$path}}[image]" />
    </div>
@overwrite

{{-- @once
    @push('styles')
        @style('/vendor/ascent/pagebuilder/css/ascent-pagebuilder-imageelement.css')
    @endpush

    @push('scripts')
        @script('/vendor/ascent/pagebuilder/js/ascent-pagebuilder-imageelement.js')
    @endpush

@endonce --}}

@push('scripts')
    
@endpush 