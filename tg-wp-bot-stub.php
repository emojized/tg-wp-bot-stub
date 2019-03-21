<?php
/*
Plugin Name: TG WP Bot Stub
Plugin URI: https://www.wp-plugin-dev.com
Description: This is the foundation of Telegram bot running inside WordPress
Author: @wpplugindevcom
Version: 0.1
Author URI: https://www.wp-plugin-dev.com
License: GPL2

Copyright (c) 2019 wp-plugin-dev.com

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

 */
 
 // The Admin Page for Bot token, Webhook and Users
include "tg-wp-admin-page.php";
include "tg-wp-send-procedures.php";

// all the actions we need to do on activation of the plugin
register_activation_hook( __FILE__, 'tg_wp_activate' );
function tg_wp_activate()
{
    // we generate the Webhook Route  so that the reader of the code cannot guess what it is.
    // we use the add_option because it does nothing if already access
    add_option("tg_wp_weebhook_route", substr(md5(crc32 ( date("U") )), 0, 10));
}

 ?>