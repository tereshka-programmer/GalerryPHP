<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Services\Thumbnail\CreateThumbnailService;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreateThumbnailsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $filePath;
    protected $height;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $filePath, int $height)
    {
        $this->height = $height;
        $this->filePath = $filePath;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(CreateThumbnailService $createThumbnailService)
    {
        $createThumbnailService->handle($this->filePath, $this->height);
    }
}
