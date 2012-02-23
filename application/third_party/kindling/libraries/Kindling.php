<?php

/**
 * Kindling Library
 *
 * A simple layout engine for CodeIgniter.
 *
 * @version 0.1.1
 *
 * @author Kevin Wood-Friend
 *
 */

class Kindling {

	public $config = array();

	public $content = array();

	public $meta = array();

	public $css = array(
		'external' => array(),
		'internal' => array(),
		'include' => array(),
		'embed' => array()
	);

	public $js = array(
		'external' => array(),
		'internal' => array(),
		'include' => array(),
		'embed' => array(),
		'ready' => array()
	);

	public $messages = array(
		'errors' => array(),
		'warnings' => array(),
		'notices' => array()
	);


	/**
	 * Constructor
	 *
	 * @param array $config Configuration array to be merged with the Kindling class's configuration file
	 *
	 * @return void
	 *
	 */

	public function __construct($config = array())
	{
		$this->CI =& get_instance();

		# Merge $config and configuration file
		$this->config = array_merge($this->CI->config->item('kindling'), $config);
	}


	/**
	 * Set config item
	 *
	 * Allows insertion of a new config item into the config array.
	 *
	 * This method will accept two argument formats. A two argument format, with a key and
	 * value, or an array of keys and values.
	 *
	 * When using the two argument format, if the second parameter is not supplied,
	 * the item will still be merged into the config array with a value of NULL.
	 *
	 * @since 0.1.0
	 *
	 * @author Kevin Wood-Friend
	 *
	 * @param string|array $item A key name or array of items to add to the config array.
	 *
	 * @param mixed $value The corresponding value for $item.
	 *
	 * @return void
	 *
	 */

	public function config($item, $value = NULL)
	{
		if (is_bool($item) OR is_null($item))
			return FALSE;	# Bool or NULL items aren't allowed

		if (is_string($item))
			$item = array($item => $value);

		$this->config = array_merge($this->config, (array) $item);
	}


	/**
	 * Unset config item
	 *
	 * Unsets the given config item.
	 *
	 * @since 0.1.0
	 *
	 * @author Kevin Wood-Friend
	 *
	 * @param mixed $item The item(s) to unset from the config array.
	 *
	 * @return void
	 *
	 */

	public function unset_config($item)
	{
		foreach ((array) $item as $key)
			unset($this->config[$key]);
	}


	/**
	 * Clear config
	 *
	 * Wipes all items from the config array.
	 *
	 * @since 0.1.0
	 *
	 * @author Kevin Wood-Friend
	 *
	 * @return void
	 *
	 */

	public function clear_config()
	{
		$this->config = array();
	}


	/**
	 * Get config item
	 *
	 * Returns the requested config item(s) from the config array.
	 *
	 * @since 0.1.0
	 *
	 * @author Kevin Wood-Friend
	 *
	 * @param string|array|NULL $item The item(s) requested from the config array. If NULL,
	 * 			the entire config array will be returned.
	 *
	 * @param mixed $default An optional value to return if the item does not exist in the config array.
	 * 			This parameter is not used when $item is an array.
	 *
	 * @return mixed
	 *
	 */

	public function get_config($item, $default = FALSE)
	{
		if (is_bool($item))
			return FALSE;	# Bool items aren't allowed, so don't even search for them.

		if ($item === NULL)
			return $this->config;

		if (is_string($item))
		{
			if (array_key_exists($item, $this->config))
				return $this->config[$item];

			else return $default;
		}

		else
		{
			$found = array();

			foreach ($item as $key)
			{
				if (array_key_exists($key, $this->config))
					$found[$key] = $this->config[$key];
			}

			return $found;
		}
	}


	/**
	 * Set content item
	 *
	 * Either adds a new item to the content array, or overwrites a preexisting item.
	 *
	 * @since 0.1.0
	 *
	 * @author Kevin Wood-Friend
	 *
	 * @param string|array $item Either a string with the key of the content item to set, or a key-value
	 * 			array, where the key will become the content item's name, and the value will become the item's value.
	 *
	 * @param mixed $value The value to be assigned when $item is a string. If $item is not a string, $value is ignored.
	 *
	 * @return void
	 *
	 */

