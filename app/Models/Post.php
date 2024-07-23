<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'content',
        'number_of_players',
        'platform',
        'game',
        // 'region',
        //'language',
        'user_id',
    ];


    public function gameList()
    {
        return $this->belongsTo(GameList::class, 'game', 'name');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
