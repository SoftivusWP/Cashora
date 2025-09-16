<?php

namespace CashbackTracker\application\libs;

defined('\ABSPATH') || exit;

use CashbackTracker\application\libs\RestClient;

/**
 * CuelinksApi class file
 *
 * @author keywordrush.com <support@keywordrush.com>
 * @link https://www.keywordrush.com
 * @copyright Copyright &copy; 2025 keywordrush.com
 *
 * @link: https://cuelinks.docs.apiary.io/#
 */
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'RestClient.php';

class CuelinksApi extends RestClient
{

    const API_URI_BASE = 'https://www.cuelinks.com/api/v2';

    private $api_key;
    protected $_responseTypes = array(
        'json',
    );

    public function __construct($api_key)
    {
        $this->api_key = $api_key;
        $this->setUri(self::API_URI_BASE);
        $this->setResponseType('json');
    }

    /**
     * Campaigns
     * @link: https://cuelinks.docs.apiary.io/#reference/authentication/get-campaigns
     */
    public function getAdvertisers(array $params = array())
    {
        $response = $this->restGet('/campaigns.json', $params);
        return $this->_decodeResponse($response);
    }

    /**
     * Transactions
     * @link: https://cuelinks.docs.apiary.io/#reference/api-methods/transactions/get-transactions?console=1
     */
    public function getOrders(array $params = array())
    {
        $response = $this->restGet('/transactions.json', $params);
        return $this->_decodeResponse($response);
    }

    /**
     * Offers
     * @link: https://cuelinks.docs.apiary.io/#reference/api-methods/offers/get-transactions?console=1
     */
    public function getOffers(array $params = array())
    {
        $response = $this->restGet('/offers.json', $params);
        return $this->_decodeResponse($response);
    }

    public function restGet($path, array $query = null)
    {
        $this->setCustomHeaders(array('Authorization' => 'Token token=' . $this->api_key, 'Content-Type' => 'application/json'));
        return parent::restGet($path, $query);
    }
}
