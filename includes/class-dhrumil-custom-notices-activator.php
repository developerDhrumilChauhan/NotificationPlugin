<?php

/**
 * @since      1.0.0
 * @package    Dhrumil_Custom_Notices
 * @subpackage Dhrumil_Custom_Notices/includes
 * @author     Dhrumil Chauhan <dhrumilchauhan708@gmail.com>
 */

class Dhrumil_Custom_Notices_Activator {

	public static function activate() {
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        global $wpdb;
        $tablename = "dcn_notices"; 
        $main_sql_create = "CREATE TABLE ". $wpdb->prefix . $tablename ." ( ID int NOT NULL AUTO_INCREMENT, user_id int NOT NULL, notices varchar(255), seen tinyint(1), PRIMARY KEY (ID))";    
        maybe_create_table( $wpdb->prefix . $tablename, $main_sql_create );
	}
}
