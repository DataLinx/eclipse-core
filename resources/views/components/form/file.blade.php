<div class="form-group">
    @if($label)
        <label for="{{ $id }}">
            {{ $label }}
            @if(isset($attributes['required']))
                <span class="required">*</span>
            @endif
        </label>
    @endif
    <div class="custom-file @if($size) form-control-{{ $size }} @endif">
        <input
            type="file"
            name="{{ $name }}"
            id="{{ $id }}"
            {{ $getClasses() }}
            {{ $attributes }}
            @if($help)
            aria-describedby="{{ $id }}_help"
            @endif>
        <label class="custom-file-label" for="customFile">
            @if($placeholder)
                {{ $placeholder }}
            @else
                {{ _('Choose file') }}
            @endif
        </label>
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

