<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Log as Logs;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
class DeleteLog extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'log:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete 1 Month Ago Log';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {


        // $log = Logs::where('created_at','<',Carbon::now()->subDays(30));
        $log = Logs::query();
        if($log != null){
        foreach($log->get() as $l){
        Log::channel('activity')->info('Activity Log :',[
            'action' => $l->event,
            'event' => $l->logable_name,
            'creator_id' => $l->creator_id,
            'creator' => $l->creator,
            'ip_address' => $l->ip_address,

        ]);
        }
    }
        $log->delete();
        return true;
    }
}
