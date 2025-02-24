<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}
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
                <td><?php echo esc_html($row->display_name); ?></td>
                <td><?php echo esc_html($row->amount); ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <th>Total</th>
                <th><?php echo esc_html($total); ?></th>
            </tr>
        </tfoot>
    </table>
</div>