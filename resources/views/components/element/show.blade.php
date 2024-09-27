<div class="pb-element pb-{{ str_replace('.', ' ', $value->t) ?? '' }} {{ $value->o->css_classes ?? '' }}" id="elm-{{ $unid }}">
    @yield('content')
</div>