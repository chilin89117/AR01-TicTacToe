<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGamesTable extends Migration
{
  public function up()
  {
    Schema::create('games', function (Blueprint $table) {
      $table->increments('id');
      $table->integer('winner_id')->unsigned()->nullable();
      $table->foreign('winner_id')->references('id')->on('users');
      $table->timestamp('end_date')->nullable();
      $table->timestamps();
    });
  }

  public function down()
  { Schema::dropIfExists('games'); }
}
