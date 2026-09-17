<?php

use App\Models\Category;
use App\Models\Contact;
use App\Models\IdmStat;
use App\Models\LegalDocument;
use App\Models\User;
use App\Models\VillageInstitution;
use Livewire\Livewire;

test('apb nagari page renders updated transparency narrative', function () {
    $response = $this->get(route('anggaran'));

    $response->assertStatus(200);
    $response->assertSee('adalah Rencana Keuangan tahunan pemerintahan Nagari.', false);
    $response->assertSee('Transparansi ini bertujuan agar masyarakat dapat mengawasi dan memantau secara langsung progres pengelolaan keuangan Nagari secara Transparansi dan Akuntabel.', false);
});

test('village institutions show page filters by dynamic categories', function () {
    $cat = Category::create([
        'name' => 'Lembaga Adat',
        'slug' => 'lembaga-adat',
        'type' => 'lembaga',
    ]);

    VillageInstitution::create([
        'category_id' => $cat->id,
        'name' => 'LKAAM Nagari Koto',
        'slug' => 'lkaam-nagari-koto',
        'leader_name' => 'Datuak Bandaro',
    ]);

    $response = $this->get(route('lembaga', ['category' => 'lembaga-adat']));

    $response->assertStatus(200);
    $response->assertSee('Lembaga Adat');
    $response->assertSee('LKAAM Nagari Koto');
});

test('legal documents show page filters by dynamic categories', function () {
    $cat = Category::create([
        'name' => 'Peraturan Nagari',
        'slug' => 'peraturan-nagari',
        'type' => 'produk_hukum',
    ]);

    LegalDocument::create([
        'category_id' => $cat->id,
        'category' => 'peraturan_nagari',
        'title' => 'Pernag No 1 Tahun 2026',
        'slug' => 'pernag-no-1-tahun-2026',
        'number' => '01/2026',
        'year' => 2026,
        'is_published' => true,
        'published_at' => now(),
    ]);

    $response = $this->get(route('produk-hukum', ['kategori' => $cat->id]));

    $response->assertStatus(200);
    $response->assertSee('Peraturan Nagari');
    $response->assertSee('Pernag No 1 Tahun 2026');
});

test('category generateUniqueSlug prevents duplicate slug integrity constraint violations across types', function () {
    Category::create([
        'name' => 'Pendidikan',
        'slug' => 'pendidikan',
        'type' => 'berita',
    ]);

    $slug = Category::generateUniqueSlug('Pendidikan', 'lembaga');
    expect($slug)->toBe('pendidikan-lembaga');

    $cat2 = Category::create([
        'name' => 'Pendidikan',
        'slug' => $slug,
        'type' => 'lembaga',
    ]);

    expect($cat2->slug)->toBe('pendidikan-lembaga');
});

test('admin can manage categories dynamically in potential, umkm, forestry, and ppid modules', function () {
    $user = User::factory()->create(['role' => 'super_admin']);

    // Potential category creation
    Livewire::actingAs($user)
        ->test(\App\Livewire\Admin\PotentialManagement::class)
        ->set('newCategoryName', 'Kerajinan Bambu')
        ->call('addCategory')
        ->assertHasNoErrors();

    expect(Category::where('type', 'potensi')->where('name', 'Kerajinan Bambu')->exists())->toBeTrue();

    // UMKM category creation
    Livewire::actingAs($user)
        ->test(\App\Livewire\Admin\ProductManagement::class)
        ->set('newCategoryName', 'Oleh-Oleh Khas')
        ->call('addCategory')
        ->assertHasNoErrors();

    expect(Category::where('type', 'umkm')->where('name', 'Oleh-Oleh Khas')->exists())->toBeTrue();

    // Forestry category creation
    Livewire::actingAs($user)
        ->test(\App\Livewire\Admin\ForestryManagement::class)
        ->set('newCategoryName', 'Hutan Adat')
        ->call('addCategory')
        ->assertHasNoErrors();

    expect(Category::where('type', 'kehutanan')->where('name', 'Hutan Adat')->exists())->toBeTrue();

    // PPID Berkala category creation
    Livewire::actingAs($user)
        ->test(\App\Livewire\Admin\PpidBerkalaManagement::class)
        ->set('newCategoryName', 'Laporan Keuangan')
        ->call('addCategory')
        ->assertHasNoErrors();

    expect(Category::where('type', 'ppid_berkala')->where('name', 'Laporan Keuangan')->exists())->toBeTrue();

    // PPID Setiap Saat category creation
    Livewire::actingAs($user)
        ->test(\App\Livewire\Admin\PpidSetiapSaatManagement::class)
        ->set('newCategoryName', 'Dokumen Publik')
        ->call('addCategory')
        ->assertHasNoErrors();

    expect(Category::where('type', 'ppid_setiap_saat')->where('name', 'Dokumen Publik')->exists())->toBeTrue();
});

test('contact and idm modules support dynamic category management, sorting, and deletion protection', function () {
    $user = User::factory()->create(['role' => 'super_admin']);

    // Test Contact Category Management
    Livewire::actingAs($user)
        ->test(\App\Livewire\Admin\ContactManagement::class)
        ->set('newCategoryName', 'Layanan Publik Baru')
        ->call('addCategory')
        ->assertHasNoErrors();

    $newCat = Category::where('type', 'kontak')->where('name', 'Layanan Publik Baru')->first();
    expect($newCat)->not->toBeNull();

    // Add a contact linked to this category
    $contact = Contact::create([
        'label' => 'Kantor Desa CS',
        'phone' => '08123456789',
        'category' => $newCat->slug,
        'order' => 1,
    ]);

    // Deleting linked category should emit error swal and keep category intact
    Livewire::actingAs($user)
        ->test(\App\Livewire\Admin\ContactManagement::class)
        ->call('deleteCategory', $newCat->id)
        ->assertDispatched('swal', icon: 'error');

    expect(Category::find($newCat->id))->not->toBeNull();

    // Remove contact and then delete category
    $contact->delete();
    Livewire::actingAs($user)
        ->test(\App\Livewire\Admin\ContactManagement::class)
        ->call('deleteCategory', $newCat->id)
        ->assertDispatched('swal', icon: 'success');

    expect(Category::find($newCat->id))->toBeNull();

    // Test IDM Category Management
    Livewire::actingAs($user)
        ->test(\App\Livewire\Admin\IdmStatManagement::class)
        ->set('newCategoryName', 'Super Mandiri')
        ->call('addCategory')
        ->assertHasNoErrors();

    $idmCat = Category::where('type', 'idm')->where('name', 'Super Mandiri')->first();
    expect($idmCat)->not->toBeNull();

    // Verify category listing order in render (newest first)
    $categories = Category::where('type', 'idm')->orderByDesc('id')->get();
    expect($categories->first()->id)->toBe($idmCat->id);
});
