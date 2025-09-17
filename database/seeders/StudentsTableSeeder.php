<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SchoolClass;
use App\Models\Student;
use Faker\Factory as Faker; 

class StudentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $classIds = SchoolClass::pluck('id')->toArray();

        foreach (range(1, 50) as $i) {
            Student::create([
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'email' => $faker->unique()->safeEmail,
                'phone' => $faker->unique()->phoneNumber,
                'dob' => $faker->date('Y-m-d', '-5 years'),
                'gender' => $faker->randomElement(['Male', 'Female']),
                'address' => $faker->address,
                'class_id' => $faker->randomElement($classIds),
            ]);
        }

    }
}
