<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WorkoutVideoSeeder extends Seeder
{
    public function run()
    {
        $exercises = [
        // BODYWEIGHT & HOME
        [
            'title' => 'Push-Ups',
            'youtube_url' => 'https://www.youtube.com/watch?v=_l3ySVKYVJ8',
            'muscle_group' => 'Chest',
            'creator' => 'Calisthenicmovement',
        ],
        [
            'title' => 'Overhead Dumbbell Press',
            'youtube_url' => 'https://www.youtube.com/watch?v=B-aVuyhvLHU',
            'muscle_group' => 'Shoulders',
            'creator' => 'ScottHermanFitness',
        ],
        [
            'title' => 'Incline Pushups',
            'youtube_url' => 'https://www.youtube.com/watch?v=yAbg3_pJKvw',
            'muscle_group' => 'Upper Chest',
            'creator' => 'HASfit',
        ],
        [
            'title' => 'Wall Pushups',
            'youtube_url' => 'https://www.youtube.com/watch?v=YB0egDzsu18',
            'muscle_group' => 'Chest',
            'creator' => 'LivestrongWoman',
        ],
        [
            'title' => 'Resistance Band Rows',
            'youtube_url' => 'https://www.youtube.com/watch?v=LSkyinhmA8k',
            'muscle_group' => 'Back',
            'creator' => 'Jeremy Ethier',
        ],
        [
            'title' => 'Superman Pulls',
            'youtube_url' => 'https://www.youtube.com/watch?v=z6PJMT2y8GQ',
            'muscle_group' => 'Lower Back',
            'creator' => 'Wellness Plus',
        ],
        [
            'title' => 'Pull Extensions',
            'youtube_url' => 'https://www.youtube.com/watch?v=ph3pddpKzzw',
            'muscle_group' => 'Back',
            'creator' => 'Strength Camp',
        ],
        [
            'title' => 'Doorway Rows',
            'youtube_url' => 'https://www.youtube.com/watch?v=eCojBl6k_HE',
            'muscle_group' => 'Back',
            'creator' => 'The Prehab Guys',
        ],
        [
            'title' => 'Bodyweight Squats',
            'youtube_url' => 'https://www.youtube.com/watch?v=aclHkVaku9U',
            'muscle_group' => 'Quads',
            'creator' => 'Nuffield Health',
        ],
        [
            'title' => 'Lunges',
            'youtube_url' => 'https://www.youtube.com/watch?v=QOVaHwm-Q6U',
            'muscle_group' => 'Quads',
            'creator' => 'FitnessBlender',
        ],
        [
            'title' => 'Glute Bridges',
            'youtube_url' => 'https://www.youtube.com/watch?v=Xp33YgPZgns',
            'muscle_group' => 'Glutes',
            'creator' => 'K’s Perfect Fitness TV',
        ],
        [
            'title' => 'Wall Sits',
            'youtube_url' => 'https://www.youtube.com/watch?v=-cdph8hv0O0',
            'muscle_group' => 'Quads',
            'creator' => 'Howcast',
        ],
        [
            'title' => 'Pike Push-Ups',
            'youtube_url' => 'https://www.youtube.com/watch?v=2pLT-olgUJs',
            'muscle_group' => 'Shoulders',
            'creator' => 'FitnessBlender',
        ],
        [
            'title' => 'Chair Dips',
            'youtube_url' => 'https://www.youtube.com/watch?v=ktSTgz8KXvo',
            'muscle_group' => 'Triceps',
            'creator' => 'Calisthenicmovement',
        ],
        [
            'title' => 'Handstand Holds',
            'youtube_url' => 'https://www.youtube.com/watch?v=KNC5lkoE2Fs',
            'muscle_group' => 'Shoulders',
            'creator' => 'THENX',
        ],
        [
            'title' => 'Resistance Band Press',
            'youtube_url' => 'https://www.youtube.com/watch?v=j3ccNPK-P4U',
            'muscle_group' => 'Chest',
            'creator' => 'MindyShaneFitness',
        ],
        [
            'title' => 'Inverted Rows (Under Table)',
            'youtube_url' => 'https://www.youtube.com/watch?v=DfVqXebqoaw',
            'muscle_group' => 'Back',
            'creator' => 'Mind Pump TV',
        ],
        [
            'title' => 'Band Pull-Aparts',
            'youtube_url' => 'https://www.youtube.com/watch?v=smSSXITNpCI',
            'muscle_group' => 'Rear Delts',
            'creator' => 'ATHLEAN-X',
        ],
        [
            'title' => 'Towel Curls',
            'youtube_url' => 'https://www.youtube.com/watch?v=RVbYKwWwauU',
            'muscle_group' => 'Biceps',
            'creator' => 'The Home Gym',
        ],
        [
            'title' => 'Bulgarian Split Squats',
            'youtube_url' => 'https://www.youtube.com/watch?v=2C-uNgKwPLE',
            'muscle_group' => 'Quads',
            'creator' => 'MadFit',
        ],
        [
            'title' => 'Jump Squats',
            'youtube_url' => 'https://www.youtube.com/watch?v=CVaEhXotL7M',
            'muscle_group' => 'Quads',
            'creator' => 'Athlean-X',
        ],
        [
            'title' => 'Step-Ups',
            'youtube_url' => 'https://www.youtube.com/watch?v=dQqApCGd5Ss',
            'muscle_group' => 'Quads',
            'creator' => 'FitnessBlender',
        ],
        [
            'title' => 'Handstand Push-Ups',
            'youtube_url' => 'https://www.youtube.com/watch?v=PDKmh0OJ6Ic',
            'muscle_group' => 'Shoulders',
            'creator' => 'FitnessFAQs',
        ],
        [
            'title' => 'Archer Push-Ups',
            'youtube_url' => 'https://www.youtube.com/watch?v=A0r8ploEnZY',
            'muscle_group' => 'Chest',
            'creator' => 'TACalisthenics',
        ],
        [
            'title' => 'Clap Push-Ups',
            'youtube_url' => 'https://www.youtube.com/watch?v=ISYbQj-t5yQ',
            'muscle_group' => 'Chest',
            'creator' => 'Freeletics',
        ],
        [
            'title' => 'Pseudo Planche Push-Ups',
            'youtube_url' => 'https://www.youtube.com/watch?v=i-gSmqe9tNw',
            'muscle_group' => 'Chest',
            'creator' => 'Calisthenicmovement',
        ],
        [
            'title' => 'Towel Rows',
            'youtube_url' => 'https://www.youtube.com/watch?v=SwaQJctxcGk',
            'muscle_group' => 'Back',
            'creator' => 'Calisthenicmovement',
        ],
        [
            'title' => 'Band Face Pulls',
            'youtube_url' => 'https://www.youtube.com/watch?v=IndIttUTNMU',
            'muscle_group' => 'Rear Delts',
            'creator' => 'PRBreaker',
        ],
        [
            'title' => 'Door Pulls',
            'youtube_url' => 'https://www.youtube.com/watch?v=WE1OzSnp2oI',
            'muscle_group' => 'Back',
            'creator' => 'Calisthenicmovement',
        ],
        [
            'title' => 'Backpack Curls',
            'youtube_url' => 'https://www.youtube.com/watch?v=dKqtGGScQhQ',
            'muscle_group' => 'Biceps',
            'creator' => 'Calisthenicmovement',
        ],
        [
            'title' => 'Pistol Squats',
            'youtube_url' => 'https://www.youtube.com/watch?v=T2ZIdwvsq1w',
            'muscle_group' => 'Quads',
            'creator' => 'FitnessFAQs',
        ],
        [
            'title' => 'Jump Lunges',
            'youtube_url' => 'https://www.youtube.com/watch?v=cIkkHg8YZQU',
            'muscle_group' => 'Quads',
            'creator' => 'FitnessBlender',
        ],
        [
            'title' => 'Wall Sit Marches',
            'youtube_url' => 'https://www.youtube.com/watch?v=k8sLPlsrybA',
            'muscle_group' => 'Quads',
            'creator' => 'Catalyst Athletics',
        ],
        [
            'title' => 'Single-Leg Glute Bridges',
            'youtube_url' => 'https://www.youtube.com/watch?v=egs6m4J8u8c',
            'muscle_group' => 'Glutes',
            'creator' => 'Calisthenicmovement',
        ],

        // GYM/WEIGHTED
        [
            'title' => 'Machine Chest Press',
            'youtube_url' => 'https://www.youtube.com/watch?v=sqNwDkUU_Ps',
            'muscle_group' => 'Chest',
            'creator' => 'ScottHermanFitness',
        ],
        [
            'title' => 'Overhead Dumbbell Press',
            'youtube_url' => 'https://www.youtube.com/watch?v=B-aVuyhvLHU',
            'muscle_group' => 'Shoulders',
            'creator' => 'ScottHermanFitness',
        ],
        [
            'title' => 'Tricep Pushdowns',
            'youtube_url' => 'https://www.youtube.com/watch?v=2-LAMcpzODU',
            'muscle_group' => 'Triceps',
            'creator' => 'Jeff Nippard',
        ],
        [
            'title' => 'Incline Machine Press',
            'youtube_url' => 'https://www.youtube.com/watch?v=tiWPSwt8_zM',
            'muscle_group' => 'Chest',
            'creator' => 'Bodybuilding.com',
        ],
        [
            'title' => 'Lat Pulldown',
            'youtube_url' => 'https://www.youtube.com/watch?v=CAwf7n6Luuc',
            'muscle_group' => 'Back',
            'creator' => 'Bodybuilding.com',
        ],
        [
            'title' => 'Cable Rows',
            'youtube_url' => 'https://www.youtube.com/watch?v=GZbfZ033f74',
            'muscle_group' => 'Back',
            'creator' => 'Bodybuilding.com',
        ],
        [
            'title' => 'EZ Bar Curls',
            'youtube_url' => 'https://www.youtube.com/watch?v=-gSM-kqNlUw',
            'muscle_group' => 'Biceps',
            'creator' => 'Bodybuilding.com',
        ],
        [
            'title' => 'Face Pulls',
            'youtube_url' => 'https://www.youtube.com/watch?v=rep-qVOkqgk',
            'muscle_group' => 'Rear Delts',
            'creator' => 'Athlean-X',
        ],
        [
            'title' => 'Leg Press',
            'youtube_url' => 'https://www.youtube.com/watch?v=uTeqMaWQLL8',
            'muscle_group' => 'Quads',
            'creator' => 'Bodybuilding.com',
        ],
        [
            'title' => 'Seated Leg Curl',
            'youtube_url' => 'https://www.youtube.com/watch?v=WGih6WFr3uI',
            'muscle_group' => 'Hamstrings',
            'creator' => 'Jeff Nippard',
        ],
        [
            'title' => 'Glute Kickbacks',
            'youtube_url' => 'https://www.youtube.com/watch?v=SqO-VUEak2M',
            'muscle_group' => 'Glutes',
            'creator' => 'Bodybuilding.com',
        ],
        [
            'title' => 'Calf Raises',
            'youtube_url' => 'https://www.youtube.com/watch?v=YMmgqO8Jo-k',
            'muscle_group' => 'Calves',
            'creator' => 'Athlean-X',
        ],
        [
            'title' => 'Bench Press',
            'youtube_url' => 'https://www.youtube.com/watch?v=SCVCLChPQFY',
            'muscle_group' => 'Chest',
            'creator' => 'Bodybuilding.com',
        ],
        [
            'title' => 'Shoulder Press',
            'youtube_url' => 'https://www.youtube.com/watch?v=qEwKCR5JCog',
            'muscle_group' => 'Shoulders',
            'creator' => 'ScottHermanFitness',
        ],
        [
            'title' => 'Tricep Extensions',
            'youtube_url' => 'https://www.youtube.com/watch?v=nRiJVZDpdL0',
            'muscle_group' => 'Triceps',
            'creator' => 'ATHLEAN-X',
        ],
        [
            'title' => 'Dumbbell Flys',
            'youtube_url' => 'https://www.youtube.com/watch?v=bgC53-J-6gA',
            'muscle_group' => 'Chest',
            'creator' => 'ScottHermanFitness',
        ],
        [
            'title' => 'Pull-Ups',
            'youtube_url' => 'https://www.youtube.com/watch?v=yHuiTeCG4AM',
            'muscle_group' => 'Back',
            'creator' => 'ATHLEAN-X',
        ],
        [
            'title' => 'Barbell Rows',
            'youtube_url' => 'https://www.youtube.com/watch?v=FWJR5Ve8bnQ',
            'muscle_group' => 'Back',
            'creator' => 'Bodybuilding.com',
        ],
        [
            'title' => 'Hammer Curls',
            'youtube_url' => 'https://www.youtube.com/watch?v=zC3nLlEvin4',
            'muscle_group' => 'Biceps',
            'creator' => 'Bodybuilding.com',
        ],
        [
            'title' => 'Squats',
            'youtube_url' => 'https://www.youtube.com/watch?v=aclHkVaku9U',
            'muscle_group' => 'Quads',
            'creator' => 'Nuffield Health',
        ],
        [
            'title' => 'Deadlifts',
            'youtube_url' => 'https://www.youtube.com/watch?v=op9kVnSso6Q',
            'muscle_group' => 'Hamstrings',
            'creator' => 'ATHLEAN-X',
        ],
        [
            'title' => 'Incline Bench Press',
            'youtube_url' => 'https://www.youtube.com/watch?v=8iPEnn-ltC8',
            'muscle_group' => 'Chest',
            'creator' => 'ScottHermanFitness',
        ],
        [
            'title' => 'Arnold Press',
            'youtube_url' => 'https://www.youtube.com/watch?v=6Z15_WdXmVw',
            'muscle_group' => 'Shoulders',
            'creator' => 'Bodybuilding.com',
        ],
        [
            'title' => 'Skull Crushers',
            'youtube_url' => 'https://www.youtube.com/watch?v=d_KZxkY_0cM',
            'muscle_group' => 'Triceps',
            'creator' => 'ATHLEAN-X',
        ],
        [
            'title' => 'Cable Crossovers',
            'youtube_url' => 'https://www.youtube.com/watch?v=taI4XduLpTk',
            'muscle_group' => 'Chest',
            'creator' => 'ScottHermanFitness',
        ],
        [
            'title' => 'Weighted Pull-Ups',
            'youtube_url' => 'https://www.youtube.com/watch?v=KOw6VhY8McQ',
            'muscle_group' => 'Back',
            'creator' => 'Bodybuilding.com',
        ],
        [
            'title' => 'T-Bar Rows',
            'youtube_url' => 'https://www.youtube.com/watch?v=rvbjGSQ2tVE',
            'muscle_group' => 'Back',
            'creator' => 'ATHLEAN-X',
        ],
        [
            'title' => 'Preacher Curls',
            'youtube_url' => 'https://www.youtube.com/watch?v=Zbs3ko8ycyg',
            'muscle_group' => 'Biceps',
            'creator' => 'Bodybuilding.com',
        ],
        [
            'title' => 'Cable Face Pulls',
            'youtube_url' => 'https://www.youtube.com/watch?v=rep-qVOkqgk',
            'muscle_group' => 'Rear Delts',
            'creator' => 'ATHLEAN-X',
        ],
        [
            'title' => 'Front Squats',
            'youtube_url' => 'https://www.youtube.com/watch?v=uYumuL_G_V0',
            'muscle_group' => 'Quads',
            'creator' => 'Bodybuilding.com',
        ],
        [
            'title' => 'Romanian Deadlifts',
            'youtube_url' => 'https://www.youtube.com/watch?v=WIcpu2UkJoY',
            'muscle_group' => 'Hamstrings',
            'creator' => 'ATHLEAN-X',
        ],
        [
            'title' => 'Hack Squats',
            'youtube_url' => 'https://www.youtube.com/watch?v=0tn5K9NlCfo',
            'muscle_group' => 'Quads',
            'creator' => 'Bodybuilding.com',
        ],
        [
            'title' => 'Hip Thrusts',
            'youtube_url' => 'https://www.youtube.com/watch?v=LM8XHLYJoYs',
            'muscle_group' => 'Glutes',
            'creator' => 'Bodybuilding.com',
        ],
        ['title' => 'Back Extensions',
            'youtube_url' => 'https://www.youtube.com/watch?v=ENXyYltB7CM',
            'muscle_group' => 'Back',
            'creator' => 'Rehab My Patient',
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
