<div class="form-group">
    @if($label)
        <label for="{{ $id }}">
            {{ $label }}
            @if(isset($attributes['required']))
                <span class="required">*</span>
            @endif
        </label>
    @endif
    <div class="input-group">
        @if($prepend)
            <div class="input-group-prepend">
                <div class="input-group-text">{{ $prepend }}</div>
            </div>
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
            <div class="input-group-append">
                <div class="input-group-text">{{ $append }}</div>
            </div>
        @endif
    </div>
    @if($help)
        <small id="{{ $id }}_help" class="text-muted">
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
