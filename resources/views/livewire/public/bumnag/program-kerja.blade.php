<div>
    <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12">
        {{-- Page Header --}}
        <div class="text-center mb-16 relative">
            <div class="absolute -top-6 left-1/2 -translate-x-1/2 w-40 h-40 bg-blue-500/5 rounded-full filter blur-2xl -z-10"></div>

            <div
                class="inline-flex items-center justify-center h-16 w-16 rounded-2xl bg-gradient-to-br from-blue-500 to-blue-700 mb-4 shadow-lg shadow-blue-500/20">
                <span class="material-symbols-outlined text-white text-3xl">assignment</span>
            </div>

            <h1 class="section-title">Program Kerja BUMNag</h1>
            <p class="section-subtitle max-w-2xl mx-auto">
                Daftar kegiatan dan program yang dijalankan oleh {{ $profile->name }} untuk memajukan ekonomi nagari.
            </p>

            @include('livewire.public.bumnag._subnav')
        </div>

        @if ($programs->count())
            <div class="space-y-6">
                @foreach ($programs as $i => $program)
                    <div class="card p-0 overflow-hidden bg-white border border-gray-150/60 hover:shadow-lg transition-all duration-300">
                        {{-- Header --}}
                        <div class="bg-gradient-to-r from-blue-50 to-white px-6 py-4 border-b border-gray-100 flex items-center gap-4">
                            <div class="h-10 w-10 rounded-xl bg-blue-100 flex items-center justify-center text-blue-600 flex-shrink-0">
                                <span class="font-extrabold text-sm">{{ $i + 1 }}</span>
                            </div>
                            <div class="min-w-0 flex-1">
                                <h3 class="font-extrabold text-gray-900 text-base truncate">{{ $program->nama_kegiatan }}</h3>
                                @if ($program->kepala_unit_usaha)
                                    <p class="text-xs text-blue-600 font-semibold mt-0.5 flex items-center gap-1">
                                        <span class="material-symbols-outlined text-xs">person</span>
                                        {{ $program->kepala_unit_usaha }}
                                    </p>
                                @endif
                            </div>
                            @if ($program->tahun)
                                <span class="px-3 py-1 bg-blue-100 text-blue-700 text-xs font-bold rounded-full flex-shrink-0">
                                    {{ $program->tahun }}
                                </span>
                            @endif
                        </div>

                        {{-- Body --}}
                        <div class="px-6 py-5 grid grid-cols-1 md:grid-cols-2 gap-5">
                            @if ($program->keterangan)
                                <div class="md:col-span-2">
                                    <div class="flex items-start gap-2.5">
                                        <span class="material-symbols-outlined text-gray-400 text-base mt-0.5 flex-shrink-0">description</span>
                                        <div>
                                            <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Keterangan</p>
                                            <p class="text-sm text-gray-700 leading-relaxed">{{ $program->keterangan }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if ($program->output_program)
                                <div>
                                    <div class="flex items-start gap-2.5">
                                        <span class="material-symbols-outlined text-emerald-500 text-base mt-0.5 flex-shrink-0">check_circle</span>
                                        <div>
                                            <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Output Program</p>
                                            <p class="text-sm text-gray-700 leading-relaxed">{{ $program->output_program }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if ($program->penerima_manfaat)
                                <div>
                                    <div class="flex items-start gap-2.5">
                                        <span class="material-symbols-outlined text-blue-500 text-base mt-0.5 flex-shrink-0">groups</span>
                                        <div>
                                            <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Penerima Manfaat</p>
                                            <p class="text-sm text-gray-700 leading-relaxed">{{ $program->penerima_manfaat }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if ($program->kendala)
                                <div class="md:col-span-2">
                                    <div class="flex items-start gap-2.5 bg-amber-50/50 rounded-xl p-3 border border-amber-100">
                                        <span class="material-symbols-outlined text-amber-500 text-base mt-0.5 flex-shrink-0">warning</span>
                                        <div>
                                            <p class="text-xs font-bold text-amber-700 uppercase tracking-wider mb-1">Kendala</p>
                                            <p class="text-sm text-amber-800 leading-relaxed">{{ $program->kendala }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="card p-16 text-center max-w-xl mx-auto border border-gray-150">
                <span class="material-symbols-outlined text-5xl text-gray-300 mb-4 animate-bounce">assignment</span>
                <h3 class="font-extrabold text-gray-900 text-lg">Belum Ada Program Kerja</h3>
                <p class="text-sm text-gray-400 mt-1 max-w-sm mx-auto">
                    Daftar program kerja BUMNag belum tersedia. Silakan periksa kembali nanti.
                </p>
            </div>
        @endif
    </section>
</div>
