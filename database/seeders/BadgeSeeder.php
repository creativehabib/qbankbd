<?php

namespace Database\Seeders;

use App\Models\Badge;
use Illuminate\Database\Seeder;

class BadgeSeeder extends Seeder
{
    public function run(): void
    {
        $badges = [
            [
                'name' => 'Math Genius',
                'description' => 'Scored perfect in Math',
                'icon' => 'calculator',
                'color' => 'blue',
                'requirement_type' => 'subject_mastery',
                'requirement_value' => 100, // percentage or some metric
                'subject_id' => 1, // Assumes Math is ID 1
            ],
            [
                'name' => 'BCS Pro',
                'description' => 'Earned 5000 XP in total',
                'icon' => 'academic-cap',
                'color' => 'amber',
                'requirement_type' => 'xp',
                'requirement_value' => 5000,
                'subject_id' => null,
            ],
            [
                'name' => 'Consistent Learner',
                'description' => 'Maintained a 7-day streak',
                'icon' => 'fire',
                'color' => 'orange',
                'requirement_type' => 'streak',
                'requirement_value' => 7,
                'subject_id' => null,
            ],
            [
                'name' => 'First Blood',
                'description' => 'Took your first exam',
                'icon' => 'star',
                'color' => 'emerald',
                'requirement_type' => 'xp',
                'requirement_value' => 10,
                'subject_id' => null,
            ]
        ];

        foreach ($badges as $badge) {
            Badge::updateOrCreate(['name' => $badge['name']], $badge);
        }
    }
}
