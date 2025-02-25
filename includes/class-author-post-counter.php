<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Main plugin class
 */
class Author_Post_Counter {
    
    // Singleton instance
    private static $instance = null;
    
    /**
     * Constructor
     */
    private function __construct() {
        // Initialize hooks
        add_action('admin_menu', array($this, 'register_admin_menu'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_assets'));
    }
    
    /**
     * Singleton pattern to get instance
     */
    public static function get_instance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    /**
     * Register admin menu pages
     */
    public function register_admin_menu() {
        add_menu_page(
            'Author Post Counter',
            'Author Post Counter',
            'delete_others_pages',
            'author-post',
            array($this, 'render_post_count_page'),
            'dashicons-clipboard'
        );
        
        add_submenu_page(
            'author-post',
            'Post Counter',
            'Post Counter',
            'delete_others_pages',
            'author-post',
            array($this, 'render_post_count_page')
        );
    }
    
    /**
     * Enqueue required scripts and styles
     */
    public function enqueue_admin_assets($hook) {
        // Only load on our plugin pages
        if (strpos($hook, 'author-post') === false) {
            return;
        }
        
        // Enqueue datepicker
        wp_enqueue_script('jquery-ui-datepicker');
        wp_enqueue_style(
            'jquery-ui-style', 
            APC_PLUGIN_URL . 'assets/jquery/jquery-ui.css', 
            array(), 
            '1.8.2'
        );
        
        // Plugin CSS
        wp_enqueue_style(
            'apc-admin-styles',
            APC_PLUGIN_URL . 'assets/css/admin.css',
            array(),
            APC_VERSION
        );
        
        // Plugin JS
        wp_enqueue_script(
            'apc-admin-scripts',
            APC_PLUGIN_URL . 'assets/js/admin.js',
            array('jquery', 'jquery-ui-datepicker'),
            APC_VERSION,
            true
        );
    }
    
    /**
     * Get post count data
     */
    private function get_post_count_data($start_date, $end_date) {
        global $wpdb;

        $next_day = gmdate('Y-m-d', strtotime($end_date . ' +1 day'));

        $query = $wpdb->prepare(
            "SELECT u.ID, u.display_name, COUNT(p.post_author) AS amount
            FROM {$wpdb->users} u
            JOIN {$wpdb->posts} p ON u.ID = p.post_author
            WHERE p.post_status = %s
            AND p.post_type = %s
            AND p.post_date >= %s
            AND p.post_date < %s
            GROUP BY p.post_author",
            'publish', 'post', $start_date, $next_day
        );
        

        return $wpdb->get_results($query);
    }

    /**
     * Render the post count page
     */
    public function render_post_count_page() {
        // Get date parameters from GET
        $start_date = isset($_GET['start_date']) ? sanitize_text_field(wp_unslash($_GET['start_date'])) : gmdate('Y-m-d');
        $end_date = isset($_GET['end_date']) ? sanitize_text_field(wp_unslash($_GET['end_date'])) : gmdate('Y-m-d');
        
        // Get data
        $data = $this->get_post_count_data($start_date, $end_date);
        $total = array_sum(array_column($data, 'amount'));
        
        // Include view file
        include(APC_PLUGIN_DIR . 'views/post-count-view.php');
    }
}