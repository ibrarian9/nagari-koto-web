<div>
    <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12">
        <h1 data-aos="fade-up" class="section-title text-center">Kontak & Telepon Penting</h1>
        <p data-aos="fade-up" data-aos-delay="100" class="section-subtitle text-center mb-10">Hubungi kami kapan saja Anda membutuhkan</p>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            @foreach($categories as $key => $label)
                @if(isset($contacts[$key]) && $contacts[$key]->count())
                    <div data-aos="fade-up" data-aos-delay="{{ $loop->index * 150 }}" class="card p-6">
                        <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2 mb-4">
                            <span class="material-symbols-outlined text-desa-500">{{ match($key) { 'emergency' => 'emergency', 'government' => 'account_balance', 'health' => 'local_hospital', default => 'group' } }}</span>
                            {{ $label }}
                        </h3>
                        <div class="space-y-3">
                            @foreach($contacts[$key] as $contact)
                                <div class="flex items-center justify-between p-3 rounded-lg bg-gray-50 hover:bg-desa-50 transition-colors">
                                    <span class="text-sm font-medium text-gray-700">{{ $contact->label }}</span>
                                    <a href="tel:{{ $contact->phone }}" class="inline-flex items-center gap-1 text-sm font-semibold text-desa-600 hover:text-desa-800">
                                        <span class="material-symbols-outlined text-base">call</span>{{ $contact->phone }}
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
        @if($village?->address || $village?->map_embed_url)
            <div data-aos="fade-up" class="mt-10 card p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2"><span class="material-symbols-outlined text-desa-500">location_on</span> Alamat Desa</h3>
                @if($village?->address)<p class="text-gray-600 mb-4">{{ $village->address }}</p>@endif
                @if($village?->map_embed_url)
                    <div class="aspect-video rounded-xl overflow-hidden border border-gray-200">
                        <iframe src="{{ $village->map_embed_url }}" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                    </div>
                @endif
            </div>
        @endif
    </section>
</div>
