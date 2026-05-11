<div>
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div><h2 class="text-xl font-bold text-gray-900">Data Infografis Penduduk</h2><p class="text-sm text-gray-500 mt-0.5">Statistik dan demografi kependudukan</p></div>
    </div>
    <x-page-guide title="Panduan Infografis Penduduk" description="Kelola data kependudukan desa per tahun. Masukkan total penduduk, jumlah KK, dan breakdown berdasarkan kelompok usia, pendidikan, dan pekerjaan. Gunakan tombol 'Tambah Baris' untuk menambah kategori baru. Data ditampilkan sebagai infografis interaktif di website publik." />
    <div class="flex gap-4 mb-6">
        <select wire:model.live="year" wire:change="loadYear($event.target.value)" class="form-input w-40"><option value="{{ date('Y') }}">{{ date('Y') }}</option>@foreach($years as $y)<option value="{{ $y }}">{{ $y }}</option>@endforeach</select>
        <span class="text-sm text-gray-500 self-center">{{ $editingId ? 'Edit data tahun '.$year : 'Data baru untuk tahun '.$year }}</span>
    </div>
    <form wire:submit="save" class="space-y-6">
        <div class="card p-6"><h3 class="font-semibold text-gray-800 border-b pb-2 mb-4">Data Umum</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div><label class="form-label">Total Penduduk</label><input type="number" wire:model="total_population" class="form-input w-full"></div>
                <div><label class="form-label">Laki-laki</label><input type="number" wire:model="male" class="form-input w-full"></div>
                <div><label class="form-label">Perempuan</label><input type="number" wire:model="female" class="form-input w-full"></div>
                <div><label class="form-label">KK</label><input type="number" wire:model="total_families" class="form-input w-full"></div>
            </div>
        </div>
        @foreach([['key'=>'age_groups','title'=>'Kelompok Usia'],['key'=>'education','title'=>'Tingkat Pendidikan'],['key'=>'occupation','title'=>'Pekerjaan']] as $section)
        <div class="card p-6"><h3 class="font-semibold text-gray-800 border-b pb-2 mb-4">{{ $section['title'] }}</h3>
            @foreach($this->{$section['key']} as $i => $row)
            <div class="flex gap-3 mb-2"><input type="text" wire:model="{{ $section['key'] }}.{{ $i }}.label" class="form-input flex-1" placeholder="Label"><input type="number" wire:model="{{ $section['key'] }}.{{ $i }}.value" class="form-input w-32" placeholder="Jumlah"><button type="button" wire:click="removeRow('{{ $section['key'] }}', {{ $i }})" class="text-red-500 hover:text-red-700"><span class="material-symbols-outlined">remove_circle</span></button></div>
            @endforeach
            <button type="button" wire:click="addRow('{{ $section['key'] }}')" class="text-sm text-desa-600 hover:text-desa-800 flex items-center gap-1 mt-2"><span class="material-symbols-outlined text-base">add</span> Tambah Baris</button>
        </div>
        @endforeach
        <div class="flex justify-end"><button type="submit" class="btn-primary">Simpan Data {{ $year }}</button></div>
    </form>
</div>
