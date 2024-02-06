<?php

namespace WCIG\Controllers;

defined('ABSPATH') || exit;

final class Language extends Controller {
    
    public function load_textdomain() {
        load_plugin_textdomain(
            'woo-checkout-image-guard', 
            false,
            dirname(plugin_basename(WCIG_FILE)) . '/languages'
        );
    }

}