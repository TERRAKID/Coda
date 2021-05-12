<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserFollow extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id_1',
        'user_id_2',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_follow';
}
