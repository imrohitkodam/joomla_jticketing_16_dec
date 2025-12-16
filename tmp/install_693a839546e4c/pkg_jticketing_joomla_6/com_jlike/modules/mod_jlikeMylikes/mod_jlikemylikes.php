<?php
/**
 * @version    SVN: <svn_id>
 * @package    Jlike
 * @author     Techjoomla <extensions@techjoomla.com>
 * @copyright  Copyright (c) 2009-2015 TechJoomla. All rights reserved.
 * @license    GNU General Public License version 2 or later.
 */

// No direct access.
defined('_JEXEC') or die();
use Joomla\Filesystem\File;
use Joomla\CMS\Factory;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Helper\ModuleHelper;

if (!defined('DS'))
{
	define('DS', '/');
}

if (File::exists(JPATH_SITE . '/components/com_jlike/jlike.php'))
{
	$path = JPATH_SITE . DS . 'components' . DS . 'com_jlike' . DS . 'helper.php';

	if (!class_exists('comjlikeHelper'))
	{
		if (file_exists($path)) {
			require_once $path;
		}
	}

	$comjlikeHelper = new comjlikeHelper;

	$doc = Factory::getDocument();
	$lang = Factory::getLanguage();
	$lang->load('mod_jlikemylikes', JPATH_SITE);
	$user = Factory::getUser();

	PluginHelper::importPlugin('system');
	$result = Factory::getApplication()->triggerEvent('onBeforeMylikesRendor_Mod');

	if (!empty($result))
	{
		// @Todo Handle case : if more than one system plugin called this trigger.
		$beforeModDis = $result[0];
	}

	// Trigger onAfterCartModule
	PluginHelper::importPlugin('system');
	$result = Factory::getApplication()->triggerEvent('onAfterMylikesRendor_Mod');

	if (!empty($result))
	{
		// @Todo Handle case : if more than one system plugin called this trigger.
		$afterModDis = $result[0];
	}

	$likeCount = $params->get('likeCount', 0);
	$likeList = $comjlikeHelper->getUserLikeDetail($user->id, $likeCount);

	// Hide mod when cart is empty.
	if ($params->get('DontshowAndMsgWhenEmpty', 0) == 1)
	{
		if (empty($likeList))
		{
			return;
		}
	}

	if (version_compare(JVERSION, '3.0', 'lt'))
	{
		// Define wrapper class
		if (!defined('JLIKE_WRAPPER_CLASS'))
		{
			define('JLIKE_WRAPPER_CLASS', "jlike-wrapper techjoomla-bootstrap");
		}
	}
	else
	{
		// Define wrapper class
		if (!defined('JLIKE_WRAPPER_CLASS'))
		{
			define('JLIKE_WRAPPER_CLASS', "jlike-wrapper");
		}

		// Bootstrap tooltip and chosen js
		HTMLHelper::_('bootstrap.tooltip');
		HTMLHelper::_('behavior.multiselect');
	}

	require ModuleHelper::getLayoutPath('mod_jlikemylikes');
}
