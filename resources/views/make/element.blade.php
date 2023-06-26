@php
    $unid = uniqid();
    $element = [
        't'=>request()->type,
        'e'=>[
            uniqid()=> (object) [
                uniqid() =>  (object) [
                    't'=>'text',
                    'content' => "Lorem",
                ]
            ]
        ],
    ];
@endphp
<x-pagebuilder-element path="new" :unid="$unid" :value="(object) $element"></x-pagebuilder-element>