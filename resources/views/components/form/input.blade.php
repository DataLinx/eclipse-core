<div class="mb-3">
    @if($label)
        <label class="form-label" for="{{ $id }}">
            {{ $label }}
            @if(isset($attributes['required']))
                <span class="required">*</span>
            @endif
        </label>
    @endif
    <div class="input-group @if(empty($noerror)) @error($name) is-invalid @enderror @endif">
        @if($prepend)
            <div class="input-group-text">{{ $prepend }}</div>
        @endif
        <input
            {{ $getClasses() }}
            id="{{ $id }}"
            name="{{ $name }}"
            type="{{ $type }}"
            value="{{ $current }}"
            @if($placeholder)
                placeholder="{{ $placeholder }}"
            @endif
            @if($help)
                aria-describedby="{{ $id }}_help"
            @endif
            {{ $attributes }}/>
        @if($append)
            <div class="input-group-text">{{ $append }}</div>
        @endif
    </div>
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
