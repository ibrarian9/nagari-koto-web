<section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16">
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-desa-950 via-desa-900 to-desa-950 p-8 md:p-12 shadow-2xl border border-white/10 text-white">
        {{-- Background Glow & Grid Accents --}}
        <div class="absolute -top-24 -right-24 h-72 w-72 rounded-full bg-emerald-500/10 blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 -left-24 h-72 w-72 rounded-full bg-amber-500/10 blur-3xl pointer-events-none"></div>
        <div class="absolute inset-0 bg-[linear-gradient(to_right,#ffffff03_1px,transparent_1px),linear-gradient(to_bottom,#ffffff03_1px,transparent_1px)] bg-[size:3rem_3rem] pointer-events-none"></div>

        <div class="relative z-10">
            {{-- Header & Realtime Online Status Badge --}}
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6 pb-8 border-b border-white/10">
                <div>
                    <div class="inline-flex items-center gap-2 rounded-full bg-white/10 border border-white/15 backdrop-blur-md px-3.5 py-1 text-xs text-amber-300 font-bold tracking-wider uppercase mb-3 shadow-inner">
                        <span class="material-symbols-outlined text-sm text-amber-400">monitoring</span>
                        Statistik Pengunjung
                    </div>
                    <h2 class="text-2xl md:text-3xl font-extrabold text-white tracking-tight">
                        Statistik Kunjungan Website
                    </h2>
                    <p class="mt-1 text-xs md:text-sm text-desa-200/80 max-w-xl">
                        Informasi jumlah pengunjung portal resmi Nagari yang tercatat secara akurat dan selalu diperbarui saat halaman dibuka.
                    </p>
                </div>

                {{-- Online Now Pill --}}
                <div class="flex items-center gap-3 self-start md:self-auto bg-emerald-950/60 border border-emerald-500/30 rounded-2xl px-5 py-3.5 shadow-lg backdrop-blur-md">
                    <span class="relative flex h-3.5 w-3.5">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-3.5 w-3.5 bg-emerald-500 shadow-sm shadow-emerald-400/50"></span>
                    </span>
                    <div>
                        <div class="text-[10px] uppercase font-bold tracking-widest text-emerald-400 leading-none">Sedang Online</div>
                        <div class="text-lg font-black text-white leading-tight mt-0.5">
                            {{ number_format($onlineCount) }} <span class="text-xs font-medium text-emerald-200/80">Pengguna</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- 4 Stat Metric Cards --}}
            <div class="mt-8 grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
                {{-- Hari Ini --}}
                <div class="group relative rounded-2xl bg-white/5 border border-white/10 p-5 backdrop-blur-md transition-all duration-300 hover:bg-white/10 hover:border-emerald-500/40 hover:-translate-y-1 shadow-lg">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-bold uppercase tracking-wider text-desa-300">Hari Ini</span>
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-500/15 border border-emerald-500/25 text-emerald-400 group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined text-xl">today</span>
                        </div>
                    </div>
                    <div class="text-2xl md:text-3xl font-black text-white tracking-tight">
                        {{ number_format($todayCount) }}
                    </div>
                    <div class="mt-1 text-[11px] text-emerald-300/80 font-medium">Pengunjung unik hari ini</div>
                </div>

                {{-- Kemarin --}}
                <div class="group relative rounded-2xl bg-white/5 border border-white/10 p-5 backdrop-blur-md transition-all duration-300 hover:bg-white/10 hover:border-sky-500/40 hover:-translate-y-1 shadow-lg">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-bold uppercase tracking-wider text-desa-300">Kemarin</span>
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-sky-500/15 border border-sky-500/25 text-sky-400 group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined text-xl">history</span>
                        </div>
                    </div>
                    <div class="text-2xl md:text-3xl font-black text-white tracking-tight">
                        {{ number_format($yesterdayCount) }}
                    </div>
                    <div class="mt-1 text-[11px] text-sky-300/80 font-medium">Pengunjung kemarin</div>
                </div>

                {{-- Bulan Ini --}}
                <div class="group relative rounded-2xl bg-white/5 border border-white/10 p-5 backdrop-blur-md transition-all duration-300 hover:bg-white/10 hover:border-amber-500/40 hover:-translate-y-1 shadow-lg">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-bold uppercase tracking-wider text-desa-300">Bulan Ini</span>
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-500/15 border border-amber-500/25 text-amber-400 group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined text-xl">calendar_month</span>
                        </div>
                    </div>
                    <div class="text-2xl md:text-3xl font-black text-white tracking-tight">
                        {{ number_format($monthCount) }}
                    </div>
                    <div class="mt-1 text-[11px] text-amber-300/80 font-medium">{{ now()->translatedFormat('F Y') }}</div>
                </div>

                {{-- Total Kunjungan --}}
                <div class="group relative rounded-2xl bg-white/5 border border-white/10 p-5 backdrop-blur-md transition-all duration-300 hover:bg-white/10 hover:border-indigo-500/40 hover:-translate-y-1 shadow-lg">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-bold uppercase tracking-wider text-desa-300">Total Kunjungan</span>
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-500/15 border border-indigo-500/25 text-indigo-400 group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined text-xl">public</span>
                        </div>
                    </div>
                    <div class="text-2xl md:text-3xl font-black text-white tracking-tight">
                        {{ number_format($totalCount) }}
                    </div>
                    <div class="mt-1 text-[11px] text-indigo-300/80 font-medium flex items-center justify-between">
                        <span>Akumulasi Total</span>
                        @if ($totalHits > 0)
                            <span class="text-[10px] text-white/60">({{ number_format($totalHits) }} hits)</span>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Footer Note --}}
            <div class="mt-6 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-desa-400/80 pt-4 border-t border-white/5">
                <div class="flex items-center gap-1.5">
                    <span class="material-symbols-outlined text-sm text-emerald-400">check_circle</span>
                    <span>Data statistik diperbarui secara otomatis setiap kali halaman di-refresh.</span>
                </div>
                <div class="text-[11px] text-desa-400/60">
                    Sistem Pelacakan Kunjungan Portal Nagari
                </div>
            </div>
        </div>
    </div>
</section>
