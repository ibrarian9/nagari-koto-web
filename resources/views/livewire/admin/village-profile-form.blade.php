<div>
    {{-- ─── HEADER ─────────────────────────────────── --}}
    <div class="mb-6">
        <h2 class="text-xl font-bold text-gray-900">Edit Profil Nagari</h2>
        <p class="text-sm text-gray-500 mt-0.5">Kelola informasi profil dan identitas nagari</p>
    </div>
    <x-page-guide title="Panduan Profil Nagari" description="Halaman ini mengelola identitas nagari yang ditampilkan di seluruh website. Lengkapi informasi umum (nama, tagline, kode nagari), upload logo dan foto nagari, serta isi kontak dan media sosial. Data yang diisi di sini menjadi sumber informasi utama yang ditampilkan di halaman Profil Nagari." />

    <form wire:submit="save" class="space-y-6">
        <x-form-guide title="Panduan Pengisian Profil Nagari">
            <ul class="list-disc list-inside space-y-1">
                <li><strong>Informasi Umum</strong> — Nama resmi nagari, tagline, kode nagari (dari Kemendagri), luas
                    wilayah, dan tahun berdiri</li>
                <li><strong>Lokasi & Wilayah</strong> — Alamat administratif lengkap (provinsi, kabupaten, kecamatan),
                    alamat kantor, dan koordinat peta (latitude/longitude dari Google Maps)</li>
                <li><strong>Kontak</strong> — Email dan website resmi nagari</li>
                <li><strong>Visi & Misi</strong> — Rumusan visi dan misi nagari sesuai RPJMDes</li>
                <li><strong>Sejarah</strong> — Gunakan editor teks untuk menulis sejarah nagari dengan format yang rapi
                </li>
                <li><strong>Media</strong> — Upload foto nagari (cth: foto kantor/pemandangan) dan logo resmi, maks 2MB
                </li>
            </ul>
        </x-form-guide>
        {{-- Informasi Umum --}}
        <div class="card overflow-hidden">
            <div class="p-5 bg-gray-50 border-b border-gray-100 flex items-center gap-3">
                <div class="h-9 w-9 rounded-lg bg-desa-100 flex items-center justify-center">
                    <span class="material-symbols-outlined text-desa-600">location_city</span>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900">Informasi Umum</h3>
                    <p class="text-xs text-gray-400">Nama, tagline, dan data dasar nagari</p>
                </div>
            </div>
            <div class="p-6 space-y-5">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="form-label">Nama Nagari <span class="text-red-400">*</span></label>
                        <input type="text" wire:model="name" class="form-input w-full"
                            placeholder="cth: Nagari Duo Koto">
                        @error('name')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="form-label">Tagline</label>
                        <input type="text" wire:model="tagline" class="form-input w-full"
                            placeholder="cth: Nagari Maju, Sejahtera, Berbudaya">
                        @error('tagline')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="form-label">Kode Nagari</label>
                        <input type="text" wire:model="village_code" class="form-input w-full"
                            placeholder="cth: 1306040001">
                        @error('village_code')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="form-label">Luas Wilayah (Ha)</label>
                        <input type="number" step="0.01" wire:model="area_ha" class="form-input w-full"
                            placeholder="cth: 150.50">
                        @error('area_ha')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="form-label">Tahun Berdiri</label>
                        <input type="number" wire:model="established_year" class="form-input w-full"
                            placeholder="cth: 1945">
                        @error('established_year')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- Lokasi --}}
        <div class="card overflow-hidden">
            <div class="p-5 bg-gray-50 border-b border-gray-100 flex items-center gap-3">
                <div class="h-9 w-9 rounded-lg bg-blue-100 flex items-center justify-center">
                    <span class="material-symbols-outlined text-blue-600">map</span>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900">Lokasi & Wilayah</h3>
                    <p class="text-xs text-gray-400">Alamat administratif dan peta nagari</p>
                </div>
            </div>
            <div class="p-6 space-y-5">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <div>
                        <label class="form-label">Provinsi</label>
                        <input type="text" wire:model="province" class="form-input w-full"
                            placeholder="cth: Sumatera Barat">
                    </div>
                    <div>
                        <label class="form-label">Kabupaten</label>
                        <input type="text" wire:model="regency" class="form-input w-full"
                            placeholder="cth: Kab. Agam">
                    </div>
                    <div>
                        <label class="form-label">Kecamatan</label>
                        <input type="text" wire:model="district" class="form-input w-full"
                            placeholder="cth: Kec. IV Koto">
                    </div>
                </div>
                <div>
                    <label class="form-label">Alamat Lengkap</label>
                    <textarea wire:model="address" class="form-input w-full" rows="2" placeholder="Alamat lengkap kantor nagari"></textarea>
                </div>
                <div>
                    <label class="form-label">Google Maps Embed URL</label>
                    <input type="url" wire:model="map_embed_url" class="form-input w-full"
                        placeholder="https://www.google.com/maps/embed?...">
                    <p class="text-xs text-gray-400 mt-1">Dapatkan URL embed dari Google Maps → Bagikan → Sematkan peta
                    </p>
                </div>
            </div>
        </div>

        {{-- Sejarah, Visi & Misi --}}
        <div class="card overflow-hidden">
            <div class="p-5 bg-gray-50 border-b border-gray-100 flex items-center gap-3">
                <div class="h-9 w-9 rounded-lg bg-amber-100 flex items-center justify-center">
                    <span class="material-symbols-outlined text-amber-600">history_edu</span>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900">Sejarah, Visi & Misi</h3>
                    <p class="text-xs text-gray-400">Konten narasi nagari — mendukung format rich text</p>
                </div>
            </div>
            <div class="p-6 space-y-5">
                <x-trix-editor name="history" :value="$history" label="Sejarah" rows="min-h-[250px]" />
                <x-trix-editor name="vision" :value="$vision" label="Visi" rows="min-h-[150px]" />
                <x-trix-editor name="mission" :value="$mission" label="Misi" rows="min-h-[150px]" />
            </div>
        </div>

        {{-- Media --}}
        <div class="card overflow-hidden">
            <div class="p-5 bg-gray-50 border-b border-gray-100 flex items-center gap-3">
                <div class="h-9 w-9 rounded-lg bg-purple-100 flex items-center justify-center">
                    <span class="material-symbols-outlined text-purple-600">image</span>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900">Media</h3>
                    <p class="text-xs text-gray-400">Logo dan foto/banner nagari</p>
                </div>
            </div>
            <div class="p-6 space-y-8">
                @php $profile = App\Models\VillageProfile::first(); @endphp

                {{-- Logo Nagari --}}
                <div>
                    <h4 class="text-sm font-semibold text-gray-700 mb-3 flex items-center gap-2">
                        <span class="material-symbols-outlined text-base text-purple-500">shield</span> Logo Nagari
                    </h4>
                    <x-admin-image-upload wireModel="newLogo" label="" :existingUrl="$profile?->logo ? Storage::url($profile->logo) : null" icon="shield" previewClass="h-28 w-28" hint="Logo resmi nagari. Format: PNG/JPG, maks 2MB. Disarankan rasio 1:1." />
                </div>

                <hr class="border-gray-100">

                {{-- Foto / Banner Nagari --}}
                <div>
                    <h4 class="text-sm font-semibold text-gray-700 mb-3 flex items-center gap-2">
                        <span class="material-symbols-outlined text-base text-purple-500">landscape</span> Foto Nagari / Banner
                    </h4>
                    <p class="text-xs text-gray-400 mb-3">Foto ini digunakan sebagai banner/header di halaman utama website. Gunakan foto landscape berkualitas tinggi (rekomendasi: 1200×400 px atau rasio 3:1).</p>

                    {{-- Wide Banner with Cropper --}}
                    <div x-data="bannerCropper()" class="space-y-3">
                        {{-- Preview --}}
                        <div class="relative w-full rounded-xl border-2 border-dashed border-gray-200 overflow-hidden bg-gray-50 aspect-[3/1] flex items-center justify-center">
                            <template x-if="croppedPreview">
                                <img :src="croppedPreview" class="h-full w-full object-cover" alt="Banner Preview">
                            </template>
                            <template x-if="!croppedPreview">
                                @if($profile?->photo)
                                    <img src="{{ Storage::url($profile->photo) }}" class="h-full w-full object-cover" alt="Current Banner">
                                @else
                                    <div class="text-center">
                                        <span class="material-symbols-outlined text-4xl text-gray-300">landscape</span>
                                        <p class="text-sm text-gray-400 mt-1">Belum ada foto banner</p>
                                        <p class="text-xs text-gray-300">Disarankan rasio 3:1 (cth: 1200×400 px)</p>
                                    </div>
                                @endif
                            </template>
                            <div wire:loading wire:target="newPhoto" class="absolute inset-0 bg-white/80 flex items-center justify-center">
                                <span class="material-symbols-outlined text-desa-500 animate-spin text-3xl">progress_activity</span>
                            </div>
                        </div>

                        {{-- Upload Button --}}
                        <div class="flex items-center gap-3">
                            <label class="relative cursor-pointer">
                                <div class="flex items-center gap-2 px-4 py-2.5 rounded-lg border border-gray-200 bg-white hover:bg-gray-50 hover:border-desa-300 transition-colors text-sm text-gray-600">
                                    <span class="material-symbols-outlined text-base text-gray-400">crop</span>
                                    <span>Pilih & Crop Foto Banner</span>
                                </div>
                                <input type="file" accept="image/*" class="sr-only" @change="openCropper($event)">
                            </label>
                            <span class="text-xs text-gray-400">Pilih foto lalu atur area yang ingin ditampilkan</span>
                        </div>
                        @error('newPhoto')<p class="text-sm text-red-500 mt-1">{{ $message }}</p>@enderror

                        {{-- Cropper Modal --}}
                        <div x-show="showCropModal" x-cloak class="fixed inset-0 z-[99] flex items-center justify-center p-4" style="background: rgba(0,0,0,0.6)">
                            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-3xl overflow-hidden" @click.outside="closeCropper()">
                                <div class="p-5 border-b border-gray-100 flex items-center justify-between">
                                    <div>
                                        <h3 class="font-semibold text-gray-900">Crop Foto Banner</h3>
                                        <p class="text-xs text-gray-400 mt-0.5">Geser dan atur area foto yang ingin ditampilkan sebagai banner</p>
                                    </div>
                                    <button @click="closeCropper()" class="h-8 w-8 rounded-lg flex items-center justify-center text-gray-400 hover:bg-gray-100"><span class="material-symbols-outlined">close</span></button>
                                </div>
                                <div class="p-5 bg-gray-900">
                                    <div style="max-height: 400px;">
                                        <img x-ref="cropImage" style="max-width: 100%; display: block;">
                                    </div>
                                </div>
                                <div class="p-5 border-t border-gray-100 flex items-center justify-end gap-3">
                                    <button type="button" @click="closeCropper()" class="btn-secondary">Batal</button>
                                    <button type="button" @click="applyCrop()" class="btn-primary">
                                        <span class="material-symbols-outlined text-base">check</span> Simpan Crop
                                    </button>
                                </div>
                            </div>
                        </div>

                        {{-- Hidden input for Livewire --}}
                        <input type="hidden" x-ref="croppedInput" wire:model="croppedBannerData">
                    </div>
                </div>
            </div>
        </div>

        {{-- Social Media --}}
        <div class="card overflow-hidden">
            <div class="p-5 bg-gray-50 border-b border-gray-100 flex items-center gap-3">
                <div class="h-9 w-9 rounded-lg bg-rose-100 flex items-center justify-center">
                    <span class="material-symbols-outlined text-rose-600">share</span>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900">Media Sosial</h3>
                    <p class="text-xs text-gray-400">Link media sosial yang ditampilkan di footer website</p>
                </div>
            </div>
            <div class="p-6 space-y-4">
                @if(count($socialMedia) > 0)
                    <div class="space-y-3">
                        @foreach($socialMedia as $index => $social)
                            <div class="flex items-center gap-3 p-4 bg-gray-50 rounded-xl border border-gray-100 group">
                                <div class="flex-shrink-0">
                                    @php $p = $platforms[$social['platform'] ?? 'facebook'] ?? $platforms['facebook']; @endphp
                                    <div class="h-10 w-10 rounded-lg flex items-center justify-center" style="background-color: {{ $p['color'] }}15">
                                        <span class="material-symbols-outlined text-lg" style="color: {{ $p['color'] }}">
                                            @switch($social['platform'] ?? 'facebook')
                                                @case('facebook') thumb_up @break
                                                @case('instagram') photo_camera @break
                                                @case('youtube') play_circle @break
                                                @case('tiktok') music_note @break
                                                @case('twitter') tag @break
                                                @case('whatsapp') chat @break
                                                @case('telegram') send @break
                                                @case('email') mail @break
                                                @default link
                                            @endswitch
                                        </span>
                                    </div>
                                </div>
                                <div class="flex-1 grid grid-cols-1 sm:grid-cols-3 gap-3">
                                    <div>
                                        <label class="form-label text-xs">Platform</label>
                                        <select wire:model.live="socialMedia.{{ $index }}.platform" class="form-input w-full text-sm">
                                            @foreach($platforms as $key => $platform)
                                                <option value="{{ $key }}">{{ $platform['label'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="sm:col-span-2">
                                        <label class="form-label text-xs">URL / Link</label>
                                        <input type="url" wire:model="socialMedia.{{ $index }}.url" class="form-input w-full text-sm"
                                            placeholder="{{ $platforms[$social['platform'] ?? 'facebook']['placeholder'] ?? 'https://...' }}">
                                    </div>
                                </div>
                                <button type="button" wire:click="removeSocialMedia({{ $index }})"
                                    class="flex-shrink-0 h-8 w-8 rounded-lg flex items-center justify-center text-gray-400 hover:bg-red-50 hover:text-red-500 transition-colors opacity-0 group-hover:opacity-100" title="Hapus">
                                    <span class="material-symbols-outlined text-sm">close</span>
                                </button>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-6">
                        <span class="material-symbols-outlined text-3xl text-gray-200">share</span>
                        <p class="text-sm text-gray-400 mt-2">Belum ada media sosial. Klik tombol di bawah untuk menambahkan.</p>
                    </div>
                @endif

                <button type="button" wire:click="addSocialMedia"
                    class="w-full py-2.5 rounded-xl border-2 border-dashed border-gray-200 hover:border-rose-300 hover:bg-rose-50/30 text-sm text-gray-500 hover:text-rose-600 transition-all flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined text-base">add</span> Tambah Media Sosial
                </button>
            </div>
        </div>

        {{-- Submit --}}
        <div class="flex justify-end">
            <button type="submit" class="btn-primary" wire:loading.attr="disabled" wire:target="save">
                <span wire:loading.remove wire:target="save" class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-base">save</span> Simpan Perubahan
                </span>
                <span wire:loading wire:target="save" class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-base animate-spin">progress_activity</span>
                    Menyimpan...
                </span>
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
function bannerCropper() {
    return {
        showCropModal: false,
        cropper: null,
        croppedPreview: null,
        openCropper(event) {
            const file = event.target.files[0];
            if (!file) return;
            // Validate file type & size
            const validTypes = ['image/jpeg', 'image/png', 'image/webp'];
            if (!validTypes.includes(file.type)) {
                Swal.fire({ icon: 'error', title: 'Format Tidak Didukung', text: 'Gunakan format JPG, PNG, atau WebP.', confirmButtonColor: '#16a34a' });
                event.target.value = '';
                return;
            }
            if (file.size > 2 * 1024 * 1024) {
                Swal.fire({ icon: 'error', title: 'Ukuran Terlalu Besar', text: 'Ukuran foto maksimal 2MB. Silakan kompres atau pilih foto lain.', confirmButtonColor: '#16a34a' });
                event.target.value = '';
                return;
            }
            const reader = new FileReader();
            reader.onload = (e) => {
                this.$refs.cropImage.src = e.target.result;
                this.showCropModal = true;
                this.$nextTick(() => {
                    if (this.cropper) this.cropper.destroy();
                    this.cropper = new Cropper(this.$refs.cropImage, {
                        aspectRatio: 3 / 1,
                        viewMode: 1,
                        autoCropArea: 1,
                        responsive: true,
                        guides: true,
                        background: true,
                    });
                });
            };
            reader.readAsDataURL(file);
            event.target.value = '';
        },
        closeCropper() {
            this.showCropModal = false;
            if (this.cropper) { this.cropper.destroy(); this.cropper = null; }
        },
        applyCrop() {
            if (!this.cropper) return;
            const canvas = this.cropper.getCroppedCanvas({ width: 1200, height: 400, imageSmoothingQuality: 'high' });
            const dataUrl = canvas.toDataURL('image/jpeg', 0.9);
            this.croppedPreview = dataUrl;
            this.$wire.set('croppedBannerData', dataUrl);
            this.closeCropper();
        }
    };
}
</script>
@endpush
