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
    /*
    CONTROLLER LAYOUT:
        Function 01: movieDiary()       -- Line 32
        Function 02: showMovieSearch()  -- Line 54
        Function 03: movieSearch()      -- Line 59
        Function 04: showCreateReview() -- Line 84
        Function 05: createReview()     -- Line 100
        Function 06: showReview()       -- Line 138
        Function 07: moviePage()        -- Line 163
        Function 08: showAllReviews()   -- Line 247
    */

/**-FUNCTION-01----------------------------------------------------------*/
    public function movieDiary(){
        $currentUser = auth()->user();
        $currentUser = $currentUser->id;

        $reviews = Movie::join('movie_ratings', 'movie_ratings.movie_id', '=', 'movie.id')
            ->where('movie_ratings.user_id', '=', $currentUser)
            ->orderBy('movie_ratings.view_date', 'desc')
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

/**-FUNCTION-02----------------------------------------------------------*/
    public function showMovieSearch(){
        return Inertia::render('Movie/Search');
    }

/**-FUNCTION-03----------------------------------------------------------*/
    public function movieSearch(Request $request){
        $search = request('search_movie');
        $results = (new TMDBController)->fetchMovieByName($search);
        $genres = TMDBController::fetchGenres();

        //this adds the title and 
        if($search){
            foreach($results as $movie){
                $movieExist = Movie::where('tmdb_id', '=', $movie['id'])->count();
                if(!$movieExist){
                    $addMovie = new Movie;
                    $addMovie->title = $movie['title'];
                    $addMovie->tmdb_id = $movie['id'];

                    $addMovie->save();
                }
            }
        }
        return Inertia::render('Movie/Search')
            ->with('results', $results)
            ->with('genres', $genres)
            ->with('search', $search);
    }

/**-FUNCTION-04----------------------------------------------------------*/
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

/**-FUNCTION-05----------------------------------------------------------*/
    public function createReview(Request $request, $movieId){
        $currentUser = auth()->user();
        $currentUser = $currentUser->id;

        try{
            $validator = $request->validate([
                'view_date' => 'required',
                'rating' => 'required',
            ]);

            $review = new MovieRating;

            $movieId = Movie::where('tmdb_id', '=', $movieId)->get();
            $movieId = $movieId['0']['id'];

            $review->user_id = $currentUser;
            $review->movie_id = $movieId;

            $checkWatched = MovieRating::where('movie_id', '=', $movieId)
                ->where('user_id', '=', $currentUser)
                ->count();
                
            if($checkWatched > 0){
                $watched = $checkWatched + 1;
            }
            else{
                $watched = 1;
            }

            $review->watched = $watched;
            $review->rating = request('rating');
            $review->review = request('review');
            $review->notes = request('notes');
            $review->view_date = request('view_date');
            $review->save();

            $newReview = MovieRating::where('movie_id', '=', $movieId)
                ->where('user_id', '=', $currentUser)
                ->orderBy('created_at', 'DESC')
                ->get();

            return Inertia::render('Movie/ReviewShow')->with('review', $newReview);
        }
        catch (ValidationException $exception) {
            return response()->json([
                'status' => 'error',
                'message'    => 'Error',
                'errors' => $exception->errors(),
            ], 422);
        }
    }

/**-FUNCTION-06----------------------------------------------------------*/
    public function showReview($movieId, $reviewId){
        $review = MovieRating::join('movie', 'movie.id', '=', 'movie_ratings.movie_id')
            ->join('users', 'users.id', '=', 'movie_ratings.user_id')
            ->where('movie_ratings.id', '=', $reviewId)
            ->get([
                'movie_ratings.id',
                'movie_ratings.user_id',
                'movie_ratings.watched',
                'movie_ratings.review',
                'movie_ratings.notes',
                'movie_ratings.created_at',
                'movie.title',
                'movie.tmdb_id',
                'users.name',
                'users.profile_photo_path',
            ]);
        $review = $review[0];
        $movie = (new TMDBController)->fetchMovieById($review['tmdb_id']);
        
        return Inertia::render('Movie/ReviewShow')
            ->with('review', $review)
            ->with('movie', $movie);
    }
/**-FUNCTION-07----------------------------------------------------------*/
    public function moviePage($movieId){
        $currentUser = auth()->user();
        $currentUser = $currentUser->id;

        $CodaMovieId = Movie::where('tmdb_id', '=', $movieId)->get();
        $CodaMovieId = $CodaMovieId['0']['id'];

        $movie = (new TMDBController)->fetchMovieById($movieId);
        $cast = (new TMDBController)->fetchMovieCast($movieId);
        $crew = (new TMDBController)->fetchMovieCrew($movieId);
        $trailer = (new TMDBController)->fetchMovieTrailer($movieId);
        
        $directors = [];
        foreach($crew as $crewMember){
            if($crewMember['job'] == 'Director'){
                array_push($directors, $crewMember);
            }
        }

        // This calculates the score of all reviews, rounded down
        $allReviews = MovieRating::join('movie', 'movie.id', '=', 'movie_ratings.movie_id')
            ->where('movie.tmdb_id', '=', $movieId)
            ->get();

        $globalReviews = [];
        foreach($allReviews as $review){
            array_push($globalReviews, $review['rating']);
        }
        $globalReviews = array_filter($globalReviews);

        if(count($globalReviews)) {
            $averageGlobalReviews = floor(array_sum($globalReviews)/count($globalReviews));
        }
        else{
            $averageGlobalReviews = null;
        }

        // This calculates the average score of the logged in user's friend's ratings

        $allFriendReviews1 = MovieRating::join('user_friend', 'user_friend.user_id', '=', 'movie_ratings.user_id')
            ->where('movie_ratings.movie_id', '=', $movieId)
            ->where('user_friend.user_id', '=', $currentUser)
            ->get([
                'movie_ratings.id',
                'movie_ratings.user_id',
                'movie_ratings.movie_id',
                'movie_ratings.rating',
            ]);

        $allFriendReviews = MovieRating::join('user_friend', 'user_friend.user_id', '=', 'movie_ratings.user_id')
            ->where(function ($query) use ($CodaMovieId){
                $query->where('movie_ratings.movie_id', '=', $CodaMovieId);
            })
            ->where(function ($query) use ($currentUser){
                $query->where('user_friend.user_id', '=', $currentUser)
                ->orWhere('user_friend.friend_id', '=', $currentUser);
            })->get([
                'movie_ratings.id',
                'movie_ratings.user_id',
                'movie_ratings.movie_id',
                'movie_ratings.rating',]
            );

        $friendReviews = [];
        foreach($allFriendReviews as $review){
            array_push($friendReviews, $review['rating']);
        }
        $friendReviews = array_filter($friendReviews);

        if(count($friendReviews)) {
            $averageFriendReviews = floor(array_sum($friendReviews)/count($friendReviews));
        }
        else{
            $averageFriendReviews = null;
        }

        return Inertia::render('Movie/Details')
            ->with('movie', $movie)
            ->with('globalReviews', $averageGlobalReviews)
            ->with('friendReviews', $averageFriendReviews)
            ->with('cast', $cast)
            ->with('trailer', $trailer)
            ->with('directors', $directors);
    }
/**-FUNCTION-08----------------------------------------------------------*/
    public function showAllReviews($movieId){
        $allReviews = MovieRating::join('movie', 'movie.id', '=', 'movie_ratings.movie_id')
            ->join('users', 'users.id', '=', 'movie_ratings.user_id')
            ->where('movie.tmdb_id', '=', $movieId)
            ->where('movie_ratings.review', '!=', '')
            ->get([
                'movie_ratings.user_id',
                'users.name',
                'users.profile_photo_path',
                'movie.tmdb_id',
                'movie_ratings.rating',
                'movie_ratings.review',
                'movie_ratings.created_at',
            ]);

        $movie = (new TMDBController)->fetchMovieById($movieId);

        return Inertia::render('Movie/AllReviewsShow')
            ->with('reviews', $allReviews)
            ->with('movie', $movie);
    }
/**-FUNCTION-08----------------------------------------------------------*/
    public function showFriendReviews($movieId){
        $currentUser = auth()->user();
        $currentUser = $currentUser->id;

        $CodaMovieId = Movie::where('tmdb_id', '=', $movieId)->get();
        $CodaMovieId = $CodaMovieId['0']['id'];

        $friendReviews = MovieRating::join('user_friend', 'user_friend.user_id', '=', 'movie_ratings.user_id')
            ->join('users', 'users.id', '=', 'movie_ratings.user_id')
            ->where('movie_ratings.review', '!=', '')
            ->where(function ($query) use ($CodaMovieId){
                $query->where('movie_ratings.movie_id', '=', $CodaMovieId);
            })
            ->where(function ($query) use ($currentUser){
                $query->where('user_friend.friend_id', '=', $currentUser)
                ->orWhere('user_friend.user_id', '=', $currentUser);
            })->get([
                'movie_ratings.user_id',
                'users.name',
                'users.profile_photo_path',
                'movie_ratings.rating',
                'movie_ratings.review',
                'movie_ratings.created_at',
            ]);
        $movie = (new TMDBController)->fetchMovieById($movieId);

        return Inertia::render('Movie/AllReviewsShow')
            ->with('reviews', $friendReviews)
            ->with('movie', $movie);
    }
}
