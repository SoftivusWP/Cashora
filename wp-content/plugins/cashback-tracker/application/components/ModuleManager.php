<?php

namespace CashbackTracker\application\components;

defined('\ABSPATH') || exit;

use CashbackTracker\application\Plugin;
use CashbackTracker\application\helpers\TextHelper;

/**
 * ModuleManager class file
 *
 * @author keywordrush.com <support@keywordrush.com>
 * @link https://www.keywordrush.com
 * @copyright Copyright &copy; 2025 keywordrush.com
 */
class ModuleManager
{

    const MODULES_DIR = 'application/modules';

    private static $modules = array();
    private static $active_modules = array();
    private static $configs = array();
    private static $instance = null;

    public static function getInstance()
    {
        if (self::$instance == null)
            self::$instance = new self;

        return self::$instance;
    }

    private function __construct()
    {
        $this->initModules();
    }

    public function adminInit()
    {
        \add_action('parent_file', array($this, 'highlightAdminMenu'));
        foreach ($this->getConfigurableModules() as $module)
        {
            $config = self::configFactory($module->getId());
            $config->adminInit();
        }
    }

    /**
     *  Highlight the proper submenu item
     */
    public function highlightAdminMenu($parent_file)
    {
        global $plugin_page;

        if (substr((string) $plugin_page, 0, strlen(Plugin::slug())) !== Plugin::slug())
            return $parent_file;

        if (!$parent_file)
            $plugin_page = Plugin::slug;
        return $parent_file;
    }

    private function initModules()
    {
        $modules_ids = $this->scanForModules();
        sort($modules_ids);

        // create modules
        foreach ($modules_ids as $module_id)
        {
            // create module
            self::factory($module_id);
        }

        // fill active modules
        foreach (self::$modules as $module)
        {
            if ($module->isActive())
                self::$active_modules[$module->getId()] = $module;
        }
    }

    private function scanForModules($path = null)
    {
        if (!$path)
            $path = \CashbackTracker\PLUGIN_PATH . self::MODULES_DIR . DIRECTORY_SEPARATOR;

        $folder_handle = @opendir($path);
        if ($folder_handle === false)
            return;

        $founded_modules = array();

        while (($m_dir = readdir($folder_handle)) !== false)
        {
            if ($m_dir == '.' || $m_dir == '..')
                continue;
            $module_path = $path . $m_dir;
            if (!is_dir($module_path))
                continue;

            $module_id = $m_dir;
            $founded_modules[] = TextHelper::clear($module_id);
        }
        closedir($folder_handle);
        return $founded_modules;
    }

    public static function factory($module_id)
    {
        if (!isset(self::$modules[$module_id]))
        {
            $path_prefix = Module::getPathId($module_id);
            $module_class = "\\CashbackTracker\\application\\modules\\" . $path_prefix . "\\" . $path_prefix . 'Module';

            if (class_exists($module_class, true) === false)
            {
                throw new \Exception("Unable to load module class: '{$module_class}'.");
            }

            $module = new $module_class($module_id);

            if (!($module instanceof \CashbackTracker\application\components\Module))
            {
                throw new \Exception("The module '{$module_id}' must inherit from Module.");
            }

            self::$modules[$module_id] = $module;
        }
        return self::$modules[$module_id];
    }

    public static function configFactory($module_id)
    {
        if (!isset(self::$configs[$module_id]))
        {
            $path_prefix = Module::getPathId($module_id);
            $config_class = "\\CashbackTracker\\application\\modules\\" . $path_prefix . "\\" . $path_prefix . 'Config';

            if (class_exists($config_class, true) === false)
            {
                throw new \Exception("Unable to load module config class: '{$config_class}'.");
            }
            $config = $config_class::getInstance($module_id);
            if (!($config instanceof \CashbackTracker\application\components\ModuleConfig))
            {
                throw new \Exception("The module config '{$config_class}' must inherit from ModuleConfig.");
            }

            self::$configs[$module_id] = $config;
        }

        return self::$configs[$module_id];
    }

    public function getModules($only_active = false)
    {
        if ($only_active)
            return self::$active_modules;
        else
            return self::$modules;
    }

    public function getModulesIdList($only_active = false)
    {
        return array_keys($this->getModules($only_active));
    }

    public function getConfigurableModules()
    {
        $result = array();
        foreach ($this->getModules() as $module)
        {
            if ($module->isConfigurable())
                $result[] = $module;
        }
        return $result;
    }

    public function moduleExists($module_id)
    {
        if (isset(self::$modules[$module_id]))
            return true;
        else
            return false;
    }

    public function isModuleActive($module_id)
    {
        if (isset(self::$active_modules[$module_id]))
            return true;
        else
            return false;
    }

    public function getOptionsList()
    {
        $options = array();
        foreach ($this->getConfigurableModules() as $module)
        {
            $config = $module->getConfigInstance();
            $options[$config->option_name()] = $config->getOptionValues();
        }
        return $options;
    }
}
