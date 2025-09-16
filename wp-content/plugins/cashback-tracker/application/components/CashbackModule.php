<?php

namespace CashbackTracker\application\components;

defined('\ABSPATH') || exit;

use CashbackTracker\application\Plugin;
use CashbackTracker\application\components\Module;
use CashbackTracker\application\models\OrderModel;
use CashbackTracker\application\components\AdvertiserManager;

/**
 * CashbackModule abstract class file
 *
 * @author keywordrush.com <support@keywordrush.com>
 * @link https://www.keywordrush.com
 * @copyright Copyright &copy; 2025 keywordrush.com
 */
abstract class CashbackModule extends Module
{

    public $date_start;
    public $date_end;
    protected $api_client = null;
    protected static $advertisers = array();

    public function isCashebackModule()
    {
        return true;
    }

    abstract public function getSubidName();

    abstract public function getGotoName();

    abstract public function getOrders();

    abstract public function getAdvertisers();

    abstract public function getAdvertiser($advertiser_id);

    abstract public function getCoupons($advertiser_id);

    abstract public function createApiClient();

    public function isTrackableUrl($url)
    {
        return false;
    }

    public function isActive()
    {
        if ($this->is_active === null)
        {
            if ($this->getConfigInstance()->option('is_active'))
                $this->is_active = true;
            else
                $this->is_active = false;
        }
        return $this->is_active;
    }

    protected function getApiClient()
    {
        if ($this->api_client === null)
        {
            $this->api_client = $this->createApiClient();
        }
        return $this->api_client;
    }

    public function getDateStart($format = 'd.m.Y', $max_range_days = null)
    {
        $params = array(
            'select' => 'action_date',
            'where' => array('order_status = %d AND module_id = %s', array(Order::STATUS_PENDING, $this->getId())),
            'order' => 'action_date ASC',
        );

        $order = OrderModel::model()->find($params);
        if ($order && $d = strtotime($order['action_date']))
        {
            $date = $d - 3600 * 24 * 7;
            if (time() - $date > 3600 * 24 * 365)
                $date = time() - 3600 * 24 * 365;
        }
        else
            $date = time() - 3600 * 24 * 29;

        if ($max_range_days && time() - $date > 3600 * 24 * $max_range_days)
            $date = time() - 3600 * 24 * $max_range_days;

        return date($format, $date);
    }

    public function advertiser($advertiser_id)
    {
        return AdvertiserManager::getInstance()->getAdvertiser($this->getId(), $advertiser_id, true);
    }

    public function getAccessToken($force = false)
    {
        $transient_name = Plugin::slug() . '-' . $this->getId() . '-access_token5';
        $token = \get_transient($transient_name);
        if (!$token || $force)
        {
            try
            {
                list($token, $expires_in) = $this->requestAccessToken();
            }
            catch (\Exception $e)
            {
                Plugin::logger()->error($this->getId() . ' ' . 'API: Fail to obtain Access Token:' . ' ' . $e->getMessage());
                return false;
            }
            \set_transient($transient_name, $token, (int) $expires_in);
        }
        return $token;
    }
}
