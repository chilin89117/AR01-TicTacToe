<?php
namespace App\Listeners;
use App\Events\NewGameEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewGameListener
{
  public function __construct()
  { }

  public function handle(NewGameEvent $event)
  { }
}
