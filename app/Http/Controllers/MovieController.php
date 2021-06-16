<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Community;
use App\Models\CommunityMember;
use App\Models\UserFriend;
use App\Models\MovieRating;
use App\Models\UserMovieCollection;
use App\Models\Movie;
use App\Traits\UploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Jetstream\Jetstream;
use Inertia\Inertia;
use Redirect;

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
            ->where('movie_ratings.active', '=', '1')
            ->where('movie_ratings.view_date', '!=', '')
            ->orderBy('movie_ratings.view_date', 'desc')
            ->get();

        $movieDetails = [];
        $groupedReviews = [];
        $reviewCount = count($reviews);

        if($reviewCount == 0){
            $groupedReviews = null;
        }
        else{
            foreach($reviews as $movie){
                $movieId = $movie->tmdb_id;
                $movie = (new TMDBController)->fetchMovieById($movieId);
                array_push($movieDetails, $movie);
            }
            foreach($reviews as $key => $item){
                $groupedReviews[substr($item['view_date'], 0, -3)][$key] = $item;
            }
            //dd($groupedReviews);
        }

        return Inertia::render('Movie/Diary')
            ->with('reviews', $groupedReviews)
            ->with('movie', $movieDetails);
    }

/**-FUNCTION-02----------------------------------------------------------*/
    public function showMovieSearch(){
        return Inertia::render('Movie/Search');
    }

