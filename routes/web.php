<?php

use App\Livewire\Admin;
use App\Livewire\PublicSite;
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
Route::get('/pbb', PublicSite\PbbCheck::class)->name('pbb');
Route::get('/surat', PublicSite\LetterInfo::class)->name('surat.info');

// Bansos check
Route::get('/bansos', PublicSite\BansosCheck::class)->name('bansos');

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
        Route::get('/pbb', Admin\PbbManagement::class)->name('pbb');
        Route::get('/bansos', Admin\BansosManagement::class)->name('bansos');

        // User management — super_admin only
        Route::get('/users', Admin\UserManagement::class)
            ->middleware('role:super_admin,admin')
            ->name('users');
    });

require __DIR__.'/auth.php';
