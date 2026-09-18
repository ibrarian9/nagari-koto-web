<section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12">
    <div class="rounded-2xl bg-desa-950 border border-desa-800 p-6 md:p-8 shadow-sm text-white">
        {{-- Header & Realtime Online Status Badge --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 pb-6 border-b border-desa-800/80">
            <div>
                <div class="inline-flex items-center gap-1.5 rounded-md bg-desa-900 border border-desa-750 px-2.5 py-1 text-xs text-desa-300 font-semibold mb-2.5">
                    <span class="material-symbols-outlined text-sm text-desa-400">monitoring</span>
                    Statistik Pengunjung
                </div>
                <h2 class="text-2xl md:text-3xl font-bold text-white tracking-tight">
                    Statistik Kunjungan Website
                </h2>
                <p class="mt-1 text-xs md:text-sm text-desa-300/80 max-w-xl">
                    Informasi jumlah pengunjung portal resmi Nagari yang tercatat secara akurat dan selalu diperbarui saat halaman dibuka.
                </p>
            </div>

            {{-- Online Now Indicator --}}
            <div class="inline-flex items-center gap-3 self-start md:self-auto bg-desa-900 border border-desa-800 rounded-xl px-4 py-3">
                <span class="relative flex h-3 w-3">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span>
                </span>
                <div>
                    <div class="text-[10px] uppercase font-bold tracking-wider text-emerald-400 leading-none">Sedang Online</div>
                    <div class="text-base font-bold text-white leading-tight mt-1">
                        {{ number_format($onlineCount) }} <span class="text-xs font-normal text-desa-300">Pengunjung</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- 4 Stat Metric Cards --}}
        <div class="mt-6 grid grid-cols-2 lg:grid-cols-4 gap-4">
            <x-stat-card
                :dark="true"
                label="Hari Ini"
                :value="number_format($todayCount)"
                subtext="Pengunjung unik hari ini"
                icon="today"
            />

            <x-stat-card
                :dark="true"
                label="Kemarin"
                :value="number_format($yesterdayCount)"
                subtext="Pengunjung kemarin"
                icon="history"
            />

            <x-stat-card
                :dark="true"
                label="Bulan Ini"
                :value="number_format($monthCount)"
                :subtext="now()->translatedFormat('F Y')"
                icon="calendar_month"
            />

            <x-stat-card
                :dark="true"
                label="Total Kunjungan"
                :value="number_format($totalCount)"
                icon="public"
            >
                <div class="flex items-center justify-between">
                    <span>Pengunjung unik</span>
                    @if ($totalHits > 0)
                        <span class="text-[11px] text-desa-400">({{ number_format($totalHits) }} hits)</span>
                    @endif
                </div>
            </x-stat-card>
        </div>

        {{-- Footer Note --}}
        <div class="mt-6 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-desa-400 pt-4 border-t border-desa-800/80">
            <div class="flex items-center gap-1.5">
                <span class="material-symbols-outlined text-sm text-desa-400">check_circle</span>
                <span>Data statistik diperbarui secara otomatis setiap kali halaman di-refresh.</span>
            </div>
            <div class="text-[11px] text-desa-400/80">
                Sistem Pelacakan Kunjungan Portal Nagari
            </div>
        </div>
    </div>
</section>
