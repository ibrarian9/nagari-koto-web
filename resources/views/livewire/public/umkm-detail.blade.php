<div>
    {{-- Hero Header --}}
    <x-hero-section slug="umkm" gradient="from-amber-600 via-orange-600 to-amber-800" class="py-12">
        <div class="max-w-4xl mx-auto px-4">
            <div class="mb-4">
                <a href="{{ route('umkm') }}" wire:navigate
                    class="inline-flex items-center gap-2 text-sm font-semibold text-amber-100 hover:text-white transition-colors group">
                    <span class="material-symbols-outlined text-lg group-hover:-translate-x-1 transition-transform">arrow_back</span>
                    Kembali ke Katalog UMKM & Produk Nagari
                </a>
            </div>
            <div class="flex flex-wrap items-center gap-3 mb-2">
                @if($product->category)
                    <span class="badge bg-white/20 text-white backdrop-blur-md border border-white/30 text-xs font-bold uppercase tracking-wider">
                        {{ $product->category }}
                    </span>
                @endif
                <span class="badge bg-emerald-500/80 text-white text-xs font-medium backdrop-blur-sm inline-flex items-center gap-1">
                    <span class="material-symbols-outlined text-xs">verified</span> UMKM Terverifikasi Nagari
                </span>
            </div>
            <h1 class="text-3xl md:text-4xl font-extrabold text-white tracking-tight drop-shadow-sm">{{ $product->business_name }}</h1>
            <p class="mt-2 text-amber-100 flex items-center gap-2 text-sm">
                <span class="material-symbols-outlined text-base">person</span> Pemilik: <strong class="text-white">{{ $product->owner_name }}</strong>
            </p>
        </div>
    </x-hero-section>

    <section class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 py-10">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Main Content (Left Col 2 cols) --}}
            <div class="lg:col-span-2 space-y-6">
                {{-- Product Image Showcase --}}
                <div class="card overflow-hidden border border-gray-200 shadow-md">
                    <div class="aspect-video bg-gray-100 overflow-hidden relative">
                        @if($product->photo)
                            <img src="{{ Storage::url($product->photo) }}" alt="{{ $product->business_name }}"
                                class="w-full h-full object-cover" loading="eager" decoding="async">
                        @else
                            <div class="w-full h-full flex flex-col items-center justify-center bg-gradient-to-br from-amber-50 to-orange-50 p-6 text-center">
                                <span class="material-symbols-outlined text-7xl text-amber-200 mb-2">storefront</span>
                                <p class="text-xs text-amber-400 font-medium">Foto Usaha Tidak Tersedia</p>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Description Card --}}
                <div class="card p-6 md:p-8 space-y-4">
                    <div class="flex items-center gap-3 border-b border-gray-100 pb-4">
                        <div class="h-10 w-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                            <span class="material-symbols-outlined text-xl">description</span>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-gray-900">Tentang Usaha / Produk</h2>
                            <p class="text-xs text-gray-500">Profil dan keunggulan produk UMKM</p>
                        </div>
                    </div>

                    @if($product->description)
                        <div class="prose prose-amber max-w-none text-gray-700 leading-relaxed text-sm whitespace-pre-line">
                            {{ $product->description }}
                        </div>
                    @else
                        <p class="text-sm text-gray-400 italic">Belum ada deskripsi rinci untuk usaha ini.</p>
                    @endif
                </div>

                {{-- Location & Address Card --}}
                @if($product->address)
                    <div class="card p-6 space-y-3">
                        <div class="flex items-center gap-3 border-b border-gray-100 pb-3">
                            <div class="h-9 w-9 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                                <span class="material-symbols-outlined text-lg">location_on</span>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900 text-sm">Alamat & Lokasi Usaha</h3>
                                <p class="text-xs text-gray-400">Jorong / kawasan usaha di Nagari</p>
                            </div>
                        </div>
                        <p class="text-sm text-gray-700 flex items-start gap-2 pt-1">
                            <span class="material-symbols-outlined text-base text-gray-400 mt-0.5">map</span>
                            {{ $product->address }}
                        </p>
                    </div>
                @endif
            </div>

            {{-- Sidebar Info & Actions (Right Col 1 col) --}}
            <div class="space-y-6">
                {{-- Contact CTA Card --}}
                <div class="card p-6 bg-gradient-to-br from-amber-50/60 via-white to-orange-50/40 border border-amber-200/80 shadow-md space-y-4">
                    <h3 class="font-bold text-gray-900 flex items-center gap-2">
                        <span class="material-symbols-outlined text-amber-600">contact_phone</span>
                        Pesan & Hubungi Pemilik
                    </h3>

                    @if($product->whatsapp)
                        @php
                            $waNumber = preg_replace('/[^0-9]/', '', $product->whatsapp);
                            if (str_starts_with($waNumber, '0')) {
                                $waNumber = '62' . substr($waNumber, 1);
                            }
                            $waMessage = rawurlencode("Halo {$product->owner_name}, saya tertarik dengan produk {$product->business_name} yang terdaftar di Website Nagari Koto. Boleh info selengkapnya?");
                        @endphp
                        <a href="https://wa.me/{{ $waNumber }}?text={{ $waMessage }}" target="_blank" rel="noopener"
                            class="w-full inline-flex items-center justify-center gap-2 rounded-xl bg-emerald-600 px-5 py-3 text-sm font-bold text-white shadow-md shadow-emerald-600/20 hover:bg-emerald-700 hover:shadow-lg transition-all transform hover:-translate-y-0.5">
                            <span class="material-symbols-outlined text-lg">chat</span>
                            Hubungi via WhatsApp
                        </a>
                        <p class="text-[11px] text-gray-500 text-center">Langsung terhubung dengan pengelola {{ $product->business_name }}</p>
                    @else
                        <div class="p-3 bg-gray-100 rounded-xl text-center text-xs text-gray-500">
                            Nomor WhatsApp belum tercantum.
                        </div>
                    @endif
                </div>

                {{-- Detail Summary Card --}}
                <div class="card p-6 space-y-4">
                    <h3 class="font-bold text-gray-900 text-sm border-b border-gray-100 pb-3 flex items-center gap-2">
                        <span class="material-symbols-outlined text-desa-600">info</span>
                        Informasi Singkat
                    </h3>

                    <div class="space-y-3 text-xs">
                        <div class="flex justify-between py-1.5 border-b border-gray-100">
                            <span class="text-gray-400">Nama Usaha</span>
                            <span class="font-semibold text-gray-800 text-right">{{ $product->business_name }}</span>
                        </div>
                        <div class="flex justify-between py-1.5 border-b border-gray-100">
                            <span class="text-gray-400">Pemilik Usaha</span>
                            <span class="font-semibold text-gray-800 text-right">{{ $product->owner_name }}</span>
                        </div>
                        <div class="flex justify-between py-1.5 border-b border-gray-100">
                            <span class="text-gray-400">Kategori</span>
                            <span class="font-semibold text-amber-700 text-right">{{ $product->category ?? 'Umum' }}</span>
                        </div>
                        @if($product->address)
                            <div class="flex justify-between py-1.5 border-b border-gray-100">
                                <span class="text-gray-400">Lokasi</span>
                                <span class="font-semibold text-gray-800 text-right max-w-[150px] truncate">{{ $product->address }}</span>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Share Button Card --}}
                <div x-data="{ copied: false }" class="card p-4 text-center">
                    <button @click="navigator.clipboard.writeText(window.location.href); copied = true; setTimeout(() => copied = false, 2000)"
                        class="w-full btn-secondary btn-sm flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined text-base" x-text="copied ? 'check' : 'share'">share</span>
                        <span x-text="copied ? 'Link Berhasil Disalin!' : 'Bagikan Produk UMKM Ini'">Bagikan Produk UMKM Ini</span>
                    </button>
                </div>
            </div>
        </div>

        {{-- Related UMKM Section --}}
        @if($relatedProducts->count())
            <div class="mt-16 pt-10 border-t border-gray-200">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">UMKM & Produk Lainnya</h2>
                        <p class="text-xs text-gray-500">Dukung juga usaha warga nagari lainnya</p>
                    </div>
                    <a href="{{ route('umkm') }}" wire:navigate class="text-xs font-semibold text-amber-600 hover:text-amber-700 flex items-center gap-1">
                        Lihat Semua <span class="material-symbols-outlined text-sm">arrow_forward</span>
                    </a>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                    @foreach($relatedProducts as $rel)
                        <div class="card group overflow-hidden hover:-translate-y-1 transition-all duration-300">
                            <div class="aspect-video bg-gray-100 overflow-hidden relative">
                                @if($rel->photo)
                                    <img src="{{ Storage::url($rel->photo) }}" alt="{{ $rel->business_name }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-amber-50">
                                        <span class="material-symbols-outlined text-4xl text-amber-200">storefront</span>
                                    </div>
                                @endif
                            </div>
                            <div class="p-4 space-y-2">
                                <h3 class="font-bold text-gray-900 text-sm group-hover:text-amber-600 transition-colors truncate">{{ $rel->business_name }}</h3>
                                <p class="text-xs text-gray-500 truncate">{{ $rel->owner_name }}</p>
                                <a href="{{ route('umkm.show', $rel->id) }}" wire:navigate
                                    class="inline-flex items-center gap-1 text-xs font-semibold text-amber-600 hover:text-amber-700 pt-1">
                                    Lihat Detail <span class="material-symbols-outlined text-xs">arrow_forward</span>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </section>
</div>
