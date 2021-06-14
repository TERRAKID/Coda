<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Support\Facades\Http;
use App\Models\ProfileInfo;
use App\Models\UserFriend;
use App\Models\MovieRating;

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

        $response = Http::get('https://api.themoviedb.org/3/search/multi?api_key=' . config('services.tmdb.token') . '&language=en-US&query=' . $request->backgroundQuery . '&page=1&include_adult=false');

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
        $user->profileInfo;
        $isFriend = false;

        if (!empty(UserFriend::where('user_id', Auth::user()->id)->where('friend_id', $userId)->first()->accepted)) {
            $isFriend = true;
        }

        $amountFriends = UserFriend::where('user_id', $userId)->where('accepted', true)->get()->count();
        $films = MovieRating::where('user_id', $userId)->where('active', true)->get();

        $amountFilms = $films->groupBy('movie_id')->count();
        $filmIds = $films->where('rating', '>', $films->avg('rating'))->sortByDesc('watched')->unique('movie_id')->take(5);

        $genres = array();
        $favMovies = array();
        $favoriteGenre = false;

        foreach ($filmIds as $filmId) {
            $response = Http::get('https://api.themoviedb.org/3/movie/'. $filmId->movie->tmdb_id .'?api_key=' . config('services.tmdb.token') . '&language=en-US');

            $favMovie = $response->json();
            $filmGenres = $favMovie['genres'];

            array_push($favMovies, $favMovie);

            if (isset($filmGenres[0]['name'])) {
                foreach ($filmGenres as $filmGenre) {
                    array_push($genres, $filmGenre['name']);
                }
            }
        }

        $values = array_count_values($genres);
        arsort($values);
        if (isset(array_keys($values)[0])) {
            $favoriteGenre = array_keys($values)[0];
        }

        return Inertia::render('User', [
            'otherUser' => $user,
            'isFriend' => $isFriend,
            'amountFriends' => $amountFriends,
            'amountFilms' => $amountFilms,
            'favoriteGenre' => $favoriteGenre,
            'favoriteMovies' => $favMovies,
        ]);
    }

    public function addFriend(Request $request)
    {
        $user = Auth::user();

        if ($request->isFriend) {
            $userFriend = UserFriend::where('user_id', $user->id)->where('friend_id', $request->friendId)->orWhere('user_id', $request->friendId)->where('friend_id', $user->id)->update(['accepted' => false]);
            return redirect('/user\\' . $request->friendId);
        }

        if (empty(UserFriend::where('user_id', $user->id)->where('friend_id', $request->friendId)->first())) {
            $userFriend = new UserFriend;
            $userFriend->user_id =  $user->id;
            $userFriend->friend_id = $request->friendId;
            $userFriend->save();
        }

        if (empty(UserFriend::where('user_id', $request->friendId)->where('friend_id', $user->id)->first())) {
            $userFriend = new UserFriend;
            $userFriend->user_id =  $request->friendId;
            $userFriend->friend_id = $user->id;
            $userFriend->save();
        }

        $userFriend = UserFriend::where('user_id', $user->id)->where('friend_id', $request->friendId)->orWhere('user_id', $request->friendId)->where('friend_id', $user->id)->update(['accepted' => true]);
        return redirect('/user\\' . $request->friendId);
    }

    public function getProfileInfo()
    {
        $amountFriends = UserFriend::where('user_id', Auth::user()->id)->where('accepted', true)->get()->count();
        $films = MovieRating::where('user_id', Auth::user()->id)->where('active', true)->get();

        $amountFilms = $films->groupBy('movie_id')->count();

        return [
            'amountFriends' => $amountFriends,
            'amountFilms' => $amountFilms,
        ];
    }
}
