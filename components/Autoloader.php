<?php

namespace app\components;

class Autoloader
{
    public function register()
    {
        spl_autoload_register([$this, 'autoload']);
    }

    /**
     * @param string $class
     * @return bool
     */
    protected function autoload(string $class): bool
    {
        $class = str_replace(['app\\','\\'], ['/', '/'], $class);
        include ROOT . $class . '.php';

        return true;
    }
}