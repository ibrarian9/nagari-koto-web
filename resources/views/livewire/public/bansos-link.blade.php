<div>
    {{-- ─── HERO ─────────────────────────────────────────── --}}
    <section class="relative bg-gradient-to-br from-green-700 via-emerald-800 to-teal-900 overflow-hidden">
        <div class="absolute inset-0">
            <div class="absolute top-0 right-0 w-96 h-96 bg-green-400/10 rounded-full blur-3xl translate-x-1/3 -translate-y-1/3"></div>
            <div class="absolute bottom-0 left-0 w-80 h-80 bg-emerald-300/10 rounded-full blur-3xl -translate-x-1/3 translate-y-1/3"></div>
        </div>
        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16 md:py-20 text-center">
            <div class="inline-flex items-center justify-center h-16 w-16 rounded-2xl bg-white/10 backdrop-blur-sm border border-white/20 mb-5">
                <span class="material-symbols-outlined text-white text-3xl">volunteer_activism</span>
            </div>
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-white tracking-tight">
                Cek Bantuan Sosial
            </h1>
            <p class="mt-3 text-lg text-green-200 max-w-2xl mx-auto">
                Akses portal resmi untuk mengecek status penerima bantuan sosial pemerintah
            </p>
        </div>
    </section>

    {{-- ─── MAIN CONTENT ─────────────────────────────────── --}}
    <section class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8 -mt-8 relative z-10 pb-12">
        @foreach($links as $link)
            <div class="bg-white rounded-2xl border border-gray-100 shadow-xl overflow-hidden">
                <div class="h-2 bg-gradient-to-r {{ $link['color'] }}"></div>
                <div class="p-8 flex flex-col md:flex-row items-center gap-8">
                    {{-- QR Code --}}
                    <div class="flex-shrink-0 text-center">
                        <div class="inline-flex items-center justify-center h-52 w-52 bg-gray-50 rounded-xl border-2 border-dashed border-gray-200">
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data={{ urlencode($link['url']) }}&format=svg"
                                alt="QR Code {{ $link['title'] }}" class="h-48 w-48 rounded-lg" loading="lazy" decoding="async">
                        </div>
                        <p class="text-xs text-gray-400 mt-2">Scan QR untuk akses langsung</p>
                    </div>

                    {{-- Info --}}
                    <div class="flex-1 text-center md:text-left">
                        <div class="flex items-center justify-center md:justify-start gap-3 mb-3">
                            <div class="h-12 w-12 rounded-xl {{ $link['light'] }} flex items-center justify-center">
                                <span class="material-symbols-outlined text-2xl">{{ $link['icon'] }}</span>
                            </div>
                            <div>
                                <h2 class="text-xl font-bold text-gray-900">{{ $link['title'] }}</h2>
                                <p class="text-xs text-gray-400">{{ str_replace('https://', '', $link['url']) }}</p>
                            </div>
                        </div>
                        <p class="text-sm text-gray-500 leading-relaxed mb-5">{{ $link['description'] }}</p>
                        <a href="{{ $link['url'] }}" target="_blank" rel="noopener noreferrer"
                            class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-gradient-to-r {{ $link['color'] }} text-white font-semibold text-sm hover:opacity-90 transition-opacity shadow-lg">
                            <span class="material-symbols-outlined text-base">open_in_new</span>
                            Kunjungi Portal
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </section>

    {{-- ─── INFO SECTION ─────────────────────────────────── --}}
    <section class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8 pb-12">
        <div class="bg-gradient-to-r from-green-700 to-emerald-800 rounded-2xl p-8 text-white">
            <div class="flex flex-col md:flex-row items-center gap-6">
                <div class="flex-shrink-0 h-14 w-14 rounded-2xl bg-white/10 flex items-center justify-center">
                    <span class="material-symbols-outlined text-2xl">info</span>
                </div>
                <div class="flex-1 text-center md:text-left">
                    <h3 class="text-lg font-bold mb-1">Informasi Penting</h3>
                    <p class="text-green-200 text-sm leading-relaxed">
                        Pastikan Anda menyiapkan <strong class="text-white">NIK (Nomor Induk Kependudukan)</strong> dan
                        <strong class="text-white">nama lengkap sesuai KTP</strong>.
                        Jika ada kendala, hubungi kantor {{ $village?->name ?? 'nagari' }} untuk bantuan lebih lanjut.
                    </p>
                </div>
            </div>
        </div>
    </section>
</div>
