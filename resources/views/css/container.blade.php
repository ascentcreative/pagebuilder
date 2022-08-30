@extends('pagebuilder::css')

@yield('css')
   

    @php
        $layout = config('pagebuilder.container_layouts.' . $data->options->container_layout);
    @endphp

    #{{$id}} {
        display: grid;
        gap: 1rem;
        grid-template-columns: {{ $layout['grid-template-columns']['lg'] }};
    }

    @media only screen and (max-width: 500px) {
        #{{$id}} {
            grid-template-columns: {{ $layout['grid-template-columns']['md'] }};
        }
    }
