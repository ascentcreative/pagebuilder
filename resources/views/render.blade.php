@push('scripts')
    @script('/vendor/ascent/pagebuilder/vendor/parallax.min.js')
@endpush


@isset($content)

    @php $content = json_decode(json_encode($content)); @endphp

    {{-- 
        Quick impl - renders the CSS to the header of the page 
         - For better performance, this needs to output to minimised CSS files which get recreated when the page is saved.
         - (i.e. what we had for the stackeditor package... see commented code at the bottom of the page!)
        --}}
    @push('styles')
        <style>
            {!! renderPageCSS($content) !!}
        </style>
    @endpush

    {{-- @dump($content); --}}


    <div>

        @foreach($content->rows as $row) 

            <div class="pb-row {{ $row->options->class ?? '' }}" id="row-{{ $row->unid }}" 

                @if(isset($row->styles->background_image))

                    @if(!Agent::isMobile() && isset($row->options->parallax) && $row->options->parallax == 1) 

                        {{-- NOT mobile AND Set to do Parallax --}}
                        @php
                            $img = \AscentCreative\CMS\Models\File::find($row->styles->background_image);
                        @endphp
                
                        data-android-fix="false" 
                        class="parallax-window" 
                        data-parallax="scroll" 
                        data-image-src="/storage/{{ $img->filepath }}"

                    @else



                    @endif

                @endif
                
                >

                @foreach($row->containers as $container)

                    <div class="pb-container centralise double" id="container-{{ $container->unid }}">


                        @foreach($container->blocks as $block)

                            <div class="pb-block" id="block-{{ $block->unid }}">

                                {{-- {{ $block->template }} --}}

                                @includeFirst( array_merge( pagebuilderbladePaths($block->template, 'show'), ['pagebuilder::block.missing']), ['value'=>$block])

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