<?php

/**
 * Debug Helper
 * 
 * Useful functions for debugging and outputting information.
 * 
 * @version 0.1.3
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
 * @param array $array Array whose contents will be "dumped."
 * 
 * @return void
 *
 */

function dump($array) 
{
	ob_start();
	
	print_r($array);
	
	$output = trim(ob_get_clean());

	if (PHP_SAPI == 'cli')
	{	
		echo $output . PHP_EOL . PHP_EOL;
		
		return;
	}
	
	echo PHP_EOL . '<pre>' . PHP_EOL . $output . PHP_EOL . '</pre>' . PHP_EOL;
}


/**
 * Puts function
 * 
 * Just like Ruby's "puts" construct, but for PHP!
 * 
 * Will take in either an int, string, or array, and output it's contents, followed 
 * by either a new line, or <br />.
 * 
 * If running PHP in CLI, this function will tack on a new line at the end of the given data. 
 * 
 * Otherwise, it will tack on a <br /> tag at the end and wrap an array's contents with a <pre> tag.
 * 
 * When $separate is TRUE, the output will include separators, either a string of hyphens in CLI, or 
 * an <hr /> tag. Useful when you use multiple puts() in a row.
 * 
 * @since 0.1.0
 * 
 * @author Kevin Wood-Friend
 * 
 * @param int|string|array $data The data that will be outputted.
 * 
 * @param bool $separate Flag to turn separation on or off.
 * 
 * @return void
 * 
 */

function puts($data, $separate = FALSE)
{	
	$separator = NULL;
	
	if ($separate)
	{
		$separator = '<hr />';
		
		if (PHP_SAPI == 'cli')
			$separator = '----------------------------------------';
			
	}
	
	if (is_string($data) OR is_numeric($data))
		echo $data . PHP_EOL . $separator . PHP_EOL . PHP_EOL;
	
	else
	{
		
		ob_start();

		print_r($data);
		
		$output = trim(ob_get_clean());
		
		if (PHP_SAPI == 'cli')
			echo $output . PHP_EOL . $separator . PHP_EOL . PHP_EOL;
		
		else
			echo PHP_EOL . '<pre>' . PHP_EOL . $output . PHP_EOL . '</pre>' . PHP_EOL . $separator . PHP_EOL . PHP_EOL;
	}
}


/**
 * Inspect function
 * 
 * Takes in a variable and attempts to return it's name and value.
 * 
 * Original Code: http://stackoverflow.com/questions/255312/how-to-get-a-variable-name-as-a-string-in-php#answer-2414745
 * 
 * Modified for
 * - Better coding style. Changed to CodeIgniter's style.
 * - More robustness.
 * - Cleaned up code and removed unneeded code.
 * - Cleaned up comments a bit and put this PHPdoc block.
 * 
 * @since 0.1.0
 * 
 * @author Sebastián Grignoli
 * 
 * @author (Additions) Kevin Wood-Friend
 * 
 * @param mixed $label The variable to be inspected.
 * 
 * @return void
 * 
 */

function inspect($data)
{
	$bt = debug_backtrace();
	
	$src = file($bt[0]["file"]);
	
	$line = $src[$bt[0]['line'] - 1];

	# Match the function call and the last closing bracket
	preg_match("#inspect\((.+)\)#", $line, $match);

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

	ob_start();
	
	var_dump($data);
	
	$output = trim(ob_get_clean());
	
	if (PHP_SAPI == 'cli')
	{
		echo $output . PHP_EOL . PHP_EOL;
		
		return;
	}
	
	echo PHP_EOL . '<pre>' . PHP_EOL . $varname . ' = ' . $output . PHP_EOL . '</pre>' . PHP_EOL . PHP_EOL;
}


# EOF