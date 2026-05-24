<div>
    <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12">
        {{-- Hero --}}
        <div class="text-center mb-12">
            <div class="inline-flex items-center justify-center h-16 w-16 rounded-2xl bg-gradient-to-br from-desa-500 to-desa-700 mb-4 shadow-lg shadow-desa-500/20">
                <span class="material-symbols-outlined text-white text-3xl">policy</span>
            </div>
            <h1 class="section-title">PPID — Informasi Publik</h1>
            <p class="section-subtitle">Pejabat Pengelola Informasi dan Dokumentasi Nagari</p>
        </div>

        {{-- Urgent Alerts --}}
        @if($urgentItems->count())
            <div class="mb-8 space-y-3">
                @foreach($urgentItems as $item)
                    <div class="rounded-xl border {{ $item->urgency === 'kritis' ? 'border-red-300 bg-red-50' : ($item->urgency === 'tinggi' ? 'border-orange-300 bg-orange-50' : 'border-amber-200 bg-amber-50') }} p-4 flex items-start gap-3">
                        <span class="material-symbols-outlined mt-0.5 {{ $item->urgency === 'kritis' ? 'text-red-600' : ($item->urgency === 'tinggi' ? 'text-orange-600' : 'text-amber-600') }}">{{ $item->urgency_icon }}</span>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="badge {{ $item->urgency_color }} text-xs">{{ $item->urgency_label }}</span>
                                <span class="text-xs text-gray-400">{{ $item->published_at?->diffForHumans() }}</span>
                            </div>
                            <h3 class="font-semibold text-gray-900 text-sm">{{ $item->title }}</h3>
                        </div>
                        <a href="{{ route('ppid.serta-merta') }}" wire:navigate class="text-xs text-desa-600 hover:underline whitespace-nowrap">Selengkapnya →</a>
                    </div>
                @endforeach
            </div>
        @endif

        {{-- Sub-module Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5 mb-10">
            @php
                $modules = [
                    ['route' => 'ppid.berkala', 'icon' => 'schedule', 'title' => 'Informasi Berkala', 'desc' => 'APBDes, RPJMDes, RKPDes, Peraturan Desa, dan laporan pertanggungjawaban yang dipublikasikan secara berkala.', 'color' => 'from-blue-500 to-blue-600', 'count' => $berkalaCount, 'countLabel' => 'dokumen'],
                    ['route' => 'ppid.setiap-saat', 'icon' => 'folder_open', 'title' => 'Informasi Setiap Saat', 'desc' => 'Daftar Informasi Publik, statistik, prosedur, dan perjanjian yang tersedia kapan saja.', 'color' => 'from-emerald-500 to-emerald-600', 'count' => $setiapSaatCount, 'countLabel' => 'dokumen'],
                    ['route' => 'ppid.serta-merta', 'icon' => 'campaign', 'title' => 'Informasi Serta Merta', 'desc' => 'Pengumuman darurat terkait bencana alam, wabah penyakit, dan peringatan keselamatan publik.', 'color' => 'from-amber-500 to-amber-600', 'count' => null, 'countLabel' => null],
                    ['route' => 'ppid.dikecualikan', 'icon' => 'lock', 'title' => 'Informasi Dikecualikan', 'desc' => 'Informasi yang dikecualikan dari akses publik beserta dasar hukum berdasarkan UU No. 14/2008.', 'color' => 'from-gray-500 to-gray-600', 'count' => null, 'countLabel' => null],
                    ['route' => 'ppid.permohonan', 'icon' => 'edit_note', 'title' => 'Permohonan Informasi', 'desc' => 'Ajukan permohonan informasi publik secara online. Setiap warga berhak mendapatkan informasi publik.', 'color' => 'from-desa-500 to-desa-600', 'count' => null, 'countLabel' => null],
                    ['route' => 'ppid.cek-status', 'icon' => 'search', 'title' => 'Cek Status Permohonan', 'desc' => 'Lacak status permohonan informasi yang telah Anda ajukan dengan nomor permohonan.', 'color' => 'from-violet-500 to-violet-600', 'count' => null, 'countLabel' => null],
                ];
            @endphp
            @foreach($modules as $mod)
                <a href="{{ route($mod['route']) }}" wire:navigate
                   class="card p-6 group hover:-translate-y-1 transition-all duration-300 flex flex-col">
                    <div class="flex items-start gap-4 mb-3">
                        <div class="flex-shrink-0 h-12 w-12 rounded-xl bg-gradient-to-br {{ $mod['color'] }} flex items-center justify-center shadow-md">
                            <span class="material-symbols-outlined text-white text-xl">{{ $mod['icon'] }}</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="font-bold text-gray-900 group-hover:text-desa-600 transition-colors">{{ $mod['title'] }}</h3>
                            @if($mod['count'] !== null)
                                <span class="text-xs text-desa-600 font-medium">{{ $mod['count'] }} {{ $mod['countLabel'] }}</span>
                            @endif
                        </div>
                    </div>
                    <p class="text-sm text-gray-500 leading-relaxed flex-1">{{ $mod['desc'] }}</p>
                    <div class="mt-4 flex items-center gap-1 text-sm text-desa-600 font-medium">
                        Lihat <span class="material-symbols-outlined text-sm group-hover:translate-x-1 transition-transform">arrow_forward</span>
                    </div>
                </a>
            @endforeach
        </div>

        {{-- Legal Info --}}
        <div class="card p-6">
            <div class="flex items-start gap-4">
                <div class="flex-shrink-0 h-10 w-10 rounded-lg bg-desa-50 flex items-center justify-center">
                    <span class="material-symbols-outlined text-desa-600">gavel</span>
                </div>
                <div class="text-sm text-gray-600 leading-relaxed">
                    <h3 class="font-bold text-gray-900 mb-1">Dasar Hukum PPID</h3>
                    <p>Pengelolaan informasi publik di tingkat desa didasarkan pada <strong>Undang-Undang Nomor 14 Tahun 2008 tentang Keterbukaan Informasi Publik (KIP)</strong> dan <strong>PP Nomor 61 Tahun 2010</strong> tentang pelaksanaannya. Setiap warga negara berhak memperoleh informasi publik sesuai dengan ketentuan yang berlaku.</p>
                </div>
            </div>
        </div>
    </section>
</div>
