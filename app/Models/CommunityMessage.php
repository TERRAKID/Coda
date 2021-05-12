<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommunityMessage extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'community_id'
        'user_id',
        'message',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'community_message';
}
