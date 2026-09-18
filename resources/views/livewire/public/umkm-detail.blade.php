<div>
    {{-- Hero Header --}}
    <x-hero-section slug="umkm" gradient="from-amber-700 via-orange-700 to-amber-900" class="py-12 md:py-14">
        <div class="max-w-4xl mx-auto px-4">
            <div class="mb-4">
                <a href="{{ route('umkm') }}" wire:navigate
                    class="inline-flex items-center gap-2 text-sm font-semibold text-amber-100 hover:text-white transition-colors group focus:outline-none focus-visible:ring-2 focus-visible:ring-amber-300 rounded-lg px-2 py-1 -ml-2">
                    <span class="material-symbols-outlined text-lg group-hover:-translate-x-1 transition-transform">arrow_back</span>
                    Kembali ke Katalog UMKM & Produk Nagari
                </a>
            </div>
            <div class="flex flex-wrap items-center gap-3 mb-3">
                @if($product->category)
                    <span class="bg-white/20 text-white border border-white/30 text-xs font-bold uppercase tracking-wider px-2.5 py-1 rounded-md">
                        {{ $product->category }}
                    </span>
                @endif
                <span class="bg-emerald-700 text-white text-xs font-semibold inline-flex items-center gap-1.5 px-3 py-1 rounded-md shadow-xs">
                    <span class="material-symbols-outlined text-sm">verified</span> UMKM Terverifikasi Nagari
                </span>
            </div>
            <h1 class="text-3xl md:text-4xl font-extrabold text-white tracking-tight leading-tight">{{ $product->business_name }}</h1>
            <p class="mt-2 text-amber-100 flex items-center gap-2 text-sm font-medium">
                <span class="material-symbols-outlined text-base">person</span> Pemilik: <strong class="text-white font-bold">{{ $product->owner_name }}</strong>
            </p>
        </div>
    </x-hero-section>

    <section class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 py-10 md:py-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Main Content (Left Col 2 cols) --}}
            <div class="lg:col-span-2 space-y-6">
                {{-- Product Image Showcase --}}
                <div class="overflow-hidden border border-slate-200 shadow-sm rounded-2xl bg-slate-100">
                    <div class="aspect-video bg-slate-100 overflow-hidden relative">
                        @if($product->photo)
                            <img src="{{ Storage::url($product->photo) }}" alt="{{ $product->business_name }}"
                                class="w-full h-full object-cover" loading="eager" decoding="async">
                        @else
                            <div class="w-full h-full flex flex-col items-center justify-center bg-slate-50 p-6 text-center text-slate-400">
                                <span class="material-symbols-outlined text-6xl text-slate-400 mb-2">storefront</span>
                                <p class="text-xs text-slate-600 font-medium">Foto Usaha Tidak Tersedia</p>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Description Card --}}
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 md:p-8 space-y-4">
                    <div class="flex items-center gap-3.5 border-b border-slate-200 pb-4">
                        <div class="h-11 w-11 rounded-xl bg-amber-100 text-amber-800 border border-amber-200 flex items-center justify-center flex-shrink-0">
                            <span class="material-symbols-outlined text-xl">description</span>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-slate-900 tracking-tight leading-tight">Tentang Usaha / Produk</h2>
                            <p class="text-xs text-slate-600 font-medium mt-0.5">Profil dan keunggulan produk UMKM</p>
                        </div>
                    </div>

                    @if($product->description)
                        <div class="text-slate-700 leading-relaxed text-sm md:text-base whitespace-pre-line">
                            {{ $product->description }}
                        </div>
                    @else
                        <p class="text-sm text-slate-500 italic">Belum ada deskripsi rinci untuk usaha ini.</p>
                    @endif
                </div>

                {{-- Location & Address Card --}}
                @if($product->address)
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 space-y-3">
                        <div class="flex items-center gap-3.5 border-b border-slate-200 pb-3">
                            <div class="h-10 w-10 rounded-xl bg-blue-100 text-blue-700 border border-blue-200 flex items-center justify-center flex-shrink-0">
                                <span class="material-symbols-outlined text-lg">location_on</span>
                            </div>
                            <div>
                                <h3 class="font-bold text-slate-900 text-sm tracking-tight leading-tight">Alamat & Lokasi Usaha</h3>
                                <p class="text-xs text-slate-600 font-medium mt-0.5">Jorong / kawasan usaha di Nagari</p>
                            </div>
                        </div>
                        <p class="text-sm text-slate-800 flex items-start gap-2 pt-1 font-medium">
                            <span class="material-symbols-outlined text-base text-slate-500 mt-0.5">map</span>
                            {{ $product->address }}
                        </p>
                    </div>
                @endif
            </div>

            {{-- Sidebar Info & Actions (Right Col 1 col) --}}
            <div class="space-y-6">
                {{-- Contact CTA Card --}}
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-4">
                    <h3 class="font-bold text-slate-900 flex items-center gap-2 text-base">
                        <span class="material-symbols-outlined text-emerald-600">contact_phone</span>
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
                            class="w-full inline-flex items-center justify-center gap-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 px-5 py-3 text-sm font-bold text-white shadow-sm transition-all focus:outline-none focus-visible:ring-2 focus-visible:ring-emerald-500 focus-visible:ring-offset-2">
                            <span class="material-symbols-outlined text-lg">chat</span>
                            Hubungi via WhatsApp
                        </a>
                        <p class="text-xs text-slate-600 text-center font-medium">Langsung terhubung dengan pengelola {{ $product->business_name }}</p>
                    @else
                        <div class="p-4 bg-slate-50 rounded-xl border border-slate-200 text-center text-xs text-slate-600 font-medium">
                            Nomor WhatsApp belum tercantum.
                        </div>
                    @endif
                </div>

                {{-- Detail Summary Card --}}
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-4">
                    <h3 class="font-bold text-slate-900 text-sm border-b border-slate-200 pb-3 flex items-center gap-2">
                        <span class="material-symbols-outlined text-desa-600">info</span>
                        Informasi Singkat
                    </h3>

                    <div class="space-y-3 text-xs">
                        <div class="flex justify-between items-center py-1.5 border-b border-slate-100">
                            <span class="text-slate-600 font-medium">Nama Usaha</span>
                            <strong class="font-bold text-slate-900 text-right">{{ $product->business_name }}</strong>
                        </div>
                        <div class="flex justify-between items-center py-1.5 border-b border-slate-100">
                            <span class="text-slate-600 font-medium">Pemilik Usaha</span>
                            <strong class="font-bold text-slate-900 text-right">{{ $product->owner_name }}</strong>
                        </div>
                        <div class="flex justify-between items-center py-1.5 border-b border-slate-100">
                            <span class="text-slate-600 font-medium">Kategori</span>
                            <span class="font-bold text-amber-800 text-right">{{ $product->category ?? 'Umum' }}</span>
                        </div>
                        @if($product->address)
                            <div class="flex justify-between items-center py-1.5 border-b border-slate-100">
                                <span class="text-slate-600 font-medium">Lokasi</span>
                                <strong class="font-bold text-slate-900 text-right max-w-[150px] truncate">{{ $product->address }}</strong>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Share Button Card --}}
                <div x-data="{ copied: false }" class="bg-white rounded-2xl border border-slate-200 shadow-sm p-4 text-center">
                    <button 
                        type="button"
                        @click="navigator.clipboard.writeText(window.location.href); copied = true; setTimeout(() => copied = false, 2000)"
                        class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl border text-sm font-semibold transition-all focus:outline-none focus-visible:ring-2 focus-visible:ring-desa-500 focus-visible:ring-offset-2"
                        :class="copied ? 'bg-emerald-700 text-white border-emerald-700' : 'bg-slate-50 text-slate-700 border-slate-300 hover:bg-slate-100 hover:text-slate-900'">
                        <span class="material-symbols-outlined text-base" x-text="copied ? 'check' : 'share'">share</span>
                        <span x-text="copied ? 'Link Berhasil Disalin!' : 'Bagikan Produk UMKM Ini'">Bagikan Produk UMKM Ini</span>
                    </button>
                </div>
            </div>
        </div>

        {{-- Related UMKM Section --}}
        @if($relatedProducts->count())
            <div class="mt-16 pt-10 border-t border-slate-200">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="text-xl font-bold text-slate-900 tracking-tight leading-tight">UMKM & Produk Lainnya</h2>
                        <p class="text-xs text-slate-600 font-medium mt-0.5">Dukung juga usaha warga nagari lainnya</p>
                    </div>
                    <a href="{{ route('umkm') }}" wire:navigate class="text-xs font-bold text-amber-700 hover:text-amber-800 flex items-center gap-1">
                        Lihat Semua <span class="material-symbols-outlined text-sm">arrow_forward</span>
                    </a>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                    @foreach($relatedProducts as $rel)
                        <div class="group bg-white rounded-2xl border border-slate-200 shadow-xs hover:border-slate-300 hover:shadow-sm transition-all duration-200 overflow-hidden flex flex-col">
                            <div class="aspect-video bg-slate-100 overflow-hidden relative">
                                @if($rel->photo)
                                    <img src="{{ Storage::url($rel->photo) }}" alt="{{ $rel->business_name }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" loading="lazy">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-slate-50 text-slate-400">
                                        <span class="material-symbols-outlined text-4xl">storefront</span>
                                    </div>
                                @endif
                            </div>
                            <div class="p-5 space-y-2 flex-1 flex flex-col justify-between">
                                <div>
                                    <h3 class="font-bold text-slate-900 text-sm group-hover:text-amber-700 transition-colors truncate">{{ $rel->business_name }}</h3>
                                    <p class="text-xs text-slate-600 font-medium truncate mt-0.5">{{ $rel->owner_name }}</p>
                                </div>
                                <a href="{{ route('umkm.show', $rel->id) }}" wire:navigate
                                    class="inline-flex items-center gap-1 text-xs font-bold text-amber-700 hover:text-amber-800 pt-2">
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
