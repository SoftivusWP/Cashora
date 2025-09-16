<?php

namespace CashbackTracker\application;

defined('\ABSPATH') || exit;

/**
 * AdvertiserPage class file
 *
 * @author keywordrush.com <support@keywordrush.com>
 * @link https://www.keywordrush.com
 * @copyright Copyright &copy; 2025 keywordrush.com
 */
class AdvertiserPage
{

    private static $instance;
    protected $pages = array();

    public static function getInstance()
    {
        if (self::$instance === null)
            self::$instance = new self;
        return self::$instance;
    }

    private function __construct()
    {
        \add_filter('single_template', array($this, 'customSingleTemplate'));
        //\add_filter('archive_template', array($this, 'customArchiveTemplate'));
    }

    public function customSingleTemplate($single)
    {
        global $post;

        if ($post->post_type != 'cbtrkr_shop')
            return $single;

        //if (\is_embed())
        //return $single;

        $file_name = 'single-cashback-shop.php';

        if ($template = \locate_template($file_name))
            return $template;

        $default_file = \CashbackTracker\PLUGIN_PATH . 'templates/' . $file_name;
        return $default_file;
    }

    /*
      public function customArchiveTemplate($single)
      {
      global $post;

      if ($post->post_type != 'cbtrkr_shop')
      return $single;

      //if (\is_embed())
      //return $single;

      $file_name = 'single-cashback-shop.php';

      if ($template = \locate_template($file_name))
      return $template;

      $default_file = \CashbackTracker\PLUGIN_PATH . 'templates/' . $file_name;
      return $default_file;
      }
     *
     */
}
