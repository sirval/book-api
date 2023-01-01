<?php

namespace Tests\Unit;

use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class listBookFormatTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
       parent::setUp();
       Artisan::call('db:seed');
    }
   
    public function test_get_create_book_form()
    {
        $response = $this->get('api/v1/book');
        $response->assertStatus(200);
       
    }

    public function test_book_has_name()
    {
       $this->assertDatabaseHas('books', 
            ['book_name' => 'Things Fall Apart']
        ); 
    }
}