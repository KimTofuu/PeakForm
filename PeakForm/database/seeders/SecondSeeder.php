<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SecondSeeder extends Seeder
{
    public function run()
    {
        $exercises = [
            ['title' => 'Planks',
                'youtube_url' => 'https://www.youtube.com/watch?v=pvIjsG5Svck',
                'muscle_group' => 'Abdomen',
                'creator' => 'Childrens Hospital Colorado',
            ],
            ['title' => 'Side Planks',
                'youtube_url' => 'https://www.youtube.com/watch?v=N_s9em1xTqU',
                'muscle_group' => 'Obliques',
                'creator' => 'Childrens Hospital Colorado',
            ],
            ['title' => 'Bird Dogs',
                'youtube_url' => 'https://www.youtube.com/watch?v=HtMI17DGuTk',
                'muscle_group' => 'Legs',
                'creator' => 'CORE Chiropractic',
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