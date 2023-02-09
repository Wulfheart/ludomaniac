<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Enums\RankEnum;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            VariantSeeder::class,
        ]);

        User::create([
            'name' => 'Test',
            'email' => 'test@test.de',
            'password' => bcrypt('123'),
            'rank' => RankEnum::A,
            'is_admin' => true,
            'is_game_master' => true,
        ]);

        User::factory(10)->create();
    }
}
