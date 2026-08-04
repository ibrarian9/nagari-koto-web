<?php

use App\Livewire\Admin\ProductManagement;
use App\Livewire\PublicSite\UmkmDetail;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

it('renders public umkm detail page for active product', function () {
    $product = Product::create([
        'owner_name' => 'Ibu Rahma',
        'business_name' => 'Kerajinan Anyaman Pandan',
        'category' => 'Kerajinan',
        'description' => 'Produk tas dan tikar pandan khas Nagari Koto.',
        'whatsapp' => '081234567890',
        'address' => 'Jorong Koto Tinggi',
        'is_active' => true,
    ]);

    Livewire::test(UmkmDetail::class, ['id' => $product->id])
        ->assertStatus(200)
        ->assertSee('Kerajinan Anyaman Pandan')
        ->assertSee('Ibu Rahma')
        ->assertSee('Jorong Koto Tinggi');
});

it('opens admin detail modal for product management', function () {
    $user = User::factory()->create(['role' => 'admin']);
    $product = Product::create([
        'owner_name' => 'Pak Ahmad',
        'business_name' => 'Kopi Robusta Nagari',
        'category' => 'Minuman',
        'description' => 'Kopi petik merah asli kebun Nagari Koto.',
        'is_active' => true,
    ]);

    Livewire::actingAs($user)
        ->test(ProductManagement::class)
        ->call('viewDetail', $product->id)
        ->assertSet('showDetailModal', true)
        ->assertSee('Kopi Robusta Nagari')
        ->assertSee('Pak Ahmad');
});
