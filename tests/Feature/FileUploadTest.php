<?php

use App\Livewire\Admin\LegalDocumentManagement;
use App\Livewire\Admin\PpidContentManagement;
use App\Livewire\PublicSite\LetterRequestForm;
use App\Models\PpidContent;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

uses(RefreshDatabase::class);

beforeEach(function () {
    Storage::fake('public');
});

it('accepts pdf under 2mb in ppid content management', function () {
    $user = User::factory()->create(['role' => 'admin']);
    $pdf = UploadedFile::fake()->create('dokumen_dikecualikan.pdf', 1024, 'application/pdf');

    Livewire::actingAs($user)
        ->test(PpidContentManagement::class)
        ->set('activeTab', 'dikecualikan')
        ->set('title', 'Info Dikecualikan Test')
        ->set('content', 'Deskripsi info dikecualikan')
        ->set('attachmentUpload', $pdf)
        ->call('save')
        ->assertHasNoErrors();

    $content = PpidContent::where('type', 'dikecualikan')->first();
    expect($content)->not->toBeNull();
    expect($content->attachment)->not->toBeNull();
    Storage::disk('public')->assertExists($content->attachment);
});

it('rejects pdf over 2mb in ppid content management', function () {
    $user = User::factory()->create(['role' => 'admin']);
    $pdf = UploadedFile::fake()->create('dokumen_besar.pdf', 3072, 'application/pdf');

    Livewire::actingAs($user)
        ->test(PpidContentManagement::class)
        ->set('activeTab', 'dikecualikan')
        ->set('attachmentUpload', $pdf)
        ->call('save')
        ->assertHasErrors(['attachmentUpload' => 'max']);
});

it('accepts image under 2mb in ppid content management', function () {
    $user = User::factory()->create(['role' => 'admin']);
    $image = UploadedFile::fake()->image('maklumat.png', 800, 600)->size(1024);

    Livewire::actingAs($user)
        ->test(PpidContentManagement::class)
        ->set('activeTab', 'maklumat')
        ->set('title', 'Maklumat Pelayanan')
        ->set('imageUpload', $image)
        ->call('save')
        ->assertHasNoErrors();

    $content = PpidContent::where('type', 'maklumat')->first();
    expect($content)->not->toBeNull();
    expect($content->image)->not->toBeNull();
    Storage::disk('public')->assertExists($content->image);
});

it('rejects image over 2mb in ppid content management', function () {
    $user = User::factory()->create(['role' => 'admin']);
    $image = UploadedFile::fake()->image('foto_besar.jpg', 1200, 1200)->size(3072);

    Livewire::actingAs($user)
        ->test(PpidContentManagement::class)
        ->set('activeTab', 'maklumat')
        ->set('imageUpload', $image)
        ->call('save')
        ->assertHasErrors(['imageUpload' => 'max']);
});

it('accepts ktp and nikah form under 2mb in public letter request form', function () {
    $user = User::factory()->create();
    $ktp1 = UploadedFile::fake()->image('ktp_pria.jpg')->size(1024);
    $ktp2 = UploadedFile::fake()->image('ktp_wanita.jpg')->size(1024);
    $nikahPdf = UploadedFile::fake()->create('formulir_n1.pdf', 1500, 'application/pdf');

    Livewire::actingAs($user)
        ->test(LetterRequestForm::class)
        ->set('letter_type', 'surat_pengantar_nikah')
        ->set('full_name', 'Ahmad Test')
        ->set('nik', '1234567890123456')
        ->set('address', 'Jalan Nagari Duo Koto')
        ->set('ktp_image', $ktp1)
        ->set('ktp_image_2', $ktp2)
        ->set('nikah_form_image', $nikahPdf)
        ->call('submit')
        ->assertHasNoErrors()
        ->assertSet('submitted', true);
});

it('rejects nikah form over 2mb in public letter request form', function () {
    $user = User::factory()->create();
    $ktp1 = UploadedFile::fake()->image('ktp_pria.jpg')->size(1024);
    $ktp2 = UploadedFile::fake()->image('ktp_wanita.jpg')->size(1024);
    $nikahPdf = UploadedFile::fake()->create('formulir_n1_besar.pdf', 3072, 'application/pdf');

    Livewire::actingAs($user)
        ->test(LetterRequestForm::class)
        ->set('letter_type', 'surat_pengantar_nikah')
        ->set('full_name', 'Ahmad Test')
        ->set('nik', '1234567890123456')
        ->set('address', 'Jalan Nagari Duo Koto')
        ->set('ktp_image', $ktp1)
        ->set('ktp_image_2', $ktp2)
        ->set('nikah_form_image', $nikahPdf)
        ->call('submit')
        ->assertHasErrors(['nikah_form_image' => 'max']);
});

it('accepts pdf under 2mb in legal document management', function () {
    $user = User::factory()->create(['role' => 'admin']);
    $pdf = UploadedFile::fake()->create('pernag_2024.pdf', 1024, 'application/pdf');

    Livewire::actingAs($user)
        ->test(LegalDocumentManagement::class)
        ->set('title', 'Peraturan Nagari No 1')
        ->set('category', 'perdes')
        ->set('year', 2024)
        ->set('file', $pdf)
        ->call('save')
        ->assertHasNoErrors();
});

it('rejects pdf over 2mb in legal document management', function () {
    $user = User::factory()->create(['role' => 'admin']);
    $pdf = UploadedFile::fake()->create('pernag_besar.pdf', 3072, 'application/pdf');

    Livewire::actingAs($user)
        ->test(LegalDocumentManagement::class)
        ->set('title', 'Peraturan Nagari No 1')
        ->set('category', 'perdes')
        ->set('year', 2024)
        ->set('file', $pdf)
        ->call('save')
        ->assertHasErrors(['file' => 'max']);
});


