<?php
namespace App\Livewire\Admin;
use App\Models\PopulationStat;
use Livewire\Attributes\Validate;
use Livewire\Component;

class PopulationStatForm extends Component
{
    public ?int $editingId = null;
    #[Validate('required|integer|min:2000|max:2100')] public int $year = 2024;
    #[Validate('required|integer|min:0')] public int $total_population = 0;
    #[Validate('required|integer|min:0')] public int $male = 0;
    #[Validate('required|integer|min:0')] public int $female = 0;
    #[Validate('required|integer|min:0')] public int $total_families = 0;
    public array $age_groups = [];
    public array $education = [];
    public array $occupation = [];

    public function mount(): void { $this->loadYear($this->year); }

    public function loadYear(int $year): void
    {
        $this->year = $year;
        $stat = PopulationStat::where('year', $year)->first();
        if ($stat) {
            $this->editingId = $stat->id;
            $this->fill($stat->only(['total_population','male','female','total_families']));
            $this->age_groups = collect($stat->age_group_data ?? [])->map(fn($v,$k) => ['label'=>$k,'value'=>$v])->values()->toArray();
            $this->education = collect($stat->education_data ?? [])->map(fn($v,$k) => ['label'=>$k,'value'=>$v])->values()->toArray();
            $this->occupation = collect($stat->occupation_data ?? [])->map(fn($v,$k) => ['label'=>$k,'value'=>$v])->values()->toArray();
        } else { $this->editingId = null; $this->reset(['total_population','male','female','total_families','age_groups','education','occupation']); }
    }

    public function addRow(string $type): void { $this->{$type}[] = ['label'=>'','value'=>0]; }
    public function removeRow(string $type, int $index): void { unset($this->{$type}[$index]); $this->{$type} = array_values($this->{$type}); }

    public function save(): void
    {
        $this->validate();
        $toAssoc = fn($rows) => collect($rows)->pluck('value','label')->filter(fn($v,$k) => $k !== '')->toArray();
        $data = [
            'year'=>$this->year,'total_population'=>$this->total_population,'male'=>$this->male,'female'=>$this->female,'total_families'=>$this->total_families,
            'age_group_data'=>json_encode($toAssoc($this->age_groups)),
            'education_data'=>json_encode($toAssoc($this->education)),
            'occupation_data'=>json_encode($toAssoc($this->occupation)),
        ];
        PopulationStat::updateOrCreate(['year'=>$this->year], $data);
        $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Data infografis tahun '.$this->year.' berhasil disimpan.');
    }

    public function render() {
        $years = PopulationStat::orderByDesc('year')->pluck('year');
        return view('livewire.admin.population-stat-form', compact('years'))->layout('layouts.admin', ['title' => 'Infografis Penduduk']);
    }
}
