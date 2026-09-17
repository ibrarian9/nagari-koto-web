<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;

test('all public routes return successful response', function ($routeName) {
    // Routes that require parameters or external redirects can be skipped or tested separately
    if (in_array($routeName, [
        'pemerintahan.detail',
        'berita.show',
        'umkm.show',
        'donasi.detail',
        'verification.verify',
        'password.reset',
        'ppid.permohonan',
        'storage.local',
        'storage.local.upload',
        'livewire.preview-file',
        'livewire.upload-file',
        'livewire.update',
        'livewire.mechanisms',
        'logout',
    ])) {
        expect(true)->toBeTrue();
        return;
    }

    $url = route($routeName);
    $response = $this->get($url);

    expect($response->status())->toBeIn([200, 302]);
})->with([
    'home',
    'profil-nagari',
    'pemerintahan',
    'berita.index',
    'potensi',
    'umkm',
    'kontak',
    'agenda',
    'infografis',
    'idm',
    'anggaran',
    'surat.info',
    'bansos',
    'kehutanan',
    'bamus',
    'lembaga',
    'donasi',
    'produk-hukum',
    'bumnag.home',
    'bumnag.struktur',
    'bumnag.hukum',
    'bumnag.anggaran',
    'bumnag.program-kerja',
    'ppid.home',
    'ppid.cek-status',
]);

test('all admin routes are protected against guest access', function ($routeName) {
    $url = route($routeName);
    $response = $this->get($url);

    // Guest must be redirected to login
    $response->assertRedirect(route('login'));
})->with([
    'admin.dashboard',
    'admin.profil-nagari',
    'admin.pemerintahan',
    'admin.berita',
    'admin.potensi',
    'admin.umkm',
    'admin.kontak',
    'admin.agenda',
    'admin.infografis',
    'admin.idm',
    'admin.anggaran',
    'admin.surat',
    'admin.kehutanan',
    'admin.bamus',
    'admin.lembaga',
    'admin.donasi',
    'admin.hero',
    'admin.produk-hukum',
    'admin.ppid-berkala',
    'admin.ppid-setiap-saat',
    'admin.ppid-serta-merta',
    'admin.ppid-permohonan',
    'admin.ppid-konten',
    'admin.ppid-keberatan',
    'admin.ppid-komentar',
    'admin.bumnag-profil',
    'admin.bumnag-anggota',
    'admin.bumnag-anggaran',
    'admin.bumnag-program',
    'admin.users',
    'admin.system-logs',
]);

test('all admin routes render 200 for authenticated super_admin', function ($routeName) {
    $admin = User::factory()->create(['role' => 'super_admin']);

    $url = route($routeName);
    $response = $this->actingAs($admin)->get($url);

    // Should return 200 OK or 302 if intentional redirect (like activity-log redirect)
    expect($response->status())->toBeIn([200, 302]);
})->with([
    'admin.dashboard',
    'admin.profil-nagari',
    'admin.pemerintahan',
    'admin.berita',
    'admin.potensi',
    'admin.umkm',
    'admin.kontak',
    'admin.agenda',
    'admin.infografis',
    'admin.idm',
    'admin.anggaran',
    'admin.surat',
    'admin.kehutanan',
    'admin.bamus',
    'admin.lembaga',
    'admin.donasi',
    'admin.hero',
    'admin.produk-hukum',
    'admin.ppid-berkala',
    'admin.ppid-setiap-saat',
    'admin.ppid-serta-merta',
    'admin.ppid-permohonan',
    'admin.ppid-konten',
    'admin.ppid-keberatan',
    'admin.ppid-komentar',
    'admin.bumnag-profil',
    'admin.bumnag-anggota',
    'admin.bumnag-anggaran',
    'admin.bumnag-program',
    'admin.users',
    'admin.system-logs',
]);
