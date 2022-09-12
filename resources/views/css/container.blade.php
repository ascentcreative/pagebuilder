@extends('pagebuilder::css')

@yield('css')
   

    @php
        $layout = config('pagebuilder.container_layouts.' . $data->options->container_layout);
    @endphp


    #{{$id}} {
        @isset($layout['grid-template-columns'])
            display: grid;
            gap: 1rem;
            grid-template-columns: {{ $layout['grid-template-columns']['lg'] }};
        @endisset
    }

    @isset($layout['grid-template-columns'])
        
    @media only screen and (max-width: 500px) {
        #{{$id}} {
            grid-template-columns: {{ $layout['grid-template-columns']['md'] }};
        }
    }

    @endisset
