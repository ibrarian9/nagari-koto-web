<?php

use App\Models\Category;
use App\Models\IdmStat;
use App\Models\Post;
use App\Models\User;
use App\Models\VillageProfile;
use Illuminate\Support\Str;

test('post og_image_url returns absolute url with thumbnail or village logo fallback', function () {
    $user = User::factory()->create();
    $category = Category::create(['name' => 'Umum', 'slug' => 'umum', 'type' => 'berita']);

    // Post with thumbnail
    $postWithThumb = Post::create([
        'category_id' => $category->id,
        'user_id' => $user->id,
        'title' => 'Berita Bergambar',
        'slug' => 'berita-bergambar',
        'excerpt' => 'Ringkasan berita',
        'body' => '<p>Isi berita lengkap</p>',
        'thumbnail' => 'posts/sample.jpg',
        'status' => 'published',
        'published_at' => now(),
    ]);

    expect($postWithThumb->og_image_url)->toContain('http')
        ->and($postWithThumb->og_image_url)->toContain('posts/sample.jpg');

    // Post without thumbnail
    $postNoThumb = Post::create([
        'category_id' => $category->id,
        'user_id' => $user->id,
        'title' => 'Berita Tanpa Gambar',
        'slug' => 'berita-tanpa-gambar',
        'excerpt' => 'Ringkasan berita tanpa gambar',
        'body' => '<p>Isi berita tanpa gambar</p>',
        'thumbnail' => null,
        'status' => 'published',
        'published_at' => now(),
    ]);

    expect($postNoThumb->og_image_url)->toContain('http');
});

test('news detail page renders open graph and whatsapp meta tags dynamically', function () {
    $user = User::factory()->create();
    $category = Category::create(['name' => 'Pengumuman', 'slug' => 'pengumuman', 'type' => 'berita']);

    $post = Post::create([
        'category_id' => $category->id,
        'user_id' => $user->id,
        'title' => 'Pengumuman Penting Nagari',
        'slug' => 'pengumuman-penting-nagari',
        'excerpt' => 'Ini adalah ringkasan pengumuman penting.',
        'body' => '<p>Isi detail pengumuman penting nagari.</p>',
        'thumbnail' => 'posts/pengumuman.jpg',
        'status' => 'published',
        'published_at' => now(),
    ]);

    $response = $this->get(route('berita.show', $post->slug));

    $response->assertStatus(200);
    $response->assertSee('og:image', false);
    $response->assertSee('posts/pengumuman.jpg', false);
    $response->assertSee('og:image:secure_url', false);
    $response->assertSee('og:title', false);
    $response->assertSee('og:description', false);
    $response->assertSee('twitter:image', false);
    $response->assertSee('twitter:card', false);
    $response->assertSee('Pengumuman Penting Nagari', false);
});

test('idm score formats decimal scores under 1 to integer without leading zero', function () {
    $stat1 = new IdmStat(['score' => 0.170]);
    expect($stat1->formatted_score)->toBe('170');

    $stat2 = new IdmStat(['score' => 0.742]);
    expect($stat2->formatted_score)->toBe('742');

    $stat3 = new IdmStat(['score' => 170]);
    expect($stat3->formatted_score)->toBe('170');

    expect(IdmStat::formatIdmScore(0.170))->toBe('170');
    expect(IdmStat::formatIdmScore(0.785))->toBe('785');
});

test('idm stats page displays formatted score and dimension scores without 0. prefix', function () {
    IdmStat::create([
        'year' => 2025,
        'score' => 0.742,
        'status' => 'maju',
        'social_score' => 0.785,
        'economic_score' => 0.692,
        'environment_score' => 0.750,
        'accessibility_score' => 0.768,
        'basic_service_score' => 0.812,
        'governance_score' => 0.735,
    ]);

    $response = $this->get(route('idm'));

    $response->assertStatus(200);
    $response->assertSee('742');
    $response->assertSee('785');
    $response->assertSee('692');
    $response->assertSee('750');
    $response->assertSee('768');
    $response->assertSee('812');
    $response->assertSee('735');
    $response->assertDontSee('0.785');
    $response->assertDontSee('0.692');
});
