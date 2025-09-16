<?php

namespace CashbackTracker\application\libs;

defined('\ABSPATH') || exit;

use CashbackTracker\application\libs\RestClient;

/**
 * AdmitadApi class file
 *
 * @author keywordrush.com <support@keywordrush.com>
 * @link https://www.keywordrush.com
 * @copyright Copyright &copy; 2025 keywordrush.com
 *
 * @link: https://developers.admitad.com/en/doc/webmaster-api/
 */
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'RestClient.php';

class AdmitadApi extends RestClient
{

    const API_URI_BASE = 'https://api.admitad.com';

    protected $access_token;
    protected $_responseTypes = array(
        'json',
    );

    public function __construct($access_token = null)
    {
        $this->setAccessToken($access_token);
        $this->setUri(self::API_URI_BASE);
        $this->setResponseType('json');
    }

    public function setAccessToken($access_token)
    {
        $this->access_token = $access_token;
    }

    public function requestAccessToken($client_id, $client_secret, $scope)
    {
        $query = array(
            'grant_type' => 'client_credentials',
            'client_id' => $client_id,
            'scope' => $scope,
        );

        $this->setCustomHeaders(array('Authorization' => 'Basic ' . base64_encode($client_id . ":" . $client_secret)));
        $response = $this->restPost('/token/', $query);
        return $this->_decodeResponse($response);
    }

    public function getOrders(array $options = array())
    {
        $response = $this->restGet('/statistics/actions/', $options);
        return $this->_decodeResponse($response);
    }

    public function getAdvertisers($website_id, array $options = array())
    {
        self::$timeout = 60;

        if (!isset($options['limit']))
            $options['limit'] = 500;
        $response = $this->restGet('/advcampaigns/website/' . urlencode($website_id) . '/', $options);
        return $this->_decodeResponse($response);
    }

    public function getAdvertiser($website_id, $advertiser_id)
    {
        $response = $this->restGet('/advcampaigns/' . urlencode($advertiser_id) . '/website/' . urlencode($website_id) . '/');
        return $this->_decodeResponse($response);
    }

    /**
     * @link: https://developers.admitad.com/en/doc/api_en/methods/coupons/coupons-website/
     */
    public function getCoupons($website_id, array $options = array())
    {
        self::$timeout = 60;

        $response = $this->restGet('/coupons/website/' . urlencode($website_id) . '/', $options);
        return $this->_decodeResponse($response);
    }

    public function restGet($path, array $query = null)
    {
        if (!$this->access_token)
            throw new \Exception("Access token not provided.");

        if (is_array($query) && !isset($query['language']))
            $query['language'] = 'en';

        $this->setCustomHeaders(array('Authorization' => 'Bearer ' . $this->access_token));
        return parent::restGet($path, $query);
    }
}
