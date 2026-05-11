<?php
namespace App\Livewire\Admin;

use App\Models\ActivityLog;
use App\Models\IdmStat;
use App\Models\LetterRequest;
use App\Models\PopulationStat;
use App\Models\Post;
use App\Models\Product;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        $totalPopulation = PopulationStat::latestYear()->value('total_population') ?? 0;
        $totalUmkm = Product::active()->count();
        $totalBerita = Post::published()->count();
        $totalSuratPending = LetterRequest::query()->where('status', 'pending')->count();

        // Surat per month (last 6 months)
        $suratPerMonth = LetterRequest::selectRaw("DATE_FORMAT(created_at, '%Y-%m') as month, COUNT(*) as total")
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('month')->orderBy('month')->pluck('total', 'month');

        // Population breakdown
        $popStats = PopulationStat::latestYear()->first();

        // IDM trend
        $idmStats = IdmStat::orderBy('year')->get();

        // Recent activity
        $recentLogs = ActivityLog::with('user')->latest()->take(10)->get();

        return view('livewire.admin.dashboard', compact(
            'totalPopulation', 'totalUmkm', 'totalBerita', 'totalSuratPending',
            'suratPerMonth', 'popStats', 'idmStats', 'recentLogs'
        ))->layout('layouts.admin', ['title' => 'Dashboard']);
    }
}
