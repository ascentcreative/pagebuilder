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

        {{-- <div class="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Modal title</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">

                    <x-forms-fields-input name="{{$name}}[styles][padding_top]" label="Padding Top" type="text" value="{{ $value->styles->padding_top ?? '50px' }}"/>
                    <x-forms-fields-input name="{{$name}}[styles][padding_bottom]" label="Padding Bottom" type="text" value="{{ $value->styles->padding_bottom ?? '50px' }}"/>

                    <x-forms-fields-input type="text" label="Background Colour" name="{{ $name }}[styles][background_color]" :value="$value->styles->background_color ?? ($defaults['bgcolor'] ?? 'transparent')" elementClass="row-bgcolor"/>

                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-primary">Save changes</button>
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
              </div>
            </div>
          </div> --}}

          
    </div>
        
</div>
