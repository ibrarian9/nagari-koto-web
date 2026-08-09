<div>
    <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12">
        {{-- Hero --}}
        <div class="text-center mb-10">
            <div class="inline-flex items-center justify-center h-16 w-16 rounded-2xl bg-gradient-to-br from-desa-500 to-desa-700 mb-4 shadow-lg shadow-desa-500/20">
                <span class="material-symbols-outlined text-white text-3xl">bar_chart</span>
            </div>
            <h1 class="section-title">Infografis Penduduk</h1>
            <p class="section-subtitle">Data kependudukan tahun {{ $stats?->year ?? '-' }}</p>
        </div>

        @if ($stats)
            {{-- Summary Cards --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-10">
                @foreach ([
                    ['icon' => 'groups', 'value' => number_format($stats->total_population), 'label' => 'Total Penduduk', 'color' => 'desa'],
                    ['icon' => 'male', 'value' => number_format($stats->male), 'label' => 'Laki-laki', 'color' => 'blue'],
                    ['icon' => 'female', 'value' => number_format($stats->female), 'label' => 'Perempuan', 'color' => 'pink'],
                    ['icon' => 'family_restroom', 'value' => number_format($stats->total_families), 'label' => 'Kepala Keluarga', 'color' => 'amber'],
                ] as $s)
                    <div class="stat-card">
                        <span class="material-symbols-outlined text-3xl text-{{ $s['color'] }}-500 mb-2">{{ $s['icon'] }}</span>
                        <span class="text-2xl font-extrabold text-gray-900">{{ $s['value'] }}</span>
                        <span class="text-xs text-gray-500 mt-1">{{ $s['label'] }}</span>
                    </div>
                @endforeach
            </div>

            {{-- Penjelasan --}}
            <div class="card p-6 mb-8">
                <div class="flex items-start gap-4">
                    <div class="flex-shrink-0 h-10 w-10 rounded-lg bg-desa-50 flex items-center justify-center">
                        <span class="material-symbols-outlined text-desa-600">info</span>
                    </div>
                    <div class="text-sm text-gray-600 leading-relaxed">
                        <h3 class="font-bold text-gray-900 mb-1">Tentang Data Ini</h3>
                        <p>Data kependudukan dikumpulkan dari <strong>Administrasi Kependudukan Nagari</strong> tahun {{ $stats->year }}. Total penduduk sebanyak <strong>{{ number_format($stats->total_population) }} jiwa</strong> terdiri dari {{ number_format($stats->male) }} laki-laki dan {{ number_format($stats->female) }} perempuan dengan rasio jenis kelamin <strong>{{ $stats->female > 0 ? number_format($stats->male / $stats->female * 100, 1) : 0 }}%</strong>.</p>
                    </div>
                </div>
            </div>

            @php
                $rawAge = is_string($stats->age_group_data) ? json_decode($stats->age_group_data, true) : $stats->age_group_data;
                $rawEdu = is_string($stats->education_data) ? json_decode($stats->education_data, true) : $stats->education_data;
                $rawOcc = is_string($stats->occupation_data) ? json_decode($stats->occupation_data, true) : $stats->occupation_data;

                $ageData = is_array($rawAge) ? array_map(fn($v) => is_numeric($v) ? (float) $v : 0, $rawAge) : [];
                $eduData = is_array($rawEdu) ? array_map(fn($v) => is_numeric($v) ? (float) $v : 0, $rawEdu) : [];
                $occData = is_array($rawOcc) ? array_map(fn($v) => is_numeric($v) ? (float) $v : 0, $rawOcc) : [];
            @endphp


            {{-- Charts --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8" x-data x-init="$nextTick(() => {
                new Chart(document.getElementById('genderChart'), {
                    type: 'doughnut',
                    data: {
                        labels: ['Laki-laki', 'Perempuan'],
                        datasets: [{
                            data: [{{ $stats->male }}, {{ $stats->female }}],
                            backgroundColor: ['#3b82f6', '#ec4899'],
                            borderWidth: 0,
                            hoverOffset: 8
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { position: 'bottom', labels: { padding: 16, usePointStyle: true } } }
                    }
                });

                const ageData = @js($ageData ?? []);
                if (Object.keys(ageData).length) {
                    new Chart(document.getElementById('ageChart'), {
                        type: 'bar',
                        data: {
                            labels: Object.keys(ageData),
                            datasets: [{
                                label: 'Jumlah',
                                data: Object.values(ageData),
                                backgroundColor: '#2D6A4F',
                                borderRadius: 4,
                                borderSkipped: false
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: { legend: { display: false } },
                            scales: { y: { beginAtZero: true } }
                        }
                    });
                }

                const eduData = @js($eduData ?? []);
                if (Object.keys(eduData).length) {
                    const eduColors = ['#ef4444', '#f97316', '#f59e0b', '#22c55e', '#3b82f6', '#8b5cf6'];
                    new Chart(document.getElementById('educationChart'), {
                        type: 'doughnut',
                        data: {
                            labels: Object.keys(eduData),
                            datasets: [{
                                data: Object.values(eduData),
                                backgroundColor: eduColors.slice(0, Object.keys(eduData).length),
                                borderWidth: 0,
                                hoverOffset: 8
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: { legend: { position: 'bottom', labels: { padding: 12, usePointStyle: true } } }
                        }
                    });
                }

                const occData = @js($occData ?? []);
                if (Object.keys(occData).length) {
                    new Chart(document.getElementById('occupationChart'), {
                        type: 'bar',
                        data: {
                            labels: Object.keys(occData),
                            datasets: [{
                                label: 'Jumlah',
                                data: Object.values(occData),
                                backgroundColor: '#6366f1',
                                borderRadius: 4,
                                borderSkipped: false
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            indexAxis: 'y',
                            plugins: { legend: { display: false } },
                            scales: { x: { beginAtZero: true } }
                        }
                    });
                }
            })">
                <div class="card p-6">
                    <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <span class="material-symbols-outlined text-blue-500">wc</span> Komposisi Gender
                    </h3>
                    <div class="relative w-full h-64"><canvas id="genderChart"></canvas></div>
                </div>
                <div class="card p-6">
                    <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <span class="material-symbols-outlined text-desa-500">calendar_month</span> Kelompok Usia
                    </h3>
                    <div class="relative w-full h-64"><canvas id="ageChart"></canvas></div>
                </div>
                <div class="card p-6">
                    <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <span class="material-symbols-outlined text-amber-500">school</span> Tingkat Pendidikan
                    </h3>
                    <div class="relative w-full h-64"><canvas id="educationChart"></canvas></div>
                </div>
                <div class="card p-6">
                    <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <span class="material-symbols-outlined text-indigo-500">work</span> Pekerjaan
                    </h3>
                    <div class="relative w-full h-64"><canvas id="occupationChart"></canvas></div>
                </div>
            </div>

            {{-- Data Tables --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Usia Table --}}
                @if(is_array($ageData) && count($ageData) > 0)
                    <div class="card overflow-hidden">
                        <div class="p-5 border-b border-gray-100">
                            <h3 class="font-bold text-gray-900 flex items-center gap-2 text-sm">
                                <span class="material-symbols-outlined text-desa-500 text-lg">calendar_month</span> Detail Kelompok Usia
                            </h3>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="data-table">
                                <thead><tr><th>Kelompok Usia</th><th class="text-right">Jumlah</th><th class="text-right">Persentase</th></tr></thead>
                                <tbody>
                                    @php $totalAge = array_sum($ageData); @endphp
                                    @foreach($ageData as $label => $count)
                                        <tr>
                                            <td class="font-medium">{{ $label }} tahun</td>
                                            <td class="text-right font-mono">{{ number_format($count) }}</td>
                                            <td class="text-right">
                                                <div class="flex items-center justify-end gap-2">
                                                    <div class="w-16 bg-gray-200 rounded-full h-1.5">
                                                        <div class="bg-desa-500 h-1.5 rounded-full" style="width: {{ $totalAge > 0 ? round($count / $totalAge * 100, 1) : 0 }}%"></div>
                                                    </div>
                                                    <span class="text-xs text-gray-500 w-10 text-right">{{ $totalAge > 0 ? number_format($count / $totalAge * 100, 1) : 0 }}%</span>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot><tr class="bg-gray-50 font-bold"><td>Total</td><td class="text-right font-mono">{{ number_format($totalAge) }}</td><td class="text-right text-xs text-gray-500">100%</td></tr></tfoot>
                            </table>
                        </div>
                    </div>
                @endif

                {{-- Pendidikan Table --}}
                @if(is_array($eduData) && count($eduData) > 0)
                    <div class="card overflow-hidden">
                        <div class="p-5 border-b border-gray-100">
                            <h3 class="font-bold text-gray-900 flex items-center gap-2 text-sm">
                                <span class="material-symbols-outlined text-amber-500 text-lg">school</span> Detail Tingkat Pendidikan
                            </h3>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="data-table">
                                <thead><tr><th>Pendidikan</th><th class="text-right">Jumlah</th><th class="text-right">Persentase</th></tr></thead>
                                <tbody>
                                    @php $totalEdu = array_sum($eduData); @endphp
                                    @foreach($eduData as $label => $count)
                                        <tr>
                                            <td class="font-medium">{{ $label }}</td>
                                            <td class="text-right font-mono">{{ number_format($count) }}</td>
                                            <td class="text-right">
                                                <div class="flex items-center justify-end gap-2">
                                                    <div class="w-16 bg-gray-200 rounded-full h-1.5">
                                                        <div class="bg-amber-500 h-1.5 rounded-full" style="width: {{ $totalEdu > 0 ? round($count / $totalEdu * 100, 1) : 0 }}%"></div>
                                                    </div>
                                                    <span class="text-xs text-gray-500 w-10 text-right">{{ $totalEdu > 0 ? number_format($count / $totalEdu * 100, 1) : 0 }}%</span>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot><tr class="bg-gray-50 font-bold"><td>Total</td><td class="text-right font-mono">{{ number_format($totalEdu) }}</td><td class="text-right text-xs text-gray-500">100%</td></tr></tfoot>
                            </table>
                        </div>
                    </div>
                @endif

                {{-- Pekerjaan Table --}}
                @if(is_array($occData) && count($occData) > 0)
                    <div class="card overflow-hidden md:col-span-2">
                        <div class="p-5 border-b border-gray-100">
                            <h3 class="font-bold text-gray-900 flex items-center gap-2 text-sm">
                                <span class="material-symbols-outlined text-indigo-500 text-lg">work</span> Detail Mata Pencaharian
                            </h3>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="data-table">
                                <thead><tr><th>Pekerjaan</th><th class="text-right">Jumlah</th><th class="text-right">Persentase</th></tr></thead>
                                <tbody>
                                    @php $totalOcc = array_sum($occData); @endphp
                                    @foreach($occData as $label => $count)
                                        <tr>
                                            <td class="font-medium">{{ $label }}</td>
                                            <td class="text-right font-mono">{{ number_format($count) }}</td>
                                            <td class="text-right">
                                                <div class="flex items-center justify-end gap-2">
                                                    <div class="w-24 bg-gray-200 rounded-full h-1.5">
                                                        <div class="bg-indigo-500 h-1.5 rounded-full" style="width: {{ $totalOcc > 0 ? round($count / $totalOcc * 100, 1) : 0 }}%"></div>
                                                    </div>
                                                    <span class="text-xs text-gray-500 w-10 text-right">{{ $totalOcc > 0 ? number_format($count / $totalOcc * 100, 1) : 0 }}%</span>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot><tr class="bg-gray-50 font-bold"><td>Total</td><td class="text-right font-mono">{{ number_format($totalOcc) }}</td><td class="text-right text-xs text-gray-500">100%</td></tr></tfoot>
                            </table>
                        </div>
                    </div>
                @endif
            </div>
        @else
            <div class="card p-12 text-center">
                <span class="material-symbols-outlined text-5xl text-gray-300 mb-3">bar_chart</span>
                <p class="text-gray-400">Belum ada data infografis penduduk.</p>
            </div>
        @endif
    </section>
</div>
