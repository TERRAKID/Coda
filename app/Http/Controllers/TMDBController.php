<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TMDBController extends Controller
{
    public function fetchMovieById($movieId){
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

    public static function fetchGenres(){
        $apiKey = '?api_key=' . config('services.tmdb.token');

        $genresArray = Http::get('https://api.themoviedb.org/3/genre/movie/list' . $apiKey)
            ->json()['genres'];

        $genres = collect($genresArray)->mapWithKeys(function ($genre){
            return [$genre['id'] => $genre['name']];
        });

        return $genres;
    }

    public function fetchMovieByName($search){
        $apiKey = '?api_key=' . config('services.tmdb.token');
        $query = '&query=' . $search;

        $movies = Http::get('https://api.themoviedb.org/3/search/movie' . $apiKey . $query)
            ->json(['results']);

        return $movies;
    }
}
