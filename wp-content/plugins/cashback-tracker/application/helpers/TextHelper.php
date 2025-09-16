<?php

namespace CashbackTracker\application\helpers;

defined('\ABSPATH') || exit;

/**
 * TextHelper class file
 *
 * @author keywordrush.com <support@keywordrush.com>
 * @link https://www.keywordrush.com
 * @copyright Copyright &copy; 2025 keywordrush.com
 */
class TextHelper
{

    public static function truncate($string, $length = 80, $etc = '...', $charset = 'UTF-8', $break_words = false, $middle = false)
    {
        if ($length == 0)
            return '';

        if (mb_strlen($string, 'UTF-8') > $length)
        {
            $length -= min($length, mb_strlen($etc, 'UTF-8'));
            if (!$break_words && !$middle)
            {
                $string = preg_replace('/\s+?(\S+)?$/', '', mb_substr($string, 0, $length + 1, $charset));
            }
            if (!$middle)
            {
                return mb_substr($string, 0, $length, $charset) . $etc;
            }
            else
            {
                return mb_substr($string, 0, $length / 2, $charset) . $etc . mb_substr($string, -$length / 2, $charset);
            }
        }
        else
        {
            return $string;
        }
    }

    public static function clear($str)
    {
        return preg_replace('/[^a-zA-Z0-9_]/', '', $str);
    }

    public static function clearId($str)
    {
        return preg_replace('/[^a-zA-Z0-9_\-~\.@]/', '', $str);
    }

    public static function clearUtf8($str)
    {
        $str = preg_replace("/[^\pL\s\d\-\.\+_]+/ui", '', $str);
        $str = preg_replace("/\s+/ui", ' ', $str);
        return $str;
    }

    public static function getDomainName($url)
    {
        return preg_replace('/^www\./', '', parse_url($url, PHP_URL_HOST));
    }

    public static function getHostName($url)
    {
        $url = trim($url);
        return TextHelper::getDomainWithoutSubdomain(strtolower(str_ireplace('www.', '', parse_url($url, PHP_URL_HOST))));
    }

    public static function getDomainWithoutSubdomain($domain)
    {
        if (preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,7})$/i', $domain, $regs))
        {
            return $regs['domain'];
        }
        return $domain;
    }

    public static function commaList($str, $input_delimer = ',', $return_delimer = ',')
    {
        $parts = explode($input_delimer, $str);
        $parts = array_map('trim', $parts);
        return join($return_delimer, $parts);
    }

    public static function commaListToIntArray($str, $input_delimer = ',')
    {
        if (!$str)
            return array();
        $parts = explode($input_delimer, $str);
        $res = array();
        foreach ($parts as $p)
        {
            $p = trim($p);
            if ($p !== '' && (int) $p == $p)
                $res[] = (int) $p;
        }
        return $res;
    }

    static public function unserialize_xml($input, $callback = null, $recurse = false)
    {
        libxml_use_internal_errors(false);

        $data = ((!$recurse) && is_string($input)) ? @simplexml_load_string($input, '\SimpleXMLElement', LIBXML_NOCDATA) : $input;

        if ($data instanceof \SimpleXMLElement)
            $data = (array) $data;

        if (is_array($data))
        {
            foreach ($data as &$item)
            {
                $item = self::unserialize_xml($item, $callback, true);
            }
        }

        return (!is_array($data) && is_callable($callback)) ? call_user_func($callback, $data) : $data;
    }

    public static function addUrlParam($url, $param_name, $param_value, $replace = true)
    {
        $url_parts = parse_url($url);
        if (isset($url_parts['query']))
            $query = $url_parts['query'];
        else
            $query = '';
        parse_str($query, $query_array);
        if (!isset($query_array[$param_name]) && !$replace)
            return $url;
        if (isset($query_array[$param_name]) && $query_array[$param_name] == $param_value)
            return $url;

        $query_array[$param_name] = $param_value;

        return $url_parts['scheme'] . '://' . $url_parts['host'] . $url_parts['path'] . '?' . http_build_query($query_array);
    }

    public static function getArrayFromCommaList($str)
    {
        return explode(",", TextHelper::commaList($str));
    }
}
