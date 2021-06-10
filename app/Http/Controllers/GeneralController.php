<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Community;
use App\Models\CommunityMember;
use App\Models\UserFriend;
use App\Models\MovieRating;
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
            
        $recCommunities = Community::join('community_member', 'community_member.community_id', '=', 'community.id')
            ->where('community_member.user_id', '!=', $currentUser)
            ->take(5)->get();
        
        $communitiesWithoutCurrentUserAsMember = [];

        foreach($recCommunities as $community){
            $isMember = CommunityMember::where('community_id', '=', $community['community_id'])
                ->where('user_id', '=', $currentUser)
                ->count();

            if($isMember == 0){
                array_push($communitiesWithoutCurrentUserAsMember, $community);
            }
        }

        $userCommunities = Community::join('community_member', 'community_member.community_id', '=', 'community.id')
        ->where('community_member.user_id', '=', $currentUser)->take(5)->get();

        $review = User::join('movie_ratings', 'movie_ratings.user_id', '=', 'users.id')
            ->join('movie', 'movie.id', '=', 'movie_ratings.movie_id')
            ->orderBy('movie_ratings.created_at', 'DESC')
            ->take(1)
            ->get([
                'users.id', 
                'users.name', 
                'users.profile_photo_path', 
                'movie_ratings.created_at', 
                'movie_ratings.movie_id', 
                'movie_ratings.watched', 
                'movie_ratings.rating', 
                'movie_ratings.review',
                'movie.tmdb_id',
            ]);

        $reviewStatus = $review->count();
        if($reviewStatus != 0){
            $review = $review[0];
            $reviewMovie = (new TMDBController)->fetchMovieById($review['tmdb_id']);
        }
        else{
            $reviewMovie = 0;
        }

        $popular = (new TMDBController)->popularMovies();
        
        return Inertia::render('Dashboard')
            ->with('recCommunities', $communitiesWithoutCurrentUserAsMember)
            ->with('userCommunities', $userCommunities)
            ->with('review', $review)
            ->with('reviewMovie', $reviewMovie)
            ->with('reviewStatus', $reviewStatus)
            ->with('popular', $popular);
    }
}
