== Hydrogen Directory ===
Contributors: LBell
Donate link: https://github.com/sponsors/lbell
Tags: directory, employee, people, church, club
Requires at least: 3.0
Tested up to: 6.9
Stable tag: 1.2.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

The simplest, lightest way to manage and display a directory of anything.

== Description ==

Finally!

A ridiculously light, stupidly-simple plugin to manage and display a directory of anything: production cast, blog contributors, businesses, collectors items, church members, books, club officers, chickens in your flock, departmental employees, students, bowling league teams... you get the point.

Most "directory" plugins out there are way too complicated. One of the more popular ones weighs in at 30 MB! That's almost as much code as Wordpress Core. That's uranium heavy. Be careful of meltdowns...

*Enter Hydrogen Directory.*

This plugin is light and simple, just like hydrogen. Weighing just 62kb zipped, it's so tiny it might float away.

Whether you need to just list the 3 members on your team, are looking to showcase the 200 cars in your pinewood derby league, or need to import 10,000 employees, Hydrogen Directory manages it all with ease, speed, and predictable grace.

Highlights:

1. Quickly add or updated listings in wordpress using familiar interface.
1. Organize entries into buckets using taxonomies.
1. Display your directories anywhere on your site.

That's it! Get on to more important things in your life.

== Installation ==

1. Upload the `hydrogen-directory` folder to the `/wp-content/plugins/` directory.
1. Activate `Hydrogen Directory` through the 'Plugins' menu in WordPress dashboard.
1. Use the "Hydrogen Directory" block in the Gutenberg editor, or use the shortcode `[hydrogen_directory]` in classic editor or anywhere shortcodes work.

== Gutenberg Block ==

The Hydrogen Directory block provides a visual way to add directory listings to your pages and posts.

**Block Features:**

* Live preview in the editor
* Visual controls for all settings
* Layout Settings: Display style (list/card/text), columns (1-6), show/hide headers
* Content Settings: Content mode (excerpt/full/none), excerpt length
* Filter Settings: Taxonomy selection, term filtering, show entries filter

Simply search for "Hydrogen Directory" in the block inserter, add the block, and configure using the sidebar controls.

**Shortcode Arguments:**

**tax:** use to display entries from a single taxonomy
**term:** use to display entries from a single term in a taxonomy
**style:** display style (default "list")
**columns:** number of columns to display (default 1)
**headers:** whether to include tax / term headers in the output (default 1 = yes)
**content:** content display mode - "excerpt" (truncated, default), "full" (all content), or "none" (hide content)
**excerpt_length:** number of words to show when content="excerpt" (default 20)

Example: 
`[hydrogen_directory tax="role" term="Alter Boy" style="card" columns=3]`
`[hydrogen_directory tax="role" term="Staff" style="list" content="excerpt" excerpt_length="30"]`
`[hydrogen_directory tax="department" content="none"]`

== Screenshots ==

1. Included "list" style.
2. Included "card" style.
3. Included "text" style.
4. Custom avatar style.
5. Settings page (There isn't one. It's that simple.)

== Frequently Asked Questions ==

= Can I import entries from a CSV? =

Yes - you can import using standard CSV import pathways. Although WordPress does not offer CSV import function natively, there are a number of plugins that will add this feature. This plugin has been tested successfully with the "Really Simple CSV Importer" plugin. (Note, entries in the file must be **comma** separated.)

= How do I theme the output? =

You have several options:

1. Add custom css to your theme to tweak the look.
1. Override the default templates by copying any of the `directory-list-entry-{type}.php` files into your theme, and modifying it there.
1. Use the plugin hooks (filters / actions) to customize specific parts.

= Can this plugin do X,Y or Z? =

Probably not. But it could!

Hydrogen Directory is purposefully simple and easy. But it can extended in powerful ways. Contact me for requests for additional functionality.

== Changelog ==

= 1.2.1 =
- Fix: removed css from text template

= 1.2.0 =
- Add: Gutenberg Block with live preview and visual controls
- Add: REST API endpoint for block preview
- Add: Block editor styles for accurate preview rendering
- Add: More filter hooks for customizing output

= 1.1.0 =
- Fix: CSS structure for better theming
- Add: schema.org markup
- Add: shortcode options for content display mode and excerpt length

= 1.0.4 =

* Tested to WordPress 6.9
* Fix: escaping output
* Fix: namespacing and global variables
* Fix: post sanitization
* Security: prevent direct access
* Fix: template errors 
* Fix: corrected filter/action usage

= 1.0.3 =

* Bugfix: activation error (submenu permission)
* Tested to WP 5.9.3

= 1.0.2 =

* CSS Fix

= 1.0.1 =

* Position Meta Box fix
* Code cleanup

= 1.0.0 =

* Initial Release
