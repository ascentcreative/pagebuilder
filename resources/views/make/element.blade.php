@php
    $unid = uniqid();
    $element = [
        't'=>request()->type,
        'e'=>null,
    ];
@endphp
<x-pagebuilder-element path="new" :unid="$unid" :value="(object) $element"></x-pagebuilder-element>