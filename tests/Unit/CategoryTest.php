<?php

use Tests\TestCase;

class CategoryTest extends TestCase
{

    public function testGetCategories()
    {
        $response = $this->get('/api/category');

        $response->assertStatus(200);
        $this->assertArrayHasKey('data', json_decode($response->getContent(), true));
    }

    public function testGetCategory()
    {
        $response = $this->get('/api/category/1');

        $response->assertStatus(200);
        $this->assertArrayHasKey('data', json_decode($response->getContent(), true));
    }
}
