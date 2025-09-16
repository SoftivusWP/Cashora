<?php

namespace CashbackTracker\application\libs;

defined('\ABSPATH') || exit;

use CashbackTracker\application\libs\RestClient;

/**
 * LinkwiseApi class file
 *
 * @author keywordrush.com <support@keywordrush.com>
 * @link https://www.keywordrush.com
 * @copyright Copyright &copy; 2025 keywordrush.com
 *
 * @link: https://affiliate.linkwi.se/api/1.1/
 */
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'RestClient.php';

class LinkwiseApi extends RestClient
{

    const API_URI_BASE = 'https://affiliate.linkwi.se/api/1.1';

    protected $api_username;
    protected $api_password;
    protected $_responseTypes = array(
        'json',
    );

    public function __construct($api_username, $api_password)
    {
        $this->api_username = $api_username;
        $this->api_password = $api_password;
        $this->setUri(self::API_URI_BASE);
        $this->setResponseType('json');
    }

    public function getOrders(array $options = array())
    {
        self::$timeout = 60;

        $options['format'] = 'json';
        $response = $this->restGet('/reports_transaction.html', $options);
        return $this->_decodeResponse($response);
    }

    public function getAdvertisers(array $options = array())
    {
        self::$timeout = 60;

        $options['format'] = 'json';
        $response = $this->restGet('/programs.html', $options);
        return $this->_decodeResponse($response);
    }

    public function getCreatives(array $options = array())
    {
        self::$timeout = 60;

        $options['format'] = 'json';
        $response = $this->restGet('/creatives.html', $options);
        return $this->_decodeResponse($response);
    }

    public function restGet($path, array $query = null)
    {
        $query['format'] = $this->getResponseType();
        $this->setCustomHeaders(array('Authorization' => 'Basic ' . base64_encode($this->api_username . ':' . $this->api_password)));
        return parent::restGet($path, $query);
    }
}
