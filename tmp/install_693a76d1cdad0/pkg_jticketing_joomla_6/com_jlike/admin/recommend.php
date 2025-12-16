<?php
/**
 * @package     JLike
 * @subpackage  com_jlike
 *
 * @author      Techjoomla <extensions@techjoomla.com>
 * @copyright   Copyright (C) 2009 - 2019 Techjoomla. All rights reserved.
 * @license     http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// No direct access
defined('_JEXEC') or die;
use Joomla\Data\DataObject;
use Joomla\CMS\MVC\Model\ListModel;
use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\Factory;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Router\Route;

/**
 * Methods supporting a list of Tjlms records.
 *
 * @since  1.0.0
 */
class JlikeModelRecommend extends ListModel
{
	protected $params;

	/**
	 * Class constructor.
	 *
	 * @since   1.6
	 */
	public function __construct()
	{
		$this->_params = ComponentHelper::getParams('com_jlike');

		if (!class_exists('comjlikeHelper'))
		{
			// Require_once $path;
			$helperPath = JPATH_SITE . '/components/com_jlike/helper.php';
			JLoader::register('comjlikeHelper', $helperPath);
			JLoader::load('comjlikeHelper');
		}

		parent::__construct();
	}

	/**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @param   string  $ordering   An optional ordering field.
	 * @param   string  $direction  An optional direction (asc|desc).
	 *
	 * @return  void
	 *
	 * @since   1.0.0
	 */
	protected function populateState($ordering = null, $direction = null)
	{
		// Initialise variables.
		// List state information.
		parent::populateState('u.username', 'asc');

		$app = Factory::getApplication();

		$search = $app->getUserStateFromRequest($this->context . '.filter.search', 'filter_search');
		$this->setState('filter.search', $search);

		$limit = $app->getUserStateFromRequest('global.list.limit', 'limit', $app->getCfg('list_limit'), 'uint');
		$this->setState('list.limit', $limit);

		$limitstart = $app->input->get('limitstart', 0, 'uint');
		$this->setState('list.start', $limitstart);
	}

	/**
	 * Method to get a store id based on model configuration state.
	 *
	 * This is necessary because the model is used by the component and
	 * different modules that might need different sets of data or different
	 * ordering requirements.
	 *
	 * @param   string  $id  A prefix for the store id.
	 *
	 * @return  string  A store id.
	 *
	 * @since	1.6
	 */
	protected function getStoreId($id = '')
	{
		// Compile the store id.
		$id .= ':' . $this->getState('filter.search');
		$id .= ':' . $this->getState('filter.state');

		return parent::getStoreId($id);
	}

