<div>
    <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12 md:py-16">
        {{-- Page Header --}}
        <div class="text-center mb-12 relative">
            <div class="inline-flex items-center justify-center h-14 w-14 rounded-xl bg-blue-100 text-blue-700 border border-blue-200 mb-4 shadow-xs">
                <span class="material-symbols-outlined text-3xl">groups</span>
            </div>

            <h1 class="text-2xl md:text-3xl lg:text-4xl font-extrabold text-slate-900 tracking-tight leading-tight">
                Struktur Organisasi BUMNag
            </h1>
            <p class="mt-2 text-slate-600 text-sm md:text-base max-w-2xl mx-auto leading-relaxed">
                Susunan pimpinan, pengurus, pembina, dan badan pengawas {{ $profile->name }} yang bertanggung jawab mengelola unit usaha nagari.
            </p>

            {{-- Sub-navigation --}}
            @include('livewire.public.bumnag._subnav')
        </div>

        @if ($pembina->count() || $pengurus->count() || $pengawas->count())

            {{-- 1. PIMPINAN & PENGURUS BUMNAG --}}
            @if ($pengurus->count())
                @php
                    $direktur = $pengurus->first();
                    $staff = $pengurus->skip(1);
                @endphp

                {{-- Top Tier: Direktur / Pimpinan BUMNag --}}
                @if ($direktur)
                    <div class="max-w-md mx-auto mb-12">
                        <div class="p-6 md:p-8 bg-white border border-slate-200 rounded-2xl shadow-sm text-center flex flex-col items-center relative overflow-hidden">
                            <div class="absolute top-0 right-0 bg-blue-700 text-white text-xs font-bold uppercase tracking-wider px-3.5 py-1.5 rounded-bl-xl shadow-xs">
                                Pimpinan BUMNag
                            </div>
                            <div class="flex-1 flex flex-col items-center pt-2">
                                <div class="h-28 w-28 rounded-full overflow-hidden ring-4 ring-slate-100 border border-slate-200 shadow-sm relative mb-4">
                                    @if ($direktur->photo)
                                        <img src="{{ Storage::url($direktur->photo) }}" alt="{{ $direktur->name }}"
                                            class="h-full w-full object-cover" loading="lazy">
                                    @else
                                        <div class="h-full w-full flex items-center justify-center bg-blue-50 text-blue-400">
                                            <span class="material-symbols-outlined text-5xl">person</span>
                                        </div>
                                    @endif
                                </div>
                                <h3 class="font-bold text-slate-900 text-xl tracking-tight leading-snug">{{ $direktur->name }}</h3>
                                <p class="text-xs text-blue-800 font-bold uppercase tracking-wider mt-2 px-3 py-1 bg-blue-50 border border-blue-200 rounded-full">
                                    {{ $direktur->position }}
                                </p>
                                @if ($direktur->period)
                                    <p class="text-xs text-slate-600 font-medium mt-2">Masa Jabatan: {{ $direktur->period }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Staff Pengurus --}}
                @if ($staff->count())
                    <div class="max-w-5xl mx-auto mb-16 space-y-6">
                        <div class="flex items-center gap-3.5 border-b border-slate-200 pb-3.5">
                            <div class="h-10 w-10 rounded-xl bg-blue-100 text-blue-700 border border-blue-200 flex items-center justify-center flex-shrink-0">
                                <span class="material-symbols-outlined text-xl">badge</span>
                            </div>
                            <div>
                                <h2 class="text-lg font-bold text-slate-900 tracking-tight leading-tight">Pengurus & Pelaksana BUMNag</h2>
                                <p class="text-xs text-slate-600 font-medium mt-0.5">Pelaksana operasional unit usaha dan manajemen harian</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-5">
                            @foreach ($staff as $member)
                                <div class="p-5 bg-white border border-slate-200 rounded-xl shadow-xs hover:border-blue-300 hover:shadow-sm transition-all duration-200 flex flex-col items-center text-center">
                                    <div class="h-20 w-20 rounded-full overflow-hidden ring-4 ring-slate-100 border border-slate-200 mb-4">
                                        @if ($member->photo)
                                            <img src="{{ Storage::url($member->photo) }}" alt="{{ $member->name }}"
                                                class="h-full w-full object-cover" loading="lazy">
                                        @else
                                            <div class="h-full w-full flex items-center justify-center bg-slate-50 text-slate-400">
                                                <span class="material-symbols-outlined text-3xl">person</span>
                                            </div>
                                        @endif
                                    </div>
                                    <h3 class="font-bold text-slate-900 text-sm leading-snug min-h-[40px] flex items-center justify-center">{{ $member->name }}</h3>
                                    <p class="text-xs text-blue-800 font-bold uppercase mt-2 px-2.5 py-1 bg-blue-50 border border-blue-200/80 rounded-full tracking-wider">
                                        {{ $member->position }}
                                    </p>
                                    @if ($member->period)
                                        <p class="text-xs text-slate-600 font-medium mt-2">{{ $member->period }}</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endif

            {{-- Divider --}}
            <div class="border-t border-slate-200 my-14 max-w-4xl mx-auto"></div>

            {{-- 2. PEMBINA / PENASEHAT --}}
            @if ($pembina->count())
                <div class="max-w-5xl mx-auto mb-16 space-y-6">
                    <div class="flex items-center gap-3.5 border-b border-slate-200 pb-3.5">
                        <div class="h-10 w-10 rounded-xl bg-purple-100 text-purple-700 border border-purple-200 flex items-center justify-center flex-shrink-0">
                            <span class="material-symbols-outlined text-xl">workspace_premium</span>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-slate-900 tracking-tight leading-tight">Pembina / Penasehat</h2>
                            <p class="text-xs text-slate-600 font-medium mt-0.5">Pembina dan pengarah kebijakan pengembangan BUMNag</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-5">
                        @foreach ($pembina as $member)
                            <div class="p-5 bg-white border border-slate-200 rounded-xl shadow-xs hover:border-purple-300 hover:shadow-sm transition-all duration-200 flex flex-col items-center text-center">
                                <div class="h-20 w-20 rounded-full overflow-hidden ring-4 ring-slate-100 border border-slate-200 mb-4">
                                    @if ($member->photo)
                                        <img src="{{ Storage::url($member->photo) }}" alt="{{ $member->name }}"
                                            class="h-full w-full object-cover" loading="lazy">
                                    @else
                                        <div class="h-full w-full flex items-center justify-center bg-purple-50 text-purple-400">
                                            <span class="material-symbols-outlined text-3xl">person</span>
                                        </div>
                                    @endif
                                </div>
                                <h3 class="font-bold text-slate-900 text-sm leading-snug min-h-[40px] flex items-center justify-center">{{ $member->name }}</h3>
                                <p class="text-xs text-purple-800 font-bold uppercase mt-2 px-2.5 py-1 bg-purple-50 border border-purple-200/80 rounded-full tracking-wider">
                                    {{ $member->position }}
                                </p>
                                @if ($member->period)
                                    <p class="text-xs text-slate-600 font-medium mt-2">{{ $member->period }}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- 3. BADAN PENGAWAS / KOMISARIS --}}
            @if ($pengawas->count())
                <div class="max-w-5xl mx-auto space-y-6">
                    <div class="flex items-center gap-3.5 border-b border-slate-200 pb-3.5">
                        <div class="h-10 w-10 rounded-xl bg-amber-100 text-amber-700 border border-amber-200 flex items-center justify-center flex-shrink-0">
                            <span class="material-symbols-outlined text-xl">shield_person</span>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-slate-900 tracking-tight leading-tight">Badan Pengawas / Komisaris</h2>
                            <p class="text-xs text-slate-600 font-medium mt-0.5">Mengawasi kinerja pengelola dan akuntabilitas keuangan BUMNag</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-5">
                        @foreach ($pengawas as $member)
                            <div class="p-5 bg-white border border-slate-200 rounded-xl shadow-xs hover:border-amber-300 hover:shadow-sm transition-all duration-200 flex flex-col items-center text-center">
                                <div class="h-20 w-20 rounded-full overflow-hidden ring-4 ring-slate-100 border border-slate-200 mb-4">
                                    @if ($member->photo)
                                        <img src="{{ Storage::url($member->photo) }}" alt="{{ $member->name }}"
                                            class="h-full w-full object-cover" loading="lazy">
                                    @else
                                        <div class="h-full w-full flex items-center justify-center bg-amber-50 text-amber-500">
                                            <span class="material-symbols-outlined text-3xl">person</span>
                                        </div>
                                    @endif
                                </div>
                                <h3 class="font-bold text-slate-900 text-sm leading-snug min-h-[40px] flex items-center justify-center">{{ $member->name }}</h3>
                                <p class="text-xs text-amber-900 font-bold uppercase mt-2 px-2.5 py-1 bg-amber-50 border border-amber-200/80 rounded-full tracking-wider">
                                    {{ $member->position }}
                                </p>
                                @if ($member->period)
                                    <p class="text-xs text-slate-600 font-medium mt-2">{{ $member->period }}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

        @else
            <div class="p-12 md:p-16 text-center max-w-xl mx-auto bg-white rounded-2xl border border-slate-200 shadow-xs">
                <div class="inline-flex items-center justify-center h-16 w-16 rounded-full bg-slate-100 text-slate-500 mb-4">
                    <span class="material-symbols-outlined text-3xl">groups</span>
                </div>
                <h3 class="font-bold text-slate-900 text-lg">Data Belum Tersedia</h3>
                <p class="text-sm text-slate-600 mt-2 max-w-sm mx-auto leading-relaxed">
                    Susunan pimpinan, pengurus, dan badan pengawas BUMNag belum diisi oleh administrator. Silakan periksa kembali nanti.
                </p>
            </div>
        @endif
    </section>
</div>
