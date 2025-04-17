@extends('pagebuilder::components.element.show')

@section('content')
    {{-- Audio Player Here... --}}
    {{-- @dump($value) --}}
    <audio src="{{ route('file.stream', ['file'=>$value->audio->hashed_filename]) }}" controls controlsList="nodownload"></audio>
    {{-- {{ embedVideo( $value->video ) }} --}}
@overwrite