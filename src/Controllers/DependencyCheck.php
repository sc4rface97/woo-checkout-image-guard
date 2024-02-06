<?php

namespace WCIG\Controllers;

use WCIG\Models;

defined('ABSPATH') || exit;

final class DependencyCheck extends Controller {
    
    /**
     * Dependency check errors.
     * 
     * @var array
     */
    protected $errors = [];
    
    public function check_dependencies() {
        if(!class_exists('WooCommerce')) {
            $this->errors[] = __('Woo Checkout Image Guard required installed and activated Woocommerce plugin.', 'woo-checkout-image-guard');
        }
    }

    public function toggle_plugin_status() {
        if(empty($this->errors)) {
            return;
        }

        $model = new Models\PluginManager();
        $model->disable_plugin(plugin_basename(WCIG_FILE));

        if(isset($_GET['activate'])) {
            unset($_GET['activate']);
        }
    }

    public function print_dependencies_errors() {
        if(empty($this->errors)) {
            return;
        }
        
        $this->view
            ->set_template('notice-error')
            ->set_args(['errors' => $this->errors])
            ->render()
        ;
    }

}