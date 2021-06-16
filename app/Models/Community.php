<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Laravel\Scout\Searchable;

class Community extends Model
{
    use HasFactory;
    use Searchable;

    public function user()
    {
        return $this->hasMany(User::class);
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'visibility',
        'community_photo_path',
        'background_photo_path',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'community';

    public function searchableAs()
    {
        return 'community_index';
    }

    public function messages()
    {
        return $this->hasMany(CommunityMessage::class);
    }
}
