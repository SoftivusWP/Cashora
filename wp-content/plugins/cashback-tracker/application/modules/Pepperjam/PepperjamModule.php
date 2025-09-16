<?php

namespace CashbackTracker\application\modules\Pepperjam;

defined('\ABSPATH') || exit;

use CashbackTracker\application\Plugin;
use CashbackTracker\application\components\Coupon;
use CashbackTracker\application\components\CashbackModule;
use CashbackTracker\application\libs\PepperjamApi;
use CashbackTracker\application\components\OrderManager;
use CashbackTracker\application\components\Order;
use CashbackTracker\application\components\Advertiser;
use CashbackTracker\application\helpers\TextHelper;
use CashbackTracker\application\modules\Pepperjam\PepperjamConfig;
use CashbackTracker\application\components\CouponManager;

/**
 * PepperjamModule class file
 *
 * @author keywordrush.com <support@keywordrush.com>
 * @link https://www.keywordrush.com
 * @copyright Copyright &copy; 2025 keywordrush.com
 */
class PepperjamModule extends CashbackModule
{

    const SUBID_NAME = 'sid';
    const GOTO_NAME = 'url';

    public function info()
    {
        return array(
            'name' => 'Pepperjam',
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
        return new PepperjamApi(PepperjamConfig::getInstance()->option('api_key'));
    }

    public function isTrackableUrl($url)
    {
        if (!$url_parts = parse_url($url))
            return false;

        $deeplink_domains = array('gopjn.com', 'pjtra.com', 'gopjn.com', 'pntrac.com');
        if (isset($url_parts['host']) && in_array($url_parts['host'], $deeplink_domains))
            return true;

        if (isset($url_parts['path']) && isset($url_parts['query']))
        {
            parse_str($url_parts['query'], $vars);
            if (strstr($url, '/t/') && !empty($vars['url']) && preg_match('/https?:\/\//', $vars['url']))
                return true;
        }

        return false;
    }

    public function getOrders()
    {
        @set_time_limit(120);

        $api_client = $this->getApiClient();

        $params = array();
        $params['startDate'] = $this->getDateStart('Y-m-d');
        $params['endDate'] = date('Y-m-d', time());

        $params['website'] = PepperjamConfig::getInstance()->option('website_id');

        try
        {
            $results = $api_client->getOrders($params);
        }
        catch (\Exception $e)
        {
            $log = $this->getId() . ': Error occurred while getting orders.';
            $log .= 'Server response: ' . $e->getMessage();
            Plugin::logger()->warning($log);
            return array();
        }

        return $this->ordersPrepare($results);
    }

    private function ordersPrepare($results)
    {
        if (!is_array($results) || !isset($results['data'][0]))
            return array();

        $orders = array();
        foreach ($results['data'] as $r)
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
            $r[self::SUBID_NAME] = 'cbtrkr-' . 1;

        if (!$r[self::SUBID_NAME] || !OrderManager::isCashbackSubid($r[self::SUBID_NAME]))
            return false;

        $order = new Order;
        $order->order_id = (int) $r['transaction_id'];
        $order->advertiser_id = (int) $r['program_id'];
        $order->merchant_order_id = $r['order_id'];
        $order->module_id = $this->getId();
        $status = self::bindStatus($r['status']);
        $order->order_status = $status;
        $order->subid = $r[self::SUBID_NAME];
        $order->sale_amount = round((float) $r['sale_amount'], 2);
        $order->commission_amount = round((float) $r['commission'], 2);
        $order->action_date = strtotime($r['date']);
        $order->api_response = serialize($r);

        $advertiser = $this->advertiser($order->advertiser_id);
        if (!$advertiser)
        {
            Plugin::logger()->info(sprintf('Pepperjam API: Unknown Advertiser ID: %d.', $order->advertiser_id));
            return false;
        }

        $order->advertiser_domain = $advertiser['domain'];
        $order->currency_code = $advertiser['currency_code'];
        return $order;
    }

    private static function bindStatus($status)
    {
        $status = strtolower($status);

        if ($status == 'paid')
            return Order::STATUS_APPROVED;
        elseif ($status == 'locked' && PepperjamConfig::getInstance()->option('locked_status') == 'approved')
            return Order::STATUS_APPROVED;
        elseif ($status == 'delayed' && PepperjamConfig::getInstance()->option('delayed_status') == 'approved')
            return Order::STATUS_APPROVED;
        else
            return Order::STATUS_PENDING;
    }

    public function getAdvertisers()
    {
        return $this->getMyAdvertisers();
    }

    private function getMyAdvertisers($advertiser_id = null)
    {
        @set_time_limit(60);

        $api_client = $this->getApiClient();
        $params = array();
        $params['status'] = 'joined';
        $params['deep_linking'] = 'Yes';

        if ($advertiser_id)
            $params['programId'] = $advertiser_id;

        $results = array();
        $deeplinks = array();
        for ($i = 1; $i <= 5; $i++)
        {
            $params['page'] = $i;

            try
            {
                $r = $api_client->getAdvertisers($params);
            }
            catch (\Exception $e)
            {
                $log = $this->getId() . ': Error occurred while getting advertiser list.';
                $log .= 'Server response: ' . $e->getMessage();
                Plugin::logger()->warning($log);
                return array();
            }

            if (!isset($r['data']) || !is_array($r['data']))
                return array();

            // get deeplinks
            $ids = array();
            foreach ($r['data'] as $d)
            {
                $ids[] = $d['id'];
            }

            $params2 = array();
            $params2['programId'] = join(',', $ids);
            $params2['website'] = PepperjamConfig::getInstance()->option('website_id');

            try
            {
                $d = $api_client->getDeeplinks($params2);
            }
            catch (\Exception $e)
            {
                $log = $this->getId() . ': Error occurred while getting advertiser deeplinks.';
                $log .= 'Server response: ' . $e->getMessage();
                Plugin::logger()->warning($log);
                return array();
            }

            $results = array_merge($results, $r['data']);
            $deeplinks = array_merge($deeplinks, $d['data']);

            if (ceil($r['meta']['pagination']['total_results'] / 500) >= $i)
                break;
        }

        $advertisers = array();
        foreach ($results as $result)
        {
            if ($advertiser = $this->prepareAdvertiser($result, $deeplinks))
                $advertisers[$advertiser->id] = $advertiser;
        }

        return $advertisers;
    }

    public function getAdvertiser($advertiser_id)
    {
        return $this->getMyAdvertisers($advertiser_id);
    }

    private function prepareAdvertiser($result, $deeplinks)
    {
        if (!isset($result['id']))
            return false;

        $advertiser = new Advertiser;
        $advertiser->id = (int) $result['id'];
        $advertiser->name = \sanitize_text_field($result['name']);
        $advertiser->logo_url = $result['logo'];
        if (!preg_match('/^http/', $advertiser->logo_url))
            $advertiser->logo_url = 'https:' . $advertiser->logo_url;

        $advertiser->site_url = $result['website'];
        $advertiser->domain = TextHelper::getDomainName($result['website']);
        $advertiser->currency_code = $result['currency'];

        if ((float) $result['percentage_payout'])
        {
            $advertiser->commission_type = Advertiser::COMMISSION_TYPE_PERCENTAGE;
            $commissions = (float) $result['percentage_payout'];
        }
        elseif ((float) $result['percentage_payout'])
        {
            $advertiser->commission_type = Advertiser::COMMISSION_TYPE_FLAT;
            $commissions = (float) $result['flat_payout'];
        }
        else
            return false;

        $advertiser->commission_min = $advertiser->commission_max = $commissions;

        foreach ($deeplinks as $deeplink)
        {
            if ((int) $deeplink['program_id'] == $advertiser->id)
            {
                $advertiser->deeplink = $deeplink['code'];
                break;
            }
        }

        if (!$advertiser->deeplink)
            return false;

        return $advertiser;
    }

    public function getCoupons($advertiser_id)
    {
        $api_client = $this->getApiClient();
        $params = array();
        $params['website_id'] = PepperjamConfig::getInstance()->option('website_id');

        $response = $api_client->getCoupons($advertiser_id, $params);
        if (!$response || !isset($response['data']) || !is_array($response['data']))
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

        $coupon->network_id = (int) $r['program_id'];
        $coupon->title = \sanitize_text_field($r['name']);
        $coupon->description = \sanitize_text_field($r['description']);
        $coupon->code = \sanitize_text_field($r['coupon']);
        $coupon->link = strip_tags($r['code']);

        if (isset($r['start_date']) && $d = strtotime($r['start_date']))
            $coupon->start_date = $d;

        if (isset($r['end_date']) && $d = strtotime($r['end_date']))
            $coupon->end_date = $d;

        unset($r['regions']);
        unset($r['categories']);
        $coupon->extra = $r;

        if (in_array($coupon->code, array('No Code Needed', 'n/a', 'none', 'none needed', 'No Code Necessary', 'NO CODE REQUIRED.', 'No Code')))
            $coupon->code = '';

        if ($coupon->title == $coupon->description)
            $coupon->description = '';

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
