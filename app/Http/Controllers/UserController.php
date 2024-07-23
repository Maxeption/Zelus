<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    //login
    public function login()
    {
        return view("authentification.login");
    }


    //register

    public function register()
    {
        return view("authentification.register");
    }

    //logout

    public function logout()
    {
        Auth::logout();
        return redirect("/index");
    }

    public function ajaxStoreRating(Request $request)
    {

        // Check if the user is logged in
        if (!auth()->check()) {
            return response()->json(['error' => 'You must be logged in to rate users.'], 401);
        }

        // Validate the request data
        $request->validate([
            'rated_user_id' => 'required|integer',
            'rating' => 'required|integer|between:1,5',
        ]);


        $user_id = $request->rated_user_id;
        $rated_by = auth()->id();
        $rating = $request->rating;

        // Check if the user has already rated this user, if so update the rating
        $existingRating = Rating::userRating($user_id, $rated_by)->first();
        if ($existingRating) {
            $existingRating->rating = $rating;
            $existingRating->save();
            return response()->json(['status' => 'success']);
        } else {
        // Create a new rating
        $newRating = new Rating();
        $newRating->user_id = $user_id;
        $newRating->rated_by = $rated_by;
        $newRating->rating = $rating;
        $newRating->save();
        }

        return response()->json(['status' => 'success']);
    }

    //add favorite game


}
