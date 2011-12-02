<?php

/**
 * Debug Helper
 * 
 * Useful functions for debugging and outputting information.
 * 
 * @version 0.1.0
 * 
 * @author Kevin Wood-Friend
 * 
 */

/**
 * Array dump function
 * 
 * Dumps (echos) an array's contents, wrapped in a <pre> tag.
 * 
 * @since 0.1.0
 * 
 * @author Kevin Wood-Friend
 * 
 * @param array $array Array whose contents will be "dumped"
 * 
 * @return void
 *
 */

function dump($array) 
{
	ob_start();
	
	print_r($array);
	
	echo '<pre>' . ob_get_clean() . '</pre>';
}


/**
 * Puts function
 * 
 * Just like Ruby's "puts" construct, but for PHP!
 * 
 * Will take in either an int, string, or array, and output it's contents.
 * 
 * If running PHP in CLI, this function will tack on a new line at the end of the given data. Otherwise,
 * it will tack on a <br /> tag at the end. It will also wrap an array's contents win a <pre> tag, when
 * not executing in CLI.
 * 
 * When $separate is TRUE, the output will include separators, either a string of hyphens in CLI, or an <hr /> tag.
 * 
 * @since 0.1.0
 * 
 * @author Kevin Wood-Friend
 * 
 * @param int|string|array $data The data that will be outputted
 * @param bool $separate Flag to turn separation on or off
 * 
 * @return void
 * 
 */

function puts($data, $separate = FALSE)
{
	ob_start();
	
	if (PHP_SAPI == 'cli')
	{
		$separator = "----------------------------------------\n";
		$brk = "\n";
	}
	
	else
	{
		$separator = '<hr />';
		$brk = '<br />';
	}
	
	if ($separate) echo $separator;
	
	if (is_string($data) OR is_numeric($data)) echo $data . $brk;
	
	elseif (is_array($data) OR is_object($data))
	{
		if (PHP_SAPI != 'cli') echo '<pre>';
		
		print_r($data);
		
		if (PHP_SAPI != 'cli') echo '</pre>';
	}
	
	if ($separate) echo $separator;
	
	ob_end_flush();
}


/**
 * Inspect function
 * 
 * Takes in a variable and attempts to return it's name and value.
 * 
 * Original Code: http://stackoverflow.com/questions/255312/how-to-get-a-variable-name-as-a-string-in-php#answer-2414745
 * 
 * Modified for
 * - Better syntax, changed to CodeIgniter syntax
 * - More robustness
 * - Cleaned up code and removed unneeded code
 * - Cleaned up comments a bit and put this PHPdoc block
 * 
 * @since 0.1.0
 * 
 * @author Sebastián Grignoli
 * @author (Additions) Kevin Wood-Friend
 * 
 * @param mixed $label The variable to be inspected
 * 
 * @return void
 * 
 */

function inspect($data)
{
	$bt = debug_backtrace();
	
	$src = file($bt[0]["file"]);
	
	$line = $src[$bt[0]['line'] - 1];

	# let's match the function call and the last closing bracket
	preg_match("#inspect\((.+)\)#", $line, $match);

	/* 
		let's count brackets to see how many of them actually belongs 
		to the var name
		Eg: die(inspect($this->getUser()->hasCredential("delete")));
			We want: $this->getUser()->hasCredential("delete")
	*/

	$max = strlen($match[1]);
	
	$varname = NULL;
	
	$c = 0;

	for ($i = 0; $i < $max; $i++)
	{
		if ($match[1]{$i} == "(" ) $c++;

		elseif ($match[1]{$i} == ")" ) $c--;

		if ($c < 0) break;

		$varname .= $match[1]{$i};
	}

	/* 
		$label now holds the name of the passed variable ($ included)
		Eg: inspect($hello) 
		 => $label = "$hello"
		or the whole expression evaluated
		Eg: inspect($this->getUser()->hasCredential("delete"))
		 => $label = "$this->getUser()->hasCredential(\"delete\")"
	

		now the actual function call to the inspector method, 
		passing the var name as the label:

 		return dInspect::dump($label, $val);
 		UPDATE: I commented this line because people got confused about 
 		the dInspect class, wich has nothing to do with the issue here.
	*/

	ob_start();

	echo $varname . ' = ';
	
	# If $data is an array, dump it's contents
	if (is_array($data) OR is_object($data))
	{
		echo '<pre>';
	
		var_dump($data);
	
		echo '</pre>';
		
		return;
	}
	
	# If $data is a string or int, echo it's valua
	if (is_string($data) OR is_int($data))
	{
		echo htmlspecialchars($data);
		
		return;
	}
	
	# If $data is TRUE or FALSE, echo special string
	if (is_bool($data) && $data)
		echo 'bool TRUE';
		
	elseif (is_bool($data))
		echo 'bool FALSE';
		
	ob_end_flush();
}


# EOF