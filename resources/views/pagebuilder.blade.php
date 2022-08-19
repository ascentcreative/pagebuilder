
@push('styles')

    @style('/vendor/ascent/pagebuilder/css/ascent-pagebuilder.css')
    {{-- @style('/css/screen.css') --}}

@endpush

@push('scripts')
    @script('/vendor/ascent/pagebuilder/js/ascent-pagebuilder.js')
    @script('/vendor/ascent/pagebuilder/js/ascent-pagebuilder-stack.js')


    <script>
       
        
    </script>

    <SCRIPT>

        // $(document).ready(function() {
        //     $(document).on('change', '#pb-iframe', function() {
        //         console.log('external change detected');
        //     });
        // });

    </SCRIPT>
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

    {{-- Can't do this... url too long --}}
    {{-- Initial Load can't go to the DB as we'd reload old data on validation fail  --}}
    <iframe src="" width="100%" border="0" height="400px" name="pb-iframe" id="pb-iframe" style="border: 1px solid #ccc;">


    </iframe>

    <div class="pb-sync">
        <input type="text" name="pb_init" id="pb-init" value="{{ @encrypt($value) }}" /> 
    </div>

</div>


{{-- 
    <x-iframetest label="test" name="iframetest" :value="$value" /> --}}



    {{-- <div class="pb-rows themed"> --}}

        {{-- <div class="pb-element pb-row" style="width: 100%; border: 1px solid rgba(0,0,0,0.1); position: relative;">

            <div class="pb-element-label">Row</div>

            <div class="pb-element pb-container" style="padding: 5px; margin: 0px auto; max-width: 800px; border: 1px dashed rgba(0,0,0,0.2); display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; position: relative;">

                <div class="pb-element-label" style="position: absolute; top: 0px; left: 0px; background: rgba(0,0,0,0.7); color:white; padding: 2px 5px; text-transform: uppercase; font-weight: 500; font-size: 10px">Content</div>

                <div class="pb-element pb-block" style="position: relative; border: 1px dashed rgba(0,0,0,0.1)">

                    <div class="pb-element-label" style="position: absolute; top: 0px; left: 0px; background: rgba(0,0,0,0.7); color:white; padding: 2px 5px; text-transform: uppercase; font-weight: 500; font-size: 10px">Page Header</div>

                    <x-forms-fields-wysiwyg value="<H1>HEADING</H1>" label="" wrapper="none" name="text" />
            
                </div>

                <div class="pb_block" style="position: relative; border: 1px dashed rgba(0,0,0,0.1); background: rgba(0,0,0,0.05)">

                   
                </div>

            </div>
                
        </div> --}}

{{--         
        @foreach($value->rows as $row)
            <x-pagebuilder-row fieldname="{{ $name }}" rowidx="0" :value="$row">

            </x-pagebuilder-row>
        @endforeach --}}

    {{-- </div> --}}

{{-- </div> --}}
 

  {{-- @dd($value) --}}

  {{-- <livewire:pagebuilder />  --}}
   {{-- :blocks="(array) $value ?? []" /> --}}