<?php

namespace WCIG\Models;

defined('ABSPATH') || exit;

final class Captcha {

    public function set_code() {
        return set_transient('wcig_captcha_code', uniqId(), 0);
    }

    public function get_code() {
        return get_transient('wcig_captcha_code');
    }

    public function remove_code() {
        return delete_transient('wcig_captcha_code');
    }

}