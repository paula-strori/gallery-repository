<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PhotoCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('photo_categories')->insert([
            ['name'=>'Personal'],
            ['name'=>'Nature'],
            ['name'=>'Technology'],
            ['name'=>'Animals'],
            ['name'=>'Other'],
        ]);
    }
}
