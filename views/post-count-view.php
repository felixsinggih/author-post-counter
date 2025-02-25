<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Get plugin data
$plugin_data = get_plugin_data(APC_PLUGIN_FILE);
?>
<div class="wrap">
    <h1 class="wp-heading-inline"><?php echo esc_html(get_admin_page_title()); ?></h1>
    
    <div class="tablenav top">
        <div class="alignleft">
            <form method="get" class="apc-form">
                <!-- Hidden field to maintain current page in admin -->
                <input type="hidden" name="page" value="author-post" />
                
                <div class="apc-form-item">
                    <label>From <input type="text" name="start_date" class="form-control start_date" value="<?php echo esc_attr($start_date); ?>" /></label>
                </div>
                <div class="apc-form-item">
                    <label>To <input type="text" name="end_date" class="form-control end_date" value="<?php echo esc_attr($end_date); ?>" /></label>
                </div>
                <input type="submit" value="Apply" class="button">
            </form>
        </div>
    </div>
    
    <?php if(empty($data)){ ?>
        <div class="notice notice-warning is-dismissible">
            <p>No data available for the selected date range.</p>
        </div>

        <p>No data available for the selected date range.</p>
    <?php }else{ ?>
        <table class="wp-list-table widefat fixed striped table-view-list" style="margin-top: 12px;">
            <thead>
                <tr>
                    <th>Author</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($data as $row) : ?>
                <tr>
                    <td><?php echo esc_html($row['display_name']); ?></td>
                    <td><?php echo esc_html(number_format_i18n($row['amount'])); ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <th>Total</th>
                    <th><?php echo esc_html(number_format_i18n($total)); ?></th>
                </tr>
            </tfoot>
        </table>
    <?php } ?>

    <div class="apc-plugin-info">
        <p>
            <?php echo esc_html($plugin_data['Version']); ?> |
            By <a href="<?php echo esc_url($plugin_data['AuthorURI']); ?>" target="_blank">Felix Singgih</a>
        </p>
    </div>

</div>