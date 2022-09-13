<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://github.com/ShawnLi14
 * @since      1.0.0
 *
 * @package    Mhsan
 * @subpackage Mhsan/admin/partials
 */
$wp_id = wp_insert_user(array(
    'user_login' => "aaaa",
    'user_pass' => "adikwahjdiuwa",
    'user_email' => "shmorganl14@gmail.com",
    'first_name' => "first name",
    'last_name' => "last name",
    'display_name' => "yeah",
    'role' => 'subscriber'
));

wp_new_user_notification( $wp_id, null, 'both' );

?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
