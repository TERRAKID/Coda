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
        ->where('community_member.user_id', '!=', $currentUser)->take(5)->get();

        $userCommunities = Community::join('community_member', 'community_member.community_id', '=', 'community.id')
        ->where('community_member.user_id', '=', $currentUser)->take(5)->get();

        $review = User::join('movie_ratings', 'movie_ratings.user_id', '=', 'users.id')
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
            ]);
        $review = $review[0];
        return Inertia::render('Dashboard')
            ->with('recCommunities', $recCommunities)
            ->with('userCommunities', $userCommunities)
            ->with('review', $review);
    }
}
