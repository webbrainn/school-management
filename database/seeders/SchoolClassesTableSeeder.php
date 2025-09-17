<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SchoolClass;

class SchoolClassesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $classNames = ['Nursery', 'KG', 'UKG', '1st', '2nd', '3rd'];
        foreach($classNames as $name){
            SchoolClass::create([
                'name'=>$name,
                'capacity'=> rand(20,40),
            ]);
        }

    }
}
