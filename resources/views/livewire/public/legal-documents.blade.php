<div>
    {{-- ─── HERO ─────────────────────────────────── --}}
    <section class="relative bg-gradient-to-br from-desa-600 via-desa-700 to-desa-900 overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 right-0 w-96 h-96 bg-amber-400 rounded-full filter blur-3xl translate-x-1/2 -translate-y-1/2"></div>
            <div class="absolute bottom-0 left-0 w-64 h-64 bg-white rounded-full filter blur-3xl -translate-x-1/2 translate-y-1/2"></div>
        </div>
        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16 md:py-24">
            <div class="text-center">
                <div class="inline-flex items-center gap-2 rounded-full bg-white/10 backdrop-blur-sm px-4 py-1.5 text-sm text-amber-300 mb-4">
                    <span class="material-symbols-outlined text-base">gavel</span>
                    Produk Hukum
                </div>
                <h1 class="text-4xl md:text-5xl font-extrabold text-white leading-tight tracking-tight">
                    Jaringan Dokumen & Produk Hukum
                </h1>
                <p class="mt-3 text-lg text-desa-100 max-w-2xl mx-auto">
                    Akses seluruh peraturan, SK, dan dokumen hukum Nagari Duo Koto dalam satu tempat
                </p>
            </div>
        </div>
    </section>

    {{-- ─── SEARCH & FILTERS ─────────────────────────────────── --}}
    <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Cari Dokumen</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">search</span>
                        <input type="text" wire:model.live.debounce.300ms="search" 
                               class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-desa-500 focus:border-desa-500 transition-all"
                               placeholder="Ketik judul dokumen...">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                    <select wire:model.live="filterCategory" 
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-desa-500 focus:border-desa-500 transition-all">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $k => $v)
                            <option value="{{ $k }}">{{ $v }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tahun</label>
                    <select wire:model.live="filterYear" 
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-desa-500 focus:border-desa-500 transition-all">
                        <option value="">Semua Tahun</option>
                        @foreach($availableYears as $year)
                            <option value="{{ $year }}">{{ $year }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </section>

    {{-- ─── DOCUMENTS GRID ─────────────────────────────────── --}}
    <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8 pb-16">
        @if($items->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($items as $item)
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-all group">
                        <div class="p-6">
                            <div class="flex items-start justify-between mb-4">
                                <span class="badge bg-desa-50 text-desa-700 text-xs">{{ $item->category_label }}</span>
                                <span class="text-xs text-gray-400">{{ $item->year }}</span>
                            </div>
                            <h3 class="font-bold text-gray-900 text-lg mb-2 line-clamp-2 group-hover:text-desa-600 transition-colors">
                                {{ $item->title }}
                            </h3>
                            @if($item->number)
                                <p class="text-sm text-gray-500 mb-3">Nomor: {{ $item->number }}</p>
                            @endif
                            @if($item->description)
                                <p class="text-sm text-gray-600 mb-4 line-clamp-2">{{ $item->description }}</p>
                            @endif
                            <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                                <div class="flex items-center gap-2 text-xs text-gray-400">
                                    <span class="material-symbols-outlined text-base">description</span>
                                    <span>{{ $item->file_extension }}</span>
                                    <span>•</span>
                                    <span>{{ $item->file_size_formatted }}</span>
                                </div>
                                <div class="flex gap-2">
                                    @if($item->fileExists())
                                        <button wire:click="view({{ $item->id }})"
                                                class="inline-flex items-center justify-center p-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors"
                                                title="Lihat">
                                            <span class="material-symbols-outlined text-base">visibility</span>
                                        </button>
                                        <button wire:click="download({{ $item->id }})"
                                                class="inline-flex items-center gap-1.5 px-3 py-2 bg-desa-600 text-white text-sm font-medium rounded-lg hover:bg-desa-700 transition-colors">
                                            <span class="material-symbols-outlined text-base">download</span>
                                            Download
                                        </button>
                                    @else
                                        <span class="text-xs text-gray-400 italic">File tidak tersedia</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div class="mt-8">
                {{ $items->links() }}
            </div>
        @else
            <div class="text-center py-16">
                <div class="inline-flex h-20 w-20 rounded-full bg-gray-50 items-center justify-center mb-4">
                    <span class="material-symbols-outlined text-4xl text-gray-300">folder_open</span>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Tidak ada dokumen ditemukan</h3>
                <p class="text-gray-500">Coba ubah kata kunci atau filter pencarian Anda</p>
            </div>
        @endif
    </section>

    {{-- PDF Viewer Modal --}}
    <div x-data="{ isOpen: false, pdfUrl: '', pdfTitle: '' }"
         @open-pdf-modal.window="if($event.detail.url) { isOpen = true; pdfUrl = $event.detail.url; pdfTitle = $event.detail.title; }"
         x-show="isOpen"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 flex items-center justify-center p-4"
         style="display: none;">
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" @click="isOpen = false"></div>
        <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-5xl max-h-[90vh] flex flex-col">
            <div class="flex items-center justify-between p-4 border-b border-gray-200">
                <h3 class="font-semibold text-gray-900 text-lg truncate pr-4" x-text="pdfTitle"></h3>
                <button @click="isOpen = false" class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                    <span class="material-symbols-outlined text-gray-500">close</span>
                </button>
            </div>
            <div class="flex-1 overflow-auto p-4 bg-gray-50">
                <iframe :src="pdfUrl" class="w-full h-full min-h-[60vh] rounded-lg border border-gray-200" frameborder="0"></iframe>
            </div>
        </div>
    </div>
</div>
