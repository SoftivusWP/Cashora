<?php

namespace CashbackTracker\application\bridges;

defined('\ABSPATH') || exit;

/**
 * AbstractBridge class file
 *
 * @author keywordrush.com <support@keywordrush.com>
 * @link https://www.keywordrush.com
 * @copyright Copyright &copy; 2025 keywordrush.com
 */
abstract class AbstractBridge
{

    protected static $instance;

    private function __construct()
    {
    }

    final public static function getInstance()
    {
        if (!static::$instance)
        {
            $class = get_called_class();
            static::$instance = new $class();
        }
        return static::$instance;
    }

    abstract public function init();
}