	public function content($item, $value = NULL)
	{
		if (is_bool($item) OR is_null($item))
			return FALSE;	# Bool and NULL items aren't allowed

		if (is_string($item))
			$item = array($item => $value);

		$this->content = array_merge($this->content, $item);
	}


	/**
	 * Unset content item
	 *
	 * Removes a content item from the content array.
	 *
	 * @since 0.1.0
	 *
	 * @author Kevin Wood-Friend
	 *
	 * @param string|array $item The item(s) to unset from the content array.
	 *
	 * @return void
	 *
	 */

	public function unset_content($item)
	{
		foreach ((array) $item as $key)
			unset($this->content[$key]);
	}


	/**
	 * Clear content array
	 *
	 * Wipes all items from the content array.
	 *
	 * @since 0.1.0
	 *
	 * @author Kevin Wood-Friend
	 *
	 * @return void
	 *
	 */

	public function clear_content()
	{
		$this->content = array();
	}


	/**
	 * Get content item
	 *
	 * Returns the requested content item(s) from the content array.
	 *
	 * @since 0.1.0
	 *
	 * @author Kevin Wood-Friend
	 *
	 * @param string|array|NULL $item The item(s) requested from the content array. If NULL,
	 * 			the entire content array will be returned.
	 *
	 * @param mixed $default An optional value to return if the item does not exist in the content array.
	 * 			This parameter is ignored when $item is an array.
	 *
	 * @param bool $convert_chars Whether to run the returned content through htmlspecialchars()
	 *
	 * @return mixed
	 *
	 */

	public function get_content($item, $default = FALSE, $convert_chars = FALSE)
	{
		if (is_bool($item))
			return FALSE;	# Bool items aren't allowed, so don't even search for them.

		if ($item === NULL)
			return $this->content;

		if (is_string($item))
		{
			if (array_key_exists($item, $this->content))
			{
				if ($convert_chars)
					return htmlspecialchars($this->content[$item]);

				return $this->content[$item];
			}

			else return $default;
		}

		else
		{
			$found = array();

			foreach ($item as $key)
			{
				if (array_key_exists($key, $this->content))
				{
					if ($convert_chars)
						$found[$key] = htmlspecialchars($this->content[$key]);

					else
						$found[$key] = $this->content[$key];
				}
			}

			return $found;
		}
	}


	/**
	 * Set meta item
	 *
	 * Either adds a new item to the meta array, or overwrites a preexisting item.
	 *
	 * @since 0.1.0
	 *
	 * @author Kevin Wood-Friend
	 *
	 * @param string|array $item Either a string with the name of the meta item to set, or a key-value
	 * 			array, where the key will become the meta tag's name attribute, and the value will become the content attribute.
	 *
	 * @param string $value The value to be assigned when $item is a string. If $item is not a string, $value is ignored.
	 *
	 * @return void
	 *
	 */

	public function meta($item, $value = NULL)
	{
		if (is_bool($item) OR is_null($item))
			return FALSE;	# Bool and NULL items aren't allowed

		if (is_string($item))
			$item = array($item => $value);

		$this->meta = array_merge($this->meta, $item);
	}


	/**
	 * Unset meta item
	 *
	 * Removes a meta item from the meta array.
	 *
	 * @since 0.1.0
	 *
	 * @author Kevin Wood-Friend
	 *
	 * @param string|array $item The item(s) to unset from the meta array.
	 *
	 * @return void
	 *
	 */

	public function unset_meta($item)
	{
		foreach ((array) $item as $key)
			unset($this->meta[$key]);
	}


	/**
	 * Clear meta array
	 *
	 * Wipes all items from the meta array.
	 *
	 * @since 0.1.0
	 *
	 * @author Kevin Wood-Friend
	 *
	 * @return void
	 *
	 */

	public function clear_meta()
	{
		$this->meta = array();
	}


	/**
	 * Render meta tags
	 *
	 * Returns a string of meta tags. Both the meta array item's key and value will be run though htmlspecialchars().
	 *
	 * @since 0.1.0
	 *
	 * @author Kevin Wood-Friend
	 *
	 * @return A string of meta tags.
	 *
	 */

