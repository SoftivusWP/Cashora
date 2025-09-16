<?php

namespace CashbackTracker\application\libs;

defined('\ABSPATH') || exit;

use CashbackTracker\application\libs\RestClient;

/**
 * InrdealsApi class file
 *
 * @author keywordrush.com <support@keywordrush.com>
 * @link https://www.keywordrush.com
 * @copyright Copyright &copy; 2025 keywordrush.com
 *
 * @link: https://inrdeals.sgp1.cdn.digitaloceanspaces.com/resources/pdf/INRDealsAPIDocumentation.pdf
 */
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'RestClient.php';

class InrdealsApi extends RestClient
{

    const API_URI_BASE = 'https://inrdeals.com';

    protected static $timeout = 60; //sec
    protected $id;
    protected $token_store;
    protected $token_coupon;
    protected $token_transaction;
    protected $_responseTypes = array(
        'json',
    );

    public function __construct($id, $token_store, $token_coupon, $token_transaction)
    {
        $this->id = $id;
        $this->token_store = $token_store;
        $this->token_coupon = $token_coupon;
        $this->token_transaction = $token_transaction;

        $this->setUri(self::API_URI_BASE);
        $this->setResponseType('json');
    }

    public function getOrders(array $options = array())
    {
        $options['token'] = $this->token_transaction;
        $response = $this->restGet('/fetch/reports', $options);
        return $this->_decodeResponse($response);
    }

    public function getAdvertisers(array $options = array())
    {
        $options['token'] = $this->token_store;
        $response = $this->restGet('/fetch/stores', $options);
        return $this->_decodeResponse($response);
    }

    public function getCoupons($campaign_id, array $options = array())
    {
        $options['store_id'] = $campaign_id;
        $options['token'] = $this->token_coupon;
        $response = $this->restGet('/api/v1/coupon-feed', $options);
        return $this->_decodeResponse($response);
    }

    public function restGet($path, array $query = null)
    {
        $query['id'] = $this->id;
        return parent::restGet($path, $query);
    }
}
