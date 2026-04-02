<?php

namespace App\Console\Commands;

use App\Models\Debt;
use Illuminate\Console\Command;

class UpdateOverdueDebts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-overdue-debts';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Debt::where('status', 0)
            ->where('debt_due_date', '<', now())
            ->update(['status' => 1]);
    }
}
