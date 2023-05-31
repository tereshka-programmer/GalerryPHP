<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\RateLimiter;

class RebootRateLimit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rateLimit:reboot';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Rebooting reviews rate limit';

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
     * @return void
     */
    public function handle(): void
    {
//        $rateLimiter->clear('reviewsLimit');
        dd(RateLimiter::attempts('throttle:reviewsLimit'));
    }
}
