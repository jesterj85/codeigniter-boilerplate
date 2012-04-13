<?php

/**
 * Kindling Library
 *
 * A simple layout engine for CodeIgniter.
 *
 * @version  0.1.5
 *
 * @author  Kevin Wood-Friend
 *
 */

class Kindling {

	protected $config = array(

		'message_prefix' => '<p>',
		'message_suffix' => '</p>',
		'message_type_prefix' => '<div class="%s">',
		'message_type_suffix' => '</div>',
		'messages_container_prefix' => '<div class="messages">',
		'messages_container_suffix' => '</div>'

	);

	protected $content = array();

	protected $meta = array();

	protected $css = array(

		'external' => array(),
		'internal' => array(),
		'include' => array(),
		'embed' => array()

	);

	protected $js = array(

		'external' => array(),
		'internal' => array(),
		'include' => array(),
		'embed' => array(),
		'ready' => array()

	);

	# Default messages types
	protected $messages = array(

		'error' => array(),
		'warning' => array(),
		'notice' => array(),
		'debug' => array()

	);


	/**
	 * Constructor
	 *
	 * @param  array $config Configuration array to be merged with the Kindling class's configuration file
	 *
	 * @return  void
	 *
	 */

	public function __construct($config = array())
	{
		$this->ci =& get_instance();

		$user_config = array();

		$this->ci->config->load('kindling', FALSE, TRUE);

		$user_config = $this->ci->config->item('kindling');

		if ( ! $user_config)
			$user_config = array();

		# Merge $config and configuration file
		$this->config = array_merge($this->config, $config, $user_config);

		# Load URL helper for its _parse_attributes() helper
		$this->ci->load->helper('url');
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
	 * @since  0.1.0
	 *
	 * @author  Kevin Wood-Friend
	 *
	 * @param  string|array $item A key name or array of items to add to the config array.
	 *
	 * @param  mixed $value The corresponding value for $item.
	 *
	 * @return  void
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
	 * @since  0.1.0
	 *
	 * @author  Kevin Wood-Friend
	 *
	 * @param  mixed $item The item(s) to unset from the config array.
	 *
	 * @return  void
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
	 * @since  0.1.0
	 *
	 * @author  Kevin Wood-Friend
	 *
	 * @return  void
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
	 * @since  0.1.0
	 *
	 * @author  Kevin Wood-Friend
	 *
	 * @param  string|array|NULL $item The item(s) requested from the config array. If NULL,
	 * 			the entire config array will be returned.
	 *
	 * @param  mixed $default An optional value to return if the item does not exist in the config array.
	 * This parameter is not used when $item is an array.
	 *
	 * @return  mixed
	 *
	 */

	public function get_config($item = NULL, $default = FALSE)
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
	 * @since  0.1.0
	 *
	 * @author  Kevin Wood-Friend
	 *
	 * @param  string|array $item Either a string with the key of the content item to set, or a key-value
	 * array, where the key will become the content item's name, and the value will become the item's value.
	 *
	 * @param  mixed $value The value to be assigned when $item is a string. If $item is not a string, $value is ignored.
	 *
	 * @return  void
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
	 * @since  0.1.0
	 *
	 * @author  Kevin Wood-Friend
	 *
	 * @param  string|array $item The item(s) to unset from the content array.
	 *
	 * @return  void
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
	 * @since  0.1.0
	 *
	 * @author  Kevin Wood-Friend
	 *
	 * @return  void
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
	 * @since  0.1.0
	 *
	 * @author  Kevin Wood-Friend
	 *
	 * @param  string|array|NULL $item The item(s) requested from the content array. If NULL,
	 * the entire content array will be returned.
	 *
	 * @param  mixed $default An optional value to return if the item does not exist in the content array.
	 * This parameter is ignored when $item is an array.
	 *
	 * @param  bool $convert_chars Whether to run the returned content through htmlspecialchars()
	 *
	 * @return  mixed
	 *
	 */

	public function get_content($item = NULL, $default = FALSE, $convert_chars = FALSE)
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
	 * @since  0.1.0
	 *
	 * @author  Kevin Wood-Friend
	 *
	 * @param  string|array $item Either a string with the name of the meta item to set, or a key-value
	 * array, where the key will become the meta tag's name attribute, and the value will become the content attribute.
	 *
	 * @param  string $value The value to be assigned when $item is a string. If $item is not a string, $value is ignored.
	 *
	 * @return  void
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
	 * @since  0.1.0
	 *
	 * @author  Kevin Wood-Friend
	 *
	 * @param  string|array $item The item(s) to unset from the meta array.
	 *
	 * @return  void
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
	 * @since  0.1.0
	 *
	 * @author  Kevin Wood-Friend
	 *
	 * @return  void
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
	 * @since  0.1.0
	 *
	 * @author  Kevin Wood-Friend
	 *
	 * @return  A string of meta tags.
	 *
	 */

	public function get_meta()
	{
		$return = NULL;

		foreach ($this->meta as $name => $content)
		{
			$attributes = array(

				'name' => htmlspecialchars($name),
				'content' => htmlspecialchars($content)

			);

			$return .= '<meta' . _parse_attributes($attributes) . ' />';
		}

		return $return;
	}


	/**
	 * Return "raw" meta tags
	 *
	 * Returns a hash of meta tag names and values.
	 *
	 * @since  0.1.2
	 *
	 * @author  Kevin Wood-Friend
	 *
	 * @param  string|null $item The meta item $item to return. A value of NULL will return the entire meta array.
	 *
	 * @return  array Either a hash of meta tag names and values, or a string for the meta item $item. Returns NULL
	 * if $item does not exist in the meta array.
	 *
	 */

	public function get_raw_meta($item = NULL)
	{
		if ($item === NULL)
			return $this->meta;

		if (array_key_exists($item, $this->meta))
			return $this->meta[$item];

		return NULL;
	}


	/**
	 * Set CSS items
	 *
	 * Adds a CSS item to the CSS array.
	 *
	 * @since  0.1.0
	 *
	 * @author  Kevin Wood-Friend
	 *
	 * @param  string|array $data Either a string, or array, of data to be inserted in the CSS $type array.
	 *
	 * @param  string $type What type of CSS items are being added. Can be external, internal, include, or embed.
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
	 * 				to supply the file's name, not the path, or extension, assuming you file is within $this->config['css_uri']
	 *
	 * 		- include: a file containing styling that will be pulled in and embedded in the page. This type assumes
	 * 				your file is held within view directory, and will be loaded in as a view, so you only need to include
	 * 				the path relative to the view directory. The file should end with .php. Items of this type do not have their
	 * 				content 'pulled in' until the get_css() method is called.
	 *
	 * 		- embed: styling that will be embedded on the page. the get_css() method will automatically wrap
	 * 				all of the embedded content within a style tag. This is the default type.
	 *
	 * @param  bool|null $append_cache_version Whether to override the 'append_cache_version' config item.
	 * TRUE will append, FALSE will not, and NULL will default to 'append_cache_version'.
	 *
	 * @param  string $ext An override for the stylesheet extension. Defaults to '.css'. This is ignored if $type is
	 * set to 'include'.
	 *
	 * @return  void
	 *
	 */

	public function css($data, $type = 'embed', $append_cache_version = NULL, $ext = '.css')
	{
		if ($append_cache_version === NULL)
			$append_cache_version = $this->get_config('append_cache_version');

		settype($data, 'array');	# Cannot use type casting below, so need change the string's type.

		if ($type != 'embed')
		{
			foreach ($data as $key => $location)
			{
				# Append cache version
				if ($append_cache_version && $type != 'include' && $type != 'external')
					$data[$key] .= '.' . $this->config['cache_version'];

				# Convert external URLs to protocol-relative URLs
				if ($type == 'external' && $this->get_config('convert_external_urls'))
					$data[$key] = preg_replace('/^https?:\/\//i', '//', $location);

				# Add extension
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
	 * @since  0.1.0
	 *
	 * @author  Kevin Wood-Friend
	 *
	 * @param  string|array $type The type of CSS item to clear. If NULL, all items are cleared.
	 *
	 * @return  void
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
	 * @since  0.1.0
	 *
	 * @author  Kevin Wood-Friend
	 *
	 * @return  string
	 *
	 */

	public function get_css()
	{
		$return = '';

		$attributes = array(

			'type' => 'text/css',
			'rel' => 'stylesheet'

		);

		foreach ($this->css['external'] as $href)
		{
			$attributes['href'] = $href;

			$return .= '<link' . _parse_attributes($attributes) . ' />';

			unset($attributes['href']);
		}

		foreach ($this->css['internal'] as $href)
		{
			$attributes['href'] = $this->get_config('css_uri') . $href;

			$return .= '<link' . _parse_attributes($attributes) . ' />';

			unset($attributes['href']);
		}

		foreach ($this->css['include'] as $include)
		{
			$return .= $this->ci->load->view($include, NULL, TRUE);
		}

		if ( ! empty($this->css['embed']))
		{
			$return .= '<style>' . implode("\n", $this->css['embed']) . '</style>';
		}

		return $return;
	}


	/**
	 * Return "raw" CSS
	 *
	 * Returns either an array of CSS types and their data, or an array
	 * of CSS for a specific type.
	 *
	 * @since  0.1.2
	 *
	 * @author  Kevin Wood-Friend
	 *
	 * @param  string|null $type the type of CSS to return. If NULL, the entire CSS array
	 * will be returned.
	 *
	 * @return  array|bool Returns either an array of CSS types and their data, or an array of
	 * CSS of the type $type. Returns NULL if the request $type does not exist in the CSS array.
	 *
	 */

	public function get_raw_css($type = NULL)
	{
		if ($type === NULL)
			return $this->css;

		if (array_key_exists($type, $this->css))
			return $this->css[$type];

		return array();
	}


	/**
	 * Set JavaScript items
	 *
	 * Adds a JavaScript (JS) item to the JS array.
	 *
	 * @since  0.1.0
	 *
	 * @author  Kevin Wood-Friend
	 *
	 * @param  string|array $data Either a string or array of data to be inserted in the JS $type array.
	 *
	 * @param  string $type What type of JS items are being added. Can be external, internal, include, or embed.
	 *
	 * 		- external: a script that is not contain on the same domain as the site. For example,
	 * 				a script on a CDN or subdomain. $data should be a string (or array) of the script's URL.
	 * 				When using the external type, $this->config['convert_external_urls'] is used as a flag to control whether
	 * 				$data is automatically stripped of 'http:' or 'https:' and replaced with a protocol-relative URL.
	 *
	 * 		- internal: a 'local' script, meaning it's contained within the same domain as the site.
	 * 				The path to the JS directory will automatically be prefixed on $data. You only need
	 * 				to supply the file's name, not the path, or extension, assuming your script is in $this->config['js_uri']
	 *
	 * 		- include: a file containing JS that will be pulled in and embedded in the page. This type assumes
	 * 				your file is held within view directory, and will be loaded in as a view, so you only need to include
	 * 				the path relative to the view directory. The file should end in .php. Items of this type do not have their
	 * 				content 'pulled in' until the get_js() method is called.
	 *
	 * 		- embed: JS that will be embedded on the page. the get_js() method will automatically wrap
	 * 				all of the embedded content within a script tag. This is the default type.
	 *
	 * @param  bool|null $append_cache_version Whether to override the 'append_cache_version' config item.
	 * TRUE will append, FALSE will not, and NULL will default to 'append_cache_version'.
	 *
	 * @param  string $ext An override for the JavaScript extension. Defaults to '.js'. This is ignored if $type is
	 * set to 'include'.
	 *
	 * @return  void
	 *
	 */

	public function js($data, $type = 'embed', $append_cache_version = NULL, $ext = '.js')
	{
		if ($append_cache_version === NULL)
			$append_cache_version = $this->get_config('append_cache_version');

		settype($data, 'array');	# Cannot use type casting below, so need change the string's type.

		if ($type != 'embed')
		{
			foreach ($data as $key => $location)
			{
				# Append cache version
				if ($append_cache_version && $type != 'include' && $type != 'external')
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
	 * @since  0.1.0
	 *
	 * @author  Kevin Wood-Friend
	 *
	 * @param  string|array $type The type of JS item to clear. If NULL, all items are cleared.
	 *
	 * @return  void
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
	 * @since  0.1.0
	 *
	 * @author  Kevin Wood-Friend
	 *
	 * @return  string
	 *
	 */

	public function get_js()
	{
		$return = '';

		foreach ($this->js['external'] as $src)
		{
			$return .= '<script src="' . $src . '"></script>';	# type attribute is no longer needed in HTML5
		}

		foreach ($this->js['internal'] as $src)
		{
			$return .= '<script src="' . $this->get_config('js_uri') . $src . '"></script>';	# type attribute is no longer needed in HTML5
		}

		foreach ($this->js['include'] as $include)
		{
			$return .= $this->ci->load->view($include, NULL, TRUE);
		}

		if ( ! empty($this->js['embed']))
		{
			$return .= '<script>' . implode("\n", $this->js['embed']) . '</script>';
		}

		return $return;
	}


	/**
	 * Return "raw" JS
	 *
	 * Returns either an array of JS types and their data, or an array
	 * of JS for a specific type.
	 *
	 * @since  0.1.2
	 *
	 * @author  Kevin Wood-Friend
	 *
	 * @param  string|null $type the type of JS to return. If NULL, the entire JS array
	 * will be returned.
	 *
	 * @return  array|bool Returns either an array of JS types and their data, or an array of
	 * JS of the type $type. Returns NULL if the request $type does not exist in the JS array.
	 *
	 */

	public function get_raw_js($type = NULL)
	{
		if ($type === NULL)
			return $this->js;

		if (array_key_exists($type, $this->js))
			return $this->js[$type];

		return array();
	}


	/**
	 * Set message
	 *
	 * Adds a notice, warning, or error message to the messages array.
	 *
	 * @since  0.1.0
	 *
	 * @author  Kevin Wood-Friend
	 *
	 * @param  string $type The message type to set.
	 *
	 * @param  string|array $message The message(s) to add to the corresponding messages array.
	 *
	 */

	public function message($type, $message = NULL)
	{
		if (empty($type))
			return;

		# Set $type in messages if it doesn't exist. Prevents array_merge() from complaining.
		if ( ! isset($this->messages[$type]))
			$this->messages[$type] = array();

		$this->messages[$type] = array_merge($this->messages[$type], (array) $message);
	}


	/**
	 * Clear message
	 *
	 * Clears the messages array of data. Can clear the entire array, or the specific type.
	 *
	 * @since  0.1.0
	 *
	 * @author  Kevin Wood-Friend
	 *
	 * @param  string|array $type The type of message to clear.
	 *
	 * @return  void
	 *
	 */

	public function clear_message($type = NULL)
	{
		# When $type is NULL, clear everything
		if ($type === NULL)
		{
			$this->messages = array();

			return;
		}

		foreach ((array) $type as $item_type)
		{
			if (array_key_exists($item_type, $this->messages))
				$this->messages[$item_type] = array();
		}
	}


	/**
	 * Return messages string
	 *
	 * Returns a string containing all of the messages of $type. Each message type is
	 * wrapped within a classed div tag, with all messages are wrapped in a single div tag.
	 *
	 * @since  0.1.0
	 *
	 * @author  Kevin Wood-Friend
	 *
	 * @param  string|array|bool|null $types The type, or types of messages to be formatted and returned.
	 * if $type is NULL, then the messages types to display are gleaned from the 'displayed_messages' config
	 * item. If $type is TRUE, then all message will be formatted and returned.
	 *
	 * @return  string
	 *
	 */

	public function get_messages($types = NULL)
	{
		if ($types === TRUE)
			$types = array_keys($this->messages);

		elseif ($types === NULL)
			$types = $this->get_config('displayed_messages', array());

		$return = '';

		foreach ((array) $types as $type)
		{
			if ( ! empty($this->messages[$type]))
			{
				$return .= sprintf($this->get_config('message_type_prefix', ''), $type);

				foreach ($this->messages[$type] as $msg)
					$return .= 	sprintf($this->get_config('message_prefix', ''), $type) . $msg . $this->get_config('message_suffix', '');

				$return .= $this->get_config('message_type_suffix', '');
			}
		}

		if ($return !== '')
			return $this->get_config('messages_container_prefix') . $return . $this->get_config('messages_container_suffix');

		return '';
	}


	/**
	 * Return "raw" messages
	 *
	 * Returns either an array of message types and their messages, or an array
	 * of messages for a specific type of message.
	 *
	 * @since  0.1.2
	 *
	 * @author  Kevin Wood-Friend
	 *
	 * @param  string|null $type the type of message to return. If NULL, the entire messages array
	 * will be returned.
	 *
	 * @return  array|bool Returns either an array of message types and their messages, or an array of
	 * messages of the type $type. Returns NULL if the request $type does not exist in the messages array.
	 *
	 */

	public function get_raw_messages($type = NULL)
	{
		if ($type === NULL)
			return $this->messages;

		if (array_key_exists($type, $this->messages))
			return $this->messages[$type];

		return array();
	}


	/**
	 * Render Layout
	 *
	 * Renders the layout
	 *
	 * @since  0.1.0
	 *
	 * @author  Kevin Wood-Friend
	 *
	 * @param  array $content Additional content to insert into the content array
	 *
	 * @param  string $path An overwrite path to an alternate layout file. Useful when you need to display a different layout
	 * but do not want to alter the layout config item.
	 *
	 * @param  bool $buffer Whether to enable output buffering.
	 *
	 * @return  void|string
	 *
	 */

	public function render($content = NULL, $path = NULL, $return = FALSE)
	{
		if ($path === NULL)
			$path = $this->config['layout_path'] . $this->config['layout'] . '.php';

		if (is_array($content))
			$this->content($content);

		if ($this->get_config('layout_kindling_var'))
			$this->ci->load->vars(array($this->get_config('layout_kindling_var') => $this));

		$rendered = $this->ci->load->file($path, TRUE);

		if ($return)
			return $rendered;

		echo $rendered;
	}
}


# EOF