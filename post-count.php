<?php
$year_input = sanitize_text_field($_POST['select-year']);
$month_input = sanitize_text_field($_POST['select-month']);
$year = ($year_input == '') ? date("Y") : $year_input;
$month = ($month_input == '') ? date("m") : $month_input;
$prefix = $wpdb->prefix;

$data = $wpdb->get_results("SELECT " . $prefix . "users.id, " . $prefix . "users.display_name, 
" . $prefix . "posts.post_author, COUNT(" . $prefix . "posts.post_author) AS qty 
    FROM " . $prefix . "users, " . $prefix . "posts 
    WHERE " . $prefix . "users.ID = " . $prefix . "posts.post_author 
    AND " . $prefix . "posts.post_status='publish' 
    AND " . $prefix . "posts.post_type='post'
    AND YEAR(" . $prefix . "posts.post_date)='" . $year . "' 
    AND MONTH(" . $prefix . "posts.post_date)='" . $month . "' 
    GROUP BY " . $prefix . "posts.post_author");
?>
<div id="wpbody" role="main">
    <div id="wpbody-content">
        <div class="wrap">
            <h1 class="wp-heading-inline"><?= esc_html(get_admin_page_title()) ?></h1>

            <div class="tablenav top">
                <div class="alignleft">
                    <form action="" method="post">
                        <select class="components-select-control__input css-1t91ps2 e1mv6sxx2" name="select-month" id="select-month">
                            <option value="<?= date("m", mktime(0, 0, 0, $month)) ?>"><?= date("F", mktime(0, 0, 0, $month)) ?></option>
                            <option value="<?= date("m", mktime(0, 0, 0, 1)) ?>"><?= date("F", mktime(0, 0, 0, 1)) ?></option>
                            <option value="<?= date("m", mktime(0, 0, 0, 2)) ?>"><?= date("F", mktime(0, 0, 0, 2)) ?></option>
                            <option value="<?= date("m", mktime(0, 0, 0, 3)) ?>"><?= date("F", mktime(0, 0, 0, 3)) ?></option>
                            <option value="<?= date("m", mktime(0, 0, 0, 4)) ?>"><?= date("F", mktime(0, 0, 0, 4)) ?></option>
                            <option value="<?= date("m", mktime(0, 0, 0, 5)) ?>"><?= date("F", mktime(0, 0, 0, 5)) ?></option>
                            <option value="<?= date("m", mktime(0, 0, 0, 6)) ?>"><?= date("F", mktime(0, 0, 0, 6)) ?></option>
                            <option value="<?= date("m", mktime(0, 0, 0, 7)) ?>"><?= date("F", mktime(0, 0, 0, 7)) ?></option>
                            <option value="<?= date("m", mktime(0, 0, 0, 8)) ?>"><?= date("F", mktime(0, 0, 0, 8)) ?></option>
                            <option value="<?= date("m", mktime(0, 0, 0, 9)) ?>"><?= date("F", mktime(0, 0, 0, 9)) ?></option>
                            <option value="<?= date("m", mktime(0, 0, 0, 10)) ?>"><?= date("F", mktime(0, 0, 0, 10)) ?></option>
                            <option value="<?= date("m", mktime(0, 0, 0, 11)) ?>"><?= date("F", mktime(0, 0, 0, 11)) ?></option>
                            <option value="<?= date("m", mktime(0, 0, 0, 12)) ?>"><?= date("F", mktime(0, 0, 0, 12)) ?></option>
                        </select>

                        <select class="components-select-control__input css-1t91ps2 e1mv6sxx2" name="select-year" id="select-year">
                            <option value="<?= $year ?>"><?= $year ?></option>
                            <?php for ($year = 2016; $year <= date("Y"); $year++) { ?>
                                <option value="<?= $year ?>"><?= $year ?></option>
                            <?php } ?>
                        </select>
                        <input type="submit" value="Apply" class="button action">
                    </form>
                </div>
            </div>

            <table class="wp-list-table widefat fixed striped table-view-list">
                <thead>
                    <tr>
                        <th>Author</th>
                        <th>Quantity</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data as $data) { ?>
                        <tr>
                            <td><?= $data->display_name ?></td>
                            <td><?= $data->qty ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>