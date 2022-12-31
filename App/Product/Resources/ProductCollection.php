<?php

namespace App\Product\Resources;
    
use Lewy\DataMapper\ResourceCollection;
    
class ProductCollection extends ResourceCollection
{
    
    public function toArray($request)
    {
        return $this->collection->transform(function($client){
            return new ProductResource($client);
        });
    }
    
}