	/**
	 * Build an SQL query to load the list data.
	 *
	 * @return	DataObjectbaseQuery
	 *
	 * @since	1.6
	 */
	protected function getListQuery()
	{
		// Create a new query object.
		$db        = $this->getDbo();
		$query     = $db->getQuery(true);
		$oluser_id = Factory::getUser()->id;

		$input = Factory::getApplication()->input;

		$socialIntegration   = $input->get('socialIntegration', 'joomla', 'STRING');
		$socialIntegration   = 'joomla';
		$plg_type            = $input->get('plg_type', 'content', 'STRING');
		$plg_name            = $input->get('plg_name', '', 'STRING');
		$elementId           = $input->get('id', '', 'INT');
		$element             = $input->get('element', '', 'INT');
		$type                = $input->get('type', 'reco', 'STRING');

		// Get Social Integration form each component
		PluginHelper::importPlugin($plg_type, $plg_name);

		$socialIntegration = Factory::getApplication()->triggerEvent('onAfter' . $plg_name . 'GetSocialIntegration', array());

		if (isset($socialIntegration[0]))
		{
			$socialIntegration = $socialIntegration[0];
		}

		if (empty($socialIntegration))
		{
			$socialIntegration = 'joomla';
		}

		$socialIntegration = strtolower($socialIntegration);

		if ($socialIntegration == 'easysocial' || $socialIntegration == 'js' || $socialIntegration == 'jomsocial')
		{
			$which_users_in_list = $this->_params->get('which_users_in_list');
		}

		switch ($socialIntegration)
		{
			case 'easysocial':

				// Get Only friends
				if ($which_users_in_list == 0)
				{
					$query = $this->getESFriends($oluser_id);
				}
				else
				{
					$query = $this->getAllUser();
				}
			break;

			case 'js':
			case 'jomsocial':

				// Get Only friends
				if ($which_users_in_list == 0)
				{
					$query = $this->getJSFriends($oluser_id);
				}
				else
				{
					$query = $this->getAllUser();
				}
			break;

			default:
				$query = $this->getAllUser();
		}

		$result = Factory::getApplication()->triggerEvent('onAfter' . $plg_name . 'GetAdditionalWhereCondition', array('id' => $elementId));

		if (isset($result[0]))
		{
			$componentSpecificCondition = $result[0];
		}

		$usersToRemove = array();

		if (!empty($componentSpecificCondition))
		{
			$usersToRemove = $componentSpecificCondition;
		}

		// Get all user which are already recommended & Assigned by this user.
		$recommendedUsers = $this->getTypewiseUsers($elementId, $element, $type);

		if (!empty($recommendedUsers))
		{
			$usersToRemove = $recommendedUsers;
		}

		if (!empty($componentSpecificCondition) && !empty($recommendedUsers))
		{
			$usersToRemove = array_merge($componentSpecificCondition, $recommendedUsers);
			$usersToRemove = array_unique($usersToRemove);
		}

		if (!empty($usersToRemove))
		{
			$usersToRemove = implode(',', $usersToRemove);
			$query->where('u.id NOT IN (' . $usersToRemove . ')');
		}

		return $query;
	}

	/**
	 * Retrieves a list of friends (Jomsocial)
	 *
	 * @param   int  $id  The user's id
	 *
	 * @return   Array
	 *
	 * @since   1.0
	 */
	public function getJSFriends($id)
	{
		$db    = Factory::getDBO();

		$query = $db->getQuery(true);

		$query->select('DISTINCT(a.' . $db->quoteName('connect_to') . ') AS ' . $db->quoteName('friendid'));
		$query->select('u.name, u.username');
		$query->from($db->quoteName('#__community_connection', 'a'));
		$join_condn = $db->quoteName('#__users') . ' AS u ' . ' ON a.' . $db->quoteName('connect_from') . '=' . $db->Quote($id);

		$join_condn .= ' AND a.' . $db->quoteName('connect_to') . ' =u.' . $db->quoteName('id');
		$join_condn .= ' AND a.' . $db->quoteName('status') . '=' . $db->Quote(1);

		$query->join('INNER', $join_condn);

		return $query;
	}

	/**
	 * Function to get already recommended users.
	 *
	 * @param   INT     $elementId  element ID
	 * @param   STRING  $element    com_tjlms.course
	 * @param   STRING  $type       Type reco or assign
	 *
	 * @return  boolean
	 *
	 * @since  1.0.0
	 */
	public function getTypewiseUsers($elementId, $element, $type = "reco")
	{
		$oluser_id = Factory::getUser()->id;
		$db        = Factory::getDBO();
		$Rquery    = $db->getQuery(true);
		$Rquery->select('t.assigned_to');
		$Rquery->from('#__jlike_todos as t');
		$Rquery->join('INNER', '#__jlike_content as c ON c.id=t.content_id');
		$Rquery->where('t.type="' . $type . '"');
		$Rquery->where('t.assigned_by=' . $oluser_id);
		$Rquery->where('c.element_id=' . $elementId);
		$Rquery->where('c.element=' . $element);

		$db->setQuery($Rquery);

		return $recommendedUsers = $db->loadColumn();
	}

