<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Teacher;
use Faker\Factory as Faker;

class TeachersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        foreach (range(1, 25) as $i) {
            Teacher::create([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'phone' => $faker->unique()->phoneNumber,
                'qualification' => $faker->randomElement(['B.Ed', 'M.Ed', 'B.Sc', 'M.Sc', 'PhD', 'BBA']),
                'subject' => $faker->randomElement(['Math', 'English', 'Science', 'History', 'Geography', 'Business Studies']),
                'address' => $faker->address,
            ]);
        }
    }
}
