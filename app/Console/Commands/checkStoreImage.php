<?php

namespace App\Console\Commands;

use Exception;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class checkStoreImage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-store-image';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $imagePath = 'pokemon/' . uniqid() . '.png';

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_POST, 0);
            curl_setopt($ch, CURLOPT_URL, "https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/1.png");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $result = curl_exec($ch);

            Storage::disk('minio')->put($imagePath, $result);

            Log::info($imagePath);

            return $imagePath;
        } catch (Exception $err) {
            Log::info($err);
            return false;
        }

        return true;
    }
}
