

@if ($errors->has($field))
    <span id="helpBlock2" class="help-block">
    @foreach ($errors->get($field) as $error)
        - {{ $error }}<br>
    @endforeach
    </span>
@endif
