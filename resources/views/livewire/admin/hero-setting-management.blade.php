<div>
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
                <span class="material-symbols-outlined text-desa-600">wallpaper</span>
                Hero Halaman Publik
            </h1>
            <p class="text-sm text-gray-500 mt-1">Kelola foto background hero untuk seluruh halaman publik Nagari. Upload foto kustom untuk menggantikan warna gradient bawaan.</p>
        </div>
        <button wire:click="seedHeroes" class="btn-secondary btn-sm flex items-center gap-2 self-start sm:self-auto">
            <span class="material-symbols-outlined text-base">refresh</span> Refresh Data Hero
        </button>

    </div>

    @if (session()->has('message'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl text-sm text-green-700 flex items-center gap-2 shadow-sm">
            <span class="material-symbols-outlined text-green-600">check_circle</span>
            {{ session('message') }}
        </div>
    @endif

    {{-- Grid Hero Settings --}}
    @php
        $iconMap = [
            'beranda' => 'home',
            'profil' => 'info',
            'berita' => 'newspaper',
            'umkm' => 'storefront',
            'potensi' => 'landscape',
            'agenda' => 'calendar_month',
            'lembaga' => 'account_balance',
            'bamus' => 'gavel',
            'bansos' => 'handshake',
            'donasi' => 'volunteer_activism',
            'kehutanan' => 'forest',
            'ppid' => 'verified_user',
            'bumnag' => 'domain',
            'infografis' => 'bar_chart',
            'anggaran' => 'payments',
            'idm' => 'analytics',
            'surat' => 'mark_as_unread',
            'produk-hukum' => 'balance',
            'kontak' => 'call',
        ];

        $gradientMap = [
            'beranda' => 'from-emerald-700 via-desa-800 to-teal-950',
            'profil' => 'from-desa-700 via-desa-800 to-desa-950',
            'berita' => 'from-blue-700 via-indigo-800 to-slate-900',
            'umkm' => 'from-amber-600 via-orange-700 to-stone-900',
            'potensi' => 'from-emerald-600 via-teal-700 to-emerald-950',
            'agenda' => 'from-amber-600 via-orange-700 to-red-900',
            'lembaga' => 'from-purple-700 via-indigo-800 to-slate-900',
            'bamus' => 'from-slate-700 via-slate-800 to-slate-950',
            'bansos' => 'from-teal-700 via-emerald-800 to-green-950',
            'donasi' => 'from-rose-700 via-pink-800 to-slate-950',
            'kehutanan' => 'from-emerald-800 via-green-900 to-emerald-950',
            'ppid' => 'from-blue-800 via-blue-900 to-slate-950',
            'bumnag' => 'from-sky-700 via-blue-800 to-indigo-950',
            'infografis' => 'from-cyan-700 via-blue-800 to-indigo-950',
            'anggaran' => 'from-green-700 via-emerald-800 to-slate-950',
            'idm' => 'from-indigo-700 via-purple-800 to-slate-950',
            'surat' => 'from-blue-700 via-indigo-800 to-purple-950',
            'produk-hukum' => 'from-slate-700 via-gray-800 to-zinc-950',
            'kontak' => 'from-teal-700 via-cyan-800 to-slate-950',
        ];
    @endphp

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
        @forelse ($heroes as $hero)
            @php
                $icon = $iconMap[$hero->page_slug] ?? 'wallpaper';
                $gradient = $gradientMap[$hero->page_slug] ?? 'from-desa-700 via-desa-800 to-desa-950';
            @endphp
            <div class="card overflow-hidden group hover:shadow-lg transition-all duration-300 border border-gray-200/80" wire:key="hero-card-{{ $hero->id }}">
                {{-- Preview Header --}}
                <div class="relative aspect-[21/9] bg-gradient-to-br {{ $gradient }} overflow-hidden">
                    @if ($hero->image)
                        <img src="{{ Storage::url($hero->image) }}" alt="{{ $hero->page_label }}" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-br from-black/60 via-black/40 to-black/70"></div>
                    @else
                        {{-- Decorative SVG Pattern for Default Gradient --}}
                        <div class="absolute inset-0 opacity-20 bg-[radial-gradient(#fff_1px,transparent_1px)] [background-size:16px_16px]"></div>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <span class="material-symbols-outlined text-6xl text-white/25 group-hover:scale-110 transition-transform duration-300">{{ $icon }}</span>
                        </div>
                    @endif

                    <div class="absolute bottom-3 left-4 right-4 z-10">
                        <div class="flex items-center gap-1.5 mb-1">
                            <span class="material-symbols-outlined text-white/80 text-sm">{{ $icon }}</span>
                            <h3 class="text-white font-bold text-sm drop-shadow-md truncate">{{ $hero->page_label }}</h3>
                        </div>
                        <p class="text-white/70 text-xs font-mono">/{{ $hero->page_slug }}</p>
                    </div>

                    {{-- Status Badge --}}
                    @if ($hero->image)
                        <span class="absolute top-2.5 right-2.5 inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-emerald-500/90 text-white text-[11px] font-semibold backdrop-blur-sm shadow-sm">
                            <span class="material-symbols-outlined text-xs">check_circle</span> Custom Image
                        </span>
                    @else
                        <span class="absolute top-2.5 right-2.5 inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-white/20 text-white text-[11px] font-medium backdrop-blur-md border border-white/30">
                            <span class="material-symbols-outlined text-xs">palette</span> Gradient Bawaan
                        </span>
                    @endif
                </div>

                {{-- Action Area --}}
                <div class="p-4 bg-white">
                    @if ($editingId === $hero->id)
                        {{-- Upload Form --}}
                        <form wire:submit="uploadImage({{ $hero->id }})" class="space-y-3">
                            <div x-data="{ previewUrl: null }">
                                <label class="block cursor-pointer">
                                    <div class="flex items-center gap-2 px-4 py-3 rounded-xl border-2 border-dashed border-desa-300 hover:border-desa-500 bg-desa-50/40 hover:bg-desa-50 transition-all text-sm text-gray-700">
                                        <span class="material-symbols-outlined text-xl text-desa-600">cloud_upload</span>
                                        <span class="font-medium" x-text="previewUrl ? 'Ganti file foto' : 'Pilih Foto Hero'">Pilih Foto Hero</span>
                                    </div>
                                    <input type="file" wire:model="newImage" accept="image/*" class="sr-only"
                                        x-on:change="const f = $event.target.files[0]; if(f) { const r = new FileReader(); r.onload = e => previewUrl = e.target.result; r.readAsDataURL(f); }">
                                </label>
                                <template x-if="previewUrl">
                                    <div class="mt-3 relative rounded-xl overflow-hidden border border-gray-200 shadow-inner aspect-[21/9]">
                                        <img :src="previewUrl" class="w-full h-full object-cover">
                                        <span class="absolute bottom-2 left-2 px-2 py-0.5 bg-black/60 text-white text-[10px] rounded">Preview Baru</span>
                                    </div>
                                </template>
                                <div wire:loading wire:target="newImage" class="mt-2 text-xs text-desa-600 flex items-center gap-1.5">
                                    <span class="material-symbols-outlined text-sm animate-spin">progress_activity</span>
                                    Mengunggah file...
                                </div>
                            </div>

                            @error('newImage')
                                <p class="text-xs text-red-500 font-medium">{{ $message }}</p>
                            @enderror
                            <p class="text-[11px] text-gray-400">Rekomendasi: Rasio 16:9 atau 21:9 (1920×600px). JPG/PNG/WebP, maks 2MB.</p>

                            <div class="flex gap-2 pt-1">
                                <button type="submit" class="btn-primary btn-sm flex-1 justify-center" wire:loading.attr="disabled" wire:target="uploadImage">
                                    <span class="material-symbols-outlined text-sm">save</span> Simpan Foto
                                </button>
                                <button type="button" wire:click="cancelEdit" class="btn-secondary btn-sm">
                                    Batal
                                </button>
                            </div>
                        </form>
                    @else
                        <div class="flex items-center gap-2">
                            <button wire:click="startEdit({{ $hero->id }})" class="btn-primary btn-sm flex-1 justify-center">
                                <span class="material-symbols-outlined text-sm">{{ $hero->image ? 'edit' : 'add_photo_alternate' }}</span>
                                {{ $hero->image ? 'Ganti Foto Hero' : 'Upload Foto Hero' }}
                            </button>

                            @if ($hero->image)
                                <button type="button" onclick="confirmAction({{ $hero->id }}, 'removeImageConfirmed', 'Kembalikan foto hero {{ addslashes($hero->page_label) }} ke gradient bawaan sistem?')"
                                    class="h-9 w-9 rounded-lg flex items-center justify-center border border-red-200 text-red-500 hover:bg-red-50 hover:text-red-700 transition-colors" title="Hapus Foto Kustom (Kembalikan ke Default)">
                                    <span class="material-symbols-outlined text-base">delete</span>
                                </button>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="col-span-full card p-12 text-center">
                <span class="material-symbols-outlined text-5xl text-gray-300 mb-3">wallpaper</span>
                <h3 class="text-lg font-bold text-gray-800 mb-1">Belum Ada Data Hero Halaman</h3>
                <p class="text-sm text-gray-500 mb-6">Klik tombol di bawah untuk membuat daftarkan seluruh 19 halaman publik secara otomatis.</p>
                <button wire:click="seedHeroes" class="btn-primary inline-flex items-center gap-2">
                    <span class="material-symbols-outlined text-base">add_circle</span> Inisialisasi Data Hero Sekarang
                </button>
            </div>
        @endforelse
    </div>
</div>
