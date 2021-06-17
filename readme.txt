=== Program Directory ===
Contributors: LBell
Donate link: https://github.com/sponsors/lbell
Tags: directory, student, teacher, employee, people list, board membership, program directory
Requires at least: 3.0
Tested up to: 5.7
Stable tag: 1.0.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Create and maintain a directory of people.

== Description ==

Manage and display a directory of individuals like students, board members, team members, department listing, etc.

1. Quickly add or updated people in Admin
1. Organize by custom hierarchy
1. Display program directory anywhere on your site using shortcodes.


== Installation ==

1. Upload the `program-directory` folder to the `/wp-content/plugins/` directory
1. Activate `Program Directory` through the 'Plugins' menu in WordPress
1. Use the shortcode [program-directory] directly in your page content

Shortcode Arguments:
tax = "taxonomy" to display entries by taxonomy
single = "term" to display entries from a single term in a taxonomy
columns = "#" to have entries displayed in multiple columns

== Frequently Asked Questions ==

= Can I import people from a CSV? =

Yes - you can import using standard CSV import pathways. Although WordPress does not offer CSV import function natively, there are a number of plugins that will add this feature. 
This plugin has been tested successfully with the "Really Simple CSV Importer" plugin. Note, entries in the file must be **comma** separated.

= How do I theme my output = 

You can override the default theme by copying the `directory-list-entry-{type}.php` file into your theme, and modifying it there. You'll probably need to tweak some CSS too.

= Can this plugin do X,Y or Z? =

Probably not. But it could! 

This is a simple plugin for getting you started. Contact me for requests for additional functionality.

Send me your requests/needs and I can see about integrating them.

== Screenshots ==

(Coming Soon ... maybe)

== Changelog ==

= 1.0.0 =
Initial Release