	public function get_meta()
	{
		$return = NULL;

		foreach ($this->meta as $name => $content)
		{
			$return .= '<meta name="' . htmlspecialchars($name) . '" content="' . htmlspecialchars($content) . '" />';
		}

		return $return;
	}


	/**
	 * Set CSS items
	 *
	 * Adds a CSS item to the CSS array.
	 *
	 * @since 0.1.0
	 *
	 * @author Kevin Wood-Friend
	 *
	 * @param string|array $data Either a string, or array, of data to be inserted in the CSS $type array.
	 *
	 * @param string $type What type of CSS items are being added. Can be external, internal, include, or embed.
	 *
	 * 		- external: a stylesheet that is not contain on the same domain as the site. For example,
	 * 				a stylesheet on a CDN or subdomain. $data should be a string (or array) of the stylesheet's URL.
	 * 				When using the external type, $this->config['convert_external_urls'] is used as a flag to control whether
	 * 				$data is automatically stripped of 'http:' or 'https:' and replaced with a protocol-relative URL.
	 *
	 * 				Note: protocol-relatives URLs cause a double download of CSS files in IE7 and 8 (see
	 * 				http://www.stevesouders.com/blog/2010/02/10/5a-missing-schema-double-download/), so use this
	 * 				feature if you don't care about those browsers.
	 *
	 * 		- internal: a 'local' stylesheet, meaning it's contained within the same domain as the site.
	 * 				The path to the CSS directory will automatically be prefixed on $data. You only need
	 * 				to supply the file's name, not the path, or extension, assuming you file is within $this->config['css_path']
	 *
	 * 		- include: a file containing styling that will be pulled in and embedded in the page. This type assumes
	 * 				your file is held within view directory, and will be loaded in as a view, so you only need to include
	 * 				the path relative to the view directory. The file should end with .php. Items of this type do not have their
	 * 				content 'pulled in' until the get_css() method is called.
	 *
	 * 		- embed: styling that will be embedded on the page. the get_css() method will automatically wrap
	 * 				all of the embedded content within a style tag. This is the default type.
	 *
	 * @param string $ext An override for the stylesheet extension. Defaults to '.css'. This is ignored if $type is
	 * 			set to 'include'.
	 *
	 * @return void
	 *
	 */

	public function css($data, $type = 'embed', $ext = '.css')
	{
		settype($data, 'array');	# Cannot use type casting below, so need change the string's type.

		if ($type != 'embed')
		{
			foreach ($data as $key => $location)
			{
				# Append cache version
				if ($this->get_config('include_cache_version') && $type != 'include' && $type != 'external')
					$data[$key] .= '.' . $this->config['cache_version'];

				# Convert external URLs to protocol-relative URLs
				if ($type == 'external' && $this->get_config('convert_external_urls'))
					$data[$key] = preg_replace('/^https?:\/\//i', '//', $location);

				# Add externsion
				$data[$key] .= $ext;
			}
		}

		# Add to CSS type array
		$this->css[$type] = array_merge($this->css[$type], $data);
	}


	/**
	 * Clear CSS
	 *
	 * Clears the CSS array of data. Can clear the entire array, or a specific CSS types.
	 *
	 * @since 0.1.0
	 *
	 * @author Kevin Wood-Friend
	 *
	 * @param string|array $type The type of CSS item to clear. If NULL, all items are cleared.
	 *
	 * @return void
	 *
	 */

	public function clear_css($type = NULL)
	{
		# When $type is NULL, clear everything
		if ($type === NULL)
		{
			$this->css['external'] = array();
			$this->css['link'] = array();
			$this->css['include'] = array();
			$this->css['embed'] = array();

			return;
		}

		foreach ((array) $type as $item_type)
		{
			if (array_key_exists($item_type, $this->css))
				$this->css[$item_type] = array();
		}
	}


	/**
	 * Render CSS
	 *
	 * Returns a string with all of the CSS stylesheets and embedded styles.
	 *
	 * @since 0.1.0
	 *
	 * @author Kevin Wood-Friend
	 *
	 * @return string
	 *
	 */

