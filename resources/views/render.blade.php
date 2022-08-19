@isset($content)

    @php $content = json_decode(json_encode($content)); @endphp

    {{-- @dump($content) --}}

    <style>
        {!! renderPageCSS($content) !!}
    </style>

    <div>

        @foreach($content->rows as $row) 

            <div class="pb-row" id="row-{{ $row->unid }}">

                @foreach($row->containers as $container)

                    <div class="pb-container centralise" id="container-{{ $container->unid }}">

                        @foreach($container->blocks as $block)

                            <div class="pb-block" id="block-{{ $block->unid }}">

                                    {!! $block->content !!}

                            </div>

                        @endforeach


                    </div>


                @endforeach

            </div>

        @endforeach


    </div>

@endisset



@push('styles')
    {{-- Load the CSS for this page --}}
    {{-- @if(request()->isPreview) --}}
        {{-- render the CSS directly to a style tag on the page --}}
        {{-- <style>
        {!! renderPageCSS($content) !!}
        </style> --}}
    {{-- @else --}}
        {{-- render the CSS to a file which can be minified for performance etc --}}
        {{-- @style(getStackCSSFile($content, $model)) --}}
    {{-- @endif --}}

@endpush