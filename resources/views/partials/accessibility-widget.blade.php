{{-- ─── ACCESSIBILITY WIDGET ─────────────────────────────────── --}}
{{-- Floating button on the LEFT side with full accessibility controls --}}
<div x-data="accessibilityWidget()" x-init="init()" x-cloak
    class="fixed left-0 top-1/2 -translate-y-1/2 z-[90] flex items-start gap-0">

    {{-- Toggle Button --}}
    <button @click="open = !open" :aria-expanded="open"
        aria-label="Menu Aksesibilitas"
        class="group relative flex items-center justify-center w-12 h-12 rounded-r-2xl bg-desa-700 hover:bg-desa-800 text-white shadow-xl shadow-desa-900/30 transition-all duration-300 hover:w-14 focus:outline-none focus:ring-2 focus:ring-desa-400 focus:ring-offset-2"
        :class="open ? 'rounded-r-none bg-desa-800' : ''">
        <span class="material-symbols-outlined text-2xl transition-transform duration-300"
            :class="open ? 'rotate-180' : ''">accessibility_new</span>
        {{-- Pulse indicator when any feature is active --}}
        <span x-show="hasActiveFeatures()" x-transition
            class="absolute -top-1 -right-1 h-3.5 w-3.5 rounded-full bg-amber-400 border-2 border-white animate-pulse"></span>
    </button>

    {{-- Panel --}}
    <div x-show="open" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 -translate-x-4"
        x-transition:enter-end="opacity-100 translate-x-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-x-0"
        x-transition:leave-end="opacity-0 -translate-x-4"
        @click.outside="open = false"
        @keydown.escape.window="open = false"
        class="w-72 max-h-[80vh] overflow-y-auto bg-white rounded-r-2xl rounded-bl-2xl shadow-2xl shadow-black/20 border border-gray-200/80 overscroll-contain"
        style="display: none;">

        {{-- Header --}}
        <div class="sticky top-0 bg-gradient-to-r from-desa-700 to-desa-800 text-white px-5 py-4 rounded-tr-2xl z-10">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2.5">
                    <span class="material-symbols-outlined text-xl">accessibility_new</span>
                    <div>
                        <h3 class="font-bold text-sm leading-tight">Aksesibilitas</h3>
                        <p class="text-[10px] text-desa-200 mt-0.5">Pengaturan tampilan</p>
                    </div>
                </div>
                <button @click="resetAll()" title="Reset semua pengaturan"
                    class="h-8 w-8 rounded-lg bg-white/15 hover:bg-white/25 flex items-center justify-center transition-colors">
                    <span class="material-symbols-outlined text-base">restart_alt</span>
                </button>
            </div>
        </div>

        <div class="p-4 space-y-3">

            {{-- 1. Ukuran Teks --}}
            <div class="acc-card">
                <div class="flex items-center justify-between mb-2.5">
                    <div class="flex items-center gap-2">
                        <span class="acc-icon bg-blue-100 text-blue-600">text_fields</span>
                        <span class="acc-label">Ukuran Teks</span>
                    </div>
                    <span class="text-xs font-bold text-gray-500 bg-gray-100 px-2 py-0.5 rounded-full"
                        x-text="fontSize + '%'"></span>
                </div>
                <div class="flex items-center gap-2">
                    <button @click="changeFontSize(-10)" :disabled="fontSize <= 80"
                        class="acc-btn flex-1" :class="fontSize <= 80 && 'opacity-40 cursor-not-allowed'">
                        <span class="material-symbols-outlined text-sm">text_decrease</span> A-
                    </button>
                    <button @click="fontSize = 100; applyFontSize()"
                        class="acc-btn flex-1" :class="fontSize === 100 && 'ring-2 ring-desa-400'">
                        <span class="material-symbols-outlined text-sm">format_size</span> Normal
                    </button>
                    <button @click="changeFontSize(10)" :disabled="fontSize >= 150"
                        class="acc-btn flex-1" :class="fontSize >= 150 && 'opacity-40 cursor-not-allowed'">
                        <span class="material-symbols-outlined text-sm">text_increase</span> A+
                    </button>
                </div>
            </div>

            {{-- 2. Kontras Tinggi --}}
            <button @click="toggle('highContrast')" class="acc-toggle-card"
                :class="highContrast && 'acc-toggle-active'">
                <span class="acc-icon" :class="highContrast ? 'bg-amber-500 text-white' : 'bg-amber-100 text-amber-600'">contrast</span>
                <div class="flex-1 text-left">
                    <p class="acc-label">Kontras Tinggi</p>
                    <p class="acc-desc">Perbesar kontras warna</p>
                </div>
                <div class="acc-switch" :class="highContrast && 'acc-switch-on'">
                    <div class="acc-switch-dot" :class="highContrast && 'translate-x-4'"></div>
                </div>
            </button>

            {{-- 3. Monokrom --}}
            <button @click="toggle('monochrome')" class="acc-toggle-card"
                :class="monochrome && 'acc-toggle-active'">
                <span class="acc-icon" :class="monochrome ? 'bg-gray-700 text-white' : 'bg-gray-100 text-gray-600'">filter_b_and_w</span>
                <div class="flex-1 text-left">
                    <p class="acc-label">Monokrom</p>
                    <p class="acc-desc">Tampilan hitam putih</p>
                </div>
                <div class="acc-switch" :class="monochrome && 'acc-switch-on'">
                    <div class="acc-switch-dot" :class="monochrome && 'translate-x-4'"></div>
                </div>
            </button>

            {{-- 4. Invert Warna --}}
            <button @click="toggle('invertColors')" class="acc-toggle-card"
                :class="invertColors && 'acc-toggle-active'">
                <span class="acc-icon" :class="invertColors ? 'bg-indigo-500 text-white' : 'bg-indigo-100 text-indigo-600'">invert_colors</span>
                <div class="flex-1 text-left">
                    <p class="acc-label">Invert Warna</p>
                    <p class="acc-desc">Balikkan semua warna</p>
                </div>
                <div class="acc-switch" :class="invertColors && 'acc-switch-on'">
                    <div class="acc-switch-dot" :class="invertColors && 'translate-x-4'"></div>
                </div>
            </button>

            {{-- 5. Kursor Besar --}}
            <button @click="toggle('bigCursor')" class="acc-toggle-card"
                :class="bigCursor && 'acc-toggle-active'">
                <span class="acc-icon" :class="bigCursor ? 'bg-purple-500 text-white' : 'bg-purple-100 text-purple-600'">mouse</span>
                <div class="flex-1 text-left">
                    <p class="acc-label">Kursor Besar</p>
                    <p class="acc-desc">Perbesar ukuran kursor</p>
                </div>
                <div class="acc-switch" :class="bigCursor && 'acc-switch-on'">
                    <div class="acc-switch-dot" :class="bigCursor && 'translate-x-4'"></div>
                </div>
            </button>

            {{-- 6. Sorot Teks --}}
            <button @click="toggle('highlightText')" class="acc-toggle-card"
                :class="highlightText && 'acc-toggle-active'">
                <span class="acc-icon" :class="highlightText ? 'bg-emerald-500 text-white' : 'bg-emerald-100 text-emerald-600'">highlight</span>
                <div class="flex-1 text-left">
                    <p class="acc-label">Sorot Teks</p>
                    <p class="acc-desc">Sorot link dan heading</p>
                </div>
                <div class="acc-switch" :class="highlightText && 'acc-switch-on'">
                    <div class="acc-switch-dot" :class="highlightText && 'translate-x-4'"></div>
                </div>
            </button>

            {{-- 7. Baca Suara --}}
            <div class="acc-card">
                <div class="flex items-center gap-2.5 mb-2.5">
                    <span class="acc-icon bg-rose-100 text-rose-600">record_voice_over</span>
                    <div>
                        <p class="acc-label">Baca Suara</p>
                        <p class="acc-desc">Pilih teks, lalu klik baca</p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <button @click="speakSelected()" class="acc-btn flex-1 gap-1.5"
                        :disabled="isSpeaking" :class="isSpeaking && 'opacity-60'">
                        <span class="material-symbols-outlined text-sm" x-text="isSpeaking ? 'volume_up' : 'play_arrow'"></span>
                        <span x-text="isSpeaking ? 'Membaca...' : 'Baca'"></span>
                    </button>
                    <button @click="stopSpeaking()" x-show="isSpeaking" x-transition class="acc-btn px-3">
                        <span class="material-symbols-outlined text-sm">stop</span>
                    </button>
                </div>
                <p class="text-[10px] text-gray-400 mt-2 flex items-center gap-1">
                    <span class="material-symbols-outlined text-xs">info</span>
                    Blok/sorot teks di halaman, lalu tekan "Baca"
                </p>
            </div>

        </div>

        {{-- Footer --}}
        <div class="px-4 pb-4">
            <div class="bg-gray-50 rounded-xl px-3 py-2.5 flex items-center gap-2 text-[10px] text-gray-400">
                <span class="material-symbols-outlined text-xs">universal_currency_alt</span>
                Komitmen aksesibilitas digital untuk semua
            </div>
        </div>
    </div>
