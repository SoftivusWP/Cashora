<?php

namespace CashbackTracker\application\modules\Linkwise;

defined('\ABSPATH') || exit;

use CashbackTracker\application\Plugin;
use CashbackTracker\application\components\Coupon;
use CashbackTracker\application\components\CashbackModule;
use CashbackTracker\application\libs\LinkwiseApi;
use CashbackTracker\application\components\OrderManager;
use CashbackTracker\application\components\Order;
use CashbackTracker\application\components\Advertiser;
use CashbackTracker\application\helpers\TextHelper;
use CashbackTracker\application\modules\Linkwise\LinkwiseConfig;
use CashbackTracker\application\components\CouponManager;

/**
 * LinkwiseModule class file
 *
 * @author keywordrush.com <support@keywordrush.com>
 * @link https://www.keywordrush.com
 * @copyright Copyright &copy; 2025 keywordrush.com
 */
class LinkwiseModule extends CashbackModule
{

    const SUBID_NAME = 'subid1';
    const GOTO_NAME = 'lnkurl';

    public function info()
    {
        return array(
            'name' => 'Linkwise',
        );
    }

    public function getSubidName()
    {
        return self::SUBID_NAME;
    }

    public function getGotoName()
    {
        return self::GOTO_NAME;
    }

    public function createApiClient()
    {
        return new LinkwiseApi(LinkwiseConfig::getInstance()->option('username'), LinkwiseConfig::getInstance()->option('password'));
    }

    public function isTrackableUrl($url)
    {
        if (!$url_parts = parse_url($url))
            return false;

        $deeplink_domains = array('go.linkwi.se');
        if (isset($url_parts['host']) && in_array($url_parts['host'], $deeplink_domains))
            return true;

        if (isset($url_parts['path']) && isset($url_parts['query']))
        {
            parse_str($url_parts['query'], $vars);
            if (!empty($vars['lnkurl']) && preg_match('/https?:\/\//', $vars['lnkurl']))
                return true;
        }

        return false;
    }

    public function getOrders()
    {
        @set_time_limit(120);

        $api_client = $this->getApiClient();

        $params = array();
        $params['fields'] = 'program_id,program,rotator,creative,subid1,transaction_id,type,status,subaction,amended,amount,commission,click_date,transaction_date,status_date,click_ref_url,payout_cat,payment_status';

        /*
        $params['length'] = 'custom';
        $params['from'] = $this->getDateStart('d/m/Y');
        $params['from_time'] = '00:00:00';
        $params['to'] = date('d/m/Y', time());
        $params['to_time'] = date('H:i:s', time());
        $params['based_on'] = 'transaction';
        */

        /**
         * I think it would be best to run a report every hour, for today (length=today) and based on the status date of the transactions (based_on=status), i.e. their confirmation date. In this way, you will also receive the new transactions that are made (after them - and until they get status) deal date & status date are the same, but also changes in status for those that are validated/cancelled as well as changes in amounts.
         */

        if (rand(0, 5) == 5)
            $length = 'last_7_days';
        else
            $length = 'today';

        $params['length'] = $length;
        $params['based_on'] = 'status';

        try
        {
            $results = $api_client->getOrders($params);
        }
        catch (\Exception $e)
        {
            $log = $this->getId() . ': Error occurred while getting orders.';
            $log .= 'Server response: ' . $e->getMessage();
            //Plugin::logger()->warning($log);
            //return array();

            throw new \Exception($log);
        }
        return $this->ordersPrepare($results);
    }

    private function ordersPrepare($results)
    {
        if (!is_array($results) || !isset($results[0]['program']))
            return array();

        $orders = array();
        foreach ($results as $r)
        {
            if ($order = $this->orderPrepare($r))
                $orders[] = $order;
        }

        return $orders;
    }

    private function orderPrepare(array $r)
    {
        //@debug
        if (!empty($_SERVER['KEYWORDRUSH_DEVELOPMENT']) && $_SERVER['KEYWORDRUSH_DEVELOPMENT'] == '16203273895503427')
            $r['subid1'] = 'cbtrkr-' . 1;

        if (!$r['subid1'] || !OrderManager::isCashbackSubid($r['subid1']))
            return false;

        $order = new Order;
        $order->order_id = (int) $r['id'];
        $order->advertiser_id = (int) $r['program']['id'];
        $order->merchant_order_id = $order->order_id;
        $order->module_id = $this->getId();
        $status = self::bindStatus($r['status']['name']);
        $order->order_status = $status;
        $order->subid = $r['subid1'];
        $order->sale_amount = round((float) $r['amount'], 2);
        $order->commission_amount = round((float) $r['commission'], 2);
        $order->action_date = strtotime($r['date']);
        $order->user_referer = $r['click']['ref_url'];
        $order->api_response = serialize($r);

        $advertiser = $this->advertiser($order->advertiser_id);
        if (!$advertiser)
        {
            Plugin::logger()->info(sprintf('Admitad API: Unknown Advertiser ID: %d.', $order->advertiser_id));
            return false;
        }

        $order->advertiser_domain = $advertiser['domain'];
        $order->currency_code = $advertiser['currency_code'];
        return $order;
    }

