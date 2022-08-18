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

@endphp

<div class="pb-element pb-row" style="border: 1px solid rgba(0,0,0,0.1); position: relative; {{ $style }}">

    <input type="hidden" name="{{ $name }}[unid]" value="{{ $value->unid ?? uniqid() }}" />

    <div class="pb-element-label">
        <div class="d-flex">
            <span>Row</span>
            <a href="#" class="pbr-settings bi-gear-fill pl-2"></a>
            <a href="#" class="pbr-delete bi-trash pl-2"></a>
            <span class="row-drag bi-arrows-move pl-2"></a>
        </div>
    </div>

    
    {{ $slot }}


    <div class="pb-element-settings">

        {{-- NB - not a FORM modal as the form start and end tags interfere with the submission of updated values. --}}
        <x-cms-modal modalid="form-modal" 
            title="Row Settings"
        >
            {{-- Only render the form body (fields etc) as it's really a subform --}}
            @formbody(\AscentCreative\PageBuilder\Forms\RowSettings::make($name, $value))

            <x-slot name="footer">
                <button class="button btn btn-secondary btn-cancel" data-dismiss="modal">Cancel</button>
                <button class="button btn btn-primary btn-ok">OK</button>
            </x-slot>

        </x-cms-modal>

          
    </div>
        
</div>
