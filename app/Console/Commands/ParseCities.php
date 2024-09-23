<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\City;
use Illuminate\Support\Str;

class ParseCities extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:parse-cities';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Парсинг городов России с API hh.ru';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        
        $response = Http::get('https://api.hh.ru/areas');
        $cities = collect($response->json())
            ->where('id', '113') // Россия
            ->pluck('areas')
            ->flatten(1);
        
       

        foreach ($cities as $city) {
            City::updateOrCreate(
                ['slug' => Str::slug($city['name'])],
                ['name' => $city['name']]
            );
        }

        $this->info('Города успешно загружены!');
    }
}
