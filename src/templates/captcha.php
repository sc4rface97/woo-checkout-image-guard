<?php
/**
 * Template for displaying WCIG captcha.
 */

defined('ABSPATH') || exit;

$args = $this->get_args(); ?>

<div class="wcig-captcha">
    
    <img src="<?php echo esc_html($args['image_b64']); ?>" class="wcig-captcha__image" /><?php 

    woocommerce_form_field('wcig_captcha_code', [
        'type' => 'text',
        'placeholder' => __('Enter captcha code...', 'woo-checkout-image-guard'),
        'required' => true,
        'class' => ['wcig-captcha__form-field'],
        'input_class' => ['wcig-captcha__input']
    ]); ?>

</div>