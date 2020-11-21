<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Services\Component\NotificationService;
class Notification extends Component
{
    public $notification;

    public function mount(NotificationService $notif){
        $this->notif = $notif;
    }
    public function render()
    {
        $this->notification = $this->notif->list();
        return view('livewire.notification');
    }
}
