<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DirectMessage extends Model
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
        'message',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'direct_message';

    public function userOne()
    {
        return $this->hasOne(User::class, 'foreign_key', 'user_id_1');
    }

    public function userTwo()
    {
        return $this->hasOne(User::class, 'foreign_key', 'user_id_2');
    }
}
