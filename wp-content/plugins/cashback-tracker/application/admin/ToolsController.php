<?php

namespace CashbackTracker\application\admin;

defined('\ABSPATH') || exit;

use CashbackTracker\application\components\OrderManager;
use CashbackTracker\application\components\AdvertiserManager;
use CashbackTracker\application\components\ModuleManager;
use CashbackTracker\application\helpers\TextHelper;
use CashbackTracker\application\components\AdvertiserPageManager;
use CashbackTracker\application\CouponScheduler;

/**
 * ToolsController class file
 *
 * @author keywordrush.com <support@keywordrush.com>
 * @link https://www.keywordrush.com
 * @copyright Copyright &copy; 2025 keywordrush.com
 */
class ToolsController
{

    const slug = 'cashback-tracker-tools';

    public function __construct()
    {
        \add_action('admin_menu', array($this, 'actionHandler'));
    }

    public function actionHandler()
    {
        if (!\current_user_can('administrator'))
            return;

        if (empty($GLOBALS['pagenow']) || $GLOBALS['pagenow'] != 'admin.php')
            return;

        if (empty($_GET['page']) || $_GET['page'] != self::slug)
            return;

        if (!empty($_GET['action']) && $_GET['action'] == 'refresh-all-advertisers')
            $this->actionRefreshAllAdvertisers();

        if (!empty($_GET['action']) && $_GET['action'] == 'create-all-pages')
            $this->actionCreateAllPages();

        if (!empty($_GET['action']) && $_GET['action'] == 'download-offers' && !empty($_GET['module_id']))
            $this->actionDownloadOffers();

        if (!empty($_GET['action']) && $_GET['action'] == 'refresh-advertisers' && !empty($_GET['module_id']))
            $this->actionRefreshAdvertisers();

        if (!empty($_GET['action']) && $_GET['action'] == 'refresh-advertisers-cron' && !empty($_GET['module_id']))
            $this->actionRefreshAdvertisersCron();

        if (!empty($_GET['action']) && $_GET['action'] == 'create-advertiser-page' && !empty($_GET['module_id']) && !empty($_GET['advertiser_id']))
            $this->actionCreateAdvertiserPage();

        die('You do not have permission to view this page.');
    }

    public function actionDownloadOffers()
    {
        $module_id = TextHelper::clear($_GET['module_id']);
        if (!ModuleManager::getInstance()->moduleExists($module_id))
            die('Module does not exist');

        OrderManager::getInstance()->downloadOrders(TextHelper::clear($module_id));
        $redirect_url = \get_admin_url(\get_current_blog_id(), 'admin.php?page=cashback-tracker-logs');
        $redirect_url = AdminNotice::add2Url($redirect_url, 'loading_orders_done', 'info');
        \wp_redirect($redirect_url);
        exit;
    }

    public function actionRefreshAllAdvertisers()
    {
        $module_ids = ModuleManager::getInstance()->getModulesIdList(true);
        foreach ($module_ids as $module_id)
        {
            AdvertiserManager::getInstance()->getAdvertisers($module_id, true);
        }

        $redirect_url = \get_admin_url(\get_current_blog_id(), 'admin.php?page=cashback-tracker-advertisers');
        $redirect_url = AdminNotice::add2Url($redirect_url, 'loading_advertisers_done', 'info');
        \wp_redirect($redirect_url);
        exit;
    }

    public function actionRefreshAdvertisers()
    {
        $module_id = TextHelper::clear($_GET['module_id']);
        if (!ModuleManager::getInstance()->moduleExists($module_id))
            die('Module does not exist');

        AdvertiserManager::getInstance()->getAdvertisers($module_id, true);

        $redirect_url = \get_admin_url(\get_current_blog_id(), 'admin.php?page=cashback-tracker--' . $module_id);
        $redirect_url = AdminNotice::add2Url($redirect_url, 'loading_advertisers_done', 'info');
        \wp_redirect($redirect_url);
        exit;
    }

    public function actionRefreshAdvertisersCron()
    {
        $module_id = TextHelper::clear($_GET['module_id']);
        if (!ModuleManager::getInstance()->moduleExists($module_id))
            die('Module does not exist');

        $hook = 'cbtrkr_refresh_advertisers';
        if (!\wp_next_scheduled($hook))
            \wp_schedule_single_event(time() + 1, $hook, array('module_id' => $module_id));

        $redirect_url = \get_admin_url(\get_current_blog_id(), 'admin.php?page=cashback-tracker--' . $module_id);
        $redirect_url = AdminNotice::add2Url($redirect_url, 'loading_advertisers_planned', 'info');
        \wp_redirect($redirect_url);
        exit;
    }

    public function actionCreateAllPages()
    {
        $advertisers = AdvertiserManager::getInstance()->getAllAdvertisers();
        foreach ($advertisers as $advertiser)
        {
            if (AdvertiserPageManager::getInstance()->isPageExists($advertiser['module_id'], $advertiser['id']))
                continue;

            AdvertiserPageManager::getInstance()->createPage($advertiser['module_id'], $advertiser['id']);
        }

        // re-init cron task
        CouponScheduler::clearScheduleEvent();
        CouponScheduler::maybeAddScheduleEvent();

        $redirect_url = \get_admin_url(\get_current_blog_id(), 'admin.php?page=cashback-tracker-advertisers');
        $redirect_url = AdminNotice::add2Url($redirect_url, 'pages_creation_complete', 'info');

        \wp_redirect($redirect_url);
        exit;
    }

    public function actionCreateAdvertiserPage()
    {
        $module_id = TextHelper::clear($_GET['module_id']);
        if (!ModuleManager::getInstance()->moduleExists($module_id))
            die('Module does not exist');

        $advertiser_id = TextHelper::clear($_GET['advertiser_id']);
        if (!AdvertiserManager::getInstance()->advertiserExists($module_id, $advertiser_id))
            die('Advertiser does not exist');

        $edit_link = \get_admin_url(\get_current_blog_id(), 'post.php?action=edit&post=%d');
        if ($page_id = AdvertiserPageManager::getInstance()->getPageId($module_id, $advertiser_id))
        {
            \wp_redirect(sprintf($edit_link, $page_id));
            exit;
        }

        if ($page_id = AdvertiserPageManager::getInstance()->createPage($module_id, $advertiser_id))
        {
            \wp_redirect(sprintf($edit_link, $page_id));
            exit;
        }
        else
        {
            $redirect_url = \get_admin_url(\get_current_blog_id(), 'admin.php?page=cashback-tracker-advertisers');
            $redirect_url = AdminNotice::add2Url($redirect_url, 'create_advertiser_page_error', 'error');
            \wp_redirect($redirect_url);
            exit;
        }
    }
}
