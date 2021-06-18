<?php
function hydir_render_settings_page() {

?>

	<h2> Using the Program Directory Shortcode </h2>

	<p>
		Insert a directory listing on any page or post with the shortcode:
	</p>
	<code>[program_directory]</code>
	<p>
		You can further refine what gets displayed by using the arguments listed in the table below.
	</p>
	<code>[program_directory tax="role" show="all" style="list" columns=3]</code>
	<p>
		Some attributes are specific to add-ons and may be ignored in your shortcode. For example, the only Taxonomy
		included in the base plugin is "role" and the only style included is "list". See below for customization options.
	</p>
	<p>
		The shortcode can be used multiple times on the same page or post.
	</p>

	<!-- Generated with the excellent: https://www.tablesgenerator.com/html_tables -->
	<style type="text/css">
		.tg {
			border-collapse: collapse;
			border-spacing: 0;
		}

		.tg td {
			border-color: black;
			border-style: solid;
			border-width: 1px;
			font-family: Arial, sans-serif;
			font-size: 14px;
			overflow: hidden;
			padding: 10px 5px;
			word-break: normal;
		}

		.tg th {
			border-color: black;
			border-style: solid;
			border-width: 1px;
			font-family: Arial, sans-serif;
			font-size: 14px;
			font-weight: normal;
			overflow: hidden;
			padding: 10px 5px;
			word-break: normal;
		}

		.tg .tg-1tol {
			border-color: #000000;
			font-weight: bold;
			text-align: left;
			vertical-align: middle
		}

		.tg .tg-0a7q {
			border-color: #000000;
			text-align: left;
			vertical-align: middle
		}

		.tg .tg-73oq {
			border-color: #000000;
			text-align: left;
			vertical-align: top
		}

		@media screen and (max-width: 767px) {
			.tg {
				width: auto !important;
			}

			.tg col {
				width: auto !important;
			}

			.tg-wrap {
				overflow-x: auto;
				-webkit-overflow-scrolling: touch;
			}
		}
	</style>

	<div class="tg-wrap">
		<table class="tg">
			<thead>
				<tr>
					<th class="tg-1tol">Attribute</th>
					<th class="tg-1tol">Description</th>
					<th class="tg-1tol">Default</th>
					<th class="tg-1tol">Notes</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td class="tg-0a7q">tax</td>
					<td class="tg-0a7q">Taxonomy to display</td>
					<td class="tg-0a7q">role</td>
					<td class="tg-0a7q">Only one taxonomy, "role" is included with the base plugin. Contact for custom catregory options.</td>
				</tr>
				<tr>
					<td class="tg-0a7q">term</td>
					<td class="tg-0a7q">Term of above taxonomy (optional)</td>
					<td class="tg-73oq"></td>
					<td class="tg-0a7q">Can be term slug or name</td>
				</tr>
				<tr>
					<td class="tg-0a7q">style</td>
					<td class="tg-0a7q">Style of listing</td>
					<td class="tg-0a7q">list</td>
					<td class="tg-0a7q">Only the "list" style is included with the base plugin. Contact for custom display options.</td>
				</tr>
				<tr>
					<td class="tg-0a7q">columns</td>
					<td class="tg-0a7q">Number of columns</td>
					<td class="tg-0a7q">3</td>
					<td class="tg-0a7q"></td>
				</tr>
				<tr>
					<td class="tg-0a7q">headers</td>
					<td class="tg-0a7q">Include headers</td>
					<td class="tg-0a7q">1</td>
					<td class="tg-0a7q">1 = yes, 0 = no</td>
				</tr>
			</tbody>
		</table>
	</div>

	<h2>Customizing / Extending the Plugin</h2>
	<p>Additional taxonomies and list display styles can be included via theme functions or add-ons.</p>
	<p>
		If you wish to customize the display, you can override the included templates by including an identically-named
		file in your theme's directory. For example, override the <code>directory-single-content.php</code> file by making a
		copy of it into your theme's directory and editing at you see fit.
	</p>

	<h2>Need help?</h2>
	<p>
		Need customizations or additional functionality like personnell status (current / alumni, active / retired)
		additional categories (Department, Campus, Group) or more creative ways to display your directory
		(cards, avatars, etc)?
	</p>
	<p>
		Well good news: I'm available for bespoke customization on a per-project basis. Please
		reach out to lbell270 at gmail.
	</p>
<?php
}
