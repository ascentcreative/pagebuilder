@extends('pagebuilder::components.element.edit')

@section('content')
    <x-forms-fields-wysiwyg :value="$value->content ?? ''" :alwayson="false" placeholder="Enter some text" label="" wrapper="none" name="{{$path}}[content]" />
@overwrite