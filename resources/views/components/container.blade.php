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


<div class="pb-element pb-container centralise" style="padding: 5px; margin: 0px auto; border: 1px dashed rgba(0,0,0,1); 
                    display: xgrid; xgrid-template-columns: 1fr; gap: 1rem; position: relative; {{ $style }}">

    <input type="hidden" name="{{ $name }}[unid]" value="{{ $value->unid ?? uniqid() }}" />

    <div class="pb-element-label">
        <div class="d-flex">
            <span>Container</span>
            <a href="#" class="pbc-settings bi-gear-fill pl-2"></a>
            <a href="#" class="pbc-split bi-layout-split pl-2"></a>
        </div>
    </div>

    {{ $slot }}

    {{-- <div class="col xcol-md-6 bg-light" style="height: 300px">

    </div> --}}

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
