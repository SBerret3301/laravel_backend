<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // تشغيل seeder ديال الرحلات
        $this->call([
            VoyageSeeder::class,
        ]);


        $this->call([
            ProduitSeeder::class,
        ]);
        $this->call([
            ArticlesSeeder::class,
        ]);
    }
}
