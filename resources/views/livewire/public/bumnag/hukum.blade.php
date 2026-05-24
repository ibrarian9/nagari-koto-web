<div>
    <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12">
        {{-- Page Header --}}
        <div class="text-center mb-12 relative">
            <div class="absolute -top-6 left-1/2 -translate-x-1/2 w-40 h-40 bg-blue-500/5 rounded-full filter blur-2xl -z-10"></div>

            <div
                class="inline-flex items-center justify-center h-16 w-16 rounded-2xl bg-gradient-to-br from-blue-500 to-blue-700 mb-4 shadow-lg shadow-blue-500/20">
                <span class="material-symbols-outlined text-white text-3xl">gavel</span>
            </div>

            <h1 class="section-title">Badan Hukum BUMNag</h1>
            <p class="section-subtitle max-w-2xl mx-auto">
                Dasar hukum pendirian dan legalitas {{ $profile->name }} sebagai badan usaha milik nagari yang sah.
            </p>

            @include('livewire.public.bumnag._subnav')
        </div>

        @if ($profile->badan_hukum_file)
            {{-- Dokumen Header Bar --}}
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-4">
                <div class="flex items-center gap-3">
                    <div class="h-10 w-10 rounded-xl bg-red-50 flex items-center justify-center text-red-500 flex-shrink-0">
                        <span class="material-symbols-outlined text-lg">picture_as_pdf</span>
                    </div>
                    <div>
                        <h2 class="font-extrabold text-gray-900 text-base">Dokumen Badan Hukum BUMNag</h2>
                        <p class="text-xs text-gray-400 mt-0.5">
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
                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold transition-all shadow-sm hover:shadow-md flex-shrink-0">
                    <span class="material-symbols-outlined text-sm">download</span>
                    Unduh Dokumen PDF
                </a>
            </div>

            {{-- Embedded PDF Viewer --}}
            <div
                class="card overflow-hidden border border-gray-200 shadow-lg rounded-2xl bg-gray-100">
                <iframe
                    src="{{ Storage::url($profile->badan_hukum_file) }}#toolbar=1&navpanes=0&view=FitH"
                    class="w-full border-0"
                    style="height: 85vh; min-height: 600px;"
                    loading="lazy"
                    title="Dokumen Badan Hukum BUMNag">
                </iframe>
            </div>

            {{-- Info ringkas di bawah PDF --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-6">
                @if ($profile->sk_pendirian)
                    <div class="card p-4 bg-white border border-gray-150/60 flex items-center gap-3">
                        <div class="h-9 w-9 rounded-lg bg-blue-50 flex items-center justify-center text-blue-600 flex-shrink-0">
                            <span class="material-symbols-outlined text-base">description</span>
                        </div>
                        <div class="min-w-0">
                            <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wider">Nomor SK Pendirian</p>
                            <p class="text-sm text-gray-900 font-semibold truncate">{{ $profile->sk_pendirian }}</p>
                        </div>
                    </div>
                @endif

                @if ($profile->tanggal_pendirian)
                    <div class="card p-4 bg-white border border-gray-150/60 flex items-center gap-3">
                        <div class="h-9 w-9 rounded-lg bg-emerald-50 flex items-center justify-center text-emerald-600 flex-shrink-0">
                            <span class="material-symbols-outlined text-base">calendar_today</span>
                        </div>
                        <div class="min-w-0">
                            <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wider">Tanggal Pendirian</p>
                            <p class="text-sm text-gray-900 font-semibold truncate">{{ $profile->tanggal_pendirian->isoFormat('D MMMM Y') }}</p>
                        </div>
                    </div>
                @endif
            </div>
        @else
            {{-- Belum ada dokumen --}}
            <div class="card p-16 text-center max-w-xl mx-auto border border-gray-150">
                <span class="material-symbols-outlined text-5xl text-gray-300 mb-4">picture_as_pdf</span>
                <h3 class="font-extrabold text-gray-900 text-lg">Dokumen Belum Tersedia</h3>
                <p class="text-sm text-gray-400 mt-1 max-w-sm mx-auto">
                    Dokumen badan hukum BUMNag belum diunggah oleh administrator. Silakan periksa kembali nanti.
                </p>
            </div>
        @endif
    </section>
</div>
