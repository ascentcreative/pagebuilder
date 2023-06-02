<div class="pb-element pb-{{ $value->t }} {{ $value->o->class ?? ''}}" 
    style="position: relative; {{ $style }}"
    >

    <div class="pb-element-label">
        <div class="d-flex">
            <span>{{ $value->t }}</span>
            <a href="#" class="pbe-settings bi-gear-fill pl-2"></a>
            <a href="#" class="pbe-delete bi-trash pl-2"></a>
            <span class="element-drag bi-arrows-move pl-2"></a>
        </div>
    </div>

    <div class="pb-element-settings">

        {{-- NB - not a FORM modal as the form start and end tags interfere with the submission of updated values. --}}
        <x-cms-modal modalid="form-modal" 
            title="{{ $value->t }} Settings"
        >
            {{-- Only render the form body (fields etc) as it's really a subform --}}
            {{-- @formbody(\AscentCreative\PageBuilder\Forms\ContainerSettings::make($name, $value)) --}}

            <x-slot name="footer">
                <button class="button btn btn-secondary btn-cancel" data-dismiss="modal">Cancel</button>
                <button class="button btn btn-primary btn-ok">OK</button>
            </x-slot>

        </x-cms-modal>

    </div>

    {{-- @section('content')
    @show --}}

    @yield('content')

    <div class="pb-element-fields">
        <input name="{{ $path }}[t]" value="{{ $value->t }}" type="hidden"/>
    </div>

    

</div>

