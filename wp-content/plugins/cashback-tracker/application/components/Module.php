<?php

namespace CashbackTracker\application\components;

defined('\ABSPATH') || exit;

use CashbackTracker\application\components\ModuleManager;
use CashbackTracker\application\helpers\TextHelper;
use CashbackTracker\application\Plugin;

/**
 * Module abstract class file
 *
 * @author keywordrush.com <support@keywordrush.com>
 * @link https://www.keywordrush.com
 * @copyright Copyright &copy; 2025 keywordrush.com
 */
abstract class Module
{

    private $id;
    private $dir;
    protected $is_active;
    protected $name;
    protected $description;
    private $is_custom;
    private $is_configurable;

    public function __construct($module_id = null)
    {
        if ($module_id)
        {
            $this->id = $module_id;
        }
        else
        {
            $parts = explode('\\', get_class($this));
            $this->id = $parts[count($parts) - 2];
        }

        $info = $this->info();
        if (!empty($info['name']))
            $this->name = $info['name'];
        else
            $this->name = $this->id;
    }

    public function info()
    {
        return array();
    }

    final public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getDir()
    {
        if ($this->dir === null)
        {
            $rc = new \ReflectionClass(get_class($this));
            $this->dir = dirname($rc->getFileName()) . DIRECTORY_SEPARATOR;
        }
        return $this->dir;
    }

    public function isActive()
    {
        if ($this->is_active === null)
        {
            // @todo
            $this->is_active = true;
        }
        return $this->is_active;
    }

    final public function isCustom()
    {
        if ($this->is_custom === null)
        {
            // @todo
            $this->is_custom = false;
        }
        return $this->is_custom;
    }

    public function isDeprecated()
    {
        return false;
    }

    public function isConfigurable()
    {
        if ($this->is_configurable === null)
        {
            if (is_file($this->getDir() . $this->getMyPathId() . 'Config.php'))
                $this->is_configurable = true;
            else
                $this->is_configurable = false;
        }
        return $this->is_configurable;
    }

    public function isFree()
    {
        return false;
    }

    public function getConfigInstance()
    {
        return ModuleManager::configFactory($this->getId());
    }

    public function config($opt_name, $default = null)
    {
        if (!$this->getConfigInstance()->option_exists($opt_name))
            return $default;
        else
            return $this->getConfigInstance()->option($opt_name);
    }

    public function render($view_name, $_data = null)
    {
        if (is_array($_data))
            extract($_data, EXTR_PREFIX_SAME, 'data');
        else
            $data = $_data;

        include \CashbackTracker\PLUGIN_PATH . 'application/modules/' . $this->getMyPathId() . '/views/' . TextHelper::clear($view_name) . '.php';
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getMyPathId()
    {
        return self::getPathId($this->getId());
    }

    public function getMyShortId()
    {
        return self::getShortId($this->getId());
    }

    public static function getPathId($module_id)
    {
        return $module_id;
    }

    public function getShortId($module_id)
    {
        return $module_id;
    }

    public function releaseVersion()
    {
        return '';
    }

    public function isNew()
    {
        if (!$module_version = $this->releaseVersion())
            return false;

        $module_version = join('.', array_slice(explode('.', $module_version), 0, 2));
        $plugin_version = join('.', array_slice(explode('.', Plugin::version()), 0, 2));
        if ($module_version == $plugin_version)
            return true;
        else
            return false;
    }

    public function isCashebackModule()
    {
        return false;
    }
}
