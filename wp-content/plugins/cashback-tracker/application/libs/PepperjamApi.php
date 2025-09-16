<?php

namespace CashbackTracker\application\libs;

defined('\ABSPATH') || exit;

use CashbackTracker\application\libs\RestClient;

/**
 * PepperjamApi class file
 *
 * @author keywordrush.com <support@keywordrush.com>
 * @link https://www.keywordrush.com
 * @copyright Copyright &copy; 2025 keywordrush.com
 *
 * @link: https://support.ascendpartner.com/s/publisher-api-documentation
 */
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'RestClient.php';

class PepperjamApi extends RestClient
{

    const API_URI_BASE = 'https://api.pepperjamnetwork.com/20120402';
    protected static $timeout = 60; //sec

    protected $api_key;
    protected $_responseTypes = array(
        'json',
    );

    public function __construct($api_key)
    {
        $this->api_key = $api_key;
        $this->setUri(self::API_URI_BASE);
        $this->setResponseType('json');
    }


    public function getOrders(array $options = array())
    {
        $response = $this->restGet('/publisher/report/transaction-details', $options);
        return $this->_decodeResponse($response);
    }

    public function getAdvertisers(array $options = array())
    {
        $response = $this->restGet('/publisher/advertiser', $options);
        return $this->_decodeResponse($response);
    }

    public function getDeeplinks(array $options = array())
    {
        $response = $this->restGet('/publisher/creative/generic', $options);
        return $this->_decodeResponse($response);
    }

    public function getCoupons($program_id, array $options = array())
    {
        self::$timeout = 60;
        $options['programId'] = $program_id;

        $response = $this->restGet('/publisher/creative/coupon', $options);
        return $this->_decodeResponse($response);
    }

    public function restGet($path, array $query = null)
    {
        $query['apiKey'] = $this->api_key;
        $query['format'] = $this->getResponseType();

        return parent::restGet($path, $query);
    }
}
