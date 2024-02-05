<?php

namespace WCIG\Controllers;

defined('ABSPATH') || exit;

class Checkout extends Controller {

    public function before_submit() {
        echo 'siema siema';
    }

}