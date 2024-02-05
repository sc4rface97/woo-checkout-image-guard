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
     * Dependencies errors array.
     * 
     * @var array
     */
    protected $errors = [];

    /**
     * WCIG controllers.
     * 
     * @var array
     */
    protected $controllers = [];

    protected function __construct() {
        spl_autoload_register([$this, 'autoload']);

        register_activation_hook(WCIG_FILE, [__CLASS__, 'activate']);
        register_deactivation_hook(WCIG_FILE, [__CLASS__, 'deactivate']);

        add_action('plugins_loaded', [$this, 'setup']);
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

    public static function activate() {
    }

    public static function deactivate() {
    }

    protected function check_dependencies() {
        if(!class_exists('WooCommerce')) {
            $this->errors[] = __('Woo Checkout Image Guard required installed and activated Woocommerce plugin.', 'woo-checkout-image-guard');
        }

        return empty($this->errors);
    }

    public function print_dependencies_errors() {
        return (new View())
            ->set_template('notice-error')
            ->set_args(['errors' => $this->errors])
            ->render()
        ;
    }

    protected function setup_controllers() {
        $this->controllers = [
            'checkout' => new Controllers\Checkout()
        ];

        return $this;
    }

    protected function setup_actions() {
        add_action('woocommerce_review_order_before_submit', [$this->controllers['checkout'], 'before_submit']);
        
        return $this;
    }

    protected function setup_filters() {
        return $this;
    }

    public function setup() {
        if($this->check_dependencies()) {
            $this
                ->setup_controllers()
                ->setup_actions()
                ->setup_filters()
            ;
        } else {
            require_once ABSPATH . 'wp-admin/includes/plugin.php';
            
            if(isset($_GET['activate'])) {
                unset($_GET['activate']);
            }

            deactivate_plugins(plugin_basename(WCIG_FILE));
            add_action('admin_notices', [$this, 'print_dependencies_errors']);
        }
    }

}