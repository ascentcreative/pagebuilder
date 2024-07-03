<div class="pb-element pb-{{ $value->t }} {{ $value->o->class ?? ''}} @if(!($visible ?? true)) pb-element-invisible @endif" 
    style="position: relative; {{ $style ?? '' }}"
    data-unid="{{ $unid }}"
    id="elm-{{ $unid }}"
    >

    <div class="pb-element-label">
            <a href="#" class="bi-arrow-90deg-up xbi-arrow-up-square pbe-selparent"></a>
            <span>{{ $value->t }}</span>

            <a href="#" class="pbe-addchild bi-plus-square" id="pbe-addchild-{{ $unid }}" aria-haspopup="true" aria-expanded="false"></a>

            <a href="#" class="pbe-settings bi-gear-fill" data-toggle="modal" data-target="#settings{{ $unid }}"></a>
            <a href="#" class="pbe-delete bi-trash" id="pbe-delete-{{ $unid }}"></a>
            <span class="element-drag bi-arrows-move"></a>
    </div>

    <div class="pb-element-settings">

        {{-- NB - not a FORM modal as the form start and end tags interfere with the submission of updated values. --}}
        <x-cms-modal modalid="settings{{ $unid }}" 
            title="{{ $value->t }} Settings"
        >
          
            @isset($formclass)
                {{-- Only render the form body (fields etc) as it's really a subform --}}
                @formbody($formclass::make($path, $value)) 
            @endisset

            <x-slot name="footer">
                <button class="button btn btn-secondary btn-cancel" data-dismiss="modal">Cancel</button>
                <button class="button btn btn-primary btn-ok">OK</button>
            </x-slot>

        </x-cms-modal>

    </div>

    {{-- The element's specific content --}}
    @yield('content')

    <div class="pb-element-fields">
        <input name="{{ $path }}[t]" value="{{ $value->t }}" type="hidden" class="pb-element-type"/>
    </div>

    

</div>

