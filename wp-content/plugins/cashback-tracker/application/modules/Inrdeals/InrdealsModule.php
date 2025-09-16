<?php

namespace CashbackTracker\application\modules\Inrdeals;

defined('\ABSPATH') || exit;

use CashbackTracker\application\Plugin;
use CashbackTracker\application\components\Coupon;
use CashbackTracker\application\components\CashbackModule;
use CashbackTracker\application\libs\InrdealsApi;
use CashbackTracker\application\components\OrderManager;
use CashbackTracker\application\components\Order;
use CashbackTracker\application\components\Advertiser;
use CashbackTracker\application\components\AdvertiserManager;
use CashbackTracker\application\helpers\TextHelper;
use CashbackTracker\application\modules\Inrdeals\InrdealsConfig;
use CashbackTracker\application\components\CouponManager;

/**
 * InrdealsModule class file
 *
 * @author keywordrush.com <support@keywordrush.com>
 * @link https://www.keywordrush.com
 * @copyright Copyright &copy; 2025 keywordrush.com
 */
class InrdealsModule extends CashbackModule
{
    const SUBID_NAME = 'subid';
    const GOTO_NAME = 'url';

    private $orders = array();
    private $iteration_count = 0;

    public function info()
    {
        return array(
            'name' => 'INRDeals',
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
        $id = InrdealsConfig::getInstance()->option('id');
        $token_store = InrdealsConfig::getInstance()->option('token_store');
        $token_coupon = InrdealsConfig::getInstance()->option('token_coupon');
        $token_transaction = InrdealsConfig::getInstance()->option('token_transaction');
        return new InrdealsApi($id, $token_store, $token_coupon, $token_transaction);
    }

    public function isTrackableUrl($url)
    {
        if (!$url_parts = parse_url($url))
            return false;

        $deeplink_domains = array('inr.deals');
        if (isset($url_parts['host']) && in_array($url_parts['host'], $deeplink_domains))
            return true;

        return false;
    }

    public function getOrders()
    {
        @set_time_limit(60);
        $this->iteration_count++;
        if ($this->iteration_count > 30)
            throw new \Exception('Inrdeals API: Something went wrong.');

        $api_client = $this->getApiClient();
        $params = array();
        $params['startdate'] = $this->getDateStart('Y-m-d', 120);
        $params['enddate'] = date('Y-m-d', time() + 86400);
        if ($this->iteration_count > 1)
            $params['page'] = $this->iteration_count;

        $response = $api_client->getOrders($params);
        $orders = $this->ordersPrepare($response);

        $this->orders = array_merge($this->orders, $orders);
        if (!empty($response['result']['next_page_url']))
        {
            $this->getOrders();
        }

        return $this->orders;
    }

    private function ordersPrepare($results)
    {
        if (!isset($results['result']['data']) || !is_array($results['result']['data']))
            return array();

        $orders = array();
        foreach ($results['result']['data'] as $r)
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
            $r['sub_id1'] = 'cbtrkr-' . 1;

        if (!$r['sub_id1'] || !OrderManager::isCashbackSubid($r['sub_id1']))
            return false;

        $order = new Order;
        $order->order_id = (int) $r['id'];
        $order->merchant_order_id = $r['transaction_id'];
        $order->module_id = $this->getId();
        $order->order_status = self::bindStatus($r['status']);
        $order->subid = $r['sub_id1'];
        $order->sale_amount = round((float) $r['sale_amount'], 2);
        $order->commission_amount = round((float) $r['user_commission'], 2);
        $order->action_date = strtotime($r['sale_date']);
        $order->user_referer = $r['referrer_url'];
        $order->api_response = serialize($r);

        $advertiser = AdvertiserManager::getInstance()->findAdvertiserByName($r['store_name'], $this->getId());

        if (!$advertiser)
        {
            Plugin::logger()->info(sprintf('Inrdeals: Unknown Advertiser ID: %d.', $order->advertiser_id));
            return false;
        }

        $order->advertiser_id = $advertiser['id'];
        $order->advertiser_domain = $advertiser['domain'];
        $order->currency_code = $advertiser['currency_code'];

        return $order;
    }

    private static function bindStatus($status)
    {
        $status = strtolower($status);

        if ($status == 'verified')
            return Order::STATUS_APPROVED;
        elseif ($status == 'failed')
            return Order::STATUS_DECLINED;
        else
            return Order::STATUS_PENDING;
    }

    public function getAdvertisers()
    {
        @set_time_limit(60);

        $api_client = $this->getApiClient();

        try
        {
            $results = $api_client->getAdvertisers();
        }
        catch (\Exception $e)
        {
            $log = $this->getId() . ': Error occurred while getting advertiser list.';
            $log .= 'Server response: ' . $e->getMessage();
            Plugin::logger()->warning($log);
            return array();
        }

        if (!isset($results['stores']) || !is_array($results['stores']))
            return array();

        foreach ($results['stores'] as $result)
        {
            $advertiser = $this->prepareAdvertiser($result);
            if (!$advertiser)
                continue;

            $advertisers[$advertiser->id] = $advertiser;
        }

        return \apply_filters('cbtrkr_inrdeals_advertisers', $advertisers);
    }

    public function getAdvertiser($advertiser_id)
    {
        $advertisers = $this->getAdvertisers();

        foreach ($advertisers as $advertiser)
        {
            if ($advertiser->id == $advertiser_id)
                return $advertiser_id;
        }

        return false;
    }

    private function prepareAdvertiser($result)
    {
        if (!isset($result['id']))
            return false;

        if ($result['status'] == 'inactive')
            return false;

        $advertiser = new Advertiser;

        $advertiser->id = (int) $result['id'];
        $advertiser->name = \sanitize_text_field($result['merchant']);
        $advertiser->site_url = self::parseOriginalUrl($result['url'], 'url');
        $advertiser->domain = TextHelper::getDomainName($advertiser->site_url);
        $advertiser->deeplink = $result['url'];
        $advertiser->logo_url = $result['logo'];
        $advertiser->currency_code = 'INR';

        list($min, $max, $type) = self::parseCommissionDetails($result['payout']);
        $advertiser->commission_min = $min;
        $advertiser->commission_max = $max;
        $advertiser->commission_type = $type;

        return $advertiser;
    }

    private static function parseCommissionDetails($payout)
    {
        if (strstr($payout, '%'))
            $type = Advertiser::COMMISSION_TYPE_PERCENTAGE;
        else
            $type = Advertiser::COMMISSION_TYPE_FLAT;

        $payout = str_replace('₹', '', $payout);
        $payout = str_replace('%', '', $payout);
        $payout = (float) $payout;

        return array($payout, $payout, $type);
    }

    public function getCoupons($advertiser_id)
    {
        $api_client = $this->getApiClient();
        $params = array();

        $response = $api_client->getCoupons($advertiser_id, $params);

        if (!$response || empty($response['data']) || !is_array($response['data']))
            return array();

        $response = array_slice($response['data'], 0, CouponManager::getInstance()->getPerPageLimit());
        return $this->couponsPrepare($response);
    }

    private function couponsPrepare($results)
    {
        $coupons = array();
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

        $coupon->network_id = (int) $r['id'];
        $coupon->title = \sanitize_text_field($r['offer']);
        $coupon->description = trim(\wp_kses_post($r['description']));
        $coupon->link = \wp_sanitize_redirect($r['url']);
        $coupon->code = \sanitize_text_field($r['coupon_code']);

        if ($r['expire_date'] != 'Ongoing Offer' && $d = strtotime($r['expire_date']))
            $coupon->end_date = $d;

        $coupon->extra = $r;

        if ($coupon->title == $coupon->description)
            $coupon->description = '';

        if ($coupon->description == '0')
            $coupon->description = '';

        if (substr($coupon->description, 0, 4) === '<li>')
            $coupon->description = '<ul>' . $coupon->description . '</ul>';

        return $coupon;
    }

    private static function parseOriginalUrl($url, $go_param)
    {
        $url = html_entity_decode($url);
        if (!$query = parse_url($url, PHP_URL_QUERY))
            return '';
        parse_str($query, $arr);
        if (isset($arr[$go_param]))
            return $arr[$go_param];
        else
            return '';
    }
}
