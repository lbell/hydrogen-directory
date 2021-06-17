<?php
// Note - while handy, this function will possibly cause wordpress Gutenberg
// to return "The response is not valid JSON response" if used inside a plugin.
// for testing only.

if (!function_exists('console_log')) {
	function console_log($output, $with_script_tags = true) {
		$js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) . ');';
		if ($with_script_tags) {
			$js_code = '<script>' . $js_code . '</script>';
		}
		echo $js_code;
	}
}
