<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Repositories\CityRepositoryInterface;

class CityController extends Controller
{
    public function __construct(
        protected CityRepositoryInterface $cityRepository
    ){}

    public function index()
    {
       // Check if a city is stored in the session
       if (session()->has('selected_city')) {
            $slug = session('selected_city');
            return redirect()->route('select.city', ['slug' => $slug], 301);
        }

        // Fetch all cities using the repository
        $cities = $this->cityRepository->getAll();

        // No city in session, show the index view
        return view('welcome', compact('cities'));
    }

    public function about(string $slug)
    {
        return view('about');
    }

    public function news(string $slug)
    {
        return view('news');
    }

    public function selectCity(string $slug)
    {
      // Find the city by slug using the repository
      $city = $this->cityRepository->getBySlug($slug);

      if (!$city) {
          abort(404);
      }

      // Store the selected city in the session
      session(['selected_city' => $city->slug]);

      // Fetch all cities using the repository
      $cities = $this->cityRepository->getAll();

      return view('welcome', compact('cities', 'city'));
    }
}
