<?php
/**
 * @package     Jticketing.Plugin
 * @subpackage  Jticketing,TJReport, order report
 *
 * @copyright   Copyright (C) 2020 - 2021 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die('Restricted access');

jimport('techjoomla.common');

use Joomla\CMS\Factory;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Component\ComponentHelper;

JLoader::import('com_tjreports.models.reports', JPATH_SITE . '/components');

JLoader::import('components.com_tjfields.helpers.geo', JPATH_SITE);

/**
 * Order Report
 *
 * @since  __DEPLOY_VERISION__
 */

class TjreportsModelOrderreport extends TjreportsModelReports
{
	protected $default_order = 'id';

	protected $default_order_dir = 'ASC';

	public $showSearchResetButton = false;

	/**
	 * Load the language file on instantiation.
	 *
	 * @var    boolean
	 * @since  __DEPLOY_VERISION__
	 */
	protected $autoloadLanguage = true;

	/**
	 * Constructor.
	 *
	 * @param   array  $config  An optional associative array of configuration settings.
	 *
	 * @since   __DEPLOY_VERISION__
	 */
	public function __construct($config = array())
	{
		JLoader::import('administrator.components.com_jticketing.helpers.jticketing', JPATH_SITE);

		$lang = Factory::getLanguage();
		$base_dir = JPATH_SITE . '/administrator';
		$lang->load('com_jticketing', $base_dir);

		$this->columns = array(
			'id' => array('title' => 'COM_JTICKETING_ORDER_ID'),
			'event_id' => array('title' => 'COM_JTICKETING_EVENT_ID'),
			'title' => array('table_column' => 'e.title','title' => 'PLG_TJREPORTS_ORDERREPORT_EVENT_NAME'),
			'created_by' => array('title' => 'JGLOBAL_FIELD_CREATED_BY_LABEL'),
			'user_id' => array('title' => 'PLG_TJREPORTS_ORDERREPORT_USER'),
			'user_name' => array('title' => 'PLG_TJREPORTS_ORDERREPORT_USER_NAME'),
			'email' => array('title' => 'PLG_TJREPORTS_ORDERREPORT_USER_EMAIL'),
			'business_name' => array('title' => 'PLG_TJREPORTS_ORDERREPORT_BUSINESS_NAME'),
			'vat_number' => array('title' => 'PLG_TJREPORTS_ORDERREPORT_VAT_NUMBER', 'not_show_hide' => false),
			'phone' => array('title' => 'PLG_TJREPORTS_ORDERREPORT_USER_PHONE'),
			'address' => array('title' => 'PLG_TJREPORTS_ORDERREPORT_USER_ADDRESS'),
			'city' => array('title' => 'PLG_TJREPORTS_ORDERREPORT_USER_CITY'),
			'country_code' => array('title' => 'PLG_TJREPORTS_ORDERREPORT_USER_COUNTRY_NAME'),
			'state_code' => array('title' => 'PLG_TJREPORTS_ORDERREPORT_USER_STATE_NAME'),
			'cdate' => array('title' => 'PLG_TJREPORTS_ORDERREPORT_ORDER_CREATED_DATE'),
			'order_amount' => array('title' => 'PLG_TJREPORTS_ORDERREPORT_ORDER_AMOUNT'),
			'original_amount' => array('title' => 'PLG_TJREPORTS_ORDERREPORT_ORIGINAL_AMOUNT'),
			'fee' => array('title' => 'PLG_TJREPORTS_ORDERREPORT_FEE', 'not_show_hide' => false),
			'coupon_code' => array('title' => 'PLG_TJREPORTS_ORDERREPORT_COUPON_CODE', 'not_show_hide' => false),
			'status' => array('title' => 'PLG_TJREPORTS_ORDERREPORT_ORDER_STATUS'),
			'processor' => array('title' => 'PLG_TJREPORTS_ORDERREPORT_ORDER_PROCESSOR'),
			'ticket_count' => array('title' => 'PLG_TJREPORTS_ORDERREPORT_TICKET_COUNT'),
			'order_tax' => array('title' => 'PLG_TJREPORTS_ORDERREPORT_ORDER_TAX', 'not_show_hide' => false),
			'coupon_discount' => array('title' => 'PLG_TJREPORTS_ORDERREPORT_COUPON_DISCOUNT', 'not_show_hide' => false)
		);

		parent::__construct($config);
	}

