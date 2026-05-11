<div>
    <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12">
        {{-- Hero --}}
        <div class="text-center mb-10">
            <div class="inline-flex items-center justify-center h-16 w-16 rounded-2xl bg-gradient-to-br from-desa-500 to-desa-700 mb-4 shadow-lg shadow-desa-500/20">
                <span class="material-symbols-outlined text-white text-3xl">mail</span>
            </div>
            <h1 class="section-title">Layanan Surat Online</h1>
            <p class="section-subtitle">Ajukan permohonan surat dari mana saja, kapan saja</p>
        </div>

        {{-- Penjelasan --}}
        <div class="card p-6 mb-8">
            <div class="flex items-start gap-4">
                <div class="flex-shrink-0 h-10 w-10 rounded-lg bg-desa-50 flex items-center justify-center">
                    <span class="material-symbols-outlined text-desa-600">info</span>
                </div>
                <div class="text-sm text-gray-600 leading-relaxed">
                    <h3 class="font-bold text-gray-900 mb-1">Tentang Layanan Ini</h3>
                    <p>Layanan surat online memudahkan warga untuk mengajukan permohonan surat keterangan dari pemerintah desa <strong>tanpa harus datang ke kantor</strong>. Cukup pilih jenis surat, isi data, dan ajukan secara online. Status surat dapat dipantau kapan saja.</p>
                </div>
            </div>
        </div>

        {{-- Alur Permohonan --}}
        <div class="card p-6 mb-8">
            <h3 class="font-bold text-gray-900 mb-6 flex items-center gap-2">
                <span class="material-symbols-outlined text-desa-500">route</span>
                Alur Permohonan Surat
            </h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                @foreach([
                    ['step' => '1', 'icon' => 'login', 'title' => 'Login Akun', 'desc' => 'Masuk ke akun Anda atau daftar terlebih dahulu sebagai warga.'],
                    ['step' => '2', 'icon' => 'edit_note', 'title' => 'Isi Formulir', 'desc' => 'Pilih jenis surat dan lengkapi data yang diperlukan.'],
                    ['step' => '3', 'icon' => 'hourglass_top', 'title' => 'Proses Verifikasi', 'desc' => 'Petugas akan memverifikasi dan memproses permohonan Anda.'],
                    ['step' => '4', 'icon' => 'task_alt', 'title' => 'Surat Siap', 'desc' => 'Ambil surat yang sudah jadi di Kantor Nagari.'],
                ] as $step)
                    <div class="relative flex flex-col items-center text-center">
                        <div class="h-12 w-12 rounded-full bg-desa-500 text-white flex items-center justify-center font-bold text-lg mb-3 shadow-md shadow-desa-500/20">
                            {{ $step['step'] }}
                        </div>
                        <h4 class="font-semibold text-gray-900 text-sm mb-1">{{ $step['title'] }}</h4>
                        <p class="text-xs text-gray-500 leading-relaxed">{{ $step['desc'] }}</p>
                        @if(!$loop->last)
                            <div class="hidden lg:block absolute top-6 left-[calc(50%+28px)] w-[calc(100%-56px)] h-px bg-gray-200"></div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Jenis Surat --}}
        <div class="mb-8">
            <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                <span class="material-symbols-outlined text-desa-500">description</span>
                Jenis Surat yang Tersedia
            </h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @php
                    $iconMap = [
                        'surat_domisili' => 'home',
                        'surat_tidak_mampu' => 'volunteer_activism',
                        'surat_keterangan_usaha' => 'storefront',
                        'surat_keterangan_lahir' => 'child_care',
                        'surat_kematian' => 'sentiment_sad',
                        'surat_pengantar_nikah' => 'favorite',
                        'surat_izin_keramaian' => 'celebration',
                    ];
                @endphp
                @foreach($letterTypes as $key => $label)
                    <div class="card p-5 flex items-start gap-4 hover:-translate-y-0.5 transition-all duration-300">
                        <div class="flex-shrink-0 h-12 w-12 rounded-xl bg-desa-50 flex items-center justify-center">
                            <span class="material-symbols-outlined text-desa-600">{{ $iconMap[$key] ?? 'description' }}</span>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 text-sm">{{ $label }}</h4>
                            <p class="text-xs text-gray-400 mt-0.5">Kode: {{ str_replace('_', ' ', $key) }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Persyaratan Umum --}}
        <div class="card p-6 mb-8">
            <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                <span class="material-symbols-outlined text-amber-500">checklist</span>
                Persyaratan Umum
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-2 text-sm text-gray-600">
                @foreach([
                    'Kartu Tanda Penduduk (KTP) asli dan fotokopi',
                    'Kartu Keluarga (KK) asli dan fotokopi',
                    'Surat pengantar dari RT/RW setempat',
                    'Pas foto 3×4 (untuk surat tertentu)',
                    'Dokumen pendukung sesuai jenis surat',
                    'Akun terdaftar di website desa',
                ] as $req)
                    <div class="flex items-center gap-2 py-1.5">
                        <span class="material-symbols-outlined text-green-500 text-base">check_circle</span>
                        <span>{{ $req }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Info Kontak --}}
        <div class="rounded-xl bg-amber-50 border border-amber-200 p-5 flex items-start gap-4 mb-8">
            <span class="material-symbols-outlined text-amber-600 mt-0.5">support_agent</span>
            <div class="text-sm text-amber-800">
                <p class="font-semibold mb-1">Butuh Bantuan?</p>
                <p>Jika mengalami kendala dalam pengajuan surat, silakan hubungi <strong>Kantor Wali Nagari</strong> di jam kerja (Senin–Jumat, 08.00–16.00 WIB) atau datang langsung ke Kantor Nagari.</p>
            </div>
        </div>

        {{-- CTA Buttons --}}
        <div class="text-center">
            @auth
                @if(auth()->user()->isWarga())
                    <div class="flex flex-wrap justify-center gap-4">
                        <a href="{{ route('surat.ajukan') }}" wire:navigate class="btn-primary">
                            <span class="material-symbols-outlined">edit_note</span>
                            Ajukan Surat Sekarang
                        </a>
                        <a href="{{ route('surat.status') }}" wire:navigate class="btn-secondary">
                            <span class="material-symbols-outlined">fact_check</span>
                            Cek Status Surat Saya
                        </a>
                    </div>
                @else
                    <div class="card p-8 max-w-md mx-auto text-center">
                        <span class="material-symbols-outlined text-4xl text-gray-300 mb-3">admin_panel_settings</span>
                        <p class="text-gray-600 font-medium mb-1">Khusus Akun Warga</p>
                        <p class="text-sm text-gray-400">Fitur pengajuan surat hanya tersedia untuk akun warga terdaftar. Anda login sebagai <strong>{{ auth()->user()->role }}</strong>.</p>
                    </div>
                @endif
            @else
                <div class="card p-8 max-w-md mx-auto text-center">
                    <span class="material-symbols-outlined text-4xl text-gray-300 mb-3">lock</span>
                    <p class="text-gray-600 font-medium mb-1">Login Diperlukan</p>
                    <p class="text-sm text-gray-400 mb-4">Silakan masuk atau daftar untuk mengajukan permohonan surat.</p>
                    <div class="flex flex-wrap justify-center gap-3">
                        <a href="{{ route('login') }}" wire:navigate class="btn-primary">
                            <span class="material-symbols-outlined">login</span>
                            Masuk ke Akun
                        </a>
                        @if(Route::has('register'))
                            <a href="{{ route('register') }}" wire:navigate class="btn-secondary">
                                <span class="material-symbols-outlined">person_add</span>
                                Daftar Warga
                            </a>
                        @endif
                    </div>
                </div>
            @endauth
        </div>
    </section>
</div>
