<?php

namespace App\Console\Commands;

use App\Notifications\AuthorPostApproved;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Queue;

class CronEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:name';

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
     * @return mixed
     */
    public function handle()
    {
        Queue::push(new AuthorPostApproved());
    }
}
