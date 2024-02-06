<?php

namespace WCIG\Models;

defined('ABSPATH') || exit;

final class PluginManager {

    public function disable_plugin($plugin) {
        require_once ABSPATH . 'wp-admin/includes/plugin.php';
        deactivate_plugins($plugin);
    }

}