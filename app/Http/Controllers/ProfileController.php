<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Comment;
use App\Models\GameList;
use Illuminate\View\View;
use App\Models\Connection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Post; // Add this line
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ProfileUpdateRequest;

class ProfileController extends Controller
{

    /**
     * Display the user's profile.
     */
    public function show(): View
    {

        $user = Auth::user();

        $avgRating = $user->ratings->avg('rating');

        //limit the decimal to 2.2

        $avgRating = number_format($avgRating, 2);

        //get all games
        $games = GameList::all();

        //get the user's favorite games
        $favoriteGames = $user->favoriteGames;

        return view('profile.show', [
            'user' => $user,
            'avgRating' => $avgRating,
            'games' => $games,
            'favoriteGames' => $favoriteGames,
        ]);
    }

    /**
     * Display the users profiles.
     */

     public function viewProfile($username)
     {
            $user = User::where('username', $username)->firstOrFail();
        // Retrieve the user's comments
            $comments = Comment::where('profile_id', $user->id)->with('user')->get();

         //return the user's posts
            $posts = $user->posts()->latest()->get();

         //return this user's rating
            $avgRating = $user->ratings->avg('rating');
            $avgRating = number_format($avgRating, 2);

         return view('profile.view', [
             'user' => $user,
             'avgRating' => $avgRating,
             'posts' => $posts,
             'comments'=> $comments,
         ]);
     }

     //show other user's posts in their profile

     public function Sposts($username)
     {
         $user = User::where('username', $username)->firstOrFail();
         $posts = $user->posts()->latest()->get();

         return view('profile.Sposts', [
             'user' => $user,
             'posts' => $posts,
         ]);
     }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request)
    {
        // Fill the user's model with validated data
        $user = $request->user();
        $user->fill($request->validated());

        // Check if a new password was provided
        if ($request->filled('new_password')) {
            $user->password = Hash::make($request->new_password);
        }

        // Save the changes to the user
        $user->save();

        // Redirect or return response
        return redirect()->route('profile.show', ['profile' => $user->id])->with('success', 'Profile updated successfully.');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function posts()
    {
        $user = Auth::user();
        return view('profile.posts' , compact('user'));
    }

    public function Jposts()
    {
        $user = Auth::user();
        return view('profile.Jposts', compact('user'));
    }

    //add favorite game

    public function addFavGame(Request $request)
    {

        // Validate the request data
        $request->validate([
            'game_id' => 'required|integer',
        ]);

        $user = auth()->user();
        $game_id = $request->game_id;

        // Check if the user has already added this game to favorites
        if ($user->favoriteGames()->where('game_id', $game_id)->exists()) {
            return redirect()->back()->with('error', 'Game already added to favorites.');
        }

        // Add the game to favorites
        $user->favoriteGames()->attach($game_id);

        return redirect()->back()->with('success', 'Game added to favorites.');
    }

    //remove favorite game
    public function removeFavGame(Request $request)
    {
        // Validate the request data
        $request->validate([
            'game_id' => 'required|integer',
        ]);

        $user = auth()->user();
        $game_id = $request->game_id;

        // Remove the game from favorites
        $user->favoriteGames()->detach($game_id);
        return redirect()->back()->with('success', 'Game removed from favorites.');
    }

    //search user
    public function search(Request $request)
    {
        $search = $request->search;
        $users = User::where('username', 'like', '%' . $search . '%')
                     ->with('favoriteGames')
                     ->get()
                     ->map(function ($user) {
                         $user->avgRating = $user->ratings->avg('rating');
                         $user->postsCount = $user->posts()->count();
                         return $user;
                     });

        return view('search', compact('users'));
    }

    //add plaform accounts

    public function addConnection(Request $request, $platform, $profile)
    {
        $request->validate([
            'IGN' => 'required|string',
        ]);

        $ign = $request->input('IGN');

        $connection = Connection::updateOrCreate(
            [
                'user_id' => $profile,
                'platform_name' => $platform,
            ],
            ['ign' => $ign]
        );

        if ($connection) {
            return redirect()->back()->with('success', 'Platform connected successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to connect platform.');
        }
    }

    //get user's connected platforms

    public function getConnections()
    {
        $user = Auth::user();
        $connections = $user->connections;

        $epicGamesIGN = $connections->where('platform_name', 'epic')->first()->ign ?? 'Not Connected';
        $xboxIGN = $connections->where('platform_name', 'xbox')->first()->ign ?? 'Not Connected';
        $riotIGN = $connections->where('platform_name', 'riot')->first()->ign ?? 'Not Connected';
        $steamIGN = $connections->where('platform_name', 'steam')->first()->ign ?? 'Not Connected';
        $discordIGN = $connections->where('platform_name', 'discord')->first()->ign ?? 'Not Connected';
        $psnIGN = $connections->where('platform_name', 'psn')->first()->ign ?? 'Not Connected';
        $bungieIGN = $connections->where('platform_name', 'bungie')->first()->ign ?? 'Not Connected';


        return view('profile.connections', compact('epicGamesIGN', 'xboxIGN', 'riotIGN', 'steamIGN', 'discordIGN', 'psnIGN', 'bungieIGN'));
    }


    public function showSconnections($username){

        $user = User::where('username', $username)->firstOrFail();

        return view('Sconnections', compact('user'));
    }

    public function getSconnections($username){

        //get the connections of the user who's profile is being viewed

        $user = User::where('username', $username)->firstOrFail();
        $connections = $user->connections;

        $epicGamesIGN = $connections->where('platform_name', 'epic')->first()->ign ?? 'Not Connected';
        $xboxIGN = $connections->where('platform_name', 'xbox')->first()->ign ?? 'Not Connected';
        $riotIGN = $connections->where('platform_name', 'riot')->first()->ign ?? 'Not Connected';
        $steamIGN = $connections->where('platform_name', 'steam')->first()->ign ?? 'Not Connected';
        $discordIGN = $connections->where('platform_name', 'discord')->first()->ign ?? 'Not Connected';
        $psnIGN = $connections->where('platform_name', 'psn')->first()->ign ?? 'Not Connected';
        $bungieIGN = $connections->where('platform_name', 'bungie')->first()->ign ?? 'Not Connected';

        return view('profile.Sconnections', compact('user' ,'epicGamesIGN', 'xboxIGN', 'riotIGN', 'steamIGN', 'discordIGN', 'psnIGN', 'bungieIGN'));
    }

}
