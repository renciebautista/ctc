<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// application/helpers/path_helper.php

if (!function_exists('debug'))
{
    function debug($array)
    {
		echo '<pre>';
		print_r($array);
		echo '</pre>';
    }
}
