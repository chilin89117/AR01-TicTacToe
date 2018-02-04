<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\User;
use App\Game;
use App\Turn;
use App\Events\NewGameEvent;
use Pusher\Pusher;

class HomeController extends Controller
{
  public function __construct()
  { $this->middleware('auth'); }

  public function index(Request $req)
  {
    $me = $req->user();
    $allUsersExceptMe = User::where('id', '!=', $me->id);
    if($req->has('search'))
    { $allUsersExceptMe->where('name', 'like', "%{$req->search}%"); }
    $users = $allUsersExceptMe->paginate(10);
    return view('home', compact('me', 'users'));
  }

  public function newGame(Request $req)
  {
    $invitor = $req->user();  // Invitor always starts with 'X'
    $invitee = $req->invitee; // Invitee always goes second with 'O'
    $game_id = Game::create([])->id;
    for ($i=1; $i<=9; $i++) {
      Turn::create([
        'game_id'   => $game_id,
        'id'        => $i,
        'player_id' => $i % 2 ? $invitor->id : $invitee,
        'sym'       => $i % 2 ? 'X' : 'O',
      ]);
    };
    event(new NewGameEvent($game_id, $invitor->name, $invitee));
    return redirect("/board/{$game_id}");
  }
}
