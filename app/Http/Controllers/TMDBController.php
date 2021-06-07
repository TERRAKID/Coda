<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TMDBController extends Controller
{
    public function fetchMovie($movieId){
        $apiKey = '?api_key=' . config('services.tmdb.token');

        $movie = Http::get('https://api.themoviedb.org/3/movie/' . $movieId . $apiKey)
            ->json();
            
        return $movie;
    }

    public function popularMovies(){
        $apiKey = '?api_key=' . config('services.tmdb.token');

        $movie = Http::get('https://api.themoviedb.org/3/movie/popular' . $apiKey)
            ->json(['results']);

        return $movie;
        
    }
}
