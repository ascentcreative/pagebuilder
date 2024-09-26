
@push('styles')

    @style('/vendor/ascent/pagebuilder/css/ascent-pagebuilder.css')
    {{-- @style('/css/screen.css') --}}

@endpush

@push('scripts')
    @scripttag('/vendor/ascent/pagebuilder/js/ascent-pagebuilder.js')
    @scripttag('/vendor/ascent/pagebuilder/js/ascent-pagebuilder-stack.js')
@endpush

<div class="pagebuilder">

    <div class="pb-actions pb-3">
        <div class="flex flex-between">

            <div class="pb-actions-left">
                <button id="btn-add-row" class="button btn btn-primary btn-sm">Add</button>
            </div>

            <div class="pb-actions-mid">
                <button id="btn-mobile" class="button btn btn-primary btn-sm">Mobile</button>
               
            </div>

            <div class="pb-actions-right">
                <button id="btn-fullscreen" class="button btn btn-primary btn-sm">Fullscreen</button>
                <button id="btn-docked" class="button btn btn-primary btn-sm">Done</button>
            </div>

        </div>
    
        
        
       
    </div>

    {{-- @dump($value) --}}

    <iframe src="" width="100%" border="0" height="400px" name="pb-iframe" id="pb-iframe" style="display: none; border: 1px solid #ccc;">
    </iframe>

    {{-- The content unid - used to create the CSS file for this page --}}
    <input type="hidden" name="{{ $name }}[unid]" value="{{ $value->unid ?? uniqid() }}"/>

    <div class="pb-sync">
        {{-- Stores the initial value for the iframe on page load. 
            PB then submits this for rendering, and this field is removed in the resulting syncData() call --}}
        <input type="text" name="pb_init" id="pb-init" value="{{ @encrypt($value) }}" /> 
    </div>


    {{-- Block Picker Modal --}}
    <x-cms-modal modalid="block-picker" title="Select a Block Type:">
        {{-- Block types: --}}
        @foreach(discoverBlocks($model) as $cat=>$blocks)

            @if(!$loop->first)
                <div class="dropdown-divider"></div>
            @endif

            <div class="block-group row">
                <div class="block-group-name col-2 pt-2"><h5 style="font-weight: 300">{{ $cat }}</h5></div>
                <div class="block-group-blocks col-10">

                    @foreach($blocks as $block)

                        <a class="stack-add-row dropdown-item text-sm btn-option display-block p-2 w-100" href="#" data-block-type="{{ $block['bladePath'] }}" data-block-field="{{ $name }}">
                            <strong>{{ $block['name'] }}</strong><span class="text-muted"> - {{ $block['description'] }}</span>
                        </a>

                    @endforeach

                </div>

            </div>          

        @endforeach

        <x-slot name="footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal"> Cancel </button>
        </x-slot>
        
    </x-cms-modal>


</div>
