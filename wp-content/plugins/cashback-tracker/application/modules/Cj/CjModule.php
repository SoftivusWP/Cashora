<?php

namespace CashbackTracker\application\modules\Cj;

defined('\ABSPATH') || exit;

use CashbackTracker\application\Plugin;
use CashbackTracker\application\components\CashbackModule;
use CashbackTracker\application\libs\CjRest;
use CashbackTracker\application\libs\CjGrapQl;
use CashbackTracker\application\components\OrderManager;
use CashbackTracker\application\components\Order;
use CashbackTracker\application\components\Advertiser;
use CashbackTracker\application\helpers\TextHelper;
use CashbackTracker\application\components\Coupon;
use CashbackTracker\application\components\CouponManager;

use function CashbackTracker\prn;
use function CashbackTracker\prnx;

/**
 * CjModule class file
 *
 * @author keywordrush.com <support@keywordrush.com>
 * @link https://www.keywordrush.com
 * @copyright Copyright &copy; 2025 keywordrush.com
 */
class CjModule extends CashbackModule
{
    const SUBID_NAME = 'sid';
    const GOTO_NAME = 'url';
    const DEEPLINK_DOMAINS = array('www.jdoqocy.com', 'www.tkqlhce.com', 'www.anrdoezrs.net', 'www.dpbolvw.net');

    private $orders = array();
    private $iteration_count = 0;

