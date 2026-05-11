<div>
    <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12">
        {{-- Hero --}}
        <div class="text-center mb-10">
            <div class="inline-flex items-center justify-center h-16 w-16 rounded-2xl bg-gradient-to-br from-desa-500 to-desa-700 mb-4 shadow-lg shadow-desa-500/20">
                <span class="material-symbols-outlined text-white text-3xl">receipt_long</span>
            </div>
            <h1 class="section-title">Informasi PBB</h1>
            <p class="section-subtitle">Pajak Bumi dan Bangunan — Tahun {{ $currentYear }}</p>
        </div>

        {{-- Summary Cards --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            @foreach([
                ['icon' => 'groups', 'value' => number_format($summary['total_wajib_pajak']), 'label' => 'Wajib Pajak', 'color' => 'desa'],
                ['icon' => 'check_circle', 'value' => number_format($summary['total_lunas']), 'label' => 'Sudah Lunas', 'color' => 'green'],
                ['icon' => 'pending', 'value' => number_format($summary['total_belum_lunas']), 'label' => 'Belum Lunas', 'color' => 'red'],
                ['icon' => 'payments', 'value' => 'Rp ' . number_format($summary['total_penerimaan'], 0, ',', '.'), 'label' => 'Total Penerimaan', 'color' => 'amber'],
            ] as $card)
                <div class="stat-card">
                    <span class="material-symbols-outlined text-3xl text-{{ $card['color'] }}-500 mb-2">{{ $card['icon'] }}</span>
                    <span class="text-lg sm:text-xl font-extrabold text-gray-900">{{ $card['value'] }}</span>
                    <span class="text-xs text-gray-500 mt-1">{{ $card['label'] }}</span>
                </div>
            @endforeach
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Left Sidebar --}}
            <div class="lg:col-span-1 space-y-6">
                {{-- Penjelasan PBB --}}
                <div class="card p-6">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="h-10 w-10 rounded-lg bg-desa-50 flex items-center justify-center">
                            <span class="material-symbols-outlined text-desa-600">info</span>
                        </div>
                        <h3 class="font-bold text-gray-900 text-sm">Apa itu PBB?</h3>
                    </div>
                    <p class="text-sm text-gray-600 leading-relaxed">Pajak Bumi dan Bangunan (PBB) adalah <strong>pajak yang dikenakan atas kepemilikan tanah dan bangunan</strong>. Setiap wajib pajak memiliki Nomor Objek Pajak (NOP) yang tercantum pada SPPT PBB.</p>
                </div>

                {{-- Cara Cek NOP --}}
                <div class="card p-6">
                    <h3 class="font-bold text-gray-900 text-sm mb-4 flex items-center gap-2">
                        <span class="material-symbols-outlined text-desa-500 text-lg">help</span>
                        Cara Menemukan NOP
                    </h3>
                    <div class="space-y-3">
                        @foreach([
                            ['icon' => 'description', 'text' => 'Lihat pada SPPT PBB tahun sebelumnya'],
                            ['icon' => 'home', 'text' => 'Tanya kepada RT/RW atau perangkat desa'],
                            ['icon' => 'support_agent', 'text' => 'Hubungi Kantor Pelayanan Pajak'],
                        ] as $tip)
                            <div class="flex items-start gap-3 p-2 rounded-lg bg-gray-50">
                                <span class="material-symbols-outlined text-desa-500 text-lg mt-0.5">{{ $tip['icon'] }}</span>
                                <p class="text-sm text-gray-600">{{ $tip['text'] }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Tempat Pembayaran --}}
                <div class="card p-6">
                    <h3 class="font-bold text-gray-900 text-sm mb-4 flex items-center gap-2">
                        <span class="material-symbols-outlined text-amber-500 text-lg">account_balance</span>
                        Tempat Pembayaran
                    </h3>
                    <div class="space-y-3">
                        @foreach([
                            ['name' => 'Bank Nagari', 'desc' => 'Seluruh cabang dan unit', 'icon' => 'account_balance'],
                            ['name' => 'Kantor Pos', 'desc' => 'Kantor pos terdekat', 'icon' => 'local_post_office'],
                            ['name' => 'Kantor Pelayanan Pajak', 'desc' => 'KPP Pratama setempat', 'icon' => 'domain'],
                            ['name' => 'Petugas Desa', 'desc' => 'Petugas pemungut PBB desa', 'icon' => 'person'],
                        ] as $place)
                            <div class="flex items-center gap-3 p-2 rounded-lg bg-gray-50">
                                <span class="material-symbols-outlined text-amber-600 text-lg">{{ $place['icon'] }}</span>
                                <div>
                                    <p class="text-sm font-semibold text-gray-900">{{ $place['name'] }}</p>
                                    <p class="text-xs text-gray-400">{{ $place['desc'] }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Istilah --}}
                <div class="card p-6">
                    <h3 class="font-bold text-gray-900 text-sm mb-4 flex items-center gap-2">
                        <span class="material-symbols-outlined text-indigo-500 text-lg">menu_book</span>
                        Istilah Penting
                    </h3>
                    <div class="space-y-3 text-sm">
                        @foreach([
                            ['term' => 'NOP', 'def' => 'Nomor Objek Pajak — identitas unik tanah/bangunan Anda'],
                            ['term' => 'NJOP', 'def' => 'Nilai Jual Objek Pajak — dasar perhitungan pajak'],
                            ['term' => 'SPPT', 'def' => 'Surat Pemberitahuan Pajak Terutang — tagihan PBB tahunan'],
                        ] as $item)
                            <div class="p-2 rounded-lg bg-gray-50">
                                <p class="font-bold text-gray-900">{{ $item['term'] }}</p>
                                <p class="text-gray-500 text-xs">{{ $item['def'] }}</p>
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
                        Cek Status PBB
                    </h2>
                    <p class="text-sm text-gray-500 mb-4">Masukkan Nomor Objek Pajak (NOP) untuk mengecek status pembayaran PBB Anda.</p>
                    <form wire:submit="search" class="flex gap-3">
                        <div class="flex-1 relative">
                            <input type="text" wire:model="nop" placeholder="Contoh: 13.06.040.001.001-0001.0"
                                class="form-input w-full font-mono text-sm pl-10" maxlength="30">
                            <span class="material-symbols-outlined text-gray-400 text-lg absolute left-3 top-1/2 -translate-y-1/2">tag</span>
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
                </div>

                {{-- Result --}}
                @if($searched)
                    @if($result)
                        <div class="card overflow-hidden">
                            {{-- Status Header --}}
                            <div class="p-5 {{ $result->status === 'paid' ? 'bg-gradient-to-r from-green-50 to-green-100 border-b border-green-200' : 'bg-gradient-to-r from-red-50 to-red-100 border-b border-red-200' }}">
                                <div class="flex items-center gap-3">
                                    <div class="h-12 w-12 rounded-xl {{ $result->status === 'paid' ? 'bg-green-500' : 'bg-red-500' }} flex items-center justify-center">
                                        <span class="material-symbols-outlined text-white text-2xl">{{ $result->status === 'paid' ? 'verified' : 'warning' }}</span>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-bold {{ $result->status === 'paid' ? 'text-green-800' : 'text-red-800' }}">
                                            {{ $result->status === 'paid' ? 'LUNAS' : 'BELUM LUNAS' }}
                                        </h3>
                                        <p class="text-sm {{ $result->status === 'paid' ? 'text-green-600' : 'text-red-600' }}">
                                            Tahun Pajak {{ $result->tax_year }}
                                            @if($result->paid_at)
                                                — Dibayar {{ $result->paid_at->translatedFormat('d F Y') }}
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>

                            {{-- Detail --}}
                            <div class="p-5 space-y-4">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-xs text-gray-400 uppercase tracking-wider">NOP</p>
                                        <p class="font-mono font-semibold text-gray-900">{{ $result->nop }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-400 uppercase tracking-wider">Nama Wajib Pajak</p>
                                        <p class="font-semibold text-gray-900">{{ $result->taxpayer_name }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-400 uppercase tracking-wider">Alamat Objek Pajak</p>
                                        <p class="text-sm text-gray-700">{{ $result->address ?: '-' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-400 uppercase tracking-wider">Tahun Pajak</p>
                                        <p class="font-semibold text-gray-900">{{ $result->tax_year }}</p>
                                    </div>
                                </div>

                                <hr class="border-gray-100">

                                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                                    <div>
                                        <p class="text-xs text-gray-400 uppercase tracking-wider">Luas Tanah</p>
                                        <p class="font-semibold text-gray-900">{{ number_format($result->land_area) }} m²</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-400 uppercase tracking-wider">Luas Bangunan</p>
                                        <p class="font-semibold text-gray-900">{{ number_format($result->building_area) }} m²</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-400 uppercase tracking-wider">NJOP</p>
                                        <p class="font-semibold text-gray-900">Rp {{ number_format($result->njop, 0, ',', '.') }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-400 uppercase tracking-wider">Pajak Terutang</p>
                                        <p class="text-xl font-extrabold {{ $result->status === 'paid' ? 'text-green-600' : 'text-red-600' }}">Rp {{ number_format($result->tax_amount, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            </div>

                            @if($result->status === 'unpaid')
                                <div class="px-5 pb-5 space-y-3">
                                    <div class="rounded-lg bg-amber-50 border border-amber-200 p-4 flex items-start gap-3">
                                        <span class="material-symbols-outlined text-amber-600 mt-0.5">info</span>
                                        <div class="text-sm text-amber-800">
                                            <p class="font-semibold mb-1">Segera Lakukan Pembayaran</p>
                                            <p>Silakan melakukan pembayaran melalui <strong>Bank Nagari</strong>, <strong>Kantor Pos</strong>, atau <strong>Kantor Pelayanan Pajak</strong> terdekat. Bawa SPPT/NOP dan identitas diri (KTP).</p>
                                        </div>
                                    </div>
                                    <div class="rounded-lg bg-blue-50 border border-blue-200 p-4 flex items-start gap-3">
                                        <span class="material-symbols-outlined text-blue-600 mt-0.5">lightbulb</span>
                                        <div class="text-sm text-blue-800">
                                            <p class="font-semibold mb-1">Tahukah Anda?</p>
                                            <p>Pembayaran PBB tepat waktu membantu pembangunan desa. Dana PBB digunakan untuk perbaikan jalan, fasilitas umum, dan layanan masyarakat.</p>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="px-5 pb-5">
                                    <div class="rounded-lg bg-green-50 border border-green-200 p-4 flex items-start gap-3">
                                        <span class="material-symbols-outlined text-green-600 mt-0.5">thumb_up</span>
                                        <div class="text-sm text-green-800">
                                            <p class="font-semibold mb-1">Terima Kasih!</p>
                                            <p>PBB Anda untuk tahun {{ $result->tax_year }} sudah lunas. Kontribusi Anda membantu pembangunan dan kemajuan desa.</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @elseif($errorMessage)
                        <div class="card overflow-hidden">
                            <div class="p-5 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                                <div class="flex items-center gap-3">
                                    <div class="h-12 w-12 rounded-xl bg-gray-400 flex items-center justify-center">
                                        <span class="material-symbols-outlined text-white text-2xl">search_off</span>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-bold text-gray-800">Data Tidak Ditemukan</h3>
                                        <p class="text-sm text-gray-500">{{ $errorMessage }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="p-5">
                                <p class="text-sm text-gray-600 mb-3">Kemungkinan penyebab:</p>
                                <div class="space-y-2 text-sm text-gray-600 mb-4">
                                    @foreach([
                                        'NOP yang dimasukkan salah atau kurang lengkap',
                                        'Objek pajak belum terdaftar di wilayah desa ini',
                                        'Data belum diperbarui oleh petugas pajak',
                                    ] as $reason)
                                        <div class="flex items-start gap-2">
                                            <span class="material-symbols-outlined text-gray-400 text-sm mt-0.5">chevron_right</span>
                                            <span>{{ $reason }}</span>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="rounded-lg bg-amber-50 border border-amber-200 p-4 flex items-start gap-3">
                                    <span class="material-symbols-outlined text-amber-600 mt-0.5">support_agent</span>
                                    <div class="text-sm text-amber-800">
                                        <p>Pastikan NOP benar atau hubungi <strong>Kantor Nagari</strong> untuk informasi lebih lanjut.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @else
                    {{-- Empty State --}}
                    <div class="card p-12 text-center">
                        <span class="material-symbols-outlined text-6xl text-gray-200 mb-4">manage_search</span>
                        <p class="text-gray-400 font-medium">Masukkan NOP untuk mulai pencarian</p>
                        <p class="text-xs text-gray-300 mt-1">Hasil pencarian PBB akan ditampilkan di sini</p>
                    </div>
                @endif
            </div>
        </div>
    </section>
</div>
