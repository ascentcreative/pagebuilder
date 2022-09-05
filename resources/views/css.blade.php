@section('css')

    #{{$id}} {
        @php

            $ignore = [];

           

            $styles = collect($data->styles ?? []);


            if(isset($data->options->parallax) && $data->options->parallax == 1) {

                // BG colour and image will break the parallax (by obscuring it)
                // the image wil be rendered to parallax in the main view, so we'll just unset / ignore both here
                // unset($data->styles->background_image);
                // unset($data->styles->background_colour);
                $ignore[] = 'background_image';
                $ignore[] = 'background_color';

            } else {

                if(isset($styles['background_image'])) {
                    $img = \AscentCreative\CMS\Models\File::find($styles['background_image']);
                     $styles['background_image'] = "url('/storage/" . $img->filepath . "')";
                }

            }

            
            $style = $styles->transform(function($item, $key) use ($ignore) {
                if($item != '' && in_array($key, $ignore) === false) {
                    return str_replace("_", '-', $key) . ': ' . $item;
                } else {
                    return null;
                }
            })->filter()->join('; ');

        @endphp

        position: relative;
        {{-- border: 1px solid transparent; --}}
        {!! $style !!}

    }

@overwrite

@yield('css')

