<div {{ $getGroupAttributes() }}>
    @if($label)
        <label class="form-label" for="{{ $id }}">
            {{ $label }}
            @if($required)
                <span class="required">*</span>
            @endif
        </label>
    @endif
    <div class="input-group @if(empty($no_error)) @error($name) is-invalid @enderror @endif">
        @if($prepend)
            <div class="input-group-text">{{ $prepend }}</div>
        @endif
        <input
            id="{{ $id }}"
            name="{{ $name }}"
            type="{{ $type }}"
            value="{{ $current }}"
            @if($placeholder) placeholder="{{ $placeholder }}" @endif
            @if($help) aria-describedby="{{ $id }}-help" @endif
            {{ $getControlAttributes() }}
        />
        @if($append)
            <div class="input-group-text">{{ $append }}</div>
        @endif
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
