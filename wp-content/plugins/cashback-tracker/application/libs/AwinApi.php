<?php

namespace CashbackTracker\application\libs;

defined('\ABSPATH') || exit;

use CashbackTracker\application\libs\RestClient;

/**
 * AwinApi class file
 *
 * @author keywordrush.com <support@keywordrush.com>
 * @link https://www.keywordrush.com
 * @copyright Copyright &copy; 2025 keywordrush.com
 *
 * @link: https://wiki.awin.com/index.php/Publisher_API
 */
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'RestClient.php';

class AwinApi extends RestClient
{

  const API_URI_BASE = 'https://api.awin.com';

  protected $access_token;
  protected $publisher_id;
  protected $_responseTypes = array(
    'json',
  );

  public function __construct($access_token, $publisher_id)
  {
    $this->access_token = $access_token;
    $this->publisher_id = $publisher_id;
    $this->setUri(self::API_URI_BASE);
    $this->setResponseType('json');
  }

  /**
   * Provides a list of your individual transactions
   * @link: https://wiki.awin.com/index.php/API_get_transactions_list
   */
  public function getOrders(array $options = array())
  {
    self::$timeout = 120;

    $response = $this->restGet('/publishers/' . urlencode($this->publisher_id) . '/transactions/', $options);

    //@debug
    if (!empty($_SERVER['KEYWORDRUSH_DEVELOPMENT']) && $_SERVER['KEYWORDRUSH_DEVELOPMENT'] == '16203273895503427')
      $response = trim($this->debugTransactions());

    return $this->_decodeResponse($response);
  }

  /**
   * Offers
   * @link: https://wiki.awin.com/index.php/API_Post_Offers
   */
  public function getOffers($publisher_id, array $filters = array())
  {
    $payload = array(
      'filters' => $filters,
    );

    $headers = array(
      'Content-Type' => 'application/json',
      'Authorization' => 'Bearer ' . $this->access_token
    );

    $this->setCustomHeaders($headers);

    $response = $this->restPost('/publisher/' . urlencode($publisher_id) . '/promotions', json_encode($payload));
    return $this->_decodeResponse($response);
  }

  /*
     * Provides detailed information about a programme you have an active relationship with
     * @link: https://wiki.awin.com/index.php/API_get_programmes
     */

  public function getAdvertisers(array $options = array())
  {
    self::$timeout = 60;

    $response = $this->restGet('/publishers/' . urlencode($this->publisher_id) . '/programmes', $options);
    return $this->_decodeResponse($response);
  }

  /*
     * Provides detailed information about a programme you have an active relationship with
     * @link: https://wiki.awin.com/index.php/API_get_programmedetails
     */

  public function getAdvertiser($advertiser_id)
  {
    $options = array(
      'advertiserId' => $advertiser_id
    );
    $response = $this->restGet('/publishers/' . urlencode($this->publisher_id) . '/programmedetails', $options);
    return $this->_decodeResponse($response);
  }

  public function restGet($path, array $query = null)
  {
    if (!$this->access_token)
      throw new \Exception("Access token not provided.");

    $this->setCustomHeaders(array('Authorization' => 'Bearer ' . $this->access_token));
    return parent::restGet($path, $query);
  }

  public function debugTransactions()
  {
    return '[
  {
    "id": 259630312,
    "url": "http://www.publisher.com",
    "advertiserId": 10526,
    "publisherId": 189069,
    "commissionSharingPublisherId": 55555,
    "siteName": "Publisher",
    "commissionStatus": "pending",
    "commissionAmount": {
      "amount": 5.59,
      "currency": "USD"
    },
    "saleAmount": {
      "amount": 55.96,
      "currency": "USD"
    },
    "ipHash": "-66667778889991112223",
    "customerCountry": "GB",
    "clickRefs": {
      "clickRef": "cbtrkr-1",
      "clickRef2": "22222",
      "clickRef3": "33333",
      "clickRef4": "44444",
      "clickRef5": "55555",
      "clickRef6": "66666"
    },
    "clickDate": "2017-01-23T12:18:00",
    "transactionDate": "2017-02-20T22:04:00",
    "validationDate": null,
    "type": "Commission group transaction",
    "declineReason": null,
    "voucherCodeUsed": true,
    "voucherCode": "example123",
    "lapseTime": 2454307,
    "amended": false,
    "amendReason": null,
    "oldSaleAmount": null,
    "oldCommissionAmount": null,
    "clickDevice": "Windows",
    "transactionDevice": "Windows",
    "publisherUrl": "http://www.publisher.com/search?query=dvds",
    "advertiserCountry": "GB",
    "orderRef": "111222333444",
    "customParameters": [
      {
        "key": "1",
        "value": "555666"
      },
      {
        "key": "2",
        "value": "example entry"
      },
      {
        "key": "3",
        "value": "LLLMMMNNN"
      }
    ],
    "transactionParts": [
      {
        "commissionGroupId": 12345,
        "amount": 44.76,
        "commissionAmount": 4.50,
        "commissionGroupCode": "DEFAULT",
        "commissionGroupName": "Default Commission"
      },

      {

        "commissionGroupId": 654321,
        "amount": 11.20,
        "commissionAmount": 1.50,
        "commissionGroupCode": "EXISTING",
        "commissionGroupName": "EXISTING"
      }

    ],
    "paidToPublisher": false,
    "paymentId": 0,
    "transactionQueryId": 0,
    "originalSaleAmount": null
  }
]';
  }
}
