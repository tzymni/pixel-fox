<?php

namespace App\Jobs;

use App\Events\PixelImageGenerated;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\{Log, Storage};
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

final class ProcessPixelRequest implements ShouldQueue
{
    use Dispatchable, Queueable;

    private const SCRIPT_COMMAND = '/opt/venv/bin/pyxelate';
    private const OUTPUT_DIR = 'pixel_images';

    public readonly string $imageOutputPath;
    public readonly string $relativeOutputPath;

    private readonly string $imageName;

    public function __construct(
        public readonly string $taskId,
        public readonly string $imagePath,
    ) {
        [$this->imageOutputPath, $this->relativeOutputPath] = $this->generateOutputPaths();
    }

    public function handle(): void
    {
        Log::info('Starting pixel art generation', [
            'task_id' => $this->taskId,
            'source' => $this->imagePath,
            'output' => $this->imageOutputPath,
        ]);

        try {
            $this->runProcess();
            Log::info('Pixel art generated', ['path' => $this->imageOutputPath]);
            event(new PixelImageGenerated($this->taskId, $this->imageName));
        } catch (ProcessFailedException $e) {
            Log::error('Pixel art generation failed', [
                'task_id' => $this->taskId,
                'error' => $e->getMessage(),
                'output' => $e->getProcess()->getErrorOutput(),
            ]);
        }
    }

    /**
     * Generates absolute and relative output paths for the image.
     *
     * @return array{0: string, 1: string}
     */
    private function generateOutputPaths(): array
    {
        Storage::disk('public')->makeDirectory(self::OUTPUT_DIR);
        $filename = "pixel_{$this->taskId}.png";
        $this->imageName = $filename;
        $absolutePath = Storage::disk('public')->path(self::OUTPUT_DIR . '/' . $filename);
        $relativePath = str_replace(base_path() . '/', '', $absolutePath);

        return [$absolutePath, $relativePath];
    }

    /**
     * Builds the command array for the pixelation script.
     *
     * @return string[]
     */
    private function buildCommand(): array
    {
        $inputPath = 'storage/app/public/' . $this->imagePath;
        return [
            self::SCRIPT_COMMAND,
            $inputPath,
            $this->relativeOutputPath,
//            '--factor',
//            '3',
            '--palette',
            '32'

        ];
    }

    /**
     * Runs the image processing command.
     *
     * @throws ProcessFailedException
     */
    private function runProcess(): void
    {
        $process = new Process($this->buildCommand(), timeout: 120);
        $process->mustRun();
    }
}
