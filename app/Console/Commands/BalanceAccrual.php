<?php

namespace App\Console\Commands;

use App\Models\Log\Schedule;
use App\Models\UserWallet;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;

class BalanceAccrual extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'balance:accrual';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $log = [
            'command' => 'balance:accrual',
            'status' => 'start',
        ];
        (new Schedule($log))->save();
        UserWallet::all()->each(
            function ($wallet) {
                $wallet->balance += $wallet->wax;
                $wallet->save();
            }
        );
        $log['status'] = 'end';
        (new Schedule($log))->save();
        return 0;
    }
}
