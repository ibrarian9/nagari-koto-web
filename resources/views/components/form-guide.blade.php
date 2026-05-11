@props([
    'title' => 'Panduan Pengisian',
])

<div x-data="{ open: false }" class="mb-5">
    <button type="button" @click="open = !open" class="w-full flex items-center gap-2 px-4 py-2.5 rounded-xl bg-blue-50 border border-blue-100 text-left transition-colors hover:bg-blue-100/70">
        <span class="material-symbols-outlined text-blue-500 text-lg">help</span>
        <span class="text-sm font-medium text-blue-700 flex-1">{{ $title }}</span>
        <span class="material-symbols-outlined text-blue-400 text-base transition-transform" :class="open && 'rotate-180'">expand_more</span>
    </button>
    <div x-show="open" x-cloak x-transition.duration.200ms class="mt-2 px-4 py-3 rounded-xl bg-blue-50/50 border border-blue-100/60 text-sm text-gray-600 space-y-2">
        {{ $slot }}
    </div>
</div>
