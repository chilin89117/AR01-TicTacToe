<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
  protected $guarded = [];

  public function turns() 
  { return $this->hasMany(Turn::class, 'game_id'); }
}
