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

class GeneralController extends Controller
{
    public function dashboard(){
        $currentUser = auth()->user();
        $currentUser = $currentUser->id;
        
        // 1. This section is for finding communities where the logged in user has never been a member
        $recCommunities = CommunityMember::where('community_member.user_id', '!=', $currentUser)
            ->orderBy('id')
            ->get('community_id');
        
        $communityIds = [];
        $communitiesWithoutCurrentUserAsMember = [];

        // 2. Grabs the array from our query and checks whether it has returned a community that the logged in user was a member of
        foreach($recCommunities as $community){
            $isMember = CommunityMember::where('community_id', '=', $community['community_id'])
                ->where('user_id', '=', $currentUser)
                ->count();
        
        // 3. If not, the community's ID is added to our array
            if($isMember == 0){
                array_push($communityIds, $community['community_id']);
            }
        }

        // 4. We then check that there are no duplicate entries
        $communityIds = array_unique($communityIds);

        // 5. Finally, we retrieve the details of the relevant communities
        foreach($communityIds as $communityId){
            $result = Community::where('id', '=', $communityId)->get();
            array_push($communitiesWithoutCurrentUserAsMember, $result['0']);
        }

        $userCommunities = Community::join('community_member', 'community_member.community_id', '=', 'community.id')
        ->where('community_member.user_id', '=', $currentUser)->take(5)->get();

        $review = User::join('movie_ratings', 'movie_ratings.user_id', '=', 'users.id')
            ->join('movie', 'movie.id', '=', 'movie_ratings.movie_id')
            ->where('movie_ratings.active', '=', '1')
            ->where('movie_ratings.review', '!=', '')
            ->orderBy('movie_ratings.created_at', 'DESC')
            ->take(1)
            ->get([
                'users.name', 
                'users.profile_photo_path',
                'movie_ratings.id',
                'movie_ratings.user_id',
                'movie_ratings.created_at', 
                'movie_ratings.movie_id', 
                'movie_ratings.watched', 
                'movie_ratings.rating', 
                'movie_ratings.review',
                'movie.tmdb_id',
            ]);
        $user = User::where('id', '=', $review['0']['user_id'])->first();

        $reviewStatus = $review->count();
        if($reviewStatus != 0){
            $review = $review[0];
            $reviewMovie = (new TMDBController)->fetchMovieById($review['tmdb_id']);
        }
        else{
            $reviewMovie = 0;
        }

        //This adds the movie to our database in case it doesn't exist yet
        $popular = (new TMDBController)->popularMovies();
        foreach($popular as $movie){
            $movieExist = Movie::where('tmdb_id', '=', $movie['id'])->count();
            if(!$movieExist){
                $addMovie = new Movie;
                $addMovie->title = $movie['title'];
                $addMovie->tmdb_id = $movie['id'];

                $addMovie->save();
            }
        }
        
        return Inertia::render('Dashboard')
            ->with('recCommunities', $communitiesWithoutCurrentUserAsMember)
            ->with('userCommunities', $userCommunities)
            ->with('review', $review)
            ->with('reviewMovie', $reviewMovie)
            ->with('reviewStatus', $reviewStatus)
            ->with('popular', $popular)
            ->with('userDetails', $user);
    }
}
