<?php

/**
 * My Form Validation Library
 *
 * Adds additional functionality to the form validation class.
 *
 * @author  Kevin Wood-Friend
 *
 */

class MY_form_validation extends CI_Form_validation {

	/**
	 * All Errors
	 *
	 * Getter method for the $_error_array property.
	 *
	 * @author  Kevin Wood-Friend
	 *
	 * @return  array An array of errors.
	 *
	 */

	public function all_errors()
	{
		return $this->_error_array;
	}

}


# EOF