<?php
/**
 * @package     JTicketing
 * @subpackage  com_jticketing
 *
 * @author      Techjoomla <extensions@techjoomla.com>
 * @copyright   Copyright (C) 2009 - 2025 Techjoomla. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

use Joomla\CMS\Factory;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\MVC\Controller\BaseController;

defined('_JEXEC') or die('Restricted access');

// Access check.
if (!Factory::getUser()->authorise('core.manage', 'com_jticketing'))
{
	throw new Exception(Text::_('JERROR_ALERTNOAUTHOR'));
}

if (!defined('DS'))
{
	define('DS', DIRECTORY_SEPARATOR);
}

define('JTICKETING_WRAPPER_CLASS', 'jticketing-wrapper');

if (file_exists(JPATH_ROOT . '/media/techjoomla_strapper/tjstrapper.php'))
{
	require_once JPATH_ROOT . '/media/techjoomla_strapper/tjstrapper.php';
	TjStrapper::loadTjAssets('com_jticketing');
}

require_once JPATH_SITE . "/components/com_jticketing/helpers/main.php";
require_once JPATH_SITE . "/components/com_jticketing/helpers/frontendhelper.php";
require_once JPATH_SITE . "/components/com_jticketing/helpers/order.php";

// Get bootstrap

$JticketingHelperadmin = JPATH_ADMINISTRATOR . '/components/com_jticketing/helpers/jticketing.php';

if (!class_exists('JticketingHelperadmin') && file_exists($JticketingHelperadmin))
{
	require_once $JticketingHelperadmin;
}

$jticketingfrontendhelper = JPATH_ROOT . '/components/com_jticketing/helpers/frontendhelper.php';

if (!class_exists('jticketingfrontendhelper') && file_exists($jticketingfrontendhelper))
{
	require_once $jticketingfrontendhelper;
}

$jteventHelper = JPATH_ROOT . '/components/com_jticketing/helpers/event.php';

if (!class_exists('jteventHelper') && file_exists($jteventHelper))
{
	require_once $jteventHelper;
}

$mediaHelperPath = JPATH_SITE . '/components/com_jticketing/helpers/media.php';

if (!class_exists('jticketingMediaHelper') && file_exists($mediaHelperPath))
{
	require_once $mediaHelperPath;
}

$JticketingmainHelper = JPATH_SITE . '/components/com_jticketing/helpers/main.php';

if (!class_exists('jticketingmainhelper') && file_exists($JticketingmainHelper))
{
	require_once $JticketingmainHelper;
}

$JticketingOrdersHelper = JPATH_SITE . '/components/com_jticketing/helpers/order.php';

if (!class_exists('JticketingOrdersHelper') && file_exists($JticketingOrdersHelper))
{
	require_once $JticketingOrdersHelper;
}

// Load JTicketing bootstrap file
include_once  JPATH_SITE . '/components/com_jticketing/includes/jticketing.php';
JT::init('admin');

define('COM_JTICKETING_WRAPPER_CLASS', "jticketing-wrapper");

// Joomla 6: chosen behavior removed - use multiselect for list tables if needed

$document = Factory::getDocument();
$rootUrl = Uri::root();

$document->addScriptDeclaration('var jtRootURL= "' . $rootUrl . '";');

$lang = Factory::getLanguage();
$lang->load('com_jticketing_common', JPATH_SITE, $lang->getTag(), true);

$controller = BaseController::getInstance('Jticketing');
$controller->execute(Factory::getApplication()->getInput()->get('task'));
$controller->redirect();
