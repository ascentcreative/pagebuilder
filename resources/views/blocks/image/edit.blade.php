
    <div class="wrap {{ $value->clipmask ?? '' }} {{ $value->objectfit ?? '' }}">
        <x-cms-form-croppie label="" name="{{ $name }}[image]" value="{!! isset($value->image) ? $value->image : ''  !!}" wrapper="none"/>
    </div>


{{-- 
@push('scripts')
    <script>
        $(document).on('change', '#block-{{ $value->unid }}-settings select', function() {
            // alert($(this).val());
            $(this).parents('.block').find('.wrap').removeClass('circle').removeClass('contain').removeClass('cover').addClass($(this).val());
        });
    </script>
@endpush --}}

@push('styles')
    <style>

        .wrap {
            width: 100%;
            height: 100%;
        }

        .wrap .croppieupload {
            min-height: 100%;
        }

        .wrap .croppieupload img {
            width: 100%;
            height: auto;
            object-position: center;
        }

        .wrap.cover .croppieupload img {
            position: absolute;
            object-fit: cover;
            object-position: center;
            height: 100%;
        }


        .wrap.contain .croppieupload img {
            position: absolute;
            object-fit: contain;
            object-position: center;
            height: 100%;
        }


        .wrap.circle .croppieupload img {
            clip-path: circle();
        }



    </style>
@endpush
