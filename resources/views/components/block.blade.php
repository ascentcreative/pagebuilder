@php
    $styles = collect($value->styles ?? []);
    // dump($styles);
    $style = $styles->transform(function($item, $key) {
        return str_replace("_", '-', $key) . ': ' . $item;
    })->join('; ');
@endphp


<div class="pb-element pb-block" style="position: relative; border: 1px dashed rgba(0,0,0,0.1)">

    <div class="pb-element-label">
        <div class="d-flex">
            <span>Page Header</span>
            <a href="#" class="bi-gear-fill pl-2"></a>
            <a href="#" class="bi-trash pl-2"></a>
            <a href="#" class="bi-arrows-move pl-2"></a>
        </div>
    </div>

    {{-- @dump($value); --}}
    <x-forms-fields-wysiwyg :value="$value->content ?? ''" label="" wrapper="none" name="{{$name}}[content]" />


    <div class="pb-element-settings">

        <x-forms-fields-input name="{{$name}}[styles][padding_top]" label="Padding Top" type="text" value="{{ $value->styles->padding_top ?? '50px' }}"/>
        <x-forms-fields-input name="{{$name}}[styles][padding_bottom]" label="Padding Bottom" type="text" value="{{ $value->styles->padding_bottom ?? '50px' }}"/>

    </div>
    
</div>

