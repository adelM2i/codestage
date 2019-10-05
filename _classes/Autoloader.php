<?php

/**
 * Class Autoloader
 */
class Autoloader
{
    /**
     * Enregistrer l'autoloader
     */
    static function register()
    {
        spl_autoload_register(array(__CLASS__, 'autoload'));
    }

    static function autoload($class_name)
    {
        require '_classes/'.$class_name.'.php';
    }
}