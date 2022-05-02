<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            'name' => 'iphone 13',
            'author_name' => 'apple',
            'created_at' => new \DateTime(),
            'updated_at' => new \DateTime()
        ]);
    }
}
