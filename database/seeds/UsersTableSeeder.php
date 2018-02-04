<?php
Use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
  public function run()
  { factory(App\User::class, 100)->create(); }
}