	/**
	 * To get the records
	 *
	 * @return  Object
	 *
	 * @since  1.0.0
	 */
	public function getItems()
	{
		$items = parent::getItems();

		// Get integration
		$input             = Factory::getApplication()->input;
		$plg_type          = $input->get('plg_type', 'content', 'STRING');
		$plg_name          = $input->get('plg_name', '', 'STRING');
		$socialIntegration = ComjlikeHelper::getSocialIntegration($plg_type, $plg_name);

		// Create object of social library
		$SocialLibraryObject = ComjlikeHelper::getSocialLibraryObject($socialIntegration);

		foreach ($items as $item)
		{
			$item->avatar = $SocialLibraryObject->getAvatar(Factory::getUser($item->friendid));
		}

		return $items;
	}

	/**
	 * Function to save recommendation
	 *
	 * @param   ARRAY  $post     data
	 * @param   ARRAY  $options  formdata
	 *
	 * @return  boolean
	 *
	 * @since  1.0.0
	 */
	public function sendRecommendation($post, $options)
	{
		$comjlikeHelper = new comjlikeHelper;
		$db    = Factory::getDBO();
		require_once JPATH_SITE . '/components/com_jlike/helpers/integration.php';

		// Get content id
		$query = $db->getQuery(true);
		$query->select($db->quoteName('jc.id'));
		$query->from($db->quoteName('#__jlike_content', 'jc'));
		$query->where($db->quoteName('jc.element') . ' = "' . $options['element'] . '"');
		$query->where($db->quoteName('jc.element_id') . '=' . $options['element_id']);
		$db->setQuery($query);
		$content_id = $db->loadResult();

		// Get URL and title form respective component
		PluginHelper::importPlugin($options['plg_type'], $options['plg_name']);
		$elementdata = Factory::getApplication()->triggerEvent('onAfter' . $options['plg_name'] . 'GetElementData', array($options['element_id']));
		$elementdata = $elementdata[0];

		if (!$content_id)
		{
			try
			{
				// If add entry in conten
				$insert_obj             = new stdClass;
				$insert_obj->element_id = $options['element_id'];
				$insert_obj->element    = $options['element'];
				$insert_obj->url        = $elementdata['url'];
				$insert_obj->title      = $elementdata['title'];
				$db->insertObject('#__jlike_content', $insert_obj);
				$content_id = $db->insertid();
			}
			catch (RuntimeException $e)
			{
				Factory::getApplication()->enqueueMessage($e->getMessage());

				return false;
			}
		}

		// Insert record in todos table
		$insert_obj               = new stdClass;
		$insert_obj->content_id   = $content_id;
		$insert_obj->sender_msg   = $post->get('sender_msg', '', 'STRING');
		$insert_obj->created_by   = Factory::getUser()->id;
		$insert_obj->assigned_by  = Factory::getUser()->id;
		$OnDate                   = Factory::getDate();
		$insert_obj->created_date = $OnDate->toSql(true);
		$insert_obj->start_date   = Factory::getDate($post->get('start_date', '', 'STRING'))->toSql();
		$insert_obj->due_date     = Factory::getDate($post->get('due_date', '', 'STRING'))->toSql();
		$insert_obj->status       = 'S';
		$insert_obj->state        = '1';

		// @Todo Get content title.
		$insert_obj->title        = $options['element_id'];
		$insert_obj->type         = $post->get('type', '', 'STRING');

		$usersToRecommend = $post->get('recommend_friends', '', 'ARRAY');

		foreach ($usersToRecommend as $eachrecommendation)
		{
			$insert_obj->id          = '';
			echo $insert_obj->assigned_to = $eachrecommendation;

			try
			{
				// If it fails, it will throw a RuntimeException
				$db->insertObject('#__jlike_todos', $insert_obj, 'id');
				$recid = $db->insertid();

				// Get integration
				$socialIntegration = ComjlikeHelper::getSocialIntegration($options['plg_type'], $options['plg_name']);

				// Create object of social library
				$SocialLibraryObject = ComjlikeHelper::getSocialLibraryObject($socialIntegration);

				// Notification sender & receiver
				$sender   = Factory::getUser();
				$receiver = Factory::getUser($insert_obj->assigned_to);

				// Notification message
				if ($insert_obj->type == 'reco')
				{
					$msg = Text::sprintf(Text::_("COM_JLIKE_RECOMMENDATIONS_NOTIFICATION"), $sender->name, $elementdata['title']);

					if (!empty($insert_obj->sender_msg))
					{
						$sender_msg = Text::sprintf(Text::_("COM_JLIKE_USER_MESSAGE_RECOMMEND"), $insert_obj->sender_msg);
					}
				}
				else
				{
					$msg = Text::sprintf(Text::_("COM_JLIKE_ASSIGN_NOTIFICATION"), $sender->name, $elementdata['title']);

					if (!empty($insert_obj->sender_msg))
					{
						$sender_msg = Text::sprintf(Text::_("COM_JLIKE_USER_MESSAGE_ASSIGN"), $insert_obj->sender_msg);
					}
				}

				// Send notification
				switch ($socialIntegration)
				{
					case 'joomla':

						$recipient = Factory::getUser($insert_obj->assigned_to)->email;
						$subject = $msg;
						$body = $msg;

						$itemlink = $elementdata['url'];
						$link = Uri::root() . substr(Route::_($itemlink), strlen(Uri::base(true)) + 1);
						$link = '<a href="' . $link . '">' . $elementdata['title'] . '</a>';

						if ($insert_obj->type == 'reco')
						{
							$body = Text::_('COM_JLIKE_RECOMMENDATIONS_MAIL_CONTENT');
						}
						else
						{
							$body = Text::_('COM_JLIKE_ASSIGNMENT_MAIL_CONTENT');

							$start_date = Factory::getDate($post->get('start_date', '', 'STRING'))->Format(Text::_('COM_JLIKE_DATE_FORMAT'));
							$due_date   = Factory::getDate($post->get('due_date', '', 'STRING'))->Format(Text::_('COM_JLIKE_DATE_FORMAT'));

							$body = str_replace('{start_date}', $start_date, $body);
							$body = str_replace('{due_date}', $due_date, $body);
							$body = str_replace('{user_msg}', $insert_obj->sender_msg, $body);
						}

						$body = str_replace('{receiver}', Factory::getUser($insert_obj->assigned_to)->name, $body);
						$body = str_replace('{sender}', Factory::getUser($insert_obj->assigned_by)->name, $body);

						$body    = str_replace('{title}', $link, $body);
						$subject = $msg;

						ComjlikeHelper::sendmail($recipient, $subject, $body, '');
					break;

					case 'easysocial':
						// Internal notification options
						$systemOptions = array(
							'uid' => 'accepted_not',
							'actor_id' => $insert_obj->assigned_by,
							'target_id' => $insert_obj->assigned_to,
							'title' => $msg,
							'image' => '',
							'cmd' => 'Jlike_notification.create',
							'url' => $elementdata['url']
						);

						$msgid = $SocialLibraryObject->sendNotification($sender, $receiver, $msg, $systemOptions);
					break;

					case 'jomsocial':
					case 'js':
						$installed     = $comjlikeHelper->Checkifinstalled('com_community');
						$msg_with_link = "<a href=" . $elementdata['url'] . ">" . $msg . "</a>";

						if ($installed)
						{
							$model = CFactory::getModel('Notification');
							$model->add($insert_obj->assigned_by, $insert_obj->assigned_to, $msg_with_link, 'notif_system_messaging', '0', '');
						}
					break;

					case 'cb':
					break;

					case 'jomwall':
					break;

					case 'easyprofile':
					break;
				}

				PluginHelper::importPlugin('system');

				if ($insert_obj->type == 'reco')
				{
					// Trigger after recommend
					$grt_response = Factory::getApplication()->triggerEvent('onAfterRecommend', array(
																			$recid,
																			$eachrecommendation,
																			Factory::getUser()->id,
																			$options['element_id']
																		)
													);
				}
				elseif ($insert_obj->type == 'assign')
				{
					$grt_response = Factory::getApplication()->triggerEvent('onAfterAssignment', array(
																			$recid,
																			$eachrecommendation,
																			Factory::getUser()->id,
																			$options['element_id']
																		)
													);
				}
			}
			catch (RuntimeException $e)
			{
				Factory::getApplication()->enqueueMessage($e->getMessage());

				return false;
			}
		}

		return true;
	}

