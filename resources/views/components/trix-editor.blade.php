@props([
    'name',
    'value' => '',
    'label' => null,
    'rows' => 'min-h-[200px]',
])

<div>
    @if($label)
        <label class="form-label">{{ $label }}</label>
    @endif
    <div wire:ignore>
        <input id="trix-{{ $name }}" type="hidden" value="{{ $value }}">
        <trix-editor
            input="trix-{{ $name }}"
            class="trix-content form-input {{ $rows }} prose max-w-none"
            x-on:trix-change="$wire.set('{{ $name }}', $event.target.value)"
        ></trix-editor>
    </div>
    @error($name)<p class="form-error">{{ $message }}</p>@enderror
</div>
