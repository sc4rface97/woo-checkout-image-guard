<?php
/**
 * Template for displaying Wordpress error notice.
 */

defined('ABSPATH') || exit;

$args = $this->get_args(); ?>

<div class="notice notice-error">
    <?php foreach($args['errors'] as $error) { ?>
        <p><?php esc_html_e($error); ?></p>
    <?php } ?>
</div>