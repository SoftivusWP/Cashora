<?php

namespace CashbackTracker\application\modules\Awin;

defined('\ABSPATH') || exit;

use CashbackTracker\application\Plugin;
use CashbackTracker\application\components\Coupon;
use CashbackTracker\application\components\CashbackModule;
use CashbackTracker\application\components\OrderManager;
use CashbackTracker\application\components\Order;
use CashbackTracker\application\components\Advertiser;
use CashbackTracker\application\helpers\TextHelper;
use CashbackTracker\application\modules\Awin\AwinConfig;
use CashbackTracker\application\libs\AwinApi;
use CashbackTracker\application\components\CouponManager;

/**
 * AwinModule class file
 *
 * @author keywordrush.com <support@keywordrush.com>
 * @link https://www.keywordrush.com
 * @copyright Copyright &copy; 2025 keywordrush.com
 */
class AwinModule extends CashbackModule
{

    const SUBID_NAME = 'clickref';
    const GOTO_NAME = 'p'; // also 'ued'

    private $orders = array();
    private $iteration_count = 0;

    public function info()
    {
        return array(
            'name' => 'AWIN',
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

    public function isTrackableUrl($url)
    {
        if (!$url_parts = parse_url($url))
            return false;

        $deeplink_domains = array('www.awin1.com', 'awin1.com');
        if (isset($url_parts['host']) && in_array($url_parts['host'], $deeplink_domains))
            return true;

        if (isset($url_parts['query']))
        {
            parse_str($url_parts['query'], $vars);
            if (empty($vars['awinmid']) || empty($vars['awinaffid']) || empty($vars['p']))
                return false;

            if (preg_match('/https?:\/\//', $vars['p']))
                return true;
        }
        return false;
    }

    public function createApiClient()
    {
        $access_token = AwinConfig::getInstance()->option('accessToken');
        $publisher_id = AwinConfig::getInstance()->option('publisherId');
        return new AwinApi($access_token, $publisher_id);
    }

    public function getOrders()
    {
        $this->iteration_count++;
        if ($this->iteration_count > 30)
            throw new \Exception('Awin API: Something went wrong.');

        $api_client = $this->getApiClient();
        $options = array();

        if (!$this->date_start)
            $this->date_start = $this->getDateStart('Y-m-d\Th:i:s');

        $options['startDate'] = $this->date_start;
        $options['endDate'] = date('Y-m-d\Th:i:s', strtotime($options['startDate'] . '+30 days'));
        $options['timezone'] = 'UTC';

        $response = $api_client->getOrders($options);
        $orders = $this->ordersPrepare($response);
        $this->orders = array_merge($this->orders, $orders);
        if (strtotime($options['endDate']) < time())
        {
            // the maximum date range between startDate and endDate currently supported is 31 days.
            $this->date_start = date('Y-m-d\Th:i:s', strtotime($options['startDate'] . '+30 days'));
            $this->getOrders();
        }
        return $this->orders;
    }

    private function ordersPrepare($results)
    {
        if (!$results || !is_array($results))
            return array();

        $orders = array();
        foreach ($results as $r)
        {
            if ($order = $this->orderPrepare($r))
                $orders[] = $order;
        }
        return $orders;
    }

    private function orderPrepare($r)
    {
        if (empty($r['clickRefs']['clickRef']))
            return false;
        $subid = $r['clickRefs']['clickRef'];
        if (!OrderManager::isCashbackSubid($subid))
            return false;

        $order = new Order;
        $order->module_id = $this->getId();
        $status = self::bindStatus($r['commissionStatus']);
        if ($status === false)
            return false;
        $order->order_id = (int) $r['id'];
        if (isset($r['orderRef']))
            $order->merchant_order_id = $r['orderRef'];
        $order->currency_code = $r['commissionAmount']['currency'];
        $order->sale_amount = (float) $r['saleAmount']['amount'];
        $order->commission_amount = (float) $r['commissionAmount']['amount'];
        $order->order_status = $status;
        $order->subid = $subid;
        $order->advertiser_id = (int) $r['advertiserId'];
        $order->click_date = strtotime($r['clickDate']);
        $order->action_date = strtotime($r['transactionDate']);
        $order->user_referer = $r['publisherUrl'];
        $order->api_response = serialize($r);

        $advertiser = $this->advertiser($order->advertiser_id);
        if (!$advertiser)
        {
            Plugin::logger()->info(sprintf('Awin API: Unknown Advertiser ID: %d.', $order->advertiser_id));
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
        else
            return false;
    }

    public function getAdvertisers()
    {
        @set_time_limit(1800);

        $api_client = $this->getApiClient();
        $options = array();
        $options['relationship'] = 'joined';

        try
        {
            $results = $api_client->getAdvertisers($options);
        }
        catch (\Exception $e)
        {
            $log = $this->getId() . ': Error occurred while getting advertiser list.';
            $log .= ' Server response: ' . $e->getMessage();
            Plugin::logger()->warning($log);
            return array();
        }
        if (!$results || !is_array($results))
            return array();

        $advertisers = array();
        $i = 1;
        // we need program details
        foreach ($results as $r)
        {
            // throttling: 20 API calls per minute
            if ($i % 20 == 0)
                sleep(60);

            if ($advertiser = $this->getAdvertiser($r['id']))
                $advertisers[$advertiser->id] = $advertiser;
            $i++;
        }
        return $advertisers;
    }

    public function getAdvertiser($advertiser_id)
    {
        $api_client = $this->getApiClient();
        try
        {
            $result = $api_client->getAdvertiser($advertiser_id);
        }
        catch (\Exception $e)
        {
            $log = sprintf(($this->getId() . ': Error occurred while getting advertiser info. Advertiser ID# %d.'), $advertiser_id);
            $log .= ' Server response: ' . $e->getMessage();
            Plugin::logger()->info($log);
            return false;
        }
        $advertiser = new Advertiser;
        $advertiser->id = $advertiser_id;

        if (empty($result['programmeInfo']) || !is_array($result['programmeInfo']))
        {
            return false;
        }

        $advertiser->name = \sanitize_text_field($result['programmeInfo']['name']);
        $advertiser->logo_url = $result['programmeInfo']['logoUrl'];
        $advertiser->site_url = $result['programmeInfo']['displayUrl'];
        $advertiser->domain = TextHelper::getDomainName($advertiser->site_url);
        $advertiser->currency_code = $result['programmeInfo']['currencyCode'];
        if (isset($result['kpi']['averagePaymentTime']))
            $advertiser->average_payment_time = (int) $result['kpi']['averagePaymentTime'];
        if (isset($result['kpi']['validationDays']))
            $advertiser->validation_days = (int) $result['kpi']['validationDays'];
        $advertiser->deeplink = $result['programmeInfo']['clickThroughUrl'];
        $advertiser->commission_min = (float) $result['commissionRange'][0]['min'];
        $advertiser->commission_max = (float) $result['commissionRange'][0]['max'];
        if ($result['commissionRange'][0]['type'] == 'percentage')
            $advertiser->commission_type = Advertiser::COMMISSION_TYPE_PERCENTAGE;
        else
            $advertiser->commission_type = Advertiser::COMMISSION_TYPE_FLAT;

        return $advertiser;
    }

    public function getCoupons($advertiser_id)
    {
        $filters = array(
            'advertiserIds' => array($advertiser_id),
            //'type' => 'voucher',
        );

        $publisher_id = $this->config('publisherId');

        $api_client = $this->getApiClient();

        $response = $api_client->getOffers($publisher_id, $filters);
        if (!$response || !isset($response['data']) || !is_array($response['data']))
            return array();

        $results = array_splice($response['data'], 0, CouponManager::getInstance()->getPerPageLimit());

        return $this->couponsPrepare($results);
    }

    private function couponsPrepare(array $results)
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

        $coupon->network_id = (int) $r['promotionId'];
        $coupon->title = \sanitize_text_field($r['title']);
        if (isset($r['voucher']['code']))
            $coupon->code = \sanitize_text_field($r['voucher']['code']);
        $coupon->link = strip_tags($r['urlTracking']);
        $coupon->description = \sanitize_text_field($r['description']);

        if (isset($r['startDate']) && $d = strtotime($r['startDate']))
            $coupon->start_date = $d;

        if (isset($r['endDate']) && $d = strtotime($r['endDate']))
            $coupon->end_date = $d;

        $coupon->extra = $r;

        return $coupon;
    }
}
