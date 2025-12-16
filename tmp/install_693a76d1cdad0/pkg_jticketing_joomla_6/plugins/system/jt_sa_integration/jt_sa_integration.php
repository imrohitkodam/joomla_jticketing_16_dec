<?php
/**
 * @version    SVN:<SVN_ID>
 * @package    Js_Events
 * @author     Techjoomla <extensions@techjoomla.com>
 * @copyright  Copyright (c) 2009-2015 TechJoomla. All rights reserved
 * @license    GNU General Public License version 2, or later
 */

// No direct access
defined('_JEXEC') or die('Restricted access');
use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\CMS\Component\ComponentHelper;

require_once JPATH_ROOT . '/administrator/components/com_easysocial/includes/foundry.php';
/**
 * Plugin class to promote easysocial events in Socialads.
 *
 * @since  1.6
 */
class PlgSystemJt_Sa_Integration extends CMSPlugin
{
	/**
	 * Load plugin language file automatically so that it can be used inside component
	 *
	 * @var    boolean
	 * @since  2.4.0
	 */
	protected $autoloadLanguage = true;

	/**
	 * Methode to promote easysocial events
	 *
	 * @param   integer  $id            order id
	 * @param   string   $status        order status
	 * @param   object   $orderDetails  order details
	 *
	 * @return  array
	 *
	 * @since   2.4.0
	 */
	public function onAfterSaOrderStatusChange($id, $status, $orderDetails)
	{
		$com_params  = ComponentHelper::getParams('com_jticketing');
		$integration = $com_params->get('integration');

		JLoader::import('payment', JPATH_SITE . '/components/com_socialads/helpers');
		$paymentHelper  = new SocialadsPaymentHelper;
		$adData = $paymentHelper->getOrderAndAdDetail($id);

		if (!empty($adData['params']) && $status == 'C')
		{
			$eventData = json_decode($adData['params']);

			switch ($integration)
			{
				case 1:
					// Jomsocial
					break;

				case 2:
					// Native
					break;

				case 3:
					// JEvent
					break;

				case 4:
					// EasySocial

					$event = Foundry::event();
					$data  = $event->loadEvents($eventData->eventId);

					if ($data || $data->id)
					{
						$data->setFeatured();
					}

					break;
			}
		}
	}

	/**
	 * Methode to get promotion data
	 *
	 * @param   integer  $id  Id of a event
	 *
	 * @return  array
	 *
	 * @since   2.4.0
	 */
	public function onAfterSaAdExpire($id)
	{
		$com_params  = ComponentHelper::getParams('com_jticketing');
		$integration = $com_params->get('integration');

		JLoader::import('common', JPATH_SITE . '/components/com_socialads/helpers');
		$adData = SaCommonHelper::getAdInfo($id);

		if (!empty($adData[0]->params))
		{
			$eventData = json_decode($adData[0]->params);

			switch ($integration)
			{
				case 1:
					// Jomsocial
					break;

				case 2:
					// Native
					break;

				case 3:
					// JEvent
					break;

				case 4:

					$event = Foundry::event();
					$data  = $event->loadEvents($eventData->eventId);

					if ($data || $data->id)
					{
						$data->removeFeatured();
					}
					break;
			}
		}
	}
}
