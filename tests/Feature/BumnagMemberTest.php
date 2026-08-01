<?php

use App\Livewire\Admin\BumnagMemberManagement;
use App\Models\BumnagMember;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

it('can save bumnag member with role_type pembina', function () {
    $user = User::factory()->create(['role' => 'admin']);

    Livewire::actingAs($user)
        ->test(BumnagMemberManagement::class)
        ->set('name', 'Bpk. Prof. Dr. H. Ahmad')
        ->set('position', 'Pembina Utama BUMNag')
        ->set('role_type', 'pembina')
        ->set('period', '2024-2029')
        ->call('save')
        ->assertHasNoErrors();

    $member = BumnagMember::where('role_type', 'pembina')->first();
    expect($member)->not->toBeNull();
    expect($member->name)->toBe('Bpk. Prof. Dr. H. Ahmad');
    expect($member->role_type)->toBe('pembina');
});

it('can update existing bumnag member to role_type pembina', function () {
    $user = User::factory()->create(['role' => 'admin']);
    $member = BumnagMember::create([
        'name' => 'Dr. Ir. Budi',
        'position' => 'Penasehat',
        'role_type' => 'pengurus',
        'is_active' => true,
    ]);

    Livewire::actingAs($user)
        ->test(BumnagMemberManagement::class)
        ->call('edit', $member->id)
        ->set('role_type', 'pembina')
        ->call('save')
        ->assertHasNoErrors();

    expect($member->fresh()->role_type)->toBe('pembina');
});
