<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FactMyth extends Model
{
    /** @use HasFactory<\Database\Factories\FactMythFactory> */
    use HasFactory;
    protected $fillable = [
        'question',
        'is_fact',
        'explanation',
        'correct_label',
        'category'
    ];
}
