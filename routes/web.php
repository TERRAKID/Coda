<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\DirectMessageController;

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

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');

Route::middleware(['auth:sanctum', 'verified'])->get('/chat', function () {
    return Inertia::render('Chat/Show');
})->name('chat');

Route::middleware(['auth:sanctum', 'verified'])->get('/chat/users', [DirectMessageController::class, 'listUsers']);
Route::middleware(['auth:sanctum', 'verified'])->get('/chat/{userId}/last', [DirectMessageController::class, 'getLastMessages']);
Route::middleware(['auth:sanctum', 'verified'])->get('/chat/{userId}', [DirectMessageController::class, 'getMessages']);
Route::middleware(['auth:sanctum', 'verified'])->post('/chat/{userId}', [DirectMessageController::class, 'newMessage']);
