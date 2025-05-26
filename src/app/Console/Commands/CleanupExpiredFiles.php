<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

/**
 * Cleanup expired files from the upload directory.
 *
 * @author Tomasz Zymni <tomasz.zymni@gmail.com>
 */
class CleanupExpiredFiles extends Command
{
    protected $signature = 'files:cleanup-expired';
    protected $description = 'Remove expired files from the uploads directory';

    const THRESHOLD_HOURS = 2;

    public function handle(): int
    {
        $uploadedFiles = Storage::disk('public')->files('uploads');
        $generatedFiles = Storage::disk('public')->files('pixel_images');

        $files = array_merge($uploadedFiles, $generatedFiles);

        foreach ($files as $file) {

            $fullPath = Storage::disk('public')->path($file);

            if (file_exists($fullPath)) {
                $ctime = filectime($fullPath);
                if ($ctime + (self::THRESHOLD_HOURS * 60 * 60) < time()) {
                    Storage::disk('public')->delete($file);
                    $this->info("Removed file: {$file}");
                }
            }
        }

        return Command::SUCCESS;
    }
}

