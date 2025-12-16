<?php
/**
 * @package     TJCertificate
 * @subpackage  com_tjcertificate
 *
 * @author      Techjoomla <extensions@techjoomla.com>
 * @copyright   Copyright (C) 2009 - 2019 Techjoomla. All rights reserved.
 * @license     http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\CMS\MVC\Controller\BaseController;

// Joomla 6: JLoader removed
TJCERT::init('site');

Joomla 6: JLoader removed - use require_once insteadPrefix('TjCertificate', JPATH_ADMINISTRATOR . "/components/com_jticketing");
// Joomla 6: JLoader removed

// Execute the task.
$controller = BaseController::getInstance('TjCertificate');
$controller->execute(Factory::getApplication()->getInput()->get('task'));
$controller->redirect();
