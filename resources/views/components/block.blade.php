@php
    $styles = collect($value->styles ?? []);
    // dump($styles);
    $style = $styles->transform(function($item, $key) {
        return str_replace("_", '-', $key) . ': ' . $item;
    })->join('; ');
@endphp

<div class="pb-element pb-block pb-block-{{ $template ?? 'empty' }}" style="position: relative;">
    <input type="hidden" name="{{ $name }}" />
    <input type="hidden" name="{{ $name }}[unid]" value="{{ $unid }}" />
    <input type="hidden" name="{{ $name }}[template]" value="{{ $template ?? 'empty' }}" />

    @if($template != 'empty')
        <div class="pb-element-label">
            <div class="d-flex">
                <span>{{ $template ?? '??' }}</span>
                {{-- <a href="#" class="bi-gear-fill pl-2"></a> --}}
                <a href="#" class="pbb-delete bi-trash pl-2"></a>
                {{-- <a href="#" class="bi-arrows-move pl-2"></a> --}}
            </div>
        </div>
    @endif

    {{-- @dump($value) --}}
    @includeFirst( array_merge( pagebuilderbladePaths($template, 'edit'), ['pagebuilder::block.missing']), ['template'=>$template])

    <div class="pb-element-settings">

        {{-- <x-forms-fields-input name="{{$name}}[styles][padding_top]" label="Padding Top" type="text" value="{{ $value->styles->padding_top ?? '50px' }}"/>
        <x-forms-fields-input name="{{$name}}[styles][padding_bottom]" label="Padding Bottom" type="text" value="{{ $value->styles->padding_bottom ?? '50px' }}"/> --}}

    </div>
    
</div>

