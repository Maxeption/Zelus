<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // paginate the comments of the user who's profile is being viewed
        // You can adjust the query to fit your needs, such as filtering by profile_id
        $comments = Comment::with('user') // Assuming you want to load the user relationship
                        ->orderBy('created_at', 'desc') // Order by creation date, for example
                        ->paginate(3); // 10 comments per page
        

        return response()->json($comments);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'profile_id' => 'required',
            'content' => 'required|string',
        ]);
        // Use the authenticated user's ID instead of taking it from the request
         $user_id = auth()->id();

         $comment = Comment::create([
            'user_id' => $user_id, // Use the authenticated user's ID
            'profile_id' => $request->profile_id,
            'content' => $request->content,
         ]);


        // Load the user relationship to access the username
        $comment->load('user');

        //calculate the average rating of the user
        $averageRating = DB::table('user_Rating')
        ->where('user_id', $user_id)
        ->avg('rating');

        return response()->json([
            'username' => $comment->user->username, // Assuming 'username' is the correct column name in your User model
            'content' => $comment->content,
            'averageRating' => round($averageRating, 2),
            'created_at' => $comment->created_at->diffForHumans(), // Format the created_at timestamp
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $Comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $Comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $Comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);

        // Check if the authenticated user is the owner of the comment
        if (Auth::id() !== $comment->user_id) {
            // Optionally, return an error or redirect back with an error message
            return back()->withErrors(['msg' => 'Unauthorized to delete this comment.']);
        }

        // Delete the comment
        $comment->delete();

        // Redirect back or return a success response
        return back()->with('success', 'Comment deleted successfully.');
    }
}
