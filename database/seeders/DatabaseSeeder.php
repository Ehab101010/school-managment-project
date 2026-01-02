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

        $this->call([
            // ClassesSeeder::class,
            // SubjectsSeeder::class,
            // TeachersSeeder::class,
            // StudentsSeeder::class,
            // ClassSubjectSeeder::class,
            // ClassAssignmentsSeeder::class,
            // TimetablesSeeder::class,
            // ExamSchedulesSeeder::class,
            // GradesSeeder::class,
            // LearningContentsSeeder::class,
            // UsersSeeder::class,
        ]);
    }
}
