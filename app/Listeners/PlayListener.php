<?php
namespace App\Listeners;

use App\Events\PlayEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class PlayListener
{
  public function __construct()
  {
    //
  }

  public function handle(PlayEvent $event)
  {
    //
  }
}
