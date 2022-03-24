<?php

use App\Product\Repositories\ProductRepository;
use Tests\TestCase;

class ProductTest extends TestCase
{

    public function testGetProducts()
    {
        $response = $this->actingAs($this->getAuthUser())->get('/api/product');

        $response->assertStatus(200);
        $this->assertArrayHasKey('data', json_decode($response->getContent(), true));
    }

    public function testGetProduct()
    {
        $entity = (new ProductRepository())->where([
            'user_id' => $this->getAuthUser()->id
        ])->entity();

        $response = $this->actingAs($this->getAuthUser())->get('/api/product/'.$entity->getId());

        $response->assertStatus(200);
        $this->assertArrayHasKey('data', json_decode($response->getContent(), true));
    }

    // Test you cannot get product that doesn't belong to authenticated user
    public function testCannotGetProductNotBelongingToYou()
    {
        $entity = (new ProductRepository())->whereOperator(
            'user_id', '!=', $this->getAuthUser()->id
        )->entity();

        $response = $this->actingAs($this->getAuthUser())->get('/api/product/'.$entity->getId());

        $response->assertStatus(403);
    }
}
