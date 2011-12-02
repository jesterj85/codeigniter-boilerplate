<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * MY Constants
 * 
 * Contains constants that apply to this applications. This file provides a separation from the
 * default constants.php file, in case that file is ever replace during a CodeIgniter update.
 * 
 */

/**
 * Debug Constant
 * 
 * Useful when you want to show debug info, without having to remove the debug code afterwards.
 * 
 */

define('DEBUG', FALSE);


/**
 * Cache Version
 * 
 * Used in conjunction apache header caching and cache busting set up in the .htaccess file. Up 
 * this value each time you make a significant change to an existing stylesheet, images, etc.
 * 
 * Use this constant within your <img>, <script>, and <link rel="stylehseet"> tags. 
 * Example: <script src="/js/script.<?php echo CACHE_VERSION; ?>.js"></script>
 * 
 */

define('CACHE_VERSION', 0);		# Used for cache busting


/**
 * Root Path Constants
 * 
 * Useful when your index.php front controller may not be in the same directory as your application or system
 * directories. For example, if you are deploying with capistrano, and have your index.php symlinked to the
 * shared directory. The FCPATH, APPPATH constants will actually be /path/to/cap/shared/ and
 * /path/to/cap/shared/application/ instead of /path/to/www/ and /path/to/www/application
 * 
 * There may be a better way of doing this.
 * 
 */

#define('ROOTPATH', '/path/to/www/');


$config = array();	# Prevents CodeIgniter from complaining about this file


# EOF