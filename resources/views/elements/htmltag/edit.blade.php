@extends('pagebuilder::components.element')

@section('content')
    <x-forms-fields-wysiwyg :value="$value->content ?? ''" placeholder="Enter some text" label="" wrapper="none" name="{{$path}}[content]" />
@overwrite