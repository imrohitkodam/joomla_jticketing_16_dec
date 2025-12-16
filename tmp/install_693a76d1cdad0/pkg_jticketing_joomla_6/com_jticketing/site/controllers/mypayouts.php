<?php
/**
 * @package     JTicketing
 * @subpackage  com_jticketing
 *
 * @author      Techjoomla <extensions@techjoomla.com>
 * @copyright   Copyright (C) 2009 - 2025 Techjoomla. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die('Restricted access');
use Joomla\CMS\MVC\Controller\BaseController;
// Joomla 6: JPATH_ADMINISTRATOR . "/components/com_jticketing" removed - use JPATH_ADMINISTRATOR or JPATH_SITE instead
		require_once (defined('JPATH_ADMINISTRATOR') ? JPATH_ADMINISTRATOR : JPATH_SITE) . '/components/com_jticketing . '/controller.php';

/**
 * Makepayment controller class.
 *
 * @since  3.2
 */
class JticketingControllermypayouts extends BaseController
{
}
