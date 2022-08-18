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


<div class="pb-element pb-container" style="padding: 5px; margin: 0px auto; max-width: 800px; border: 1px dashed rgba(0,0,0,0.2); 
                    display: grid; grid-template-columns: 1fr; gap: 1rem; position: relative; {{ $style }}">

    <div class="pb-element-label">
        <div class="d-flex">
            <span>Container</span>
            <a href="#" class="pbc-settings bi-gear-fill pl-2"></a>
        </div>
    </div>

    {{ $slot }}

    <div class="pb-element-settings">

        <x-forms-modal 
            :form="\AscentCreative\PageBuilder\Forms\ContainerSettings::make($name, $value)"
            title="Container Settings"
        />

    </div>

    
        
</div>
