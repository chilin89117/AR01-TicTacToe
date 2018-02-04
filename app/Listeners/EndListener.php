<?php
namespace App\Listeners;

use App\Events\EndEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class EndListener
{
  public function __construct()
  {
    //
  }

  public function handle(EndEvent $event)
  {
    //
  }
}
