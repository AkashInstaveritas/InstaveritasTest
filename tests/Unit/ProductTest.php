<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testGetProduct()
    {
            $response = $this->json('GET', '/api/categories');

            $response->assertStatus(200);
        }
}
