<div>
    <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12">
        {{-- Page Header --}}
        <div class="text-center mb-16 relative">
            <div class="absolute -top-6 left-1/2 -translate-x-1/2 w-40 h-40 bg-blue-500/5 rounded-full filter blur-2xl -z-10"></div>

            <div
                class="inline-flex items-center justify-center h-16 w-16 rounded-2xl bg-gradient-to-br from-blue-500 to-blue-700 mb-4 shadow-lg shadow-blue-500/20">
                <span class="material-symbols-outlined text-white text-3xl">groups</span>
            </div>

            <h1 class="section-title">Struktur Organisasi BUMNag</h1>
            <p class="section-subtitle max-w-2xl mx-auto">
                Susunan pengurus dan badan pengawas {{ $profile->name }} yang bertanggung jawab mengelola seluruh unit usaha nagari.
            </p>

            {{-- Sub-navigation --}}
            @include('livewire.public.bumnag._subnav')
        </div>

        @if ($pembina->count() || $pengurus->count() || $pengawas->count())
            {{-- PEMBINA / PENASEHAT --}}
            @if ($pembina->count())
                <div class="max-w-5xl mx-auto mb-12 space-y-6">
                    <div class="flex items-center gap-3 border-b border-gray-150 pb-3">
                        <div class="h-9 w-9 rounded-xl bg-purple-50 flex items-center justify-center text-purple-600">
                            <span class="material-symbols-outlined text-lg">workspace_premium</span>
                        </div>
                        <div>
                            <h2 class="text-lg font-extrabold text-gray-900 tracking-tight">Pembina / Penasehat</h2>
                            <p class="text-xs text-gray-400">Pembina dan pengarah kebijakan pengembangan BUMNag</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-5">
                        @foreach ($pembina as $member)
                            <div class="card group p-5 bg-purple-50/20 hover:bg-white border border-purple-150 hover:border-purple-300 hover:shadow-lg transition-all duration-300 flex flex-col items-center text-center">
                                <div class="h-20 w-20 rounded-full overflow-hidden ring-4 ring-purple-100 group-hover:ring-purple-200 transition-all mb-4">
                                    @if ($member->photo)
                                        <img src="{{ Storage::url($member->photo) }}" alt="{{ $member->name }}"
                                            class="h-full w-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
                                    @else
                                        <div class="h-full w-full flex items-center justify-center bg-purple-50">
                                            <span class="material-symbols-outlined text-3xl text-purple-300">person</span>
                                        </div>
                                    @endif
                                </div>
                                <h3 class="font-bold text-gray-900 text-sm leading-snug min-h-[40px] flex items-center justify-center">{{ $member->name }}</h3>
                                <p class="text-xs text-purple-700 font-semibold uppercase mt-2 px-2.5 py-0.5 bg-purple-100/60 rounded-full tracking-wide">
                                    {{ $member->position }}
                                </p>
                                @if ($member->period)
                                    <p class="text-xs text-gray-400 mt-1.5">{{ $member->period }}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- PENGURUS (Pengelola) --}}
            @if ($pengurus->count())
                @php
                    $direktur = $pengurus->first();
                    $staff = $pengurus->skip(1);
                @endphp

                {{-- Top Tier: Direktur --}}
                @if ($direktur)
                    <div class="max-w-md mx-auto mb-12">
                        <div class="relative group">
                            <div class="absolute inset-0 bg-gradient-to-br from-blue-500/10 to-amber-500/10 rounded-3xl filter blur-xl opacity-70 group-hover:opacity-100 transition-opacity -z-10"></div>
                            <div class="card h-full p-6 text-center border-2 border-blue-300/60 bg-gradient-to-b from-blue-50/40 via-white to-white flex flex-col items-center shadow-lg relative overflow-hidden">
                                <div class="absolute top-0 right-0 bg-gradient-to-l from-blue-500 to-blue-600 text-white text-[10px] font-bold uppercase tracking-widest px-4 py-1.5 rounded-bl-2xl">
                                    Pimpinan BUMNag
                                </div>
                                <div class="flex-1 flex flex-col items-center pt-4">
                                    <div class="relative mb-5">
                                        <div class="absolute inset-0 bg-blue-400 rounded-full animate-ping opacity-15"></div>
                                        <div class="h-28 w-28 rounded-full overflow-hidden ring-4 ring-blue-300 group-hover:ring-blue-400 transition-all shadow-md relative">
                                            @if ($direktur->photo)
                                                <img src="{{ Storage::url($direktur->photo) }}" alt="{{ $direktur->name }}"
                                                    class="h-full w-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
                                            @else
                                                <div class="h-full w-full flex items-center justify-center bg-blue-50">
                                                    <span class="material-symbols-outlined text-5xl text-blue-300">person</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <h3 class="font-extrabold text-gray-900 text-xl tracking-tight leading-snug">{{ $direktur->name }}</h3>
                                    <p class="text-xs text-blue-700 font-bold uppercase tracking-wider mt-1.5 px-3 py-1 bg-blue-100/50 rounded-full">
                                        {{ $direktur->position }}
                                    </p>
                                    @if ($direktur->period)
                                        <p class="text-xs text-gray-400 mt-2">Masa Jabatan: {{ $direktur->period }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Divider --}}
                @if ($staff->count())
                    <div class="flex items-center justify-center gap-4 max-w-4xl mx-auto mb-12">
                        <div class="h-px bg-gradient-to-r from-transparent to-gray-200 flex-1"></div>
                        <div class="h-2 w-2 rounded-full bg-blue-500"></div>
                        <div class="h-px bg-gradient-to-l from-transparent to-gray-200 flex-1"></div>
                    </div>

                    {{-- Staff Pengurus --}}
                    <div class="max-w-5xl mx-auto mb-16 space-y-6">
                        <div class="flex items-center gap-3 border-b border-gray-150 pb-3">
                            <div class="h-9 w-9 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600">
                                <span class="material-symbols-outlined text-lg">badge</span>
                            </div>
                            <div>
                                <h2 class="text-lg font-extrabold text-gray-900 tracking-tight">Pengurus BUMNag</h2>
                                <p class="text-xs text-gray-400">Pelaksana operasional unit usaha dan manajemen harian</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-5">
                            @foreach ($staff as $member)
                                <div class="card group p-5 bg-white border border-gray-150/60 hover:border-blue-300 hover:shadow-lg transition-all duration-300 flex flex-col items-center text-center">
                                    <div class="h-20 w-20 rounded-full overflow-hidden ring-4 ring-gray-100 group-hover:ring-blue-100 transition-all mb-4">
                                        @if ($member->photo)
                                            <img src="{{ Storage::url($member->photo) }}" alt="{{ $member->name }}"
                                                class="h-full w-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
                                        @else
                                            <div class="h-full w-full flex items-center justify-center bg-gray-50">
                                                <span class="material-symbols-outlined text-3xl text-gray-300">person</span>
                                            </div>
                                        @endif
                                    </div>
                                    <h3 class="font-bold text-gray-900 text-sm leading-snug min-h-[40px] flex items-center justify-center">{{ $member->name }}</h3>
                                    <p class="text-xs text-blue-600 font-semibold uppercase mt-2 px-2.5 py-0.5 bg-blue-50 rounded-full tracking-wide">
                                        {{ $member->position }}
                                    </p>
                                    @if ($member->period)
                                        <p class="text-xs text-gray-400 mt-1.5">{{ $member->period }}</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endif

            {{-- PENGAWAS --}}
            @if ($pengawas->count())
                <div class="max-w-5xl mx-auto space-y-6">
                    <div class="flex items-center gap-3 border-b border-gray-150 pb-3">
                        <div class="h-9 w-9 rounded-xl bg-amber-50 flex items-center justify-center text-amber-600">
                            <span class="material-symbols-outlined text-lg">shield_person</span>
                        </div>
                        <div>
                            <h2 class="text-lg font-extrabold text-gray-900 tracking-tight">Badan Pengawas</h2>
                            <p class="text-xs text-gray-400">Mengawasi kinerja pengelolaan dan keuangan BUMNag</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-5">
                        @foreach ($pengawas as $member)
                            <div class="card group p-5 bg-gray-50/50 hover:bg-white border border-gray-150 border-dashed hover:border-solid hover:border-amber-300 hover:shadow-lg transition-all duration-300 flex flex-col items-center text-center">
                                <div class="h-20 w-20 rounded-full overflow-hidden ring-4 ring-gray-100 group-hover:ring-amber-100 transition-all mb-4">
                                    @if ($member->photo)
                                        <img src="{{ Storage::url($member->photo) }}" alt="{{ $member->name }}"
                                            class="h-full w-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
                                    @else
                                        <div class="h-full w-full flex items-center justify-center bg-gray-50">
                                            <span class="material-symbols-outlined text-3xl text-gray-300">person</span>
                                        </div>
                                    @endif
                                </div>
                                <h3 class="font-bold text-gray-900 text-sm leading-snug min-h-[40px] flex items-center justify-center">{{ $member->name }}</h3>
                                <p class="text-xs text-amber-700 font-semibold uppercase mt-2 px-2.5 py-0.5 bg-amber-100/60 rounded-full tracking-wide">
                                    {{ $member->position }}
                                </p>
                                @if ($member->period)
                                    <p class="text-xs text-gray-400 mt-1.5">{{ $member->period }}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        @else
            <div class="card p-16 text-center max-w-xl mx-auto border border-gray-150">
                <span class="material-symbols-outlined text-5xl text-gray-300 mb-4 animate-bounce">groups</span>
                <h3 class="font-extrabold text-gray-900 text-lg">Data Belum Tersedia</h3>
                <p class="text-sm text-gray-400 mt-1 max-w-sm mx-auto">
                    Susunan pengurus dan pengawas BUMNag belum diisi oleh administrator. Silakan periksa kembali nanti.
                </p>
            </div>
        @endif
    </section>
</div>
