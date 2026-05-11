<div>
    <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12">
        {{-- Hero --}}
        <div class="text-center mb-10">
            <div class="inline-flex items-center justify-center h-16 w-16 rounded-2xl bg-gradient-to-br from-desa-500 to-desa-700 mb-4 shadow-lg shadow-desa-500/20">
                <span class="material-symbols-outlined text-white text-3xl">volunteer_activism</span>
            </div>
            <h1 class="section-title">Cek Penerima Bantuan Sosial</h1>
            <p class="section-subtitle">Pastikan data Anda terdaftar sebagai penerima manfaat</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Left: Info --}}
            <div class="lg:col-span-1 space-y-6">
                {{-- Penjelasan --}}
                <div class="card p-6">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="h-10 w-10 rounded-lg bg-desa-50 flex items-center justify-center">
                            <span class="material-symbols-outlined text-desa-600">info</span>
                        </div>
                        <h3 class="font-bold text-gray-900 text-sm">Tentang Layanan Ini</h3>
                    </div>
                    <p class="text-sm text-gray-600 leading-relaxed">Layanan ini memungkinkan warga untuk <strong>mengecek status penerima bantuan sosial</strong> dari pemerintah. Data yang ditampilkan bersifat <strong>tersamar</strong> untuk menjaga privasi.</p>
                </div>

                {{-- Cara Penggunaan --}}
                <div class="card p-6">
                    <h3 class="font-bold text-gray-900 text-sm mb-4 flex items-center gap-2">
                        <span class="material-symbols-outlined text-desa-500 text-lg">help</span>
                        Cara Menggunakan
                    </h3>
                    <div class="space-y-3">
                        @foreach([
                            ['step' => '1', 'text' => 'Siapkan KTP atau Kartu Keluarga Anda'],
                            ['step' => '2', 'text' => 'Masukkan 16 digit NIK pada kolom pencarian'],
                            ['step' => '3', 'text' => 'Klik tombol cari dan lihat hasilnya'],
                        ] as $step)
                            <div class="flex items-start gap-3">
                                <div class="flex-shrink-0 h-7 w-7 rounded-full bg-desa-500 text-white flex items-center justify-center text-xs font-bold">{{ $step['step'] }}</div>
                                <p class="text-sm text-gray-600 pt-0.5">{{ $step['text'] }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Program Bansos --}}
                <div class="card p-6">
                    <h3 class="font-bold text-gray-900 text-sm mb-4 flex items-center gap-2">
                        <span class="material-symbols-outlined text-amber-500 text-lg">card_giftcard</span>
                        Program Bansos Aktif
                    </h3>
                    <div class="space-y-3">
                        @foreach([
                            ['name' => 'PKH', 'full' => 'Program Keluarga Harapan', 'icon' => 'family_restroom'],
                            ['name' => 'BPNT', 'full' => 'Bantuan Pangan Non Tunai', 'icon' => 'restaurant'],
                            ['name' => 'BST', 'full' => 'Bantuan Sosial Tunai', 'icon' => 'payments'],
                            ['name' => 'BLT DD', 'full' => 'Bantuan Langsung Tunai Dana Desa', 'icon' => 'account_balance'],
                        ] as $prog)
                            <div class="flex items-center gap-3 p-2 rounded-lg bg-gray-50">
                                <span class="material-symbols-outlined text-desa-500 text-lg">{{ $prog['icon'] }}</span>
                                <div>
                                    <p class="text-sm font-semibold text-gray-900">{{ $prog['name'] }}</p>
                                    <p class="text-xs text-gray-400">{{ $prog['full'] }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Right: Search + Results --}}
            <div class="lg:col-span-2">
                {{-- Search Box --}}
                <div class="card p-6 mb-6">
                    <h2 class="font-bold text-gray-900 mb-1 flex items-center gap-2">
                        <span class="material-symbols-outlined text-desa-500">search</span>
                        Cari Data Penerima
                    </h2>
                    <p class="text-sm text-gray-500 mb-4">Masukkan Nomor Induk Kependudukan (NIK) 16 digit dari KTP Anda.</p>
                    <form wire:submit="search" class="flex gap-3">
                        <div class="flex-1 relative">
                            <input type="text" wire:model="nik"
                                class="form-input w-full font-mono text-sm pl-10" maxlength="16"
                                placeholder="Contoh: 1306040101900001">
                            <span class="material-symbols-outlined text-gray-400 text-lg absolute left-3 top-1/2 -translate-y-1/2">badge</span>
                        </div>
                        <button type="submit" class="btn-primary whitespace-nowrap" wire:loading.attr="disabled">
                            <span wire:loading.remove class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-base">search</span>
                                Cari
                            </span>
                            <span wire:loading class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-base animate-spin">progress_activity</span>
                                Mencari...
                            </span>
                        </button>
                    </form>
                    @error('nik')<p class="form-error mt-2">{{ $message }}</p>@enderror
                    <p class="mt-3 text-xs text-gray-400 flex items-center gap-1">
                        <span class="material-symbols-outlined text-xs">shield</span>
                        Data bersifat rahasia dan ditampilkan secara tersamar. Maksimal 5 pencarian per jam.
                    </p>
                </div>

                {{-- Results --}}
                @if($searched)
                    @if($results && $results->count())
                        <div class="card overflow-hidden">
                            <div class="p-5 bg-gradient-to-r from-green-50 to-green-100 border-b border-green-200">
                                <div class="flex items-center gap-3">
                                    <div class="h-12 w-12 rounded-xl bg-green-500 flex items-center justify-center">
                                        <span class="material-symbols-outlined text-white text-2xl">verified</span>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-bold text-green-800">Data Ditemukan</h3>
                                        <p class="text-sm text-green-600">{{ $results->count() }} program bantuan terdaftar</p>
                                    </div>
                                </div>
                            </div>
                            <div class="p-5 space-y-4">
                                @foreach($results as $r)
                                    <div class="rounded-xl border border-gray-100 p-4 hover:border-desa-200 transition-colors">
                                        <div class="flex items-start justify-between gap-4">
                                            <div class="flex items-start gap-3">
                                                <div class="flex-shrink-0 h-10 w-10 rounded-lg bg-desa-50 flex items-center justify-center">
                                                    <span class="material-symbols-outlined text-desa-600">card_giftcard</span>
                                                </div>
                                                <div>
                                                    <p class="font-bold text-gray-900">{{ $r->program_name }}</p>
                                                    @if($r->program_type)
                                                        <p class="text-xs text-gray-500">Tipe: {{ $r->program_type }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                            <span class="badge bg-green-100 text-green-700 text-xs">Aktif</span>
                                        </div>
                                        <hr class="my-3 border-gray-100">
                                        <div class="grid grid-cols-2 gap-4 text-sm">
                                            <div>
                                                <p class="text-xs text-gray-400 uppercase tracking-wider">Nama Penerima</p>
                                                <p class="font-medium text-gray-900">{{ $r->masked_name }}</p>
                                            </div>
                                            <div>
                                                <p class="text-xs text-gray-400 uppercase tracking-wider">Periode</p>
                                                <p class="font-medium text-gray-900">{{ $r->start_period?->format('M Y') ?? '-' }} — {{ $r->end_period?->format('M Y') ?? 'sekarang' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div class="card overflow-hidden">
                            <div class="p-5 bg-gradient-to-r from-red-50 to-red-100 border-b border-red-200">
                                <div class="flex items-center gap-3">
                                    <div class="h-12 w-12 rounded-xl bg-red-500 flex items-center justify-center">
                                        <span class="material-symbols-outlined text-white text-2xl">search_off</span>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-bold text-red-800">Data Tidak Ditemukan</h3>
                                        <p class="text-sm text-red-600">NIK tidak terdaftar sebagai penerima bansos aktif</p>
                                    </div>
                                </div>
                            </div>
                            <div class="p-5">
                                <p class="text-sm text-gray-600 mb-4">Hal ini bisa terjadi karena beberapa alasan:</p>
                                <div class="space-y-2 text-sm text-gray-600">
                                    @foreach([
                                        'NIK yang dimasukkan salah atau tidak sesuai KTP',
                                        'Anda belum terdaftar dalam program bantuan sosial',
                                        'Periode bantuan sudah berakhir atau belum dimulai',
                                        'Data belum diperbarui oleh pemerintah desa',
                                    ] as $reason)
                                        <div class="flex items-start gap-2">
                                            <span class="material-symbols-outlined text-red-400 text-sm mt-0.5">chevron_right</span>
                                            <span>{{ $reason }}</span>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="mt-4 rounded-lg bg-amber-50 border border-amber-200 p-4 flex items-start gap-3">
                                    <span class="material-symbols-outlined text-amber-600 mt-0.5">support_agent</span>
                                    <div class="text-sm text-amber-800">
                                        <p class="font-semibold mb-1">Perlu Bantuan?</p>
                                        <p>Hubungi <strong>Kantor Wali Nagari</strong> atau <strong>Pendamping PKH</strong> setempat untuk informasi lebih lanjut tentang pendaftaran bantuan sosial.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @else
                    {{-- Empty State --}}
                    <div class="card p-12 text-center">
                        <span class="material-symbols-outlined text-6xl text-gray-200 mb-4">person_search</span>
                        <p class="text-gray-400 font-medium">Masukkan NIK untuk mulai pencarian</p>
                        <p class="text-xs text-gray-300 mt-1">Hasil akan ditampilkan di sini</p>
                    </div>
                @endif
            </div>
        </div>
    </section>
</div>
