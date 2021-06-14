<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovieRating extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'movie_id',
        'watched',
        'rating',
        'review',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'movie_ratings';



    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }
}
