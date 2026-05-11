<div>
    {{-- ─── HERO / THUMBNAIL ─────────────────────────────────── --}}
    @if($post->thumbnail)
        <div class="relative">
            <div class="aspect-[21/9] bg-gray-900 overflow-hidden">
                <img src="{{ Storage::url($post->thumbnail) }}" alt="{{ $post->title }}"
                    class="w-full h-full object-cover opacity-40">
            </div>
            <div class="absolute inset-0 bg-gradient-to-t from-gray-900/90 via-gray-900/50 to-transparent"></div>
            <div class="absolute bottom-0 left-0 right-0 mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 pb-10">
                <a href="{{ route('berita.index') }}" wire:navigate
                    class="inline-flex items-center gap-1 text-sm text-white/70 hover:text-white mb-4 transition-colors">
                    <span class="material-symbols-outlined text-base">arrow_back</span> Kembali ke Berita
                </a>
                <span class="badge bg-white/20 text-white backdrop-blur-sm mb-3">{{ $post->category?->name ?? 'Umum' }}</span>
                <h1 class="text-3xl md:text-4xl font-extrabold text-white leading-tight">{{ $post->title }}</h1>
                <div class="flex flex-wrap items-center gap-4 mt-4 text-sm text-white/60">
                    <span class="flex items-center gap-1">
                        <span class="material-symbols-outlined text-base">person</span>{{ $post->user?->name ?? 'Admin' }}
                    </span>
                    <span class="flex items-center gap-1">
                        <span class="material-symbols-outlined text-base">calendar_today</span>{{ $post->published_at?->translatedFormat('d F Y') }}
                    </span>
                    <span class="flex items-center gap-1">
                        <span class="material-symbols-outlined text-base">visibility</span>{{ number_format($post->views) }}x dibaca
                    </span>
                </div>
            </div>
        </div>
    @else
        <div class="bg-gradient-to-br from-desa-600 to-desa-800 py-12">
            <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
                <a href="{{ route('berita.index') }}" wire:navigate
                    class="inline-flex items-center gap-1 text-sm text-white/70 hover:text-white mb-4 transition-colors">
                    <span class="material-symbols-outlined text-base">arrow_back</span> Kembali ke Berita
                </a>
                <span class="badge bg-white/20 text-white backdrop-blur-sm mb-3">{{ $post->category?->name ?? 'Umum' }}</span>
                <h1 class="text-3xl md:text-4xl font-extrabold text-white leading-tight">{{ $post->title }}</h1>
                <div class="flex flex-wrap items-center gap-4 mt-4 text-sm text-white/60">
                    <span class="flex items-center gap-1">
                        <span class="material-symbols-outlined text-base">person</span>{{ $post->user?->name ?? 'Admin' }}
                    </span>
                    <span class="flex items-center gap-1">
                        <span class="material-symbols-outlined text-base">calendar_today</span>{{ $post->published_at?->translatedFormat('d F Y') }}
                    </span>
                    <span class="flex items-center gap-1">
                        <span class="material-symbols-outlined text-base">visibility</span>{{ number_format($post->views) }}x dibaca
                    </span>
                </div>
            </div>
        </div>
    @endif

    {{-- ─── CONTENT ─────────────────────────────────── --}}
    <article class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-10">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            {{-- Main Content --}}
            <div class="lg:col-span-2">
                <div class="card p-6 md:p-10">
                    <div class="prose max-w-none prose-lg prose-headings:text-gray-900 prose-a:text-desa-600 prose-img:rounded-xl">
                        {!! $post->body !!}
                    </div>
                </div>

                {{-- Share --}}
                <div class="card p-5 mt-6">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-500">Bagikan berita ini:</span>
                        <div class="flex items-center gap-2">
                            <a href="https://wa.me/?text={{ urlencode($post->title . ' ' . request()->url()) }}" target="_blank" rel="noopener"
                                class="h-9 w-9 rounded-lg bg-green-50 flex items-center justify-center text-green-600 hover:bg-green-100 transition-colors">
                                <span class="material-symbols-outlined text-lg">chat</span>
                            </a>
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" target="_blank" rel="noopener"
                                class="h-9 w-9 rounded-lg bg-blue-50 flex items-center justify-center text-blue-600 hover:bg-blue-100 transition-colors">
                                <span class="material-symbols-outlined text-lg">share</span>
                            </a>
                            <button onclick="navigator.clipboard.writeText('{{ request()->url() }}'); Swal.fire({icon:'success',title:'Link disalin!',timer:1500,showConfirmButton:false,toast:true,position:'top-end'})"
                                class="h-9 w-9 rounded-lg bg-gray-50 flex items-center justify-center text-gray-600 hover:bg-gray-100 transition-colors">
                                <span class="material-symbols-outlined text-lg">content_copy</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sidebar --}}
            <aside class="lg:col-span-1 space-y-6">
                <div class="sticky top-24 space-y-6">
                    {{-- Article Info --}}
                    <div class="card p-5">
                        <h3 class="font-bold text-gray-900 text-sm mb-4 flex items-center gap-2">
                            <span class="material-symbols-outlined text-desa-500 text-lg">info</span>
                            Informasi Artikel
                        </h3>
                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-400">Penulis</span>
                                <span class="font-medium text-gray-900">{{ $post->user?->name ?? 'Admin' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-400">Kategori</span>
                                <span class="badge badge-desa">{{ $post->category?->name ?? 'Umum' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-400">Diterbitkan</span>
                                <span class="font-medium text-gray-900">{{ $post->published_at?->translatedFormat('d M Y') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-400">Dibaca</span>
                                <span class="font-medium text-gray-900">{{ number_format($post->views) }}x</span>
                            </div>
                        </div>
                    </div>

                    {{-- Related --}}
                    <div class="card p-5">
                        <h3 class="font-bold text-gray-900 text-sm mb-4 flex items-center gap-2">
                            <span class="material-symbols-outlined text-desa-500 text-lg">article</span>
                            Berita Terkait
                        </h3>
                        <div class="space-y-4">
                            @forelse($relatedPosts as $rp)
                                <a href="{{ route('berita.show', $rp->slug) }}" wire:navigate class="flex gap-3 group">
                                    <div class="flex-shrink-0 h-14 w-18 rounded-lg bg-gray-100 overflow-hidden">
                                        @if($rp->thumbnail)
                                            <img src="{{ Storage::url($rp->thumbnail) }}" alt="{{ $rp->title }}" class="h-full w-full object-cover">
                                        @else
                                            <div class="h-full w-full flex items-center justify-center bg-desa-50">
                                                <span class="material-symbols-outlined text-desa-300 text-base">newspaper</span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <h4 class="text-sm font-medium text-gray-900 line-clamp-2 group-hover:text-desa-600 transition-colors">{{ $rp->title }}</h4>
                                        <p class="text-xs text-gray-400 mt-1">{{ $rp->published_at?->translatedFormat('d M Y') }}</p>
                                    </div>
                                </a>
                            @empty
                                <p class="text-sm text-gray-400">Belum ada berita terkait.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </aside>
        </div>
    </article>
</div>
