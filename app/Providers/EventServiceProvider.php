<?php
namespace App\Providers;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
  protected $listen = [
    'App\Events\NewGameEvent' => ['App\Listeners\NewGameListener'],
    'App\Events\PlayEvent' => ['App\Listeners\PlayListener'],
    'App\Events\EndEvent' => ['App\Listeners\EndListener'],
  ];

  public function boot()
  { parent::boot(); }
}
