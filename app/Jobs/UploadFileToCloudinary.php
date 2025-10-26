<?php

namespace App\Jobs;

use App\Models\Lesson;
use App\Services\CloudinaryService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UploadFileToCloudinary implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected Lesson $lesson;

    protected string $filePath;

    /**
     * Create a new job instance.
     */
    public function __construct(Lesson $lesson, string $filePath)
    {
        $this->lesson = $lesson;
        $this->filePath = $filePath;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $cloudinary = new CloudinaryService;

        // Upload / Update video
        $uploaded = $cloudinary->update($this->filePath, $this->lesson->video_public_id ?? null, 'lessons');

        // Update lesson record
        $this->lesson->update([
            'video_path' => $uploaded['secure_url'],
            'video_public_id' => $uploaded['public_id'],
        ]);
    }
}
