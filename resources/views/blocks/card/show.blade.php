<div class="card">

    {{-- <img class="card-image-top" style="width: 100%; height: 175px; sbackground: grey"/> --}}

    <div class="card-body">
        
        <h4 class="card-title">
            {!! $value->title !!}
        </h4>

        <div class="card-text pb-2">
            {!! $value->body !!}    
        </div>

        {{-- <div class="card-action">

            <button class="btn btn-primary button">Action...</button>

        </div> --}}
    </div>

</div>

@once

  

    @push('styles')

    <style>

        .pb-block .card {
            height: 100%;
        }

    </style>

    @endpush

@endonce