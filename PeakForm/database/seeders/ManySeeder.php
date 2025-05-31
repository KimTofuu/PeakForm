<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ManySeeder extends Seeder
{
    public function run()
    {
        $exercises = [
            ['title' => 'Mobility Work',
                'youtube_url' => 'https://www.youtube.com/watch?v=WUKHM6-ekJM&t=1s',
                'muscle_group' => 'Mobility',
                'creator' => 'nourishmovelove',
            ],
            ['title' => 'Foam Rolling',
                'youtube_url' => 'https://www.youtube.com/watch?v=Hu-rVZVSzxs',
                'muscle_group' => 'Joints',
                'creator' => 'Caroline Jordan',
            ],
            ['title' => 'Stretching',
                'youtube_url' => 'https://www.youtube.com/watch?v=g1pb2aK2we4',
                'muscle_group' => 'Joints',
                'creator' => 'Caroline Jordan',
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