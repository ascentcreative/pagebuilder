<div class="card">

    {{-- <div>
        <x-forms-fields-croppie name="{{ $name }}[image]" :value="$value->image ?? null" wrapper="none" label="" previewScale="1" height="175" xwidth="400"/>
    </div> --}}
    
    <div class="card-body">
        
        <div>
        <h4>
            <x-forms-fields-wysiwyg :value="$value->title ?? ''" placeholder="Card Title" label="" wrapper="none" name="{{$name}}[title]" toolbar="basic"/>
        </h4>
        </div>
        {{-- <h4 class="card-title" contenteditable="true">
            TITLE
        </h4> --}}

        <div class="card-text">
            <x-forms-fields-wysiwyg :value="$value->body ?? ''"  placeholder="Card Text" label="" wrapper="none" name="{{$name}}[body]" toolbar="basic"/>
        </div>
{{-- 
        <div class="card-action">

            <button class="btn btn-primary button">Action...</button>

        </div> --}}
    </div>

</div>