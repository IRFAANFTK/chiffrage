<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    protected $fillable = ['game_session_id', 'player_id', 'card_number'];

    public function player()
    {
        return $this->belongsTo(Player::class);
    }

    public function session()
    {
        return $this->belongsTo(GameSession::class);
    }
}
