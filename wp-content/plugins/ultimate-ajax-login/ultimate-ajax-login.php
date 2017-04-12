<?php
/**
 * Plugin Name: Ultimate AJAX Login
 * Plugin URI: http://thoughtengineer.com/
 * Description:  Easy, Flexible and Customizable AJAX login plugin
 * Version: 1.2.1
 * Author: Samer Bechara
 * Author URI: http://thoughtengineer.com/
 * Text Domain: ultimate-ajax-login
 * Domain Path: /languages
 * Network: false
 * License: GPL2
 */

/*  Copyright 2014  Samer Bechara  (email : sam@thoughtengineer.com)

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

// Define plugin path and URL constant - makes it easier to include files 
// Use acronyms of plugin name, e.g. Marketpress Category Copier becomes MPP_PATH
define( 'UAL_PATH', plugin_dir_path( __FILE__ ) );
define( 'UAL_URL', plugin_dir_url(__FILE__));


// Require Widget class if any, change to match plugin class
require_once (UAL_PATH.'/lib/class-ual-widget.php'); 

// Require main class
require_once (UAL_PATH.'/lib/class-ual-main.php'); 

// Initialize our main object - we don't want to include code in main plugin file
$plugin_object = new UAL_Main();