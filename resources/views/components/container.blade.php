@php
    $styles = collect($value->styles ?? []);
    // dump($styles);

    if(isset($styles['background_image'])) {
        $img = \AscentCreative\CMS\Models\File::find($styles['background_image']);
        $styles['background_image'] = "url('/storage/" . $img->filepath . "')";
    }

    $style = $styles->transform(function($item, $key) {
        return str_replace("_", '-', $key) . ': ' . $item;
    })->join('; ');


     // add the container_layout styles
    $layout = $getLayout();
    $contentstyles = [];


    if(isset($layout['grid-template-columns'])) {
        $contentstyles['display'] = 'grid';
        $contentstyles['gap'] = '1rem';
        $contentstyles['grid-template-columns'] = $layout['grid-template-columns']['lg'];
    }

    $contentstyle = collect($contentstyles)->transform(function($item, $key) {
        return str_replace("_", '-', $key) . ': ' . $item;
    })->join('; ');

@endphp


<div class="pb-element pb-container centralise" style="padding: 5px; xmargin: 0px auto; 
                    position: relative; {{ $style }}">

    <input type="hidden" class="pb-container-unid" name="{{ $name }}[unid]" value="{{ $unid }}" />

    <div class="pb-element-label">
        <div class="d-flex">
            <span>Container</span>
            <a href="#" class="pbc-settings bi-gear-fill pl-2"></a>
            {{-- <a href="#" class="pbc-split bi-layout-split pl-2"></a> --}}
        </div>
    </div>

    {{-- @dump($value) --}}

    <div class="pb-element-content pb-content-grid {{ $getLayoutClass }}" xstyle="{{ $contentstyle }}">

        @php $blockcount = 0; @endphp
        @isset($value->blocks)
            @php $blockcount = count((array) $value->blocks); @endphp
            @foreach($value->blocks as $unid=>$block)
            {{-- @for($iCol = 0; $iCol < $getLayout()['columns']; $iCol++) --}}

                {{-- @isset($value->blocks[$iCol]) --}}
                    <x-pagebuilder-block fieldname="{{ $name }}" :row="$pb_row_unid" :container="$pb_container_unid" :value="$block ?? []">

                    </x-pagebuilder-block>
                {{-- @else  --}}
                    {{-- <div class="pb-block-empty bg-light" style="xheight: 300px"> --}}
                        {{-- EMPTY BLOCK --}}
                        {{-- <input name="{{$name}}[blocks][{{ $iCol }}][template]" value="text"/> --}}
                    {{-- </div>  --}}
                {{-- @endisset --}}

            {{-- @endfor --}}
            @endforeach
        @endisset

        @if($blockcount < $getLayout()['columns']) 
            {{-- Top up with empty blocks: --}}
            @for($iTopUp = 0; $iTopUp < ($getLayout()['columns'] - $blockcount); $iTopUp++)
                <x-pagebuilder-block fieldname="{{ $name }}">

                </x-pagebuilder-block>
            @endfor
        @endif
            
        {{-- {{ $slot }} --}}

        {{-- --}}

    </div>
{{-- 
    @dd( collect(config('pagebuilder.container_layouts'))->mapWithKeys(function($item, $key) {
        return [ $key => $item['title'] ];
    })->toArray()
) --}}
    {{-- @dump() --}}

    <div class="pb-element-settings">

        

        {{-- NB - not a FORM modal as the form start and end tags interfere with the submission of updated values. --}}
        <x-cms-modal modalid="form-modal" 
            title="Container Settings"
        >
            {{-- Only render the form body (fields etc) as it's really a subform --}}
            @formbody(\AscentCreative\PageBuilder\Forms\ContainerSettings::make($name, $value))

            <x-slot name="footer">
                <button class="button btn btn-secondary btn-cancel" data-dismiss="modal">Cancel</button>
                <button class="button btn btn-primary btn-ok">OK</button>
            </x-slot>

        </x-cms-modal>

    </div>

    
        
</div>
