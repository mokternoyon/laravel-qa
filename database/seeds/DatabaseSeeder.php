<?php

use VotablesTableSeeder;
use FavoritesTableSeeder;
use Illuminate\Database\Seeder;
use UserQuestionAnswersTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
       $this->call([
        UserQuestionAnswersTableSeeder::class,
        FavoritesTableSeeder::class,
        VotablesTableSeeder::class,
       ]);
        
    }
}
