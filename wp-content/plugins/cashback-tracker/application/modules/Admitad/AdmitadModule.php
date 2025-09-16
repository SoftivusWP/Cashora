<?php

namespace CashbackTracker\application\modules\Admitad;

defined('\ABSPATH') || exit;

use CashbackTracker\application\Plugin;
use CashbackTracker\application\components\Coupon;
use CashbackTracker\application\components\CashbackModule;
use CashbackTracker\application\libs\AdmitadApi;
use CashbackTracker\application\components\OrderManager;
use CashbackTracker\application\components\Order;
use CashbackTracker\application\components\Advertiser;
use CashbackTracker\application\helpers\TextHelper;
use CashbackTracker\application\modules\Admitad\AdmitadConfig;
use CashbackTracker\application\components\CouponManager;

/**
 * AdmitadModule class file
 *
 * @author keywordrush.com <support@keywordrush.com>
 * @link https://www.keywordrush.com
 * @copyright Copyright &copy; 2025 keywordrush.com
 */
class AdmitadModule extends CashbackModule
{

    const SUBID_NAME = 'subid1';
    const GOTO_NAME = 'ulp';

    private $limit = 500;
    private $offset = 0;
    private $orders = array();
    private $iteration_count = 0;

    public function info()
    {
        return array(
            'name' => 'Admitad',
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
        return new AdmitadApi();
    }

    public function isTrackableUrl($url)
    {
        if (!$url_parts = parse_url($url))
            return false;

        $deeplink_domains = array('ad.admitad.com', 'alitems.com');
        if (isset($url_parts['host']) && in_array($url_parts['host'], $deeplink_domains))
            return true;

        if (isset($url_parts['path']) && isset($url_parts['query']))
        {
            if (!preg_match('/\/g\/[a-z0-9]+/', $url_parts['path']))
                return false;

            parse_str($url_parts['query'], $vars);
            if (!empty($vars['ulp']) && preg_match('/https?:\/\//', $vars['ulp']))
                return true;
        }

        return false;
    }

    public function getOrders()
    {
        $this->iteration_count++;
        if ($this->iteration_count > 100)
            throw new \Exception('Admitad API: Something went wrong.');

        $api_client = $this->getApiClient();
        $api_client->setAccessToken($this->getAccessToken());
        $options = array();
        $options['website'] = AdmitadConfig::getInstance()->option('website_id');
        $options['limit'] = $this->limit;
        $options['offset'] = $this->offset;

        // Error: Date has wrong format. Use one of these formats instead: YYYY-MM-DD, YYYY.MM.DD. ???
        // The values for dates should be in format %d.%m.%Y - 01.05.2012.
        // @link: https://developers.admitad.com/en/doc/api_en/methods/statistics/statistics-actions/
        if (!$this->date_start)
            //$this->date_start = $this->getDateStart('d.m.Y');
            $this->date_start = $this->getDateStart('Y-m-d');
        $options['date_start'] = $this->date_start;
        $response = $api_client->getOrders($options);
        $meta = $response['_meta'];

        $orders = $this->ordersPrepare($response);
        $this->orders = array_merge($this->orders, $orders);
        if ($meta['count'] > ($this->offset + $this->limit))
        {
            $this->offset += $this->limit;
            $this->getOrders();
        }
        return $this->orders;
    }

    private function ordersPrepare($results)
    {
        if (empty($results['results']) || !is_array($results['results']))
            return array();

        $orders = array();
        foreach ($results['results'] as $r)
        {
            if ($order = $this->orderPrepare($r))
                $orders[] = $order;
        }
        return $orders;
    }

    private function orderPrepare($r)
    {
        $subid_param = self::getSubidName();

        //@debug
        if (!empty($_SERVER['KEYWORDRUSH_DEVELOPMENT']) && $_SERVER['KEYWORDRUSH_DEVELOPMENT'] == '16203273895503427')
            $r[$subid_param] = 'cbtrkr-' . 1;
        if (empty($r[$subid_param]) || !OrderManager::isCashbackSubid($r[$subid_param]))
            return false;

        $order = new Order;
        $order->order_id = (int) $r['id'];
        $order->merchant_order_id = $r['order_id'];
        $order->module_id = $this->getId();
        $status = self::bindStatus($r['status']);
        if ($status === false)
        {
            Plugin::logger()->warning('Admitad API: Unknown order status.');
            return false;
        }
        $order->order_status = $status;
        $order->subid = $r[$subid_param];
        $order->advertiser_id = (int) $r['advcampaign_id'];
        $order->currency_code = $r['currency'];
        $order->sale_amount = (float) $r['cart'];
        $order->commission_amount = (float) $r['payment'];
        $order->click_date = strtotime($r['click_date']);
        $order->action_date = strtotime($r['action_date']);
        $order->user_referer = $r['click_user_referer'];
        $order->api_response = serialize($r);

        $advertiser = $this->advertiser($order->advertiser_id);
        if (!$advertiser)
        {
            Plugin::logger()->info(sprintf('Admitad API: Unknown Advertiser ID: %d.', $order->advertiser_id));
            return false;
        }
        $order->advertiser_domain = $advertiser['domain'];

        return $order;
    }

    private static function bindStatus($status)
    {
        if ($status == 'pending')
            return Order::STATUS_PENDING;
        elseif ($status == 'approved')
            return Order::STATUS_APPROVED;
        elseif ($status == 'declined')
            return Order::STATUS_DECLINED;
        elseif ($status == 'approved_but_stalled' && AdmitadConfig::getInstance()->option('approved_but_stalled') == 'approved')
            return Order::STATUS_APPROVED;
        elseif ($status == 'approved_but_stalled' && AdmitadConfig::getInstance()->option('approved_but_stalled') == 'pending')
            return Order::STATUS_PENDING;
        else
            return false;
    }

    public function requestAccessToken()
    {
        $client_id = AdmitadConfig::getInstance()->option('client_id');
        $client_secret = AdmitadConfig::getInstance()->option('client_secret');
        $scope = 'statistics advcampaigns_for_website deeplink_generator coupons_for_website coupons';
        $api_client = $this->getApiClient();
        $response = $api_client->requestAccessToken($client_id, $client_secret, $scope);
        if (empty($response['access_token']) || empty($response['expires_in']))
        {
            throw new \Exception('Admitad API: Invalid Response Format.');
        }

        return array($response['access_token'], (int) $response['expires_in']);
    }

    public function getAdvertisers()
    {
        @set_time_limit(60);

        $website_id = AdmitadConfig::getInstance()->option('website_id');
        $api_client = $this->getApiClient();
        $api_client->setAccessToken($this->getAccessToken());
        $params = array();
        $params['connection_status'] = 'active';

        $params['limit'] = 500; //max limit
        $params['offset'] = 0;
        $results = array();
        for ($i = 0; $i < 5; $i++)
        {
            try
            {
                $r = $api_client->getAdvertisers($website_id, $params);
            }
            catch (\Exception $e)
            {
                $log = $this->getId() . ': Error occurred while getting advertiser list.';
                $log .= 'Server response: ' . $e->getMessage();
                Plugin::logger()->warning($log);
                return array();
            }

            if (!isset($r['results']) || !is_array($r['results']))
                return array();

            $results = array_merge($results, $r['results']);

            if ($params['offset'] * $i >= $r['_meta']['count'] || count($results) >= $r['_meta']['count'])
                break;
            $params['offset'] += $params['limit'];
        }
        $advertisers = array();
        foreach ($results as $result)
        {
            $advertiser = $this->prepareAdvertiser($result);
            $advertisers[$advertiser->id] = $advertiser;
        }
        return $advertisers;
    }

    public function getAdvertiser($advertiser_id)
    {
        $website_id = AdmitadConfig::getInstance()->option('website_id');
        $api_client = $this->getApiClient();
        $api_client->setAccessToken($this->getAccessToken());
        try
        {
            $result = $api_client->getAdvertiser($website_id, $advertiser_id);
        }
        catch (\Exception $e)
        {
            $log = sprintf(($this->getId() . ': Error occurred while getting advertiser info. Advertiser ID# %d.'), $advertiser_id);
            $log .= 'Server response: ' . $e->getMessage();
            Plugin::logger()->info($log);
            return false;
        }
        $advertiser = $this->prepareAdvertiser($result);
        $advertiser->id = $advertiser_id;
        return $advertiser;
    }

    private function prepareAdvertiser($result)
    {
        $advertiser = new Advertiser;
        $advertiser->id = (int) $result['id'];
        $advertiser->name = \sanitize_text_field($result['name']);

        $advertiser->name = str_replace(' WW', '', $advertiser->name);
        $advertiser->name = str_replace(' UA', '', $advertiser->name);
        $advertiser->name = str_replace(' Many GEOs', '', $advertiser->name);
        $advertiser->name = str_replace(' INT', '', $advertiser->name);

        $advertiser->logo_url = $result['image'];
        $advertiser->site_url = $result['site_url'];
        $advertiser->domain = TextHelper::getDomainName($result['site_url']);
        if ($advertiser->domain == 'saudi.souq.com')
            $advertiser->domain = 'souq.com';

        $advertiser->average_payment_time = (int) $result['avg_money_transfer_time'];
        $advertiser->validation_days = (int) $result['avg_hold_time'];
        $advertiser->currency_code = $result['currency'];
        $advertiser->deeplink = $result['gotolink'];
        if (!empty($result['actions_detail']))
            list($min, $max, $type) = self::parseCommissionDetails($result['actions_detail']);
        else
            list($min, $max, $type) = array(0, 0, Advertiser::COMMISSION_TYPE_FLAT);

        $advertiser->commission_min = $min;
        $advertiser->commission_max = $max;
        $advertiser->commission_type = $type;
        return $advertiser;
    }

    private static function parseCommissionDetails(array $actions)
    {
        $max_percentage = $max_flat = 0;
        $min_percentage = 100;
        $min_flat = \PHP_INT_MAX;
        $type = null;

        foreach ($actions as $action)
        {
            foreach ($action['tariffs'] as $tariff)
            {
                foreach ($tariff['rates'] as $rate)
                {
                    if ($rate['is_percentage'])
                    {
                        // percentage
                        if ($rate['size'] < $min_percentage)
                            $min_percentage = (float) $rate['size'];
                        if ($rate['size'] > $max_percentage)
                            $max_percentage = (float) $rate['size'];
                        $type = Advertiser::COMMISSION_TYPE_PERCENTAGE;
                    }
                    else
                    {
                        // flat
                        if ($rate['size'] < $min_flat)
                            $min_flat = (float) $rate['size'];
                        if ($rate['size'] > $max_flat)
                            $max_flat = (float) $rate['size'];
                        $type = Advertiser::COMMISSION_TYPE_FLAT;
                    }
                }
            }
        }

        if ($type == Advertiser::COMMISSION_TYPE_PERCENTAGE)
            return array($min_percentage, $max_percentage, $type);
        else
            return array($min_flat, $max_flat, $type);
    }

    public function getCoupons($advertiser_id)
    {
        $advertiser_id = (int)$advertiser_id;
        if (!$advertiser_id)
            return array();
        $api_client = $this->getApiClient();
        $api_client->setAccessToken($this->getAccessToken());
        $options = array();
        $options['campaign'] = $advertiser_id;
        $options['limit'] = CouponManager::getInstance()->getPerPageLimit();
        $options['offset'] = 0;
        $options['order_by'] = 'rating';
        $options['language'] = ''; //!

        $region = $this->config('region');
        if (strlen($region) == 2)
            $options['region'] = strtoupper($region);

        $response = $api_client->getCoupons($this->config('website_id'), $options);
        return $this->couponsPrepare($response);
    }

    private function couponsPrepare($results)
    {
        if (empty($results['results']) || !is_array($results['results']))
            return array();

        $coupons = array();
        foreach ($results['results'] as $r)
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
        $coupon->title = \sanitize_text_field($r['name']);
        $coupon->code = \sanitize_text_field($r['promocode']);
        $coupon->link = strip_tags($r['goto_link']);
        $coupon->image = \sanitize_text_field($r['image']);
        $coupon->discount = \sanitize_text_field($r['discount']);
        $coupon->description = \sanitize_text_field($r['description']);

        if (isset($r['date_start']) && $d = strtotime($r['date_start']))
            $coupon->start_date = $d;

        if (isset($r['date_end']) && $d = strtotime($r['date_end']))
            $coupon->end_date = $d;

        unset($r['regions']);
        unset($r['categories']);
        $coupon->extra = $r;

        if ($coupon->code == 'NOT REQUIRED' || $coupon->code == 'НЕ НУЖЕН')
            $coupon->code = '';

        return $coupon;
    }
}
