<?php

namespace Tests;

trait TestRequests
{
    public function testCreateResource()
    {
        $response = $this->post('/api/'.$this->endPointName, $this->createParams);

        $response->assertStatus(201);
    }

    public function testUpdateResource()
    {
        // Get resource of which we created in the create test
        $entity = (new $this->repository)
                ->queryBuilder(function($m){
                    return $m->latest();
                })->entity();

        $response = $this->put('/api/'.$this->endPointName.'/'.$entity->getId(), $this->updateParams);

        $response->assertStatus(200);
    }

    public function testGetResources()
    {
        $response = $this->get('/api/'.$this->endPointName);

        $response->assertStatus(200);
        $this->assertArrayHasKey('data', json_decode($response->getContent(), true));
    }

    public function testGetResource()
    {
        // Get resource of which we created in the create test
        $entity = (new $this->repository)
                ->queryBuilder(function($m){
                    return $m->latest();
                })->entity();

        $response = $this->get('/api/'.$this->endPointName.'/'.$entity->getId());

        $response->assertStatus(200);
        $this->assertArrayHasKey('data', json_decode($response->getContent(), true));
    }

    public function testDeleteResource()
    {
        // Get resource of which we created in the create test
        $entity = (new $this->repository)
                ->queryBuilder(function($m){
                    return $m->latest();
                })->entity();

        $response = $this->delete('/api/'.$this->endPointName.'/'.$entity->getId());

        $response->assertStatus(200);
    }
}