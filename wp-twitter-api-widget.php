<?php
/*
	Plugin Name: Twitter API Widget for WordPress
	Plugin URI: http://www.alleyinteractive.com/
	Description: A plugin to provide a widget for the Twitter API plugin. Requires Twitter API for WordPress plugin (wp-twitter-api).
	Version: 0.1
	Author: Nicole Arnold, Alley Interactive
	Author URI: http://www.alleyinteractive.com/
*/
/*  This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

add_action( 'admin_init', 'tapi_widget_has_parent_plugin' );

if( !function_exists( 'tapi_widget_has_parent_plugin' ) && !function_exists( 'tapi_widget_missing_parent_plugin' ) ) {

    function tapi_widget_has_parent_plugin() {
        if( is_admin() && ( !class_exists( 'WP_Twitter_API' ) && current_user_can( 'activate_plugins' ) ) ) {
            add_action( 'admin_notices', 'tapi_widget_missing_parent_plugin' );

            deactivate_plugins( plugin_basename( __FILE__ ) );
            if ( isset( $_GET['activate'] ) ) {
               unset( $_GET['activate'] );
            }
        }
    }

    function tapi_widget_missing_parent_plugin() {
        $activate = admin_url( 'plugins.php#twitter-api-for-wordpress' );
        $string = '<div class="error"><p>' . sprintf( __( 'Twitter API for WordPress must be activated to use the Twitter API Widget for WordPress Plugin. <a href="%s">Visit your plugins page to activate</a>.', 'debug-bar-constants' ), $activate ) . '</p></div>';
        echo $string;
    }
}


define('TAPI_WIDGET_PLUGIN_URL', plugin_dir_url( __FILE__ ));

# Widget functions
require_once( 'widget.php' );
?>