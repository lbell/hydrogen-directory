=== Program Directory ===
Contributors: LBell
Donate link: 
Tags: directory, student, teacher, employee, people list
Requires at least: 3.0
Tested up to: 5.5
Stable tag: 0.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Create and maintain a directory of people.

== Description ==

Manage and display a directory of individuals.

1. Quickly add or updated people in Admin
1. Organize by custom hierarchy
1. Display program directory using shortcodes.


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

Yes - you can import using standard CSV import pathways. Although WordPress does not offer CSV import function natively, there are a number of plugins that will add this feature. This plugin has been tested successfully with the "Really Simple CSV Importer" plugin. Note, entries in the file must be **comma** separated.

= How do I theme my output = 

You can override the default theme by copying the `directory-list-entry-{type}.php` file into your theme, and modifying it there. You'll probably need to tweak some CSS too.

= Can this plugin do X,Y or Z? =

Probably not. But it could! Send me your requests/needs and I can see about integrating them.

== Screenshots ==

(Coming Soon ... maybe)

== Changelog ==

= 0.1 =
Initial Release

