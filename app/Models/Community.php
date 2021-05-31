<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Community extends Model
{
    use HasFactory;

    public function user(){
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
}
