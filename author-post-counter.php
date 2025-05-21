<?php
/*
 * Plugin Name: Author Post Counter
 * Description: Generate insightful reports showcasing the number of posts each author has published on your WordPress site.
 * Version: 1.0.2
 * Requires PHP: 7.4
 * Author: Felix Singgih
 * Author URI: https://github.com/felixsinggih
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('APC_PLUGIN_FILE', __FILE__);
define('APC_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('APC_PLUGIN_URL', plugin_dir_url(__FILE__));
define('APC_VERSION', '1.0.2');

// Include required files
require_once APC_PLUGIN_DIR . 'includes/class-author-post-counter.php';

// Initialize the plugin
function apc_init() {
    Author_Post_Counter::get_instance();
}
add_action('plugins_loaded', 'apc_init');

// Activation hook
register_activation_hook(__FILE__, 'apc_activate');
function apc_activate() {
    // Create necessary directories if they don't exist
    if (!file_exists(APC_PLUGIN_DIR . 'assets/css')) {
        wp_mkdir_p(APC_PLUGIN_DIR . 'assets/css');
    }
    if (!file_exists(APC_PLUGIN_DIR . 'assets/js')) {
        wp_mkdir_p(APC_PLUGIN_DIR . 'assets/js');
    }
}

// Deactivation hook
register_deactivation_hook(__FILE__, 'apc_deactivate');
function apc_deactivate() {
    // Clean up if needed
}