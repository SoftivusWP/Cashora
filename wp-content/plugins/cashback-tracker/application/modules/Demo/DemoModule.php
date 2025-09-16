<?php

namespace CashbackTracker\application\modules\Demo;

defined('\ABSPATH') || exit;

use CashbackTracker\application\components\CashbackModule;
use CashbackTracker\application\components\Order;
use CashbackTracker\application\components\Advertiser;
use CashbackTracker\application\helpers\TextHelper;
use CashbackTracker\application\components\Network;
use CashbackTracker\application\helpers\WpHelper;
use CashbackTracker\application\components\Coupon;

/**
 * DemoModule class file
 *
 * @author keywordrush.com <support@keywordrush.com>
 * @link https://www.keywordrush.com
 * @copyright Copyright &copy; 2025 keywordrush.com
 */
class DemoModule extends CashbackModule
{

    const SUBID_NAME = 'subid';
    const GOTO_NAME = 'go';
    const DEMO_ADVERTISER_ID = 123;

    public function info()
    {
        return array(
            'name' => 'Demo',
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
        return '';
    }

    public function getOrders()
    {
        $username = DemoConfig::getInstance()->option('username');
        if ($username && $user = \get_user_by('login', $username))
            $user_id = $user->ID;
        else
            $user_id = self::getAdminId();

        $orders = array();
        for ($i = 1; $i <= 3; $i++)
        {
            $order = new Order;
            $order->order_id = time() . rand(100, 999);
            $order->merchant_order_id = $order->order_id;
            $order->module_id = $this->getId();

            if ($i % 2 == 0)
                $order->order_status = Order::STATUS_PENDING;
            elseif ($i % 3 == 0)
                $order->order_status = Order::STATUS_DECLINED;
            else
                $order->order_status = Order::STATUS_APPROVED;

            $order->subid = Network::getSubidPrefix() . '-' . $user_id;
            $order->advertiser_id = self::DEMO_ADVERTISER_ID;
            $order->currency_code = $this->getConfigInstance()->option('currency');
            $order->sale_amount = rand(1, 100);
            $order->commission_amount = ($order->sale_amount * rand(3, 10)) / 100;

            $order->click_date = date("Y-m-d H:i:s", time() - rand(604800, 604800 * 3));
            $order->action_date = date("Y-m-d H:i:s", time() - rand(86400, 86400 * 5));
            $order->user_referer = '';
            $order->api_response = '';
            $order->advertiser_domain = 'example.com';
            $orders[] = $order;
        }
        return $orders;
    }

    public function getAdvertisers()
    {
        return array(
            self::DEMO_ADVERTISER_ID => $this->getAdvertiser(
                self::DEMO_ADVERTISER_ID
            )
        );
    }

    public function getAdvertiser($advertiser_id)
    {
        if ($advertiser_id != self::DEMO_ADVERTISER_ID)
            return false;

        $advertiser = new Advertiser;
        $advertiser->id = $advertiser_id;
        $advertiser->name = 'Demo advertiser ' . $advertiser_id;
        $advertiser->logo_url = 'https://via.placeholder.com/150/FFFF00/000000?text=DemoAdvertiser/O';
        $advertiser->site_url = 'https://www.example.com';
        $advertiser->domain = TextHelper::getDomainName($advertiser->site_url);
        $advertiser->average_payment_time = 60;
        $advertiser->validation_days = 30;
        $advertiser->currency_code = 'USD';
        $advertiser->deeplink = 'https://www.example.com/deeplink';
        $advertiser->commission_min = 2.5;
        $advertiser->commission_max = 15;
        $advertiser->commission_type = Advertiser::COMMISSION_TYPE_PERCENTAGE;
        return $advertiser;
    }

    private static function getAdminId()
    {
        return WpHelper::getCurrentUserIdOrAdmin();
    }

    public function getCoupons($advertiser_id)
    {
        $coupons = array();

        $coupon = new Coupon;
        $coupon->network_id = 12345;
        $coupon->title = 'Save up to 70% in our Sale section';
        $coupon->code = 'SALE70';
        $coupon->link = 'https://www.example.com';
        $coupon->discount = 70;
        $coupon->description = 'Shop the latest deals on our Sale Section!';
        $coupon->end_date = time() + 24 * 3600 * 7;
        $coupons[] = $coupon;

        $coupon = new Coupon;
        $coupon->network_id = 12345;
        $coupon->title = 'Best deal - 1 day sale on all products';
        $coupon->code = '';
        $coupon->link = 'https://www.example.com';
        $coupon->end_date = time() + 24 * 3600 * 1;
        $coupons[] = $coupon;

        return $coupons;
    }
}
