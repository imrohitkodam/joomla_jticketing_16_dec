<?php
/**
 * @package     Jticketing.Plugin
 * @subpackage  Tjevents.microsoftteams
 *
 * @copyright   Copyright (C) 2009 - 2025 Techjoomla. All rights reserved.
 * @license     http:/www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// No direct access
defined('_JEXEC') or die('Restricted access');

use Firebase\JWT\JWT;
use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\CMS\Response\JsonResponse;
use Joomla\CMS\Session\Session;
use Joomla\CMS\Uri\Uri;
use Joomla\Registry\Registry;

JLoader::discover("JTicketingEvent", JPATH_PLUGINS . '/tjevents/microsoftteams/microsoftteams');
JLoader::discover("JTicketingEvent", JPATH_PLUGINS . '/tjevents/microsoftteams/vendor');
JLoader::registerNamespace('Microsoft', JPATH_PLUGINS.'/tjevents/microsoftteams/vendor/microsoft/microsoft-graph/src');
JLoader::registerNamespace('GuzzleHttp', JPATH_PLUGINS.'/tjevents/microsoftteams/vendor/guzzlehttp/guzzle/src');

/**
 * Class for microsoftteams Tjevents Plugin
 *
 * @since  3.0.0
 */
class PlgTjeventsMicrosoftteams extends CMSPlugin
{
	/**
	 * Load the language file on instantiation.
	 *
	 * @var    boolean
	 *
	 * @since  3.0.0
	 */
	protected $autoloadLanguage = true;

	/**
	 * Return the type of the plugin
	 *
	 * @return  array
	 *
	 * @since  3.0.0
	 */
	public function onJtGetContentInfo()
	{
		$obj = array();
		$obj['name'] = 'microsoftteams';
		$obj['id']   = $this->_name;

		return $obj;
	}
}