	/**
	 * Get client of this plugin
	 *
	 * @return array
	 *
	 * @since   __DEPLOY_VERISION__
	 * */
	public function getPluginDetail()
	{
		$detail = array('client' => 'com_jticketing', 'title' => Text::_('PLG_TJREPORTS_ORDERREPORT_TITLE'));

		return $detail;
	}

	/**
	 * Get style for left sidebar menu
	 *
	 * @return ARRAY Keys of data
	 *
	 * @since   __DEPLOY_VERISION__
	 * */
	public function getStyles()
	{
		return array(
			Uri::root(true) . '/media/com_jticketing/css/jticketing.css',
		);
	}

	/**
	 * Create an array of filters
	 *
	 * @return  mixed  An array of data items on success, false on failure.
	 *
	 * @since   __DEPLOY_VERISION__
	 */
	public function displayFilters()
	{
		$selected   = null;
		$created_by = 0;
		$myTeam     = false;

		$reportOptions  = JticketingHelper::getReportFilterValues($this, $selected, $created_by, $myTeam);

		$com_params = ComponentHelper::getParams('com_jticketing');
		$gatewaysconfig = $com_params->get('gateways', '', 'ARRAY');
		$processor = array();
		$processor[] = HTMLHelper::_('select.option', '', Text::_('COM_JTICKETING_FILTER_SELECT_PAYMENT_PROCESSOR'));

		foreach ($gatewaysconfig as $gateway)
		{
			$processor[] = HTMLHelper::_('select.option', $gateway);
		}

		$db = $this->_db;
		$query = $db->getQuery(true);
		$query->select($db->qn(array('u.id','u.name')));
		$query->from($db->qn('#__users', 'u'));
		$query->join('INNER', $db->quoteName('#__jticketing_events', 'e') . ' ON (' . $db->quoteName('u.id') .
			' = ' . $db->quoteName('e.created_by') . ')');
		$query->where($db->qn('u.block') . ' <> 1');
		$query->group('u.id');
		$db->setQuery($query);
		$users = $db->loadObjectList();

		$userFilter = array();
		$userFilter[] = HTMLHelper::_('select.option', '', Text::_('COM_JTICKETING_FILTER_SELECT_USER'));

		foreach ($users as $eachUser)
		{
			$userFilter[] = HTMLHelper::_('select.option', $eachUser->id, $eachUser->name);
		}

		$query = $db->getQuery(true);
		$query->select($db->qn(array('jte.id', 'jte.title')));
		$query->from($db->qn('#__jticketing_events', 'jte'));
		$query->where($db->qn('jte.state') . '=1');
		$db->setQuery($query);
		$eventNames = $db->loadObjectList();

		$eventNamesFilter = array();
		$eventNamesFilter[] = HTMLHelper::_('select.option', '', Text::_('COM_JTICKETING_FILTER_SELECT_EVENT_NAME'));

		foreach ($eventNames as $eventName)
		{
			$eventNamesFilter[] = HTMLHelper::_('select.option', $eventName->id, $eventName->title);
		}

		$query = $db->getQuery(true);
		$query->select($db->qn(array('jto.user_id', 'jto.name')));
		$query->from($db->qn('#__jticketing_order', 'jto'));
		$query->group('jto.user_id');
		$db->setQuery($query);
		$userNames = $db->loadObjectList();

		$userNamesFilter = array();
		$userNamesFilter[] = HTMLHelper::_('select.option', '', Text::_('COM_JTICKETING_FILTER_SELECT_USER'));

		foreach ($userNames as $userName)
		{
			$userNamesFilter[] = HTMLHelper::_('select.option', $userName->user_id, $userName->name);
		}

		$paymentStatusArray = array();
		$paymentStatusArray[] = HTMLHelper::_('select.option', '', Text::_('COM_JTICKETING_SELECT_PSTATUS'));
		$paymentStatusArray[] = HTMLHelper::_('select.option', 'I', Text::_('COM_JTICKETING_PSTATUS_INITIATED'));
		$paymentStatusArray[] = HTMLHelper::_('select.option', 'P', Text::_('COM_JTICKETING_PSTATUS_PENDING'));
		$paymentStatusArray[] = HTMLHelper::_('select.option', 'C', Text::_('COM_JTICKETING_PSTATUS_COMPLETED'));
		$paymentStatusArray[] = HTMLHelper::_('select.option', 'D', Text::_('COM_JTICKETING_PSTATUS_DECLINED'));
		$paymentStatusArray[] = HTMLHelper::_('select.option', 'E', Text::_('COM_JTICKETING_PSTATUS_FAILED'));
		$paymentStatusArray[] = HTMLHelper::_('select.option', 'UR', Text::_('COM_JTICKETING_PSTATUS_UNDERREVIW'));
		$paymentStatusArray[] = HTMLHelper::_('select.option', 'RF', Text::_('COM_JTICKETING_PSTATUS_REFUNDED'));
		$paymentStatusArray[] = HTMLHelper::_('select.option', 'CRV', Text::_('COM_JTICKETING_PSTATUS_CANCEL_REVERSED'));
		$paymentStatusArray[] = HTMLHelper::_('select.option', 'RV', Text::_('COM_JTICKETING_PSTATUS_REVERSED'));

		$dispFilters = array(
			array(
				'id' => array(
					'search_type' => 'text',  'searchin' => 'o.order_id'
				),
				'event_id' => array(
					'search_type' => 'text','searchin' => 'e.id'
				),
				'email' => array(
					'search_type' => 'text','searchin' => 'o.email'
				),
				'title' => array(
					'search_type' => 'select', 'select_options' => $eventNamesFilter, 'type' => 'equal', 'searchin' => 'e.id'
				),
				'user_id' => array(
					'search_type' => 'text', 'searchin' => 'o.user_id'
				),
				'user_name' => array(
					'search_type' => 'select', 'select_options' => $userNamesFilter, 'type' => 'equal', 'searchin' => 'o.user_id'
				),
				'created_by' => array(
					'search_type' => 'select', 'select_options' => $userFilter, 'type' => 'equal', 'searchin' => 'us.id'
				),
				'status' => array(
					'search_type' => 'select', 'select_options' => $paymentStatusArray, 'type' => 'equal', 'searchin' => 'o.status'
				),
				'processor' => array(
					'search_type' => 'select', 'select_options' => $processor, 'type' => 'equal', 'searchin' => 'o.processor'
				),
				'cdate' => array(
					'search_type' => 'date.range',
					'searchin' => 'cdate',
					'cdate_from' => array('attrib' => array('placeholder' => 'YYYY-MM-DD', 'onChange' => 'tjrContentUI.report.attachCalSubmit(this);')),
					'cdate_to' => array('attrib' => array('placeholder' => 'YYYY-MM-DD', 'onChange' => 'tjrContentUI.report.attachCalSubmit(this);'))
				)
			)
		);

		if (count($reportOptions) > 1)
		{
			$dispFilters[1] = array();
			$dispFilters[1]['report_filter'] = array( 'search_type' => 'select',
			'select_options' => $reportOptions );
		}

		// Joomla fields integration
		// Call parent function to set filters for custom fields
		if (method_exists(get_parent_class($this), 'setCustomFieldsDisplayFilters'))
		{
			parent::setCustomFieldsDisplayFilters($dispFilters);
		}

		return $dispFilters;
	}

