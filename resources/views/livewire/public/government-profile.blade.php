<div>
    <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12">
        <div class="text-center mb-12">
            <div data-aos="zoom-in"
                class="inline-flex items-center justify-center h-16 w-16 rounded-2xl bg-gradient-to-br from-desa-500 to-desa-700 mb-4 shadow-lg shadow-desa-500/20">
                <span class="material-symbols-outlined text-white text-3xl">groups</span>
            </div>
            <h1 data-aos="fade-up" data-aos-delay="100" class="section-title">Struktur Pemerintahan Nagari</h1>
            <p data-aos="fade-up" data-aos-delay="200" class="section-subtitle">Perangkat nagari yang melayani masyarakat
            </p>
        </div>

        @if ($members->count())
            @php
                $kepala = $members->firstWhere('order', 1);
                $sekretaris = $members->firstWhere('order', 2);
                $kaur = $members->filter(fn($m) => in_array($m->order, [3, 4]));
                $kasi = $members->filter(fn($m) => in_array($m->order, [5, 6, 7]));
                $jorong = $members->filter(fn($m) => $m->order >= 8);
            @endphp

            {{-- Tier 1: Wali Nagari --}}
            @if ($kepala)
                <div data-aos="zoom-in" class="flex justify-center mb-4">
                    <div
                        class="card group text-center p-6 w-64 hover:-translate-y-1 transition-all duration-300 border-2 border-desa-200 bg-gradient-to-b from-desa-50 to-white">
                        <div
                            class="mx-auto h-28 w-28 rounded-full bg-gray-100 overflow-hidden mb-4 ring-4 ring-desa-200 group-hover:ring-desa-400 transition-all">
                            @if ($kepala->photo)
                                <img src="{{ Storage::url($kepala->photo) }}" alt="{{ $kepala->name }}"
                                    class="h-full w-full object-cover" loading="lazy" decoding="async">
                            @else
                                <div class="h-full w-full flex items-center justify-center bg-desa-50"><span
                                        class="material-symbols-outlined text-5xl text-desa-300">person</span></div>
                            @endif
                        </div>
                        <h3 class="font-bold text-gray-900 text-lg">{{ $kepala->name }}</h3>
                        <p class="text-sm text-desa-600 font-semibold mt-1">{{ $kepala->position }}</p>
                        <a href="{{ route('pemerintahan.detail', $kepala->id) }}" wire:navigate
                            class="inline-flex items-center gap-1 mt-3 text-xs font-semibold text-desa-600 hover:text-desa-800 bg-desa-50 hover:bg-desa-100 px-3 py-1.5 rounded-lg transition-colors">
                            <span class="material-symbols-outlined text-sm">visibility</span> Lihat Profil
                        </a>
                    </div>
                </div>
                {{-- Connector line --}}
                <div class="flex justify-center mb-4">
                    <div class="w-px h-8 bg-desa-200"></div>
                </div>
            @endif

            {{-- Tier 2: Sekretaris --}}
            @if ($sekretaris)
                <div data-aos="zoom-in" data-aos-delay="200" class="flex justify-center mb-4">
                    <div
                        class="card group text-center p-5 w-56 hover:-translate-y-1 transition-all duration-300 border border-desa-100">
                        <div
                            class="mx-auto h-22 w-22 rounded-full bg-gray-100 overflow-hidden mb-3 ring-4 ring-gray-100 group-hover:ring-desa-200 transition-all">
                            @if ($sekretaris->photo)
                                <img src="{{ Storage::url($sekretaris->photo) }}" alt="{{ $sekretaris->name }}"
                                    class="h-full w-full object-cover" loading="lazy" decoding="async">
                            @else
                                <div class="h-full w-full flex items-center justify-center bg-desa-50"><span
                                        class="material-symbols-outlined text-4xl text-desa-300">person</span></div>
                            @endif
                        </div>
                        <h3 class="font-semibold text-gray-900">{{ $sekretaris->name }}</h3>
                        <p class="text-sm text-desa-600 font-medium mt-1">{{ $sekretaris->position }}</p>
                        <a href="{{ route('pemerintahan.detail', $sekretaris->id) }}" wire:navigate
                            class="inline-flex items-center gap-1 mt-2 text-[11px] font-semibold text-desa-600 hover:text-desa-800 bg-desa-50 hover:bg-desa-100 px-2.5 py-1 rounded-lg transition-colors">
                            <span class="material-symbols-outlined text-xs">visibility</span> Lihat Profil
                        </a>
                    </div>
                </div>
                <div class="flex justify-center mb-4">
                    <div class="w-px h-8 bg-gray-200"></div>
                </div>
            @endif

            {{-- Tier 3: Kaur (Kepala Urusan) --}}
            @if ($kaur->count())
                <div class="relative mb-4">
                    {{-- Horizontal connector --}}
                    <div class="hidden md:block absolute top-0 left-1/2 -translate-x-1/2 h-px bg-gray-200"
                        style="width: {{ min($kaur->count() * 220, 600) }}px"></div>
                    <div class="grid grid-cols-1 md:grid-cols-{{ $kaur->count() }} gap-4 max-w-2xl mx-auto">
                        @foreach ($kaur as $member)
                            <div class="flex flex-col items-center">
                                <div class="hidden md:block w-px h-6 bg-gray-200"></div>
                                <div
                                    class="card group text-center p-4 w-full hover:-translate-y-1 transition-all duration-300">
                                    <div
                                        class="mx-auto h-20 w-20 rounded-full bg-gray-100 overflow-hidden mb-3 ring-4 ring-gray-100 group-hover:ring-desa-200 transition-all">
                                        @if ($member->photo)
                                            <img src="{{ Storage::url($member->photo) }}" alt="{{ $member->name }}"
                                                class="h-full w-full object-cover" loading="lazy" decoding="async">
                                        @else
                                            <div class="h-full w-full flex items-center justify-center bg-desa-50"><span
                                                    class="material-symbols-outlined text-3xl text-desa-300">person</span>
                                            </div>
                                        @endif
                                    </div>
                                    <h3 class="font-semibold text-gray-900 text-sm">{{ $member->name }}</h3>
                                    <p class="text-xs text-desa-600 font-medium mt-1">{{ $member->position }}</p>
                                    <a href="{{ route('pemerintahan.detail', $member->id) }}" wire:navigate
                                        class="inline-flex items-center gap-1 mt-2 text-[11px] font-semibold text-desa-600 hover:text-desa-800 bg-desa-50 hover:bg-desa-100 px-2.5 py-1 rounded-lg transition-colors">
                                        <span class="material-symbols-outlined text-xs">visibility</span> Profil
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="flex justify-center mb-4">
                    <div class="w-px h-8 bg-gray-200"></div>
                </div>
            @endif

            {{-- Tier 4: Kasi (Kepala Seksi) --}}
            @if ($kasi->count())
                <div class="relative mb-4">
                    <div class="hidden md:block absolute top-0 left-1/2 -translate-x-1/2 h-px bg-gray-200"
                        style="width: {{ min($kasi->count() * 220, 800) }}px"></div>
                    <div class="grid grid-cols-1 md:grid-cols-{{ $kasi->count() }} gap-4 max-w-4xl mx-auto">
                        @foreach ($kasi as $member)
                            <div class="flex flex-col items-center">
                                <div class="hidden md:block w-px h-6 bg-gray-200"></div>
                                <div
                                    class="card group text-center p-4 w-full hover:-translate-y-1 transition-all duration-300">
                                    <div
                                        class="mx-auto h-20 w-20 rounded-full bg-gray-100 overflow-hidden mb-3 ring-4 ring-gray-100 group-hover:ring-desa-200 transition-all">
                                        @if ($member->photo)
                                            <img src="{{ Storage::url($member->photo) }}" alt="{{ $member->name }}"
                                                class="h-full w-full object-cover" loading="lazy" decoding="async">
                                        @else
                                            <div class="h-full w-full flex items-center justify-center bg-desa-50"><span
                                                    class="material-symbols-outlined text-3xl text-desa-300">person</span>
                                            </div>
                                        @endif
                                    </div>
                                    <h3 class="font-semibold text-gray-900 text-sm">{{ $member->name }}</h3>
                                    <p class="text-xs text-desa-600 font-medium mt-1">{{ $member->position }}</p>
                                    <a href="{{ route('pemerintahan.detail', $member->id) }}" wire:navigate
                                        class="inline-flex items-center gap-1 mt-2 text-[11px] font-semibold text-desa-600 hover:text-desa-800 bg-desa-50 hover:bg-desa-100 px-2.5 py-1 rounded-lg transition-colors">
                                        <span class="material-symbols-outlined text-xs">visibility</span> Profil
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Tier 5: Kepala Jorong --}}
            @if ($jorong->count())
                <div class="flex justify-center mb-4">
                    <div class="w-px h-8 bg-gray-200"></div>
                </div>
                <div class="mb-4">
                    <p class="text-center text-xs font-semibold text-gray-400 uppercase tracking-widest mb-4">Kepala
                        Jorong</p>
                    <div class="grid grid-cols-2 md:grid-cols-{{ min($jorong->count(), 4) }} gap-4 max-w-4xl mx-auto">
                        @foreach ($jorong as $member)
                            <div
                                class="card group text-center p-4 hover:-translate-y-1 transition-all duration-300 bg-gray-50 border-dashed">
                                <div
                                    class="mx-auto h-16 w-16 rounded-full bg-gray-100 overflow-hidden mb-3 ring-2 ring-gray-200 group-hover:ring-desa-200 transition-all">
                                    @if ($member->photo)
                                        <img src="{{ Storage::url($member->photo) }}" alt="{{ $member->name }}"
                                            class="h-full w-full object-cover" loading="lazy" decoding="async">
                                    @else
                                        <div class="h-full w-full flex items-center justify-center bg-desa-50"><span
                                                class="material-symbols-outlined text-2xl text-desa-300">person</span>
                                        </div>
                                    @endif
                                </div>
                                <h3 class="font-semibold text-gray-900 text-sm">{{ $member->name }}</h3>
                                <p class="text-xs text-desa-600 font-medium mt-1">{{ $member->position }}</p>
                                <a href="{{ route('pemerintahan.detail', $member->id) }}" wire:navigate
                                    class="inline-flex items-center gap-1 mt-2 text-[11px] font-semibold text-desa-600 hover:text-desa-800 bg-desa-50 hover:bg-desa-100 px-2.5 py-1 rounded-lg transition-colors">
                                    <span class="material-symbols-outlined text-xs">visibility</span> Profil
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        @else
            <p class="text-center text-gray-400 py-12">Belum ada data perangkat nagari.</p>
        @endif
    </section>
</div>
