<div {{ $getGroupAttributes() }} @if($help) aria-describedby="{{ $id }}-help" @endif>
    <div class="form-check form-switch @if($inline) form-check-inline @endif">
        <input
            type="checkbox"
            name="{{ $name }}"
            value="{{ $value }}"
            id="{{ $id }}"
            @if($isChecked()) checked @endif
            @if($required) required @endif
            @if($disabled) disabled @endif
            {{ $getControlAttributes() }}
        />
        <label class="form-check-label" for="{{ $id }}">
            {{ $label }}
            @if($required)
                <span class="required">*</span>
            @endif
        </label>
    </div>
    @if($help)
        <small id="{{ $id }}-help" class="form-text">
            {{ $help }}
        </small>
    @endif
    @if(empty($no_error))
        @error($name)
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    @endif
</div>
