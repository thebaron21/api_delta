<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        \App\Models\Product::factory(100)->create();
        \App\Models\TypeProduct::factory(1000)->create(); 
        \App\Models\News::factory(1000)->create();  
        \App\Models\Video::factory(1000)->create();  
        \App\Models\VideoCategory::factory(100)->create();
        \App\Models\Studio::factory(100)->create();  
    }
}
