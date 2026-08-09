@props([
    'show' => false,
    'title' => '',
    'subtitle' => '',
    'icon' => 'edit',
    'iconBg' => 'bg-desa-100',
    'iconColor' => 'text-desa-600',
    'maxWidth' => 'max-w-2xl',
    'closeProperty' => 'showForm',
])

@if($show)
<div class="fixed inset-0 z-50 overflow-y-auto" x-data x-init="document.body.classList.add('overflow-hidden')" x-on:remove.window="document.body.classList.remove('overflow-hidden')">
    {{-- Backdrop --}}
    <div class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity" wire:click="$set('{{ $closeProperty }}', false)"></div>

    {{-- Panel --}}
    <div class="relative min-h-screen flex items-start justify-center p-4 pt-12 sm:pt-20">
        <div class="relative bg-white rounded-2xl shadow-2xl w-full {{ $maxWidth }} transform transition-all"
             x-transition:enter="ease-out duration-200" x-transition:enter-start="opacity-0 scale-95 translate-y-4" x-transition:enter-end="opacity-100 scale-100 translate-y-0">
            {{-- Header --}}
            <div class="flex items-center gap-3 p-5 border-b border-gray-100">
                <div class="h-10 w-10 rounded-xl {{ $iconBg }} flex items-center justify-center">
                    <span class="material-symbols-outlined {{ $iconColor }}">{{ $icon }}</span>
                </div>
                <div class="flex-1 min-w-0">
                    <h3 class="font-semibold text-gray-900 text-lg">{{ $title }}</h3>
                    @if($subtitle)<p class="text-xs text-gray-400 mt-0.5">{{ $subtitle }}</p>@endif
                </div>
                <button wire:click="$set('{{ $closeProperty }}', false)" class="h-9 w-9 rounded-lg flex items-center justify-center text-gray-400 hover:bg-gray-100 hover:text-gray-600 transition-colors">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            {{-- Body --}}
            <div class="p-6 max-h-[70vh] overflow-y-auto">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>
@endif