/**-FUNCTION-03----------------------------------------------------------*/
    public function movieSearch(Request $request){
        $currentUser = auth()->user();
        $currentUser = $currentUser->id;

        $search = request('search_movie');

        $users = [];
        $communities = [];
        if($search != null){
            $userSearch = User::search(request('search_movie'))->get();
            if($userSearch->count() == 0){
                $users = null;
            }
            else{
                foreach($userSearch as $user){
                    $user = User::where('id', '=', $user['id'])
                        ->where('id', '!=', $currentUser)
                        ->first();

                    array_push($users, $user);
                }
            }

            $communities = Community::search(request('search_movie'))
                ->where('active', 1)
                ->where('visibility', 1)
                ->get();

            if($communities->count() == 0){
                $communities = null;
            }

            $results = (new TMDBController)->fetchMovieByName($search);
            if(empty($results)){
                $results = null;
                $genres = null;
            }
            else{
                $genres = TMDBController::fetchGenres();
                
                //This adds the movie to our database in case it doesn't exist yet
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
        }
        else{
            $genres = null;
            $search = null;
            $users = null;
            $results = null;
            $communities = null;
        }
        return Inertia::render('Movie/Search')
            ->with('movies', $results)
            ->with('genres', $genres)
            ->with('search', $search)
            ->with('users', $users)
            ->with('communities', $communities);
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

            return redirect()->to('/diary')->send();
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
        $currentUser = auth()->user();
        $currentUser = $currentUser->id;

        $userCheck = MovieRating::where('user_id', '=', $currentUser)
            ->where('id', '=', $reviewId)
            ->count();
        
        if($userCheck == 1){
            $review = MovieRating::join('movie', 'movie.id', '=', 'movie_ratings.movie_id')
            ->join('users', 'users.id', '=', 'movie_ratings.user_id')
            ->where('movie_ratings.active', '=', '1')
            ->where('movie_ratings.id', '=', $reviewId)
            ->get([
                'movie_ratings.id',
                'movie_ratings.user_id',
                'movie_ratings.watched',
                'movie_ratings.rating',
                'movie_ratings.review',
                'movie_ratings.notes',
                'movie_ratings.created_at',
                'movie.title',
                'movie.tmdb_id',
                'users.name',
                'users.profile_photo_path',
            ]);
        }
        else{
            $review = MovieRating::join('movie', 'movie.id', '=', 'movie_ratings.movie_id')
            ->join('users', 'users.id', '=', 'movie_ratings.user_id')
            ->where('movie_ratings.active', '=', '1')
            ->where('movie_ratings.id', '=', $reviewId)
            ->get([
                'movie_ratings.id',
                'movie_ratings.user_id',
                'movie_ratings.watched',
                'movie_ratings.review',
                'movie_ratings.created_at',
                'movie.title',
                'movie.tmdb_id',
                'users.name',
                'users.profile_photo_path',
            ]);
        }

        $user = User::where('id', '=', $review['0']['user_id'])->first();
        if($user['id'] == $currentUser){
            $deletePermissions = 1;
        }
        else{
            $deletePermissions = 0;
        }
        $review = $review[0];
        $movie = (new TMDBController)->fetchMovieById($review['tmdb_id']);
        
        return Inertia::render('Movie/ReviewShow')
            ->with('review', $review)
            ->with('userDetails', $user)
            ->with('movie', $movie)
            ->with('deletePermissions', $deletePermissions);
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
            ->where('movie_ratings.active', '=', '1')
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
        $allFriendReviews = MovieRating::join('user_friend', 'user_friend.user_id', '=', 'movie_ratings.user_id')
            ->where('movie_ratings.active', '=', '1')
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

        $collectionStatus = UserMovieCollection::where('user_id', '=', $currentUser)
            ->where('movie_id', '=', $CodaMovieId)
            ->where('active', '=', 1)
            ->count();
        
        if($collectionStatus == 0){
            $collectionStatus = false;
        }
        else{
            $collectionStatus = true;
        }

        return Inertia::render('Movie/Details')
            ->with('movie', $movie)
            ->with('globalReviews', $averageGlobalReviews)
            ->with('friendReviews', $averageFriendReviews)
            ->with('cast', $cast)
            ->with('trailer', $trailer)
            ->with('directors', $directors)
            ->with('collectionStatus', $collectionStatus);
    }
/**-FUNCTION-08----------------------------------------------------------*/
    public function showAllReviews($movieId){
        $allReviews = MovieRating::join('movie', 'movie.id', '=', 'movie_ratings.movie_id')
            ->join('users', 'users.id', '=', 'movie_ratings.user_id')
            ->where('movie.tmdb_id', '=', $movieId)
            ->where('movie_ratings.review', '!=', '')
            ->where('movie_ratings.active', '=', '1')
            ->get([
                'movie_ratings.id',
                'movie_ratings.user_id',
                'users.name',
                'users.profile_photo_path',
                'movie.tmdb_id',
                'movie_ratings.rating',
                'movie_ratings.review',
                'movie_ratings.created_at',
            ]);
        $users = [];
        foreach($allReviews as $review){
            $user = User::where('id', '=', $review['user_id'])->first();
            array_push($users, $user);
        }

        $movie = (new TMDBController)->fetchMovieById($movieId);
        $reviewCount = count($allReviews);

        if($reviewCount == 0){
            $allReviews = null;
        }

        return Inertia::render('Movie/AllReviewsShow')
            ->with('reviews', $allReviews)
            ->with('movie', $movie)
            ->with('users', $users);
    }
/**-FUNCTION-08----------------------------------------------------------*/
    public function showFriendReviews($movieId){
        $currentUser = auth()->user();
        $currentUser = $currentUser->id;

        $CodaMovieId = Movie::where('tmdb_id', '=', $movieId)->get();
        $CodaMovieId = $CodaMovieId['0']['id'];

        $friends = [];
        $friends1 = UserFriend::where('user_friend.user_id', '=', $currentUser)
            ->where('user_friend.accepted', '=', '1')
            ->get('friend_id');

        $friends2 = UserFriend::where('user_friend.friend_id', '=', $currentUser)
            ->where('user_friend.accepted', '=', '1')
            ->get('user_id');
        
        foreach($friends1 as $friend){
            array_push($friends, $friend['friend_id']);
        }
        foreach($friends2 as $friend){
            array_push($friends, $friend['user_id']);
        }
        $friends = array_unique($friends);

        $friendReviews = [];
        $friendDetails = [];

        foreach($friends as $friend){
            $friendReview = MovieRating::where('user_id', '=', $friend)
                ->where('movie_ratings.movie_id', '=', $CodaMovieId)
                ->get();

            foreach($friendReview as $extractedFriendReview){
                array_push($friendReviews, $extractedFriendReview);

                $users = User::where('id', '=', $extractedFriendReview['user_id'])->get();
                foreach($users as $user){
                    array_push($friendDetails, $user);
                }
            }
        }

        $movie = (new TMDBController)->fetchMovieById($movieId);
        $reviewCount = count($friendReviews);

        if($reviewCount == 0){
            $friendReviews = null;
        }

        return Inertia::render('Movie/AllReviewsShow')
            ->with('reviews', $friendReviews)
            ->with('users', $friendDetails)
            ->with('movie', $movie);
    }
/**-FUNCTION-08----------------------------------------------------------*/
    public function deleteReview($movieId, $reviewId){
        $currentUser = auth()->user();
        $currentUser = $currentUser->id;

        $review = MovieRating::find($reviewId);

        if($review){
            $review->active = '0';
            $review->save();
        }

        return redirect()->to('/diary')->send();
    }
/**-FUNCTION-09----------------------------------------------------------*/
    public function recentReviews(){
        $recentReviews = MovieRating::join('movie', 'movie.id', '=', 'movie_ratings.movie_id')
            ->join('users', 'users.id', '=', 'movie_ratings.user_id')
            ->where('movie_ratings.review', '!=', '')
            ->where('movie_ratings.active', '=', '1')
            ->orderBy('movie_ratings.created_at', 'DESC')
            ->take(100)
            ->get([
                'movie_ratings.id',
                'movie_ratings.user_id',
                'users.name',
                'users.profile_photo_path',
                'movie.tmdb_id',
                'movie.title',
                'movie_ratings.rating',
                'movie_ratings.review',
                'movie_ratings.created_at',
            ]);

        $users = [];
        

        if($recentReviews->count()!= 0){
            $movie = (new TMDBController)->fetchMovieById($recentReviews['0']['tmdb_id']);
            foreach($recentReviews as $review){
                $user = User::where('id', '=', $review['user_id'])->first();
    
                array_push($users, $user);
            }
        }

        else{
            $recentReviews = null;
        }

        return Inertia::render('Movie/RecentReviews')
            ->with('reviews', $recentReviews)
            ->with('movie', $movie)
            ->with('users', $users);
    }
/**-FUNCTION-10----------------------------------------------------------*/
    public function randomMovie(){
        $currentUser = auth()->user();
        $currentUser = $currentUser->id;

        $movies = UserMovieCollection::where('user_id', '=', $currentUser)
            ->where('active', '=', '1')
            ->get(['movie_id']);

        if($movies->count() == 0){
            $randomMovie = null;
        }
        else{
            
        $movieIds = [];
            foreach($movies as $movie){
                $movieId = Movie::where('id', '=', $movie['movie_id'])->first('tmdb_id');
                array_push($movieIds, $movieId['tmdb_id']);
            }

            $randomMovie = (new TMDBController)->fetchMovieById($movieIds[rand(0, count($movieIds) - 1)]);
        }
        return Inertia::render('Movie/RandomMovie')
            ->with('movie', $randomMovie);
    }
}

