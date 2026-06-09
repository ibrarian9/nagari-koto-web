<div>
    {{-- ─── HERO ─────────────────────────────────── --}}
    <section class="relative bg-gradient-to-br from-desa-600 via-desa-700 to-desa-900 overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div
                class="absolute top-0 right-0 w-96 h-96 bg-amber-400 rounded-full filter blur-3xl translate-x-1/2 -translate-y-1/2">
            </div>
            <div
                class="absolute bottom-0 left-0 w-64 h-64 bg-white rounded-full filter blur-3xl -translate-x-1/2 translate-y-1/2">
            </div>
        </div>
        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16 md:py-24">
            <div class="grid grid-cols-1 lg:grid-cols-5 gap-10 items-center">
                <div class="lg:col-span-3">
                    <div
                        class="inline-flex items-center gap-2 rounded-full bg-white/10 backdrop-blur-sm px-4 py-1.5 text-sm text-amber-300 mb-4">
                        <span class="material-symbols-outlined text-base">policy</span>
                        PPID Nagari
                    </div>
                    <h1 class="text-4xl md:text-5xl font-extrabold text-white leading-tight tracking-tight">
                        Pejabat Pengelola Informasi & Dokumentasi
                    </h1>
                    <p class="mt-3 text-lg text-desa-100 max-w-lg">
                        Transparansi informasi publik untuk masyarakat Nagari Duo Koto
                    </p>
                </div>
                {{-- Quick Info Cards --}}
                <div class="lg:col-span-2 grid grid-cols-2 gap-3">
                    @foreach ([['icon' => 'schedule', 'value' => $berkalaCount, 'label' => 'Info Berkala'], ['icon' => 'folder_open', 'value' => $setiapSaatCount, 'label' => 'Info Setiap Saat'], ['icon' => 'assignment', 'value' => $permohonanCount, 'label' => 'Permohonan'], ['icon' => 'gavel', 'value' => 'UU 14/2008', 'label' => 'Dasar Hukum']] as $qi)
                        <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 text-center border border-white/10">
                            <span
                                class="material-symbols-outlined text-amber-300 text-xl mb-1">{{ $qi['icon'] }}</span>
                            <p class="text-xl font-extrabold text-white">{{ $qi['value'] }}</p>
                            <p class="text-xs text-desa-200">{{ $qi['label'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- ─── NAVIGATION TABS ─────────────────────────────────── --}}
    <section wire:ignore.self class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12" x-data="{ 
        tab: (new URLSearchParams(window.location.search)).get('tab') || 'profil', 
        sub: (new URLSearchParams(window.location.search)).get('sub') || ((new URLSearchParams(window.location.search)).get('tab') === 'dip' ? 'info_berkala' : 'alur_info'),
        _popstateHandler: null,
        _navigatedHandler: null,
        init() {
            this.$watch('tab', val => {
                const url = new URL(window.location);
                url.searchParams.set('tab', val);
                if (val !== 'pelayanan') {
                    url.searchParams.delete('sub');
                }
                window.history.replaceState({}, '', url);
            });
            this.$watch('sub', val => {
                if (this.tab === 'pelayanan') {
                    const url = new URL(window.location);
                    url.searchParams.set('sub', val);
                    window.history.replaceState({}, '', url);
                }
            });
            this._popstateHandler = () => {
                const params = new URLSearchParams(window.location.search);
                this.tab = params.get('tab') || 'profil';
                this.sub = params.get('sub') || 'alur_info';
            };
            this._navigatedHandler = () => {
                const params = new URLSearchParams(window.location.search);
                this.tab = params.get('tab') || 'profil';
                this.sub = params.get('sub') || 'alur_info';
            };
            window.addEventListener('popstate', this._popstateHandler);
            document.addEventListener('livewire:navigated', this._navigatedHandler);
        },
        destroy() {
            if (this._popstateHandler) window.removeEventListener('popstate', this._popstateHandler);
            if (this._navigatedHandler) document.removeEventListener('livewire:navigated', this._navigatedHandler);
        }
    }">
        
        {{-- ─── MOBILE MENU SELECTOR (lg:hidden) ─────────────────── --}}
        <div class="lg:hidden mb-6" x-data="{ mobileMenuOpen: false }">
            <button @click="mobileMenuOpen = true" class="w-full flex items-center justify-between bg-white px-5 py-4 rounded-xl border border-gray-200 shadow-xs text-left active:scale-[0.99] transition-all">
                <div class="flex items-center gap-3">
                    <div class="h-10 w-10 rounded-xl bg-desa-50 flex items-center justify-center text-desa-600">
                        <span class="material-symbols-outlined text-xl" x-text="
                            tab === 'profil' ? 'badge' :
                            tab === 'visi' ? 'visibility' :
                            tab === 'tugas' ? 'assignment' :
                            tab === 'struktur' ? 'account_tree' :
                            tab === 'dip' ? 'list_alt' :
                            tab === 'pelayanan' ? 'support_agent' :
                            tab === 'maklumat' ? 'verified' :
                            tab === 'jadwal' ? 'event_note' :
                            tab === 'dikecualikan' ? 'lock' :
                            tab === 'regulasi' ? 'gavel' : 'badge'
                        "></span>
                    </div>
                    <div>
                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Menu Aktif PPID</p>
                        <p class="text-sm font-bold text-gray-900" x-text="
                            tab === 'profil' ? 'Profil Singkat' :
                            tab === 'visi' ? 'Visi & Misi' :
                            tab === 'tugas' ? 'Tugas & Fungsi' :
                            tab === 'struktur' ? 'Struktur Organisasi' :
                            tab === 'dip' ? 'Informasi Publik' :
                            tab === 'pelayanan' ? 'Pelayanan Publik' :
                            tab === 'maklumat' ? 'Maklumat Pelayanan' :
                            tab === 'jadwal' ? 'Jadwal & Biaya' :
                            tab === 'dikecualikan' ? 'Informasi Dikecualikan' :
                            tab === 'regulasi' ? 'Regulasi' : 'Profil Singkat'
                        "></p>
                    </div>
                </div>
                <div class="flex items-center gap-1.5 text-gray-400">
                    <span class="text-xs font-semibold text-desa-600 bg-desa-50 px-2.5 py-1 rounded-lg">Pilih Menu</span>
                    <span class="material-symbols-outlined text-lg">unfold_more</span>
                </div>
            </button>

            <!-- Bottom Sheet Modal Drawer -->
            <div x-show="mobileMenuOpen" 
                 class="fixed inset-0 z-50 overflow-hidden" 
                 style="display: none;"
                 role="dialog" 
                 aria-modal="true">
                <!-- Overlay backdrop -->
                <div x-show="mobileMenuOpen"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     @click="mobileMenuOpen = false"
                     class="absolute inset-0 bg-black/50 backdrop-blur-xs"></div>

                <!-- Drawer Content -->
                <div x-show="mobileMenuOpen"
                     x-transition:enter="transition ease-out duration-300 transform translate-y-0"
                     x-transition:enter-start="translate-y-full"
                     x-transition:enter-end="translate-y-0"
                     x-transition:leave="transition ease-in duration-200 transform translate-y-0"
                     x-transition:leave-start="translate-y-0"
                     x-transition:leave-end="translate-y-full"
                     class="absolute inset-x-0 bottom-0 max-h-[85vh] flex flex-col bg-white rounded-t-2xl shadow-xl overflow-hidden">
                    <!-- Header Drawer -->
                    <div class="flex items-center justify-between p-4 border-b border-gray-150 bg-gray-50/50">
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-desa-600">policy</span>
                            <h3 class="font-bold text-gray-900">Pilih Menu PPID</h3>
                        </div>
                        <button @click="mobileMenuOpen = false" class="h-8 w-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-400 hover:text-gray-600 transition-colors">
                            <span class="material-symbols-outlined text-lg">close</span>
                        </button>
                    </div>

                    <!-- Options List -->
                    <div class="flex-1 overflow-y-auto p-4 space-y-6 pb-8">
                        <!-- Group 1: Profil -->
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 px-2 flex items-center gap-1.5">
                                <span class="h-1.5 w-1.5 rounded-full bg-desa-500"></span> Profil PPID
                            </p>
                            <div class="grid grid-cols-1 gap-1">
                                @foreach([
                                    ['key' => 'profil', 'label' => 'Profil Singkat', 'icon' => 'badge'],
                                    ['key' => 'visi', 'label' => 'Visi & Misi', 'icon' => 'visibility'],
                                    ['key' => 'tugas', 'label' => 'Tugas & Fungsi', 'icon' => 'assignment'],
                                    ['key' => 'struktur', 'label' => 'Struktur Organisasi', 'icon' => 'account_tree'],
                                ] as $m)
                                    <button @click="tab = '{{ $m['key'] }}'; mobileMenuOpen = false;"
                                            :class="tab === '{{ $m['key'] }}' ? 'bg-desa-50 text-desa-700 font-bold border-l-4 border-desa-500 pl-2' : 'text-gray-600 hover:bg-gray-50'"
                                            class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-left transition-all">
                                        <span class="material-symbols-outlined text-lg" :class="tab === '{{ $m['key'] }}' ? 'text-desa-600' : 'text-gray-400'">{{ $m['icon'] }}</span>
                                        {{ $m['label'] }}
                                    </button>
                                @endforeach
                            </div>
                        </div>

                        <!-- Group 2: Informasi & Layanan -->
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 px-2 flex items-center gap-1.5">
                                <span class="h-1.5 w-1.5 rounded-full bg-desa-500"></span> Informasi & Layanan
                            </p>
                            <div class="grid grid-cols-1 gap-1">
                                @foreach([
                                    ['key' => 'dip', 'label' => 'Informasi Publik', 'icon' => 'list_alt'],
                                    ['key' => 'pelayanan', 'label' => 'Pelayanan Publik', 'icon' => 'support_agent'],
                                    ['key' => 'maklumat', 'label' => 'Maklumat Pelayanan', 'icon' => 'verified'],
                                    ['key' => 'jadwal', 'label' => 'Jadwal & Biaya', 'icon' => 'event_note'],
                                    ['key' => 'dikecualikan', 'label' => 'Informasi Dikecualikan', 'icon' => 'lock'],
                                ] as $m)
                                    <button @click="tab = '{{ $m['key'] }}'; if('{{ $m['key'] }}' === 'dip') sub = 'info_berkala'; if('{{ $m['key'] }}' === 'pelayanan') sub = 'alur_info'; mobileMenuOpen = false;"
                                            :class="tab === '{{ $m['key'] }}' ? 'bg-desa-50 text-desa-700 font-bold border-l-4 border-desa-500 pl-2' : 'text-gray-600 hover:bg-gray-50'"
                                            class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-left transition-all">
                                        <span class="material-symbols-outlined text-lg" :class="tab === '{{ $m['key'] }}' ? 'text-desa-600' : 'text-gray-400'">{{ $m['icon'] }}</span>
                                        {{ $m['label'] }}
                                    </button>
                                @endforeach
                            </div>
                        </div>

                        <!-- Group 3: Regulasi -->
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 px-2 flex items-center gap-1.5">
                                <span class="h-1.5 w-1.5 rounded-full bg-desa-500"></span> Regulasi
                            </p>
                            <div class="grid grid-cols-1 gap-1">
                                @foreach([
                                    ['key' => 'regulasi', 'label' => 'Regulasi', 'icon' => 'gavel'],
                                ] as $m)
                                    <button @click="tab = '{{ $m['key'] }}'; mobileMenuOpen = false;"
                                            :class="tab === '{{ $m['key'] }}' ? 'bg-desa-50 text-desa-700 font-bold border-l-4 border-desa-500 pl-2' : 'text-gray-600 hover:bg-gray-50'"
                                            class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-left transition-all">
                                        <span class="material-symbols-outlined text-lg" :class="tab === '{{ $m['key'] }}' ? 'text-desa-600' : 'text-gray-400'">{{ $m['icon'] }}</span>
                                        {{ $m['label'] }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ─── MAIN HUB LAYOUT GRID ─────────────────────────────── --}}
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8 items-start">
            
            {{-- DESKTOP SIDEBAR --}}
            <div class="hidden lg:block lg:col-span-1 sticky top-24 space-y-6">
                <!-- Sidebar Menu Card -->
                <div class="bg-white rounded-2xl border border-gray-150 shadow-xs p-4 space-y-6">
                    <!-- Group 1: Profil PPID -->
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 px-2 flex items-center gap-1.5">
                            <span class="h-1.5 w-1.5 rounded-full bg-desa-500"></span> Profil PPID
                        </p>
                        <div class="space-y-1">
                            @foreach([
                                ['key' => 'profil', 'label' => 'Profil Singkat', 'icon' => 'badge'],
                                ['key' => 'visi', 'label' => 'Visi & Misi', 'icon' => 'visibility'],
                                ['key' => 'tugas', 'label' => 'Tugas & Fungsi', 'icon' => 'assignment'],
                                ['key' => 'struktur', 'label' => 'Struktur Organisasi', 'icon' => 'account_tree'],
                            ] as $m)
                                <button @click="tab = '{{ $m['key'] }}'"
                                        :class="tab === '{{ $m['key'] }}' ? 'bg-desa-50 text-desa-700 font-bold border-l-4 border-desa-500 pl-2' : 'text-gray-600 hover:bg-gray-50'"
                                        class="w-full flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-left transition-all duration-150 hover:pl-4">
                                    <span class="material-symbols-outlined text-lg" :class="tab === '{{ $m['key'] }}' ? 'text-desa-600' : 'text-gray-400'">{{ $m['icon'] }}</span>
                                    {{ $m['label'] }}
                                </button>
                            @endforeach
                        </div>
                    </div>

                    <!-- Group 2: Informasi & Layanan -->
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 px-2 flex items-center gap-1.5">
                            <span class="h-1.5 w-1.5 rounded-full bg-desa-500"></span> Informasi & Layanan
                        </p>
                        <div class="space-y-1">
                            @foreach([
                                ['key' => 'dip', 'label' => 'Informasi Publik', 'icon' => 'list_alt'],
                                ['key' => 'pelayanan', 'label' => 'Pelayanan Publik', 'icon' => 'support_agent'],
                                ['key' => 'maklumat', 'label' => 'Maklumat Pelayanan', 'icon' => 'verified'],
                                ['key' => 'jadwal', 'label' => 'Jadwal & Biaya', 'icon' => 'event_note'],
                                ['key' => 'dikecualikan', 'label' => 'Informasi Dikecualikan', 'icon' => 'lock'],
                            ] as $m)
                                <button @click="tab = '{{ $m['key'] }}'; if('{{ $m['key'] }}' === 'dip') sub = 'info_berkala'; if('{{ $m['key'] }}' === 'pelayanan') sub = 'alur_info';"
                                        :class="tab === '{{ $m['key'] }}' ? 'bg-desa-50 text-desa-700 font-bold border-l-4 border-desa-500 pl-2' : 'text-gray-600 hover:bg-gray-50'"
                                        class="w-full flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-left transition-all duration-150 hover:pl-4">
                                    <span class="material-symbols-outlined text-lg" :class="tab === '{{ $m['key'] }}' ? 'text-desa-600' : 'text-gray-400'">{{ $m['icon'] }}</span>
                                    {{ $m['label'] }}
                                </button>
                            @endforeach
                        </div>
                    </div>

                    <!-- Group 3: Regulasi -->
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 px-2 flex items-center gap-1.5">
                            <span class="h-1.5 w-1.5 rounded-full bg-desa-500"></span> Regulasi
                        </p>
                        <div class="space-y-1">
                            @foreach([
                                ['key' => 'regulasi', 'label' => 'Regulasi', 'icon' => 'gavel'],
                            ] as $m)
                                <button @click="tab = '{{ $m['key'] }}'"
                                        :class="tab === '{{ $m['key'] }}' ? 'bg-desa-50 text-desa-700 font-bold border-l-4 border-desa-500 pl-2' : 'text-gray-600 hover:bg-gray-50'"
                                        class="w-full flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-left transition-all duration-150 hover:pl-4">
                                    <span class="material-symbols-outlined text-lg" :class="tab === '{{ $m['key'] }}' ? 'text-desa-600' : 'text-gray-400'">{{ $m['icon'] }}</span>
                                    {{ $m['label'] }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Quick Actions Widget -->
                <div class="bg-gradient-to-br from-desa-700 to-desa-900 rounded-2xl p-5 text-white shadow-sm border border-desa-800 space-y-4">
                    <div>
                        <h4 class="font-bold text-sm">Layanan Online PPID</h4>
                        <p class="text-[11px] text-desa-200 mt-1">Ajukan permohonan informasi publik secara online atau periksa status pengajuan Anda.</p>
                    </div>
                    <div class="space-y-2 pt-1">
                        <button @click="tab = 'pelayanan'; sub = 'permohonan';" 
                                class="w-full inline-flex items-center justify-center gap-2 rounded-xl bg-amber-500 hover:bg-amber-600 text-white py-2.5 text-xs font-bold transition-all shadow-sm active:scale-[0.98]">
                            <span class="material-symbols-outlined text-base">edit_note</span> Ajukan Permohonan
                        </button>
                        <a href="{{ route('ppid.cek-status') }}" wire:navigate
                           class="w-full inline-flex items-center justify-center gap-2 rounded-xl bg-white/10 hover:bg-white/15 text-white border border-white/10 py-2.5 text-xs font-bold transition-all active:scale-[0.98]">
                            <span class="material-symbols-outlined text-base">search</span> Cek Status Online
                        </a>
                    </div>
                </div>
            </div>

            {{-- CONTENT COLUMN --}}
            <div class="lg:col-span-3 space-y-8">
                
                {{-- Tab 1: Profil Singkat --}}
                <div x-show="tab === 'profil'" x-transition>
                    <div class="space-y-6">
                        <div class="card p-6 md:p-8">
                            <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                                <span class="material-symbols-outlined text-desa-500">badge</span>
                                {{ $profil->title }}
                            </h2>
                            @if ($profil->content)
                                <div class="prose max-w-none text-gray-700 leading-relaxed whitespace-pre-line">
                                    {{ $profil->content }}</div>
                            @else
                                <p class="text-gray-400">Belum ada data profil PPID.</p>
                            @endif
                        </div>
                        
                        <div class="card p-6">
                            <h3 class="font-bold text-gray-900 text-sm mb-4 flex items-center gap-2">
                                <span class="material-symbols-outlined text-desa-500 text-lg">gavel</span>
                                Dasar Hukum & Acuan Regulasi
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                                @foreach ([
                                    ['label' => 'Undang-Undang', 'value' => 'UU No. 14 Tahun 2008', 'desc' => 'Tentang Keterbukaan Informasi Publik'], 
                                    ['label' => 'Peraturan Pemerintah', 'value' => 'PP No. 61 Tahun 2010', 'desc' => 'Pelaksanaan UU Keterbukaan Informasi Publik'], 
                                    ['label' => 'Peraturan Komisi Informasi', 'value' => 'PERKI No. 1 Tahun 2021', 'desc' => 'Standar Layanan Informasi Publik']
                                ] as $item)
                                    <div class="bg-gray-50/50 p-4 rounded-xl border border-gray-150">
                                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">{{ $item['label'] }}</p>
                                        <p class="font-semibold text-gray-900 mt-1">{{ $item['value'] }}</p>
                                        <p class="text-xs text-gray-550 mt-1">{{ $item['desc'] }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

        {{-- Tab 2: Visi & Misi --}}
        <div x-show="tab === 'visi'" x-transition>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div class="card p-6 md:p-8 bg-gradient-to-br from-desa-50 to-white border-2 border-desa-100">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="h-12 w-12 rounded-xl bg-desa-500 flex items-center justify-center">
                            <span class="material-symbols-outlined text-white text-2xl">flag</span>
                        </div>
                        <h2 class="text-xl font-bold text-gray-900">Visi PPID</h2>
                    </div>
                    @php
                        // Use content field directly; fallback to regex split for legacy data
                        if (!empty($visiMisi->content_extra)) {
                            $visiText = trim($visiMisi->content ?? '');
                        } else {
                            $parts = preg_split('/\n\s*MISI\s*\n/i', $visiMisi->content ?? '', 2);
                            $visiText = trim(preg_replace('/^VISI\s*\n/i', '', $parts[0] ?? ''));
                        }
                    @endphp
                    @if ($visiText)
                        <div class="prose max-w-none text-gray-700 leading-relaxed whitespace-pre-line">
                            {{ $visiText }}</div>
                    @else
                        <p class="text-gray-400">Belum ada data visi.</p>
                    @endif
                </div>
                <div class="card p-6 md:p-8">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="h-12 w-12 rounded-xl bg-desa-500 flex items-center justify-center">
                            <span class="material-symbols-outlined text-white text-2xl">checklist</span>
                        </div>
                        <h2 class="text-xl font-bold text-gray-900">Misi PPID</h2>
                    </div>
                    @php
                        // Use content_extra if available; fallback to regex split
                        if (!empty($visiMisi->content_extra)) {
                            $misiText = trim($visiMisi->content_extra);
                        } else {
                            $misiText = trim($parts[1] ?? '');
                        }
                    @endphp
                    @if ($misiText)
                        <div class="prose max-w-none text-gray-700 leading-relaxed whitespace-pre-line">
                            {{ $misiText }}</div>
                    @else
                        <p class="text-gray-400">Belum ada data misi.</p>
                    @endif
                </div>
            </div>
        </div>

        {{-- Tab 3: Tugas & Fungsi --}}
        <div x-show="tab === 'tugas'" x-transition>
            <div class="space-y-8">
                {{-- Split Layout: Tugas | Fungsi --}}
                @php
                    // Use content_extra if available; fallback to regex split for legacy data
                    if (!empty($tugasFungsi->content_extra)) {
                        $tugasText = trim($tugasFungsi->content ?? '');
                        $fungsiText = trim($tugasFungsi->content_extra);
                    } else {
                        $tfContent = $tugasFungsi->content ?? '';
                        $tfParts = preg_split('/\n\s*FUNGSI\s+PPID\s*\n/i', $tfContent, 2);
                        $tugasText = trim(preg_replace('/^TUGAS\s+PPID\s*\n/i', '', $tfParts[0] ?? ''));
                        $fungsiText = trim($tfParts[1] ?? '');
                    }
                @endphp

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    {{-- Tugas Card --}}
                    <div class="card p-6 md:p-8 bg-gradient-to-br from-desa-50 to-white border-2 border-desa-100">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="h-12 w-12 rounded-xl bg-desa-500 flex items-center justify-center">
                                <span class="material-symbols-outlined text-white text-2xl">assignment</span>
                            </div>
                            <h2 class="text-xl font-bold text-gray-900">Tugas PPID</h2>
                        </div>
                        @if ($tugasText)
                            <div class="prose max-w-none text-gray-700 leading-relaxed whitespace-pre-line">
                                {{ $tugasText }}</div>
                        @else
                            <p class="text-gray-400">Belum ada data tugas PPID.</p>
                        @endif
                    </div>

                    {{-- Fungsi Card --}}
                    <div class="card p-6 md:p-8">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="h-12 w-12 rounded-xl bg-desa-500 flex items-center justify-center">
                                <span class="material-symbols-outlined text-white text-2xl">settings_suggest</span>
                            </div>
                            <h2 class="text-xl font-bold text-gray-900">Fungsi PPID</h2>
                        </div>
                        @if ($fungsiText)
                            <div class="prose max-w-none text-gray-700 leading-relaxed whitespace-pre-line">
                                {{ $fungsiText }}</div>
                        @else
                            <p class="text-gray-400">Belum ada data fungsi PPID.</p>
                        @endif
                    </div>
                </div>

                {{-- PDF Preview --}}
                @if ($tugasFungsi->attachment)
                    <div class="card overflow-hidden">
                        <div
                            class="p-5 border-b border-gray-100 flex f lex-col sm:flex-row sm:items-center sm:justify-between gap-3 bg-gradient-to-r from-desa-50 to-amber-50">
                            <div class="flex items-center gap-3">
                                <div
                                    class="h-10 w-10 rounded-lg bg-gradient-to-br from-red-500 to-red-600 flex items-center justify-center flex-shrink-0">
                                    <span class="material-symbols-outlined text-white">picture_as_pdf</span>
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-900">Lampiran Dokumen</h3>
                                    <p class="text-xs text-gray-500">Dokumen tugas dan fungsi PPID</p>
                                </div>
                            </div>
                            <a href="{{ Storage::url($tugasFungsi->attachment) }}" target="_blank"
                                class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-desa-500 to-desa-600 hover:from-desa-600 hover:to-desa-700 text-white rounded-xl text-sm font-semibold shadow-md transition-all">
                                <span class="material-symbols-outlined text-base">download</span> Unduh PDF
                            </a>
                        </div>
                        <div class="bg-gray-100" style="height: 80vh; min-height: 500px;">
                            <iframe src="{{ Storage::url($tugasFungsi->attachment) }}#toolbar=1&navpanes=0"
                                class="w-full h-full border-0" loading="lazy"
                                title="Preview Dokumen Tugas & Fungsi PPID"></iframe>
                        </div>
                    </div>
                @endif

                {{-- Action Cards --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="card p-6 bg-gradient-to-br from-desa-50 to-white border-2 border-desa-100">
                        <div class="text-center">
                            <span class="material-symbols-outlined text-4xl text-desa-500 mb-2">edit_note</span>
                            <h3 class="font-bold text-gray-900 text-sm">Permohonan Informasi</h3>
                            <p class="text-xs text-gray-400 mt-1 mb-3">Ajukan permohonan informasi publik</p>
                            <a href="{{ route('ppid.permohonan') }}" wire:navigate
                                class="btn-primary btn-sm w-full justify-center">
                                <span class="material-symbols-outlined text-sm">send</span> Ajukan
                            </a>
                        </div>
                    </div>
                    <div class="card p-6 bg-gradient-to-br from-amber-50 to-white border-2 border-amber-100">
                        <div class="text-center">
                            <span class="material-symbols-outlined text-4xl text-amber-500 mb-2">search</span>
                            <h3 class="font-bold text-gray-900 text-sm">Cek Status Permohonan</h3>
                            <p class="text-xs text-gray-400 mt-1 mb-3">Lacak permohonan informasi Anda</p>
                            <a href="{{ route('ppid.cek-status') }}" wire:navigate
                                class="btn-secondary btn-sm w-full justify-center">
                                <span class="material-symbols-outlined text-sm">search</span> Cek Status
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tab 4: Struktur Organisasi --}}
        <div x-show="tab === 'struktur'" x-transition>
            @php
                $membersData = $struktur->members_data ?? [];
                $leader = collect($membersData)->firstWhere('is_leader', true);
                $others = collect($membersData)->where('is_leader', '!=', true)->values();
            @endphp

            @if (count($membersData))
                {{-- Pimpinan Card --}}
                @if ($leader)
                    <div class="max-w-lg mx-auto mb-2">
                        <div
                            class="bg-white rounded-2xl shadow-xl shadow-desa-900/10 border border-gray-100 p-6 md:p-8 flex flex-col sm:flex-row items-center gap-6 hover:shadow-2xl transition-all duration-300">
                            <div class="flex-shrink-0">
                                <div
                                    class="h-24 w-24 md:h-28 md:w-28 rounded-2xl bg-gradient-to-br from-desa-100 to-desa-50 overflow-hidden ring-4 ring-desa-200/50 flex items-center justify-center">
                                    @if (!empty($leader['photo']))
                                        <img src="{{ Storage::url($leader['photo']) }}" alt="{{ $leader['name'] }}" class="h-full w-full object-cover">
                                    @else
                                        <span class="material-symbols-outlined text-5xl text-desa-300">person</span>
                                    @endif
                                </div>
                            </div>
                            <div class="text-center sm:text-left">
                                <span
                                    class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-amber-100 text-amber-700 text-xs font-semibold mb-2">
                                    <span class="material-symbols-outlined text-xs">star</span>
                                    {{ $leader['position'] ?? 'Pimpinan' }}
                                </span>
                                <h2 class="text-xl md:text-2xl font-bold text-gray-900">{{ $leader['name'] }}</h2>
                                <p class="text-desa-600 font-semibold mt-0.5">{{ $leader['role'] ?? '' }}</p>
                                @if (!empty($leader['desc']))
                                    <p class="text-sm text-gray-400 mt-1">{{ $leader['desc'] }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Connector --}}
                @if ($leader && $others->count())
                    <div class="flex justify-center mb-2">
                        <div class="flex flex-col items-center">
                            <div class="w-px h-10 bg-gradient-to-b from-desa-300 to-desa-200"></div>
                            <div class="h-3 w-3 rounded-full bg-desa-300 ring-4 ring-desa-100"></div>
                        </div>
                    </div>
                @endif

                {{-- Anggota Cards --}}
                @if ($others->count())
                    <div class="mb-8">
                        <div class="text-center mb-6">
                            <h3
                                class="text-sm font-bold text-gray-400 uppercase tracking-widest flex items-center justify-center gap-2">
                                <span class="h-px w-8 bg-gray-300"></span> Pejabat PPID <span
                                    class="h-px w-8 bg-gray-300"></span>
                            </h3>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 max-w-5xl mx-auto">
                            @foreach ($others as $member)
                                <div
                                    class="bg-white rounded-xl border border-gray-100 shadow-sm hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300 p-5">
                                    <div class="flex items-center gap-4">
                                    <div
                                        class="flex-shrink-0 h-14 w-14 rounded-xl bg-gradient-to-br from-desa-50 to-emerald-50 overflow-hidden ring-2 ring-desa-100 flex items-center justify-center">
                                        @if (!empty($member['photo']))
                                            <img src="{{ Storage::url($member['photo']) }}" alt="{{ $member['name'] }}" class="h-full w-full object-cover">
                                        @else
                                            <span
                                                class="material-symbols-outlined text-2xl text-desa-300">person</span>
                                        @endif
                                    </div>
                                        <div class="min-w-0">
                                            <h4 class="font-semibold text-gray-900 truncate">{{ $member['name'] }}
                                            </h4>
                                            <p class="text-sm text-desa-600 font-medium mt-0.5">
                                                {{ $member['position'] ?? '' }}</p>
                                            @if (!empty($member['role']))
                                                <p class="text-xs text-gray-400 mt-0.5">{{ $member['role'] }}</p>
                                            @endif
                                        </div>
                                    </div>
                                    @if (!empty($member['desc']))
                                        <p
                                            class="mt-3 text-xs text-gray-500 leading-relaxed border-t border-gray-100 pt-3">
                                            {{ $member['desc'] }}</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endif

            {{-- Bagan Image --}}
            @if ($struktur->image)
                <div class="card p-4 md:p-6 mb-8">
                    <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <span class="material-symbols-outlined text-desa-500">account_tree</span>
                        Bagan Struktur Organisasi
                    </h2>
                    <div x-data="{ showLightbox: false }">
                        <div class="rounded-xl overflow-hidden border border-gray-100 cursor-pointer group relative" @click="showLightbox = true">
                            <img src="{{ Storage::url($struktur->image) }}" alt="Bagan Struktur Organisasi PPID"
                                class="w-full object-contain max-h-80" loading="lazy" decoding="async">
                            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors duration-200 flex items-center justify-center">
                                <span class="material-symbols-outlined text-white text-3xl opacity-0 group-hover:opacity-100 transition-opacity duration-200 drop-shadow-lg">zoom_in</span>
                            </div>
                        </div>
                        {{-- Lightbox --}}
                        <div x-show="showLightbox" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="showLightbox = false" @keydown.escape.window="showLightbox = false" class="fixed inset-0 z-[100] flex items-center justify-center bg-black/70 backdrop-blur-sm p-4 cursor-zoom-out" style="display: none;">
                            <img src="{{ Storage::url($struktur->image) }}" alt="Bagan Struktur Organisasi PPID" class="max-w-full max-h-[90vh] object-contain rounded-xl shadow-2xl" @click.stop>
                            <button @click="showLightbox = false" class="absolute top-4 right-4 h-10 w-10 rounded-full bg-white/20 hover:bg-white/30 flex items-center justify-center text-white transition-colors">
                                <span class="material-symbols-outlined">close</span>
                            </button>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Info Box --}}
            @if ($struktur->content)
                <div
                    class="bg-gradient-to-br from-desa-50 to-white rounded-2xl border border-desa-100 p-6 md:p-8 max-w-4xl mx-auto">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="h-10 w-10 rounded-xl bg-desa-100 flex items-center justify-center">
                            <span class="material-symbols-outlined text-xl text-desa-600">info</span>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900">Tentang Struktur PPID</h3>
                    </div>
                    <div class="prose max-w-none text-gray-600 text-sm leading-relaxed whitespace-pre-line">
                        {{ $struktur->content }}</div>
                </div>
            @endif

            @if (!count($membersData) && !$struktur->content && !$struktur->image)
                <div class="card p-12 text-center">
                    <span class="material-symbols-outlined text-4xl text-gray-200 mb-3">account_tree</span>
                    <p class="text-gray-400">Struktur organisasi belum diisi oleh admin.</p>
                </div>
            @endif
        </div>

        @include('livewire.public.ppid._tabs-new')

            </div> {{-- End of Content Column --}}
        </div> {{-- End of Grid Layout --}}
    </section>

    @include('livewire.public.ppid._comments')

    {{-- ─── LEGAL INFO BAR ─────────────────────────────────── --}}
    <section class="bg-desa-50 py-10">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-6">
                <div>
                    <h3 class="font-bold text-gray-900 text-lg">Layanan Informasi Publik</h3>
                    <p class="text-sm text-gray-500">Berdasarkan UU No. 14 Tahun 2008 tentang Keterbukaan Informasi
                        Publik</p>
                </div>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('ppid.permohonan') }}" wire:navigate class="btn-primary btn-sm">
                        <span class="material-symbols-outlined text-base">edit_note</span> Ajukan Permohonan
                    </a>
                    <a href="{{ route('ppid.cek-status') }}" wire:navigate class="btn-secondary btn-sm">
                        <span class="material-symbols-outlined text-base">search</span> Cek Status
                    </a>
                </div>
            </div>
        </div>
    </section>
</div>
