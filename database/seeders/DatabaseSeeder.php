<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Domain\Users\Enums\RankEnum;
use Domain\Users\Models\User;
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
    }
}
