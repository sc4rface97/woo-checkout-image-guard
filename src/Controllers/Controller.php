<?php

namespace WCIG\Controllers;

defined('ABSPATH') || exit;

abstract class Controller {

    /**
     * View object for templates management.
     * 
     * @var View
     */
    protected $view;

    public function __construct() {
        $this->view = new \WCIG\View();
    }

}