<?php

namespace App\Livewire\Admin;

use App\Models\Donation;
use App\Models\DonationCampaign;
use App\Services\ImageOptimizer;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class CampaignManagement extends Component
{
    use WithFileUploads, WithPagination;

    public bool $showForm = false;
    public bool $showDonations = false;
    public ?int $editingId = null;
    public ?int $viewingCampaignId = null;
    public string $search = '';

    #[Validate('required|string|max:255')]
    public string $title = '';
    #[Validate('nullable|string')]
    public ?string $description = '';
    #[Validate('required|numeric|min:100000')]
    public $target_amount = '';
    #[Validate('required|date')]
    public string $start_date = '';
    #[Validate('nullable|date|after_or_equal:start_date')]
    public ?string $end_date = '';
    #[Validate('required|in:active,completed,closed')]
    public string $status = 'active';
    #[Validate('nullable|image|mimes:jpg,jpeg,png,webp|max:2048')]
    public $thumbnail = null;
    public ?string $existingThumbnail = null;

    public function create(): void
    {
        $user = auth()->user();
        if (!$user->isSuperAdmin() && !$user->isOperator()) {
            $this->dispatch('swal', icon: 'error', title: 'Akses Ditolak', text: 'Hanya Super Admin dan Operator yang dapat membuat campaign.');
            return;
        }
        $this->resetForm();
        $this->start_date = date('Y-m-d');
        $this->showForm = true;
    }

    public function edit(int $id): void
    {
        $user = auth()->user();
        if (!$user->isSuperAdmin() && !$user->isOperator()) {
            $this->dispatch('swal', icon: 'error', title: 'Akses Ditolak', text: 'Hanya Super Admin dan Operator yang dapat mengedit campaign.');
            return;
        }
        $c = DonationCampaign::findOrFail($id);
        $this->editingId = $c->id;
        $this->fill($c->only(['title', 'description', 'target_amount', 'status']));
        $this->start_date = $c->start_date->format('Y-m-d');
        $this->end_date = $c->end_date?->format('Y-m-d') ?? '';
        $this->existingThumbnail = $c->thumbnail;
        $this->showForm = true;
    }

    public function save(): void
    {
        $user = auth()->user();
        if (!$user->isSuperAdmin() && !$user->isOperator()) {
            $this->dispatch('swal', icon: 'error', title: 'Akses Ditolak', text: 'Anda tidak memiliki izin.');
            return;
        }

        $this->validate();
        $data = [
            'title'         => $this->title,
            'slug'          => Str::slug($this->title) . '-' . Str::random(5),
            'description'   => $this->description,
            'target_amount' => $this->target_amount,
            'start_date'    => $this->start_date,
            'end_date'      => $this->end_date ?: null,
            'status'        => $this->status,
        ];

        if ($this->thumbnail) {
            $data['thumbnail'] = (new ImageOptimizer())->optimize($this->thumbnail, 'campaigns', 'thumbnail');
        }

        if ($this->editingId) {
            unset($data['slug']);
            DonationCampaign::findOrFail($this->editingId)->update($data);
        } else {
            $data['created_by'] = $user->id;
            DonationCampaign::create($data);
        }

        $this->resetForm();
        $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Campaign berhasil disimpan.');
    }

    #[On('deleteConfirmed')]
    public function delete(int $id): void
    {
        $user = auth()->user();
        if (!$user->isSuperAdmin() && !$user->isOperator()) {
            $this->dispatch('swal', icon: 'error', title: 'Akses Ditolak', text: 'Anda tidak memiliki izin.');
            return;
        }
        DonationCampaign::findOrFail($id)->delete();
        $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Campaign berhasil dihapus.');
    }

    public function viewDonations(int $id): void
    {
        $this->viewingCampaignId = $id;
        $this->showDonations = true;
    }

    private function resetForm(): void
    {
        $this->reset(['showForm', 'editingId', 'title', 'description', 'target_amount', 'start_date', 'end_date', 'status', 'thumbnail', 'existingThumbnail']);
        $this->status = 'active';
    }

    public function render()
    {
        $campaigns = DonationCampaign::withCount(['donations as donor_count' => fn($q) => $q->where('payment_status', 'success')])
            ->when($this->search, fn($q) => $q->where('title', 'like', "%{$this->search}%"))
            ->latest()
            ->paginate(10);

        $globalSummary = [
            'total_collected' => DonationCampaign::sum('collected_amount'),
            'total_campaigns' => DonationCampaign::count(),
            'active_campaigns' => DonationCampaign::where('status', 'active')->count(),
            'total_donors' => Donation::where('payment_status', 'success')->count(),
        ];

        $viewingDonations = null;
        $viewingCampaign = null;
        if ($this->showDonations && $this->viewingCampaignId) {
            $viewingCampaign = DonationCampaign::find($this->viewingCampaignId);
            $viewingDonations = Donation::where('campaign_id', $this->viewingCampaignId)
                ->latest()
                ->get();
        }

        $canManage = auth()->user()?->isSuperAdmin() || auth()->user()?->isOperator();

        return view('livewire.admin.campaign-management', compact('campaigns', 'globalSummary', 'viewingDonations', 'viewingCampaign', 'canManage'))
            ->layout('layouts.admin', ['title' => 'Donasi & Campaign']);
    }
}
