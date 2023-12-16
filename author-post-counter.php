<?php
/*
 * Plugin Name: Author Post Counter
 * Description: Display reports about number posts published by every Author on your Wordpress installation.
 * Version: 1.0.0
 * Requires PHP: 7.4
 * Author: felixsinggih
 * Author URI: https://github.com/felixsinggih
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */
function apc_post_count()
{
    global $wpdb;
    include('post-count.php');
}

function apc_options_page()
{
    add_menu_page(
        'Author Post Counter',
        'Author Post Counter',
        '',
        'author-post',
        'apc_post_count',
        'dashicons-clipboard',
    );
    add_submenu_page(
        'author-post',
        'Post Counter',
        'Post Counter',
        'delete_others_pages',
        'post-counter',
        'apc_post_count',
    );
}
add_action('admin_menu', 'apc_options_page');
