<div
    id="{{ $id }}"
    @if($help) aria-describedby="{{ $id }}-help" @endif
    {{ $getGroupAttributes() }}>
    @if($label)
        <label class="form-label">
            {{ $label }}
            @if($required)
                <span class="required">*</span>
            @endif
        </label>
    @endif
    @if ($as_buttons)
        @if (! $inline) <div> @endif
        <div class="btn-group @if ($size) btn-group-{{ $size }} @endif" role="group">
            @foreach($options as $option)
                <input
                    autocomplete="off"
                    name="{{ $getName() }}"
                    type="{{ $type }}"
                    value="{{ $option['value'] }}"
                    id="{{ $option['id'] }}"
                    @if($option['checked']) checked @endif
                    @if($required) required @endif
                    @if($disabled) disabled @endif
                    {{ $getControlAttributes() }}
                />
                <label class="btn btn-outline-primary" for="{{ $option['id'] }}">{{ $option['label'] }}</label>
            @endforeach
        </div>
        @if (! $inline) </div> @endif
    @else
        @foreach($options as $option)
            <div class="form-check @if ($as_switches) form-switch @endif @if($inline) form-check-inline @endif">
                <input
                    name="{{ $getName() }}"
                    type="{{ $type }}"
                    value="{{ $option['value'] }}"
                    id="{{ $option['id'] }}"
                    @if($option['checked']) checked @endif
                    @if($required) required @endif
                    @if($disabled) disabled @endif
                    {{ $getControlAttributes() }}
                    @if ($attributes->has('wire:model')) wire:model="{{ $attributes->get('wire:model') }}" @endif
                />
                <label class="form-check-label" for="{{ $option['id'] }}">
                    {{ $option['label'] }}
                </label>
            </div>
        @endforeach
    @endif
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
