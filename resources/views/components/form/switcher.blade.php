<div
    {{ $getClasses() }}
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
    <div class="custom-control custom-switch @if($inline) custom-control-inline @endif">
        <input class="custom-control-input" name="{{ $name }}" type="checkbox" value="{{ $value }}" id="{{ $id }}" @if($isChecked()) checked @endif @if($required) required @endif @if($disabled) disabled @endif>
        <label class="custom-control-label" for="{{ $id }}">
            {{ $label }}
        </label>
    </div>
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
