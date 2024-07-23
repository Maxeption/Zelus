<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;


Route::resource('posts', PostController::class);

Route::resource('profile', ProfileController::class);


Route::resource('auth', AuthController::class);

Route::resource('comment', CommentController::class);


Route::get('/', [PostController::class, 'index'])->name('index');

Route::get('/index', [PostController::class, 'index'])->name('index');

Route::get('/index', [PostController::class, 'index'])->name('posts.index');

Route::get('/create-posts', [PostController::class, 'allgames'])->middleware('auth')->name('allgames');

Route::get('/profile', [ProfileController::class, 'show'])->middleware('auth')->name('profile.show');

Route::get('/profile-posts', [ProfileController::class, 'posts'])->middleware('auth')->name('profile.posts');

Route::post('/user/rating', [UserController::class, 'ajaxStoreRating'])->name('user.rating')->middleware('auth');

//other user profile page

Route::get('/profiles/{username}', [ProfileController::class, 'viewProfile'])->name('profile.view');

//other users posts in their profile

Route::get('/profile-posts/{username}', [ProfileController::class, 'Sposts'])->name('profile.Sposts');

//joined posts

Route::get('/profile-joined', [ProfileController::class, 'Jposts'])->middleware('auth')->name('profile.Jposts');

//login

Route::get('/login', [AuthController::class, 'login'])->name('login');

//authenticate

Route::post('/login', [AuthController::class, 'authenticate'])->name('authenticate');

//register

Route::get('/register', [AuthController::class, 'register'])->name('register');

//logout

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

//profile update

Route::post('/profile/{profile}', [ProfileController::class, 'update'])->name('profile.update')->middleware('auth');

//join post

Route::post('/posts/join/{post}', [PostController::class, 'join'])->name('posts.join')->middleware('auth');

//unjoin post

Route::post('/posts/{post}/unjoin', [PostController::class, 'unjoin'])->name('posts.unjoin')->middleware('auth');

//comments

Route::post('/comment', [CommentController::class, 'store'])->name('comment.store');

//add favorite game in user profile

Route::post('/profile/{profile}', [ProfileController::class, 'addFavGame'])->name('profile.favorite');

//remove favorite game in user profile

Route::delete('/profile/{profile}', [ProfileController::class, 'removeFavGame'])->name('profile.removeFavorite');

//search user

Route::get('/search', [ProfileController::class, 'search'])->name('search');

//user's connected platforms

Route::post('/profile/connect/{platform}/{profile}', [ProfileController::class, 'addConnection'])->name('profile.connect')->middleware('auth');

//get user's connected platforms

Route::get('/profile-connections', [ProfileController::class, 'getConnections'])->name('profile.connections')->middleware('auth');

//see other user's connected platforms

Route::get('/profile-connections/{username}', [ProfileController::class, 'getSconnections'])->name('profile.Sconnections');
