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

        $communities = Community::take(5)->get();

        $review = MovieRating::take(1)->get();

        return Inertia::render('Dashboard')
            ->with('recCommunities', $communities)
            ->with('review', $review);
    }
}
