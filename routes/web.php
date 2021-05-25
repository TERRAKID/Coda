<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\CommunityController;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');

//---Communities----------------------------------
// These routes are used to display and submit the form for creating a new community
Route::get('/community/create', [CommunityController::class, 'createCommunityShowUsers'])->middleware('auth');;
Route::post('/community/create', [CommunityController::class, 'createCommunity'])->middleware('auth');


Route::get('/community/{id}', [CommunityController::class,'showCommunity']);

Route::get('/community/{id}/details', [CommunityController::class, 'communityDetails'])->middleware('auth');
Route::post('/community/{id}/details', [CommunityController::class, 'leaveCommunity'])->middleware('auth');

Route::get('/community/{id}/invite', [CommunityController::class, 'communityInvite'])->middleware('auth');;
Route::post('/community/{id}/invite', [CommunityController::class, 'acceptInvite'])->middleware('auth');


