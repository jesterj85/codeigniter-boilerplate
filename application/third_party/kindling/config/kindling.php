<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Kindling Library Configuration File
 *
 * Contains default configuration options for the Kindling library.
 *
 */

/**
 * Layout File Path
 *
 * Where your layout files are stored. Defaults to the layouts directory within
 * the views directory. Make sure to create it before using Kindling.
 *
 */

$config['layout_path'] = APPPATH . 'views/layouts/';


/**
 * Default Layout File
 *
 * The filename, without the .php extension, for the default layout file.
 *
 */

$config['layout'] = 'primary';


/**
 * Kindling Layout Variable
 *
 * A string containing the variable name that will represent Kindling within layout files.
 * For example, if 'layout_kindling_var' was set to 'template', $template would be
 * available within layout files, and would refer to Kindling.
 *
 * To prevent Kindling from automatically creating this variable, set 'layout_kindling_var'
 * to FALSE.
 *
 */

$config['layout_kindling_var'] = 'kindling';


/**
 * CSS URI Path
 *
 * The URI path to the primary location CSS files are stored. This value is used with the
 * 'internal' CSS entries when calling Kindling::get_css().
 *
 */

$config['css_uri'] = '/css/';


/**
 * JS URI Path
 *
 * The URI path to the primary location JS files are stored. This value is used with the
 * 'internal' JS entries when calling Kindling::get_js().
 *
 */

$config['js_uri'] = '/js/';


/**
 * Displayed Message Types
 *
 * Controls the default messages types that are rendered with Kindling::get_messages(). For
 * example, 'debug' is not included by default, so you can assign debug messages, and not
 * worry about them being displayed to a visitor.
 *
 */

$config['displayed_messages'] = array('notice', 'warning', 'error');


/**
 * Cache Version
 *
 * The current cache version, used with the 'internal' type for Kindling::css() and
 * Kindling::js(). Using this value allows you to set far ahead expirations on CSS and JS
 * files, but force a visitor to redownload them when ever you increment the 'cache_version'.
 *
 * Cache versioning uses the HTML Boilerplate style.
 * See https://github.com/h5bp/html5-boilerplate/wiki/Version-Control-with-Cachebusting.
 *
 */

$config['cache_version'] = 0;


/**
 * Append Cache Version
 *
 * A global switch for controlling whether the 'cache_version' is actually appended.
 *
 */

$config['append_cache_version'] = TRUE;


/**
 * Convert External URLS
 *
 * Convert external CSS and JS URLs to protocol-relative URLs. This will take
 * 'http://example.com/js/foobar.js' and convert it to '//example.com/js/foobar.js'. Useful
 * for eliminating the annoying "some resources aren't being transmitted securely" notices
 * within browsers.
 *
 * Note: protocol-relatives URLs cause a double download of CSS files in IE 7 and 8 (see
 * http://www.stevesouders.com/blog/2010/02/10/5a-missing-schema-double-download/), so use this
 * feature if you don't care about those browsers.
 *
 */

$config['convert_external_urls'] = TRUE;


# EOF