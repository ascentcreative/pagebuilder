@php
    
    $styles = collect($block['styles']);

    $style = $styles->transform(function($item, $key) {
        return (str_replace('_', '-', $key) . ":" . $item);
    })->join('; ');

    // dump($style);

@endphp

<div style="width: 100%; border: 1px solid rgba(0,0,0,0.1); {{ $style }}; position: relative">

    <div class="block-label" style="position: absolute; top: 5px; left: 5px; background: rgba(0,0,0,0.7); color:white; padding: 2px 5px; text-transform: uppercase; font-weight: 500; font-size: 10px">Page Header</div>

    <x-forms-fields-wysiwyg value="<H1>HEADING</H1>" label="" wrapper="none" name="block[0][text]" />

    <input type="text" wire:model="blocks.0.styles.padding_top" />
        
</div>