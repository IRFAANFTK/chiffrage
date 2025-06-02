<?php

namespace App\Http\Controllers;

use App\Events\CardsRevealed;
use App\Events\PlayerJoined;
use App\Models\Card;
use App\Models\Player;
use App\Models\GameSession;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GameSessionController extends Controller
{
    public function create()
    {
        $code = Str::upper(Str::random(6));
        $session = GameSession::create(['code' => $code]);
        return response()->json(['code' => $session->code]);
    }

    public function join(Request $request, $code)
    {
        $session = GameSession::where('code', $code)->firstOrFail();
        $player = Player::create([
            'session_id' => $session->id,
            'name' => $request->name,
        ]);
        broadcast(new PlayerJoined($session))->toOthers();
        return response()->json(['player' => $player]);
    }

    public function chooseCard(Request $request, $code)
    {
        $session = GameSession::where('code', $code)->firstOrFail();
        $player = Player::where('session_id', $session->id)
            ->where('name', $request->user())
            ->first();

        // For simplicity (no auth): identify by name if needed
        if (!$player) {
            $player = $session->players()->where('name', $request->name)->firstOrFail();
        }

        Card::updateOrCreate(
            ['session_id' => $session->id, 'player_id' => $player->id],
            ['card_number' => $request->card_number]
        );

        // Check if all players have chosen
        if ($session->cards()->count() === $session->players()->count()) {
            broadcast(new CardsRevealed($session))->toOthers();
        }

        return response()->json(['message' => 'Card chosen!']);
    }

    public function show($code)
    {
        $session = GameSession::where('code', $code)->with('players')->firstOrFail();
        return response()->json($session);
    }
}
