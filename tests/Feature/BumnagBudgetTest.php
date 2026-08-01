<?php

use App\Livewire\Admin\BumnagBudgetManagement;
use App\Models\BumnagBudget;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

it('renders bumnag budget management component for admin', function () {
    $user = User::factory()->create(['role' => 'admin']);

    Livewire::actingAs($user)
        ->test(BumnagBudgetManagement::class)
        ->assertStatus(200);
});

it('saves bumnag budget data with long keterangan text', function () {
    $user = User::factory()->create(['role' => 'admin']);
    $longText = str_repeat('Narasi penggunaan anggaran BUMNag untuk pembangunan unit usaha desa. ', 100);

    Livewire::actingAs($user)
        ->test(BumnagBudgetManagement::class)
        ->set('year', 2024)
        ->set('total_income', 500000000)
        ->set('total_expenditure', 450000000)
        ->set('realization_pct', 90.00)
        ->set('keterangan', $longText)
        ->set('apbdes_rows', [
            ['label' => 'Unit Perdagangan', 'value' => 300000000],
            ['label' => 'Unit Jasa', 'value' => 200000000],
        ])
        ->call('save')
        ->assertHasNoErrors();

    $budget = BumnagBudget::where('year', 2024)->first();
    expect($budget)->not->toBeNull();
    expect($budget->total_income)->toBe(500000000);
    expect($budget->keterangan)->toBe($longText);
});

it('rejects keterangan text exceeding 65000 characters', function () {
    $user = User::factory()->create(['role' => 'admin']);
    $excessiveText = str_repeat('a', 65001);

    Livewire::actingAs($user)
        ->test(BumnagBudgetManagement::class)
        ->set('year', 2024)
        ->set('total_income', 100000000)
        ->set('total_expenditure', 90000000)
        ->set('keterangan', $excessiveText)
        ->call('save')
        ->assertHasErrors(['keterangan' => 'max']);
});

it('can update existing bumnag budget record', function () {
    $user = User::factory()->create(['role' => 'admin']);
    $budget = BumnagBudget::create([
        'year' => 2023,
        'total_income' => 200000000,
        'total_expenditure' => 180000000,
        'realization_pct' => 90.00,
        'keterangan' => 'Keterangan lama',
    ]);

    Livewire::actingAs($user)
        ->test(BumnagBudgetManagement::class)
        ->call('edit', $budget->id)
        ->set('keterangan', 'Keterangan baru diperbarui')
        ->call('save')
        ->assertHasNoErrors();

    expect($budget->fresh()->keterangan)->toBe('Keterangan baru diperbarui');
});

it('can delete bumnag budget record', function () {
    $user = User::factory()->create(['role' => 'admin']);
    $budget = BumnagBudget::create([
        'year' => 2022,
        'total_income' => 100000000,
        'total_expenditure' => 90000000,
        'realization_pct' => 85.00,
    ]);

    Livewire::actingAs($user)
        ->test(BumnagBudgetManagement::class)
        ->call('delete', $budget->id)
        ->assertHasNoErrors();

    expect(BumnagBudget::find($budget->id))->toBeNull();
});
