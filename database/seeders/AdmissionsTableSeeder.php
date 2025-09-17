<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Faker\Factory as Faker;

class AdmissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $faker = Faker::create();

        for ($i = 1; $i <= 12; $i++) {
            DB::table('admissions')->insert([
                'serial_no' => 'S' . ($i + 200),
                'registration_no' => 'R' . ($i + 200),
                'admission_no' => 'A' . ($i + 200),
                'session' => '2025',
                'imageUpload' => 'uploads/admissions/sample' . $i . '.jpg',
                'child_relation' => $faker->randomElement(['Son', 'Daughter']),
                'student_name_consent' => $faker->firstName,
                'class_name_consent' => rand(1, 10) . 'th',
                'student_type' => $faker->randomElement(['Day Scholar', 'Hosteler']),
                'student_name' => $faker->name,
                'dob' => $faker->date('Y-m-d', now()->subYears(5)),
                'gender' => $faker->randomElement(['Male', 'Female']),
                'only_child' => $faker->randomElement(['Yes', 'No']),
                'adhaar_no' => $faker->numerify('############'),
                'email' => $faker->unique()->safeEmail,
                'father_name' => $faker->name('male'),
                'father_qualification' => $faker->randomElement(['Graduate', 'Postgraduate', 'PhD']),
                'father_occupation' => $faker->jobTitle,
                'mother_name' => $faker->name('female'),
                'mother_qualification' => $faker->randomElement(['Graduate', 'Postgraduate', 'PhD']),
                'mother_occupation' => $faker->jobTitle,
                'address' => $faker->address,
                'whatsapp_no' => $faker->numerify('9#########'),
                'mobile_no' => $faker->numerify('9#########'),
                'guardian_name' => $faker->name,
                'guardian_relation' => $faker->randomElement(['Uncle', 'Aunt', 'Brother']),
                'nationality' => 'Indian',
                'religion' => $faker->randomElement(['Hindu', 'Muslim', 'Christian', 'Sikh']),
                'weight' => rand(25, 35) . 'kg',
                'blood_group' => $faker->randomElement(['A+', 'B+', 'O+', 'AB+']),
                'category' => $faker->randomElement(['General', 'OBC', 'SC', 'ST']),
                'last_exam_class' => 'Class ' . rand(1, 5),
                'last_exam_school' => $faker->company,
                'last_exam_year' => '2024',
                'last_exam_marks' => rand(60, 99) . '%',
                'applying_for_class' => 'Class ' . rand(2, 8),
                'admitted_to_class' => 'Class ' . rand(2, 8),
                'admission_date' => now()->format('Y-m-d'),
                'language_subject' => $faker->randomElement(['Hindi', 'Urdu', 'Sanskrit']),
                'subjects_offered' => 'Math,Science,EVS',
                'adhaar_card' => 'uploads/admissions/aadhar/sample' . $i . '_aadhar.jpg',
                'status' => $faker->randomElement(['Pending', 'Approved']),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

    }
}



