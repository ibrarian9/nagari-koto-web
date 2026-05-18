<?php

use App\Livewire\Admin;
use App\Livewire\PublicSite;
use App\Http\Controllers\MidtransWebhookController;
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

Route::get('/bansos', PublicSite\BansosLink::class)->name('bansos');
Route::get('/kehutanan', PublicSite\ForestryInfo::class)->name('kehutanan');
Route::get('/bamus', PublicSite\BamusInfo::class)->name('bamus');
Route::get('/lembaga', PublicSite\InstitutionInfo::class)->name('lembaga');
Route::get('/donasi', PublicSite\DonationPage::class)->name('donasi');
Route::get('/donasi/{slug}', PublicSite\DonationDetail::class)->name('donasi.detail');

// Midtrans webhook (no CSRF)
Route::post('/api/midtrans/webhook', [MidtransWebhookController::class, 'handle'])
    ->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class])
    ->name('midtrans.webhook');

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
        Route::get('/kehutanan', Admin\ForestryManagement::class)->name('kehutanan');
        Route::get('/bamus', Admin\BamusManagement::class)->name('bamus');
        Route::get('/lembaga', Admin\InstitutionManagement::class)->name('lembaga');
        Route::get('/donasi', Admin\CampaignManagement::class)->name('donasi');

        // User management — super_admin only
        Route::get('/users', Admin\UserManagement::class)
            ->middleware('role:super_admin,admin')
            ->name('users');
    });

require __DIR__.'/auth.php';
