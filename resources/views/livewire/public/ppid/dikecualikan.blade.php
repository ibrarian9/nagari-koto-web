<div>
    <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12">
        {{-- Header Section --}}
        <div class="mb-10 text-center md:text-left md:flex md:items-center md:justify-between border-b border-gray-150 pb-8">
            <div>
                <div class="inline-flex items-center gap-2 rounded-full bg-red-50 border border-red-100 px-3 py-1 text-xs text-red-700 font-semibold mb-3">
                    <span class="material-symbols-outlined text-sm">lock</span>
                    Informasi Terbatas
                </div>
                <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Informasi Dikecualikan</h1>
                <p class="text-sm text-gray-500 mt-1">Informasi yang tidak dapat diakses publik berdasarkan ketentuan Undang-Undang</p>
            </div>
            
            <div class="mt-4 md:mt-0">
                <a href="{{ route('ppid.home') }}" wire:navigate class="inline-flex items-center gap-1.5 px-4 py-2 border border-gray-200 hover:border-desa-300 hover:bg-desa-50 text-gray-700 hover:text-desa-700 rounded-xl text-xs font-semibold transition-all">
                    <span class="material-symbols-outlined text-sm">arrow_back</span>
                    Kembali ke PPID Hub
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            {{-- Main Content Column --}}
            <div class="lg:col-span-8 space-y-6">
                {{-- Important Notice Card --}}
                <div class="bg-amber-50/50 border border-amber-200/60 rounded-2xl p-5 flex items-start gap-4 shadow-sm">
                    <div class="h-10 w-10 rounded-xl bg-amber-100 flex items-center justify-center flex-shrink-0 text-amber-700">
                        <span class="material-symbols-outlined text-xl">gavel</span>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-amber-900">Uji Konsekuensi Informasi</h3>
                        <p class="text-xs text-amber-800/80 mt-1 leading-relaxed">
                            Penetapan informasi dikecualikan telah melalui pengujian konsekuensi dengan mempertimbangkan bahwa dibukanya suatu informasi dapat menimbulkan dampak kerugian yang lebih besar bagi kepentingan publik atau keamanan nasional.
                        </p>
                    </div>
                </div>

                {{-- Prose Document Card --}}
                <div class="card p-6 sm:p-8 bg-white border border-gray-150/60">
                    <div class="prose prose-sm sm:prose max-w-none prose-headings:text-gray-950 prose-headings:font-extrabold prose-a:text-desa-600 hover:prose-a:text-desa-700 prose-strong:text-gray-900 prose-ol:list-decimal prose-ul:list-disc">
                        {!! $record->content !!}
                    </div>
                    
                    <div class="mt-8 pt-5 border-t border-gray-100 flex items-center justify-between text-xs text-gray-400">
                        <span class="flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-sm">update</span>
                            Terakhir Diperbarui: {{ $record->updated_at->isoFormat('D MMMM Y') }}
                        </span>
                        <span class="flex items-center gap-1">
                            <span class="material-symbols-outlined text-sm">shield</span>
                            Sifat: Rahasia
                        </span>
                    </div>
                </div>
            </div>

            {{-- Sidebar Column --}}
            <div class="lg:col-span-4 space-y-6">
                {{-- Law Framework Info --}}
                <div class="card p-5 bg-gray-50/50 border border-gray-150/60">
                    <h3 class="font-bold text-gray-900 flex items-center gap-2 text-sm">
                        <span class="material-symbols-outlined text-desa-600 text-lg">verified_user</span>
                        Ketentuan Regulasi
                    </h3>
                    <p class="text-xs text-gray-500 mt-2 leading-relaxed">
                        Pemerintah Desa berkomitmen terhadap keterbukaan informasi publik, namun beberapa data harus dijaga kerahasiaannya untuk mematuhi:
                    </p>
                    
                    <div class="mt-4 space-y-3">
                        <div class="flex items-start gap-2.5">
                            <span class="h-1.5 w-1.5 rounded-full bg-desa-600 mt-1.5 flex-shrink-0"></span>
                            <p class="text-xs text-gray-700 font-medium">UU No. 14 Tahun 2008 Pasal 17 (KIP)</p>
                        </div>
                        <div class="flex items-start gap-2.5">
                            <span class="h-1.5 w-1.5 rounded-full bg-desa-600 mt-1.5 flex-shrink-0"></span>
                            <p class="text-xs text-gray-700 font-medium">PP No. 61 Tahun 2010 tentang Pelaksanaan UU KIP</p>
                        </div>
                        <div class="flex items-start gap-2.5">
                            <span class="h-1.5 w-1.5 rounded-full bg-desa-600 mt-1.5 flex-shrink-0"></span>
                            <p class="text-xs text-gray-700 font-medium">Peraturan Komisi Informasi No. 1 Tahun 2010</p>
                        </div>
                    </div>
                </div>

                {{-- Need Information Help Banner --}}
                <div class="card p-6 bg-gradient-to-br from-desa-600 to-desa-800 text-white relative overflow-hidden border-none shadow-md">
                    {{-- Graphic Glow --}}
                    <div class="absolute -bottom-10 -right-10 w-24 h-24 bg-white/10 rounded-full filter blur-xl"></div>
                    
                    <h3 class="font-extrabold text-sm mb-2">Butuh Informasi Lain?</h3>
                    <p class="text-xs text-desa-100 leading-relaxed mb-5">
                        Anda dapat mengajukan permohonan tertulis kepada Pejabat Pengelola Informasi dan Dokumentasi (PPID) Nagari jika membutuhkan data publik lainnya.
                    </p>
                    
                    <a href="{{ route('ppid.permohonan') }}" wire:navigate class="w-full inline-flex items-center justify-center gap-1.5 px-4 py-2.5 bg-amber-500 hover:bg-amber-600 text-white text-xs font-bold rounded-xl transition-all shadow-md">
                        <span class="material-symbols-outlined text-sm font-bold">send</span>
                        Ajukan Permohonan Informasi
                    </a>
                </div>
            </div>
        </div>
    </section>
</div>

