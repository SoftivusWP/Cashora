<?php

namespace CashbackTracker\application\modules\Cuelinks;

defined('\ABSPATH') || exit;

use CashbackTracker\application\Plugin;
use CashbackTracker\application\components\CashbackModule;
use CashbackTracker\application\libs\CuelinksApi;
use CashbackTracker\application\components\OrderManager;
use CashbackTracker\application\components\Order;
use CashbackTracker\application\components\Advertiser;
use CashbackTracker\application\helpers\TextHelper;
use CashbackTracker\application\components\AdvertiserManager;
use CashbackTracker\application\components\Coupon;
use CashbackTracker\application\components\CouponManager;

/**
 * CuelinksModule class file
 *
 * @author keywordrush.com <support@keywordrush.com>
 * @link https://www.keywordrush.com
 * @copyright Copyright &copy; 2025 keywordrush.com
 */
class CuelinksModule extends CashbackModule
{

    const SUBID_NAME = 'subid';
    const GOTO_NAME = 'url';
    const DEEPLINK_DOMAINS = array('linksredirect.com', 'www.linksredirect.com');

    private $orders = array();
    private $iteration_count = 0;

    public function info()
    {
        return array(
            'name' => 'Cuelinks',
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
        return new CuelinksApi(CuelinksConfig::getInstance()->option('api_key'));
    }

    public function isTrackableUrl($url)
    {
        if (!$url_parts = parse_url($url))
            return false;

        if (isset($url_parts['host']) && in_array($url_parts['host'], self::DEEPLINK_DOMAINS))
            return true;

        return false;
    }

    public function getOrders()
    {
        @set_time_limit(900);

        $api_client = $this->getApiClient();
        $params = array();
        $params['per_page'] = 100; //max limit
        $params['page'] = 1;
        $params['start_date'] = $this->getDateStart('Y-m-d');
        $results = array();
        for ($i = 1; $i < 25; $i++)
        {
            try
            {
                $r = $api_client->getOrders($params);
            }
            catch (\Exception $e)
            {
                if ($e->getCode() == 204)
                    break; // 204 - No Content
                else
                {
                    $log = $this->getId() . ': Error occurred while getting orders.';
                    $log .= 'Server response: ' . $e->getMessage();
                    Plugin::logger()->warning($log);
                    return array();
                }
            }

            if (!isset($r['transactions']) || !is_array($r['transactions']))
                break;

            $results = array_merge($results, $r['transactions']);

            if (count($results) >= (int) $r['total_count'])
                break;

            $params['page']++;
        }

        $orders = array();
        foreach ($results as $result)
        {
            if ($order = $this->orderPrepare($result))
                $orders[] = $order;
        }
        return $orders;
    }

    private function orderPrepare(array $r)
    {
        //@debug
        if (!empty($_SERVER['KEYWORDRUSH_DEVELOPMENT']) && $_SERVER['KEYWORDRUSH_DEVELOPMENT'] == '16203273895503427')
            $r['aff_sub'] = 'cbtrkr-' . 1;

        if (!$r['aff_sub'] || !OrderManager::isCashbackSubid($r['aff_sub']))
            return false;

        $order = new Order;
        $order->order_id = (int) $r['id'];
        $order->merchant_order_id = $order->order_id;
        $order->module_id = $this->getId();
        $status = self::bindStatus($r['status']);
        if ($status === false)
        {
            Plugin::logger()->warning('Cuelinks API: Unknown order status.');
            return false;
        }
        $order->order_status = $status;
        $order->subid = $r['aff_sub'];
        $order->currency_code = 'INR';
        $order->sale_amount = round((float) $r['sale_amount'], 2);
        $order->commission_amount = round((float) $r['user_commission'], 2);
        $order->action_date = strtotime($r['transaction_date']);
        $order->user_referer = $r['referrer_url'];
        $order->api_response = serialize($r);

        $advertiser = AdvertiserManager::getInstance()->findAdvertiserByName($r['store_name'], $this->getId());
        if (!$advertiser)
        {
            Plugin::logger()->warning(sprintf('Cuelinks: Can not find advertiser by name: %s.', $r['store_name']));
            return false;
        }
        $order->advertiser_id = $advertiser['id'];
        $order->advertiser_domain = $advertiser['domain'];
        return $order;
    }

    private static function bindStatus($status)
    {
        if (in_array($status, array('payable', 'claimed', 'paid')))
            return Order::STATUS_APPROVED;
        elseif ($status == 'validated' && CuelinksConfig::getInstance()->option('validated_status') == 'approved')
            return Order::STATUS_APPROVED;
        elseif ($status == 'rejected')
            return Order::STATUS_DECLINED;
        else
            return Order::STATUS_PENDING;
    }

    public function getAdvertisers()
    {
        @set_time_limit(900);

        $api_client = $this->getApiClient();
        $params = array();
        $params['per_page'] = 100; //max limit
        $params['page'] = 1;

        $results = array();
        for ($i = 1; $i < 25; $i++)
        {
            try
            {
                $r = $api_client->getAdvertisers($params);
            }
            catch (\Exception $e)
            {
                if ($e->getCode() == 204)
                    break; // 204 - No Content
                else
                {
                    $log = $this->getId() . ': Error occurred while getting advertiser list.';
                    $log .= 'Server response: ' . $e->getMessage();
                    Plugin::logger()->warning($log);
                    return array();
                }
            }

            if (!isset($r['campaigns']) || !is_array($r['campaigns']))
                break;

            $results = array_merge($results, $r['campaigns']);

            $params['page']++;
        }

        $advertisers = array();
        foreach ($results as $result)
        {
            $advertiser = $this->prepareAdvertiser($result);
            if ($advertiser)
            {
                $advertisers[$advertiser->id] = $advertiser;
            }
        }
        return $advertisers;
    }

    public function getAdvertiser($advertiser_id)
    {
        // No way to search by advertiser_id in Cuelinks API
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
        if (
            !isset($result['id']) ||
            !isset($result['name']) ||
            !isset($result['image']) ||
            !isset($result['url']) ||
            !isset($result['payout_categories']) ||
            !is_array($result['payout_categories'])
        )
        {
            return false;
        }

        $advertiser = new Advertiser;
        $advertiser->id = (int) $result['id'];
        $advertiser->name = \sanitize_text_field($result['name']);
        $advertiser->logo_url = str_replace('/thumb/', '/medium/', $result['image']);
        $advertiser->site_url = $result['url'];
        $advertiser->domain = TextHelper::getDomainName($result['url']);
        $chanel_id = CuelinksConfig::getInstance()->option('channel_id');
        $advertiser->deeplink = 'https://linksredirect.com/?cid=' . urlencode($chanel_id) . '&url=' . urlencode($advertiser->site_url);

        list($min, $max, $type, $currency) = self::parseCommissionDetails($result['payout_categories']);
        $advertiser->commission_min = $min;
        $advertiser->commission_max = $max;
        $advertiser->commission_type = $type;
        $advertiser->currency_code = $currency;
        return $advertiser;
    }

    private static function parseCommissionDetails(array $payout_categories)
    {
        $max_percentage = $max_flat = 0;
        $min_percentage = 100;
        $min_flat = \PHP_INT_MAX;
        $type = null;
        $currency = '';
        foreach ($payout_categories as $action)
        {
            $rate = (float) $action['payout'];

            if (strstr($action['payout_type'], '%'))
            {
                // percentage
                if ($rate < $min_percentage)
                    $min_percentage = $rate;
                if ($rate > $max_percentage)
                    $max_percentage = $rate;
                if (!$type)
                    $type = Advertiser::COMMISSION_TYPE_PERCENTAGE;
            }
            else
            {
                $currency = 'INR'; // ?
                // flat
                if ($rate < $min_flat)
                    $min_flat = $rate;
                if ($rate > $max_flat)
                    $max_flat = $rate;
                if (!$type)
                    $type = Advertiser::COMMISSION_TYPE_FLAT;
            }
        }

        if ($type == Advertiser::COMMISSION_TYPE_PERCENTAGE)
            return array($min_percentage, $max_percentage, $type, $currency);
        else
            return array($min_flat, $max_flat, $type, $currency);
    }

    public function getCoupons($advertiser_id)
    {
        $api_client = $this->getApiClient();

        $params['per_page'] = CouponManager::getInstance()->getPerPageLimit(); //100 max limit
        $params['page'] = 1;
        $params['campaigns'] = $advertiser_id;

        $response = $api_client->getOffers($params);

        return $this->couponsPrepare($response);
    }

    private function couponsPrepare($results)
    {
        if (empty($results['offers']) || !is_array($results['offers']))
            return array();

        $coupons = array();
        foreach ($results['offers'] as $r)
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
        $coupon->title = \sanitize_text_field($r['title']);
        $coupon->code = \sanitize_text_field($r['coupon_code']);
        $coupon->link = strip_tags($r['affiliate_url']);
        $coupon->image = \sanitize_text_field($r['image_url']);
        $coupon->description = \sanitize_text_field($r['description']);

        if (isset($r['start_date']) && $d = strtotime($r['start_date']))
            $coupon->start_date = $d;

        if (isset($r['end_date']) && $d = strtotime($r['end_date']))
            $coupon->end_date = $d;

        $coupon->extra = $r;

        return $coupon;
    }
}
