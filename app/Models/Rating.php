<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = [
        'player_id',
        'user_id',
        'rating',
        'user_comment'
    ];

    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class);
    }

    //add team

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
