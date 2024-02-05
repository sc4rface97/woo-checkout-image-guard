<?php

namespace WCIG;

defined('ABSPATH') || exit;

final class Core {

    /**
     * The single class instance.
     * 
     * @var Core
     */
    protected static $instance;

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

    public function setup() {
    }

}