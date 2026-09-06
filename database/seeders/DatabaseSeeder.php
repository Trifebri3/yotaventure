<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@yotainovasi.id'],
            [
                'name' => 'Admin YOIN',
                'password' => bcrypt('password'),
            ]
        );

        $this->call([
            ArticleSeeder::class,
            MenuHighlightSeeder::class,
            ArticleCategorySeeder::class,
            CollaborationSeeder::class,
            EcosystemSeeder::class,
            CompanyProfileSeeder::class,
            CompanyAchievementSeeder::class,
        ]);
    }
}
