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

    {{-- @dump($content) --}}


    @include('pagebuilder::render.elements', ['elements' => $content])

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