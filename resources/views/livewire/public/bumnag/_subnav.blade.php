{{-- BUMNag Sub-Navigation (shared across all BUMNag pages) --}}
<div class="flex flex-wrap items-center justify-center gap-2 mt-6">
    @php
        $tabs = [
            ['route' => 'bumnag.home', 'icon' => 'info', 'label' => 'Profil'],
            ['route' => 'bumnag.struktur', 'icon' => 'groups', 'label' => 'Struktur'],
            ['route' => 'bumnag.hukum', 'icon' => 'gavel', 'label' => 'Badan Hukum'],
            ['route' => 'bumnag.anggaran', 'icon' => 'account_balance', 'label' => 'Anggaran'],
            ['route' => 'bumnag.program-kerja', 'icon' => 'assignment', 'label' => 'Program Kerja'],
        ];
    @endphp
    @foreach ($tabs as $tab)
        <a href="{{ route($tab['route']) }}" wire:navigate
            class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-bold transition-all {{ request()->routeIs($tab['route']) ? 'bg-desa-600 text-white shadow-md' : 'bg-gray-100 text-gray-600 hover:bg-desa-50 hover:text-desa-700' }}">
            <span class="material-symbols-outlined text-sm">{{ $tab['icon'] }}</span> {{ $tab['label'] }}
        </a>
    @endforeach
</div>
