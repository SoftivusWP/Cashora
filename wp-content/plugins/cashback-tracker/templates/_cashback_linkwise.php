<?php defined('\ABSPATH') || exit; ?>

<?php

$extra = $viewer->getExtra();

if (!$extra || count($extra['commissions']['details']) <= 1)
{
    echo '<div class="cbtrkr_cashback_notice_value">' . \esc_html($viewer->getCashback()) . '</div>';
    return;
}

foreach ($extra['commissions']['details'] as $d)
{
    $name = $d['category']['name'];
    $type = $d['category']['payout_type'];
    $value = $d['category']['tiers'][0]['tier']['action'];

    echo '<span class="cbtrkr_cashback_notice_name">' . \esc_html(__($name, 'cashback-tracker')) . ': ';

    $advertiser = $viewer->getAdvertiser();

    $advertiser['commission_min'] = $value;
    $advertiser['commission_max'] = $value;

    if ($type == 'percent')
        $advertiser['commission_type'] = \CashbackTracker\application\components\Advertiser::COMMISSION_TYPE_PERCENTAGE;
    else
        $advertiser['commission_type'] = \CashbackTracker\application\components\Advertiser::COMMISSION_TYPE_FLAT;

    $cashback = CashbackTracker\application\components\Commission::displayAdvertiserCashback($advertiser);

    echo '<span class="cbtrkr_cashback_notice_value">' . \esc_html($cashback) . '</span><br />';
}

