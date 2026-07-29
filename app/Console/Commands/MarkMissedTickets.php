<?php

namespace App\Console\Commands;

use App\Models\Ticket;
use Illuminate\Console\Command;

class MarkMissedTickets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tickets:mark-missed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Marca como "missed" los tickets no escaneados cuya función ya pasó';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $count = Ticket::whereHas('performance', function ($query) {
                $query->where('start_time', '<', now());
            })
            ->where('status', 'active')
            ->where('is_scanned', false)
            ->update(['status' => 'missed']);

        $this->info("Se marcaron {$count} ticket(s) como vencidos.");
    }
}
