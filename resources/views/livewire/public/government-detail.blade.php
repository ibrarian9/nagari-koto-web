<div>
    <section class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 py-12">

        {{-- Back button --}}
        <div class="mb-8" data-aos="fade-right">
            <a href="{{ route('pemerintahan') }}" wire:navigate
                class="inline-flex items-center gap-2 text-sm font-semibold text-desa-600 hover:text-desa-800 transition-colors group">
                <span
                    class="material-symbols-outlined text-lg group-hover:-translate-x-1 transition-transform">arrow_back</span>
                Kembali ke Struktur Pemerintahan
            </a>
        </div>

        {{-- Profile Header Card --}}
        <div data-aos="fade-up"
            class="card overflow-hidden border-2 border-desa-100 bg-gradient-to-br from-white to-desa-50/30 mb-8">
            <div class="bg-gradient-to-r from-desa-700 via-desa-800 to-desa-950 px-6 py-8 sm:px-8 sm:py-10">
                <div class="flex flex-col sm:flex-row items-center gap-6">
                    {{-- Photo --}}
                    <div
                        class="h-32 w-32 sm:h-36 sm:w-36 rounded-2xl bg-white/10 overflow-hidden ring-4 ring-white/20 flex-shrink-0 shadow-xl">
                        @if ($member->photo)
                            <img src="{{ Storage::url($member->photo) }}" alt="{{ $member->name }}"
                                class="h-full w-full object-cover" loading="lazy">
                        @else
                            <div class="h-full w-full flex items-center justify-center bg-desa-600/30">
                                <span class="material-symbols-outlined text-6xl text-white/40">person</span>
                            </div>
                        @endif
                    </div>

                    {{-- Identity --}}
                    <div class="text-center sm:text-left">
                        <span
                            class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/10 text-amber-300 text-xs font-bold uppercase tracking-wider mb-3 border border-amber-400/20">
                            <span class="material-symbols-outlined text-sm">badge</span>
                            {{ $member->position }}
                        </span>
                        <h1 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight">
                            {{ $member->name }}</h1>
                        @if ($member->nip)
                            <p class="text-desa-300 text-sm mt-2 flex items-center gap-1.5 justify-center sm:justify-start">
                                <span class="material-symbols-outlined text-base">fingerprint</span>
                                NIP: {{ $member->nip }}
                            </p>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Quick Info Grid --}}
            <div class="grid grid-cols-2 sm:grid-cols-3 divide-x divide-gray-100 border-t border-gray-100">
                @if ($member->place_of_birth || $member->date_of_birth)
                    <div class="p-4 sm:p-5 text-center">
                        <span class="material-symbols-outlined text-desa-500 text-xl mb-1">cake</span>
                        <p class="text-xs text-gray-400 font-medium">Tempat, Tgl Lahir</p>
                        <p class="text-sm font-bold text-gray-900 mt-0.5">
                            {{ $member->place_of_birth ?? '-' }}{{ $member->date_of_birth ? ', ' . $member->date_of_birth->isoFormat('D MMM Y') : '' }}
                        </p>
                    </div>
                @endif
                <div class="p-4 sm:p-5 text-center">
                    <span class="material-symbols-outlined text-desa-500 text-xl mb-1">work</span>
                    <p class="text-xs text-gray-400 font-medium">Jabatan</p>
                    <p class="text-sm font-bold text-gray-900 mt-0.5">{{ $member->position }}</p>
                </div>
                <div class="p-4 sm:p-5 text-center">
                    <span class="material-symbols-outlined text-desa-500 text-xl mb-1">verified</span>
                    <p class="text-xs text-gray-400 font-medium">Status</p>
                    <p class="text-sm font-bold text-green-600 mt-0.5 flex items-center justify-center gap-1">
                        <span class="h-2 w-2 rounded-full bg-green-500"></span> Aktif
                    </p>
                </div>
            </div>
        </div>

        {{-- Riwayat Pendidikan --}}
        <div data-aos="fade-up" data-aos-delay="100" class="card overflow-hidden mb-8">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50 flex items-center gap-3">
                <div class="h-10 w-10 rounded-xl bg-blue-100 flex items-center justify-center flex-shrink-0">
                    <span class="material-symbols-outlined text-blue-600">school</span>
                </div>
                <div>
                    <h2 class="font-bold text-gray-900">Riwayat Pendidikan</h2>
                    <p class="text-xs text-gray-400">Jenjang pendidikan yang telah ditempuh</p>
                </div>
            </div>
            <div class="p-6">
                @if (!empty($member->education_history))
                    <div class="relative pl-6 border-l-2 border-blue-200 space-y-6">
                        @foreach ($member->education_history as $edu)
                            <div class="relative">
                                {{-- Timeline dot --}}
                                <div
                                    class="absolute -left-[calc(1.5rem+5px)] top-1 h-3 w-3 rounded-full bg-blue-500 ring-4 ring-blue-100">
                                </div>
                                <div class="bg-blue-50/50 rounded-xl p-4 border border-blue-100/80">
                                    <div class="flex flex-wrap items-center gap-2 mb-1">
                                        <span
                                            class="text-xs font-bold text-blue-600 bg-blue-100 px-2 py-0.5 rounded-full">{{ $edu['level'] ?? '-' }}</span>
                                        @if (!empty($edu['year']))
                                            <span class="text-xs text-gray-400">{{ $edu['year'] }}</span>
                                        @endif
                                    </div>
                                    <h3 class="font-semibold text-gray-900 text-sm">
                                        {{ $edu['institution'] ?? '-' }}</h3>
                                    @if (!empty($edu['major']))
                                        <p class="text-xs text-gray-500 mt-0.5">Jurusan:
                                            {{ $edu['major'] }}</p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <span class="material-symbols-outlined text-4xl text-gray-200 mb-2">school</span>
                        <p class="text-gray-400 text-sm">Belum ada data riwayat pendidikan.</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- Riwayat Jabatan --}}
        <div data-aos="fade-up" data-aos-delay="200" class="card overflow-hidden mb-8">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50 flex items-center gap-3">
                <div class="h-10 w-10 rounded-xl bg-amber-100 flex items-center justify-center flex-shrink-0">
                    <span class="material-symbols-outlined text-amber-600">military_tech</span>
                </div>
                <div>
                    <h2 class="font-bold text-gray-900">Riwayat Jabatan</h2>
                    <p class="text-xs text-gray-400">Perjalanan karir dan jabatan yang pernah diampu</p>
                </div>
            </div>
            <div class="p-6">
                @if (!empty($member->position_history))
                    <div class="relative pl-6 border-l-2 border-amber-200 space-y-6">
                        @foreach ($member->position_history as $pos)
                            <div class="relative">
                                {{-- Timeline dot --}}
                                <div
                                    class="absolute -left-[calc(1.5rem+5px)] top-1 h-3 w-3 rounded-full bg-amber-500 ring-4 ring-amber-100">
                                </div>
                                <div class="bg-amber-50/50 rounded-xl p-4 border border-amber-100/80">
                                    <div class="flex flex-wrap items-center gap-2 mb-1">
                                        <span
                                            class="text-xs font-bold text-amber-700 bg-amber-100 px-2 py-0.5 rounded-full">{{ $pos['period'] ?? '-' }}</span>
                                    </div>
                                    <h3 class="font-semibold text-gray-900 text-sm">
                                        {{ $pos['position'] ?? '-' }}</h3>
                                    @if (!empty($pos['institution']))
                                        <p class="text-xs text-gray-500 mt-0.5">
                                            {{ $pos['institution'] }}</p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <span class="material-symbols-outlined text-4xl text-gray-200 mb-2">military_tech</span>
                        <p class="text-gray-400 text-sm">Belum ada data riwayat jabatan.</p>
                    </div>
                @endif
            </div>
        </div>

    </section>
</div>
