<?php
defined ( '_JEXEC' ) or die ( 'Restricted access' );

use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\CMS\Factory;
use Joomla\CMS\Uri\Uri;

/**
 * @package		jLike
 * @author 		Techjoomla http://www.techjoomla.com
 * @copyright 	Copyright (C) 2011-2012 Techjoomla. All rights reserved.
 * @license 	GNU/GPL v2 http://www.gnu.org/licenses/gpl-2.0.html
 *
 */

class plgSystemjlike_sys_plugin extends CMSPlugin {

	public function onAfterRoute()
	{
		$document = Factory::getDocument();
		$app = Factory::getApplication();
		
		// Return if called from backend EXCEPT FOR INSTALLER
		if (!$app->isClient('site')) {
			return;
		}

		if (!defined('TJ_JLIKE_MULTI_LOAD')) {
			if (!defined('DS')) {
				define('DS', DIRECTORY_SEPARATOR);
			}

			$document->addScript(Uri::base() . 'components' . DS . 'com_jlike' . DS . 'assets' . DS . 'scripts' . DS . 'jquery-1.7.1.min.js');
			$document->addScript(Uri::base() . 'components' . DS . 'com_jlike' . DS . 'assets' . DS . 'scripts' . DS . 'jlike.js');
			$document->addStyleSheet(Uri::base() . 'components' . DS . 'com_jlike' . DS . 'assets' . DS . 'css' . DS . 'like.css');

			/* Bootstrap related */
			$strapperPath = JPATH_ROOT . DS . 'media' . DS . 'techjoomla_strapper' . DS . 'strapper.php';
			if (file_exists($strapperPath)) {
				include_once $strapperPath;
				if (class_exists('TjAkeebaStrapper')) {
					TjAkeebaStrapper::bootstrap();
				}
			}
			
			define('TJ_JLIKE_MULTI_LOAD', 1);
		}
	}
}
