<div>
    {{-- ─── HERO ─────────────────────────────────── --}}
    <section class="bg-gradient-to-br from-amber-500 to-orange-600 py-12">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-center">
            <div class="inline-flex items-center justify-center h-14 w-14 rounded-2xl bg-white/10 mb-4">
                <span class="material-symbols-outlined text-white text-2xl">storefront</span>
            </div>
            <h1 class="text-3xl md:text-4xl font-extrabold text-white">UMKM & Produk Desa</h1>
            <p class="mt-2 text-amber-100 max-w-lg mx-auto">Dukung usaha lokal desa kami — temukan produk dan layanan dari warga</p>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-10">
        {{-- Search --}}
        <div class="card p-4 mb-8">
            <div class="relative max-w-md mx-auto">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">search</span>
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari nama usaha atau produk..."
                    class="form-input pl-10 w-full">
            </div>
        </div>

        {{-- Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($products as $product)
                <div class="card group overflow-hidden hover:-translate-y-1 transition-all duration-300">
                    <div class="aspect-video bg-gray-100 overflow-hidden relative">
                        @if($product->photo)
                            <img src="{{ Storage::url($product->photo) }}" alt="{{ $product->business_name }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy" decoding="async">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-amber-50 to-orange-50">
                                <span class="material-symbols-outlined text-5xl text-amber-200">storefront</span>
                            </div>
                        @endif
                        @if($product->category)
                            <div class="absolute top-3 left-3">
                                <span class="badge bg-white/90 backdrop-blur-sm text-amber-700 shadow-sm">{{ $product->category }}</span>
                            </div>
                        @endif
                    </div>
                    <div class="card-body">
                        <h3 class="font-bold text-gray-900 group-hover:text-amber-600 transition-colors">{{ $product->business_name }}</h3>
                        <div class="flex items-center gap-2 mt-1 text-sm text-gray-500">
                            <span class="material-symbols-outlined text-sm">person</span>
                            {{ $product->owner_name }}
                        </div>
                        @if($product->address)
                            <div class="flex items-start gap-2 mt-1 text-xs text-gray-400">
                                <span class="material-symbols-outlined text-xs mt-0.5">location_on</span>
                                <span class="line-clamp-1">{{ $product->address }}</span>
                            </div>
                        @endif
                        @if($product->description)
                            <p class="text-sm text-gray-500 mt-3 line-clamp-2">{{ $product->description }}</p>
                        @endif
                        @if($product->whatsapp)
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $product->whatsapp) }}" target="_blank" rel="noopener"
                                class="mt-4 w-full inline-flex items-center justify-center gap-2 rounded-xl bg-green-500 px-4 py-2.5 text-sm font-medium text-white hover:bg-green-600 transition-colors">
                                <span class="material-symbols-outlined text-base">chat</span>
                                Hubungi via WhatsApp
                            </a>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-3 card p-12 text-center">
                    <span class="material-symbols-outlined text-5xl text-gray-200 mb-3">storefront</span>
                    <p class="text-gray-400 font-medium">Tidak ada UMKM ditemukan.</p>
                    <p class="text-xs text-gray-300 mt-1">Coba ubah kata kunci pencarian</p>
                </div>
            @endforelse
        </div>
    </section>
</div>
