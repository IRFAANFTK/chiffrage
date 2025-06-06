<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    protected $fillable = ['game_session_id', 'name', 'card'];

    public function gameSession()
    {
        return $this->belongsTo(GameSession::class);
    }

}
