<?php

namespace CashbackTracker\application\modules\Impact;

defined('\ABSPATH') || exit;

use CashbackTracker\application\Plugin;
use CashbackTracker\application\components\Coupon;
use CashbackTracker\application\components\CashbackModule;
use CashbackTracker\application\libs\ImpactApi;
use CashbackTracker\application\components\OrderManager;
use CashbackTracker\application\components\Order;
use CashbackTracker\application\components\Advertiser;
use CashbackTracker\application\helpers\TextHelper;
use CashbackTracker\application\modules\Impact\ImpactConfig;
use CashbackTracker\application\components\CouponManager;

/**
 * ImpactModule class file
 *
 * @author keywordrush.com <support@keywordrush.com>
 * @link https://www.keywordrush.com
 * @copyright Copyright &copy; 2025 keywordrush.com
 */
class ImpactModule extends CashbackModule
{

    const SUBID_NAME = 'subId1';
    const GOTO_NAME = 'u';

    public function info()
    {
        return array(
            'name' => 'Impact Radius',
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
        return new ImpactApi(ImpactConfig::getInstance()->option('sid'), ImpactConfig::getInstance()->option('token'));
    }

    public function isTrackableUrl($url)
    {
        if (!$url_parts = parse_url($url))
            return false;

        if (isset($url_parts['path']) && isset($url_parts['query']))
        {
            parse_str($url_parts['query'], $vars);
            if (strstr($url, '/c/') && !empty($vars['u']) && preg_match('/https?:\/\//', $vars['u']))
                return true;
        }

        return false;
    }

    public function getOrders()
    {
        @set_time_limit(120);

        $api_client = $this->getApiClient();

        $params = array();
        $params['ActionDateStart'] = $this->getDateStart('Y-m-d\Th:i:s\Z');
        $params['ActionDateEnd'] = date('Y-m-d\Th:i:s\Z', time());
        $params['PageSize'] = 10000;

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
        if (!isset($results['Actions']) || !is_array($results['Actions']))
            return array();

        $orders = array();
        foreach ($results['Actions'] as $r)
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
            $r['SubId1'] = 'cbtrkr-' . 1;

        if (!$r['SubId1'] || !OrderManager::isCashbackSubid($r['SubId1']))
            return false;

        $order = new Order;
        $order->order_id = (int) str_replace('.', '', $r['Id']);
        $order->advertiser_id = (int) $r['CampaignId'];
        $order->merchant_order_id = $r['ActionTrackerId'];
        $order->module_id = $this->getId();
        $status = self::bindStatus($r['State']);
        $order->order_status = $status;
        $order->subid = $r['SubId1'];
        $order->sale_amount = round((float) $r['Amount'], 2);
        $order->commission_amount = round((float) $r['Payout'], 2);
        $order->action_date = strtotime($r['EventDate']);
        $order->api_response = serialize($r);
        $order->currency_code = $r['Currency'];

        $advertiser = $this->advertiser($order->advertiser_id);
        if (!$advertiser)
        {
            Plugin::logger()->info(sprintf('Impact API: Unknown Advertiser ID: %d.', $order->advertiser_id));
            return false;
        }

        $order->advertiser_domain = $advertiser['domain'];
        return $order;
    }

    private static function bindStatus($status)
    {
        $status = strtoupper($status);

        if ($status == 'APPROVED')
            return Order::STATUS_APPROVED;
        elseif ($status == 'REVERSED')
            return Order::STATUS_DECLINED;
        else
            return Order::STATUS_PENDING;
    }

    public function getAdvertisers()
    {
        @set_time_limit(120);

        $api_client = $this->getApiClient();
        $params = array();
        $params['InsertionOrderStatus'] = 'Active';
        $params['PageSize'] = 1000; //max limit
        $results = array();
        for ($i = 1; $i < 5; $i++)
        {
            $params['Page'] = $i;

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

            if (!isset($r['Campaigns']) || !is_array($r['Campaigns']))
                return array();

            // get terms
            $campaigns = array();
            foreach ($r['Campaigns'] as $c)
            {
                if (!$terms = $this->getTerms($c['CampaignId']))
                    continue;

                $c['PayoutTermsList'] = $terms;
                $campaigns[] = $c;
            }

            $results = array_merge($results, $campaigns);

            if ($i >= (int) $r['@numpages'])
                break;
        }

        $advertisers = array();
        foreach ($results as $result)
        {
            $advertiser = $this->prepareAdvertiser($result);
            $advertisers[$advertiser->id] = $advertiser;
        }
        return $advertisers;
    }

    public function getTerms($campaign_id)
    {
        $api_client = $this->getApiClient();
        try
        {
            $r = $api_client->getTerms($campaign_id);
        }
        catch (\Exception $e)
        {
            $log = $this->getId() . ': Error occurred while getting campaign terms.';
            $log .= ' ' . sprintf('Campaign ID: %d. ', $campaign_id);
            $log .= ' ' . 'Server response: ' . $e->getMessage();
            Plugin::logger()->info($log);
            return array();
        }

        if (!isset($r['PayoutTermsList']) || !is_array($r['PayoutTermsList']))
            return false;

        return $r['PayoutTermsList'];
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
            $log = sprintf(($this->getId() . ': Error occurred while getting advertiser info. Advertiser (campaign) ID# %d.'), $advertiser_id);
            $log .= 'Server response: ' . $e->getMessage();
            Plugin::logger()->info($log);
            return false;
        }

        if (!isset($result['CampaignId']))
            return false;

        if (!$terms = $this->getTerms($result['CampaignId']))
            return false;

        $result['PayoutTermsList'] = $terms;

        $advertiser = $this->prepareAdvertiser($result);
        if (!$advertiser)
            return false;

        $advertiser->id = $advertiser_id;
        return $advertiser;
    }

