<?php
namespace App\Livewire\PublicSite;
use App\Models\BudgetStat;
use Livewire\Component;

class BudgetStats extends Component
{
    public int $selectedYear = 0;

    public function mount(): void
    {
        $this->selectedYear = BudgetStat::latestYear()->value('year') ?? (int) date('Y');
    }

    public function render()
    {
        $stat = BudgetStat::query()->where('year', $this->selectedYear)->first();
        $years = BudgetStat::orderByDesc('year')->pluck('year');
        return view('livewire.public.budget-stats', compact('stat', 'years'))
            ->layout('layouts.app', ['title' => 'Anggaran Desa']);
    }
}
