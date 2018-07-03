<?php
/*
Plugin Name: ITRE Add-Ons
GitHub Plugin URI: https://github.com/dCremins/add-ons
GitHub Branch: master
Description: Custom widgets and functions for ITRE website use
Version: 2.2.4
Author: Devin Cremins
Author URI: http://octopusoddments.com
*/

require_once(dirname(__FILE__) . '/functions.php');

/* Add Style.css */
add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style('myCSS', plugins_url('/style.css', __FILE__));
});

/* Add Admin.css */
add_action('admin_enqueue_scripts', function () {
    wp_enqueue_style('adminCSS', plugins_url('/admin.css', __FILE__));
});
