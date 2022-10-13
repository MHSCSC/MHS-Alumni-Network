<?php

/**
 * Fired during plugin activation
 *
 * @link       https://github.com/ShawnLi14
 * @since      1.0.0
 *
 * @package    Mhsan
 * @subpackage Mhsan/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Mhsan
 * @subpackage Mhsan/includes
 * @author     Shawn Li <shmorganl14@gmail.com>
 */
class Mhsan_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */

	public static function activate() {
		Mhsan_Activator::init_db_myplugin();
	}

	// Initialize DB Tables
	public static function init_db_myplugin() {

		// WP Globals
		global $table_prefix, $wpdb;

		// User Info Table
		$studentTable = $table_prefix . 'studentInfo';

		// Alumni Info Table
		$alumniTable = $table_prefix . 'alumniInfo';

		// Post Info Table
		$postTable = $table_prefix . 'postInfo';

		// Create Student Table if not exist
		if( $wpdb->get_var( "show tables like '$studentTable'" ) != $studentTable ) {

			// Query - Create Table
			$sql = "CREATE TABLE `$studentTable` (";
			$sql .= " `id` int(11) NOT NULL PRIMARY KEY auto_increment, ";
			$sql .= " `wp_id` int(11), ";
			$sql .= " `displayName` varchar(20) NOT NULL, ";
			$sql .= " `graduationYear` varchar(4) NOT NULL, ";
			$sql .= " `areaOfExpertise` varchar(50) NOT NULL, ";
			$sql .= " `schoolEmail` varchar(50) NOT NULL, ";
			$sql .= " `preferredEmail` varchar(100) NOT NULL,";
			$sql .= " `status` varchar(20) NOT NULL";
			$sql .= ") ENGINE=InnoDB";

			// Include Upgrade Script
			require_once( ABSPATH . '/wp-admin/includes/upgrade.php' );
		
			// Create Table
			dbDelta( $sql );
		}

		// Create ALumni Table if not exist
		if( $wpdb->get_var( "show tables like '$alumniTable'" ) != $alumniTable ) {

			// Query - Create Table
			$sql = "CREATE TABLE `$alumniTable` (";
			$sql .= " `id` int(11) NOT NULL PRIMARY KEY auto_increment, ";
			$sql .= " `wp_id` int(11), ";
			$sql .= " `displayName` varchar(20) NOT NULL, ";
			$sql .= " `graduationYear` varchar(4) NOT NULL, ";
			$sql .= " `areaOfExpertise` varchar(50) NOT NULL, ";
			$sql .= " `college` varchar(100), ";
			$sql .= " `job` varchar(100), ";
			$sql .= " `email` varchar(100) NOT NULL,";
			$sql .= " `status` varchar(20) NOT NULL";
			$sql .= " ) ENGINE=InnoDB";

			// Include Upgrade Script
			require_once( ABSPATH . '/wp-admin/includes/upgrade.php' );
		
			// Create Table
			dbDelta( $sql );
		}

		// Create Post Table if not exist
		if( $wpdb->get_var( "show tables like '$postTable'" ) != $postTable ) {

			// Query - Create Table
			$sql = "CREATE TABLE `$postTable` (";
			$sql .= " `id` int(11) NOT NULL PRIMARY KEY auto_increment, ";
			$sql .= " `wp_id` int(11), ";
			$sql .= " `author` varchar(20) NOT NULL, ";
			$sql .= " `postName` varchar(50) NOT NULL, ";
			$sql .= " `category` varchar(30) NOT NULL, ";
			$sql .= " `status` varchar(20) NOT NULL, ";
			$sql .= " `content` varchar(20000) NOT NULL,";
			$sql .= " `upvotes` int(10000) NOT NULL,";
			$sql .= " `downvotes` varchar(10000) NOT NULL";
			$sql .= ") ENGINE=InnoDB";

			// Include Upgrade Script
			require_once( ABSPATH . '/wp-admin/includes/upgrade.php' );
		
			// Create Table
			dbDelta( $sql );
		}
	}
}


