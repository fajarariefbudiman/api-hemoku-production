<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EducationalContent extends Model
{
    /** @use HasFactory<\Database\Factories\EducationalContentFactory> */
    use HasFactory;
    protected $fillable = [
        'title',
        'content',
        'section',
        'description',
        'type',
        'url',
        'order'
    ];
}
