<?php

namespace App\Console\Commands;

use Exception;
use App\Models\Ability;
use App\Models\Pokemon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class GetPokemonData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:get-pokemon-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected function firstFetch()
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://pokeapi.co/api/v2/pokemon?offset=20&limit=200");

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        return curl_exec($ch);
    }

    protected function secondFetch(string $url)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        return curl_exec($ch);
    }

    public function storeImage($imageUrl)
    {
        try {
            $imagePath = 'pokemon/' . uniqid() . '.png';

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_POST, 0);
            curl_setopt($ch, CURLOPT_URL, $imageUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $result = curl_exec($ch);

            Storage::disk('minio')->put($imagePath, $result);

            return $imagePath;
        } catch (Exception $err) {
            Log::info($err);
            return false;
        }
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $firstResponse = $this->firstFetch();

        $getPokemonUrls = [];

        foreach (json_decode($firstResponse, true)['results'] as $pokemonsUrl) {
            $getPokemonUrls[] = $pokemonsUrl['url'];
        }

        foreach ($getPokemonUrls as $index => $pokemonsUrl) {
            $response = $this->secondFetch($pokemonsUrl);
            $response = json_decode($response, true);

            if ($index > 200) {
                break;
            }

            if ($response['weight'] < 100) {
                try {
                    // store pokemon data
                    $new_pokemon = new Pokemon();
                    $new_pokemon->name = $response['name'];
                    $new_pokemon->best_experience = $response['base_experience'];
                    $new_pokemon->weight = $response['weight'];
                    $new_pokemon->image_path = $this->storeImage($response['sprites']['front_default']);
                    $new_pokemon->save();

                    // search the ability
                    foreach ($response['abilities'] as $ability) {
                        if ($ability['is_hidden']) {
                            $dbAbility = Ability::where('name', $ability['ability']['name'])->first();
                            if ($dbAbility) {
                                $new_pokemon->abilities()->attach($dbAbility->id);
                            } else {
                                $new_pokemon->abilities()->attach(Ability::create(['name' => $ability['ability']['name']])->id);
                            }
                        }
                    }
                } catch (Exception $err) {
                    Log::error("pokemon get data err : " . $err->getMessage());
                }
            }

            continue;
        }
    }
}
