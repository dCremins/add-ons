<?php
/*
Plugin Name: ITRE Add-Ons
Plugin URI: http://itre.ncsu.edu
Description: Custom widgets and functions for ITRE website use
Version: 1.0
Author: Devin Cremins
Author URI: http://octopusoddments.com
*/

require_once( dirname( __FILE__ ) . '/widgets/searchWidget.php' );
require_once( dirname( __FILE__ ) . '/widgets/newsWidget.php' );
require_once( dirname( __FILE__ ) . '/functions.php' );

/* Add Style.css */
add_action('wp_enqueue_scripts', function(){
	wp_enqueue_style( 'myCSS', plugins_url( '/style.css', __FILE__ ) );
});
/*
function assignPageTitle(){
  return "Title goes here";
}
add_filter('wp_title', 'assignPageTitle');
*/
/* Add Admin.css */
add_action('admin_enqueue_scripts', function () {
	wp_enqueue_style( 'adminCSS', plugins_url( '/admin.css', __FILE__ ) );
});

/* Add Image Sizes */
add_action( 'init', function() {
  add_image_size( 'news-post-thumbnail', 230, 170, true );
	add_image_size( 'news-wide-post-thumbnail', 400, 250, true );
});
?>
