<?php
namespace App\Livewire\PublicSite;

use App\Models\BansosRecipient;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Attributes\Validate;
use Livewire\Component;

class BansosCheck extends Component
{
    #[Validate('required|digits:16')]
    public string $nik = '';

    public bool $searched = false;
    public $results = null;

    public function search(): void
    {
        $key = 'bansos-search:' . request()->ip();

        if (RateLimiter::tooManyAttempts($key, 10)) {
            $this->dispatch('swal', icon: 'warning', title: 'Terlalu Banyak Percobaan', text: 'Anda telah mencapai batas pencarian. Silakan coba lagi nanti.');
            return;
        }

        $this->validate();

        RateLimiter::hit($key, 3600); // 1 hour decay

        $this->results = BansosRecipient::query()->where('nik', $this->nik)->active()->get();
        $this->searched = true;
    }

    public function render()
    {
        return view('livewire.public.bansos-check')
            ->layout('layouts.app', ['title' => 'Cek Bansos']);
    }
}
