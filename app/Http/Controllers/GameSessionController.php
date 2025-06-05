<?php

namespace App\Http\Controllers;

use App\Events\RevealCards;
use App\Models\GameSession;
use App\Models\Player;
use Illuminate\Http\Request;
use App\Events\PlayerJoined;
use App\Events\CardChosen;
use App\Events\RoundReset;

class GameSessionController extends Controller
{
    public function create(Request $request)
    {
        $session = GameSession::create([
            'code' => strtoupper(uniqid())
        ]);

        $player = Player::create([
            'game_session_id' => $session->id,
            'name' => $request->name
        ]);

        broadcast(new PlayerJoined($player))->toOthers();

        return response()->json([
            'session' => $session,
            'player' => $player
        ]);
    }

    public function join($code, Request $request)
    {
        $session = GameSession::where('code', $code)->firstOrFail();

        $player = Player::create([
            'game_session_id' => $session->id,
            'name' => $request->name
        ]);

        broadcast(new PlayerJoined($player))->toOthers();

        return response()->json(['player' => $player]);
    }

    public function getSession($code)
    {
        $session = GameSession::where('code', $code)->with('players')->firstOrFail();
        return response()->json($session);
    }

    public function chooseCard($code, Request $request)
    {
        $player = Player::findOrFail($request->player_id);
        $player->card = $request->card;
        $player->save();

        $sessionCode = $player->gameSession->code;
        $playerId = $player->id;
        $cardValue = $player->card;

        broadcast(new CardChosen($sessionCode, $playerId, $cardValue));

        return response()->json(['status' => 'ok']);
    }

    public function resetRound($code)
    {
        $session = GameSession::where('code', $code)->firstOrFail();
        $session->players()->update(['card' => null]);

        broadcast(new RoundReset($session->code)); // 🔥 sync all players

        return response()->json(['status' => 'ok']);
    }

    public function revealCards($code)
    {
        $session = GameSession::where('code', $code)->firstOrFail();

        broadcast(new RevealCards($session->code));

        return response()->json(['status' => 'cards revealed']);
    }



}
