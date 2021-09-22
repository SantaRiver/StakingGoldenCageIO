<?php

namespace App\Console\Commands;

use App\Models\Log\Schedule;
use App\Models\User;
use App\Models\UserWallet;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;

class DeletingDuplicateWallets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'walletsDuplicate:delete';

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
            'command' => 'walletsDuplicate:delete',
            'status' => 'start',
        ];
        (new Schedule($log))->save();
        $deletingID = '';
        User::query()->each(function ($user) use (&$deletingID) {
            $userWallets = UserWallet::query()->where('user_id', $user->id)->orderByDesc('wax')->get();
            if ($userWallets->count() > 1){
                $deletingID .= $userWallets->first()->id . ', ';
                $userWallets->first()->delete();
            }
        });
        $log['status'] = 'end';
        $log['message'] = 'Delete ID: ' . $deletingID
        (new Schedule($log))->save();
        return 0;
    }
}
