@extends('pagebuilder::components.element.show')

@section('content')
    {{ embedVideo( $value->video ) }}
@overwrite