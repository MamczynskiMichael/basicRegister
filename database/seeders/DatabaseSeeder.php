<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0; $i < 10; $i++) { 
            DB::table('users')->insert([
                'first_name'=> Str::random(10),
                'last_name' => Str::random(10),
                'email' =>  Str::random(10).'@gmail.com',
                'phone_number' => rand(1000,1500),
                'news_letter' => false,
        
            ]);
        }
        
    }
}
