<div>
    <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12">
        <h1 class="section-title">Informasi Serta Merta</h1>
        <p class="section-subtitle mb-8">Pengumuman darurat yang harus diketahui masyarakat segera</p>

        {{-- Urgency Filter --}}
        <div class="flex flex-wrap gap-2 mb-6">
            <button wire:click="$set('urgency', '')" class="badge px-3 py-1.5 cursor-pointer {{ !$urgency ? 'bg-desa-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }} transition-colors">Semua</button>
            @foreach($urgencyLevels as $key => $level)
                <button wire:click="$set('urgency', '{{ $key }}')" class="badge px-3 py-1.5 cursor-pointer {{ $urgency === $key ? $level['color'] . ' ring-2 ring-offset-1' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }} transition-colors">{{ $level['label'] }}</button>
            @endforeach
        </div>

        {{-- Items --}}
        <div class="space-y-4">
            @forelse($items as $item)
                <div class="card p-5 border-l-4 {{ $item->urgency === 'kritis' ? 'border-l-red-500' : ($item->urgency === 'tinggi' ? 'border-l-orange-500' : ($item->urgency === 'sedang' ? 'border-l-amber-500' : 'border-l-blue-500')) }}">
                    <div class="flex items-start gap-3">
                        <span class="material-symbols-outlined mt-0.5 {{ $item->urgency === 'kritis' ? 'text-red-500' : ($item->urgency === 'tinggi' ? 'text-orange-500' : ($item->urgency === 'sedang' ? 'text-amber-500' : 'text-blue-500')) }}">{{ $item->urgency_icon }}</span>
                        <div class="flex-1 min-w-0">
                            <div class="flex flex-wrap items-center gap-2 mb-2">
                                <span class="badge {{ $item->urgency_color }} text-xs">{{ $item->urgency_label }}</span>
                                <span class="text-xs text-gray-400">{{ $item->published_at?->isoFormat('D MMMM Y, HH:mm') }} WIB</span>
                            </div>
                            <h3 class="font-bold text-gray-900 mb-2">{{ $item->title }}</h3>
                            <div class="prose prose-sm max-w-none text-gray-600">{!! $item->content !!}</div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="card p-12 text-center">
                    <span class="material-symbols-outlined text-4xl text-green-300 mb-3">verified_user</span>
                    <p class="text-gray-400 font-medium">Tidak ada pengumuman darurat saat ini.</p>
                    <p class="text-gray-400 text-sm mt-1">Situasi aman, tidak ada informasi serta merta yang perlu disampaikan.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-6">{{ $items->links() }}</div>
    </section>
</div>
