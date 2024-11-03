<?php

use App\Http\Controllers\CommentsController;
use App\Http\Controllers\MatchController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\TeamController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

//Route::get('/', function () {
//    return Inertia::render('Welcome', [
//        'canLogin' => Route::has('login'),
//        'canRegister' => Route::has('register'),
//        'laravelVersion' => Application::VERSION,
//        'phpVersion' => PHP_VERSION,
//    ]);
//});

Route::get('/', function () {
    return Inertia::render('LandingPage');
})->name('landing-page');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::resource('comments', CommentsController::class)
    ->only(['index', 'store'])
    ->middleware(['auth', 'verified']);

Route::resource('teams', TeamController::class)->only(['index', 'show', 'getTeams']);
Route::resource('players', PlayerController::class)->only(['index', 'show']);
Route::resource('ratings', RatingController::class)->only(['index', 'store']);

//Route::get('teams', [TeamController::class, 'getTeams'])->name('teams.getTeams');


Route::get('/todays-matches', [MatchController::class, 'getTodaysMatches'])->name('todays-matches');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
