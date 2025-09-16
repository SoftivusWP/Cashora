<?php

namespace CashbackTracker\application\components;

defined('\ABSPATH') || exit;

use CashbackTracker\application\Plugin;

/**
 * Metabox class file
 *
 * @author keywordrush.com <support@keywordrush.com>
 * @link https://www.keywordrush.com
 * @copyright Copyright &copy; 2025 keywordrush.com
 */
abstract class Metabox
{

    protected $save = array();
    protected $post_id;

    abstract public function fields();

    abstract public function addMetabox();

    public function __construct()
    {
    }

    public function getFieldNames()
    {
        return array_keys($this->fields());
    }

    public function adminInit()
    {
        if (!\is_admin())
            return;
        \add_action('load-post.php', array($this, 'initMetabox'));
        \add_action('load-post-new.php', array($this, 'initMetabox'));
    }

    public function initMetabox()
    {
        \add_action('add_meta_boxes', array($this, 'addMetabox'));
        \add_action('save_post', array($this, 'saveMetabox'), 10, 2);
    }

    public function renderMetabox($post)
    {
        $this->post_id = $post->ID;
        \wp_nonce_field(Plugin::slug() . '_nonce_action', 'metabox_nonce');

        $fields = $this->fields();
        echo '<table class="form-table">';
        foreach ($fields as $field_id => $field)
        {
            echo '<tr><th>';
            if (isset($field['title']))
                echo '<label for="' . \esc_attr($field_id) . '" class="' . \esc_attr($field_id) . '_label">' . \esc_html($field['title']) . '</label>';
            echo '</th><td>';
            if (\metadata_exists('post', $post->ID, $field_id))
                $value = \get_post_meta($post->ID, $field_id, true);
            elseif (isset($field['default']))
                $value = $field['default'];
            else
                $value = '';

            $args = $field;
            $args['id'] = $field_id;
            $args['value'] = $value;
            if (!empty($field['callback']))
                call_user_func($field['callback'], $args);

            echo '</td></tr>';
        }
        echo '</table>';
    }

    public function saveMetabox($post_id, $post)
    {
        $this->post_id = $post_id;

        if (isset($_POST['metabox_nonce']))
            $nonce_name = $_POST['metabox_nonce'];
        else
            return;
        $nonce_action = Plugin::slug() . '_nonce_action';

        if (empty($nonce_name) || !\wp_verify_nonce($nonce_name, $nonce_action))
            return;

        if (!\current_user_can('edit_post', $post_id))
            return;

        if (\wp_is_post_autosave($post_id) || \wp_is_post_revision($post_id))
            return;

        $fields = $this->fields();

        $this->submited_values = array();
        foreach ($fields as $field_id => $field)
        {
            $value = isset($_POST[$field_id]) ? $_POST[$field_id] : '';
            if (isset($field['filters']))
            {
                foreach ($field['filters'] as $filter)
                {
                    if ($filter == 'allow_empty')
                    {
                        if ($value == '')
                            break;
                        continue;
                    }
                    if ($filter == 'allow_pattern')
                    {
                        if (preg_match('/^\%\w+\%$/', $value))
                            break;
                        continue;
                    }

                    $value = call_user_func($filter, $value);
                }
            }
            else
                $value = \sanitize_text_field(trim($value));

            $this->save[$field_id] = $value;
        }

        foreach ($this->save as $field_id => $value)
        {
            \update_post_meta($post_id, $field_id, $value);
        }
    }

    public function render_input($args)
    {
        if (isset($args['placeholder']))
            $placeholder = $args['placeholder'];
        else
            $placeholder = '';
        if (!empty($args['readonly_if_set']) && $args['value'])
            $readonly = ' readonly';
        else
            $readonly = '';

        echo '<input type="text" placeholder="' . \esc_attr($placeholder) . '" id="' . \esc_attr($args['id']) . '" name="' . \esc_attr($args['id']) . '" class="' . \esc_attr($args['id']) . '_field" placeholder="" value="' . \esc_attr($args['value']) . '"' . $readonly . ' size="70">';
        if (!empty($args['description']))
            echo '<br /><span class="description">' . $args['description'] . '</span>';
    }

    public function render_dropdown($args)
    {
        if (!empty($args['readonly_if_set']) && $args['value'])
            $readonly = ' disabled';
        else
            $readonly = '';
        echo '<select name="' . \esc_attr($args['id']) . '" id="' . \esc_attr($args['id']) . '">';
        foreach ($args['dropdown_options'] as $option_value => $option_name)
        {
            if ($option_value === $args['value'])
                $selected = ' selected="selected" ';
            else
                $selected = '';
            echo '<option value="' . \esc_attr($option_value) . '"' . $selected . $readonly . '>' . \esc_html($option_name) . '</option>';
        }
        echo '</select>';
        if (!empty($args['description']))
            echo '<br /><span class="description">' . $args['description'] . '</span>';
    }

    public function render_textarea($args)
    {
        echo '<textarea rows="4" id="' . \esc_attr($args['id']) . '" name="' . \esc_attr($args['id']) . '" class="' . \esc_attr($args['id']) . '_field large-text code">' . \esc_textarea($args['value']) . '</textarea>';
        if (!empty($args['description']))
            echo '<br /><span class="description">' . $args['description'] . '</span>';
    }

    public function render_separator($args)
    {
        echo '<hr />';
    }
}
