@php 

// dd($data['payload']);
// 
// if(is_string($data)) {
if(isset($data['payload'])) {
    $value = decrypt($data['payload']); 
} else if(!is_null($data)) {
    $value = json_decode(json_encode($data))->content;
}

if(is_null($value)) {
    // load a default value:
    $value = [
    'rows' => [
        uniqid() => [
            'containers' => [
                    uniqid() => [
                        'blocks' => [
                           uniqid() => [
                                'template'=>'text',
                            ]
                        ]
                    ]
                ]
            ]
        ]   
    ];

    // fudge to deep-cast array to objects
    $value = json_decode(json_encode($value));

}

$name = 'content'
@endphp


@push('styles')

    {{-- @style('/vendor/ascent/cms/css/bootstrap.min.css')  --}}
    {{-- @style('/css/bootstrap_custom.css')
    @style("https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css") 
    @style('/vendor/ascent/cms/js/jquery-ui.min.css') 
    
   
    @style('/vendor/ascent/cms/css/ascent-cms-core.css')  --}}

    @style('/vendor/ascent/pagebuilder/css/ascent-pagebuilder.css')
    @style('/vendor/ascent/forms/dist/css/ascent-forms-bundle.css')

    @style('/vendor/ascent/cms/css/ascent-cms-core.css') 
    @foreach(packageAssets()->getStylesheets() as $style)
        @style($style)
    @endforeach
    @foreach(config('cms.theme_stylesheets') as $style)
        @style($style)
    @endforeach
   
@endpush

@push('scripts')
    @script('/vendor/ascent/pagebuilder/js/ascent-pagebuilder-stack.js')
    @script('/vendor/ascent/pagebuilder/js/ascent-pagebuilder-row.js')
    @script('/vendor/ascent/pagebuilder/js/ascent-pagebuilder-container.js')
    @script('/vendor/ascent/pagebuilder/js/ascent-pagebuilder-block.js')

    <script>
        $(document).on('show.bs.modal', function(e) {
            // alert('modal');

            console.log(e);

            let clone = $(e.target).clone(true); 

            clone.addClass('modal-clone');

            parent.$('body').append(clone);
            
            parent.$('body').find('.modal-clone').on('hidden.bs.modal', function() {
                alert('proxy hidden');
            }).modal(); //.modal('show'); //.show().addClass('show');

            // parent.$('.pagebuilder').trigger('show-modal', [e.target, true]);
            

            return false;
        });
    </script>

@endpush



<html>

<head>
    @stack('styles')
</head>

<body class="pb-display">

    <form method="post" action="/admin/pagebuilder/iframe">
        @csrf
        {{-- @dump(request()->all()) --}}
        <input type="hidden" name="scroll_position" id="scrPos" value="{{ request()->scroll_position }}">
        {{-- <x-forms-fields-input type="text" name="text" label="some test text" value="" placeholder="enter something"/> --}}
        <div class="pagebuilderstack">
            <div class="pb-rows themed">
                @isset($value->rows)
                    @php $iRow = 0; @endphp
                    @foreach($value->rows as $unid=>$row)

                        <x-pagebuilder-row fieldname="{{ $name }}" :unid="$unid" :value="$row">
        
                           
                        </x-pagebuilder-row>

                        @php $iRow++; @endphp
                    @endforeach
                @endisset
            </div>
        </div>

    </form>

    @script('/vendor/ascent/cms/js/jquery-3.5.1.min.js')
    @script('/vendor/ascent/cms/js/jquery-ui.min.js')
    @script('/vendor/ascent/cms/js/bootstrap.bundle.min.js')
   

    @script('/vendor/ascent/cms/ckeditor/ckeditor.js', false)
    @script('/vendor/ascent/cms/ckeditor/adapters/jquery.js', false)

    @script('/vendor/ascent/cms/dist/js/ascent-cms-bundle.js')
    @script('/vendor/ascent/forms/dist/js/ascent-forms-bundle.js')



    @stack('lib')
    @stack('scripts')



    <script>
        // relay any change events up to the parent window
        $('.pagebuilderstack').on('change', function(e) {
            console.log('pbs onChange');
            parent.$('.pagebuilder').trigger('pb-change');
        });

        // $(document).ready(function() {
            $('body')[0].scrollTop = $('#scrPos').val();
        // });

        $(document).on('scroll', function(e) {
            $('#scrPos').val($(this).find('body')[0].scrollTop)
            // console.log('scroll', ;
        });

    </script>
</body>

</html>
