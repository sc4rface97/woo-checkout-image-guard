<?php

namespace WCIG;

defined('ABSPATH') || exit;

final class View {
    
    /**
     * Templates directory base path.
     * 
     * @var string
     */
    protected $base_path;

    /**
     * Template name
     * 
     * @var string
     */
    protected $template;

    /**
     * Template args
     * 
     * @var array
     */
    protected $args = [];

    public function __construct() {
        $this->base_path = __DIR__ . '/templates';
    }

    public function set_template($template) {
        $this->template = sprintf('%s/%s.php', $this->base_path, $template);
        return $this;
    }

    public function get_template() {
        return $this->template;
    }

    public function set_args($args) {
        $this->args = $args;
        return $this;
    }

    public function get_args() {
        return $this->args;
    }

    public function render() {
        if(!file_exists($this->get_template())) {
            esc_html_e(sprintf('%s doesn\'t exists.', $this->get_template()), 'woo-checkout-image-guard');
            return;
        }

        require_once $this->get_template();
    }

}