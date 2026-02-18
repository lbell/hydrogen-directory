<?php
/*
Plugin Name: Hydrogen Directory
Plugin URI: https://github.com/lbell/hydrogen-directory
Description: The simplest, lightest way to manage and display a directory of anything.
Version: 1.3.0
Author: LBell
Author URI: http://lorenbell.com
Text Domain: hydrogen-directory
License: GPLv2 or later
*/
/*  Copyright 2020 LBell

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

if (! defined('ABSPATH')) exit;

define('HYDIR_VER', "1.3.0");
define('HYDIR_DIR', plugin_dir_path(__FILE__)); // Trailing slash
define('HYDIR_TEMPLATE_DIR', HYDIR_DIR . 'templates/');
define('HYDIR_URL', plugin_dir_url(__FILE__));

load_plugin_textdomain('hydrogen-directory', false, dirname(plugin_basename(__FILE__)) . '/languages');

/**
 * Plugin activation hook
 */
function hydir_activate() {
  /**
   * Fires when the Hydrogen Directory plugin is activated.
   * Use this hook to set up custom tables, options, or initial data.
   */
  do_action('hydir_activated');

  // Flush rewrite rules on activation
  flush_rewrite_rules();
}
register_activation_hook(__FILE__, 'hydir_activate');

/**
 * Plugin deactivation hook
 */
function hydir_deactivate() {
  /**
   * Fires when the Hydrogen Directory plugin is deactivated.
   * Use this hook to clean up temporary data (do NOT remove user data here).
   */
  do_action('hydir_deactivated');

  // Flush rewrite rules on deactivation
  flush_rewrite_rules();
}
register_deactivation_hook(__FILE__, 'hydir_deactivate');

require(HYDIR_DIR . 'util/dropdown-category-callback.php');
require(HYDIR_DIR . 'util/post-entries.php');
require(HYDIR_DIR . 'util/thumb.php');
require(HYDIR_DIR . 'util/column-fill.php');
require(HYDIR_DIR . 'init/init.php');
require(HYDIR_DIR . 'init/templates.php');
require(HYDIR_DIR . 'init/admin/position-meta-box.php');
require(HYDIR_DIR . 'init/admin/directory-settings-page.php');
require(HYDIR_DIR . 'init/shortcode.php');
require(HYDIR_DIR . 'init/block.php');

// require(HYDIR_DIR . 'dev/console-log.php'); // DEBUG

/**
 * Fires after Hydrogen Directory has fully loaded.
 * 
 * Use this hook to safely extend Hydrogen Directory functionality.
 * All plugin files and functions are available at this point.
 * 
 * @since 1.2.0
 */
do_action('hydir_loaded');