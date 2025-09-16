<?php

namespace CashbackTracker\application\components;

defined('\ABSPATH') || exit;

/**
 * Network class file
 *
 * @author keywordrush.com <support@keywordrush.com>
 * @link httpы://www.keywordrush.com
 * @copyright Copyright &copy; 2025 keywordrush.com
 */
class Network
{

    const ID_ADMITAD = 'Admitad';
    const ID_AWIN = 'Awin';
    const SUBID_ADMITAD = 'subid1';
    const SUBID_AWIN = '';

    static public function getSubidParameters()
    {
        return array(
            Network::ID_ADMITAD => self::SUBID_ADMITAD,
            Network::ID_AWIN => self::SUBID_AWIN,
        );
    }

    static public function getSubidPrefix()
    {
        return \apply_filters('cbtrkr_subid_prefix', 'cbtrkr');
    }

    static public function getSubidParam($network_id)
    {
        $subids = self::getSubidParameters();
        if (isset($subids[$network_id]))
            return $subids[$network_id];
        else
            return '';
    }

    static public function isTrackerSubid($subid)
    {
        $parts = explode('-', $subid);
        if (count($parts) == 2 && $parts[0] == self::getSubidPrefix() && is_numeric($parts[1]))
            return true;
        else
            return false;
    }

    static public function parseUserId($subid)
    {
        if (!Network::isTrackerSubid($subid))
            return null;

        $parts = explode('-', $subid);
        return (int) $parts[1];
    }
}
