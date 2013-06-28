<?php

// Ensure DIO extendsion installed
if ( ! function_exists('dio_read') || ! function_exists('dio_write')) {
	die('ERROR : Need DIO extension to be installed'."\n");
}

define('DATA_PATH',realpath(__DIR__.'/../../../'));
require_once realpath(__DIR__.'/../../../vendor/autoload.php');