<?php
namespace App\Events;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NewGameEvent implements ShouldBroadcast
{
  use Dispatchable, InteractsWithSockets, SerializesModels;

  public $gameId;
  public $invitor;
  public $invitee;

  public function __construct($gameId, $invitor, $invitee)
  {
    $this->gameId  = $gameId;
    $this->invitor = $invitor;
    $this->invitee = $invitee;
  }

  public function broadcastOn()
  { return new Channel('newGameChannel'); }
}
