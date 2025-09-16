<?php

namespace CashbackTracker\application\helpers;

defined('\ABSPATH') || exit;

/**
 * WpHelper class file
 *
 * @author keywordrush.com <support@keywordrush.com>
 * @link https://www.keywordrush.com
 * @copyright Copyright &copy; 2025 keywordrush.com
 */
class WpHelper
{

    public static function getCurrentUserIdOrAdmin()
    {
        if ($user_id = \get_current_user_id())
            return $user_id;
        $users = \get_super_admins();
        foreach ($users as $login)
        {
            $wp_user = \get_user_by('login', $login);
            return $wp_user->ID;
        }
    }
}
