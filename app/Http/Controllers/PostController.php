<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\GameList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    //     private function getGamesFromApi()
    // {
    //     $url = "https://api.rawg.io/api/games?key=73f49a4ddd0d4b999a85172202c1fd85&page_size=50";
    //     $response = @file_get_contents($url);

    //     if ($response === false) {
    //         throw new \Exception('Failed to fetch games from RAWG API');
    //     }

    //     $data = json_decode($response);
    //     return $data->results;
    // }

    private function getGamesFromApi()
    {
        // $multiplayerTagId = 7; // Replace with the actual ID
        // $startDate = date('Y-m-d', strtotime('-7 years')); // 5 years ago from today
        // $endDate = date('Y-m-d'); // Today

        // $url = "https://api.rawg.io/api/games?key=73f49a4ddd0d4b999a85172202c1fd85&tags=" . "multiplayer" . "&page_size=50&dates=" . $startDate . "," . $endDate . "&ordering=-rating";
        // $response = @file_get_contents($url);

        // if ($response === false) {
        //     throw new \Exception('Failed to fetch games from RAWG API');
        // }

        $tags = [
            'e-sports',
            'multiplayer',
        ];

        $tagIds = implode(',', $tags);


        // Build the URL with the combined tag IDs
        $url = "https://api.rawg.io/api/games?key=73f49a4ddd0d4b999a85172202c1fd85&tags=" . $tagIds . "&page_size=50" . "&ordering=-rating";

        // Fetch the response
        $response = @file_get_contents($url);

        $data = json_decode($response);
        return $data->results;
    }

    //populate the game list table with the name of games and image url

    // public function populateGameListTable()
    // {
    //     $games = $this->getGamesFromApi();

    //     foreach ($games as $game) {
    //         $gameList = new GameList;
    //         $gameList->name = $game->name;
    //         $gameList->image = $game->background_image;

    //         $gameList->save();
    //     }


    // }

    public function index(Request $request)
    {

        // $this->populateGameListTable();

        $games = GameList::withCount('posts')->get();
        $gameFilter = $request->query('game');
        $platformFilter = $request->query('platform');

        if ($gameFilter) {
            $posts = Post::with('user', 'gameList')->whereHas('gameList', function ($query) use ($gameFilter) {
                $query->where('name', $gameFilter);
            })->get();
        } else {
            $posts = Post::with('user', 'gameList')->get();
        }

        if ($platformFilter) {
            $posts = $posts->where('platform', $platformFilter);
        }

        $posts->map(function ($post) {
            $post->formatted_creation_date = $post->created_at->format('F d, Y');
            return $post;
        });

        return view('index', compact('posts', 'games'));
    }

    public function allgames()
    {
        //
        //RAWRgame api
        $games = $this->getGamesFromApi();
        // populate a table wth the name of games and image url
        foreach ($games as $game) {
            $game_name = $game->name;
            $game_image = $game->background_image;
            $game_list = new GameList();
            $game_list->name = $game_name;
            $game_list->image = $game_image;
            $game_list->save();
        }
        return view('posts.create', compact('games'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        // $url = "https://api.rawg.io/api/games?key=73f49a4ddd0d4b999a85172202c1fd85&page_size=50";
        // $response = file_get_contents($url);
        // $data = json_decode($response);
        // $games = $data->results;

        //only authenticated users can create a post

        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You need to be logged in to create a post.');
        }

        $games = GameList::all();

        $post = Post::all();
        return view('posts.create', compact('post', 'games'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        error_log(print_r($request->all(), true));

        $data = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'number_of_players' => 'required',
            'platform' => 'required|max:255',
            'game' => 'required|max:255',
        ]);
        $data['user_id'] = auth()->id();
        Post::create($data);

        return redirect()->route('profile.posts')->with('success', 'Post created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    // public function join($postId)
    // {
    //     $user = Auth::user();
    //     $post = Post::findOrFail($postId);

    //     //don't let the creator join their own post
    //     if ($user->id === $post->user_id) {
    //         return redirect()->back()->with('error', 'You cannot join your own post.');
    //     }

    //     if ($user->joinPost($post)) {
    //         $message = 'You have joined the post!';
    //     } else {
    //         $message = 'You have already joined this post.';
    //     }

    //     return redirect()->back()->with('success', $message);
    // }

    public function join($postId)
{
    $user = Auth::user();
    $post = Post::findOrFail($postId);

    if ($user->id === $post->user_id) {
        return redirect()->back()->with('error', 'You cannot join your own post.');
    }

    if ($post->number_of_players >= 6) {
        return redirect()->back()->with('error', 'This post is already full.');
    }

    if ($user->joinPost($post)) {
        $post->number_of_players += 1;
        $post->save();

        $message = 'You have joined the post!';
    } else {
        $message = 'You have already joined this post or the post is full.';
    }

    return redirect()->back()->with('success', $message);
}

    /**
     * Unjoin a post
     */
    public function unjoin($postId)
    {
        $user = Auth::user();
        $post = Post::findOrFail($postId);

        if ($user->unjoinPost($post)) {
            $post->number_of_players = max($post->number_of_players - 1, 0);
            $post->save();

            return redirect()->back()->with('success', 'You have successfully unjoined the post.');
        } else {
            return redirect()->back()->with('error', 'You have not joined this post.');
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        // Check if the authenticated user is the owner of the post
        if (Auth::user()->id !== $post->user_id) {
            return redirect()->back()->with('error', 'You are not authorized to delete this post.');
        }
        $post->delete();

        return redirect()->route('profile.posts')->with('success', 'Post deleted successfully');
    }
}
