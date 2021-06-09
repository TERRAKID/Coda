<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Support\Facades\Http;
use App\Models\ProfileInfo;

class UserController extends Controller
{
    public function updateBackground(Request $request)
    {
        $user = Auth::user();

        if (!$user->profileInfo) {
            $profileInfo = new ProfileInfo;
            $profileInfo->save();
            $user->profileInfo()->associate($profileInfo);
        }

        $response = Http::get('https://api.themoviedb.org/3/search/multi?api_key=' . env('TMDB_KEY') . '&language=en-US&query=' . $request->backgroundQuery . '&page=1&include_adult=false');

        $user->profileInfo->background_photo_path = null;

        if (isset($response->json()['results'][0]['backdrop_path'])) {
            $user->profileInfo->background_photo_path = $response->json()['results'][0]['backdrop_path'];
        }

        $user->profileInfo->save();
        $user->save();
        return $user;
    }

    public function getBackground()
    {
        $user = Auth::user();
        $profile = $user->profileInfo;

        if (!$profile) {
            return null;
        }

        $background = $profile->background_photo_path;

        if ($background) {
            return $background;
        }

        return null;
    }

    public function getUser(Request $request, int $userId)
    {
        if ($userId === Auth::user()->id) {
            return redirect('user/profile');
        }

        $user = User::find($userId);

        return Inertia::render('Profile/Show', [
            'user' => $user,
            'background' => null,
            'sessions' => [],
        ]);
    }
}
