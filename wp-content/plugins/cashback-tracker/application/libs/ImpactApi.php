<?php

namespace CashbackTracker\application\libs;

defined('\ABSPATH') || exit;

use CashbackTracker\application\libs\RestClient;

/**
 * ImpactApi class file
 *
 * @author keywordrush.com <support@keywordrush.com>
 * @link https://www.keywordrush.com
 * @copyright Copyright &copy; 2025 keywordrush.com
 *
 * @link: https://integrations.impact.com/impact-publisher/reference/overview
 */
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'RestClient.php';

class ImpactApi extends RestClient
{

    const _API_VERSION = 13;
    const API_URI_BASE = 'https://product.api.impactradius.com/Mediapartners';

    protected static $timeout = 60; //sec
    protected $AccountSid;
    protected $AuthToken;
    protected $_responseTypes = array(
        'json',
    );

    public function __construct($AccountSid, $AuthToken)
    {
        $this->AccountSid = $AccountSid;
        $this->AuthToken = $AuthToken;
        $this->setUri(self::API_URI_BASE);
        $this->setResponseType('json');
    }

    /**
     * List all actions
     * @link: https://integrations.impact.com/impact-publisher/reference/list-actions-1
     */
    public function getOrders(array $options = array())
    {
        $response = $this->restGet('/Actions', $options);
        return $this->_decodeResponse($response);
    }

    /*
     * List all campaigns
     * @link: https://integrations.impact.com/impact-publisher/reference/list-campaigns
     */

    public function getAdvertisers(array $options = array())
    {
        $response = $this->restGet('/Campaigns', $options);
        return $this->_decodeResponse($response);
    }

    /*
     * Retrieve a campaign
     * @link: https://integrations.impact.com/impact-publisher/reference/retrieve-a-campaign
     */

    public function getAdvertiser($campaign_id)
    {
        $response = $this->restGet('/Campaigns/' . urlencode($campaign_id));
        return $this->_decodeResponse($response);
    }

    /*
     * Retrieve public terms
     * @link: https://integrations.impact.com/impact-publisher/reference/download-public-terms-pdf
     */

    public function getTerms($campaign_id)
    {
        $response = $this->restGet('/Campaigns/' . urlencode($campaign_id) . '/PublicTerms');
        return $this->_decodeResponse($response);
    }

    /*
     * List ads
     * @link: https://integrations.impact.com/impact-publisher/reference/list-ads
     */

    public function getCoupons($campaign_id, array $options = array())
    {
        $options['CampaignId'] = $campaign_id;
        $options['Type'] = 'COUPON';

        $response = $this->restGet('/Ads', $options);
        return $this->_decodeResponse($response);
    }

    public function restGet($path, array $query = null)
    {
        $query['IrVersion'] = self::_API_VERSION; // force API version
        $path = '/' . $this->AccountSid . $path;
        $this->setCustomHeaders(array(
            'Authorization' => 'Basic ' . base64_encode($this->AccountSid . ':' . $this->AuthToken),
            'Accept' => 'application/json'
        ));

        return parent::restGet($path, $query);
    }
}
