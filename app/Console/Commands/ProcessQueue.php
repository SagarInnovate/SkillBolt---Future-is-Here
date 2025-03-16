<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class ProcessQueue extends Command
{
    protected $signature = 'app:process-queue';
    protected $description = 'Process the queue for a limited time';

    public function handle()
    {
        $this->info('Processing queue...');
        Artisan::call('queue:work', [
            '--stop-when-empty' => true,
            '--max-time' => 58, 
            '--tries' => 3
        ]);
        $this->info('Queue processing completed.');
        
        return Command::SUCCESS;
    }
}