	public function get_css()
	{
		$return = NULL;

		foreach ($this->css['external'] as $href)
		{
			$return .= '<link type="text/css rel="stylesheet" href="' . $href . '"></script>';
		}

		foreach ($this->css['internal'] as $href)
		{
			$return .= '<link type="text/css" rel="stylesheet" href="' . $this->get_config('css_path') . $href . '" />';
		}

		foreach ($this->css['include'] as $include)
		{
			$return .= $this->CI->load->view($include, NULL, TRUE);
		}

		if ( ! empty($this->css['embed']))
		{
			$return .= '<style>' . implode("\n", $this->css['embed']) . '</style>';
		}

		return $return;
	}


	/**
	 * Set JavaScript items
	 *
	 * Adds a JavaScript (JS) item to the JS array.
	 *
	 * @since 0.1.0
	 *
	 * @author Kevin Wood-Friend
	 *
	 * @param string|array $data Either a string or array of data to be inserted in the JS $type array.
	 *
	 * @param string $type What type of JS items are being added. Can be external, internal, include, or embed.
	 *
	 * 		- external: a script that is not contain on the same domain as the site. For example,
	 * 				a script on a CDN or subdomain. $data should be a string (or array) of the script's URL.
	 * 				When using the external type, $this->config['convert_external_urls'] is used as a flag to control whether
	 * 				$data is automatically stripped of 'http:' or 'https:' and replaced with a protocol-relative URL.
	 *
	 * 		- internal: a 'local' script, meaning it's contained within the same domain as the site.
	 * 				The path to the JS directory will automatically be prefixed on $data. You only need
	 * 				to supply the file's name, not the path, or extension, assuming your script is in $this->config['js_path']
	 *
	 * 		- include: a file containing JS that will be pulled in and embedded in the page. This type assumes
	 * 				your file is held within view directory, and will be loaded in as a view, so you only need to include
	 * 				the path relative to the view directory. The file should end in .php. Items of this type do not have their
	 * 				content 'pulled in' until the get_js() method is called.
	 *
	 * 		- embed: JS that will be embedded on the page. the get_js() method will automatically wrap
	 * 				all of the embedded content within a script tag. This is the default type.
	 *
	 * @param string $ext An override for the JavaScript extension. Defaults to '.js'. This is ignored if $type is
	 * 			set to 'include'.
	 *
	 * @return void
	 *
	 */

	public function js($data, $type = 'embed', $ext = '.js')
	{
		settype($data, 'array');	# Cannot use type casting below, so need change the string's type.

		if ($type != 'embed')
		{
			foreach ($data as $key => $location)
			{
				# Append cache version
				if ($this->get_config('include_cache_version') && $type != 'include' && $type != 'external')
					$data[$key] .= '.' . $this->config['cache_version'];

				# Convert external URLs to protocol-relative URLs
				if ($type == 'external' && $this->get_config('convert_external_urls'))
					$data[$key] = preg_replace('/^https?:\/\//i', '//', $location);

				# Add extension
				$data[$key] .= $ext;
			}
		}

		# Add to JS type array
		$this->js[$type] = array_merge($this->js[$type], $data);
	}


	/**
	 * Clear JavaScript
	 *
	 * Clears the JavaScript (JS) array of data. Can clear the entire array, or a specific JS type.
	 *
	 * @since 0.1.0
	 *
	 * @author Kevin Wood-Friend
	 *
	 * @param string|array $type The type of JS item to clear. If NULL, all items are cleared.
	 *
	 * @return void
	 *
	 */

	public function clear_js($type = NULL)
	{
		# When $type is NULL, clear everything
		if ($type === NULL)
		{
			$this->js['external'] = array();
			$this->js['link'] = array();
			$this->js['include'] = array();
			$this->js['embed'] = array();

			return;
		}

		foreach ((array) $type as $item_type)
		{
			if (array_key_exists($item_type, $this->js))
				$this->js[$item_type] = array();
		}
	}


	/**
	 * Render JavaScript
	 *
	 * Returns a string with all of the JavaScript related tags and content.
	 *
	 * @since 0.1.0
	 *
	 * @author Kevin Wood-Friend
	 *
	 * @return string
	 *
	 */

