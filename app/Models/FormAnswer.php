<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormAnswer extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'form_question_id',
        'answer',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'form_answer';
}
