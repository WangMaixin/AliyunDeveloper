<?php
namespace Boot\Controller;

use Boot\Error;
use Dotenv\Dotenv;

class Controller {
    public static function run() {
        self::error(true);
    }



    /**
     * Get environment variable
     * @return env
     */
    public static function getenv($name) {
        $dotenv = Dotenv::createImmutable('boot/config/bin');
        $dotenv->load();
        return $_ENV[$name];
    }


    
    private static function error($system_state) {
        return (new Error($system_state))->error();
    }
}
?>