    private static function bindStatus($status)
    {
        $status = strtolower($status);

        if ($status == 'validated')
            return Order::STATUS_APPROVED;
        elseif ($status == 'pending_validated' && LinkwiseConfig::getInstance()->option('pending_validated') == 'validated')
            return Order::STATUS_APPROVED;
        elseif ($status == 'cancelled')
            return Order::STATUS_DECLINED;
        else
            return Order::STATUS_PENDING;
    }

    public function getAdvertisers()
    {
        @set_time_limit(120);

        $api_client = $this->getApiClient();
        $params = array();
        $params['joined'] = 'yes';

        try
        {
            $results = $api_client->getAdvertisers($params);
        }
        catch (\Exception $e)
        {
            $log = $this->getId() . ': Error occurred while getting advertiser list.';
            $log .= 'Server response: ' . $e->getMessage();
            Plugin::logger()->warning($log);
            return array();
        }

        $advertisers = array();
        foreach ($results as $result)
        {
            $advertiser = $this->prepareAdvertiser($result);
            if ($advertiser)
                $advertisers[$advertiser->id] = $advertiser;
        }

        return $advertisers;
    }

    public function getAdvertiser($advertiser_id)
    {
        $api_client = $this->getApiClient();
        $options = array(
            'program_ids' => $advertiser_id,
            'joined' => 'yes',
        );

        try
        {
            $result = $api_client->getAdvertisers($options);
        }
        catch (\Exception $e)
        {
            $log = sprintf(($this->getId() . ': Error occurred while getting advertiser info. Advertiser ID# %d.'), $advertiser_id);
            $log .= 'Server response: ' . $e->getMessage();
            Plugin::logger()->info($log);
            return false;
        }

        if (isset($result[0]))
            $result = $result[0];

        $advertiser = $this->prepareAdvertiser($result);
        if (!$advertiser)
            return false;

        $advertiser->id = $advertiser_id;
        return $advertiser;
    }

    private function prepareAdvertiser($result)
    {
        if (!isset($result['id']))
            return false;

        $advertiser = new Advertiser;

        $advertiser->id = (int) $result['id'];
        $advertiser->name = \sanitize_text_field($result['name']);
        $advertiser->logo_url = $result['logo'];
        $advertiser->site_url = $result['url'];
        $advertiser->domain = TextHelper::getDomainName($result['url']);

        $affiliate_id = LinkwiseConfig::getInstance()->option('affiliate_id');
        $advertiser->deeplink = 'https://go.linkwi.se/z/' . urldecode($advertiser->id) . '-0/' . urlencode($affiliate_id) . '/';
        $advertiser->currency_code = $result['currency']['code'];

        if ($result['commissions']['summary']['percent'] != '-')
        {
            $advertiser->commission_type = Advertiser::COMMISSION_TYPE_PERCENTAGE;
            $commissions = $result['commissions']['summary']['percent'];
        }
        elseif (isset($result['commissions']['summary']['flat_nosign']))
        {
            $advertiser->commission_type = Advertiser::COMMISSION_TYPE_FLAT;
            $commissions = $result['commissions']['summary']['flat_nosign'];
        }
        else
            $commissions = '';

        $parts = explode('-', $commissions);
        if (isset($parts[0]))
            $advertiser->commission_min = (float) trim($parts[0], " %");
        if (isset($parts[1]))
            $advertiser->commission_max = (float) trim($parts[1], " %");

        $advertiser->_extra = array();
        $advertiser->_extra['commissions'] = $result['commissions'];
        return $advertiser;
    }

    public function getCoupons($advertiser_id)
    {
        $api_client = $this->getApiClient();

        $params['joined'] = 'yes';
        $params['types'] = 'coupon,offer';
        $params['program_ids'] = $advertiser_id;

        $response = $api_client->getCreatives($params);
        if (!$response || !is_array($response))
            return array();

        $response = array_slice($response, 0, CouponManager::getInstance()->getPerPageLimit());
        return $this->couponsPrepare($response);
    }

    private function couponsPrepare($results)
    {
        foreach ($results as $r)
        {
            if ($coupon = $this->couponPrepare($r))
                $coupons[] = $coupon;
        }

        return $coupons;
    }

    private function couponPrepare($r)
    {
        $coupon = new Coupon;

        $affiliate_id = LinkwiseConfig::getInstance()->option('affiliate_id');

        $coupon->network_id = $r['name'];
        list($title, $code) = self::parseCouponCode($r['description']);
        $coupon->title = \sanitize_text_field($title);
        $coupon->code = \sanitize_text_field($code);

        $coupon->link = 'https://go.linkwi.se/z/' . urlencode($r['name']) . '/' . urldecode($affiliate_id) . '/';

        if (isset($r['start_date']) && $d = strtotime($r['start_date']))
            $coupon->start_date = $d;

        if (isset($r['end_date']) && $d = strtotime($r['end_date']))
            $coupon->end_date = $d;

        $coupon->extra = $r;

        return $coupon;
    }

    private static function parseCouponCode($name)
    {
        if (!preg_match('~.+? - Coupon.*?/([^/]+)$~', $name, $matches))
            return array($name, '');;

        $coupon = $matches[1];
        $title = str_replace('/' . $coupon, '', $name);

        return array($title, $coupon);
    }
}
