<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Connection extends Model
{
    use HasFactory;

    protected $table = 'platform_connections';
    protected $fillable = ['user_id', 'platform_name', 'ign'];

}
