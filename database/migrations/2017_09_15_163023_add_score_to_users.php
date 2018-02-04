<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddScoreToUsers extends Migration
{
  public function up()
  {
    Schema::table('users', function (Blueprint $table) {
      $table->integer('score')->after('password');
    });
  }

  public function down()
  {
    Schema::table('users', function (Blueprint $table) {
      $table->dropColumn('score');
    });
  }
}
