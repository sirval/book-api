<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookSeederTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('books')->insert([
            'book_name' => 'Things Fall Apart',
            'isbn'      => '111111111',
            'pages'     => 1000,
            'date_published'    => '2022-12-12',
            'publisher' => 'Chinua Achebe Publishers',
        ]);
    }
}