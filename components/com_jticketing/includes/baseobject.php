<?php
/**
 * @package     JTicketing
 * @subpackage  com_jticketing
 *
 * @author      Techjoomla <extensions@techjoomla.com>
 * @copyright   Copyright (C) 2009 - 2025 Techjoomla. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die();

/**
 * Base object class for Joomla 6 compatibility
 * Replaces CMSObject which was removed in Joomla 6
 *
 * @since  5.1.1
 */
class JTicketingBaseObject extends \stdClass
{
	/**
	 * Error message
	 *
	 * @var    string
	 * @since  5.1.1
	 */
	protected $_error = null;

	/**
	 * Set an error message
	 *
	 * @param   string  $error  Error message
	 *
	 * @return  void
	 *
	 * @since   5.1.1
	 */
	public function setError($error)
	{
		$this->_error = $error;
	}

	/**
	 * Get the error message
	 *
	 * @return  string  Error message
	 *
	 * @since   5.1.1
	 */
	public function getError()
	{
		return $this->_error;
	}

	/**
	 * Set object properties
	 *
	 * @param   mixed  $properties  Either an associative array or another object.
	 *
	 * @return  boolean
	 *
	 * @since   5.1.1
	 */
	public function setProperties($properties)
	{
		if (is_array($properties) || is_object($properties))
		{
			foreach ((array) $properties as $k => $v)
			{
				$this->$k = $v;
			}

			return true;
		}

		return false;
	}

	/**
	 * Get object properties
	 *
	 * @param   boolean  $public  If true, returns only the public properties
	 *
	 * @return  array
	 *
	 * @since   5.1.1
	 */
	public function getProperties($public = true)
	{
		$vars = get_object_vars($this);

		if ($public)
		{
			foreach ($vars as $key => $value)
			{
				if ('_' == substr($key, 0, 1))
				{
					unset($vars[$key]);
				}
			}
		}

		return $vars;
	}
}

