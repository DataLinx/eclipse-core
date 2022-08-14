<div class="mb-3">
    @if($label)
        <label class="form-label" for="{{ $id }}">
            {{ $label }}
            @if(isset($attributes['required']))
                <span class="required">*</span>
            @endif
        </label>
    @endif
    <textarea
        {{ $getClasses() }}
        id="{{ $id }}"
        name="{{ $name }}"
        @if($placeholder)
            placeholder="{{ $placeholder }}"
        @endif
        @if($help)
            aria-describedby="{{ $id }}_help"
        @endif>{{ $current }}</textarea>
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
