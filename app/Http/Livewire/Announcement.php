<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Services\Component\AnnouncementService;
class Announcement extends Component
{
    public $announcement;

    public function mount(AnnouncementService $anno){
        $this->anno = $anno;
    }

    public function render()
    {
        $this->announcement = $this->anno->annoDashboard();
        return view('livewire.announcement');
    }
}
