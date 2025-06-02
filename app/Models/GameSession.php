<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameSession extends Model
{
    protected $fillable = ['code'];

    public function players()
    {
        return $this->hasMany(Player::class);
    }

    public function cards()
    {
        return $this->hasMany(Card::class);
    }
}
