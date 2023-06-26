<div class="pb-element pb-{{ $value->t }} {{ $value->o->class ?? ''}}" 
    style="position: relative; "
    data-unid="{{ $unid }}"
    >

    <div class="pb-element-label">
        <div class="d-flex">
            <span>{{ $value->t }}</span>
            <a href="#" class="pbe-addchild bi-plus-square pl-2" id="pbe-addchild-{{ $unid }}"></a>
            <a href="#" class="pbe-settings bi-gear-fill pl-2"></a>
            <a href="#" class="pbe-delete bi-trash pl-2" id="pbe-delete-{{ $unid }}"></a>
            <span class="element-drag bi-arrows-move pl-2"></a>
        </div>
    </div>

    <div class="pb-element-settings">

        {{-- NB - not a FORM modal as the form start and end tags interfere with the submission of updated values. --}}
        <x-cms-modal modalid="form-modal" 
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

