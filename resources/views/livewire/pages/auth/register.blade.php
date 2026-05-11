<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $name = '';
    public string $nik = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public bool $registered = false;

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'nik' => ['required', 'string', 'size:16', 'unique:'.User::class],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'nik' => $validated['nik'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'warga',
            'is_active' => false, // Requires admin approval
        ]);

        event(new Registered($user));

        $this->registered = true;
    }
}; ?>

<div>
    @if($registered)
        {{-- Success State --}}
        <div class="text-center py-4">
            <div class="inline-flex items-center justify-center h-16 w-16 rounded-full bg-green-100 mb-4">
                <span class="material-symbols-outlined text-green-600 text-3xl">check_circle</span>
            </div>
            <h2 class="text-xl font-bold text-gray-900 mb-2">Pendaftaran Berhasil!</h2>
            <p class="text-sm text-gray-500 leading-relaxed mb-6">
                Akun Anda telah dibuat dan sedang <strong>menunggu persetujuan admin</strong>.
                Anda akan dapat login setelah akun diaktifkan oleh petugas desa.
            </p>
            <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 text-sm text-amber-800 mb-6">
                <div class="flex items-start gap-3">
                    <span class="material-symbols-outlined text-amber-500 mt-0.5">info</span>
                    <div class="text-left">
                        <p class="font-semibold mb-1">Apa selanjutnya?</p>
                        <p>Admin Nagari akan memverifikasi data Anda. Proses ini biasanya memerlukan waktu 1-2 hari kerja.</p>
                    </div>
                </div>
            </div>
            <a href="{{ route('login') }}" wire:navigate class="btn-primary w-full">
                <span class="material-symbols-outlined text-base">login</span>
                Ke Halaman Login
            </a>
        </div>
    @else
        {{-- Registration Form --}}
        <div class="mb-5">
            <h2 class="text-lg font-bold text-gray-900">Daftar Akun Warga</h2>
            <p class="text-sm text-gray-500 mt-0.5">Isi data di bawah ini untuk mendaftar</p>
        </div>

        <form wire:submit="register" class="space-y-4">
            {{-- Nama Lengkap --}}
            <div>
                <label for="name" class="form-label">Nama Lengkap <span class="text-red-400">*</span></label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-lg">person</span>
                    <input wire:model="name" id="name" type="text" class="form-input w-full pl-10" placeholder="Sesuai KTP" required autofocus>
                </div>
                @error('name')<p class="form-error">{{ $message }}</p>@enderror
            </div>

            {{-- NIK --}}
            <div>
                <label for="nik" class="form-label">NIK (16 Digit) <span class="text-red-400">*</span></label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-lg">badge</span>
                    <input wire:model="nik" id="nik" type="text" class="form-input w-full pl-10" maxlength="16" placeholder="Nomor Induk Kependudukan" required>
                </div>
                @error('nik')<p class="form-error">{{ $message }}</p>@enderror
            </div>

            {{-- Email --}}
            <div>
                <label for="email" class="form-label">Email <span class="text-red-400">*</span></label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-lg">mail</span>
                    <input wire:model="email" id="email" type="email" class="form-input w-full pl-10" placeholder="email@contoh.com" required>
                </div>
                @error('email')<p class="form-error">{{ $message }}</p>@enderror
            </div>

            {{-- Password --}}
            <div>
                <label for="password" class="form-label">Password <span class="text-red-400">*</span></label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-lg">lock</span>
                    <input wire:model="password" id="password" type="password" class="form-input w-full pl-10" placeholder="Minimal 8 karakter" required>
                </div>
                @error('password')<p class="form-error">{{ $message }}</p>@enderror
            </div>

            {{-- Confirm Password --}}
            <div>
                <label for="password_confirmation" class="form-label">Konfirmasi Password <span class="text-red-400">*</span></label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-lg">lock</span>
                    <input wire:model="password_confirmation" id="password_confirmation" type="password" class="form-input w-full pl-10" placeholder="Ulangi password" required>
                </div>
                @error('password_confirmation')<p class="form-error">{{ $message }}</p>@enderror
            </div>

            {{-- Info Box --}}
            <div class="bg-blue-50 border border-blue-200 rounded-xl p-3 text-xs text-blue-700 flex items-start gap-2">
                <span class="material-symbols-outlined text-blue-400 text-sm mt-0.5">info</span>
                <p>Setelah mendaftar, akun Anda perlu diverifikasi oleh admin desa sebelum dapat digunakan untuk mengajukan surat.</p>
            </div>

            {{-- Submit --}}
            <button type="submit" class="btn-primary w-full" wire:loading.attr="disabled" wire:target="register">
                <span wire:loading.remove wire:target="register" class="flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined text-base">person_add</span> Daftar Sekarang
                </span>
                <span wire:loading wire:target="register" class="flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined text-base animate-spin">progress_activity</span> Mendaftar...
                </span>
            </button>

            {{-- Login Link --}}
            <p class="text-center text-sm text-gray-500">
                Sudah punya akun?
                <a href="{{ route('login') }}" wire:navigate class="font-semibold text-desa-600 hover:text-desa-800 transition-colors">Masuk di sini</a>
            </p>
        </form>
    @endif
</div>
