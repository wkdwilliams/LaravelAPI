<?php

namespace Core;

class Application extends \Illuminate\Foundation\Application
{
    /**
     * @inheritdoc
     */
    public function path($path = '')
    {
        return $this->basePath . DIRECTORY_SEPARATOR . 'Core' . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }
}