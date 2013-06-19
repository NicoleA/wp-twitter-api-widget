
<?php
/*
	Plugin Name: Twitter API Widget for WordPress
	Plugin URI: http://www.alleyinteractive.com/
	Description: A plugin to provide a widget for the Twitter API plugin.
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

define('TAPI_WIDGET_PLUGIN_URL', plugin_dir_url( __FILE__ ));

# Widget functions
require_once( 'widget.php' );

