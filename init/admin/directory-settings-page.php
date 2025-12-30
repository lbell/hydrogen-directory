<?php
function hydir_render_settings_page() {

?>

	<div class="hydir-settings-page">
		<div class="hydir-settings-header">
			<img class="hydir-logo" src=<?php
										echo 'data:image/svg+xml;base64,' . base64_encode('
			<svg width="30mm" height="30mm" version="1.1" viewBox="0 0 128 128" xmlns="http://www.w3.org/2000/svg">
			<g transform="translate(133.17 -53.681)">
			 <circle cx="-69.044" cy="117.75" r="63.808" fill="#68c5ed" stroke-width=".26866"/>
			 <path d="m-70.976 83.359-18.268 0.0024c-10.042 0.0013-18.77 0.04009-19.394 0.08517-1.0335 0.07485-1.1904 0.1108-1.8141 0.42131-0.91326 0.44817-1.8978 1.4285-2.4725 2.4656l-0.41655 0.74591-0.0597 19.382c-0.0268 10.661-0.0575 24.017-0.0575 29.682v10.302l0.21429 0.57554c0.31184 0.81527 0.52703 1.2159 1.0037 1.8578 0.65041 0.85982 1.7132 1.6011 2.6843 1.8671 0.1782 0.0476 1.7551 0.11677 3.497 0.15196v-2e-3c1.7553 0.0353 4.785 0.0717 6.7407 0.0806l3.5569 0.0184 0.05748-1.1603c0.02668-0.63705 0.05748-1.4288 0.05748-1.7589v-0.60086l0.48119-0.0576c0.26284-0.0311 1.0597-0.059 1.7681-0.0599h1.2961v3.6374h46.373v-3.6374h1.2915c0.7128 6.6e-4 1.5098 0.0289 1.7727 0.0599l0.47655 0.0576v0.65385c0 0.35997 0.02228 1.1602 0.06192 1.775l0.05747 1.1189 6.2343-0.0621c3.4259-0.0352 6.5752-0.1057 6.994-0.15424 0.88654-0.10736 1.4877-0.35701 2.2584-0.93929 0.87763-0.66244 1.567-1.6559 2.0259-2.9237l0.19336-0.55062-0.0401-24.949c-0.03563-25.492-0.0481-26.342-0.37733-27.665-0.24502-0.94178-1.3143-2.1132-2.6107-2.8478l-0.68143-0.38446-19.488-0.10131c-10.714-0.0548-19.497-0.10674-19.506-0.11743-0.01336-0.0098-0.0597-0.59112-0.12207-1.2892-0.14256-1.9335-0.38625-2.7543-1.059-3.6466-0.45886-0.60855-1.042-1.0875-1.9776-1.6092zm-18.777 16.735c1.6483 0 3.0131 1.2042 3.276 2.7741 8.1883 1.5334 14.384 8.7201 14.384 17.356 0 9.7542-7.8991 17.662-17.66 17.662-9.7609 0-17.66-7.9081-17.66-17.662 0-8.636 6.1982-15.824 14.391-17.358 0.26285-1.569 1.6252-2.7718 3.2691-2.7718zm-3.2507 3.8907c-7.5868 1.5125-13.304 8.2094-13.304 16.24 0 9.1452 7.4089 16.557 16.555 16.557 9.1461 0 16.56-7.413 16.56-16.557 0-8.0301-5.7197-14.727-13.307-16.24-0.27176 1.5566-1.618 2.7327-3.253 2.7327-1.635 0-2.9789-1.1774-3.2507-2.7327zm27.175 5.4654 5.249 0.0598c2.8824 0.0329 10.108 0.0599 16.042 0.0599h10.8v3.4279l-1.158 0.0576c-0.64152 0.032-7.8604 0.0599-16.053 0.0599h-14.879v-1.8325zm-24.067 4.2176c3.662 0 6.6257 2.964 6.6257 6.621 0 3.658-2.9637 6.6234-6.6257 6.6234-3.662 0-6.6257-2.9654-6.6257-6.6234 0-3.6571 2.9637-6.621 6.6257-6.621zm40.159 4.7839c7.9644 4e-3 15.928 0.0254 15.966 0.0644 0.03119 0.0272 0.07218 0.82799 0.0989 1.7796l0.04856 1.7312h-32.237l0.05079-1.7289c0.01782-0.94935 0.06593-1.7555 0.10602-1.7934 0.03565-0.0388 8.0035-0.0562 15.968-0.0529zm16.081 8.937v3.5454h-32.187l0.03119-1.7497 0.01782-1.7496 16.069-0.023z" stroke-width="9.7395"/>
			</g>
		   </svg>
	   ');

										?> />
			<h1>Hydrogen Directory</h1>

			&nbsp;&nbsp; <button><a href="https://github.com/sponsors/lbell">Sponsor</a></button>

		</div>

		<div class="hydir-settings-content">
			<p>
				Welcome to the lightest, simplest directory plugin you'll find. But just like the world's smallest atom,
				Hydrogen Directory packs a powerful punch if used correctly.
			</p>
			<p>
				In simplest terms, add people (or things, or whatever... it's your site, you do you) and then display a
				listing on any page or post using the handy shortcode.
			</p>
			<p>
				BOOM! <a href="https://en.wikipedia.org/wiki/Doctor_Manhattan">Dr. Manhattan</a> couldn't do it any faster.
			</p>
			<h2> Using the Hydrogen Directory Shortcode </h2>
			<p>
				Insert a directory listing on any page or post with the shortcode:
			</p>
			<code>[hydrogen_directory]</code>
			<p>
				You can further refine what gets displayed by using a handful of arguments. For example:
			</p>
			<code>[hydrogen_directory tax="role" term="Alter Boy" style="list" columns=3]</code>
			<p>
				Some attributes play nicer with eachother than others, and some are specific to add-ons and may be
				ignored in your shortcode. For example, the only Taxonomy included in the base plugin is "role" and the
				only styles included are list, card and text. (Need more? <a href="#help">See below</a>.)
			</p>

			<!-- Table generated with the excellent: https://www.tablesgenerator.com/html_tables -->
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
							<td class="tg-0a7q">Base plugin includes "role" tax</td>
						</tr>
						<tr>
							<td class="tg-0a7q">term</td>
							<td class="tg-0a7q">Term of above taxonomy (optional)</td>
							<td class="tg-73oq"></td>
							<td class="tg-0a7q">Limits tax to specified term. Use term name or slug.</td>
						</tr>
						<tr>
							<td class="tg-0a7q">style</td>
							<td class="tg-0a7q">Style of listing</td>
							<td class="tg-0a7q">list</td>
							<td class="tg-0a7q">Base plugin includes: 'text', 'list', and 'card' styles</td>
						</tr>
						<tr>
							<td class="tg-0a7q">columns</td>
							<td class="tg-0a7q">Number of columns</td>
							<td class="tg-0a7q">1</td>
							<td class="tg-0a7q"></td>
						</tr>
						<tr>
							<td class="tg-0a7q">headers</td>
							<td class="tg-0a7q">Include headers</td>
							<td class="tg-0a7q">1</td>
							<td class="tg-0a7q">1 = yes, 0 = no to include the Taxonomy and Terms in your list</td>
						</tr>
					</tbody>
				</table>
			</div>
			<p>
				Oh, and did we mention that variations on the shortcode can be used multiple times on the same page or post?
				No? It's true. Nice!
			</p>

			<h2>Customizing / Extending the Plugin</h2>
			<p>
				I've tried to add hooks and filters to make customizing things easy for developers. But ANYONE can easily
				change the look of how things are displayed by overiding the styles or adding custom CSS.
			</p>
			<p>
				Neat! But to be honest, I published this stupid-simple plugin with the hope that while it will do what
				90% of you need, the other 10% of you <b>might consider hiring me</b> to customize it for you. I'm not going to
				maintain a bunch of add-ons that <em>might</em> do close to what you need for an ever-increasing
				subscription fee. Instead, let's talk and I'll tailor an add-on for exactly what you need.
			</p>
			<h4>Styles</h4>
			<p>
				Any of the included styles can be overidden easily by either:
			</p>
			<p>
				• Copying any of the files in the "template" folder into your theme and editing them as you see fit, or<br />
				• Overiding the <code>hydir_shortcode_meat</code> filter for a more nuclear option

			</p>
			<h4>Taxonomies</h4>
			<p>
				Need a "Degree" taxonomy for your students?
			</p>
			<p>
				Just add one via your theme's <code>function.php</code> file,
				or a Taxonomy plugin. Then they'll be available using the <code>tax="" term=""</code> arguments of the shortcode.
			</p>
			<p>
			</p>

			<h2><a name="help">Need help?</a></h2>
			<p>
				Look. Like I said above, I'm giving this to the world because I believe in open-source and think it will
				serve the needs of 90% of users as-is.
			</p>
			<p>
				But what about <b>you</b>? You're no sheep... you want something special. Something different.
			</p>
			<p>
				I'm here for you.
			</p>
			<p>
				Please reach out.
			</p>
			<h2>Love it?</h2>
			<div class="hydir-settings-love">
				<button><a href="https://github.com/sponsors/lbell">Sponsor</a></button>
			</div>
		</div>
	</div>
<?php
}
