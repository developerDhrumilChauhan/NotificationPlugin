<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://www.dhrumilcustomnotices.com
 * @since      1.0.0
 *
 * @package    Dhrumil_Custom_Notices_History
 * @subpackage Dhrumil_Custom_Notices/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<?php
global $wpdb;
$table = 'dcn_notices';

function clean($string)
{
    $string = str_replace('\s', '', $string); // Replaces all spaces with hyphens.
    return preg_replace('/[^0-9\-]/', '', $string); // Removes special chars.
}

$searchForValue = ',';
$stringValue = $_GET["user_id"];
$page = isset($_GET['dcn_page']) ? $_GET['dcn_page'] : false;
$user_id = isset($_GET['user_id']) ? $_GET['user_id'] : false;

// DELETE Notice
if ( isset($_GET['noice_delete']) && $_GET['noice_delete'] ) {
    $notice_table_id = $_GET['noice_delete'];

    $table_with_prefix = $wpdb->prefix . $table;
    $delete_notice_history = $wpdb->delete( $table_with_prefix, array( 'ID' => $notice_table_id ) );

    if ( $delete_notice_history ) {
        echo '<div id="message" class="updated notice is-dismissible">
            <p>Notice delete successfully.</p>
        </div>'; 
    }
}

if ($page) {
    if ($page == 'notice-history') {

        $sql_query = "SELECT * FROM " . $wpdb->prefix . $table;

        // search by multiple users
        if (strpos($stringValue, $searchForValue) !== false) {
            $stringValue = rtrim($stringValue, ',');
            $sql_query .= " WHERE user_id IN ($stringValue)";
        } else if ($user_id) {
            $sql_query .= " WHERE user_id = $user_id";
        }

        $sql_query .= " ORDER BY ID DESC;";
        
        $get_notice_histories = $wpdb->get_results($sql_query);

        ?>
        <div class="dhrunotcus-main-wrapper">
            <div class="dhrunotcus-instructions-wrap" style="display: flex;align-items: center;justify-content: space-between;">
                <h1 style="margin:0;padding:20px 0;">
                    Notice Histories
                </h1>
                <div class="back">
                    <a href="admin.php?page=dhrumil-custom-notices" class="dhrunotcus-form-btn dhrunotcus-form-back-btn">Go Back</a>
                </div>
            </div>

            <table id="dhrunotcus-users-table">
                <thead class="dhrunotcus-users-table-header">
                    <tr class="dhrunotcus-users-table-row">
                        <th width="100px">Sr. No.</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>notices</th>
                        <th width="200px">Action</th>
                    </tr>
                </thead>
                <tbody class="dhrunotcus-users-table-body">
                    <?php
                    $i = 1;
                    foreach ($get_notice_histories as $history) {
                        $user_info = get_userdata($history->user_id);
                    ?>
                    <tr class="dhrunotcus-users-table-row">
                        <td><?php echo $i; ?></td>
                        <td><?php echo $user_info->user_nicename; ?></td>
                        <td><?php echo $user_info->user_email; ?></td>
                        <td><?php echo $history->notices; ?></td>
                        <td>
                        <a href='admin.php?page=dhrumil-custom-notices&dcn_page=notice-history&user_id=<?php echo $user->ID; ?>&noice_delete=<?php echo $history->ID; ?>'>Delete</a>
                        </td>
                    </tr>
                    <?php $i++; } ?>
                </tbody>
            </table>
    <?php
    }
}
