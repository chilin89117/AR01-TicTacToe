<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDefaultToScore extends Migration
{
  public function up()
  {
    Schema::table('users', function (Blueprint $table) {
      $table->integer('score')->default(0)->change();
    });
  }

  public function down()
  {
    Schema::table('users', function (Blueprint $table) {
      //
    });
  }
}
