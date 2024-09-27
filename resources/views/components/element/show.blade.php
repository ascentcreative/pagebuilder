<div class="pb-element pb-{{ str_replace('.', ' ', $value->t) ?? '' }} {{ $value->o->css_classes ?? '' }}" id="elm-{{ $unid }}"

    @isset($value->s->background_image)
     {{-- ($img = ) ?? false) --}}
        data-android-fix="false" 
        class="parallax-window" 
        data-parallax="scroll" 
        data-image-src="/storage/{{ $value->s->background_image->hashed_filename }}"
        @php unset($value->s->background_image); @endphp
    @endif
    


    >

    {{-- @dump($value) --}}
     {{-- NOT mobile AND Set to do Parallax --}}
     {{-- @php
     $img = \AscentCreative\CMS\Models\File::find($row->styles->background_image);
 @endphp

 data-android-fix="false" 
 class="parallax-window" 
 data-parallax="scroll" 
 data-image-src="/storage/{{ $img->filepath }}" --}}

    @yield('content')
</div>