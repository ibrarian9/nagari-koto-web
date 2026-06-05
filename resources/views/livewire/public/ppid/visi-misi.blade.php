<div>
    <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12">
        {{-- Header --}}
        <div class="mb-10 text-center md:text-left md:flex md:items-center md:justify-between border-b border-gray-150 pb-8">
            <div>
                <div class="inline-flex items-center gap-2 rounded-full bg-blue-50 border border-blue-100 px-3 py-1 text-xs text-blue-700 font-semibold mb-3">
                    <span class="material-symbols-outlined text-sm">visibility</span>
                    Visi & Misi
                </div>
                <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">{{ $item->title }}</h1>
                <p class="text-sm text-gray-500 mt-1">Visi dan misi PPID dalam pengelolaan informasi publik</p>
            </div>
            <div class="mt-4 md:mt-0">
                <a href="{{ route('ppid.home') }}" wire:navigate class="inline-flex items-center gap-1.5 px-4 py-2 border border-gray-200 hover:border-desa-300 hover:bg-desa-50 text-gray-700 hover:text-desa-700 rounded-xl text-xs font-semibold transition-all">
                    <span class="material-symbols-outlined text-sm">arrow_back</span> Kembali ke PPID Hub
                </a>
            </div>
        </div>

        {{-- Content --}}
        <div class="max-w-4xl">
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
        </div>
    </section>
</div>
