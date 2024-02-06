<?php

namespace WCIG;

use WCIG\Controllers;

defined('ABSPATH') || exit;

final class Core {

    /**
     * The single class instance.
     * 
     * @var Core
     */
    protected static $instance;

    /**
     * WCIG controllers.
     * 
     * @var array
     */
    protected $controllers = [];

    protected function __construct() {
        spl_autoload_register([$this, 'autoload']);
        $this->setup();
    }

    public static function instance() {
        if(is_null(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }
    
    public function autoload($class) {
        $class = str_replace('WCIG\\', '', $class);
        $path = str_replace('\\', '/', $class) . '.php';
        
        $file = __DIR__ . '/' . $path;
        if(!file_exists($file)) {
            return;
        }

        require_once $file;
    }

    protected function setup_controllers() {
        $this->controllers = [
            'activation' => new Controllers\Activation(),
            'deactivation' => new Controllers\Deactivation(),
            'dependency-check' => new Controllers\DependencyCheck(),
            'language' => new Controllers\Language(),
            'checkout' => new Controllers\Checkout()
        ];

        return $this;
    }

    protected function setup_activation_hook() {
        register_activation_hook(WCIG_FILE, [
            $this->controllers['activation'], 
            'activate'
        ]);

        return $this;
    }

    protected function setup_deactivation_hook() {
        register_activation_hook(WCIG_FILE, [
            $this->controllers['deactivation'], 
            'deactivate'
        ]);

        return $this;
    }

    protected function setup_actions() {
        add_action('plugins_loaded', [
            $this->controllers['language'],
            'load_textdomain'
        ]);

        add_action('plugins_loaded', [
            $this->controllers['dependency-check'],
            'check_dependencies'
        ]);

        add_action('init', [
            $this->controllers['dependency-check'],
            'toggle_plugin_status'
        ]);

        add_action('admin_notices', [
            $this->controllers['dependency-check'],
            'print_dependencies_errors'
        ]);

        add_action('woocommerce_review_order_before_submit', [
            $this->controllers['checkout'],
            'display_captcha'
        ]);

        add_action('woocommerce_checkout_process', [
            $this->controllers['checkout'],
            'verify_captcha'
        ], 10, 2);

        return $this;
    }

    protected function setup_filters() {
        return $this;
    }

    protected function setup() {
        $this
            ->setup_controllers()
            ->setup_activation_hook()
            ->setup_deactivation_hook()
            ->setup_actions()
            ->setup_filters()
        ;
    }

}