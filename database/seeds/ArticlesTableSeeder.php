<?php

use Illuminate\Database\Seeder;

class ArticlesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //truncar os registos existentes pra começar do 0
        Article::truncate();
        
                $faker = \Faker\Factory::create();
        
                // criar artigos para a bd
                for ($i = 0; $i < 50; $i++) {
                    Article::create([
                        'title' => $faker->sentence,
                        'body' => $faker->paragraph,
                    ]);
                }
    }
}
