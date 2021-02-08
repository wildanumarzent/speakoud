<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Services\Component\NotificationService;
class Notification extends Component
{
    public $notification;
    public $unread;

    public function mount(NotificationService $notif){
        $this->notif = $notif;
    }
    public function render()
    {
        $userId = auth()->user()->id;
        $this->notification = $this->notif->list($userId);
    $this->unread  = $this->notif->unread($userId);
        return view('livewire.notification');
    }
}
