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
        $pathParts = explode('\\', $class);
        if (is_array($pathParts)) {
            include end($pathParts) . '.php';

            return true;
        }

        return false;
    }
}