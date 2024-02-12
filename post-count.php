<?php
wp_enqueue_script('jquery-ui-datepicker');
wp_enqueue_style('jquery-style', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css');

$year_input = sanitize_text_field($_POST['select-year']);
$month_input = sanitize_text_field($_POST['select-month']);
$year = ($year_input == '') ? date("Y") : $year_input;
$month = ($month_input == '') ? date("m") : $month_input;
$prefix = $wpdb->prefix;

$start_date = $_POST['start_date'] ? sanitize_text_field($_POST['start_date']) : date('Y-m-d');
$end_date = $_POST['end_date'] ? sanitize_text_field($_POST['end_date']) : date('Y-m-d');

$data = $wpdb->get_results(
    "SELECT " . $prefix . "users.id, " . $prefix . "users.display_name, 
        " . $prefix . "posts.post_author, COUNT(" . $prefix . "posts.post_author) AS qty 
        FROM " . $prefix . "users, " . $prefix . "posts 
        WHERE " . $prefix . "users.ID = " . $prefix . "posts.post_author 
        AND " . $prefix . "posts.post_status='publish' 
        AND " . $prefix . "posts.post_type='post'
        AND " . $prefix . "posts.post_date >= '" . $start_date . "' 
        AND " . $prefix . "posts.post_date <= '" . date('Y-m-d', strtotime($end_date . "+1 days")) . "' 
        GROUP BY " . $prefix . "posts.post_author"
);
?>
<div id="wpbody" role="main">
    <div id="wpbody-content">
        <div class="wrap">
            <h1 class="wp-heading-inline"><?= esc_html(get_admin_page_title()) ?></h1>

            <div class="tablenav top" style="margin-bottom: 10px;">
                <div class="alignleft">
                    <form action="" method="post">

                        <span style="margin-bottom: 5px;">Dari tanggal
                            <input type="text" name="start_date" class="form-control start_date" value="<?= $start_date ?>" />
                        </span>
                        <span style="margin-bottom: 5px;"> sampai
                            <input type="text" name="end_date" class="form-control end_date" value="<?= $end_date ?>" />
                        </span>

                        <input type="submit" value="Apply" class="button action">
                    </form>
                </div>
            </div>

            <table class="wp-list-table widefat fixed striped table-view-list">
                <thead>
                    <tr>
                        <th>Author</th>
                        <th>Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $total = 0;
                    foreach ($data as $data) {
                        $total = $total + $data->qty; ?>
                        <tr>
                            <td><?= $data->display_name ?></td>
                            <td><?= $data->qty ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th>Total</th>
                        <th><?= $total ?></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<script type="text/javascript">
    jQuery(document).ready(function($) {
        $('.start_date').datepicker({
            dateFormat: 'yy-mm-dd'
        });

        $('.end_date').datepicker({
            dateFormat: 'yy-mm-dd'
        });
    });
</script>