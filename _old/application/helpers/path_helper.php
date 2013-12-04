<?php
if (!function_exists('assets_url')) {
  function assets_url($path = '') {
    $CI = & get_instance();
    return base_url() . $CI->config->item('assets_path') . $path;
  }
}




?>
