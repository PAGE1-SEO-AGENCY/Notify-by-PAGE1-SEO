<?php
/*
Plugin Name: Notify by PAGE1 SEO
Description: Provides customizable popup notifications for your WordPress site, allowing you to display social proof and other messages to users based on configurable settings.
Version: 1.0
Author: PAGE1 SEO Agency
Author URI: https://page1.vn
Plugin URI: https://page1.vn/plugin/WP-Notify-by-PAGE1-SEO
Text Domain: Notify-by-PAGE1-SEO
Requires at least: 5.0
Tested up to: 6.5
Requires PHP: 5.6

  Copyright 2024  PAGE1 SEO Agency  (email: top@page1.vn)

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License, version 2, as
  published by the Free Software Foundation.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

// Enqueue styles and scripts
function page1_notify_enqueue_scripts() {
    wp_enqueue_style('page1-notify-style', plugins_url('/style.css', __FILE__));
    wp_enqueue_script('page1-notify-script', plugins_url('/notification-script.js', __FILE__), array('jquery'), null, true);

    // Pass plugin options to JavaScript
    $options = get_option('page1_notify_options');
    wp_localize_script('page1-notify-script', 'page1NotifyOptions', $options);
}
add_action('wp_enqueue_scripts', 'page1_notify_enqueue_scripts');

// Admin settings menu
include(plugin_dir_path(__FILE__) . 'admin-settings.php');
