<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Community;
use App\Models\CommunityMember;
use App\Models\UserFriend;
use App\Models\MovieRating;
use App\Models\Movie;
use App\Models\UserMovieCollection;
use App\Traits\UploadTrait;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Jetstream\Jetstream;
use Inertia\Inertia;
use Redirect;

use Illuminate\Http\Request;

class MovieCollectionController extends Controller
{
    public function addMovieToCollection($movieId){
        $currentUser = auth()->user();
        $currentUser = $currentUser->id;

        $codaMovieId = Movie::where('tmdb_id', '=', $movieId)->get();
        $codaMovieId = $codaMovieId['0']['id'];

        $checkMovie = UserMovieCollection::where('user_id', '=', $currentUser)
            ->where('movie_id', '=', $codaMovieId)
            ->count();

        if($checkMovie == 0){
            $addMovie = new UserMovieCollection;
    
            $addMovie->user_id = $currentUser;
            $addMovie->movie_id = $codaMovieId;
            $addMovie->active = 1;
            $addMovie->save();
        }
        else{
            $addMovie = UserMovieCollection::where('user_id', '=', $currentUser)
                ->where('movie_id', '=', $codaMovieId)
                ->update(['active' => 1]);
        }
    }

    public function removeMovieFromCollection($movieId){
        $currentUser = auth()->user();
        $currentUser = $currentUser->id;

        $codaMovieId = Movie::where('tmdb_id', '=', $movieId)->get();
        $codaMovieId = $codaMovieId['0']['id'];

        $removeMovie = UserMovieCollection::where('user_id', '=', $currentUser)
            ->where('movie_id', '=', $codaMovieId)
            ->where('active', '=', 1)
            ->update(['active' => 0]);
    }

    public function showMovieCollection(){
        $currentUser = auth()->user();
        $currentUser = $currentUser->id;

        $movies = UserMovieCollection::join('movie', 'movie.id', '=', 'user_movie_collections.movie_id')
            ->where('user_movie_collections.user_id', '=', $currentUser)
            ->where('active', '=', '1')
            ->orderBy('movie.title', 'ASC')
            ->get();
        
        $collection = [];
        $allDirectors = [];

        if($movies->count() == 0){
            $collection = null;
            $directors = null;
        }
        else{
            foreach($movies as $movie){
                $item = (new TMDBController)->fetchMovieByID($movie['tmdb_id']);
                $crew = (new TMDBController)->fetchMovieCrew($movie['tmdb_id']);
                array_push($collection, $item);

                $movieDirectors = [];
                foreach($crew as $crewMember){
                    if($crewMember['job'] == 'Director'){
                        array_push($movieDirectors, $crewMember);
                    }
                }
                array_push($allDirectors, $movieDirectors);
            }
        }
        return Inertia::render('Movie/Collection')
            ->with('collection', $collection)
            ->with('directors', $allDirectors);
    }
}