	public function get_js()
	{
		$return = NULL;

		foreach ($this->js['external'] as $src)
		{
			$return .= '<script src="' . $src . '"></script>';	# type attribute is no longer needed in HTML5
		}

		foreach ($this->js['internal'] as $src)
		{
			$return .= '<script src="' . $this->get_config('js_path') . $src . '"></script>';	# type attribute is no longer needed in HTML5
		}

		foreach ($this->js['include'] as $include)
		{
			$return .= $this->CI->load->view($include, NULL, TRUE);
		}

		if ( ! empty($this->js['embed']))
		{
			$return .= '<script>' . implode("\n", $this->js['embed']) . '</script>';
		}

		return $return;
	}


	/**
	 * Set message
	 *
	 * Adds an notice, warning, or error message to the messages array.
	 *
	 * @since 0.1.0
	 *
	 * @author Kevin Wood-Friend
	 *
	 * @param string $type What type of message. Either 'notices', 'warnings', or 'errors'. If singular form of type is given, it will
	 * 		automatically be pluralized.
	 *
	 * @param string|array $message The message(s) to add to the corresponding messages array.
	 *
	 */

	public function message($type, $message = NULL)
	{
		if (empty($type))
			return;

		# Pluralize type, if singular
		if (substr($type, -1) != 's')
			$type .= 's';

		$this->messages[$type] = array_merge($this->messages[$type], (array) $message);
	}


	/**
	 * Clear message
	 *
	 * Clears the messages array of data. Can clear the entire array, or the specific type.
	 *
	 * @since 0.1.0
	 *
	 * @author Kevin Wood-Friend
	 *
	 * @param string|array $type The type of message item to clear. If NULL, all items are cleared. If singular form of type is
	 * 		given, it will automatically be pluralized.
	 *
	 * @return void
	 *
	 */

	public function clear_message($type = NULL)
	{
		# When $type is NULL, clear everything
		if ($type === NULL)
		{
			$this->js['notices'] = array();
			$this->js['warnings'] = array();
			$this->js['errors'] = array();

			return;
		}

		foreach ((array) $type as $item_type)
		{
			# Pluralize type, if singular
			if (substr($item_type, -1) != 's')
				$item_type .= 's';

			if (array_key_exists($item_type, $this->messages))
				$this->messages[$item_type] = array();
		}
	}


	/**
	 * Return messages string
	 *
	 * Returns a string containing all of the notices, warnings, and errors. Each message type is
	 * wrapped within a classed div tag, with all messages are wrapped in a single div tag.
	 *
	 * @since 0.1.0
	 *
	 * @author Kevin Wood-Friend
	 *
	 * @return string
	 *
	 */

	public function get_messages()
	{
		$return = NULL;

		if ( ! empty($this->messages['errors']))
		{
			$return .= '<div class="errors">';

			foreach ($this->messages['errors'] as $msg)
			{
				$return .= "<p>{$msg}</p>";
			}

			$return .= '</div>';
		}

		if ( ! empty($this->messages['warnings']))
		{
			$return .= '<div class="warnings">';

			foreach ($this->messages['warnings'] as $msg)
			{
				$return .= "<p>{$msg}</p>";
			}

			$return .= '</div>';
		}

		if ( ! empty($this->messages['notices']))
		{
			$return .= '<div class="notices">';

			foreach ($this->messages['notices'] as $msg)
			{
				$return .= "<p>{$msg}</p>";
			}

			$return .= '</div>';
		}

		if ($return !== NULL)
			return '<div id="messages">' . $return . '</div>';

		return NULL;
	}


	/**
	 * Render Layout
	 *
	 * Renders the layout
	 *
	 * @since 0.1.0
	 *
	 * @author Kevin Wood-Friend
	 *
	 * @param string $path An overwrite path to an alternate layout file. Useful when you need to display a different layout
	 * 			but do not want to alter the layout config item.
	 *
	 * @param bool $buffer Whether to enable output buffering.
	 *
	 * @return void
	 *
	 */

	public function render($path = NULL, $buffer = TRUE)
	{
		if ($buffer)
			ob_start();

		if ($path)
			require($path);

		else
			require($this->config['layout_path'] . $this->config['layout'] . '.php');

		if ($buffer)
			ob_end_flush();
	}
}


# EOF