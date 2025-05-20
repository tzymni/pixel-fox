<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;

/**
 * Cleanup expired files from the upload directory.
 *
 * @author Tomasz Zymni <tomasz.zymni@gmail.com>
 */
class CleanupExpiredFiles extends Command
{
    protected $signature = 'files:cleanup-expired';
    protected $description = 'Remove expired files from the uploads directory';

    public function handle(): int
    {
        $files = Storage::disk('public')->files('uploads');

        foreach ($files as $file) {
            if (!Cache::has("file_expire:{$file}")) {
                Storage::disk('public')->delete($file);
                $this->info("Removed file: {$file}");
            }
        }

        return Command::SUCCESS;
    }
}

