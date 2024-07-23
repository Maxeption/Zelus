<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'rated_by',
        'rating',
    ];

    protected $table = 'user_rating';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ratedBy()
    {
        return $this->belongsTo(User::class, 'rated_by');
    }

    public function scopeUserRating($query, $user_id, $rated_by)
    {
        return $query->where('user_id', $user_id)->where('rated_by', $rated_by);
    }

    public function scopeUserRatings($query, $user_id)
    {
        return $query->where('user_id', $user_id);
    }



}
