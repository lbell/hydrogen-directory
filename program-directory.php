<?php
/*
Plugin Name: Program Directory
Plugin URI:
Description: Manage and display a directory of individuals.
Version: 0.1
Author: LBell
Author URI: http://lorenbell.com
Text Domain: progdir
*/
/*  Copyright 2020 LBell  (email : lbell270@gmail.com)

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


define('PROGDIR_DIR', plugin_dir_path(__FILE__)); // Trailing slash
// define( 'PROGDIR_DIR', basename( dirname( __FILE__ ) ) ); // No Trialing Slash
define('PROGDIR_TEMPLATE_DIR', PROGDIR_DIR . 'templates/');
define('PROGDIR_URL', plugins_url() . '/program-directory/');

load_plugin_textdomain('progdir', false, PROGDIR_DIR . 'languages');

require(PROGDIR_DIR . 'util/dropdown-category-callback.php');
require(PROGDIR_DIR . 'util/post-entries.php');
require(PROGDIR_DIR . 'util/thumb.php');
require(PROGDIR_DIR . 'util/column-fill.php');
require(PROGDIR_DIR . 'init/init.php');
require(PROGDIR_DIR . 'init/templates.php');
require(PROGDIR_DIR . 'init/admin/position-meta-box.php');
require(PROGDIR_DIR . 'init/admin/directory-settings-page.php');
require(PROGDIR_DIR . 'init/shortcode.php');

require(PROGDIR_DIR . 'util/console-log.php'); // DEBUG