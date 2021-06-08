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
/**----------------------------------------------------------*/
    public function movieDiary(){
        $currentUser = auth()->user();
        $currentUser = $currentUser->id;

        $reviews = Movie::join('movie_ratings', 'movie_ratings.movie_id', '=', 'movie.id')
            ->where('movie_ratings.user_id', '=', $currentUser)
            ->orderBy('movie_ratings.created_at', 'desc')
            ->get();

        $movieDetails = [];

        foreach($reviews as $movie){
            $movieId = $movie->tmdb_id;
            $movie = (new TMDBController)->fetchMovieById($movieId);
            array_push($movieDetails, $movie);
        }

        return Inertia::render('Movie/Diary')
            ->with('reviews', $reviews)
            ->with('movie', $movieDetails);
    }

/**----------------------------------------------------------*/
    public function showMovieSearch(){
        return Inertia::render('Movie/Search');
    }

/**----------------------------------------------------------*/
    public function movieSearch(Request $request){
        $search = request('search_movie');
        $results = (new TMDBController)->fetchMovieByName($search);
        $genres = TMDBController::fetchGenres();

        return Inertia::render('Movie/Search')
            ->with('results', $results)
            ->with('genres', $genres);
    }

/**----------------------------------------------------------*/
    public function showCreateReview($movieId){
        $currentUser = auth()->user();
        $currentUser = $currentUser->id;

        $movie = (new TMDBController)->fetchMovieById($movieId);

        $communities = Community::join('community_member', 'community_member.community_id', '=', 'community.id')
                ->where('community_member.user_id', '=', $currentUser)
                ->get();

        return Inertia::render('Movie/CreateReview')
            ->with('movie', $movie)
            ->with('communities', $communities);
    }
}
