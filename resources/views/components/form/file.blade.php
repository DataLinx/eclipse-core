<div class="mb-3">
    @if($label)
        <label class="form-label" for="{{ $id }}">
            {{ $label }}
            @if(isset($attributes['required']))
                <span class="required">*</span>
            @endif
        </label>
    @endif
    <input
        type="file"
        name="{{ $name }}"
        id="{{ $id }}"
        {{ $getClasses() }}
        {{ $attributes }}
        @if($help)
        aria-describedby="{{ $id }}_help"
        @endif>
    @if($help)
        <small id="{{ $id }}_help" class="form-text">
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

