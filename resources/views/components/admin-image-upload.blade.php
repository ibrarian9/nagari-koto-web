@props([
    'wireModel',
    'label' => 'Foto',
    'existingUrl' => null,
    'icon' => 'image',
    'accept' => 'image/*',
    'hint' => 'JPG, PNG, WebP. Maks 2MB',
    'previewClass' => 'h-24 w-24',
])

<div x-data="{ previewUrl: null }" class="space-y-2">
    <label class="form-label">{{ $label }}</label>
    <div class="flex items-start gap-4">
        {{-- Preview Area --}}
        <div
            class="relative flex-shrink-0 {{ $previewClass }} rounded-xl border-2 border-dashed border-gray-200 overflow-hidden bg-gray-50 flex items-center justify-center group">
            {{-- New upload preview --}}
            <template x-if="previewUrl">
                <img :src="previewUrl" class="h-full w-full object-cover" alt="Preview">
            </template>
            {{-- Existing image --}}
            <template x-if="!previewUrl">
                @if ($existingUrl)
                    <img src="{{ $existingUrl }}" class="h-full w-full object-cover" alt="Current">
                @else
                    <div class="text-center">
                        <span class="material-symbols-outlined text-2xl text-gray-300">{{ $icon }}</span>
                        <p class="text-[10px] text-gray-400 mt-0.5">No image</p>
                    </div>
                @endif
            </template>
            {{-- Loading overlay --}}
            <div wire:loading wire:target="{{ $wireModel }}"
                class="absolute inset-0 bg-white/80 flex items-center justify-center">
                <span class="material-symbols-outlined text-desa-500 animate-spin">progress_activity</span>
            </div>
        </div>
        {{-- Upload Control --}}
        <div class="flex-1 min-w-0">
            <label class="relative cursor-pointer block">
                <div
                    class="flex items-center gap-2 px-4 py-2.5 rounded-lg border border-gray-200 bg-white hover:bg-gray-50 hover:border-desa-300 transition-colors text-sm text-gray-600">
                    <span class="material-symbols-outlined text-base text-gray-400">cloud_upload</span>
                    <span>Pilih File</span>
                </div>
                <input type="file" wire:model="{{ $wireModel }}" accept="{{ $accept }}" class="sr-only"
                    x-on:change="const f = $event.target.files[0]; if(f) { const r = new FileReader(); r.onload = e => previewUrl = e.target.result; r.readAsDataURL(f); }">

            </label>
            <p class="text-xs text-gray-400 mt-1.5">{{ $hint }}</p>
            @error($wireModel)
                <p class="form-error mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>
</div>
