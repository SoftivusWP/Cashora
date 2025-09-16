<?php

namespace CashbackTracker\application\libs;

defined('\ABSPATH') || exit;

use CashbackTracker\application\libs\RestClient;

/**
 * CjGrapQl class file
 *
 * @author keywordrush.com <support@keywordrush.com>
 * @link https://www.keywordrush.com
 * @copyright Copyright &copy; 2025 keywordrush.com
 *
 * @link: https://developers.cj.com/graphql/reference/Commission%20Detail
 */
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'RestClient.php';

class CjGrapQl extends RestClient
{

    const API_URI_BASE = 'https://commissions.api.cj.com';

    private $accessToken;
    protected $_responseTypes = array(
        'json',
    );

    public function __construct($accessToken)
    {
        $this->setResponseType('json');
        $this->setUri(self::API_URI_BASE);
        $this->accessToken = $accessToken;
    }

    public function getOrders($payload)
    {
        $response = $this->restPost('/query', $payload);
        return $this->_decodeResponse($response);
    }

    public function restPost($path, $data = null, $enctype = null, $opts = array())
    {
        $this->setCustomHeaders(array('Authorization' => 'Bearer ' . $this->accessToken, 'Accept' => 'application/json'));
        return parent::restPost($path, $data);
    }
}
