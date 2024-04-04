@extends('pagebuilder::components.element.show')

@section('content')

    @php    
        $url = $value->link ?? "#";

        if($value->file) {
            $url = route('pagebuilder.file.download', ['hash'=>$value->file->hashed_filename, 'target'=>$value->file->original_filename]);
        } 
    @endphp

    <a href="{{ $url }}" class="btn" id="elm-{{ $unid }}-inner">{{ $value->label ?? 'BUTTON TEXT' }}</a>

@overwrite