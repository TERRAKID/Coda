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

    public function fetchMovieByName($search){
        $apiKey = '?api_key=' . config('services.tmdb.token');
        $query = '&query=' . $search;

        $movies = Http::get('https://api.themoviedb.org/3/search/movie' . $apiKey . $query)
            ->json(['results']);

        return $movies;
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

    public function fetchMovieCast($movieId){
        $apiKey = '?api_key=' . config('services.tmdb.token');

        $credits = Http::get('https://api.themoviedb.org/3/movie/' . $movieId . '/credits' . $apiKey)
            ->json();

        $cast = $credits['cast'];
            
        return $cast;
    }

    public function fetchMovieCrew($movieId){
        $apiKey = '?api_key=' . config('services.tmdb.token');

        $credits = Http::get('https://api.themoviedb.org/3/movie/' . $movieId . '/credits' . $apiKey)
            ->json();

        $crew = $credits['crew'];
            
        return $crew;
    }

    public function fetchMovieTrailer($movieId){
        $apiKey = '?api_key=' . config('services.tmdb.token');

        $videos = Http::get('https://api.themoviedb.org/3/movie/' . $movieId . '/videos' . $apiKey)
            ->json();

        if($videos['results']){
            $trailer = $videos['results']['0']['key'];
        }
        else{
            $trailer = null;
        }
        return $trailer;

    }

    public static function fetchRandomMovie(){
        $apiKey = '?api_key=' . config('services.tmdb.token');

        do{
            $latestMovie = Http::get('https://api.themoviedb.org/3/movie/latest' . $apiKey)
                ->json();

            $movieId = rand(0, $latestMovie['id']);
            $randomMovie = Http::get('https://api.themoviedb.org/3/movie/' . $movieId . $apiKey)
                ->json();
        
            if(array_key_exists('adult', $randomMovie) 
                && $randomMovie['adult'] == false
                && $randomMovie['popularity'] > 2
                && $randomMovie['backdrop_path']
                && $randomMovie['poster_path']
                && $randomMovie['title']
                && $randomMovie['overview']
                && $randomMovie['genres']){

                $randomMovie = $randomMovie;
            }
            else{
                $randomMovie = null;
            }
        } while($randomMovie == null);

        return $randomMovie;

    }
}
