@props([
    'label',
    'value',
    'subtext' => null,
    'icon' => null,
    'dark' => false,
])

<div {{ $attributes->merge([
    'class' => $dark
        ? 'rounded-xl bg-desa-900/90 border border-desa-800 p-5 text-white shadow-sm'
        : 'rounded-xl bg-white border border-gray-200 p-5 text-gray-900 shadow-sm'
]) }}>
    <div class="flex items-center justify-between mb-3">
        <span class="{{ $dark ? 'text-desa-300' : 'text-gray-500' }} text-xs font-semibold uppercase tracking-wider">
            {{ $label }}
        </span>
        @if ($icon)
            <div class="{{ $dark ? 'bg-desa-800 text-desa-300' : 'bg-gray-100 text-gray-600' }} flex h-9 w-9 items-center justify-center rounded-lg">
                <span class="material-symbols-outlined text-lg">{{ $icon }}</span>
            </div>
        @endif
    </div>
    <div class="text-2xl md:text-3xl font-bold tracking-tight {{ $dark ? 'text-white' : 'text-gray-900' }}">
        {{ $value }}
    </div>
    @if ($subtext || $slot->isNotEmpty())
        <div class="mt-1 text-xs {{ $dark ? 'text-desa-300/80' : 'text-gray-500' }}">
            {{ $subtext ?? $slot }}
        </div>
    @endif
</div>
