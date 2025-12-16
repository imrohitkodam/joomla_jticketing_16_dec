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
use Joomla\CMS\Factory;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\MVC\Controller\BaseController;

// Define directory separator
if (!defined('DS'))
{
	define('DS', DIRECTORY_SEPARATOR);
}

// Require the base controller
// Joomla 6: JPATH_ADMINISTRATOR . "/components/com_jticketing" removed - use JPATH_ADMINISTRATOR or JPATH_SITE instead
		require_once (defined('JPATH_ADMINISTRATOR') ? JPATH_ADMINISTRATOR : JPATH_SITE) . '/components/com_jticketing . '/controller.php';
// Joomla 6: JPATH_ADMINISTRATOR . "/components/com_jticketing" removed - use JPATH_ADMINISTRATOR or JPATH_SITE instead
		require_once (defined('JPATH_ADMINISTRATOR') ? JPATH_ADMINISTRATOR : JPATH_SITE) . '/components/com_jticketing . '/helpers/main.php';
// Joomla 6: JPATH_ADMINISTRATOR . "/components/com_jticketing" removed - use JPATH_ADMINISTRATOR or JPATH_SITE instead
		require_once (defined('JPATH_ADMINISTRATOR') ? JPATH_ADMINISTRATOR : JPATH_SITE) . '/components/com_jticketing . '/helpers/common.php';

$document   = Factory::getDocument();
$root_url   = Uri::root();

// Load comman language file.
$lang = Factory::getLanguage();
$lang->load('com_jticketing_common', JPATH_SITE, $lang->getTag(), true);

// Load various helpers
$path                     = JPATH_ROOT . '/components/com_jticketing/helpers/main.php';
$jticketingfrontendhelper = JPATH_ROOT . '/components/com_jticketing/helpers/frontendhelper.php';
$JTicketingIntegrationsHelperPath   = JPATH_ROOT . '/components/com_jticketing/helpers/integrations.php';
$helperPath               = JPATH_SITE . '/components/com_jticketing/helpers/event.php';
$mediaHelperPath          = JPATH_SITE . '/components/com_jticketing/helpers/media.php';
$field_manager_path       = JPATH_SITE . '/components/com_tjfields/helpers/tjfields.php';
$JTRouteHelper            = JPATH_SITE . '/components/com_jticketing/helpers/route.php';

$JticketingCommonHelper = JPATH_SITE . '/components/com_jticketing/helpers/common.php';

$document->addScriptDeclaration('var jtRootURL= "' . $root_url . '";');

if (!class_exists('JticketingCommonHelper'))
{
	// Joomla 6: JLoader removed
	// Joomla 6: JLoader removed
}

if (!class_exists('jticketingmainhelper'))
{
	// Joomla 6: JLoader removed
	// Joomla 6: JLoader removed
}

if (!class_exists('jticketingfrontendhelper'))
{
	// Joomla 6: JLoader removed
	// Joomla 6: JLoader removed
}

if (!class_exists('JTicketingIntegrationsHelper'))
{
	// Joomla 6: JLoader removed
	// Joomla 6: JLoader removed
}

if (!class_exists('jteventHelper'))
{
	// Joomla 6: JLoader removed
	// Joomla 6: JLoader removed
}

if (file_exists($field_manager_path))
{
	if (!class_exists('TjfieldsHelper'))
	{
		// Joomla 6: JLoader removed
		// Joomla 6: JLoader removed
	}
}

if (!class_exists('jticketingMediaHelper'))
{
	// Joomla 6: JLoader removed
	// Joomla 6: JLoader removed
}

if (!class_exists('JTRouteHelper'))
{
	// Joomla 6: JLoader removed
	// Joomla 6: JLoader removed
}

include_once  JPATH_SITE . '/components/com_jticketing/includes/jticketing.php';
JT::init();
$config = JT::config();

$document->addScriptDeclaration('var jtRootURL= "' . $root_url . '";');
$document->addScriptDeclaration('var ga_ec_analytics= "' . $config->get('ga_ec_analytics') . '";');
$document->addScriptDeclaration('var track_attendee_step= "' . $config->get('track_attendee_step') . '";');

JT::utilities()->loadjticketingAssetFiles();

// Load Global language constants to in .js file
$JticketingCommonHelper = new JticketingCommonHelper;
$JticketingCommonHelper->getLanguageConstant();

if (!defined('JTICKETING_LOAD_BOOTSTRAP_VERSION'))
{
	if (Factory::getApplication()->isClient("administrator"))
	{
		$bsVersion = (JVERSION >= '4.0.0') ? 'bs5' : 'bs3';
	}
	else
	{
		$bsVersion = $config->get('bootstrap_version', '', 'STRING');

		if (empty($bsVersion))
		{
			$bsVersion = (JVERSION >= '4.0.0') ? 'bs5' : 'bs3';
		}
	}

	define('JTICKETING_LOAD_BOOTSTRAP_VERSION', $bsVersion);
}

// Execute the task.
$controller = BaseController::getInstance('Jticketing');
$controller->execute(Factory::getApplication()->getInput()->get('task'));
$controller->redirect();
