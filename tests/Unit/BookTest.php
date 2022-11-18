<?php

namespace Tests\Unit;

// use PHPUnit\Framework\TestCase;
use Tests\TestCase;
class BookTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_example()
    {
    	$response = $this->call('POST','/login',[
    		'email' => 'arsalan@gmail.com',
    		'password' => 'password',

    	]);
    	dd($response->status());
        $this->assertTrue(true);
    }
}
