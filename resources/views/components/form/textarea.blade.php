<div {{ $getGroupAttributes() }}>
    @if($label)
        <label class="form-label" for="{{ $id }}">
            {{ $label }}
            @if($required)
                <span class="required">*</span>
            @endif
        </label>
    @endif
    <textarea
        id="{{ $id }}"
        name="{{ $name }}"
        @if($placeholder) placeholder="{{ $placeholder }}" @endif
        @if($help) aria-describedby="{{ $id }}-help" @endif
        {{ $getControlAttributes() }}
    >{{ $current }}</textarea>
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
