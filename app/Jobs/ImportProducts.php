<?php

namespace App\Jobs;

use App\Models\Product;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ImportProducts implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(protected $count)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Product::factory($this->count)->create();
    }
}
