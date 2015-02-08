<?php
/**
* Plugin Name: Google Locker for Wordpress
* Plugin URI: http://wptp.net/#product
* Description: Google Locker is a plugin help you to get more Share/Subscriber, traffic and customers.
* Version: 1.0
* Author: WPTP Net
* Author URI: http://wptp.net
*/

if ( defined( 'G_LOCKER_PLUGIN_ACTIVE' ) ) return;
define( 'G_LOCKER_PLUGIN_ACTIVE', true );

define( 'G_LOCKER_PLUGIN_DIR', dirname( __FILE__ ) );
define( 'G_LOCKER_PLUGIN_URL', plugins_url( null, __FILE__ ) );

require( G_LOCKER_PLUGIN_DIR . '/admin/init.php' );
?>