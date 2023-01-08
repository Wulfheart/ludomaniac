<?php

namespace Database\Seeders;

use Domain\Core\Models\Variant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VariantSeeder extends Seeder
{
    public function run(): void
    {
        Variant::create([
            'name' => 'Klassisch',
        ]);
    }
}
