<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTurnsTable extends Migration
{
  public function up()
  {
    Schema::create('turns', function (Blueprint $table) {
      $table->integer('id');
      $table->integer('player_id')->unsigned();
      $table->foreign('player_id')->references('id')->on('users');
      $table->integer('game_id')->unsigned();
      $table->foreign('game_id')->references('id')->on('games');
      $table->enum('box', [1,2,3,4,5,6,7,8,9])->nullable();
      $table->enum('sym', ['x','o'])->nullable();
      $table->primary(['game_id', 'id']);
      $table->timestamps();
    });
  }

  public function down()
  { Schema::dropIfExists('turns'); }
}
