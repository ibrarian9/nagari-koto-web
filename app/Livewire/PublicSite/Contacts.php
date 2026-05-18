<?php
namespace App\Livewire\PublicSite;
use App\Models\Contact;
use App\Models\VillageProfile as VP;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Contacts extends Component
{
    #[Layout('layouts.app', ['title' => 'Kontak'])]
    public function render()
    {
        $village = VP::getCached();
        $categories = ['emergency' => 'Darurat', 'government' => 'Pemerintahan', 'health' => 'Kesehatan', 'social' => 'Sosial'];
        $contacts = Contact::ordered()->get()->groupBy('category');
        return view('livewire.public.contacts', compact('contacts', 'categories', 'village'));
    }
}
