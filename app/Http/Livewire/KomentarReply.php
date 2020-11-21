<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Component\KomentarBalasan;
class KomentarReply extends Component
{
    public $komentarID,$replyData,$reply;

    protected $listeners = [
        'repplied',
    ];

    public function repplied(){
        $this->replyData = '';
    }

    public function mount(KomentarBalasan $reply,$komentarID){
        $this->komentarID = $komentarID ;
    }
    public function render()
    {
        $reply = KomentarBalasan::where('komentar_id',$this->komentarID)->orderby('created_at','desc')->get();
        $this->reply = $reply;
        return view('livewire.komentar-reply');
    }
    public function reply()
    {
        $reply = new KomentarBalasan;
        $query = KomentarBalasan::create([
            'komentar_id' => $this->komentarID,
            'komentar'=>$this->replyData,
            ]);
            $this->emit('repplied');
    }
}
