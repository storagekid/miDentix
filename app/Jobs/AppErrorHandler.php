<?php

namespace App\Jobs;

use App\Notifications\AppErrorOcurred;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AppErrorHandler implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $adminMessage, $userMessage;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($adminMessage, $userMessage = null)
    {
        $this->adminMessage = $adminMessage;
        $this->userMessage = $userMessage;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // dd($this->adminMessage);
        $user = \App\User::find(1);
        $user->notify(new AppErrorOcurred($this->adminMessage));
        return 'Done';
    }

    public function getAdminEmail() {
        return 'jgvillalba@dentix.es';
    }
}
