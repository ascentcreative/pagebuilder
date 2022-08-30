<div class="card">

    <img class="card-image-top" style="width: 100%; height: 175px; sbackground: grey"/>

    <div class="card-body">
        
        <h4>
            <x-forms-fields-wysiwyg :value="$value->title ?? ''" placeholder="Card Title" label="" wrapper="none" name="{{$name}}[title]" toolbar="basic"/>
        </h4>
        {{-- <h4 class="card-title" contenteditable="true">
            TITLE
        </h4> --}}

        <div class="card-text">
            <x-forms-fields-wysiwyg :value="$value->body ?? ''"  placeholder="Card Text" label="" wrapper="none" name="{{$name}}[body]" toolbar="basic"/>
        </div>

        <div class="card-action">

            <button class="btn btn-primary button">Action...</button>

        </div>
    </div>


</div>

