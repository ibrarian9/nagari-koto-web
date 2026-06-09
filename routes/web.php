<?php

use App\Livewire\Admin;
use App\Livewire\PublicSite;
use App\Livewire\PublicSite\Ppid;
use App\Livewire\PublicSite\Bumnag;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', PublicSite\Home::class)->name('home');
Route::get('/profil-desa', PublicSite\VillageProfile::class)->name('profil-desa');
Route::get('/pemerintahan', PublicSite\GovernmentProfile::class)->name('pemerintahan');
Route::get('/berita', PublicSite\NewsIndex::class)->name('berita.index');
Route::get('/berita/{slug}', PublicSite\NewsShow::class)->name('berita.show');
Route::get('/potensi', PublicSite\VillagePotential::class)->name('potensi');
Route::get('/umkm', PublicSite\Umkm::class)->name('umkm');
Route::get('/kontak', PublicSite\Contacts::class)->name('kontak');
Route::get('/agenda', PublicSite\Agenda::class)->name('agenda');
Route::get('/infografis', PublicSite\PopulationInfographic::class)->name('infografis');
Route::get('/idm', PublicSite\IdmStats::class)->name('idm');
Route::get('/anggaran', PublicSite\BudgetStats::class)->name('anggaran');
Route::get('/surat', PublicSite\LetterInfo::class)->name('surat.info');

Route::get('/bansos', PublicSite\BansosLink::class)->name('bansos');
Route::get('/kehutanan', PublicSite\ForestryInfo::class)->name('kehutanan');
Route::get('/bamus', PublicSite\BamusInfo::class)->name('bamus');
Route::get('/lembaga', PublicSite\InstitutionInfo::class)->name('lembaga');
Route::get('/donasi', PublicSite\DonationPage::class)->name('donasi');
Route::get('/donasi/{slug}', PublicSite\DonationDetail::class)->name('donasi.detail');

// BUMNag (Badan Usaha Milik Nagari)
Route::prefix('bumnag')->name('bumnag.')->group(function () {
    Route::get('/', Bumnag\BumnagHome::class)->name('home');
    Route::get('/struktur', Bumnag\BumnagStruktur::class)->name('struktur');
    Route::get('/badan-hukum', Bumnag\BumnagHukum::class)->name('hukum');
    Route::get('/anggaran', Bumnag\BumnagAnggaran::class)->name('anggaran');
    Route::get('/program-kerja', Bumnag\BumnagProgramKerja::class)->name('program-kerja');
});

// PPID (Pejabat Pengelola Informasi dan Dokumentasi)
Route::prefix('ppid')->name('ppid.')->group(function () {
    Route::get('/', Ppid\PpidHome::class)->name('home');
    Route::get('/permohonan', fn() => redirect()->route('ppid.home', ['tab' => 'pelayanan', 'sub' => 'permohonan']))->name('permohonan');
    Route::get('/cek-status', Ppid\PpidCekStatus::class)->name('cek-status');
});



/*
|--------------------------------------------------------------------------
| Authenticated Public Routes (warga)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:warga'])->group(function () {
    Route::get('/surat/ajukan', PublicSite\LetterRequestForm::class)->name('surat.ajukan');
    Route::get('/surat/status', PublicSite\LetterRequestStatus::class)->name('surat.status');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::prefix('admin')
    ->middleware(['auth', 'role:super_admin,admin,operator'])
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', Admin\Dashboard::class)->name('dashboard');
        Route::get('/profil-desa', Admin\VillageProfileForm::class)->name('profil-desa');
        Route::get('/pemerintahan', Admin\GovernmentManagement::class)->name('pemerintahan');
        Route::get('/berita', Admin\PostManagement::class)->name('berita');
        Route::get('/potensi', Admin\PotentialManagement::class)->name('potensi');
        Route::get('/umkm', Admin\ProductManagement::class)->name('umkm');
        Route::get('/kontak', Admin\ContactManagement::class)->name('kontak');
        Route::get('/agenda', Admin\AgendaManagement::class)->name('agenda');
        Route::get('/infografis', Admin\PopulationStatForm::class)->name('infografis');
        Route::get('/idm', Admin\IdmStatManagement::class)->name('idm');
        Route::get('/anggaran', Admin\BudgetStatManagement::class)->name('anggaran');
        Route::get('/surat', Admin\LetterRequestManagement::class)->name('surat');
        Route::get('/kehutanan', Admin\ForestryManagement::class)->name('kehutanan');
        Route::get('/bamus', Admin\BamusManagement::class)->name('bamus');
        Route::get('/lembaga', Admin\InstitutionManagement::class)->name('lembaga');
        Route::get('/donasi', Admin\CampaignManagement::class)->name('donasi');
        Route::get('/hero', Admin\HeroSettingManagement::class)->name('hero');

        // PPID Admin
        Route::get('/ppid-berkala', Admin\PpidBerkalaManagement::class)->name('ppid-berkala');
        Route::get('/ppid-setiap-saat', Admin\PpidSetiapSaatManagement::class)->name('ppid-setiap-saat');
        Route::get('/ppid-serta-merta', Admin\PpidSertaMertaManagement::class)->name('ppid-serta-merta');
        Route::get('/ppid-permohonan', Admin\PpidPermohonanManagement::class)->name('ppid-permohonan');
        Route::get('/ppid-konten', Admin\PpidContentManagement::class)->name('ppid-konten');
        Route::get('/ppid-keberatan', Admin\PpidKeberatanManagement::class)->name('ppid-keberatan');
        Route::get('/ppid-komentar', Admin\PpidCommentManagement::class)->name('ppid-komentar');

        // BUMNag Admin
        Route::get('/bumnag-profil', Admin\BumnagProfileManagement::class)->name('bumnag-profil');
        Route::get('/bumnag-anggota', Admin\BumnagMemberManagement::class)->name('bumnag-anggota');
        Route::get('/bumnag-anggaran', Admin\BumnagBudgetManagement::class)->name('bumnag-anggaran');
        Route::get('/bumnag-program', Admin\BumnagProgramManagement::class)->name('bumnag-program');

        // User management — super_admin only
        Route::get('/users', Admin\UserManagement::class)
            ->middleware('role:super_admin,admin')
            ->name('users');

        // Activity Log
        Route::get('/activity-log', Admin\ActivityLogViewer::class)
            ->middleware('role:super_admin,admin')
            ->name('activity-log');
    });

require __DIR__.'/auth.php';
