<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameSession extends Model
{
    protected $fillable = ['code'];
    protected $table = 'game_sessions';

    public function players()
    {
        return $this->hasMany(Player::class);
    }
}