    public function info()
    {
        return array(
            'name' => 'CJ',
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
        return new CjGrapQl(CjConfig::getInstance()->option('access_token'));
    }

    public function isTrackableUrl($url)
    {
        if (!$url_parts = parse_url($url))
            return false;

        if (isset($url_parts['host']) && in_array($url_parts['host'], self::DEEPLINK_DOMAINS))
            return true;

        if (isset($url_parts['path']) && isset($url_parts['query']))
        {
            if (!preg_match('/click-\d+-\d+/', $url_parts['path']))
                return false;

            parse_str($url_parts['query'], $vars);
            if (!empty($vars['url']) && preg_match('/https?:\/\//', $vars['url']))
                return true;
        }

        return false;
    }

    public function getOrders()
    {
        $this->iteration_count++;
        if ($this->iteration_count > 20)
            throw new \Exception('CJ API: Something went wrong.');

        $api_client = $this->getApiClient();
        $options = array();

        if (!$this->date_start)
            $this->date_start = $this->getDateStart('Y-m-d\Th:i:s\Z');

        $endDate = date('Y-m-d\Th:i:s\Z', strtotime($this->date_start . '+30 days'));

        $publisherCommissions = sprintf('forPublishers: "%d"', CjConfig::getInstance()->option('cid'));
        $publisherCommissions .= sprintf(',websiteIds: "%d"', CjConfig::getInstance()->option('website_id'));
        $publisherCommissions .= sprintf(',sinceEventDate: "%s"', $this->date_start);
        $publisherCommissions .= sprintf(',beforeEventDate: "%s"', $endDate);

        $records = array(
            'actionStatus',
            'actionTrackerId',
            'actionTrackerName',
            'actionType',
            'advertiserId',
            'aid',
            'clickDate',
            'clickReferringURL',
            'commissionId',
            'correctionReason',
            'eventDate',
            'lockingDate',
            'lockingMethod',
            'orderId',
            'original',
            'originalActionId',
            'postingDate',
            'pubCommissionAmountPubCurrency',
            'pubCommissionAmountUsd',
            'publisherId',
            'publisherName',
            'reviewedStatus',
            'saleAmountPubCurrency',
            'saleAmountUsd',
            'shopperId',
            'validationStatus',
        );
        $records = join(',', $records);

        $payload = '{publisherCommissions(' . $publisherCommissions . ') {records {' . $records . '}}}';

        $response = $api_client->getOrders($payload);
        $orders = $this->ordersPrepare($response);

        $this->orders = array_merge($this->orders, $orders);
        if (strtotime($endDate) < time())
        {
            // Date ranges of no more than 31 days are allowed in the arguments
            $this->date_start = date('Y-m-d\Th:i:s\Z', strtotime($this->date_start . '+30 days'));
            $this->getOrders();
        }

        // Corrections
        $corrections = array();
        foreach ($this->orders as $i => $order)
        {
            if ($order->is_correction)
            {
                $corrections[$order->merchant_order_id] = $this->orders[$i];
                unset($this->orders[$i]);
            }
        }

        foreach ($corrections as $order_id => $correction)
        {
            foreach ($this->orders as $i => $order)
            {
                if ($order->merchant_order_id == $order_id)
                {
                    $this->orders[$i]->sale_amount += $correction->sale_amount;
                    $this->orders[$i]->commission_amount += $correction->commission_amount;
                    break;
                }
            }
        }

        return array_values($this->orders);
    }

    private function ordersPrepare($results)
    {
        if (!$results || !isset($results['data']['publisherCommissions']['records']))
            return array();
        $results = $results['data']['publisherCommissions']['records'];

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
        //@debug
        if (!empty($_SERVER['KEYWORDRUSH_DEVELOPMENT']) && $_SERVER['KEYWORDRUSH_DEVELOPMENT'] == '16203273895503427')
            $r['shopperId'] = 'cbtrkr-' . 1;

        if (!$r['shopperId'] || !OrderManager::isCashbackSubid($r['shopperId']))
            return false;

        $order = new Order;
        $order->order_id = (int) $r['commissionId'];
        $order->merchant_order_id = $r['orderId'];
        $order->module_id = $this->getId();
        $status = self::bindStatus($r['actionStatus'], $r['validationStatus']);
        if ($status === false)
        {
            Plugin::logger()->warning('CJ API: Unknown order status.');
            return false;
        }
        $order->order_status = $status;
        $order->subid = $r['shopperId'];
        $order->advertiser_id = (int) $r['advertiserId'];

        $pub_currency = strtoupper($this->config('pub_currency'));
        if (strlen($pub_currency) != 3)
            $pub_currency = '';

        if ($pub_currency && $pub_currency != 'USD')
        {
            $order->sale_amount = round((float) $r['saleAmountPubCurrency'], 2);
            $order->commission_amount = round((float) $r['pubCommissionAmountPubCurrency'], 2);
            $order->currency_code = $pub_currency;
        }
        else
        {
            $order->sale_amount = round((float) $r['saleAmountUsd'], 2);
            $order->commission_amount = round((float) $r['pubCommissionAmountUsd'], 2);
            $order->currency_code = 'USD';
        }

        $order->click_date = strtotime($r['clickDate']);
        $order->action_date = strtotime($r['eventDate']);
        $order->user_referer = $r['clickReferringURL'];
        $order->is_correction = !$r['original'];
        $order->api_response = serialize($r);

        $advertiser = $this->advertiser($order->advertiser_id);
        if (!$advertiser)
        {
            Plugin::logger()->info(sprintf('CJ API: Unknown Advertiser ID: %d.', $order->advertiser_id));
            return false;
        }
        $order->advertiser_domain = $advertiser['domain'];
        return $order;
    }

    private static function bindStatus($actionStatus, $validationStatus)
    {
        $actionStatus = strtolower($actionStatus);
        $validationStatus = strtolower($validationStatus);

        $prepared_for_payment = array('closed');
        if (CjConfig::getInstance()->option('locked_status') == 'approved')
            $prepared_for_payment[] = 'locked';

        if (in_array($actionStatus, $prepared_for_payment) && in_array($validationStatus, array('accepted', 'automated')))
            return Order::STATUS_APPROVED;
        elseif ($validationStatus == 'declined')
            return Order::STATUS_DECLINED;
        else
            return Order::STATUS_PENDING;
    }

    public function getAdvertisers()
    {
        return $this->getAdvertisersApi();
    }

    public function getAdvertiser($advertiser_id)
    {
        if (!$advertisers = $this->getAdvertisersApi($advertiser_id))
            return false;
        else
            return reset($advertisers);
    }

    public function getAdvertisersApi($advertiser_ids = 'joined')
    {
        @set_time_limit(2700);

        $api_client = new CjRest(CjConfig::getInstance()->option('access_token'));
        $options = array();
        $options['requestor-cid'] = CjConfig::getInstance()->option('cid');
        $options['advertiser-ids'] = $advertiser_ids;
        $options['records-per-page'] = 100; //max limit
        $options['page-number'] = 1;

        $results = array();
        for ($i = 1; $i < 25; $i++)
        {
            try
            {
                $r = $api_client->advertiserLookup($options);
            }
            catch (\Exception $e)
            {
                $log = $this->getId() . ': Error occurred while getting advertiser list.';
                $log .= 'Server response: ' . $e->getMessage();
                Plugin::logger()->warning($log);
                return array();
            }

            if (!$r || !isset($r['advertisers']['advertiser']))
                return array();

            $advertisers = $r['advertisers']['advertiser'];

            if (!isset($advertisers[0]) && isset($advertisers['advertiser-id']))
                $advertisers = array($advertisers);

            $results = array_merge($results, $advertisers);

            if ($options['page-number'] >= $r['advertisers']['@attributes']['total-matched'] / $options['records-per-page'])
                break;

            $options['page-number']++;
        }

        $advertisers = array();
        $start_time = time();
        $n = 1;
        foreach ($results as $result)
        {
            // throttling: 25 API calls for link search per minute
            if ($n % 25 == 0)
            {
                sleep(60 - (time() - $start_time) + 1);
                $start_time = time();
            }

            $advertiser = $this->prepareAdvertiser($result);

            $advertisers[$advertiser->id] = $advertiser;
            $n++;
        }
        return $advertisers;
    }

    private function prepareAdvertiser(array $result)
    {
        $advertiser = new Advertiser;
        $advertiser->id = (int) $result['advertiser-id'];
        $advertiser->name = \sanitize_text_field($result['advertiser-name']);
        $advertiser->site_url = strtolower($result['program-url']);
        $advertiser->domain = TextHelper::getDomainName($result['program-url']);

        if (isset($result['actions']['action']))
        {

            $actions = $result['actions']['action'];
            if (!isset($actions[0]))
                $actions = array($actions);
        }
        else
            $actions = array();

        list($min, $max, $type, $currency) = self::parseCommissionDetails($actions);

        $advertiser->commission_min = $min;
        $advertiser->commission_max = $max;
        $advertiser->commission_type = $type;
        $advertiser->currency_code = $currency;

        // find deeplink
        if ($deeplink = $this->findDeeplink($advertiser->id))
            $advertiser->deeplink = $deeplink;
        else
        {
            $domain = self::DEEPLINK_DOMAINS[array_rand(self::DEEPLINK_DOMAINS)];
            $pid = (int) CjConfig::getInstance()->option('website_id');
            $advertiser->deeplink = 'https://' . $domain . '/links/' . $pid . '/type/dlg/sid/{{sub_id}}/{{url}}';
        }

        return $advertiser;
    }

    private function findDeeplink($advertiser_id)
    {
        $deeplink = \apply_filters('cbtrkr_cj_advertiser_deeplink', $advertiser_id);

        if ($deeplink && $deeplink != $advertiser_id)
            return $deeplink;

        $api_client = new CjRest(CjConfig::getInstance()->option('access_token'));
        $options = array();
        $options['website-id'] = CjConfig::getInstance()->option('website_id');
        $options['advertiser-ids'] = $advertiser_id;
        $options['records-per-page'] = 1;
        $options['page-number'] = 1;
        $options['allow-deep-linking'] = 'yes';
        //$options['promotion-type'] = 'site to store';
        $options['link-type'] = 'text link';

        try
        {
            $response = $api_client->linkSearch($options);
        }
        catch (\Exception $e)
        {
            return false;
        }

        if (!isset($response['links']['link']['clickUrl']))
            return false;

        $deeplink = $response['links']['link']['clickUrl'];
        $deeplink = preg_replace('/(click-\d+-\d+)-\d+$/', '$1', $deeplink);
        return $deeplink;
    }

    private static function parseCommissionDetails(array $actions)
    {
        if (!$actions)
            return array(0, 0, Advertiser::COMMISSION_TYPE_PERCENTAGE, '');

        $max_percentage = $max_flat = 0;
        $min_percentage = 100;
        $min_flat = \PHP_INT_MAX;
        $type = null;
        $currency = '';
        foreach ($actions as $action)
        {
            $commission = $action['commission']['default'];

            if (strstr($commission, '%'))
            {
                // percentage
                $rate = (float) $commission;
                if ($rate < $min_percentage)
                    $min_percentage = $rate;
                if ($rate > $max_percentage)
                    $max_percentage = $rate;
                if (!$type)
                    $type = Advertiser::COMMISSION_TYPE_PERCENTAGE;
            }
            else
            {
                $parts = explode(' ', $commission);
                if (count($parts) != 2)
                    throw new \Exception('CJ Module: Unknown commission type.');

                $currency = $parts[0];
                $rate = (float) $parts[1];

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
        $api_client = new CjRest(CjConfig::getInstance()->option('access_token'));
        $options = array();
        $options['website-id'] = CjConfig::getInstance()->option('website_id');
        $options['advertiser-ids'] = $advertiser_id;
        $options['records-per-page'] = CouponManager::getInstance()->getPerPageLimit(); //100 max limit
        $options['page-number'] = 1;

        $response = $api_client->linkSearch($options);
        return $this->couponsPrepare($response);
    }

    private function couponsPrepare($results)
    {
        if (empty($results['links']['link']) || !is_array($results['links']['link']))
            return array();

        $results = $results['links']['link'];

        if (!isset($results[0]) && isset($results['link-id']))
            $results = array($results);

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
        if (!isset($r['clickUrl']))
            return false;

        if (!is_string($r['link-code-html']))
            return false;

        if ($r['link-type'] == 'Banner')
            return false;

        $coupon = new Coupon;

        $coupon->network_id = (int) $r['link-id'];
        $coupon->title = \sanitize_text_field($r['link-name']);

        if (stristr($coupon->title, 'homepage'))
            return false;

        $coupon->code = \sanitize_text_field($r['coupon-code']);
        $coupon->link = strip_tags($r['clickUrl']);

        // parse link code html
        $doc = new \DOMDocument();
        @$doc->loadHTML($r['link-code-html']);

        if ($images = $doc->getElementsByTagName('img'))
        {
            if ($images->item(0) && $images->item(0)->getAttribute('height') != 1)
                $coupon->image = $images->item(0)->getAttribute('src');
        }

        if ($r['link-type'] == 'Text Link' && $links = $doc->getElementsByTagName('a'))
            $coupon->title = \sanitize_text_field($links->item(0)->nodeValue);

        if ($r['description'] != $coupon->title)
        {
            $coupon->description = \sanitize_text_field($r['description']);
            $coupon->description = str_replace($coupon->title, '', $coupon->description);
            $coupon->description = ltrim($coupon->description, ".!, ");

            if (stristr($coupon->description, 'homepage'))
                return false;
        }

        if (strstr(strtolower($coupon->title), 'banner') || strstr(strtolower($coupon->title), 'placeholder') || strstr(strtolower($coupon->title), 'click here'))
        {
            if ($coupon->description)
            {
                $coupon->title = $coupon->description;
                $coupon->description = '';
            }
            else
                return false;
        }

        if (!empty($r['promotion-start-date']) && $d = strtotime($r['promotion-start-date']))
            $coupon->start_date = $d;

        if (!empty($r['promotion-end-date']) && $d = strtotime($r['promotion-end-date']))
            $coupon->end_date = $d;

        $coupon->extra = $r;

        return $coupon;
    }
}
