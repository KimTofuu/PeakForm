<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class legSeeder extends Seeder
{
    public function run()
    {
        $exercises = [
            ['title' => 'Leg Raises',
                'youtube_url' => 'https://www.youtube.com/watch?v=d8BITjLpD1o',
                'muscle_group' => 'Glutes',
                'creator' => 'www.sportsinjuryclinic.net',
            ],
        ];

                foreach ($exercises as $exercise) {
                    DB::table('workout_videos')->insert([
                        'title' => $exercise['title'],
                        'description' => 'Tutorial by ' . $exercise['creator'],
                        'youtube_url' => $exercise['youtube_url'],
                        'muscle_group' => $exercise['muscle_group'],
                        // 'level' => 'Beginner',
                        'duration' => 120,
                        'thumbnail_url' => 'https://img.youtube.com/vi/' . substr($exercise['youtube_url'], -11) . '/hqdefault.jpg',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
}