<?php
namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class EndEvent implements ShouldBroadcast
{
  use Dispatchable, InteractsWithSockets, SerializesModels;

  public $game_id;
  public $gameResult;
  public $box;
  public $sym;
  public $user_id;

  public function __construct($game_id, $gameResult, $box, $sym, $user_id)
  {
    $this->game_id    = $game_id;
    $this->gameResult = $gameResult;
    $this->box        = $box;
    $this->sym        = $sym;
    $this->user_id    = $user_id;
  }

  public function broadcastOn()
  {
    // Use a unique channel for every user in every game
    return new Channel('end-channel-'.$this->game_id.'-'.$this->user_id);
  }
}
