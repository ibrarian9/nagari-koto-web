<div>
    <section class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 py-12">
        <h1 class="section-title">Status Permohonan Surat</h1>
        <p class="section-subtitle mb-8">Riwayat permohonan surat Anda</p>
        @if($requests->count())
            <div class="space-y-4">
                @foreach($requests as $req)
                    <div class="card p-5">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                            <div>
                                <h3 class="font-semibold text-gray-900">{{ $req->letter_type_label }}</h3>
                                <p class="text-sm text-gray-500">Diajukan: {{ $req->requested_at?->translatedFormat('d M Y H:i') ?? $req->created_at->translatedFormat('d M Y H:i') }}</p>
                            </div>
                            <span class="badge {{ $req->status_color }}">{{ $req->status_label }}</span>
                        </div>
                        @if($req->notes)<p class="mt-3 text-sm text-gray-600 bg-gray-50 rounded-lg p-3"><strong>Catatan:</strong> {{ $req->notes }}</p>@endif
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12"><span class="material-symbols-outlined text-5xl text-gray-300 mb-4">mail</span><p class="text-gray-400">Belum ada permohonan surat.</p>
                <a href="{{ route('surat.ajukan') }}" wire:navigate class="btn-primary mt-4">Ajukan Surat Baru</a></div>
        @endif
    </section>
</div>
