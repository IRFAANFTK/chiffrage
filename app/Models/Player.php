<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    protected $fillable = ['game_session_id', 'name'];

    public function session()
    {
        return $this->belongsTo(GameSession::class);
    }

    public function card()
    {
        return $this->hasOne(Card::class);
    }
}
