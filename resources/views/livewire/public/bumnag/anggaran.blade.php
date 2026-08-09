<div>
    <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12">
        {{-- Page Header --}}
        <div class="text-center mb-16 relative">
            <div class="absolute -top-6 left-1/2 -translate-x-1/2 w-40 h-40 bg-blue-500/5 rounded-full filter blur-2xl -z-10"></div>

            <div
                class="inline-flex items-center justify-center h-16 w-16 rounded-2xl bg-gradient-to-br from-blue-500 to-blue-700 mb-4 shadow-lg shadow-blue-500/20">
                <span class="material-symbols-outlined text-white text-3xl">account_balance</span>
            </div>

            <h1 class="section-title">Anggaran BUMNag</h1>
            <p class="section-subtitle max-w-2xl mx-auto">
                Transparansi pengelolaan keuangan {{ $profile->name }}.
            </p>

            @include('livewire.public.bumnag._subnav')
        </div>

        {{-- Year Selector --}}
        @if ($years->count())
            <div class="flex justify-center mb-8">
                <div class="inline-flex items-center gap-3 bg-white rounded-xl shadow-sm border border-gray-200 px-4 py-2">
                    <span class="material-symbols-outlined text-blue-500">calendar_month</span>
                    <select wire:model.live="selectedYear"
                        class="border-0 bg-transparent font-semibold text-gray-900 focus:ring-0 cursor-pointer pr-8">
                        @foreach ($years as $y)
                            <option value="{{ $y }}">Tahun {{ $y }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        @endif

        @if ($stat)
            {{-- Summary Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-10">
                <div class="stat-card">
                    <span class="material-symbols-outlined text-3xl text-green-500 mb-2">trending_up</span>
                    <span class="text-xl font-extrabold text-gray-900">Rp {{ number_format($stat->total_income, 0, ',', '.') }}</span>
                    <span class="text-xs text-gray-500 mt-1">Total Pendapatan</span>
                </div>
                <div class="stat-card">
                    <span class="material-symbols-outlined text-3xl text-red-500 mb-2">trending_down</span>
                    <span class="text-xl font-extrabold text-gray-900">Rp {{ number_format($stat->total_expenditure, 0, ',', '.') }}</span>
                    <span class="text-xs text-gray-500 mt-1">Total Belanja</span>
                </div>
                <div class="stat-card">
                    <span class="material-symbols-outlined text-3xl text-amber-500 mb-2">speed</span>
                    <span class="text-xl font-extrabold text-gray-900">{{ $stat->realization_pct }}%</span>
                    <span class="text-xs text-gray-500 mt-1">Realisasi</span>
                    <div class="w-full bg-gray-200 rounded-full h-2.5 mt-3">
                        <div class="h-2.5 rounded-full transition-all duration-500 {{ $stat->realization_pct >= 80 ? 'bg-blue-500' : ($stat->realization_pct >= 50 ? 'bg-amber-500' : 'bg-red-500') }}"
                            style="width: {{ min($stat->realization_pct, 100) }}%"></div>
                    </div>
                </div>
            </div>

            {{-- Charts --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10"
                wire:key="bumnag-charts-{{ $stat->id }}-{{ $selectedYear }}"
                x-data="{
                    initCharts() {
                        this.$nextTick(() => {
                            const incExpCanvas = document.getElementById('bumnagIncExpChart');
                            const apbdesCanvas = document.getElementById('bumnagApbdesChart');

                            if (incExpCanvas && typeof Chart !== 'undefined') {
                                const oldIncExp = Chart.getChart(incExpCanvas);
                                if (oldIncExp) oldIncExp.destroy();

                                new Chart(incExpCanvas, {
                                    type: 'doughnut',
                                    data: {
                                        labels: ['Pendapatan', 'Belanja'],
                                        datasets: [{
                                            data: [{{ $stat->total_income }}, {{ $stat->total_expenditure }}],
                                            backgroundColor: ['#22c55e', '#ef4444'],
                                            borderWidth: 0,
                                            hoverOffset: 8
                                        }]
                                    },
                                    options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'bottom', labels: { padding: 20, usePointStyle: true } } } }
                                });
                            }

                            const apbdes = @js(is_string($stat->apbdes_data) ? json_decode($stat->apbdes_data, true) : ($stat->apbdes_data ?? []));
                            if (apbdesCanvas && typeof Chart !== 'undefined' && apbdes && Object.keys(apbdes).length) {
                                const oldApbdes = Chart.getChart(apbdesCanvas);
                                if (oldApbdes) oldApbdes.destroy();

                                const colors = ['#3b82f6', '#22c55e', '#f59e0b', '#8b5cf6', '#ec4899', '#06b6d4', '#f97316'];
                                new Chart(apbdesCanvas, {
                                    type: 'bar',
                                    data: {
                                        labels: Object.keys(apbdes),
                                        datasets: [{ label: 'Jumlah (Rp)', data: Object.values(apbdes), backgroundColor: colors.slice(0, Object.keys(apbdes).length), borderRadius: 6, borderSkipped: false }]
                                    },
                                    options: {
                                        responsive: true, maintainAspectRatio: false,
                                        plugins: { legend: { display: false }, tooltip: { callbacks: { label: (ctx) => 'Rp ' + ctx.raw.toLocaleString('id-ID') } } },
                                        scales: { y: { beginAtZero: true, ticks: { callback: (v) => 'Rp ' + (v / 1000000).toFixed(0) + ' Jt' } } }
                                    }
                                });
                            }
                        });
                    }
                }"
                x-init="initCharts()">
                <div class="card p-6">
                    <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <span class="material-symbols-outlined text-blue-500">donut_large</span>
                        Pendapatan vs Belanja
                    </h3>
                    <div class="relative w-full h-72"><canvas id="bumnagIncExpChart"></canvas></div>
                </div>
                <div class="card p-6">
                    <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <span class="material-symbols-outlined text-blue-500">bar_chart</span>
                        Rincian Komponen Anggaran
                    </h3>
                    <div class="relative w-full h-72"><canvas id="bumnagApbdesChart"></canvas></div>
                </div>
            </div>


            @php
                $apbdes = is_string($stat->apbdes_data) ? json_decode($stat->apbdes_data, true) : $stat->apbdes_data;
            @endphp

            {{-- Detail Table --}}
            @if (is_array($apbdes) && count($apbdes) > 0)
                <div class="card overflow-hidden mb-8">
                    <div class="p-5 border-b border-gray-100">
                        <h3 class="font-bold text-gray-900 flex items-center gap-2">
                            <span class="material-symbols-outlined text-blue-500">table_chart</span>
                            Detail Komponen Anggaran {{ $stat->year }}
                        </h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="data-table">
                            <thead><tr><th>No</th><th>Komponen</th><th class="text-right">Jumlah (Rp)</th><th class="text-right">Persentase</th></tr></thead>
                            <tbody>
                                @php $totalApbdes = is_array($apbdes) ? array_sum(array_map(fn($v) => is_numeric($v) ? (float)$v : 0, $apbdes)) : 0; @endphp

                                @foreach ($apbdes as $label => $amount)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td class="font-medium">{{ $label }}</td>
                                        <td class="text-right font-mono">Rp {{ number_format($amount, 0, ',', '.') }}</td>
                                        <td class="text-right">
                                            <div class="flex items-center justify-end gap-2">
                                                <div class="w-20 bg-gray-200 rounded-full h-1.5">
                                                    <div class="bg-blue-500 h-1.5 rounded-full" style="width: {{ $totalApbdes > 0 ? round(($amount / $totalApbdes) * 100, 1) : 0 }}%"></div>
                                                </div>
                                                <span class="text-xs text-gray-500 w-12 text-right">{{ $totalApbdes > 0 ? number_format(($amount / $totalApbdes) * 100, 1) : 0 }}%</span>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="bg-gray-50 font-bold">
                                    <td colspan="2">Total</td>
                                    <td class="text-right font-mono">Rp {{ number_format($totalApbdes, 0, ',', '.') }}</td>
                                    <td class="text-right text-xs text-gray-500">100%</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            @endif

            {{-- Keterangan / Narasi --}}
            @if ($stat->keterangan)
                <div class="card p-6 sm:p-8 bg-gradient-to-br from-blue-50/30 to-white border border-blue-100/60">
                    <div class="flex items-start gap-4">
                        <div class="h-10 w-10 rounded-xl bg-blue-100 flex items-center justify-center text-blue-600 flex-shrink-0">
                            <span class="material-symbols-outlined text-lg">edit_note</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="font-extrabold text-gray-900 text-base mb-2">Keterangan Penggunaan Anggaran</h3>
                            <div class="prose prose-sm max-w-none text-gray-600 leading-relaxed">
                                {!! nl2br(e($stat->keterangan)) !!}
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @else
            <div class="card p-12 text-center">
                <span class="material-symbols-outlined text-5xl text-gray-300 mb-3">account_balance_wallet</span>
                <p class="text-gray-400">Belum ada data anggaran BUMNag untuk tahun ini.</p>
            </div>
        @endif
    </section>
</div>
