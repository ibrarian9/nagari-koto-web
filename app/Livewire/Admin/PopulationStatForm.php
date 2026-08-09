<?php

namespace App\Livewire\Admin;

use App\Models\PopulationStat;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class PopulationStatForm extends Component
{
    public ?int $editingId = null;

    #[Validate('required|integer|min:2000|max:2100')]
    public int $year = 2026;

    #[Validate('required|integer|min:0')]
    public int $total_population = 0;

    #[Validate('required|integer|min:0')]
    public int $male = 0;

    #[Validate('required|integer|min:0')]
    public int $female = 0;

    #[Validate('required|integer|min:0')]
    public int $total_families = 0;

    public array $age_groups = [];
    public array $education = [];
    public array $occupation = [];

    public bool $showNewYearModal = false;
    public ?int $newYearInput = null;

    public function mount(): void
    {
        $latest = PopulationStat::orderByDesc('year')->value('year') ?? (int) date('Y');
        $this->loadYear($latest);
    }

    public function openNewYearModal(): void
    {
        $latest = PopulationStat::orderByDesc('year')->value('year') ?? (int) date('Y');
        $this->newYearInput = $latest + 1;
        $this->showNewYearModal = true;
    }

    public function createNewYear(): void
    {
        $this->validate([
            'newYearInput' => 'required|integer|min:2000|max:2100',
        ]);

        $year = (int) $this->newYearInput;
        $this->showNewYearModal = false;
        $this->loadYear($year);

        $this->dispatch('swal', icon: 'info', title: 'Tahun Baru Dibuat', text: "Form infografis untuk tahun {$year} siap diisi.");
    }

    public function loadYear(int $year): void
    {
        $this->year = $year;
        $stat = PopulationStat::where('year', $year)->first();

        if ($stat) {
            $this->editingId = $stat->id;
            $this->fill($stat->only(['total_population', 'male', 'female', 'total_families']));

            $ageData = is_string($stat->age_group_data) ? json_decode($stat->age_group_data, true) : ($stat->age_group_data ?? []);
            $eduData = is_string($stat->education_data) ? json_decode($stat->education_data, true) : ($stat->education_data ?? []);
            $occData = is_string($stat->occupation_data) ? json_decode($stat->occupation_data, true) : ($stat->occupation_data ?? []);

            $this->age_groups = collect($ageData)->map(fn($v, $k) => ['label' => $k, 'value' => $v])->values()->toArray();
            $this->education = collect($eduData)->map(fn($v, $k) => ['label' => $k, 'value' => $v])->values()->toArray();
            $this->occupation = collect($occData)->map(fn($v, $k) => ['label' => $k, 'value' => $v])->values()->toArray();
        } else {
            $this->editingId = null;
            $this->reset(['total_population', 'male', 'female', 'total_families']);

            // Default template rows for new year
            $this->age_groups = [
                ['label' => '0 - 4 Tahun', 'value' => 0],
                ['label' => '5 - 14 Tahun', 'value' => 0],
                ['label' => '15 - 64 Tahun', 'value' => 0],
                ['label' => '65+ Tahun', 'value' => 0],
            ];
            $this->education = [
                ['label' => 'SD / Sederajat', 'value' => 0],
                ['label' => 'SMP / Sederajat', 'value' => 0],
                ['label' => 'SMA / Sederajat', 'value' => 0],
                ['label' => 'Diploma / Sarjana', 'value' => 0],
            ];
            $this->occupation = [
                ['label' => 'Petani / Pekebun', 'value' => 0],
                ['label' => 'Pedagang / UMKM', 'value' => 0],
                ['label' => 'PNS / TNI / Polri', 'value' => 0],
                ['label' => 'Swasta / Buruh', 'value' => 0],
            ];
        }
    }

    public function addRow(string $type): void
    {
        $this->{$type}[] = ['label' => '', 'value' => 0];
    }

    public function removeRow(string $type, int $index): void
    {
        unset($this->{$type}[$index]);
        $this->{$type} = array_values($this->{$type});
    }

    public function save(): void
    {
        $this->validate();

        $toAssoc = fn($rows) => collect($rows)
            ->pluck('value', 'label')
            ->filter(fn($v, $k) => trim($k) !== '')
            ->toArray();

        $data = [
            'year' => $this->year,
            'total_population' => $this->total_population,
            'male' => $this->male,
            'female' => $this->female,
            'total_families' => $this->total_families,
            'age_group_data' => $toAssoc($this->age_groups),
            'education_data' => $toAssoc($this->education),
            'occupation_data' => $toAssoc($this->occupation),
        ];

        PopulationStat::updateOrCreate(['year' => $this->year], $data);

        $this->loadYear($this->year);
        $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Data infografis tahun ' . $this->year . ' berhasil disimpan.');
    }

    #[On('deleteYearConfirmed')]
    public function deleteYear(int $year): void
    {
        PopulationStat::where('year', $year)->delete();

        $latest = PopulationStat::orderByDesc('year')->value('year') ?? (int) date('Y');
        $this->loadYear($latest);

        $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: "Data infografis tahun {$year} berhasil dihapus.");
    }

    public function render()
    {
        $years = PopulationStat::orderByDesc('year')
            ->pluck('year')
            ->push($this->year)
            ->unique()
            ->sortDesc()
            ->values();

        return view('livewire.admin.population-stat-form', [
            'years' => $years,
        ])->layout('layouts.admin', ['title' => 'Infografis Penduduk']);
    }
}
