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

        //this adds the title and 
        foreach($results as $movie){
            $movieExist = Movie::where('tmdb_id', '=', $movie['id'])->count();
            if(!$movieExist){
                $addMovie = new Movie;
                $addMovie->title = $movie['title'];
                $addMovie->tmdb_id = $movie['id'];

                $addMovie->save();
            }
        }
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

/**----------------------------------------------------------*/
    public function createReview(Request $request, $movieId){
        $currentUser = auth()->user();
        $currentUser = $currentUser->id;
        
        $review = new MovieRating;

        $movieId = Movie::where('tmdb_id', '=', $movieId)->get();
        $movieId = $movieId['0']['id'];

        $review->user_id = $currentUser;
        $review->movie_id = $movieId;

        $checkWatched = MovieRating::where('movie_id', '=', $movieId)->count();
            
        if($checkWatched == 1){
            $watched = MovieRating::where('movie_id', '=', $movieId)
            ->orderBy('created_at', 'DESC')
            ->take(1)
            ->get();

            $watched = $watched['0']['watched'] + 1;
        }
        else{
            $watched = 1;
        }
        $review->watched = $watched;
        $review->rating = request('rating');
        $review->review = request('review');
        $review->notes = request('notes');
        $review->save();
    }
/**----------------------------------------------------------*/
    public function moviePage($movieId){
        $currentUser = auth()->user();
        $currentUser = $currentUser->id;

        $movie = (new TMDBController)->fetchMovieById($movieId);
        $cast = (new TMDBController)->fetchMovieCast($movieId);
        $crew = (new TMDBController)->fetchMovieCrew($movieId);

        $directors = [];
        foreach($crew as $crewMember){
            if($crewMember['job'] == 'Director'){
                array_push($directors, $crewMember);
            }
        }

        $allReviews = MovieRating::join('movie', 'movie.id', '=', 'movie_ratings.movie_id')
            ->where('movie.tmdb_id', '=', $movieId)
            ->get();

        $globalReviews = [];
        foreach($allReviews as $review){
            array_push($globalReviews, $review['rating']);
        }
        
        $globalReviews = array_filter($globalReviews);
        if(count($globalReviews)) {
            $averageGlobalReviews = array_sum($globalReviews)/count($globalReviews);
        }

        return Inertia::render('Movie/Details')
            ->with('movie', $movie)
            ->with('globalReviews', $averageGlobalReviews)
            ->with('cast', $cast)
            ->with('directors', $directors);
    }
}
