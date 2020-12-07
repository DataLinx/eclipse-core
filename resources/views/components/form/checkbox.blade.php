<div
    {{ $getClasses() }}
    id="{{ $id }}"
    @if($help)
        aria-describedby="{{ $id }}-help"
    @endif
    {{ $attributes }}>
    @if($label)
        <label>
            {{ $label }}
            @if($required)
                <span class="required">*</span>
            @endif
        </label>
    @endif
    @if ($as_buttons)
        @if (! $inline) <div> @endif
        <div class="btn-group btn-group-toggle @if ($size) btn-group-{{ $size }} @endif" data-toggle="buttons">
            @foreach($options as $option)
                <label class="btn btn-secondary @if($option['checked']) active @endif">
                    <input name="{{ $getName() }}" type="{{ $type }}" value="{{ $option['value'] }}" @if($option['checked']) checked @endif @if($required) required @endif @if($disabled) disabled @endif>
                    {{ $option['label'] }}
                </label>
            @endforeach
        </div>
        @if (! $inline) </div> @endif
    @else
        @foreach($options as $option)
            <div class="custom-control @if ($as_switches) custom-switch @else custom-{{ $type }} @endif @if($inline) custom-control-inline @endif">
                <input class="custom-control-input" name="{{ $getName() }}" type="{{ $type }}" value="{{ $option['value'] }}" @if($option['checked']) checked @endif id="{{ $option['id'] }}" @if($required) required @endif @if($disabled) disabled @endif>
                <label class="custom-control-label" for="{{ $option['id'] }}">
                    {{ $option['label'] }}
                </label>
            </div>
        @endforeach
    @endif
    @if($help)
        <small id="{{ $id }}-help" class="text-muted">
            {{ $help }}
        </small>
    @endif
    @if(empty($noerror))
        @error($name)
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    @endif
</div>
