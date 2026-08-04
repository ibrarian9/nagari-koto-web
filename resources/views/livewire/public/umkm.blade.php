<div>
    {{-- ─── HERO ─────────────────────────────────── --}}
    <x-hero-section slug="umkm" gradient="from-amber-500 via-orange-600 to-amber-700" class="py-12">
        <div class="text-center">
            <div class="inline-flex items-center justify-center h-14 w-14 rounded-2xl bg-white/10 mb-4 shadow-md">
                <span class="material-symbols-outlined text-white text-2xl">storefront</span>
            </div>
            <h1 class="text-3xl md:text-4xl font-extrabold text-white tracking-tight">UMKM & Produk Nagari</h1>
            <p class="mt-2 text-amber-100 max-w-lg mx-auto">Dukung usaha lokal nagari kami — temukan produk, kuliner, dan kerajinan dari warga</p>
        </div>
    </x-hero-section>

    <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-10">
        {{-- Category Filter --}}
        @if($categories->count())
            <div class="flex flex-wrap justify-center gap-2 mb-6">
                <button wire:click="$set('category', '')"
                    class="flex items-center gap-1.5 px-4 py-2 rounded-xl text-sm font-medium transition-all {{ $category === '' ? 'bg-amber-600 text-white shadow-md' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-50' }}">
                    <span class="material-symbols-outlined text-base">apps</span>
                    Semua Produk
                </button>
                @foreach ($categories as $cat)
                    <button wire:click="$set('category', '{{ $cat }}')"
                        class="px-4 py-2 rounded-xl text-sm font-medium transition-all {{ $category === $cat ? 'bg-amber-600 text-white shadow-md' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-50' }}">
                        {{ $cat }}
                    </button>
                @endforeach
            </div>
        @endif

        {{-- Search Input --}}
        <div class="card p-4 mb-8 max-w-md mx-auto">
            <div class="relative">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">search</span>
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari nama usaha, pemilik, produk..."
                    class="form-input pl-10 w-full text-sm">
            </div>
        </div>

        {{-- Grid UMKM --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($products as $product)
                <div class="card group overflow-hidden hover:-translate-y-1 transition-all duration-300 border border-gray-200/80 shadow-sm">
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
                                <span class="badge bg-white/90 backdrop-blur-sm text-amber-800 shadow-sm font-semibold">{{ $product->category }}</span>
                            </div>
                        @endif
                    </div>

                    <div class="card-body flex flex-col justify-between">
                        <div>
                            <h3 class="font-bold text-gray-900 text-base leading-snug group-hover:text-amber-600 transition-colors">
                                {{ $product->business_name }}
                            </h3>
                            <div class="flex items-center gap-2 mt-1.5 text-sm text-gray-600">
                                <span class="material-symbols-outlined text-sm text-amber-600">person</span>
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
                        </div>

                        {{-- Action Buttons (Detail modal & WhatsApp link) --}}
                        <div class="mt-5 pt-3 border-t border-gray-100 flex items-center gap-2">
                            <button
                                data-product="{{ json_encode([
                                    'title' => $product->business_name,
                                    'owner' => $product->owner_name,
                                    'category' => $product->category ?? '',
                                    'address' => $product->address ?? '',
                                    'whatsapp' => $product->whatsapp ?? '',
                                    'photo' => $product->photo ? Storage::url($product->photo) : '',
                                    'description' => $product->description ?? '',
                                    'detailurl' => route('umkm.show', $product->id),
                                ]) }}"
                                onclick="showUmkmDetailModal(this)"
                                class="flex-1 btn-secondary btn-sm justify-center text-xs font-semibold text-gray-700 hover:text-amber-600">
                                <span class="material-symbols-outlined text-sm">info</span> Detail
                            </button>

                            @if($product->whatsapp)
                                @php
                                    $waNumber = preg_replace('/[^0-9]/', '', $product->whatsapp);
                                    if (str_starts_with($waNumber, '0')) {
                                        $waNumber = '62' . substr($waNumber, 1);
                                    }
                                    $waMsg = rawurlencode("Halo {$product->owner_name}, saya tertarik dengan produk {$product->business_name} di Website Nagari. Boleh info selengkapnya?");
                                @endphp
                                <a href="https://wa.me/{{ $waNumber }}?text={{ $waMsg }}" target="_blank" rel="noopener"
                                    class="flex-1 inline-flex items-center justify-center gap-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 px-3 py-2 text-xs font-bold text-white transition-colors">
                                    <span class="material-symbols-outlined text-sm">chat</span> WhatsApp
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-3 card p-12 text-center">
                    <span class="material-symbols-outlined text-5xl text-gray-200 mb-3">storefront</span>
                    <p class="text-gray-400 font-medium">Tidak ada UMKM ditemukan.</p>
                    <p class="text-xs text-gray-300 mt-1">Coba ubah kata kunci pencarian atau kategori</p>
                </div>
            @endforelse
        </div>
    </section>
