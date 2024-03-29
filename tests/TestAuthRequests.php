<?php

namespace Tests;

trait TestAuthRequests
{

    public function testCreateResource()
    {
        $response = $this->actingAs($this->getAuthUser())->post('/api/'.$this->endPointName, $this->createParams);

        $response->assertStatus(201);
    }

    public function testUpdateResource()
    {
        // Get resource of which we created in the create test
        $entity = $this->getRepository()
                ->queryBuilder(function($m){
                    return $m->latest();
                })->entity();

        $response = $this->actingAs($this->getAuthUser())->put('/api/'.$this->endPointName.'/'.$entity->getId(), $this->updateParams);

        $response->assertStatus(200);
    }

    public function testGetResources()
    {
        $response = $this->actingAs($this->getAuthUser())->get('/api/'.$this->endPointName);

        $response->assertStatus(200);
        $this->assertArrayHasKey('data', json_decode($response->getContent(), true));
    }

    public function testGetResource()
    {
        // Get resource of which we created in the create test
        $entity = $this->getRepository()
                ->queryBuilder(function($m){
                    return $m->latest();
                })->entity();

        $response = $this->actingAs($this->getAuthUser())->get('/api/'.$this->endPointName.'/'.$entity->getId());

        $response->assertStatus(200);
        $this->assertArrayHasKey('data', json_decode($response->getContent(), true));
    }

    public function testDeleteResource()
    {
        // Get resource of which we created in the create test
        $entity = $this->getRepository()
                ->queryBuilder(function($m){
                    return $m->latest();
                })->entity();

        $response = $this->actingAs($this->getAuthUser())->delete('/api/'.$this->endPointName.'/'.$entity->getId());

        $response->assertStatus(200);
    }

    public function testCannotGetResourceNotBelongingToYou()
    {
        // Get a resource that doesn't belong to our authenticated user
        $entity = $this->getRepository()->whereOperator('user_id', '!=', $this->getAuthUser()->id)->entity();

        $response = $this->actingAs($this->getAuthUser())->get('/api/'.$this->endPointName.'/'.$entity->getId());

        $response->assertStatus(403);
    }

    public function testCannotGetResourcesNotBelongingToYou()
    {
        $response = $this->actingAs($this->getAuthUser())->get('/api/'.$this->endPointName);

        $json = json_decode($response->getContent(), true);

        $response->assertStatus(200);
        $this->assertArrayHasKey('data', $json, true);

        // Check if each resource has user_id of the authenticated user we're using
        foreach($json['data'] as $j)
            $this->assertTrue($j['user_id'] === $this->getAuthUser()->id);

    }

    public function testCannotUpdateResourceNotBelongingToYou()
    {
        // Get resource that doesn't belong to authenticated user
        $entity = $this->getRepository()->whereOperator('user_id', '!=', $this->getAuthUser()->id)->entity();

        $response = $this->actingAs($this->getAuthUser())->put('/api/'.$this->endPointName.'/'.$entity->getId(), $this->updateParams);

        $response->assertStatus(403);
    }

    public function testCannotDeleteResourceNotBelongingToYou()
    {
        // Get resource that doesn't belong to authenticated user
        $entity = $this->getRepository()->whereOperator('user_id', '!=', $this->getAuthUser()->id)->entity();

        $response = $this->actingAs($this->getAuthUser())->delete('/api/'.$this->endPointName.'/'.$entity->getId());

        $response->assertStatus(403);
    }
}
