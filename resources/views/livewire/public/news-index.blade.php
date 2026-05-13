<div>
    {{-- ─── HERO ─────────────────────────────────── --}}
    <section class="bg-gradient-to-br from-desa-600 to-desa-800 py-12">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-center">
            <div data-aos="zoom-in" class="inline-flex items-center justify-center h-14 w-14 rounded-2xl bg-white/10 mb-4">
                <span class="material-symbols-outlined text-white text-2xl">newspaper</span>
            </div>
            <h1 data-aos="fade-up" data-aos-delay="100" class="text-3xl md:text-4xl font-extrabold text-white">Berita & Artikel</h1>
            <p data-aos="fade-up" data-aos-delay="200" class="mt-2 text-desa-100">Informasi terkini seputar desa</p>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-10">
        {{-- Filters --}}
        <div data-aos="fade-up" class="card p-4 mb-8">
            <div class="flex flex-col sm:flex-row gap-4">
                <div class="relative flex-1">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xl">search</span>
                    <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari berita..." class="form-input pl-10 w-full">
                </div>
                <select wire:model.live="category" class="form-input w-full sm:w-48">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->slug }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- Posts Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($posts as $post)
                <a href="{{ route('berita.show', $post->slug) }}" wire:navigate data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}" class="card group overflow-hidden hover:-translate-y-1 transition-all duration-300">
                    <div class="aspect-video bg-gray-100 overflow-hidden">
                        @if($post->thumbnail)
                            <img src="{{ Storage::url($post->thumbnail) }}" alt="{{ $post->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy" decoding="async">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-desa-50">
                                <span class="material-symbols-outlined text-4xl text-desa-300">newspaper</span>
                            </div>
                        @endif
                    </div>
                    <div class="card-body">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="badge badge-desa">{{ $post->category?->name ?? 'Umum' }}</span>
                        </div>
                        <h3 class="font-semibold text-gray-900 line-clamp-2 group-hover:text-desa-600 transition-colors">{{ $post->title }}</h3>
                        <p class="mt-2 text-sm text-gray-500 line-clamp-2">{{ $post->excerpt }}</p>
                        <div class="mt-4 pt-3 border-t border-gray-100 flex items-center justify-between text-xs text-gray-400">
                            <span class="flex items-center gap-1">
                                <span class="material-symbols-outlined text-sm">calendar_today</span>
                                {{ $post->published_at?->translatedFormat('d M Y') }}
                            </span>
                            <span class="flex items-center gap-1">
                                <span class="material-symbols-outlined text-sm">visibility</span>
                                {{ number_format($post->views) }}
                            </span>
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-3 card p-12 text-center">
                    <span class="material-symbols-outlined text-5xl text-gray-200 mb-3">search_off</span>
                    <p class="text-gray-400 font-medium">Tidak ada berita ditemukan.</p>
                    <p class="text-xs text-gray-300 mt-1">Coba ubah kata kunci atau kategori pencarian</p>
                </div>
            @endforelse
        </div>

        <div class="mt-8">{{ $posts->links() }}</div>
    </section>
</div>
