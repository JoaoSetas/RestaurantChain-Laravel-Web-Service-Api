<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Limpar a tabela de utilizadores
        User::truncate();
        
                $faker = \Faker\Factory::create();
        
                // garantir que todos têm a mesma pass-antes do loop para não ficar tão lento
                $password = Hash::make('toptal');
        
                User::create([
                    'name' => 'Administrator',
                    'email' => 'admin@test.com',
                    'password' => $password,
                ]);
        
                // gerar utilizadores
                for ($i = 0; $i < 10; $i++) {
                    User::create([
                        'name' => $faker->name,
                        'email' => $faker->email,
                        'password' => $password,
                    ]);
                }
    }
}
