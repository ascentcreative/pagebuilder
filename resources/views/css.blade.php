#{{$id}} {
    @php

        $styles = collect($data->styles ?? []);

        if(isset($styles['background_image'])) {
            $img = \AscentCreative\CMS\Models\File::find($styles['background_image']);
            $styles['background_image'] = "url('/storage/" . $img->filepath . "')";
        }

        $style = $styles->transform(function($item, $key) {
            if($item != '') {
                return str_replace("_", '-', $key) . ': ' . $item;
            } else {
                return null;
            }
        })->filter()->join('; ');

    @endphp

    position: relative;
    border: 1px solid transparent;
    {!! $style !!}

}