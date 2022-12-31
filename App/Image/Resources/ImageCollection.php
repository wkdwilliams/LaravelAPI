<?php

namespace App\Image\Resources;

use Lewy\DataMapper\ResourceCollection;

class ImageCollection extends ResourceCollection
{

    public function toArray($request)
    {
        return $this->collection->transform(function($client){
            return new ImageResource($client);
        });
    }

}