<div>
    <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12">
        {{-- Page Header --}}
        <div class="text-center mb-16 relative">
            <div class="absolute -top-6 left-1/2 -translate-x-1/2 w-40 h-40 bg-blue-500/5 rounded-full filter blur-2xl -z-10"></div>

            @if ($profile->logo)
                <img src="{{ Storage::url($profile->logo) }}" alt="{{ $profile->name }}"
                    class="h-20 w-20 mx-auto mb-4 object-contain rounded-2xl shadow-lg shadow-blue-500/10 ring-4 ring-white">
            @else
                <div
                    class="inline-flex items-center justify-center h-16 w-16 rounded-2xl bg-gradient-to-br from-blue-500 to-blue-700 mb-4 shadow-lg shadow-blue-500/20">
                    <span class="material-symbols-outlined text-white text-3xl">store</span>
                </div>
            @endif

            <h1 class="section-title">{{ $profile->name }}</h1>
            <p class="section-subtitle max-w-2xl mx-auto">
                Badan Usaha Milik Nagari — Motor penggerak ekonomi masyarakat desa yang mandiri dan berdaya saing.
            </p>

            {{-- Sub-navigation --}}
            @include('livewire.public.bumnag._subnav')
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            {{-- Main Content --}}
            <div class="lg:col-span-8 space-y-8">
                {{-- Deskripsi --}}
                @if ($profile->description)
                    <div class="card p-6 sm:p-8 bg-white border border-gray-150/60">
                        <h2 class="text-lg font-extrabold text-gray-900 flex items-center gap-2 mb-4">
                            <span class="material-symbols-outlined text-blue-600">description</span>
                            Tentang {{ $profile->name }}
                        </h2>
                        <div class="prose prose-sm max-w-none text-gray-600 leading-relaxed">
                            {!! nl2br(e($profile->description)) !!}
                        </div>
                    </div>
                @endif

                {{-- Sejarah --}}
                @if ($profile->sejarah)
                    <div class="card p-6 sm:p-8 bg-white border border-gray-150/60">
                        <h2 class="text-lg font-extrabold text-gray-900 flex items-center gap-2 mb-4">
                            <span class="material-symbols-outlined text-amber-600">history_edu</span>
                            Sejarah BUMNag
                        </h2>
                        <div class="prose prose-sm max-w-none text-gray-600 leading-relaxed">
                            {!! nl2br(e($profile->sejarah)) !!}
                        </div>
                    </div>
                @endif

                {{-- Visi & Misi --}}
                @if ($profile->visi || $profile->misi)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @if ($profile->visi)
                            <div class="card p-6 bg-gradient-to-br from-blue-50/50 to-white border border-blue-100/60">
                                <div class="flex items-center gap-2 mb-3">
                                    <div class="h-8 w-8 rounded-lg bg-blue-100 flex items-center justify-center text-blue-600">
                                        <span class="material-symbols-outlined text-base">visibility</span>
                                    </div>
                                    <h3 class="font-extrabold text-gray-900 text-sm">Visi</h3>
                                </div>
                                <p class="text-sm text-gray-700 leading-relaxed italic">"{{ $profile->visi }}"</p>
                            </div>
                        @endif

                        @if ($profile->misi)
                            <div class="card p-6 bg-gradient-to-br from-emerald-50/50 to-white border border-emerald-100/60">
                                <div class="flex items-center gap-2 mb-3">
                                    <div class="h-8 w-8 rounded-lg bg-emerald-100 flex items-center justify-center text-emerald-600">
                                        <span class="material-symbols-outlined text-base">flag</span>
                                    </div>
                                    <h3 class="font-extrabold text-gray-900 text-sm">Misi</h3>
                                </div>
                                <div class="text-sm text-gray-700 leading-relaxed">
                                    {!! nl2br(e($profile->misi)) !!}
                                </div>
                            </div>
                        @endif
                    </div>
                @endif

                {{-- Unit Usaha --}}
                @if (!empty($profile->unit_usaha))
                    <div>
                        <div class="flex items-center gap-3 border-b border-gray-150 pb-3 mb-6">
                            <div class="h-9 w-9 rounded-xl bg-amber-50 flex items-center justify-center text-amber-600">
                                <span class="material-symbols-outlined text-lg">storefront</span>
                            </div>
                            <div>
                                <h2 class="text-lg font-extrabold text-gray-900 tracking-tight">Unit Usaha</h2>
                                <p class="text-xs text-gray-400">Bidang usaha yang dikelola BUMNag</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            @foreach ($profile->unit_usaha as $i => $unit)
                                <div class="card p-5 bg-white border border-gray-150/60 hover:border-amber-300 hover:shadow-lg transition-all duration-300 group">
                                    <div class="flex items-start gap-3">
                                        <div class="h-10 w-10 rounded-xl bg-amber-50 flex items-center justify-center text-amber-600 flex-shrink-0 group-hover:bg-amber-100 transition-colors">
                                            <span class="font-extrabold text-sm">{{ $i + 1 }}</span>
                                        </div>
                                        <div class="min-w-0">
                                            <h4 class="font-bold text-gray-900 text-sm">{{ $unit['nama'] }}</h4>
                                            @if (!empty($unit['deskripsi']))
                                                <p class="text-xs text-gray-500 mt-1 leading-relaxed">{{ $unit['deskripsi'] }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            {{-- Sidebar --}}
            <div class="lg:col-span-4 space-y-6">
                {{-- Kontak BUMNag --}}
                <div class="card p-5 bg-gray-50/50 border border-gray-150/60">
                    <h3 class="font-bold text-gray-900 flex items-center gap-2 text-sm mb-4">
                        <span class="material-symbols-outlined text-blue-600 text-lg">contact_phone</span>
                        Kontak BUMNag
                    </h3>
                    <div class="space-y-3">
                        @if ($profile->alamat)
                            <div class="flex items-start gap-2.5">
                                <span class="material-symbols-outlined text-gray-400 text-base mt-0.5">location_on</span>
                                <p class="text-xs text-gray-700">{{ $profile->alamat }}</p>
                            </div>
                        @endif
                        @if ($profile->telepon)
                            <div class="flex items-start gap-2.5">
                                <span class="material-symbols-outlined text-gray-400 text-base mt-0.5">phone</span>
                                <p class="text-xs text-gray-700">{{ $profile->telepon }}</p>
                            </div>
                        @endif
                        @if ($profile->email)
                            <div class="flex items-start gap-2.5">
                                <span class="material-symbols-outlined text-gray-400 text-base mt-0.5">email</span>
                                <p class="text-xs text-gray-700">{{ $profile->email }}</p>
                            </div>
                        @endif
                        @if (!$profile->alamat && !$profile->telepon && !$profile->email)
                            <p class="text-xs text-gray-400 italic">Belum ada data kontak.</p>
                        @endif
                    </div>
                </div>

                {{-- Quick Links --}}
                <div class="card p-6 bg-gradient-to-br from-blue-600 to-blue-800 text-white relative overflow-hidden border-none shadow-md">
                    <div class="absolute -bottom-10 -right-10 w-24 h-24 bg-white/10 rounded-full filter blur-xl"></div>
                    <h3 class="font-extrabold text-sm mb-2">Program Kerja BUMNag</h3>
                    <p class="text-xs text-blue-100 leading-relaxed mb-5">
                        Lihat daftar program kerja dan kegiatan yang sedang dijalankan oleh unit usaha BUMNag.
                    </p>
                    <a href="{{ route('bumnag.program-kerja') }}" wire:navigate
                        class="w-full inline-flex items-center justify-center gap-1.5 px-4 py-2.5 bg-amber-500 hover:bg-amber-600 text-white text-xs font-bold rounded-xl transition-all shadow-md">
                        <span class="material-symbols-outlined text-sm">assignment</span>
                        Lihat Program Kerja
                    </a>
                </div>
            </div>
        </div>
    </section>
</div>
