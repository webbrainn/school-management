<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Exam;
use App\Models\SchoolClass;
use App\Models\Subject;
use Faker\Factory as Faker; 

class ExamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

         // Sample term options
        $terms = ['Term 1', 'Term 2', 'Term 3'];

        $classIds = DB::table('school_classes')->pluck('id')->toArray();
        $subjectIds = DB::table('subjects')->pluck('id')->toArray();

        if (empty($classIds) || empty($subjectIds)) {
            $this->command->warn('No classes or subjects found. Skipping ExamSeeder.');
            return;
        }

        foreach (range(1, 20) as $i) {
            DB::table('exams')->insert([
                'name' => $faker->randomElement(['Midterm', 'Final', 'Quiz', 'Assessment']) . " Exam",
                'school_classes_id' => $faker->randomElement($classIds),
                'subjects_id' => $faker->randomElement($subjectIds),
                'term' => $faker->randomElement($terms),
                'exam_date' => $faker->date(),
                'start_time' => $faker->time('H:i:s'),
                'end_time' => $faker->time('H:i:s'),
                'max_marks' => 100,
                'pass_marks' => 35,
                'field1' => $faker->word(),
                'field2' => $faker->word(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