	/**
	 * Method to get a JDatabaseQuery object for retrieving the data set from a database.
	 *
	 * @return  JDatabaseQuery  A JDatabaseQuery object to retrieve the data set.
	 *
	 * @since   __DEPLOY_VERISION__
	 */
	protected function getListQuery()
	{
		$db        = $this->_db;
		$query     = parent::getListQuery();
		$colToshow = $this->getState('colToshow');

		$query->select(
		array('o.*, u.*, o.name as user_name, o.order_id as id, e.id as event_id, e.title as event_title,
		 e.created_by as event_creator,
		(
		CASE
		 WHEN o.status = "C" THEN "Complete"
		 WHEN o.status = "RF" THEN "Refunded"
		 WHEN o.status = "P" THEN "Pending"
		 WHEN o.status = "D" THEN "Declined"
		 WHEN o.status = "E" THEN "Failed"
		 WHEN o.status = "UR" THEN "Under Review"
		 WHEN o.status = "CRV" THEN "Cancel Reversed"
		 WHEN o.status = "RV" THEN "Reversed"
		 WHEN o.status = "I" THEN "Initiated"
		ELSE "-"
		END) as status')
		);
		$query->from($db->quoteName('#__jticketing_order') . 'AS o');
		$query->join('INNER', $db->quoteName('#__jticketing_events', 'e') . ' ON (' .
			$db->quoteName('o.event_details_id') . ' = ' . $db->quoteName('e.id') . ')');
		$query->join('INNER', $db->quoteName('#__jticketing_users', 'u') . ' ON (' .
			$db->quoteName('u.order_id') . ' = ' . $db->quoteName('o.id') . ')');

		if (in_array('created_by', $colToshow))
		{
			$query->select('us.name as created_by');
			$query->join('LEFT', $db->quoteName('#__users', 'us') . ' ON (' . $db->quoteName('e.created_by') .
				' = ' . $db->quoteName('us.id') . ')');
		}

		if (in_array('ticket_count', $colToshow))
		{
			$query->select('SUM(oi.ticketcount) as ticket_count');
			$query->join('LEFT', $db->quoteName('#__jticketing_order_items', 'oi') . ' ON (' . $db->quoteName('o.id') .
				' = ' . $db->quoteName('oi.order_id') . ')');
		}

		$query->group('oi.order_id');

		return $query;
	}

	/**
	 * Method to get an array of data items.
	 *
	 * @return  mixed  An array of data items on success, false on failure.
	 *
	 * @since   __DEPLOY_VERISION__
	 */
	public function getItems()
	{
		// Add additional columns which are not part of the query
		$items = parent::getItems();

		$colToshow = $this->getState('colToshow');

		foreach ($items as $key => $item)
		{
			if (in_array('coupon_code', $colToshow))
			{
				if ($item['coupon_code'] == '')
				{
					$item['coupon_code'] = '-';
				}
			}

			if (in_array('coupon_discount', $colToshow))
			{
				if ($item['coupon_discount'] == '')
				{
					$item['coupon_discount'] = '-';
				}
			}

			if (in_array('processor', $colToshow))
			{
				if ($item['processor'] == '')
				{
					$item['processor'] = '-';
				}
			}

			if (in_array('business_name', $colToshow))
			{
				if ($item['business_name'] == '')
				{
					$item['business_name'] = '-';
				}
			}

			if (in_array('vat_number', $colToshow))
			{
				if ($item['vat_number'] == '')
				{
					$item['vat_number'] = '-';
				}
			}

			$TjGeoHelper = new TjGeoHelper;

			if (in_array('country_code', $colToshow))
			{
				if ($item['country_code'])
				{
					$item['country_code'] = $TjGeoHelper->getCountryNameFromId($item['country_code']);
				}
				else
				{
					$item['country_code'] = '-';
				}
			}

			if (in_array('state_code', $colToshow))
			{
				if ($item['state_code'])
				{
					$item['state_code'] = $TjGeoHelper->getRegionNameFromId($item['state_code']);
				}
				else
				{
					$item['state_code'] = '-';
				}
			}

			if (in_array('created_by', $colToshow))
			{
				$item['created_by'] = $item['created_by'];

				if (empty($item['created_by']) || ($item['block'] == 1))
				{
					$item['created_by'] = Text::_('COM_JTICKETING_BLOCKED_USER');
				}
			}

			$items[$key] = $item;
		}

		$items = $this->sortCustomColumns($items);

		return $items;
	}

	/**
	 * Create an array of fields in the form of Google data studio requires
	 * Array(
	 *   array(
	 *		'name' => internal name of the field
	 * 		'label' => Name to be displayed on the report
	 *      'dataType' => 'NUMBER' OR 'STRING' OR 'BOOLEAN'
	 * 		'semantics' => array('conceptType' => 'DIMENSION' OR 'METRIC')
	 * 	  ),
	 * )
	 *
	 * More information about fields https://developers.google.com/datastudio/connector/reference#data_types
	 *
	 * @return  ARRAY
	 *
	 * @since   __DEPLOY_VERISION__
	 */
	public function getGDSFields()
	{
		return array(
			array('name' => 'order_id', 'label' => Text::_('COM_JTICKETING_ORDER_ID'),
				'dataType' => 'NUMBER', 'semantics' => array('conceptType' => 'DIMENSION')),
			array('name' => 'event_id', 'label' => Text::_('COM_JTICKETING_EVENT_ID'),
				'dataType' => 'NUMBER', 'semantics' => array('conceptType' => 'DIMENSION')),
			array('name' => 'title', 'label' => Text::_('COM_JTICKETING_EVENT_NAME'),
				'dataType' => 'STRING', 'semantics' => array('conceptType' => 'DIMENSION')),
			array('name' => 'created_by', 'label' => Text::_('JGLOBAL_FIELD_CREATED_BY_LABEL'),
				'dataType' => 'STRING', 'semantics' => array('conceptType' => 'DIMENSION')),
			array('name' => 'user_id', 'label' => Text::_('PLG_TJREPORTS_ORDERREPORT_USER'),
				'dataType' => 'NUMBER',
				'semantics' => array('conceptType' => 'DIMENSION')),
			array('name' => 'user_name', 'label' => Text::_('PLG_TJREPORTS_ORDERREPORT_USER_NAME'),
				'dataType' => 'STRING', 'semantics' => array('conceptType' => 'DIMENSION')),
			array('name' => 'user_email', 'label' => Text::_('PLG_TJREPORTS_ORDERREPORT_USER_EMAIL'),
				'dataType' => 'STRING', 'semantics' => array('conceptType' => 'DIMENSION')),
			array('name' => 'business_name', 'label' => Text::_('PLG_TJREPORTS_ORDERREPORT_BUSINESS_NAME'),
				'dataType' => 'STRING', 'semantics' => array('conceptType' => 'DIMENSION')),
			array('name' => 'vat_number', 'label' => Text::_('PLG_TJREPORTS_ORDERREPORT_VAT_NUMBER'),
				'dataType' => 'NUMBER', 'semantics' => array('conceptType' => 'DIMENSION')),
			array('name' => 'phone', 'label' => Text::_('PLG_TJREPORTS_ORDERREPORT_USER_PHONE'),
				'dataType' => 'NUMBER', 'semantics' => array('conceptType' => 'DIMENSION')),
			array('name' => 'address', 'label' => Text::_('PLG_TJREPORTS_ORDERREPORT_USER_ADDRESS'),
				'dataType' => 'NUMBER', 'semantics' => array('conceptType' => 'DIMENSION')),
			array('name' => 'city', 'label' => Text::_('PLG_TJREPORTS_ORDERREPORT_USER_CITY'),
				'dataType' => 'STRING', 'semantics' => array('conceptType' => 'DIMENSION')),
			array('name' => 'country_code', 'label' => Text::_('PLG_TJREPORTS_ORDERREPORT_USER_COUNTRY_NAME'),
				'dataType' => 'STRING', 'semantics' => array('conceptType' => 'DIMENSION')),
			array('name' => 'state_code', 'label' => Text::_('PLG_TJREPORTS_ORDERREPORT_USER_STATE_NAME'),
				'dataType' => 'STRING', 'semantics' => array('conceptType' => 'DIMENSION')),
			array('name' => 'cdate', 'label' => Text::_('PLG_TJREPORTS_ORDERREPORT_ORDER_CREATED_DATE'),
				'dataType' => 'STRING', 'semantics' => array('conceptType' => 'DIMENSION', 'semanticType' => 'YEAR_MONTH_DAY')),
			array('name' => 'order_amount', 'label' => Text::_('PLG_TJREPORTS_ORDERREPORT_ORDER_AMOUNT'),
				'dataType' => 'NUMBER', 'semantics' => array('conceptType' => 'DIMENSION')),
			array('name' => 'original_amount', 'label' => Text::_('PLG_TJREPORTS_ORDERREPORT_ORIGINAL_AMOUNT'),
				'dataType' => 'NUMBER', 'semantics' => array('conceptType' => 'DIMENSION')),
			array('name' => 'fee', 'label' => Text::_('PLG_TJREPORTS_ORDERREPORT_FEE'),
				'dataType' => 'NUMBER', 'semantics' => array('conceptType' => 'DIMENSION')),
			array('name' => 'coupon_code', 'label' => Text::_('PLG_TJREPORTS_ORDERREPORT_COUPON_CODE'),
				'dataType' => 'STRING', 'semantics' => array('conceptType' => 'DIMENSION')),
			array('name' => 'status', 'label' => Text::_('PLG_TJREPORTS_ORDERREPORT_ORDER_STATUS'),
				'dataType' => 'STRING', 'semantics' => array('conceptType' => 'DIMENSION')),
			array('name' => 'processor', 'label' => Text::_('PLG_TJREPORTS_ORDERREPORT_ORDER_PROCESSOR'),
				'dataType' => 'STRING', 'semantics' => array('conceptType' => 'DIMENSION')),
			array('name' => 'ticket_count', 'label' => Text::_('PLG_TJREPORTS_ORDERREPORT_TICKET_COUNT'),
				'dataType' => 'NUMBER', 'semantics' => array('conceptType' => 'DIMENSION')),
			array('name' => 'order_tax', 'label' => Text::_('PLG_TJREPORTS_ORDERREPORT_ORDER_TAX'),
				'dataType' => 'NUMBER', 'semantics' => array('conceptType' => 'DIMENSION')),
			array('name' => 'coupon_discount', 'label' => Text::_('PLG_TJREPORTS_ORDERREPORT_COUPON_DISCOUNT'),
				'dataType' => 'NUMBER', 'semantics' => array('conceptType' => 'DIMENSION')),
		);
	}
}
