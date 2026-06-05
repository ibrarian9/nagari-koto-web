<div>
    <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12">
        {{-- Header --}}
        <div class="mb-10 text-center md:text-left md:flex md:items-center md:justify-between border-b border-gray-150 pb-8">
            <div>
                <div class="inline-flex items-center gap-2 rounded-full bg-amber-50 border border-amber-100 px-3 py-1 text-xs text-amber-700 font-semibold mb-3">
                    <span class="material-symbols-outlined text-sm">assignment</span>
                    Tugas & Fungsi
                </div>
                <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">{{ $item->title }}</h1>
                <p class="text-sm text-gray-500 mt-1">Uraian tugas dan fungsi PPID dalam pelayanan informasi publik</p>
            </div>
            <div class="mt-4 md:mt-0">
                <a href="{{ route('ppid.home') }}" wire:navigate class="inline-flex items-center gap-1.5 px-4 py-2 border border-gray-200 hover:border-desa-300 hover:bg-desa-50 text-gray-700 hover:text-desa-700 rounded-xl text-xs font-semibold transition-all">
                    <span class="material-symbols-outlined text-sm">arrow_back</span> Kembali ke PPID Hub
                </a>
            </div>
        </div>

        <div class="max-w-4xl space-y-6">
            {{-- Content --}}
            @if($item->content)
                <div class="card p-8">
                    <div class="prose prose-gray max-w-none whitespace-pre-line text-gray-700 leading-relaxed">{{ $item->content }}</div>
                </div>
            @else
                <div class="card p-12 text-center">
                    <span class="material-symbols-outlined text-4xl text-gray-200 mb-3">edit_note</span>
                    <p class="text-gray-400">Konten belum diisi oleh admin.</p>
                </div>
            @endif

            {{-- PDF Attachment --}}
            @if($item->attachment)
                <div class="card p-6 bg-gradient-to-r from-blue-50 to-indigo-50 border-blue-200/60">
                    <div class="flex items-center gap-4">
                        <div class="flex-shrink-0 h-14 w-14 rounded-xl bg-gradient-to-br from-red-500 to-red-600 flex items-center justify-center shadow-md">
                            <span class="material-symbols-outlined text-white text-2xl">picture_as_pdf</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="font-bold text-gray-900">Lampiran Dokumen</h3>
                            <p class="text-sm text-gray-500">Dokumen tugas dan fungsi PPID dalam format PDF</p>
                        </div>
                        <a href="{{ Storage::url($item->attachment) }}" target="_blank"
                           class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white rounded-xl text-sm font-semibold shadow-md shadow-blue-200 transition-all">
                            <span class="material-symbols-outlined text-base">download</span> Unduh PDF
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </section>
</div>
