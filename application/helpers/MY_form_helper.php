<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Drop-down Menu
 *
 * @access	public
 * @param	mixed
 * @param	array
 * @param	string
 * @param	string
 * @return	string
 */
if ( ! function_exists('form_dropdown'))
{
	function form_dropdown($data = '', $options = array(), $selected = array(), $extra = '')
	{
		if ( ! is_array($data))
		{
			$data = array('name' => $data);
		}
		
		$defaults = array('name' => $data['name']);
		
		if ( ! is_array($selected))
		{
			$selected = array($selected);
		}

		// If no selected state was submitted we will attempt to set it automatically
		if (count($selected) === 0)
		{
			// If the form name appears in the $_POST array we have a winner!
			if (isset($_POST[$data['name']]))
			{
				$selected = array($_POST[$data['name']]);
			}
		}

		if ($extra != '') $extra = ' '.$extra;

		$multiple = (count($selected) > 1 && strpos($extra, 'multiple') === FALSE) ? ' multiple="multiple"' : '';

		$form = '<select '._parse_form_attributes($data, $defaults).$extra.$multiple.">\n";

		foreach ($options as $key => $val)
		{
			$key = (string) $key;

			if (is_array($val) && ! empty($val))
			{
				$form .= '<optgroup label="'.$key.'">'."\n";

				foreach ($val as $optgroup_key => $optgroup_val)
				{
					$sel = (in_array($optgroup_key, $selected)) ? ' selected="selected"' : '';

					$form .= '<option value="'.$optgroup_key.'"'.$sel.'>'.(string) $optgroup_val."</option>\n";
				}

				$form .= '</optgroup>'."\n";
			}
			else
			{
				$sel = (in_array($key, $selected)) ? ' selected="selected"' : '';

				$form .= '<option value="'.$key.'"'.$sel.'>'.(string) $val."</option>\n";
			}
		}

		$form .= '</select>';

		return $form;
	}
}


# EOF