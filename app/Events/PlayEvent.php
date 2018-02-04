<?php
namespace App\Events;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class PlayEvent implements ShouldBroadcast
{
  use Dispatchable, InteractsWithSockets, SerializesModels;

  public $game_id;
  public $sym;
  public $box;
  public $user_id;

  public function __construct($game_id, $sym, $box, $user_id)
  {
    $this->game_id = $game_id;
    $this->sym     = $sym;
    $this->box     = $box;
    $this->user_id = $user_id;
  }

  public function broadcastOn()
  {
    // Use a unique channel for every player in every game
    return new Channel('game-channel-'.$this->game_id.'-'.$this->user_id);
  }
}
