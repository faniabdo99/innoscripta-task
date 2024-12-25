<?php

namespace App\Jobs;

use App\Services\FetchArticlesService;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class FetchArticlesJob implements ShouldBeUnique, ShouldQueue {
    use Queueable;

    public $timeout = 6000;

    public $uniqueFor = 6500;

    public string $source = '';

    public function __construct(string $source) {
        $this->source = $source;
    }

    /**
     * Get the unique ID for the job.
     */
    public function uniqueId(): string {
        return $this->source;
    }

    /**
     * Execute the job.
     */
    public function handle(): void {
        app(FetchArticlesService::class)->execute($this->source);
    }
}
