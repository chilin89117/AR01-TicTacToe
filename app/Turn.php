<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

class Turn extends Model
{
  public $incrementing = false;
  protected $guarded = [];
  // protected $primaryKey = ['id', 'game_id'];

  public function game() 
  { return $this->belongsTo(Game::class, 'game_id'); }
}
