<?php
/**
 * Plugin Name: Woo Checkout Image Guard
 * Plugin URI: https://rootbine.com/portfolio/woo-checkout-image-guard
 * Description: Implementing image based security code on woocommerce checkout page to prevent creating orders with bots.
 * Author: Kamil Mlonek
 * Author URI: https://rootbine.com/author/kamilml
 * Version: 1.0.0
 * Text Domain: woo-checkout-image-guard
 */

defined('ABSPATH') || exit;

if(!defined('WCIG_FILE')) {
    define('WCIG_FILE', __FILE__);
}

require_once __DIR__ . '/src/Core.php';

function WCIG() {
    return WCIG\Core::instance();
}

WCIG();