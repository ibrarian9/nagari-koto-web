<?php

use App\Livewire\PublicSite\VisitorCounter;
use App\Models\SiteVisitor;
use App\Models\User;
use Livewire\Livewire;

test('public visit records a new site visitor in database', function () {
    $initialCount = SiteVisitor::count();

    $response = $this->get(route('home'));
    $response->assertOk();

    expect(SiteVisitor::count())->toBeGreaterThan($initialCount);

    $visitor = SiteVisitor::where('visit_date', today())->latest('id')->first();
    expect($visitor)->not->toBeNull()
        ->and($visitor->hits)->toBeGreaterThanOrEqual(1)
        ->and($visitor->last_activity)->not->toBeNull();
});

test('subsequent visits on the same session increment hits and update last_activity', function () {
    $res1 = $this->get(route('home'));
    $res1->assertOk();

    $cookie = $res1->getCookie(config('session.cookie'));
    $visitor = SiteVisitor::where('visit_date', today())->latest('id')->first();
    expect($visitor)->not->toBeNull();
    $firstHits = $visitor->hits;

    if ($cookie) {
        $this->withCookie($cookie->getName(), $cookie->getValue())
            ->get(route('home'))
            ->assertOk();
    }

    $visitor->refresh();
    expect($visitor->hits)->toBeGreaterThan($firstHits);
});

test('admin routes are not counted as public site visitors', function () {
    $admin = User::factory()->create(['role' => 'super_admin']);
    
    // Empty table for clean isolation
    SiteVisitor::truncate();

    $response = $this->actingAs($admin)->get(route('admin.dashboard'));
    $response->assertOk();

    expect(SiteVisitor::count())->toBe(0);
});

test('visitor counter component renders statistics correctly', function () {
    // Create seed visits for yesterday and today
    SiteVisitor::create([
        'session_id' => 'sess_yesterday_1',
        'ip_address' => '127.0.0.1',
        'visit_date' => today()->subDay(),
        'hits' => 3,
        'last_activity' => now()->subDay(),
    ]);

    SiteVisitor::create([
        'session_id' => 'sess_today_active',
        'ip_address' => '127.0.0.2',
        'visit_date' => today(),
        'hits' => 5,
        'last_activity' => now()->subMinute(),
    ]);

    Livewire::test(VisitorCounter::class)
        ->assertSee('Statistik Kunjungan Website')
        ->assertSee('Sedang Online')
        ->assertSee('Hari Ini')
        ->assertSee('Kemarin')
        ->assertSee('Bulan Ini')
        ->assertSee('Total Kunjungan')
        ->assertSee('Pengunjung');

    expect(SiteVisitor::getTodayCount())->toBeGreaterThanOrEqual(1)
        ->and(SiteVisitor::getYesterdayCount())->toBeGreaterThanOrEqual(1)
        ->and(SiteVisitor::getOnlineCount(5))->toBeGreaterThanOrEqual(1)
        ->and(SiteVisitor::getTotalCount())->toBeGreaterThanOrEqual(2);
});

test('home page renders visitor counter component', function () {
    $response = $this->get(route('home'));
    $response->assertOk()
        ->assertSee('Statistik Kunjungan Website')
        ->assertSee('Sedang Online');
});
