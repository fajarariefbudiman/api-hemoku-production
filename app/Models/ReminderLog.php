<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReminderLog extends Model
{
    /** @use HasFactory<\Database\Factories\ReminderLogFactory> */
    use HasFactory;
    protected $fillable = [
        'user_id',
        'date',
        'is_taken',
        'is_menstruating',
        'category',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected $casts = [
        'date' => 'date',
    ];
}
