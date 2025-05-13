<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Voyage;

class VoyageSeeder extends Seeder
{
    public function run(): void
    {
        $voyages = [];

        for ($i = 0; $i < 60; $i++) {
            $voyages[] = [
                'destination' => fake()->city(),
                'date_debut' => fake()->dateTimeBetween('2025-04-01', '2025-12-31')->format('Y-m-d'),
                'date_fin' => fake()->dateTimeBetween('2025-06-01', '2026-01-31')->format('Y-m-d'),
                'prix' => fake()->numberBetween(500, 3000),
                'image' => 'https://picsum.photos/seed/voyage' . $i . '/300/300',
            ];
        }

        foreach ($voyages as $voyage) {
            Voyage::create($voyage);
        }
    }
}
