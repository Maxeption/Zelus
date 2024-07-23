<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameList extends Model
{

public function posts()
{
    return $this->hasMany(Post::class, 'game', 'name');
}

public function favoredByUsers()
{
    return $this->belongsToMany(User::class, 'fav_games');
}
    use HasFactory;
}
