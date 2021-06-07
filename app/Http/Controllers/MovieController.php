<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Community;
use App\Models\CommunityMember;
use App\Models\UserFriend;
use App\Models\MovieRating;
use App\Models\Movie;
use App\Traits\UploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Jetstream\Jetstream;
use Inertia\Inertia;

class MovieController extends Controller
{
    public function movieDiary(){
        $currentUser = auth()->user();
        $currentUser = $currentUser->id;

        $reviews = Movie::join('movie_ratings', 'movie_ratings.movie_id', '=', 'movie.id')
            ->where('movie_ratings.user_id', '=', $currentUser)->get();

        $movieDetails = [];

        foreach($reviews as $movie){
            $movieId = $movie->tmdb_id;
            $movie = (new TMDBController)->fetchMovie($movieId);
            array_push($movieDetails, $movie);
        }

        return Inertia::render('Movie/Diary')
            ->with('reviews', $reviews)
            ->with('movie', $movieDetails);
    }
}
