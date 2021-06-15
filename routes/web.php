<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\DirectMessageController;
use App\Http\Controllers\GeneralController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CommunityController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\TMDBController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('dashboard');
});
/*
Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');
*/
Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', [GeneralController::class, 'dashboard'])->name('dashboard');

Route::middleware(['auth:sanctum', 'verified'])->get('/chat', function () {
    return Inertia::render('Chat/Show');
})->name('chat');

Route::middleware(['auth:sanctum', 'verified'])->get('/chat/users', [DirectMessageController::class, 'listUsers']);
Route::middleware(['auth:sanctum', 'verified'])->get('/chat/{userId}/last', [DirectMessageController::class, 'getLastMessages']);
Route::middleware(['auth:sanctum', 'verified'])->get('/chat/{userId}', [DirectMessageController::class, 'getMessages']);
Route::middleware(['auth:sanctum', 'verified'])->post('/chat/{userId}', [DirectMessageController::class, 'newMessage']);



Route::middleware(['auth:sanctum', 'verified'])->get('/chat', function () {
    return Inertia::render('Chat/Show');
})->name('chat');

/** Direct Messages */
Route::middleware(['auth:sanctum', 'verified'])->get('/chat/users', [DirectMessageController::class, 'listUsers']);
Route::middleware(['auth:sanctum', 'verified'])->get('/chat/{userId}/last', [DirectMessageController::class, 'getLastMessages']);
Route::middleware(['auth:sanctum', 'verified'])->get('/chat/{userId}', [DirectMessageController::class, 'getMessages']);
Route::middleware(['auth:sanctum', 'verified'])->post('/chat/{userId}', [DirectMessageController::class, 'newMessage']);

/** Communities */
Route::middleware(['auth:sanctum', 'verified'])->get('/community/create', [CommunityController::class, 'createCommunityShowUsers']);
Route::middleware(['auth:sanctum', 'verified'])->post('/community/create', [CommunityController::class, 'createCommunity']);

Route::middleware(['auth:sanctum', 'verified'])->get('/community', [CommunityController::class, 'showAllCommunities'])->name('community');
Route::middleware(['auth:sanctum', 'verified'])->get('/community/{id}', [CommunityController::class, 'showCommunity']);

Route::middleware(['auth:sanctum', 'verified'])->get('/community/{id}/details', [CommunityController::class, 'communityDetails']);
Route::middleware(['auth:sanctum', 'verified'])->post('/community/{id}/details', [CommunityController::class, 'leaveCommunity']);

Route::middleware(['auth:sanctum', 'verified'])->get('/community/{id}/invite', [CommunityController::class, 'communityInvite']);
Route::middleware(['auth:sanctum', 'verified'])->post('/community/{id}/invite', [CommunityController::class, 'acceptInvite']);

Route::middleware(['auth:sanctum', 'verified'])->post('/user/profile/info', [UserController::class, 'getProfileInfo'])->name('profileInfo');
Route::middleware(['auth:sanctum', 'verified'])->post('/user/background', [UserController::class, 'updateBackground']);
Route::middleware(['auth:sanctum', 'verified'])->get('/user/background', [UserController::class, 'getBackground']);
Route::middleware(['auth:sanctum', 'verified'])->post('/user/friend', [UserController::class, 'addFriend'])->name('addFriend');
Route::middleware(['auth:sanctum', 'verified'])->get('/user/{id}', [UserController::class, 'getUser']);

/** Movies */
Route::middleware(['auth:sanctum', 'verified'])->get('/movie/search', [MovieController::class, 'showMovieSearch'])->name('search');
Route::middleware(['auth:sanctum', 'verified'])->post('/movie/search', [MovieController::class, 'movieSearch']);

Route::middleware(['auth:sanctum', 'verified'])->get('/movie/{movieId}', [MovieController::class, 'moviePage']);

/** Diary + Reviews */
Route::middleware(['auth:sanctum', 'verified'])->get('/diary', [MovieController::class, 'movieDiary'])->name('diary');
Route::middleware(['auth:sanctum', 'verified'])->get('/diary/{movieId}/create', [MovieController::class, 'showCreateReview']);
Route::middleware(['auth:sanctum', 'verified'])->post('/diary/{movieId}/create', [MovieController::class, 'createReview']);

Route::middleware(['auth:sanctum', 'verified'])->post('/movie/{movieId}/review/{reviewId}/delete', [MovieController::class, 'deleteReview']);

Route::middleware(['auth:sanctum', 'verified'])->get('/movie/{movieId}/review/{reviewId}', [MovieController::class, 'showReview']);
Route::middleware(['auth:sanctum', 'verified'])->get('/movie/{movieId}/reviews/friends', [MovieController::class, 'showFriendReviews']);
Route::middleware(['auth:sanctum', 'verified'])->get('/movie/{movieId}/reviews', [MovieController::class, 'showAllReviews']);

