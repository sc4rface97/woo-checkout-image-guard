<?php

namespace WCIG\Controllers;

use WCIG\Models;
use WCIG\Utils;

defined('ABSPATH') || exit;

final class Checkout extends Controller {

    public function display_captcha() {
        $model = new Models\Captcha();
        $model->set_code();
        
        $this->view
            ->set_template('captcha')
            ->set_args([
                'image_b64' => Utils\ImageGenerator::string_to_image_b64($model->get_code())
            ])
            ->render()
        ;
    }

    public function verify_captcha() {
        $model = new Models\Captcha();
        $captcha_code = $model->get_code();

        if($captcha_code && !empty($_POST['wcig_captcha_code']) && $_POST['wcig_captcha_code'] === $captcha_code) {
            return;
        }

        wc_add_notice(__('Please enter correct captcha code.', 'woo-checkout-image-guard'), 'error');
    }

}