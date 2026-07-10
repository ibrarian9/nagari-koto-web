<div>
    <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12">
        {{-- Hero --}}
        <div class="text-center mb-10">
            <div
                class="inline-flex items-center justify-center h-16 w-16 rounded-2xl bg-gradient-to-br from-desa-500 to-desa-700 mb-4 shadow-lg shadow-desa-500/20">
                <span class="material-symbols-outlined text-white text-3xl">insights</span>
            </div>
            <h1 class="section-title">Indeks Desa Membangun (IDM)</h1>
            <p class="section-subtitle">Mengukur kemajuan dan kemandirian nagari</p>
        </div>

        {{-- Penjelasan IDM --}}
        <div class="card p-6 mb-8">
            <div class="flex items-start gap-4">
                <div class="flex-shrink-0 h-10 w-10 rounded-lg bg-desa-50 flex items-center justify-center">
                    <span class="material-symbols-outlined text-desa-600">help</span>
                </div>
                <div class="text-sm text-gray-600 leading-relaxed">
                    <h3 class="font-bold text-gray-900 mb-2">Apa itu IDM?</h3>
                    <p>Indeks Desa Membangun (IDM) adalah indikator yang dikembangkan oleh <strong>Kementerian Desa, PDT
                            dan Transmigrasi</strong> untuk mengukur tingkat kemajuan dan kemandirian nagari. IDM
                        menggunakan dimensi utama dan tambahan:</p>
                    <ul class="mt-2 space-y-1">
                        <li class="flex items-start gap-2"><span
                                class="material-symbols-outlined text-blue-500 text-sm mt-0.5">group</span>
                            <span><strong>IKS (Sosial):</strong> Kesehatan, pendidikan, modal sosial, dan
                                permukiman</span>
                        </li>
                        <li class="flex items-start gap-2"><span
                                class="material-symbols-outlined text-amber-500 text-sm mt-0.5">trending_up</span>
                            <span><strong>IKE (Ekonomi):</strong> Keragaman produksi, perdagangan, akses distribusi dan
                                kredit</span>
                        </li>
                        <li class="flex items-start gap-2"><span
                                class="material-symbols-outlined text-green-500 text-sm mt-0.5">eco</span>
                            <span><strong>IKL (Lingkungan):</strong> Kualitas lingkungan, potensi rawan bencana</span>
                        </li>
                        <li class="flex items-start gap-2"><span
                                class="material-symbols-outlined text-purple-500 text-sm mt-0.5">route</span>
                            <span><strong>Aksesibilitas:</strong> Kemudahan akses transportasi dan komunikasi</span>
                        </li>
                        <li class="flex items-start gap-2"><span
                                class="material-symbols-outlined text-rose-500 text-sm mt-0.5">medical_services</span>
                            <span><strong>Layanan Dasar:</strong> Ketersediaan pelayanan kesehatan, pendidikan, dan
                                infrastruktur</span>
                        </li>
                        <li class="flex items-start gap-2"><span
                                class="material-symbols-outlined text-indigo-500 text-sm mt-0.5">account_balance</span>
                            <span><strong>Tata Kelola Pemdes:</strong> Kualitas penyelenggaraan pemerintahan nagari</span>
                        </li>
                    </ul>
                    <p class="mt-2">Skor IDM berkisar antara <strong>0 sampai 1</strong>. Semakin tinggi skor, semakin
                        maju nagarinya.</p>
                </div>
            </div>
        </div>

        @if ($latest)
            {{-- Current Score Hero --}}
            <div class="card p-8 mb-8 text-center bg-gradient-to-br from-desa-50 to-white border-2 border-desa-100">
                <p class="text-sm text-gray-500 mb-2">Skor IDM Tahun {{ $latest->year }}</p>
                <p class="text-6xl font-extrabold text-desa-600 mb-3">{{ number_format($latest->score, 3) }}</p>
                <span
                    class="inline-block badge text-sm px-5 py-2 {{ $latest->status_color }}">{{ $latest->status_label }}</span>
                <p class="mt-3 text-sm text-gray-500">
                    @if ($latest->status === 'mandiri')
                        Selamat! Nagari kita telah mencapai status <strong class="text-green-600">Mandiri</strong> —
                        tingkat tertinggi dalam IDM.
                    @elseif($latest->status === 'maju')
                        Nagari kita berstatus <strong class="text-blue-600">Maju</strong> dan terus bergerak menuju
                        kemandirian.
                    @elseif($latest->status === 'berkembang')
                        Nagari kita berstatus <strong class="text-amber-600">Berkembang</strong> dan sedang dalam proses
                        peningkatan.
                    @else
                        Nagari kita masih dalam tahap pembangunan dan memerlukan perhatian lebih.
                    @endif
                </p>
            </div>

            {{-- Status Reference --}}
            <div class="card p-6 mb-8">
                <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <span class="material-symbols-outlined text-desa-500">info</span> Keterangan Status IDM
                </h3>
                <p class="text-sm text-gray-500 mb-4">Status nagari ditetapkan berdasarkan rentang skor IDM menurut
                    ketentuan Kementerian Desa, PDT dan Transmigrasi:</p>
                <div class="grid grid-cols-1 sm:grid-cols-5 gap-3">
                    @foreach ([['status' => 'Sangat Tertinggal', 'range' => '< 0,491', 'color' => 'bg-red-100 text-red-800', 'icon' => 'warning'], ['status' => 'Tertinggal', 'range' => '0,491 – 0,599', 'color' => 'bg-orange-100 text-orange-800', 'icon' => 'trending_flat'], ['status' => 'Berkembang', 'range' => '0,600 – 0,707', 'color' => 'bg-amber-100 text-amber-800', 'icon' => 'trending_up'], ['status' => 'Maju', 'range' => '0,708 – 0,815', 'color' => 'bg-blue-100 text-blue-800', 'icon' => 'rocket_launch'], ['status' => 'Mandiri', 'range' => '> 0,815', 'color' => 'bg-green-100 text-green-800', 'icon' => 'stars']] as $info)
                        <div class="rounded-xl p-4 text-center {{ $info['color'] }}">
                            <span class="material-symbols-outlined text-2xl mb-1">{{ $info['icon'] }}</span>
                            <p class="font-bold text-sm">{{ $info['status'] }}</p>
                            <p class="text-xs mt-1 opacity-80">{{ $info['range'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Dimension Scores --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mb-8">
                @foreach ([
        ['label' => 'Indeks Ketahanan Sosial', 'short' => 'IKS', 'score' => $latest->social_score, 'icon' => 'group', 'color' => 'blue', 'desc' => 'Kesehatan, pendidikan, permukiman'],
        ['label' => 'Indeks Ketahanan Ekonomi', 'short' => 'IKE', 'score' => $latest->economic_score, 'icon' => 'trending_up', 'color' => 'amber', 'desc' => 'Produksi, perdagangan, kredit'],
        ['label' => 'Indeks Ketahanan Lingkungan', 'short' => 'IKL', 'score' => $latest->environment_score, 'icon' => 'eco', 'color' => 'green', 'desc' => 'Lingkungan hidup, bencana'],
        ['label' => 'Skor Aksesibilitas', 'short' => 'Akses', 'score' => $latest->accessibility_score, 'icon' => 'route', 'color' => 'purple', 'desc' => 'Transportasi & komunikasi'],
        ['label' => 'Layanan Dasar', 'short' => 'LayDas', 'score' => $latest->basic_service_score, 'icon' => 'medical_services', 'color' => 'rose', 'desc' => 'Kesehatan, pendidikan, infrastruktur'],
        ['label' => 'Tata Kelola Pemdes', 'short' => 'TKP', 'score' => $latest->governance_score, 'icon' => 'account_balance', 'color' => 'indigo', 'desc' => 'Penyelenggaraan pemerintahan nagari'],
    ] as $dim)
                    <div class="card p-5">
                        <div class="flex items-center gap-3 mb-3">
                            <div
                                class="h-10 w-10 rounded-lg bg-{{ $dim['color'] }}-50 flex items-center justify-center">
                                <span
                                    class="material-symbols-outlined text-{{ $dim['color'] }}-600">{{ $dim['icon'] }}</span>
                            </div>
                            <div>
                                <p class="font-bold text-gray-900 text-sm">{{ $dim['label'] }}</p>
                                <p class="text-xs text-gray-400">{{ $dim['desc'] }}</p>
                            </div>
                        </div>
                        <div class="flex items-end gap-2">
                            <span
                                class="text-3xl font-extrabold text-gray-900">{{ number_format($dim['score'], 3) }}</span>
                            <span class="text-xs text-gray-400 mb-1">/ 1.000</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                            <div class="bg-{{ $dim['color'] }}-500 h-2 rounded-full transition-all duration-500"
                                style="width: {{ $dim['score'] * 100 }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Charts --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8" x-data x-init="$nextTick(() => {
                new Chart(document.getElementById('radarChart'), {
                    type: 'radar',
                    data: {
                        labels: ['Sosial (IKS)', 'Ekonomi (IKE)', 'Lingkungan (IKL)', 'Aksesibilitas', 'Layanan Dasar', 'Tata Kelola'],
                        datasets: [{
                            label: 'Skor IDM {{ $latest->year }}',
                            data: [{{ $latest->social_score }}, {{ $latest->economic_score }}, {{ $latest->environment_score }}, {{ $latest->accessibility_score }}, {{ $latest->basic_service_score }}, {{ $latest->governance_score }}],
                            backgroundColor: 'rgba(45,106,79,0.15)',
                            borderColor: '#2D6A4F',
                            pointBackgroundColor: '#2D6A4F',
                            pointRadius: 5,
                            borderWidth: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: { r: { beginAtZero: true, max: 1, ticks: { stepSize: 0.2 } } },
                        plugins: { legend: { position: 'bottom' } }
                    }
                });
            
                const years = @js($allStats->pluck('year')->reverse()->values());
                const scores = @js($allStats->pluck('score')->reverse()->values());
                new Chart(document.getElementById('trendChart'), {
                    type: 'line',
                    data: {
                        labels: years,
                        datasets: [{
                            label: 'Skor IDM',
                            data: scores,
                            borderColor: '#2D6A4F',
                            backgroundColor: 'rgba(45,106,79,0.1)',
                            fill: true,
                            tension: 0.3,
                            pointRadius: 6,
                            pointBackgroundColor: '#2D6A4F'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: { y: { min: 0.5, max: 1, ticks: { stepSize: 0.05 } } },
                        plugins: { legend: { position: 'bottom' } }
                    }
                });
            })">
                <div class="card p-6">
                    <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <span class="material-symbols-outlined text-desa-500">radar</span> Dimensi IDM
                        {{ $latest->year }}
                    </h3>
                    <div class="relative w-full h-72"><canvas id="radarChart"></canvas></div>
                </div>
                <div class="card p-6">
                    <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <span class="material-symbols-outlined text-desa-500">show_chart</span> Tren Skor IDM
                    </h3>
                    <div class="relative w-full h-72"><canvas id="trendChart"></canvas></div>
                </div>
            </div>

            {{-- Riwayat IDM Table --}}
            <div class="card overflow-hidden mb-8">
                <div class="p-5 border-b border-gray-100">
                    <h3 class="font-bold text-gray-900 flex items-center gap-2">
                        <span class="material-symbols-outlined text-desa-500">table_chart</span> Riwayat IDM Per Tahun
                    </h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Tahun</th>
                                <th>Skor IDM</th>
                                <th>Status</th>
                                <th>IKS (Sosial)</th>
                                <th>IKE (Ekonomi)</th>
                                <th>IKL (Lingkungan)</th>
                                <th>Akses.</th>
                                <th>Lay. Dasar</th>
                                <th>Tata Kelola</th>
                                <th>Perubahan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($allStats as $i => $stat)
                                @php
                                    $prev = $allStats[$i + 1] ?? null;
                                    $change = $prev ? $stat->score - $prev->score : null;
                                @endphp
                                <tr>
                                    <td class="font-bold">{{ $stat->year }}</td>
                                    <td class="font-mono font-bold text-desa-600">{{ number_format($stat->score, 3) }}
                                    </td>
                                    <td><span class="badge {{ $stat->status_color }}">{{ $stat->status_label }}</span>
                                    </td>
                                    <td class="font-mono">{{ number_format($stat->social_score, 3) }}</td>
                                    <td class="font-mono">{{ number_format($stat->economic_score, 3) }}</td>
                                    <td class="font-mono">{{ number_format($stat->environment_score, 3) }}</td>
                                    <td class="font-mono">{{ number_format($stat->accessibility_score, 3) }}</td>
                                    <td class="font-mono">{{ number_format($stat->basic_service_score, 3) }}</td>
                                    <td class="font-mono">{{ number_format($stat->governance_score, 3) }}</td>
                                    <td>
                                        @if ($change !== null)
                                            <span
                                                class="inline-flex items-center gap-1 text-sm font-medium {{ $change >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                                <span
                                                    class="material-symbols-outlined text-sm">{{ $change >= 0 ? 'arrow_upward' : 'arrow_downward' }}</span>
                                                {{ $change >= 0 ? '+' : '' }}{{ number_format($change, 3) }}
                                            </span>
                                        @else
                                            <span class="text-gray-400">—</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <div class="card p-12 text-center">
                <span class="material-symbols-outlined text-5xl text-gray-300 mb-3">insights</span>
                <p class="text-gray-400">Belum ada data IDM.</p>
            </div>
        @endif
    </section>
</div>
