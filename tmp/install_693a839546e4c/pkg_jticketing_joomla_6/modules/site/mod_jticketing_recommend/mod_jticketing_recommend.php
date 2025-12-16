<?php
/**
 * @version    SVN: <svn_id>
 * @package    JTicketing
 * @author     Techjoomla <extensions@techjoomla.com>
 * @copyright  Copyright (c) 2009-2015 TechJoomla. All rights reserved.
 * @license    GNU General Public License version 2 or later.
 */

defined('_JEXEC') or die('Restricted access');
use Joomla\CMS\Filesystem\File;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\CMS\Factory;
use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\MVC\Model\BaseDatabaseModel;
use Joomla\CMS\Helper\ModuleHelper;

require_once JPATH_SITE . '/components/com_jticketing/helpers/event.php';

if (File::exists(JPATH_SITE . '/components/com_jticketing/jticketing.php'))
{
	$moduleData = new stdClass;
	$moduleData->jLikepluginParams = '';
	$jLikePlugin = PluginHelper::getPlugin('content', 'jlike_events');
	$moduleData->event_id = $eventID = Factory::getApplication()->input->get('id', '', 'INT');
	$show_user_or_username = "name";

	if ($eventID)
	{
		$moduleData->jticketingparams = ComponentHelper::getParams('com_jticketing');
		$moduleData->social_integration = $moduleData->jticketingparams->get('social_integration');
		$moduleData->loggedInUserID = Factory::getUser()->id;
		$moduleData->loggedInUser = Factory::getUser();
		BaseDatabaseModel::addIncludePath(JPATH_ADMINISTRATOR . '/components/com_jticketing/models', 'eventform');
		$eventFormsModel = BaseDatabaseModel::getInstance('EventForm', 'JticketingModel');
		$moduleData->eventInfo = $eventFormsModel->getItem($eventID);
		$eventHelper = new JteventHelper;

		if (!empty($jLikePlugin))
		{
			// Get Params each component
			PluginHelper::importPlugin('content', 'jlike_events');
			$paramsArray = Factory::getApplication()->triggerEvent('onJlikeEventsGetParams', array());
			$moduleData->jLikepluginParams = !empty ($paramsArray[0]) ? $paramsArray[0] : '';
		}

		/*
		if ($params->get('assign_user', 1) &&  ($moduleData->loggedInUserID == $moduleData->eventInfo->created_by) )
		{
			if (!empty($moduleData->jLikepluginParams))
			{
				if ($moduleData->jLikepluginParams->get('assignment') == 1)
				{
					$showassign = 1;
					$mod_data->getuserAssignedUsers = $model->getuserAssignedUsersInfo($eventID, $moduleData->eventInfo->created_by);
				}
			}
		}*/

		if ($params->get('recommend', 1) && $moduleData->loggedInUserID)
		{
			if (!empty($moduleData->jLikepluginParams))
			{
				if ($moduleData->jLikepluginParams->get('recommendation') == 1)
				{
					$showrecommend = 1;
					$moduleData->getuserRecommendedUsers = JT::model('Enrollment')->getuserRecommendedUsers($eventID, $moduleData->loggedInUserID);
				}
			}
		}

		require	ModuleHelper::getLayoutPath('mod_jticketing_recommend');
	}
}