</div>

{{-- Script SweetAlert Modal Detail (Safe against quotes & special characters) --}}
<script>
    function escapeHtml(str) {
        if (!str) return '';
        return String(str)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    function showUmkmDetailModal(button) {
        let data = {};
        try {
            data = JSON.parse(button.dataset.product);
        } catch (e) {
            console.error('Failed to parse product data JSON:', e);
            return;
        }

        const safeTitle = escapeHtml(data.title);
        const safeOwner = escapeHtml(data.owner);
        const safeCategory = escapeHtml(data.category);
        const safeAddress = escapeHtml(data.address);
        const safeDescription = escapeHtml(data.description);
        const safeDetailUrl = escapeHtml(data.detailurl);

        let imgHtml = '';
        if (data.photo) {
            imgHtml = `<div class="aspect-video w-full rounded-xl overflow-hidden mb-4 bg-gray-100 border border-gray-200"><img src="${escapeHtml(data.photo)}" class="w-full h-full object-cover"></div>`;
        } else {
            imgHtml = `<div class="aspect-video w-full rounded-xl overflow-hidden mb-4 bg-amber-50 flex items-center justify-center text-amber-300"><span class="material-symbols-outlined text-6xl">storefront</span></div>`;
        }

        let catBadge = safeCategory ? `<span class="inline-block px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-800 mb-2 border border-amber-200">${safeCategory}</span>` : '';
        let addressHtml = safeAddress ? `<p class="text-xs text-gray-500 mb-3 flex items-center justify-center gap-1"><span class="material-symbols-outlined text-sm text-gray-400">location_on</span> ${safeAddress}</p>` : '';

        let waHtml = '';
        if (data.whatsapp) {
            let cleanNum = String(data.whatsapp).replace(/[^0-9]/g, '');
            if (cleanNum.startsWith('0')) cleanNum = '62' + cleanNum.substring(1);
            const waMsg = encodeURIComponent(`Halo ${data.owner}, saya tertarik dengan produk ${data.title} di Website Nagari. Boleh info selengkapnya?`);
            waHtml = `
                <div class="mt-4 pt-3 border-t border-gray-100 flex flex-col sm:flex-row gap-2">
                    <a href="https://wa.me/${cleanNum}?text=${waMsg}" target="_blank" rel="noopener"
                        class="flex-1 inline-flex items-center justify-center gap-2 rounded-xl bg-emerald-600 px-4 py-2.5 text-xs font-bold text-white shadow hover:bg-emerald-700 transition-all text-decoration-none">
                        <span class="material-symbols-outlined text-base">chat</span> Hubungi via WhatsApp (${escapeHtml(data.whatsapp)})
                    </a>
                    <a href="${safeDetailUrl}"
                        class="inline-flex items-center justify-center gap-1 px-4 py-2.5 rounded-xl border border-gray-200 text-xs font-semibold text-gray-700 hover:bg-gray-50 transition-colors text-decoration-none">
                        <span class="material-symbols-outlined text-base">open_in_new</span> Halaman Penuh
                    </a>
                </div>
            `;
        } else {
            waHtml = `
                <div class="mt-4 pt-3 border-t border-gray-100 flex justify-end">
                    <a href="${safeDetailUrl}"
                        class="inline-flex items-center justify-center gap-1 px-4 py-2.5 rounded-xl border border-gray-200 text-xs font-semibold text-gray-700 hover:bg-gray-50 transition-colors text-decoration-none">
                        <span class="material-symbols-outlined text-base">open_in_new</span> Buka Halaman Penuh
                    </a>
                </div>
            `;
        }

        Swal.fire({
            title: safeTitle,
            html: `
                ${imgHtml}
                ${catBadge}
                <p class="text-sm font-semibold text-gray-700 mb-1">Pemilik: <span class="text-gray-900">${safeOwner}</span></p>
                ${addressHtml}
                <div class="text-sm text-gray-700 text-left bg-gray-50 p-4 rounded-xl border border-gray-100 mt-3 whitespace-pre-line leading-relaxed max-h-60 overflow-y-auto">
                    ${safeDescription || 'Belum ada deskripsi rinci.'}
                </div>
                ${waHtml}
            `,
            width: 650,
            showCloseButton: true,
            showConfirmButton: false
        });
    }
</script>
