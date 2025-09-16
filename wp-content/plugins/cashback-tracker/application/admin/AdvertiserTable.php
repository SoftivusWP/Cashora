<?php

namespace CashbackTracker\application\admin;

defined('\ABSPATH') || exit;

use CashbackTracker\application\components\AdvertiserManager;
use CashbackTracker\application\components\Commission;
use CashbackTracker\application\components\AdvertiserPageManager;
use CashbackTracker\application\models\CouponModel;
use CashbackTracker\application\components\CouponManager;
use CashbackTracker\application\helpers\TemplateHelper;

/**
 * AdvertiserTable class file
 *
 * @author keywordrush.com <support@keywordrush.com>
 * @link https://www.keywordrush.com
 * @copyright Copyright &copy; 2025 keywordrush.com
 */
class AdvertiserTable extends MyListTable
{

    const per_page = 100;

    function get_columns()
    {
        return
            array(
                //'logo_url' => __('Logo', 'cashback-tracker'),
                'module_id' => __('Module ID', 'cashback-tracker'),
                'id' => __('Adv. ID', 'cashback-tracker'),
                'name' => __('Name', 'cashback-tracker'),
                'domain' => __('Domain', 'cashback-tracker'),
                'cashback' => __('Cashback', 'cashback-tracker'),
                'comission' => __('Commission', 'cashback-tracker'),
                'currency_code' => __('Currency', 'cashback-tracker'),
                'validation_days' => __('Validation days', 'cashback-tracker'),
                'coupons' => __('Coupons', 'cashback-tracker'),
            );
    }

    function prepare_items()
    {
        $columns = $this->get_columns();
        $where = $this->getWhereFilters();

        $hidden = array();
        $sortable = $this->get_sortable_columns();
        $this->_column_headers = array($columns, $hidden, $sortable);
        $this->process_bulk_action();

        $paged = isset($_REQUEST['paged']) ? max(0, intval($_REQUEST['paged']) - 1) : 0;
        $orderby = (isset($_REQUEST['orderby']) && in_array($_REQUEST['orderby'], array_keys($this->get_sortable_columns()))) ? $_REQUEST['orderby'] : $this->default_orderby();
        $order = (isset($_REQUEST['order']) && in_array($_REQUEST['order'], array('asc', 'desc'))) ? $_REQUEST['order'] : 'desc';

        $limit = static::per_page;
        $offset = $paged * static::per_page;

        $all_advertisers = AdvertiserManager::getInstance()->getAllAdvertisers(true);
        $this->items = array_slice($all_advertisers, $offset, $limit);
        $total_items = count($all_advertisers);

        $this->set_pagination_args(
            array(
                'total_items' => $total_items,
                'per_page' => static::per_page,
                'total_pages' => ceil($total_items / static::per_page)
            )
        );
    }

    function column_name($item)
    {

        $page_id = AdvertiserPageManager::getInstance()->getPageId($item['module_id'], $item['id']);

        $title = $item['name'];

        if ($page_id)
        {
            $edit_link = \get_edit_post_link($page_id);
            $actions = array(
                'post_id' => sprintf(__('Page ID: %d', 'cashback-tracker'), $page_id),
                'edit' => sprintf('<a href="%s">%s</a>', \esc_url($edit_link), __('Edit', 'cashback-tracker')),
                'view' => sprintf('<a href="%s">%s</a>', \esc_url(\get_post_permalink($page_id)), __('View', 'cashback-tracker')),
            );
            return '<strong><a class="row-title" href="' . \esc_url($edit_link) . '">' . \esc_html($title) . '</a></strong>' .
                $this->row_actions($actions);
        }
        else
        {
            $create_link = \get_admin_url(\get_current_blog_id(), 'admin.php?page=cashback-tracker-tools&action=create-advertiser-page&module_id=' . urlencode($item['module_id']) . '&advertiser_id=' . urlencode($item['id']));
            $actions = array(
                'create' => sprintf('<a href="%s">%s</a>', $create_link, __('Create page', 'cashback-tracker')),
            );
            return '<strong>' . \esc_html($title) . '</strong>' .
                $this->row_actions($actions);
        }
    }

    function column_logo_url($item)
    {
        return '<img height="35" src="' . \esc_attr($item['logo_url']) . '" />';
    }

    function column_domain($item)
    {
        return '<ins>' . \esc_html($item['domain']) . '</ins>';
    }

    function column_module_id($item)
    {
        return '<strong>' . \esc_html($item['module_id']) . '</strong>';
    }

    function column_validation_days($item)
    {
        if (!$item['validation_days'])
            return '-';
        else
            return $item['validation_days'];
    }

    function column_advertiser_id($item)
    {
        $res = '#' . $item['advertiser_id'] . ':';
        $res .= ' ' . '<ins>' . \esc_html($item['advertiser_domain']) . '</ins>';
        return $res;
    }

    function column_cashback($item)
    {
        return '<ins>' . Commission::displayAdvertiserCashback($item['id'], $item['module_id']) . '<ins>';
    }

    function column_comission($item)
    {
        return Commission::displayAdvertiserComission($item['id'], $item['module_id']);
    }

    function get_sortable_columns()
    {
        return array();
    }

    function get_bulk_actions()
    {
        return array();
    }

    protected function extra_tablenav($which)
    {
        if ($which != 'top')
            return;

        echo '<div class="alignleft actions">';
        echo '</div>';
    }

    function column_coupons($item)
    {
        if (CouponConfig::getInstance()->option('import_coupons') != 'enabled')
            return '-';

        $page_id = AdvertiserPageManager::getInstance()->getPageId($item['module_id'], $item['id']);

        if (!$page_id)
            return '-';

        $last_update = CouponManager::getInstance()->getUpdateDate($page_id);

        if (!$last_update || $last_update <= 1)
            return '-';

        $show_date_time = TemplateHelper::dateFormatFromGmt($last_update, true);

        if ($last_update > strtotime('-1 day', \current_time('timestamp', true)))
            $show_date = sprintf(__('%s ago', '%s = human-readable time difference', 'cashback-tracker'), \human_time_diff($last_update, \current_time('timestamp', true)));
        else
            $show_date = TemplateHelper::dateFormatFromGmt($last_update, false);

        $count = CouponModel::model()->count(array('module_id = %s AND advertiser_id = %d', array($item['module_id'], $item['id'])));

        return sprintf('<a href="%s" title="Updated: %s">%d</a>', \esc_url(\get_post_permalink($page_id)), esc_attr($show_date), $count);
    }
}
