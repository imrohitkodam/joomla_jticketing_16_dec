<?php
/**
 * @version    SVN: <svn_id>
 * @package    Quick2cart
 * @author     Techjoomla <extensions@techjoomla.com>
 * @copyright  Copyright (c) 2009-2015 TechJoomla. All rights reserved.
 * @license    GNU General Public License version 2 or later.
 */

// No direct access.
defined('_JEXEC') or die();
use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\Filesystem\File;
use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\Factory;


/**
 * plugin to send my like to friends via InviteX Integration
 *
 * @package     Jlike
 * @subpackage  site
 * @since       2.2
 */
class PlgSystemJlike_Likesmail extends CMSPlugin
{
	/**
	 * This function will be called on after queuing up the invitations.
	 *
	 * @param   Integer  $import_id  import_id: where the invitation is saved.
	 *
	 * @return void
	 *
	 * @since 3.0
	 */
	public function onAfterQueupInvities($import_id)
	{
		if (!empty($import_id))
		{
			$com_jlike_installed = 0;

			// Check if JLike is installed
			if (File::exists(JPATH_ROOT . '/components/com_jlike/jlike.php'))
			{
				if (ComponentHelper::isEnabled('com_jlike', true))
				{
					$com_jlike_installed = 1;
				}
			}

			if ($com_jlike_installed === 0)
			{
				return;
			}

			require_once JPATH_SITE . '/components/com_jlike/helper.php';

			$comjlikeHelper = new comjlikeHelper;
			$comjlikeHelper->addEntryJlikeInvitexRefTb($import_id);
		}
	}

	/**
	 * This function loads the helper files.
	 *
	 * @return void
	 *
	 * @since 3.0
	 */
	private function loadJlikeHelper()
	{
		$com_jlike_installed = 0;

		// Check if JLike is installed
		if (File::exists(JPATH_ROOT . '/components/com_jlike/jlike.php'))
		{
			if (ComponentHelper::isEnabled('com_jlike', true))
			{
				$com_jlike_installed = 1;
			}
		}

		if ($com_jlike_installed === 0)
		{
			return null;
		}

		$path = JPATH_SITE . '/components/com_jlike/helper.php';

		if (!class_exists('comjlikeHelper'))
		{
			// Require_once $path;
			if (file_exists($path)) {
				require_once $path;
			}
		}

		return new comjlikeHelper;
	}

	/**
	 * This function will be called before sending the email from invitex.
	 *
	 * @param   string  $message_body     Msg body of email.
	 * @param   object  $connection_data  Inviter Email connection deta.
	 *
	 * @return void
	 *
	 * @since 3.0
	 */
	public function onPrepareInvitexEmail($message_body, $connection_data)
	{
		$importEmailId = $connection_data->refid;

		if (empty($importEmailId))
		{
			return;
		}

		$comjlikeHelper = $this->loadJlikeHelper();

		// Get like content
		$contentList = $comjlikeHelper->getJlikeDetailFromInvitexRefTb($importEmailId);

		if (empty($contentList) || !is_array($contentList))
		{
			return;
		}

		$html = "<table>";
		$html .= "<tbody>";

		foreach ($contentList as $key => $likedata)
		{
			$html .= "<tr>";
			$html .= "<td>" . ($key + 1) . "</td>";
			$html .= "<td><strong><a href='" . $likedata->url . "'>" . $likedata->title . "</a></strong>
						</td>";
			$html .= "</tr>";
		}

		$html .= "</tbody>";
		$html .= "</table>";

		// Replace placeholders with values
		$find    = array('[jlike_likeditem]');
		$replace = array($html);


		return str_replace($find, $replace, $message_body);
	}

	/**
	 * This function will be called after sending the email from invitex.
	 *
	 * @param   integer  $inviter_id       Inviter id(userid).
	 * @param   string   $invitee_mail     invitee_mail.
	 * @param   object   $connection_data  Inviter Email connection deta.
	 *
	 * @return void
	 *
	 * @since 3.0
	 */
	public function onAfterinvitesent($inviter_id, $invitee_mail, $connection_data)
	{
		// If inviter email id present
		if (!empty($connection_data->refid))
		{
			$com_jlike_installed = 0;

			// Check if JLike is installed
			if (File::exists(JPATH_ROOT . '/components/com_jlike/jlike.php'))
			{
				if (ComponentHelper::isEnabled('com_jlike', true))
				{
					$com_jlike_installed = 1;
				}
			}

			if ($com_jlike_installed === 0)
			{
				return;
			}

			require_once JPATH_SITE . '/components/com_jlike/helper.php';
			$comjlikeHelper = new comjlikeHelper;
			$comjlikeHelper->DelEntryJlikeInvitexRefTb($connection_data->refid);
		}
	}

	/**
	 * This function will be called queup of all email.
	 *
	 * @param   integer  $import_id       import_id.
	 *
	 * @return void
	 *
	 * @since 3.0
	 */
	public function onAfterQueupDone($import_id)
	{
		$session = Factory::getSession();
		$session->set('jlikeContentIds', '');
	}
}
