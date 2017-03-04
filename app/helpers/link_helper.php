<?php defined('BASEPATH') OR exit('No direct script access allowed');

if(! function_exists('site_link')) {
    function site_link($m, $v = NULL) {
        $link = 'index.php?module='.$m;
        if($v) { $link .= '&view='.$v; }
        return $link;
    }
}

if ( ! function_exists('redirect')) {
    function redirect($uri = '', $method = 'auto') {
        $link = base_url();
            if($uri != '') {
            $explode = explode('&', $uri);
            foreach ($explode as $exp) {
                list($c, $v) = explode('=', $exp);
                $link .= $v.'/';
            }
        }
        switch ($method) {
            case 'refresh':
                header('Refresh:0;url='.$link);
                break;
            default:
                header('Location: '.$link);
                break;
        }
        exit;
    }
}

if ( ! function_exists('base_url')) {
    function base_url($uri = '', $protocol = NULL) {
        return get_instance()->config->base_url($uri, $protocol);
    }
}