	/**
	 * Retrieves a list of friends (Easysocial)
	 *
	 * @param   int    $id       The user's id
	 * @param   Array  $options  An array of options. state - SOCIAL_FRIENDS_STATE_PENDING or SOCIAL_FRIENDS_STATE_FRIENDS
	 *
	 * @return   Array
	 *
	 * @since   1.0
	 */
	public function getESFriends($id, $options = array())
	{
		require_once JPATH_ROOT . '/administrator/components/com_easysocial/includes/foundry.php';

		$config = FD::config();

		$db  = FD::db();
		$sql = $db->sql();

		$query = $db->getQuery(true);
		$query->select('a.*, if( a.target_id= ' . $db->Quote($id) . ', a.actor_id, a.target_id) AS friendid');
		$query->select('u.name, u.username');
		$query->from($db->nameQuote('#__social_friends') . ' AS a');
		$query->join('INNER', '#__users AS u ON u.id = if( a.target_id = ' . $db->Quote($id) . ', a.actor_id, a.target_id)');
		$query->join('INNER', '`#__social_profiles_maps` as upm ON u.`id` = upm.`user_id`');
		$query->join('INNER', '`#__social_profiles` as up on upm.`profile_id` = up.`id` and up.`community_access` = 1');

		if ($config->get('users.blocking.enabled') && !Factory::getUser()->guest)
		{
			$query->join('LEFT', '#__social_block_users as bus ON u.id = bus.user_id AND bus.target_id = ' . $db->Quote(Factory::getUser()->id));
		}

		$query->where('u.' . $db->nameQuote('block') . ' = ' . $db->Quote('0'));

		if ($config->get('users.blocking.enabled') && !Factory::getUser()->guest)
		{
			$query->where('bus.' . $db->nameQuote('id') . ' IS NULL');
		}

		$query->where('a.' . $db->nameQuote('state') . '=1');

		return $query;
	}

	/**
	 * Retrieves a list of users(Joomla)
	 *
	 * @return   Array
	 *
	 * @since   1.0
	 */
	public function getAllUser()
	{
		$db    = Factory::getDBO();

		$query = $db->getQuery(true);

		// Select the required fields from the table.
		$query->select($this->getState('list.select', 'distinct(u.id) as friendid, u.name, u.username'));
		$query->from('`#__users` AS u');
		$query->where('u.block=0');

		// Filter by search in title
		$search = $this->getState('filter.search');

		if (!empty($search))
		{
			if (stripos($search, 'id:') === 0)
			{
				$query->where('u.id = ' . (int) substr($search, 3));
			}
			else
			{
				$search = $db->Quote('%' . $db->escape($search, true) . '%');
				$query->where('(( u.name LIKE ' . $search . ' ) OR ( u.username LIKE ' . $search . ' ))');
			}
		}

		// Add the list ordering clause.
		$orderCol  = $this->state->get('list.ordering');
		$orderDirn = $this->state->get('list.direction');

		if ($orderCol && $orderDirn)
		{
			$query->order($db->escape($orderCol . ' ' . $orderDirn));
		}

		return $query;
	}
}
