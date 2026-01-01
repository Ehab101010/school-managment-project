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
    {$this->call(UserSeeder::class);

        // $this->call([
        //     UserSeeder::class,
        //     ParentSeeder::class,
        //     TeacherSeeder::class,
        //     StudentSeeder::class,
        //     SectionSeeder::class,
        //     ClassSeeder::class,
        //     SubjectSeeder::class,
        //     ClassAssignmentSeeder::class,
        //     WeeklyScheduleSeeder::class,
        //     LearningContentSeeder::class,
        //     ExamScheduleSeeder::class,
        //     GradeSeeder::class,
        // ]);
    }
}