</div>

<script>
    function accessibilityWidget() {
        return {
            open: false,
            fontSize: 100,
            highContrast: false,
            monochrome: false,
            invertColors: false,
            bigCursor: false,
            highlightText: false,
            isSpeaking: false,
            _synth: null,

            init() {
                // Load saved preferences
                const saved = localStorage.getItem('acc_prefs');
                if (saved) {
                    try {
                        const prefs = JSON.parse(saved);
                        this.fontSize = prefs.fontSize ?? 100;
                        this.highContrast = prefs.highContrast ?? false;
                        this.monochrome = prefs.monochrome ?? false;
                        this.invertColors = prefs.invertColors ?? false;
                        this.bigCursor = prefs.bigCursor ?? false;
                        this.highlightText = prefs.highlightText ?? false;
                    } catch (e) {}
                }
                this.applyAll();
                this._synth = window.speechSynthesis || null;
            },

            save() {
                localStorage.setItem('acc_prefs', JSON.stringify({
                    fontSize: this.fontSize,
                    highContrast: this.highContrast,
                    monochrome: this.monochrome,
                    invertColors: this.invertColors,
                    bigCursor: this.bigCursor,
                    highlightText: this.highlightText,
                }));
            },

            hasActiveFeatures() {
                return this.fontSize !== 100 || this.highContrast || this.monochrome ||
                    this.invertColors || this.bigCursor || this.highlightText;
            },

            toggle(feature) {
                this[feature] = !this[feature];
                this.applyAll();
                this.save();
            },

            changeFontSize(delta) {
                this.fontSize = Math.min(150, Math.max(80, this.fontSize + delta));
                this.applyFontSize();
                this.save();
            },

            applyFontSize() {
                document.documentElement.style.fontSize = this.fontSize + '%';
            },

            applyAll() {
                const html = document.documentElement;
                html.classList.toggle('acc-high-contrast', this.highContrast);
                html.classList.toggle('acc-monochrome', this.monochrome);
                html.classList.toggle('acc-invert', this.invertColors);
                html.classList.toggle('acc-big-cursor', this.bigCursor);
                html.classList.toggle('acc-highlight-text', this.highlightText);
                this.applyFontSize();
            },

            resetAll() {
                this.fontSize = 100;
                this.highContrast = false;
                this.monochrome = false;
                this.invertColors = false;
                this.bigCursor = false;
                this.highlightText = false;
                this.stopSpeaking();
                this.applyAll();
                this.save();
            },

            speakSelected() {
                if (!this._synth) return alert('Browser Anda tidak mendukung fitur baca suara.');
                const text = window.getSelection()?.toString()?.trim();
                if (!text) return alert('Silakan sorot/blok teks yang ingin dibacakan terlebih dahulu.');

                this.stopSpeaking();
                const utterance = new SpeechSynthesisUtterance(text);
                utterance.lang = 'id-ID';
                utterance.rate = 0.9;
                utterance.pitch = 1;
                utterance.onend = () => { this.isSpeaking = false; };
                utterance.onerror = () => { this.isSpeaking = false; };
                this.isSpeaking = true;
                this._synth.speak(utterance);
            },

            stopSpeaking() {
                if (this._synth) this._synth.cancel();
                this.isSpeaking = false;
            }
        };
    }
</script>
