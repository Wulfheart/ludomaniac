<?php

namespace Database\Seeders;

use App\Models\Variant;
use Illuminate\Database\Seeder;

class VariantSeeder extends Seeder
{
    public function run(): void
    {
        $classic = Variant::create([
            'name' => 'Klassisch',
        ]);

        $names = ['Deutschland', 'England', 'Frankreich', 'Österreich-Ungarn', 'Italien', 'Russland', 'Osmanisches Reich'];
        foreach ($names as $name) {
            $classic->powers()->create([
                'name' => $name,
            ]);
        }
    }
}
