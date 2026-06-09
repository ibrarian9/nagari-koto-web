<div>
    {{-- ─── HERO ─────────────────────────────────────────── --}}
    <x-hero-section slug="bamus" gradient="from-desa-700 via-desa-800 to-desa-950">
        <x-slot:decorations>
            <div class="absolute inset-0">
                <div class="absolute top-0 right-0 w-96 h-96 bg-desa-400/10 rounded-full blur-3xl translate-x-1/3 -translate-y-1/3"></div>
                <div class="absolute bottom-0 left-0 w-80 h-80 bg-desa-300/10 rounded-full blur-3xl -translate-x-1/3 translate-y-1/3"></div>
            </div>
        </x-slot:decorations>
        <div class="text-center">
            <div class="inline-flex items-center justify-center h-16 w-16 rounded-2xl bg-white/10 backdrop-blur-sm border border-white/20 mb-5">
                <span class="material-symbols-outlined text-white text-3xl">gavel</span>
            </div>
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-white tracking-tight">
                Badan Musyawarah Nagari
            </h1>
            <p class="mt-3 text-lg text-desa-200 max-w-2xl mx-auto">
                Lembaga legislatif {{ $village?->name ?? 'nagari' }} yang mengawasi penyelenggaraan pemerintahan
            </p>
            <div class="mt-5 flex items-center justify-center gap-4 text-sm text-desa-300">
                <span class="flex items-center gap-1.5">
                    <span class="material-symbols-outlined text-base text-desa-300">groups</span>
                    {{ $members->count() }} Anggota Aktif
                </span>
                @if($members->first()?->period)
                    <span class="flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-base text-desa-300">date_range</span>
                        Periode {{ $members->first()->period }}
                    </span>
                @endif
            </div>
        </div>
    </x-hero-section>

    @if($members->count())
        @php
            $ketua = $members->first();
            $others = $members->skip(1);
        @endphp

        {{-- ─── PIMPINAN ─────────────────────────────────────── --}}
        <section class="relative -mt-10 z-10 mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 mb-12">
            @if($ketua)
                <div data-aos="fade-up" class="bg-white rounded-2xl shadow-xl shadow-desa-900/10 border border-gray-100 p-6 md:p-8 flex flex-col sm:flex-row items-center gap-6 hover:shadow-2xl transition-all duration-300 max-w-lg mx-auto">
                    <div class="flex-shrink-0">
                        <div class="h-24 w-24 md:h-28 md:w-28 rounded-2xl bg-gradient-to-br from-desa-100 to-desa-50 overflow-hidden ring-4 ring-desa-200/50">
                            @if($ketua->photo)
                                <img src="{{ Storage::url($ketua->photo) }}" alt="{{ $ketua->name }}" class="h-full w-full object-cover" loading="lazy" decoding="async">
                            @else
                                <div class="h-full w-full flex items-center justify-center"><span class="material-symbols-outlined text-5xl text-desa-300">person</span></div>
                            @endif
                        </div>
                    </div>
                    <div class="text-center sm:text-left">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-desa-100 text-desa-700 text-xs font-semibold mb-2">
                            <span class="material-symbols-outlined text-xs">star</span> Pimpinan
                        </span>
                        <h2 class="text-xl md:text-2xl font-bold text-gray-900">{{ $ketua->name }}</h2>
                        <p class="text-desa-600 font-semibold mt-0.5">{{ $ketua->position }}</p>
                        @if($ketua->period)<p class="text-sm text-gray-400 mt-1">Periode {{ $ketua->period }}</p>@endif
                    </div>
                </div>
            @endif
        </section>

        {{-- ─── CONNECTOR ────────────────────────────────────── --}}
        @if($others->count())
            <div class="flex justify-center mb-2">
                <div class="flex flex-col items-center">
                    <div class="w-px h-10 bg-gradient-to-b from-desa-300 to-desa-200"></div>
                    <div class="h-3 w-3 rounded-full bg-desa-300 ring-4 ring-desa-100"></div>
                </div>
            </div>

            {{-- ─── ANGGOTA ──────────────────────────────────── --}}
            <section class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8 mb-12">
                <div class="text-center mb-6">
                    <h3 data-aos="fade-up" class="text-sm font-bold text-gray-400 uppercase tracking-widest flex items-center justify-center gap-2">
                        <span class="h-px w-8 bg-gray-300"></span> Anggota BAMUS <span class="h-px w-8 bg-gray-300"></span>
                    </h3>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                    @foreach($others as $member)
                        <div data-aos="fade-up" data-aos-delay="{{ $loop->index % 3 * 100 }}"
                            class="bg-white rounded-xl border border-gray-100 shadow-sm hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300 p-5">
                            <div class="flex items-center gap-4">
                                <div class="flex-shrink-0 h-14 w-14 rounded-xl bg-gradient-to-br from-desa-50 to-desa-50 overflow-hidden ring-2 ring-desa-100">
                                    @if($member->photo)
                                        <img src="{{ Storage::url($member->photo) }}" alt="{{ $member->name }}" class="h-full w-full object-cover" loading="lazy" decoding="async">
                                    @else
                                        <div class="h-full w-full flex items-center justify-center"><span class="material-symbols-outlined text-2xl text-desa-300">person</span></div>
                                    @endif
                                </div>
                                <div class="min-w-0">
                                    <h4 class="font-semibold text-gray-900 truncate">{{ $member->name }}</h4>
                                    <p class="text-sm text-desa-600 font-medium mt-0.5">{{ $member->position }}</p>
                                    @if($member->period)<p class="text-xs text-gray-400 mt-0.5">{{ $member->period }}</p>@endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif

        {{-- ─── INFO BOX ─────────────────────────────────────── --}}
        <section class="bg-gradient-to-br from-desa-50 to-white py-10 mb-0">
            <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
                <div data-aos="fade-up" class="bg-white rounded-2xl border border-desa-100 p-6 md:p-8">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="h-10 w-10 rounded-xl bg-desa-100 flex items-center justify-center">
                            <span class="material-symbols-outlined text-xl text-desa-600">info</span>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900">Tugas & Fungsi BAMUS</h3>
                    </div>
                    <ul class="space-y-2 text-gray-600 text-sm leading-relaxed">
                        <li class="flex items-start gap-2"><span class="material-symbols-outlined text-desa-500 text-base mt-0.5">check_circle</span> Membahas dan menyepakati Rancangan Peraturan Nagari bersama Wali Nagari</li>
                        <li class="flex items-start gap-2"><span class="material-symbols-outlined text-desa-500 text-base mt-0.5">check_circle</span> Menampung dan menyalurkan aspirasi masyarakat nagari</li>
                        <li class="flex items-start gap-2"><span class="material-symbols-outlined text-desa-500 text-base mt-0.5">check_circle</span> Melakukan pengawasan terhadap kinerja Wali Nagari</li>
                        <li class="flex items-start gap-2"><span class="material-symbols-outlined text-desa-500 text-base mt-0.5">check_circle</span> Membahas dan menyetujui Rancangan APBNagari</li>
                        <li class="flex items-start gap-2"><span class="material-symbols-outlined text-desa-500 text-base mt-0.5">check_circle</span> Membentuk panitia pemilihan Wali Nagari</li>
                    </ul>
                </div>
            </div>
        </section>
    @else
        <section class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8 py-20 text-center">
            <div class="inline-flex items-center justify-center h-20 w-20 rounded-2xl bg-desa-50 mb-6">
                <span class="material-symbols-outlined text-4xl text-desa-300">gavel</span>
            </div>
            <h2 class="text-xl font-bold text-gray-400 mb-2">Data belum tersedia</h2>
            <p class="text-gray-400">Informasi BAMUS Nagari sedang dalam proses pengisian.</p>
        </section>
    @endif
</div>
