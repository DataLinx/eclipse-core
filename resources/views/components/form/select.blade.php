<div class="form-group">
    @if($label)
        <label for="{{ $id }}">
            {{ $label }}
            @if(isset($attributes['required']))
                <span class="required">*</span>
            @endif
        </label>
    @endif
    <select
        {{ $getClasses() }}
        id="{{ $id }}"
        name="{{ $name }}"
        @if($multiple)
            multiple
        @endif
        @if($help)
            aria-describedby="{{ $id }}_help"
        @endif
        {{ $attributes }}>
        @if($placeholder)
            <option value="">{{ $placeholder }}</option>
        @endif
        @foreach($options as $option)
            <option value="{{ $option['value'] }}" @if($option['selected']) selected @endif>{{ $option['label'] }}</option>
        @endforeach
        @foreach($groups as $group)
            <optgroup label="{{ $group['label'] }}">
                @foreach($group['options'] as $option)
                    <option value="{{ $option['value'] }}" @if($option['selected']) selected @endif>{{ $option['label'] }}</option>
                @endforeach
            </optgroup>
        @endforeach
    </select>
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
