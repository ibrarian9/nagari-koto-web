<?php

use App\Livewire\Admin\ActivityLogViewer;
use App\Models\ActivityLog;
use App\Models\BudgetStat;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

test('activity log automatically records created, updated, and deleted model events with client ip address', function () {
    $user = User::factory()->create([
        'role' => 'super_admin',
    ]);

    $this->actingAs($user);

    // Create model
    $budget = BudgetStat::create([
        'year' => 2026,
        'total_income' => 1000000,
        'total_expenditure' => 800000,
        'realization_pct' => 80,
        'apbdes_data' => ['PAD' => 1000000],
    ]);

    $this->assertDatabaseHas('activity_logs', [
        'user_id' => $user->id,
        'action' => 'created',
        'model_type' => BudgetStat::class,
        'model_id' => $budget->id,
    ]);

    // Update model
    $budget->update(['total_income' => 1200000]);

    $this->assertDatabaseHas('activity_logs', [
        'user_id' => $user->id,
        'action' => 'updated',
        'model_type' => BudgetStat::class,
        'model_id' => $budget->id,
    ]);

    // Delete model
    $budget->delete();

    $this->assertDatabaseHas('activity_logs', [
        'user_id' => $user->id,
        'action' => 'deleted',
        'model_type' => BudgetStat::class,
        'model_id' => $budget->id,
    ]);
});

test('activity log viewer displays logs in reverse chronological order (newest first)', function () {
    $user = User::factory()->create([
        'role' => 'super_admin',
    ]);

    $log1 = ActivityLog::create([
        'user_id' => $user->id,
        'action' => 'created',
        'model_type' => BudgetStat::class,
        'model_id' => 1,
        'description' => 'Log Pertama (Lama)',
        'created_at' => now()->subHour(),
    ]);

    $log2 = ActivityLog::create([
        'user_id' => $user->id,
        'action' => 'updated',
        'model_type' => BudgetStat::class,
        'model_id' => 1,
        'description' => 'Log Kedua (Terbaru)',
        'created_at' => now(),
    ]);

    Livewire::actingAs($user)
        ->test(ActivityLogViewer::class)
        ->assertSeeInOrder(['Log Kedua (Terbaru)', 'Log Pertama (Lama)']);
});

test('activity log viewer filters logs by action, model type, and search query', function () {
    $user = User::factory()->create([
        'role' => 'super_admin',
    ]);

    ActivityLog::create([
        'user_id' => $user->id,
        'action' => 'created',
        'model_type' => BudgetStat::class,
        'model_id' => 1,
        'description' => 'Membuat Anggaran Nagari',
    ]);

    ActivityLog::create([
        'user_id' => $user->id,
        'action' => 'deleted',
        'model_type' => User::class,
        'model_id' => 2,
        'description' => 'Menghapus User Budi',
    ]);

    Livewire::actingAs($user)
        ->test(ActivityLogViewer::class)
        ->set('search', 'Anggaran')
        ->assertSee('Membuat Anggaran Nagari')
        ->assertDontSee('Menghapus User Budi')
        ->set('search', '')
        ->set('actionFilter', 'deleted')
        ->assertSee('Menghapus User Budi')
        ->assertDontSee('Membuat Anggaran Nagari');
});
