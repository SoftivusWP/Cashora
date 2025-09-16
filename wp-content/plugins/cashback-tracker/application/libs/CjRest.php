<?php

namespace CashbackTracker\application\libs;

defined('\ABSPATH') || exit;

use CashbackTracker\application\libs\RestClient;

/**
 * CjRest class file
 *
 * @author keywordrush.com <support@keywordrush.com>
 * @link https://www.keywordrush.com
 * @copyright Copyright &copy; 2025 keywordrush.com
 *
 */
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'RestClient.php';

class CjRest extends RestClient
{

    const API_URI_BASE_ADVERTISER = 'https://advertiser-lookup.api.cj.com/v2';
    const API_URI_BASE_LINKS = 'https://link-search.api.cj.com/v2';

    private $access_token;
    protected $_responseTypes = array(
        'xml',
    );

    public function __construct($access_token)
    {
        $this->setResponseType('xml');
        $this->access_token = $access_token;
    }

    /**
     * Advertiser Lookup
     * @link: https://developers.cj.com/docs/rest-apis/advertiser-lookup
     */
    public function advertiserLookup(array $params = array())
    {
        $this->setUri(self::API_URI_BASE_ADVERTISER);
        $response = $this->restGet('/advertiser-lookup', $params);
        return $this->_decodeResponse($response);
    }

    /**
     * Link Search
     * @link: https://developers.cj.com/docs/rest-apis/link-search
     * Call limit: 25 calls per minute
     */
    public function linkSearch(array $params = array())
    {
        $this->setUri(self::API_URI_BASE_LINKS);
        $response = $this->restGet('/link-search', $params);
        return $this->_decodeResponse($response);
    }

    public function restGet($path, array $query = null)
    {
        if (!$this->access_token)
            throw new \Exception("Access token not provided.");

        $this->setCustomHeaders(array('Authorization' => 'Bearer ' . $this->access_token));
        return parent::restGet($path, $query);
    }
}
