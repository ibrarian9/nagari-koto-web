<div>
    <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12 md:py-16">
        {{-- Page Header --}}
        <div class="text-center mb-10 relative">
            <div class="inline-flex items-center justify-center h-14 w-14 rounded-xl bg-blue-100 text-blue-700 border border-blue-200 mb-4 shadow-xs">
                <span class="material-symbols-outlined text-3xl">gavel</span>
            </div>

            <h1 class="text-2xl md:text-3xl lg:text-4xl font-extrabold text-slate-900 tracking-tight leading-tight">
                Badan Hukum BUMNag
            </h1>
            <p class="mt-2 text-slate-600 text-sm md:text-base max-w-2xl mx-auto leading-relaxed">
                Dasar hukum pendirian dan legalitas {{ $profile->name }} sebagai badan usaha milik nagari yang sah.
            </p>

            @include('livewire.public.bumnag._subnav')
        </div>

        @if ($profile->badan_hukum_file)
            {{-- Dokumen Header Bar --}}
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-4 p-4 sm:p-5 bg-white rounded-2xl border border-slate-200 shadow-xs">
                <div class="flex items-center gap-3.5">
                    <div class="h-11 w-11 rounded-xl bg-rose-100 text-rose-700 border border-rose-200 flex items-center justify-center flex-shrink-0">
                        <span class="material-symbols-outlined text-2xl">picture_as_pdf</span>
                    </div>
                    <div>
                        <h2 class="font-bold text-slate-900 text-base leading-snug">Dokumen Badan Hukum BUMNag</h2>
                        <p class="text-xs text-slate-600 font-medium mt-0.5">
                            @if ($profile->sk_pendirian)
                                SK {{ $profile->sk_pendirian }}
                                @if ($profile->tanggal_pendirian)
                                    — {{ $profile->tanggal_pendirian->isoFormat('D MMMM Y') }}
                                @endif
                            @else
                                Dokumen resmi badan hukum BUMNag
                            @endif
                        </p>
                    </div>
                </div>
                <a href="{{ Storage::url($profile->badan_hukum_file) }}" download
                    class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold transition-all shadow-xs hover:shadow focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2 flex-shrink-0">
                    <span class="material-symbols-outlined text-base">download</span>
                    Unduh Dokumen PDF
                </a>
            </div>

            {{-- Embedded PDF Viewer --}}
            <div class="overflow-hidden border border-slate-200 shadow-sm rounded-2xl bg-slate-100">
                <iframe
                    src="{{ Storage::url($profile->badan_hukum_file) }}#toolbar=1&navpanes=0&view=FitH"
                    class="w-full border-0"
                    style="height: 80vh; min-height: 550px;"
                    loading="lazy"
                    title="Dokumen Badan Hukum BUMNag">
                </iframe>
            </div>

            {{-- Info ringkas di bawah PDF --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-6">
                @if ($profile->sk_pendirian)
                    <div class="p-5 bg-white border border-slate-200 rounded-xl shadow-xs flex items-center gap-4">
                        <div class="h-11 w-11 rounded-lg bg-blue-100 text-blue-700 border border-blue-200 flex items-center justify-center flex-shrink-0">
                            <span class="material-symbols-outlined text-xl">description</span>
                        </div>
                        <div class="min-w-0">
                            <p class="text-xs text-slate-600 uppercase font-bold tracking-wider">Nomor SK Pendirian</p>
                            <p class="text-sm md:text-base text-slate-900 font-bold truncate mt-0.5">{{ $profile->sk_pendirian }}</p>
                        </div>
                    </div>
                @endif

                @if ($profile->tanggal_pendirian)
                    <div class="p-5 bg-white border border-slate-200 rounded-xl shadow-xs flex items-center gap-4">
                        <div class="h-11 w-11 rounded-lg bg-emerald-100 text-emerald-700 border border-emerald-200 flex items-center justify-center flex-shrink-0">
                            <span class="material-symbols-outlined text-xl">calendar_today</span>
                        </div>
                        <div class="min-w-0">
                            <p class="text-xs text-slate-600 uppercase font-bold tracking-wider">Tanggal Pendirian</p>
                            <p class="text-sm md:text-base text-slate-900 font-bold truncate mt-0.5">{{ $profile->tanggal_pendirian->isoFormat('D MMMM Y') }}</p>
                        </div>
                    </div>
                @endif
            </div>
        @else
            {{-- Belum ada dokumen --}}
            <div class="p-12 md:p-16 text-center max-w-xl mx-auto bg-white rounded-2xl border border-slate-200 shadow-xs">
                <div class="inline-flex items-center justify-center h-16 w-16 rounded-full bg-slate-100 text-slate-500 mb-4">
                    <span class="material-symbols-outlined text-3xl">picture_as_pdf</span>
                </div>
                <h3 class="font-bold text-slate-900 text-lg">Dokumen Belum Tersedia</h3>
                <p class="text-sm text-slate-600 mt-2 max-w-sm mx-auto leading-relaxed">
                    Dokumen badan hukum BUMNag belum diunggah oleh administrator. Silakan periksa kembali nanti.
                </p>
            </div>
        @endif
    </section>
</div>
