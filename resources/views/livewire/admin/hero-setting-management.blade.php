<div>
    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
                <span class="material-symbols-outlined text-desa-500">wallpaper</span>
                Hero Halaman
            </h1>
            <p class="text-sm text-gray-500 mt-1">Kelola foto background hero untuk setiap halaman publik</p>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl text-sm text-green-700 flex items-center gap-2">
            <span class="material-symbols-outlined text-green-500">check_circle</span>
            {{ session('message') }}
        </div>
    @endif

    {{-- Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
        @foreach ($heroes as $hero)
            <div class="card overflow-hidden group" wire:key="hero-{{ $hero->id }}">
                {{-- Preview --}}
                <div class="relative aspect-[21/9] bg-gradient-to-br from-gray-700 to-gray-900 overflow-hidden">
                    @if ($hero->image)
                        <img src="{{ Storage::url($hero->image) }}" alt="{{ $hero->page_label }}"
                            class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-br from-black/50 to-black/40"></div>
                    @else
                        <div class="absolute inset-0 flex items-center justify-center">
                            <span class="material-symbols-outlined text-5xl text-white/20">wallpaper</span>
                        </div>
                    @endif
                    <div class="absolute bottom-3 left-4 right-4">
                        <h3 class="text-white font-bold text-sm drop-shadow-lg">{{ $hero->page_label }}</h3>
                        <p class="text-white/60 text-xs">/{{ $hero->page_slug }}</p>
                    </div>
                    @if ($hero->image)
                        <span class="absolute top-2 right-2 inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-green-500/90 text-white text-[10px] font-semibold">
                            <span class="material-symbols-outlined text-xs">image</span> Custom
                        </span>
                    @else
                        <span class="absolute top-2 right-2 inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-gray-500/70 text-white text-[10px] font-semibold">
                            Default
                        </span>
                    @endif
                </div>

                {{-- Actions --}}
                <div class="p-4">
                    @if ($editingId === $hero->id)
                        {{-- Upload form --}}
                        <form wire:submit="uploadImage({{ $hero->id }})" class="space-y-3">
                            <div x-data="{ previewUrl: null }">
                                <label class="block cursor-pointer">
                                    <div class="flex items-center gap-2 px-4 py-2.5 rounded-lg border-2 border-dashed border-gray-200 hover:border-desa-400 transition-colors text-sm text-gray-500">
                                        <span class="material-symbols-outlined text-base">cloud_upload</span>
                                        <span x-text="previewUrl ? 'Ganti file' : 'Pilih foto hero'">Pilih foto hero</span>
                                    </div>
                                    <input type="file" wire:model="newImage" accept="image/*" class="sr-only"
                                        x-on:change="const f = $event.target.files[0]; if(f) { const r = new FileReader(); r.onload = e => previewUrl = e.target.result; r.readAsDataURL(f); }">
                                </label>
                                <template x-if="previewUrl">
                                    <img :src="previewUrl" class="mt-2 w-full aspect-[21/9] object-cover rounded-lg border">
                                </template>
                                <div wire:loading wire:target="newImage" class="mt-2 text-xs text-desa-600 flex items-center gap-1">
                                    <span class="material-symbols-outlined text-sm animate-spin">progress_activity</span>
                                    Mengunggah...
                                </div>
                            </div>
                            @error('newImage')
                                <p class="text-xs text-red-500">{{ $message }}</p>
                            @enderror
                            <p class="text-xs text-gray-400">Rekomendasi: 1920×600px. JPG/PNG/WebP. Maks 2MB.</p>

                            <div class="flex gap-2">
                                <button type="submit"
                                    class="btn-primary btn-sm flex-1"
                                    wire:loading.attr="disabled" wire:target="uploadImage">
                                    <span class="material-symbols-outlined text-sm">save</span> Simpan
                                </button>
                                <button type="button" wire:click="cancelEdit" class="btn-secondary btn-sm">
                                    Batal
                                </button>
                            </div>
                        </form>
                    @else
                        <div class="flex gap-2">
                            <button wire:click="startEdit({{ $hero->id }})"
                                class="btn-primary btn-sm flex-1">
                                <span class="material-symbols-outlined text-sm">{{ $hero->image ? 'edit' : 'add_photo_alternate' }}</span>
                                {{ $hero->image ? 'Ganti Foto' : 'Upload Foto' }}
                            </button>
                            @if ($hero->image)
                                <button type="button" onclick="confirmAction({{ $hero->id }}, 'removeImageConfirmed', 'Kembalikan foto hero {{ addslashes($hero->page_label) }} ke foto default?')"
                                    class="btn-secondary btn-sm text-red-500 hover:text-red-700" title="Hapus Foto / Kembalikan ke Default">
                                    <span class="material-symbols-outlined text-sm">delete</span>
                                </button>
                            @endif

                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>
