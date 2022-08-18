@php 

// dd($data)

if(is_string($data)) {
    $value = decrypt($data); 
} else if(!is_null($data)) {
    $value = json_decode(json_encode($data))->content;
}

if(is_null($value)) {
    // load a default value:
    $value = [
    'rows' => [
        [
            'containers' => [
                    [
                        'blocks' => [
                            [
                                'template'=>'page-header',
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

    @style('/vendor/ascent/cms/css/bootstrap.min.css') 
    @style("https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css") 
    @style('/vendor/ascent/pagebuilder/css/ascent-pagebuilder.css')
    @style('/vendor/ascent/forms/dist/css/ascent-forms-bundle.css')

    @style('/css/screen.css')

@endpush

@push('scripts')
    @script('/vendor/ascent/pagebuilder/js/ascent-pagebuilder-stack.js')
    @script('/vendor/ascent/pagebuilder/js/ascent-pagebuilder-row.js')
    @script('/vendor/ascent/pagebuilder/js/ascent-pagebuilder-container.js')
@endpush



<html>

<head>
    @stack('styles')
</head>

<body class="pb-display">

   
    <form method="post" action="/admin/pagebuilder/iframe">
        @csrf
        {{-- <x-forms-fields-input type="text" name="text" label="some test text" value="" placeholder="enter something"/> --}}
        <div class="pagebuilderstack">
            <div class="pb-rows themed">
                @isset($value->rows)
                    @php $iRow = 0; @endphp
                    @foreach($value->rows as $row)

                        <x-pagebuilder-row fieldname="{{ $name }}" :rowidx="$iRow" :value="$row">
        
                            @foreach($row->containers as $container)
                                
                                <x-pagebuilder-container fieldname="{{ $name }}" :row="$iRow" idx="0" :value="$container">
                        
                                    @foreach($container->blocks as $block)

                                        <x-pagebuilder-block fieldname="{{ $name }}" :row="$iRow" container="0" idx="0" :value="$block">

                                        </x-pagebuilder-block>

                                    @endforeach

                                </x-pagebuilder-container>

                            @endforeach

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
            parent.$('.pagebuilder').trigger('pb-change');
        });
    </script>
</body>

</html>
