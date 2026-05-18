<div>
    {{-- ─── HERO ─────────────────────────────────── --}}
    <section class="bg-gradient-to-br from-desa-600 to-desa-800 py-12">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-center">
            <div class="inline-flex items-center justify-center h-14 w-14 rounded-2xl bg-white/10 mb-4">
                <span class="material-symbols-outlined text-white text-2xl">eco</span>
            </div>
            <h1 class="text-3xl md:text-4xl font-extrabold text-white">Potensi Desa</h1>
            <p class="mt-2 text-desa-100 max-w-lg mx-auto">Kekayaan alam, budaya, dan potensi unggulan yang menjadi kebanggaan desa</p>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-10">
        {{-- Category Filter --}}
        <div class="flex flex-wrap justify-center gap-2 mb-8">
            <button wire:click="$set('category', '')"
                class="flex items-center gap-1.5 px-4 py-2 rounded-xl text-sm font-medium transition-all {{ $category === '' ? 'bg-desa-500 text-white shadow-md' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-50' }}">
                <span class="material-symbols-outlined text-base">apps</span>
                Semua
            </button>
            @foreach($categories as $key => $label)
                <button wire:click="$set('category', '{{ $key }}')"
                    class="px-4 py-2 rounded-xl text-sm font-medium transition-all {{ $category === $key ? 'bg-desa-500 text-white shadow-md' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-50' }}">
                    {{ $label }}
                </button>
            @endforeach
        </div>

        {{-- Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($potentials as $p)
                <div class="card group overflow-hidden hover:-translate-y-1 transition-all duration-300">
                    <div class="aspect-video bg-gray-100 overflow-hidden relative">
                        @if($p->thumbnail)
                            <img src="{{ Storage::url($p->thumbnail) }}" alt="{{ $p->title }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy" decoding="async">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-desa-50 to-amber-50">
                                <span class="material-symbols-outlined text-5xl text-desa-200">eco</span>
                            </div>
                        @endif
                        <div class="absolute top-3 left-3">
                            <span class="badge bg-white/90 backdrop-blur-sm text-desa-700 shadow-sm">{{ $categories[$p->category] ?? ucfirst($p->category) }}</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <h3 class="font-bold text-gray-900 group-hover:text-desa-600 transition-colors">{{ $p->title }}</h3>
                        <p class="mt-2 text-sm text-gray-500 line-clamp-3">{{ Str::limit(strip_tags($p->description), 120) }}</p>
                        @if($p->description)
                            <button onclick="Swal.fire({title: '{{ addslashes($p->title) }}', html: `{!! addslashes(Str::markdown($p->description)) !!}`, width: 700, confirmButtonColor: '#059669'})"
                                class="mt-3 inline-flex items-center gap-1 text-xs text-desa-600 hover:text-desa-800 font-medium transition-colors">
                                Baca Selengkapnya <span class="material-symbols-outlined text-xs">arrow_forward</span>
                            </button>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-3 card p-12 text-center">
                    <span class="material-symbols-outlined text-5xl text-gray-200 mb-3">eco</span>
                    <p class="text-gray-400 font-medium">Belum ada data potensi desa.</p>
                    <p class="text-xs text-gray-300 mt-1">Data akan ditampilkan setelah diinput oleh perangkat desa</p>
                </div>
            @endforelse
        </div>
    </section>
</div>
