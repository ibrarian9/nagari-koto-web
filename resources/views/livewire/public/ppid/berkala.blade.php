<div>
    <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12">
        <h1 class="section-title">Informasi Berkala</h1>
        <p class="section-subtitle mb-8">Dokumen yang dipublikasikan secara berkala sesuai ketentuan</p>

        {{-- Filters --}}
        <div class="card p-4 mb-6">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-lg">search</span>
                    <input type="text" wire:model.live.debounce.300ms="search" class="form-input w-full pl-10" placeholder="Cari dokumen...">
                </div>
                <select wire:model.live="category" class="form-input w-full">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $k => $v)
                        <option value="{{ $k }}">{{ $v }}</option>
                    @endforeach
                </select>
                <select wire:model.live="year" class="form-input w-full">
                    <option value="">Semua Tahun</option>
                    @foreach($years as $y)
                        <option value="{{ $y }}">{{ $y }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- Document List --}}
        <div class="space-y-3">
            @forelse($items as $item)
                <div class="card p-5 flex flex-col sm:flex-row sm:items-center gap-4 hover:-translate-y-0.5 transition-all duration-200">
                    <div class="flex-shrink-0">
                        @php $ext = $item->file_extension; @endphp
                        <div class="h-12 w-12 rounded-xl flex items-center justify-center text-xs font-bold {{ $ext === 'PDF' ? 'bg-red-100 text-red-700' : ($ext === 'DOC' || $ext === 'DOCX' ? 'bg-blue-100 text-blue-700' : ($ext === 'XLS' || $ext === 'XLSX' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700')) }}">
                            {{ $ext }}
                        </div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="font-semibold text-gray-900 text-sm">{{ $item->title }}</h3>
                        <div class="flex flex-wrap items-center gap-x-3 gap-y-1 mt-1 text-xs text-gray-400">
                            <span class="badge bg-desa-50 text-desa-700">{{ $item->category_label }}</span>
                            <span>Tahun {{ $item->year }}</span>
                            <span>{{ $item->file_size_formatted }}</span>
                            <span class="flex items-center gap-0.5"><span class="material-symbols-outlined text-xs">download</span> {{ number_format($item->download_count) }}×</span>
                        </div>
                        @if($item->description)
                            <p class="text-xs text-gray-500 mt-1 line-clamp-2">{{ $item->description }}</p>
                        @endif
                    </div>
                    <button wire:click="download({{ $item->id }})" class="btn-primary btn-sm whitespace-nowrap flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-sm">download</span>
                        Download
                    </button>
                </div>
            @empty
                <div class="card p-12 text-center">
                    <span class="material-symbols-outlined text-4xl text-gray-300 mb-3">folder_off</span>
                    <p class="text-gray-400">Belum ada dokumen informasi berkala.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-6">{{ $items->links() }}</div>
    </section>
</div>