    private function prepareAdvertiser($result)
    {
        if (!isset($result['CampaignId']))
            return false;

        $advertiser = new Advertiser;

        $advertiser->id = (int) $result['CampaignId'];
        $name = $result['AdvertiserName'];
        $name = str_replace(', LLC', '', $name);
        $name = str_replace(', Inc.', '', $name);
        $name = str_replace(' Inc.', '', $name);

        $advertiser->name = \sanitize_text_field($name);
        $advertiser->site_url = $result['CampaignUrl'];
        $advertiser->domain = TextHelper::getDomainName($result['CampaignUrl']);
        $advertiser->deeplink = $result['TrackingLink'];

        //$advertiser->logo_url = 'https://cdn1.impact.com' . $result['CampaignLogoUri'];
        $advertiser->logo_url = 'https://cdn1.impact.com/display-logo-via-campaign/' . $advertiser->id . '.gif';

        $currency = ImpactConfig::getInstance()->option('currency');
        $term = reset($result['PayoutTermsList']);
        if ($term['PayoutCurrency'])
            $advertiser->currency_code = $term['PayoutCurrency'];
        elseif ($currency && strlen($currency) == 3)
            $advertiser->currency_code = strtoupper($currency);
        else
            $advertiser->currency_code = 'USD';

        list($min, $max, $type) = self::parseCommissionDetails($result['PayoutTermsList']);
        $advertiser->commission_min = $min;
        $advertiser->commission_max = $max;
        $advertiser->commission_type = $type;
        return $advertiser;
    }

    private static function parseCommissionDetails(array $terms)
    {
        $max_percentage = $max_flat = 0;
        $min_percentage = 100;
        $min_flat = \PHP_INT_MAX;
        $type = null;

        foreach ($terms as $rate)
        {
            if ($rate['PayoutPercentage'])
            {
                // percentage
                if ((float) $rate['PayoutPercentageLowerLimit'] < $min_percentage)
                    $min_percentage = (float) $rate['PayoutPercentageLowerLimit'];
                if ((float) $rate['PayoutPercentageUpperLimit'] > $max_percentage)
                    $max_percentage = (float) $rate['PayoutPercentageUpperLimit'];
                $type = Advertiser::COMMISSION_TYPE_PERCENTAGE;
            }
            else
            {
                // flat
                if ((float) $rate['PayoutAmountLowerLimit'] < $min_flat)
                    $min_flat = (float) $rate['PayoutAmountLowerLimit'];
                if ((float) $rate['PayoutAmountUpperLimit'] > $max_flat)
                    $max_flat = (float) $rate['PayoutAmountUpperLimit'];
                $type = Advertiser::COMMISSION_TYPE_FLAT;
            }
        }

        if ($type == Advertiser::COMMISSION_TYPE_PERCENTAGE)
            return array($min_percentage, $max_percentage, $type);
        else
            return array($min_flat, $max_flat, $type);
    }

    public function getCoupons($advertiser_id)
    {
        $api_client = $this->getApiClient();
        $params = array();

        $response = $api_client->getCoupons($advertiser_id, $params);
        if (!$response || !isset($response['Ads']) || !is_array($response['Ads']))
            return array();

        $response = array_slice($response['Ads'], 0, CouponManager::getInstance()->getPerPageLimit());
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

        $coupon->network_id = (int) $r['Id'];
        $coupon->title = \sanitize_text_field($r['Name']);
        $coupon->description = \sanitize_text_field($r['Description']);
        $coupon->link = strip_tags($r['TrackingLink']);

        if (isset($r['StartDate']) && $d = strtotime($r['StartDate']))
            $coupon->start_date = $d;

        if (isset($r['EndDate']) && $d = strtotime($r['EndDate']))
            $coupon->end_date = $d;

        $coupon->extra = $r;

        if ($coupon->title == $coupon->description)
            $coupon->description = '';

        return $coupon;
    }
}
