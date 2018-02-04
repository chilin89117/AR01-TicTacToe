<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Game;
use App\Turn;
use App\Events\PlayEvent;
use App\Events\EndEvent;

class GameController extends Controller
{
  public function board(Request $req, $game_id)
  {
    // If it's a completed game, redirect to dashboard
    if(Game::find($game_id)->end_date != null) {
      return redirect('/home');
    }
    // Get current status of game
    $game = Turn::where('game_id', '=', $game_id)
                ->orderBy('id')
                ->get();
    // Get all the turns that have been played
    $played = $game->where('box', '!=', null);
    // Get all the turns that have not been played
    $notPlayed = $game->where('box', '=', null);
    // Get symbol for logged-in player
    $myId = $req->user()->id;
    $mySym = $game->where('player_id', $myId)->first()->sym;
    // Get "player_id" of opponent
    $opponentId = $game->where('player_id', '!=', $myId)->first()->player_id;
    // Get the "id" of the next Turn
    $next = $notPlayed->first()->id;
    // Array to represent each box (initialized outside the loops)
    $loc = [];
    // Set class names for each square
    $boxClass = [
      'top left',
      'top middle',
      'top right',
      'center left',
      'center middle',
      'center right',
      'bottom left',
      'bottom middle',
      'bottom right'
    ];
    // Initialize each square with default values
    for($i=1; $i<=9; $i++) {
      $loc[$i] = [
        "player_id" => "",
        "class" => $boxClass[$i-1],
        "checked" => false,
        "sym" => $mySym
      ];
    }
    // Update parts of the board that have been played
    for($i=0; $i<$next-1; $i++) {
      $player_id = $played[$i]->player_id;
      $box = $played[$i]->box;
      $sym = $played[$i]->sym;
      $loc[$box] = [
        "player_id" => $player_id,
        "class" => $boxClass[$box-1],
        "checked" => true,
        "sym" => $sym
      ];
    }
    return view('board', compact('loc', 'notPlayed', 'mySym', 'game_id', 'opponentId'));
  }

  public function play(Request $req, $game_id)
  {
    $box = $req->box;
    // Record that a player has taken a turn
    $turn = Turn::where('game_id', '=', $game_id)->whereNull('box')->orderBy('id')->first();
    $turn->box = $box;
    $turn->save();
    // Broadcast event to opponent
    event(new PlayEvent($game_id, $turn->sym, $box, $req->user()->id));
    return response()->json(['status' => 'success', 'data' => 'Your move has been recorded.']);
  }

  public function gameOver(Request $req, $game_id)
  {
    $user = $req->user();
    $box = $req->box;
    // Record that a player has taken a turn
    $turn = Turn::where('game_id', '=', $game_id)->whereNull('box')->orderBy('id')->first();
    $turn->box = $box;
    $turn->save();
    if($req->gameResult == "win") {
			$user->score++;
			$user->save();
		}
		$game = Game::find($game_id);
		$game->end_date = date("Y-m-d H:i:s");
		$game->save();
    // Broadcast event to opponent
    event(new EndEvent($game_id, $req->gameResult, $box, $turn->sym, $req->user()->id));
    return response()->json(['status' => 'success', 'data' => 'Game Over!!!']);
  }
}
