<?php
/*
Plugin Name: ITRE Add-Ons
GitHub Plugin URI: https://github.ncsu.edu/drcremin/itre-plugin
GitHub Branch:      master
GitHub Enterprise: https://github.ncsu.edu
Description: Custom widgets and functions for ITRE website use
Version: 2.0.2
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

/* Add Image Sizes */
add_action('init', function () {
    add_image_size('news-post-thumbnail', 230, 170, true);
    add_image_size('news-wide-post-thumbnail', 400, 250, true);
});
