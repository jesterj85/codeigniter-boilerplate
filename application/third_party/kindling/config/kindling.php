<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Kindling Library Configuration File
 *
 * Contains default configuration options for the Kindling library.
 *
 */

# Layout settings
$config['layout_path'] = APPPATH . 'views/layouts/';
$config['layout'] = 'primary';

# CSS settings
$config['css_path'] = '/css/';
$config['parse_css'] = TRUE;			# Setting to FALSE will prevent Kindling class from outputting any CSS

# JavaScript settings
$config['js_path'] = '/js/';
$config['parse_js'] = TRUE;				# Setting to FALSE will prevent Kindling class from outputting any JS

$config['js_include_ga'] = TRUE;		# Include Google Analytics by default

# HTTP cache controls
$config['cache_version'] = 0;
$config['include_cache_version'] = TRUE;	# Whether to include HTML5 Boilerplate style cache versioning. See https://github.com/h5bp/html5-boilerplate/wiki/Version-Control-with-Cachebusting.

# HTTP/HTTPS

/*
	Note: protocol-relatives URLs cause a double download of CSS files in IE 7 and 8 (see
	http://www.stevesouders.com/blog/2010/02/10/5a-missing-schema-double-download/), so use this
	feature if you don't care about those browsers.
*/

$config['convert_external_urls'] = TRUE;	# Convert external URLs to protocol-relative URLs for stylesheets and javascript files (used with Kindling's css() and js() methods)


# Convert $config into friendly version for accessing later
$config = array('kindling' => $config);


# EOF