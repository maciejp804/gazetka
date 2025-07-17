<?php

namespace App\Jobs;

use App\Models\Leaflet;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class ImportLeafletHotSpotsJob implements ShouldQueue
{
    use Dispatchable, Queueable, InteractsWithQueue, SerializesModels;

    protected string $path;

    protected Leaflet $leaflet;
    protected int $imageWidth;
    protected int $imageHeight;

    /**
     * Create a new job instance.
     */
    public function __construct(string $path, Leaflet $leaflet, $imageWidth, $imageHeight)
    {
        $this->path = $path;
        $this->leaflet = $leaflet;
        $this->imageWidth = $imageWidth;
        $this->imageHeight = $imageHeight;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        $json = Storage::get($this->path);
        $data = json_decode($json, true)['productOffers'] ?? [];

        $chunks = array_chunk($data, 20); // po 25 produktów
        foreach ($chunks as $chunk) {
            ProcessHotSpotsChunkJob::dispatch(
                $chunk,
                $this->leaflet,
                $this->imageWidth,
                $this->imageHeight
            );
        }

        // Usuwanie pliku po zakończeniu podziału
        Storage::delete($this->path);
    }
}
