<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Rating;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'username',
        'email',
        'password',
        'rating',
    ];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    // protected function casts(): array
    // {
    //     return [
    //         'email_verified_at' => 'datetime',
    //         'password' => 'hashed',
    //     ];
    // }

    protected $casts = [
        'email_verified_at' => 'datetime',
        // Add other attributes to cast here
    ];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function favoriteGames(){
        return $this->belongsToMany(GameList::class, 'fav_games', 'user_id', 'game_id');
    }

    public function joinedPosts()
    {
        return $this->belongsToMany(Post::class, 'user_post', 'user_id', 'post_id');
    }

    public function joinPost($post)
    {

                // If $post is an integer, assume it's the post ID and retrieve the Post object
        if (is_int($post)) {
            $post = Post::find($post);
            // Optionally, handle the case where the post does not exist
            if (!$post) {
                return false; // Or throw an exception, based on your application's needs
            }
        }

        // Check if the user has already joined the post to prevent duplicates
        if (!$this->joinedPosts()->where('post_id', $post->id)->exists()) {
            $this->joinedPosts()->attach($post->id);
            return true; // Joined.*successfully
        }
        return false; // Already joined
    }

    public function unjoinPost($post)
    {
        // If $post is an integer, assume it's the post ID and retrieve the Post object
        if (is_int($post)) {
            $post = Post::find($post);
            // Optionally, handle the case where the post does not exist
            if (!$post) {
                return false; // Or throw an exception, based on your application's needs
            }
        }

        // Check if the user has joined the post to allow unjoining
        if ($this->joinedPosts()->where('post_id', $post->id)->exists()) {
            $this->joinedPosts()->detach($post->id);
            return true; // Unjoined successfully
        }
        return false; // Not joined
    }

    //user ratings
    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function comments()
{
    return $this->hasMany(Comment::class, 'user_id');
}

public function getAverageRatingAttribute()
{
    // Check if the ratings relationship is already loaded to avoid additional queries
    if ($this->relationLoaded('ratings')) {
        // If ratings are loaded, calculate the average from the collection
        $average = $this->ratings->avg('rating');
    } else {
        // If ratings are not loaded, calculate the average using a query
        $average = $this->ratings()->avg('rating');
    }

    return $average ? round($average, 2) : null; // Round to 2 decimal places or return null if no ratings
}

//connected platforms

public function connections()
{
    return $this->hasMany(Connection::class, 'user_id', 'id');
}

}
