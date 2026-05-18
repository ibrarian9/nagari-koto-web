<?php

namespace App\Livewire\PublicSite;

use App\Models\ForestryRecord;
use App\Models\VillageProfile;
use Livewire\Component;

class ForestryInfo extends Component
{
    public string $categoryFilter = '';

    public function render()
    {
        $records = ForestryRecord::query()
            ->when($this->categoryFilter, fn($q) => $q->byCategory($this->categoryFilter))
            ->latest('year')
            ->get();

        $village = VillageProfile::first();

        $summary = [
            'total_area'  => ForestryRecord::sum('area_ha'),
            'total_zones' => ForestryRecord::count(),
            'aktif'       => ForestryRecord::where('status', 'aktif')->count(),
            'kritis'      => ForestryRecord::where('status', 'kritis')->count(),
            'pemulihan'   => ForestryRecord::where('status', 'dalam_pemulihan')->count(),
        ];

        // Group by category for chart-like display
        $byCategory = ForestryRecord::selectRaw('category, COUNT(*) as total, SUM(area_ha) as total_area')
            ->groupBy('category')
            ->get()
            ->keyBy('category');

        return view('livewire.public.forestry-info', compact('records', 'village', 'summary', 'byCategory'))
            ->layout('layouts.app', ['title' => 'Data Kehutanan']);
    }
}
