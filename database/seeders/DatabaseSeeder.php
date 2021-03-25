<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Module;
use App\Models\User;
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
        Module::factory()->create([
            'name' => 'blog'
        ])->each(function ($module) {
            User::factory(10)->create([
                'module' => $module->name
            ])->each(function ($user) use ($module) {
                Article::factory()->create([
                    'module' => $module->name,
                    'user_id' => $user->id
                ]);
            });
        });
    }
}
