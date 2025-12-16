<?php
/**
 * @version    SVN: <svn_id>
 * @package    Com_Jticketing
 * @copyright  Copyright (C) 2005 - 2017. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 * Shika is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 */
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Component\ComponentHelper;
use Joomla\String\StringHelper;
use Joomla\CMS\Application\CMSApplication;
use Joomla\CMS\Table\Table;
use Joomla\Filesystem\File;
use Joomla\CMS\Installer\Installer;
use Joomla\CMS\Installer\InstallerAdapter;
use Joomla\CMS\Log\Log;
use Joomla\Database\DatabaseInterface;

/**
 * Script file of JTicketing component
 *
 * @since  1.0.0
 **/
class com_jticketingInstallerScript
{
	/**
	 * Database driver
	 *
	 * @var DatabaseInterface
	 */
	private $db;

	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->db = Factory::getContainer()->get(DatabaseInterface::class);
	}

	/** @var array The list of extra modules and plugins to install */
	private array $uninstallation_queue = array(
		// @modules => { (folder) => { (module) => { (position), (published) } }* }*
		'modules' => array(
			'admin' => array(),
			'site' => array(
				'mod_jticketing_buy'       => 0,
				'mod_jticketing_event'     => 0,
				'mod_jticketing_menu'      => 0,
				'mod_jticketing_calendar'  => 0,
				'mod_jticketing_recommend' => 0
			)
		),

		// @plugins => { (folder) => { (element) => (published) }* }*
		'plugins' => array(
			'actionlog' => array(
				'jticketing' => 1
			),
			'api' => array(
				'jticket' => 1,
				'jlike'   => 1
			),
			'community' => array(
				'addfields' => 0
			),
			'content' => array(
				'jlike_events' => 1
			),
			'jevents' => array(
				'addfields' => 0
			),
			'jticketingtax' => array(
				'jticketing_tax_default' => 0
			),
			'privacy' => array(
				'jticketing' => 1
			),
			'search' => array(
				'jtevents' => 1
			),
			'system' => array(
				'jticketing_j3'        => 1,
				'plug_sys_jticketing'  => 1,
				'tjassetsloader'       => 1,
				'jticketingactivities' => 1,
				'tjupdates'            => 1
			),
			'tjevents' => array(
				'plug_tjevents_adobeconnect' => 1,
				'zoom' => 1,
				'jaas' => 1,
				'googlemeet' => 1,
			),
			'tjlmsdashboard' => array(
				'eventlist' => 1,
			),
			'tjsms' => array(
				'smshorizon' => 0,
				'clickatell' => 1
			),
			'tjreports' => array(
				'attendeereport'      => 1,
				'customerreport'      => 1,
				'eventcategoryreport' => 1,
				'eventreport'         => 1,
				'salesreport'         => 1
			),
			'jticketing' => array(
				'rsform' => 0
			),
			'finder' => array(
				'jticketingevents' => 0
			),
		),

		'applications' => array(
			'easysocial' => array(
				'jticketMyEvents'       => 0,
				'jticket_boughttickets' => 0,
				'jticketingtickettypes' => 1
			)
		),

		'dynamics' => array(
			'jticketing' => 1
		)
	);

	/**
	 * method to install the component
	 *
	 * @param   InstallerAdapter  $parent  Parent installer adapter
	 *
	 * @return void
	 */
	public function install(InstallerAdapter $parent): void
	{
		// $parent is the class calling this method
		$this->installSqlFiles($parent);

		$this->setjticketingdefaultBavior();

		// add acymailing integration
		$this->addAcyMalingIntegration();
	}

	/**
	 * method to uninstall the component
	 *
	 * @param   InstallerAdapter  $parent  Parent installer adapter
	 *
	 * @return void
	 */
	public function uninstall(InstallerAdapter $parent): void
	{
		// Uninstall subextensions
		$status = $this->_uninstallSubextensions($parent);
	}

	/**
	 * method to setjticketingdefaultBavior
	 *
	 * @return void|boolean  in case of success return void incase of failure return false
	 */
	public function setjticketingdefaultBavior()
	{
		$user = Factory::getUser();
		// Use $this->db instead

		// Check if tag exists
		$sql = $this->db->getQuery(true)->select($this->db->quoteName('type_id'))
			->from($this->db->quoteName('#__content_types'))
			->where($this->db->quoteName('type_title') . ' = ' . $this->db->quote('Event'))
			->where($this->db->quoteName('type_alias') . ' = ' . $this->db->quote('com_jticketing.event'));
		$this->db->setQuery($sql);
		$type_id = (int) ($this->db->loadResult() ?? 0);

		// Create tag
		$tagobject                          = new stdclass;
		$tagobject->type_id                 = '';
		$tagobject->type_title              = 'Event';
		$tagobject->type_alias              = 'com_jticketing.event';
		$tagobject->table                   = '{"special":{"dbtable":"#__jticketing_events","key":"id","type":"Jticketingevent",'
		. '"prefix":"JTable","config":"array()"},'
		. '"common":{"dbtable":"#__ucm_content","key":"ucm_id","type":"Corecontent","prefix":"JTable","config":"array()"}}';
		$tagobject->rules                   = '';

		$field_mappings_arr = array(
		'common' => array(
					"core_content_item_id" => "id",
					"core_title" => "title",
					"core_state" => "state",
					"core_alias" => "alias",
					"core_created_time" => "created",
					"core_modified_time" => "modified",
					"core_body_short" => "short_description",
					"core_body_long" => "long_description",
					"core_hits" => "null",
					"core_publish_up" => "null",
					"core_publish_down" => "enddate",
					"core_access" => "access",
					"core_params" => "jt_params",
					"core_featured" => "featured",
					"core_metadata" => "null",
					"core_language" => "null",
					"core_images" => "image",
					"core_urls" => "null",
					"core_version" => "null",
					"core_ordering" => "ordering",
					"core_metakey" => "null",
					"core_metadesc" => "null",
					"core_catid" => "catid",
					"core_xreference" => "null",
					"asset_id" => "null"
				),
		'special' => array(
					"parent_id" => "parent_id",
					"lft" => "lft",
					"rgt" => "rgt",
					"level" => "level",
					"path" => "path",
					"path" => "path",
					"extension" => "extension",
					"extension" => "extension",
					"note" => "note"
					)
		);
		$tagobject->field_mappings          = json_encode($field_mappings_arr);

		$tagobject->router                  = 'JTRouteHelper::getEventRoute';

		$content_history_options_arr = array(
		'formFile' => "administrator\/components\/com_jticketing\/models\/forms\/event.xml",
		'hideFields' => '["asset_id","checked_out","checked_out_time"],"ignoreChanges":["checked_out", "checked_out_time"]',
		'convertToInt' => '["ordering"]',
		'displayLookup' => '[{"sourceColumn":"cat_id",
		"targetTable":"#__categories","targetColumn":"id","displayColumn":"title"},
		{"sourceColumn":"created_by","targetTable":"#__users","targetColumn":"id","displayColumn":"name"}]'
		);

		$tagobject->content_history_options = json_encode($content_history_options_arr);

		if (!$type_id)
		{
			try
			{
				$this->db->insertObject('#__content_types', $tagobject, 'type_id');
			}
			catch (\RuntimeException $e)
			{
				Log::add(
					Text::sprintf('JLIB_INSTALLER_ERROR_SQL_ERROR', $e->getMessage()),
					Log::WARNING,
					'jerror'
				);
				return;
			}
		}
		else
		{
			$tagobject->type_id = $type_id;

			try
			{
				$this->db->updateObject('#__content_types', $tagobject, 'type_id');
			}
			catch (\RuntimeException $e)
			{
				Log::add(
					Text::sprintf('JLIB_INSTALLER_ERROR_SQL_ERROR', $e->getMessage()),
					Log::WARNING,
					'jerror'
				);
				return;
			}
		}

		/** @var JTableContentType $table */
		$table	= JTable::getInstance('contenttype');
			$table->load(array('type_alias' => 'com_jticketing.category'));

		if (!$table->type_id)
		{
			$data	= array(
				'type_title'		=> 'Event Category',
				'type_alias'		=> 'com_jticketing.category',
				'table'				=> '{"special":{"dbtable":"#__categories","key":"id","type":"Category","prefix":"JTable","config":"array()"},'
				. '"common":{"dbtable":"#__ucm_content","key":"ucm_id","type":"Corecontent","prefix":"JTable","config":"array()"}}',
				'rules'				=> '',
				'field_mappings'	=> '
				{"common":{
				"core_content_item_id":"id",
				"core_title":"title",
				"core_state":"published",
				"core_alias":"alias",
				"core_created_time":"created_time",
				"core_modified_time":"modified_time",
				"core_body":"description",
				"core_hits":"hits",
				"core_publish_up":"null",
				"core_publish_down":"null",
				"core_access":"access",
				"core_params":"params", "core_featured":"null",
				"core_metadata":"metadata", "core_language":"language",
				"core_images":"null", "core_urls":"null", "core_version":"version", "core_ordering":"null", "core_metakey":"metakey",
				"core_metadesc":"metadesc", "core_catid":"parent_id",
				"core_xreference":"null", "asset_id":"asset_id"},
				"special": {
				"parent_id":"parent_id",
				"lft":"lft",
				"rgt":"rgt",
				"level":"level",
				"path":"path",
				"extension":"extension",
				"note":"note"
				}
				}',
				'content_history_options' => '{"formFile":"administrator\/components\/com_categories\/models\/forms\/category.xml",
				"hideFields":["asset_id","checked_out","checked_out_time","version","lft","rgt","level","path","extension"],

				"ignoreChanges":["modified_user_id", "modified_time", "checked_out", "checked_out_time", "version", "hits", "path"],

				"convertToInt":["publish_up", "publish_down"],
				"displayLookup":[{"sourceColumn":"created_user_id","targetTable":"#__users","targetColumn":"id",
				"displayColumn":"name"},
				{"sourceColumn":"access","targetTable":"#__viewlevels","targetColumn":"id","displayColumn":"title"},
				{"sourceColumn":"modified_user_id","targetTable":"#__users","targetColumn":"id","displayColumn":"name"},
				{"sourceColumn":"parent_id","targetTable":"#__categories","targetColumn":"id","displayColumn":"title"}]}',
			);

			$table->bind($data);

			if ($table->check())
			{
				$table->store();
			}
		}

		//  Tags for venue category field
		/** @var JTableContentType $table */
		$table	= JTable::getInstance('contenttype');
		$table->load(array('type_alias' => 'com_jticketing.venues.category'));

		if (!$table->type_id)
		{
			$data	= array(
				'type_title'		=> 'Venue Category',

				'type_alias'		=> 'com_jticketing.venues.category',
				'table'				=> '
					{"special":{"dbtable":"#__categories","key":"id","type":"CategoryTable",
						"prefix":"Joomla\\Component\\Categories\\Administrator\\Table\\","config":"array()"},
						"common":{"dbtable":"#__ucm_content","key":"ucm_id","type":"Corecontent",
						"prefix":"Joomla\\CMS\\Table\\","config":"array()"}}',

				'rules'				=> '',
				'field_mappings'	=> '
					{"common":{"core_content_item_id":"id","core_title":"title","core_state":"published","core_alias":"alias",
						"core_created_time":"created_time","core_modified_time":"modified_time","core_body":"description", 
						"core_hits":"hits","core_publish_up":"null","core_publish_down":"null","core_access":"access", "core_params":"params", 
						"core_featured":"null", "core_metadata":"metadata", "core_language":"language", "core_images":"null", 
						"core_urls":"null", "core_version":"version", "core_ordering":"null", "core_metakey":"metakey", 
						"core_metadesc":"metadesc", "core_catid":"parent_id", "asset_id":"asset_id"}, 
						"special":{"parent_id":"parent_id","lft":"lft","rgt":"rgt","level":"level","path":"path","extension":"extension","note":"note"}}',

				'content_history_options' => '{"formFile":"administrator\/components\/com_categories\/forms\/category.xml", 
					"hideFields":["checked_out","checked_out_time","version","lft","rgt","level","path","extension"], 
					"ignoreChanges":["modified_user_id", "modified_time", "checked_out", "checked_out_time", "version", "hits", "path"], 
					"convertToInt":["publish_up", "publish_down"], 
					"displayLookup":[{"sourceColumn":"created_user_id",
					"targetTable":"#__users","targetColumn":"id","displayColumn":"name"}, 
					{"sourceColumn":"access","targetTable":"#__viewlevels","targetColumn":"id","displayColumn":"title"},
					{"sourceColumn":"modified_user_id","targetTable":"#__users","targetColumn":"id","displayColumn":"name"},
					{"sourceColumn":"parent_id","targetTable":"#__categories","targetColumn":"id","displayColumn":"title"}]}',
			);

			$table->bind($data);

			if ($table->check())
			{
				$table->store();
			}
		}

		// Create default category on installation if not exists
		$sql = $this->db->getQuery(true)->select($this->db->quoteName('id'))
			->from($this->db->quoteName('#__categories'))
			->where($this->db->quoteName('extension') . ' = ' . $this->db->quote('com_jticketing'));

		$this->db->setQuery($sql);
		$cat_id = (int) ($this->db->loadResult() ?? 0);

		if (empty($cat_id))
		{
			$catobj        = new stdClass;
			$catobj->title = 'Uncategorised';
			$catobj->alias = 'uncategorised';

			$catobj->extension = "com_jticketing";
			$catobj->path      = "uncategorised";
			$catobj->parent_id = 1;
			$catobj->level     = 1;
			$catobj->created_user_id = $user->id;
			$catobj->language        = "*";
			$catobj->description     = '<p>This is a default Event category</p>';
			$createdDateTime = Factory::getDate('now');
			$catobj->created_time = $createdDateTime->toSQL();
			$catobj->modified_time = $createdDateTime->toSQL();
			$catobj->published = 1;
			$catobj->access    = 1;

			if (!$this->db->insertObject('#__categories', $catobj, 'id'))
			{
				Log::add('Error inserting category', Log::WARNING, 'com_jticketing');

				return false;
			}
		}
	}

	public function row2text($row,$dvars=array())
	{
		reset($dvars);
		foreach ($dvars as $idx => $var)
		{
			unset($row[$var]);
		}

		$text='';
		reset($row);
		$flag=0;
		$i=0;

		foreach ($row as $var => $val)
		{
			if($flag==1)
			$text.=",\n";
			elseif($flag==2)
			$text.=",\n";
			$flag=1;

			if(is_numeric($var))
			if($var[0]=='0')
			$text.="'$var'=>";
			else
			{
				if($var!==$i)
				$text.="$var=>";
				$i=$var;
			}
			else
			$text.="'$var'=>";
			$i++;

			if(is_array($val))
			{
				$text.="array(".$this->row2text($val,$dvars).")";
				$flag=2;
			}
			else
			$text.="\"".addslashes($val)."\"";
		}

		return($text);
	}

	/**
	 * method to update the component
	 *
	 * @return void
	 */
	public function update(InstallerAdapter $parent): void
	{
		// Install SQL FIles
		$this->installSqlFiles($parent);
		$this->fix_db_on_update();

		// To remove short description
		$this->removeShortDescription($parent);

		// To add event alias
		$this->addEventAlias($parent);

		// To add venue alias
		$this->addVenueAlias($parent);

		$this->deleteCategoryReport();
		$this->setjticketingdefaultBavior();

		// add acymailing integration
		$this->addAcyMalingIntegration();
	}

	/**
	 * Delete category report
	 *
	 * @return Boolean
	 *
	 * @since 2.1
	 */
	public function deleteCategoryReport()
	{
		// Delete the category report entry from report table.

		// Use $this->db instead
		$selectReport = $this->db->getQuery(true);

		$conditions = array(
		$this->db->quoteName('client') . ' = ' . $this->db->quote('com_jticketing'),
		$this->db->quoteName('plugin') . ' = ' . $this->db->quote('categoryreport')
		);

		$selectReport->select('*');
		$selectReport->from($this->db->quoteName('#__tj_reports'));
		$selectReport->where($conditions);
		$this->db->setQuery($selectReport);
		$confrim = $this->db->execute();

		if (!empty($confrim))
		{
			// Use $this->db instead
			$deleteReport = $this->db->getQuery(true);
			$deleteReport->delete($this->db->quoteName('#__tj_reports'));
			$deleteReport->where($conditions);
			$this->db->setQuery($deleteReport);
			$result = $this->db->execute();
		}
	}

	/**
	 * method to run before an install/update/uninstall method
	 *
	 * @return void
	 */
	public function preflight(string $type, InstallerAdapter $parent): void
	{
	}

	/**
	 * method to run after an install/update/uninstall method
	 *
	 * @return void
	 */
	public function postflight(string $type, InstallerAdapter $parent): void
	{
		// Delete existing log file for security purpose
		$this->deleteLog();

		// Add sample field manager data.
		$fieldsManagerDataStatus = $this->_installSampleFieldsManagerData();

		if ($fieldsManagerDataStatus)
		{
			Factory::getApplication()->enqueueMessage(Text::_('COM_JTICKETING_FIELDS_SAMPLE_DATA_INSTALLED'), 'message');
		}

		// Add core fields manager .
		$fieldsManagerDataStatus = $this->_installSampleCoreFieldsJTicketing();

		if ($fieldsManagerDataStatus)
		{
			Factory::getApplication()->enqueueMessage(Text::_('COM_JTICKETING_FIELDS_SAMPLE_CORE_FIELDS_INSTALLED'), 'message');
		}

		// Add Categories for native events
		$basicCategories = $this->_installbasicCategories();

		if ($basicCategories)
		{
			Factory::getApplication()->enqueueMessage(Text::_('COM_JTICKETING_FIELDS_SAMPLE_CATEGORY_INSTALLED'), 'message');
		}

		// Add Categories for native events
		$basicCategoriesforVenues = $this->_installbasicCategoriesforVenues();

		if ($basicCategoriesforVenues)
		{
			Factory::getApplication()->enqueueMessage(Text::_('COM_JTICKETING_FIELDS_SAMPLE_CATEGORY_INSTALLED'), 'message');
		}

		// Add default permissions
		$this->deFaultPermissionsFix();

		// Write template file for email and pdf template
		$this->_writeTemplate();

		if ($type=='install')
		{
			Factory::getApplication()->enqueueMessage(Text::_('COM_JTICKETING_' . $type . '_TEXT'), 'message');
		}
		else
		{
			Factory::getApplication()->enqueueMessage(Text::_('COM_JTICKETING_' . $type . '_TEXT'), 'message');
		}

		// Set default layouts to load
		$this->setDefaultLayout($type);

		// Add All Events menu in the main menu
		$menuMsg = $this->_addMenuItems();

		if ($menuMsg)
		{
			Factory::getApplication()->enqueueMessage(Text::_('COM_JTICKETING_ALL_EVENTS_MENU_CREATED'), 'message');
		}

		// Add my events menu in the main menu
		$myEventsMenuMsg = $this->_addMyEventsMenu();

		if ($myEventsMenuMsg)
		{
			Factory::getApplication()->enqueueMessage(Text::_('COM_JTICKETING_MY_EVENTS_MENU_CREATED'), 'message');
		}
		
		// Need to verify We have written that code removes duplicate menu entry from table
		$this->menuItemMigration();

	}

	/**
	 * method to install default email templates
	 *
	 * @return void
	 */
	private function _writeTemplate()
	{
		// Write default config template for PDF(Which is attached to Ticket email)
		$this->_writeTicketTemplate();

		// Insert the required data for notifications template
		$this->_installNotificationsTemplates();

		// Insert Certificate templates
		$this->installCertificateTemplates();
	}

	/**
	 * method to install default ticket templates
	 *
	 * @return void
	 */
	private function _writeTicketTemplate()
	{
		// Code for email template
		$filename = JPATH_ADMINISTRATOR . '/components/com_jticketing/config.php';
		$filename_default = JPATH_ADMINISTRATOR . '/components/com_jticketing/config_default.php';

		// If config file does not exists
		if (!JFile::exists($filename))
		{
			JFile::move($filename_default,$filename);
			include($filename);

			$emails_config_new = array();
			$emails_config_new['message_body'] = $emails_config["message_body"];
			$emails_config_file_contents = "<?php \n\n";
			$emails_config_file_contents .= "\$emails_config=array(\n" . $this->row2text($emails_config_new) . "\n);\n";
			$emails_config_file_contents .= "\n?>";

			JFile::delete($filename);
			JFile::write($filename, $emails_config_file_contents);
		}
		elseif (JFile::exists($filename_default))
		{
			// If config file exists
			JFile::delete($filename_default);
		}
	}

	/**
	 * TODO - Check its use and remove the function
	 * Add default ACL permissions if already set by administrator
	 *
	 * @return  void
	 */
	public function deFaultPermissionsFix()
	{
		// Use $this->db instead
		$query = "SELECT id, rules FROM `#__assets` WHERE `name` = 'com_jticketing' ";
		$this->db->setQuery($query);
		$result = $this->db->loadObject();

		if (strlen(trim($result->rules))<=3)
		{
			$obj = new Stdclass();
			$obj->id = $result->id;
			$obj->rules = '{"core.admin":[],"core.manage":[],"core.create":{"2":1},"core.delete":{"2":1},"core.edit":{"2":1},"core.edit.state":{"2":1},"core.edit.own":{"2":1},"core.enrollown":{"7":0}, "core.enrollall":{"7":0},"core.enroll":{"7":0},"coupon.create":{"2":1},"coupon.view":{"2":1},"coupon.edit.own":{"2":1},"coupon.edit":{"2":1},"coupon.edit.state":{"2":1},"coupon.delete":{"2":1}}';

			if (!$this->db->updateObject('#__assets', $obj, 'id'))
			{
				$app = Factory::getApplication();
				Log::add('Error in database operation', Log::WARNING, 'com_jticketing');
			}
		}
	}

	/**
	 * installSqlFiles
	 *
	 * @param   JInstaller  $parent  parent
	 *
	 * @return  void
	 */
	public function installSqlFiles($parent)
	{
		// Use $this->db instead

		// Obviously you may have to change the path and name if your installation SQL file
		if (method_exists($parent, 'extension_root'))
		{
			$sqlfile = $parent->getPath('extension_root') . '/admin/sql/install.sql';
		}
		else
		{
			$sqlfile = $parent->getParent()->getPath('extension_root') . '/sql/install.sql';
		}

		// Don't modify below this line
		$buffer = file_get_contents($sqlfile);

		if ($buffer !== false)
		{

			$queries = $this->db->splitSql($buffer);

			if (count($queries) != 0)
			{
				foreach ($queries as $query)
				{
					$query = trim($query);

					if ($query != '' && $query[0] != '#')
					{
						$this->db->setQuery($query);

						if (!$this->db->execute())
						{
							Log::add(Text::sprintf('JLIB_INSTALLER_ERROR_SQL_ERROR', 'SQL execution failed'), Log::WARNING, 'jerror');

							return false;
						}
					}
				}
			}
		}

		$config = Factory::getConfig();
		$configdb = $config->get('db');

		// Get dbprefix
		$dbprefix = $config->get('dbprefix');
	}

	/**
	 * install core attendee fields in JTicketing
	 *
	 * @param   JInstaller  $parent  parent
	 *
	 * @return  void
	 */
	private function _installSampleCoreFieldsJTicketing()
	{
		// Check if file is present.
		// Use $this->db instead

		// Check if any core ateende fields  exists.
		$query = $this->db->getQuery(true);
		$query->select('COUNT(aflds.id) AS count');
		$query->from('`#__jticketing_attendee_fields` AS aflds');
		$query->where('aflds.core=1');
		$this->db->setQuery($query);
		$attendee_fields = (int) ($this->db->loadResult() ?? 0);

		if (empty($attendee_fields))
		{
			// If no core ateende fields, add a sample one.First name,Last name is required
			$queries[] = "INSERT INTO `#__jticketing_attendee_fields` (`eventid`, `placeholder`, `type`, `label`, `name`,`core`,`state`,`required`, `options`, `default_selected_option`) VALUES(0, 'COM_JTICKETING_AF_FNAME','text','COM_JTICKETING_AF_FNAME','first_name',1,1,1, '', '');";
			$queries[] = "INSERT INTO `#__jticketing_attendee_fields` (`eventid`, `placeholder`, `type`, `label`, `name`,`core`,`state`,`required`, `options`, `default_selected_option`) VALUES(0, 'COM_JTICKETING_AF_LNAME','text','COM_JTICKETING_AF_LNAME','last_name',1,1,1, '', '');";
			$queries[] = "INSERT INTO `#__jticketing_attendee_fields` (`eventid`, `placeholder`, `type`, `label`, `name`,`core`,`state`,`required`, `options`, `default_selected_option`) VALUES(0, 'COM_JTICKETING_AF_PHONE','text','COM_JTICKETING_AF_PHONE','phone',1,1,1, '', '');";
			$queries[] = "INSERT INTO `#__jticketing_attendee_fields` (`eventid`, `placeholder`, `type`, `label`, `name`,`core`,`state`,`required`, `options`, `default_selected_option`) VALUES(0, 'COM_JTICKETING_AF_EMAIL','text','COM_JTICKETING_AF_EMAIL','email',1,1,1, '', '');";

			// Execute sql queries.
			if (count($queries) != 0)
			{
				foreach ($queries as $query)
				{
					$query = trim($query);

					if ($query != '')
					{
						$this->db->setQuery($query);

						if (!$this->db->execute())
						{
							Log::add(Text::sprintf('JLIB_INSTALLER_ERROR_SQL_ERROR', 'SQL execution failed'), Log::WARNING, 'jerror');

							return false;
						}
					}
				}
			}
		}

		return true;
	}

	/**
	 * install event categories in JTicketing
	 *
	 * @param   JInstaller  $parent  parent
	 *
	 * @return  void
	 */
	private function _installbasicCategories()
	{
		// File class already imported
		// Use $this->db instead
		$user = Factory::getUser();

		// Check if any categories present for jticketing.
		$query = $this->db->getQuery(true);
		$query->select('COUNT(cat.id) AS count');
		$query->from('`#__categories` AS cat');
		$search = $this->db->quote('com_jticketing');
		$query->where('cat.extension=' . $search);
		$this->db->setQuery($query);
		$CategoryCount = (int) ($this->db->loadResult() ?? 0);

		// If no category found, add a sample one.
		if (!$CategoryCount)
		{
				$catobj=new stdClass;
				$catobj->title = 'General';
				$catobj->alias = 'General';;
				$catobj->extension="com_jticketing";
				$catobj->path=" General";
				$catobj->parent_id=1;
				$catobj->level=1;

				$paramdata=array();
				$paramdata['category_layout']='';
				$paramdata['image']='';
				$catobj->params=json_encode($paramdata);

				$catobj->created_user_id=$user->id;
				$catobj->language="*";
				//$catobj->description = $category->description;
				$createdDateTime = Factory::getDate('now');
				$catobj->created_time = $createdDateTime->toSQL();
				$catobj->modified_time = $createdDateTime->toSQL();
				$catobj->published = 1;
				$catobj->access = 1;
				if(!$this->db->insertObject('#__categories',$catobj,'id'))
				{
					Log::add('Error inserting category', Log::WARNING, 'com_jticketing');
					return false;
				}
			return true;
		}
	}

	/**
	 * install venue categories in JTicketing
	 *
	 * @param   JInstaller  $parent  parent
	 *
	 * @return  void
	 */
	private function _installbasicCategoriesforVenues()
	{
		// File class already imported
		// Use $this->db instead
		$user = Factory::getUser();


		// Check if any categories present for jticketing.
		$query = $this->db->getQuery(true);
		$query->select('COUNT(cat.id) AS count');
		$query->from('`#__categories` AS cat');
		$search = $this->db->quote('com_jticketing.venues');
		$query->where('cat.extension=' . $search);
		$this->db->setQuery($query);
		$CategoryCount = (int) ($this->db->loadResult() ?? 0);

		// If no category found, add a sample one.
		if (!$CategoryCount)
		{
				$catobj=new stdClass;
				$catobj->title = 'General';
				$catobj->alias = 'General';;
				$catobj->extension="com_jticketing.venues";
				$catobj->path=" General";
				$catobj->parent_id=1;
				$catobj->level=1;

				$paramdata=array();
				$paramdata['category_layout']='';
				$paramdata['image']='';
				$catobj->params=json_encode($paramdata);

				$catobj->created_user_id=$user->id;
				$catobj->language="*";
				//$catobj->description = $category->description;
				$createdDateTime = Factory::getDate('now');
				$catobj->created_time = $createdDateTime->toSQL();

				// Need to add date as in com_content to install
				$catobj->modified_time = $createdDateTime->toSQL();
				$catobj->published = 1;
				$catobj->access = 1;
				if(!$this->db->insertObject('#__categories',$catobj,'id'))
				{
					Log::add('Error inserting category', Log::WARNING, 'com_jticketing');
					return false;
				}
			return true;
		}
	}

	/**
	 * install event categories in JTicketing
	 *
	 * @param   JInstaller  $parent  parent
	 *
	 * @return  void
	 */
	private function _installSampleFieldsManagerData()
	{
		// Check if file is present.
		$filePath = JPATH_SITE . '/components/com_tjfields/tjfields.php';

		if (!JFile::exists($filePath))
		{
			return false;
		}

		// Use $this->db instead
		$user = Factory::getUser();

		// Check if any eventform fields groups exists.
		$query = $this->db->getQuery(true);
		$query->select('COUNT(tfg.id) AS count');
		$query->from('`#__tjfields_groups` AS tfg');
		$search = $db->Quote('com_jticketing.event');
		$query->where('tfg.client=' . $search);
		$this->db->setQuery($query);
		$eventFieldsGroupsCount = (int) ($this->db->loadResult() ?? 0);

		// Check if any ticket fields groups exists.
		$query = $this->db->getQuery(true);
		$query->select('COUNT(tfg.id) AS count');
		$query->from('`#__tjfields_groups` AS tfg');
		$search = $db->Quote('com_jticketing.ticket');
		$query->where('tfg.client=' . $search);
		$this->db->setQuery($query);
		$ticketFieldsGroupsCount = (int) ($this->db->loadResult() ?? 0);

		$queries = array();

		// If no eventform fields groups found, add a sample one.
		if (!$eventFieldsGroupsCount)
		{
			$queries[] = "INSERT INTO `#__tjfields_groups` (`ordering`, `state`, `created_by`, `name`, `title`, `client`) VALUES(1, 1, ".$user->id.", 'Event - Additional Details', 'Event Fields', 'com_jticketing.event');";
		}

		// If no ticketform fields groups found, add a sample one.
		if (!$ticketFieldsGroupsCount)
		{
			$queries[] = "INSERT INTO `#__tjfields_groups` (`ordering`, `state`, `created_by`, `name`, `title`, `client`) VALUES(2, 1,".$user->id.", 'Ticket - Additional Details', 'Ticket Fields', 'com_jticketing.ticket');";
		}

		// Execute sql queries.
		if (count($queries) != 0)
		{
			foreach ($queries as $query)
			{
				$query = trim($query);

				if ($query != '')
				{
					$this->db->setQuery($query);

					if (!$this->db->execute())
					{
						Log::add(Text::sprintf('JLIB_INSTALLER_ERROR_SQL_ERROR', 'SQL execution failed'), Log::WARNING, 'jerror');

						return false;
					}
				}
			}
		}

		return true;
	}

	//since version 1.5
	//check if column - paypal_email exists
	function fixIntegrationXrefTable(): void
	{
		// since version 1.8
		// check if column - cron_status exists
		$query = "SHOW COLUMNS FROM #__jticketing_integration_xref WHERE `Field` = 'cron_status'";
		$this->db->setQuery($query);
		$columns = $this->db->loadColumn();
		$check = !empty($columns);
		
		if (!$check)
		{
			$query = "ALTER TABLE  `#__jticketing_integration_xref` ADD  `cron_status` INT( 11 ) NOT NULL DEFAULT 0 AFTER  `userid`";
			$this->db->setQuery($query);
			try
			{
				$this->db->execute();
			}
			catch (\RuntimeException $e)
			{
				Log::add(
					Text::sprintf('JLIB_INSTALLER_ERROR_SQL_ERROR', $e->getMessage()),
					Log::WARNING,
					'jerror'
				);
			}
		}

		//since version 1.8
		//check if column - cron_date exists
		$query = "SHOW COLUMNS FROM #__jticketing_integration_xref WHERE `Field` = 'cron_date'";
		$this->db->setQuery($query);
		$columns = $this->db->loadColumn();
		$check = !empty($columns);
		
		if (!$check)
		{
			$query = "ALTER TABLE  `#__jticketing_integration_xref` ADD  `cron_date` datetime DEFAULT NULL AFTER  `cron_status`";
			$this->db->setQuery($query);
			try
			{
				$this->db->execute();
			}
			catch (\RuntimeException $e)
			{
				Log::add(
					Text::sprintf('JLIB_INSTALLER_ERROR_SQL_ERROR', $e->getMessage()),
					Log::WARNING,
					'jerror'
				);
			}
		}

		//since version 2.0
		//check if column - vendor_id exists
		$query = "SHOW COLUMNS FROM #__jticketing_integration_xref WHERE `Field` = 'vendor_id'";
		$this->db->setQuery($query);
		$columns = $this->db->loadColumn();
		$check = !empty($columns);
		
		if (!$check)
		{
			$query = "ALTER TABLE  `#__jticketing_integration_xref` ADD  `vendor_id` INTEGER NOT NULL DEFAULT 0 AFTER  `eventid`";
			$this->db->setQuery($query);
			try
			{
				$this->db->execute();
			}
			catch (\RuntimeException $e)
			{
				Log::add(
					Text::sprintf('JLIB_INSTALLER_ERROR_SQL_ERROR', $e->getMessage()),
					Log::WARNING,
					'jerror'
				);
			}
		}
	}


		//since version 1.5
		//check if column - attendee_id exists
	function fixEventsTable(): void
	{
		$query = "SHOW COLUMNS FROM #__jticketing_events WHERE `Field` = 'access'";
		$this->db->setQuery($query);
		$columns = $this->db->loadColumn();
		$check = !empty($columns);

		if (!$check)
		{
			$query = " ALTER TABLE  `#__jticketing_events` ADD  `access` int(11) NOT NULL DEFAULT 0 AFTER  `state`";
			$this->db->setQuery($query);

			try
			{
				$this->db->execute();
			}
			catch (\RuntimeException $e)
			{
				Log::add(
					Text::sprintf('JLIB_INSTALLER_ERROR_SQL_ERROR', $e->getMessage()),
					Log::WARNING,
					'jerror'
				);
			}

			// Set each ticket type as public
			/*$query=" UPDATE   `#__jticketing_events` SET  `access`=1";
			$this->db->setQuery($query);
			$this->db->execute();*/

		}

		//since version 1.5
		//check if column - asset_id exists
		$query = "SHOW COLUMNS FROM #__jticketing_events WHERE `Field` = 'asset_id'";
		$this->db->setQuery($query);
		$columns = $this->db->loadColumn();
		$check = !empty($columns);

		if (!$check)
		{
			$query = " ALTER TABLE  `#__jticketing_events` ADD  `asset_id` int(11) NOT NULL DEFAULT 0 AFTER `id`";
			$this->db->setQuery($query);

			try
			{
				$this->db->execute();
			}
			catch (\RuntimeException $e)
			{
				Log::add(
					Text::sprintf('JLIB_INSTALLER_ERROR_SQL_ERROR', $e->getMessage()),
					Log::WARNING,
					'jerror'
				);
			}
		}

		//since version 2.0
		//check if column - allow_view_attendee exists
		$query = "SHOW COLUMNS FROM #__jticketing_events WHERE `Field` = 'allow_view_attendee'";
		$this->db->setQuery($query);
		$columns = $this->db->loadColumn();
		$check = !empty($columns);

		if (!$check)
		{
			$query = " ALTER TABLE  `#__jticketing_events` ADD  `allow_view_attendee` tinyint(3) NOT NULL DEFAULT 0 AFTER `state`";
			$this->db->setQuery($query);

			try
			{
				$this->db->execute();
			}
			catch (\RuntimeException $e)
			{
				Log::add(
					Text::sprintf('JLIB_INSTALLER_ERROR_SQL_ERROR', $e->getMessage()),
					Log::WARNING,
					'jerror'
				);
			}
		}

		//since version 1.8
		//check if column - venue exists
		$query = "SHOW COLUMNS FROM #__jticketing_events WHERE `Field` = 'venue'";
		$this->db->setQuery($query);
		$columns = $this->db->loadColumn();
		$check = !empty($columns);
		
		if (!$check)
		{
			$query = "ALTER TABLE  `#__jticketing_events` ADD  `venue` INT(11) NOT NULL DEFAULT 0 AFTER  `catid`";
			$this->db->setQuery($query);
			try
			{
				$this->db->execute();
			}
			catch (\RuntimeException $e)
			{
				Log::add(
					Text::sprintf('JLIB_INSTALLER_ERROR_SQL_ERROR', $e->getMessage()),
					Log::WARNING,
					'jerror'
				);
			}
		}

		// Since version 1.8
		$query = "SHOW COLUMNS FROM #__jticketing_events WHERE `Field` = 'online_events'";
		$this->db->setQuery($query);
		$columns = $this->db->loadColumn();
		$check = !empty($columns);
		
		if (!$check)
		{
			$query = "ALTER TABLE  `#__jticketing_events` ADD  `online_events` TINYINT(4) NOT NULL DEFAULT 0 AFTER  `featured`";
			$this->db->setQuery($query);
			try
			{
				$this->db->execute();
			}
			catch (\RuntimeException $e)
			{
				Log::add(
					Text::sprintf('JLIB_INSTALLER_ERROR_SQL_ERROR', $e->getMessage()),
					Log::WARNING,
					'jerror'
				);
			}
		}

		// Since version 1.8
		$query = "SHOW COLUMNS FROM #__jticketing_events WHERE `Field` = 'jt_params'";
		$this->db->setQuery($query);
		$columns = $this->db->loadColumn();
		$check = !empty($columns);
		
		if (!$check)
		{
			$query = "ALTER TABLE  `#__jticketing_events` ADD  `jt_params` TEXT DEFAULT NULL AFTER  `checked_out_time`";
			$this->db->setQuery($query);
			try
			{
				$this->db->execute();
			}
			catch (\RuntimeException $e)
			{
				Log::add(
					Text::sprintf('JLIB_INSTALLER_ERROR_SQL_ERROR', $e->getMessage()),
					Log::WARNING,
					'jerror'
				);
			}
		}
		else 
		{
			$query       = "ALTER TABLE `#__jticketing_events` CHANGE `jt_params` `jt_params` text DEFAULT NULL";
			$this->db->setQuery($query);
			if ( !$this->db->execute() ) {
				$app = Factory::getApplication();
				Log::add('Error in database operation', Log::WARNING, 'com_jticketing');
			}
		}
	}

	//since version 2.0
	function fixCheckindetailsTable(): void
	{
		$query = "SHOW COLUMNS FROM #__jticketing_checkindetails WHERE `Field` = 'id'";
		$this->db->setQuery($query);
		$columns = $this->db->loadColumn();
		$check = !empty($columns);
		
		if (!$check)
		{
			$query = "ALTER TABLE  `#__jticketing_checkindetails` ADD  `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST ";
			$this->db->setQuery($query);
			try
			{
				$this->db->execute();
			}
			catch (\RuntimeException $e)
			{
				Log::add(
					Text::sprintf('JLIB_INSTALLER_ERROR_SQL_ERROR', $e->getMessage()),
					Log::WARNING,
					'jerror'
				);
			}
		}

		//since version 2.0
		$query = "SHOW COLUMNS FROM #__jticketing_checkindetails WHERE `Field` = 'checkouttime'";
		$this->db->setQuery($query);
		$columns = $this->db->loadColumn();
		$check = !empty($columns);
		
		if (!$check)
		{
			$query = "ALTER TABLE  `#__jticketing_checkindetails` ADD  `checkouttime` DATETIME DEFAULT NULL AFTER  `checkintime`";
			$this->db->setQuery($query);
			try
			{
				$this->db->execute();
			}
			catch (\RuntimeException $e)
			{
				Log::add(
					Text::sprintf('JLIB_INSTALLER_ERROR_SQL_ERROR', $e->getMessage()),
					Log::WARNING,
					'jerror'
				);
			}
		}
	}

	function fixJtUsersTable(): void
	{
		$query = "ALTER TABLE `#__jticketing_users` CHANGE `country_code` `country_code` VARCHAR( 250 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
		CHANGE `city` `city` VARCHAR( 250 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
		CHANGE `state_code` `state_code` VARCHAR( 250 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT ''";
		$this->db->setQuery($query);

		try
		{
			$this->db->execute();
		}
		catch (\RuntimeException $e)
		{
			Log::add(
				Text::sprintf('JLIB_INSTALLER_ERROR_SQL_ERROR', $e->getMessage()),
				Log::WARNING,
				'jerror'
			);
		}

		//since version 1.7.2
		//check if column - country_mobile_code exists
		$query = "SHOW COLUMNS FROM #__jticketing_users WHERE `Field` = 'country_mobile_code'";
		$this->db->setQuery($query);
		$columns = $this->db->loadColumn();
		$check = !empty($columns);

		if (!$check)
		{
			$query = " ALTER TABLE  `#__jticketing_users` ADD  `country_mobile_code` int(11) NOT NULL DEFAULT 0 AFTER  `zipcode`";
			$this->db->setQuery($query);
			try
			{
				$this->db->execute();
			}
			catch (\RuntimeException $e)
			{
				Log::add(
					Text::sprintf('JLIB_INSTALLER_ERROR_SQL_ERROR', $e->getMessage()),
					Log::WARNING,
					'jerror'
				);
			}
		}
	}

	//since version 1.8
	//check if column - venue exists
	function fixVenuesTable(): void
	{
		$query = "SHOW COLUMNS FROM #__jticketing_venues WHERE `Field` = 'address'";
		$this->db->setQuery($query);
		$columns = $this->db->loadColumn();
		$check = !empty($columns);
		
		if (!$check)
		{
			$query = "ALTER TABLE  `#__jticketing_venues` ADD  `address` VARCHAR(255) NOT NULL DEFAULT '' AFTER  `zipcode`";
			$this->db->setQuery($query);
			try
			{
				$this->db->execute();
			}
			catch (\RuntimeException $e)
			{
				Log::add(
					Text::sprintf('JLIB_INSTALLER_ERROR_SQL_ERROR', $e->getMessage()),
					Log::WARNING,
					'jerror'
				);
			}
		}

		// Check if column - venue alias exists
		$query = "SHOW COLUMNS FROM #__jticketing_venues WHERE `Field` = 'alias'";
		$this->db->setQuery($query);
		$columns = $this->db->loadColumn();
		$check = !empty($columns);

		if (!$check)
		{
			$query = "ALTER TABLE `#__jticketing_venues` ADD `alias` VARCHAR(255) NOT NULL DEFAULT '' AFTER `name`";
			$this->db->setQuery($query);
			try
			{
				$this->db->execute();
			}
			catch (\RuntimeException $e)
			{
				Log::add(
					Text::sprintf('JLIB_INSTALLER_ERROR_SQL_ERROR', $e->getMessage()),
					Log::WARNING,
					'jerror'
				);
			}
		}

		// Check if column - vendor_id exists
		$query = "SHOW COLUMNS FROM #__jticketing_venues WHERE `Field` = 'vendor_id'";
		$this->db->setQuery($query);
		$columns = $this->db->loadColumn();
		$check = !empty($columns);

		if (!$check)
		{
			$query = "ALTER TABLE `#__jticketing_venues` ADD `vendor_id` INTEGER(11) NOT NULL DEFAULT 0 AFTER `id`";
			$this->db->setQuery($query);
			try
			{
				$this->db->execute();
			}
			catch (\RuntimeException $e)
			{
				Log::add(
					Text::sprintf('JLIB_INSTALLER_ERROR_SQL_ERROR', $e->getMessage()),
					Log::WARNING,
					'jerror'
				);
			}
		}
	}

	/**
	 * Function to update JLike data
	 *
	 * @return  void
	 *
	 * @since   2.1.3
	 */
	function jLikeContentMigration(): void
	{
		// Check if JLike table exists first using SHOW TABLES
		$config = Factory::getConfig();
		$dbprefix = $config->get('dbprefix');
		$tableName = $dbprefix . 'jlike_content';
		
		// Check if table exists
		$checkQuery = "SHOW TABLES LIKE " . $this->db->quote($tableName);
		$this->db->setQuery($checkQuery);
		
		try
		{
			$tableExists = $this->db->loadResult();
			if (empty($tableExists))
			{
				// Table doesn't exist, skip migration
				return;
			}
		}
		catch (\Exception $e)
		{
			// Cannot check table, skip migration
			return;
		}

		// Try to query JLike table - if it doesn't exist, catch exception and skip migration
		$query = $this->db->getQuery(true);
		$query->select('COUNT(*)');
		$query->from($this->db->quoteName('#__jlike_content', 'a'));
		$query->where($this->db->quoteName('a.element') . ' = ' . $this->db->quote('com_jticketing.event'));
		$this->db->setQuery($query);
		
		try
		{
			$count = (int) ($this->db->loadResult() ?? 0);
			if ($count === 0)
			{
				// No JLike data to migrate
				return;
			}
		}
		catch (\Exception $e)
		{
			// Table doesn't exist or query failed, skip migration silently
			return;
		}

		// Load JLike data
		$query = $this->db->getQuery(true);
		$query->select('a.*');
		$query->from($this->db->quoteName('#__jlike_content', 'a'));
		$query->where($this->db->quoteName('a.element') . ' = ' . $this->db->quote('com_jticketing.event'));
		$this->db->setQuery($query);
		
		try
		{
			$results = $this->db->loadObjectList();
		}
		catch (\Exception $e)
		{
			// Table might not exist or query failed, skip migration
			return;
		}

		foreach ($results as $result)
		{
			// Delete itemID from URL
			$this->updateURL($result);

			// Delete Duplicate entries of JLike
			$query1 = $this->db->getQuery(true);
			$query1->select('b.*');
			$query1->from($this->db->quoteName('#__jlike_content', 'b'));
			$query1->where($this->db->quoteName('b.element_id')." = ".$this->db->quote($result->element_id));
			$query1->where($this->db->quoteName('b.element')." = ".$this->db->quote($result->element));
			$this->db->setQuery($query1);
			
			try
			{
				$contents = $this->db->loadObjectList();
			}
			catch (\Exception $e)
			{
				// Table might have been dropped, skip this record
				continue;
			}

			if (count($contents) >= 2)
			{
				array_pop($contents);

				for ($i = 0; $i < count($contents); $i++)
				{
					$query3 = $this->db->getQuery(true);
					$conditions = array(
						$this->db->quoteName('id') . ' = ' . $this->db->quote($contents[$i]->id),
						$this->db->quoteName('element') . ' = ' . $this->db->quote('com_jticketing.event')
					);

					$query3->delete($this->db->quoteName('#__jlike_content'));
					$query3->where($conditions);

					$this->db->setQuery($query3);
					try
					{
						$this->db->execute();
					}
					catch (\Exception $e)
					{
						// Skip if delete fails
						continue;
					}
				}
			}
		}
	}

	/**
	 * Function to remove itemID from URL
	 *
	 * @return  void
	 *
	 * @since   2.1.3
	 */
	function updateURL($result): bool
	{
		if($result->url == '')
		{
			return false;
		}

		$urlExplode = explode('&', $result->url);

		if (sizeof($urlExplode) == 4)
		{
			array_pop($urlExplode);
		}

		$urlAfterItemID = implode('&', $urlExplode);
		// Use $this->db instead
		$query = $this->db->getQuery(true);
		$fields = array(
			$this->db->quoteName('url') . ' = ' . $this->db->quote($urlAfterItemID),
		);

		$conditions = array(
			$this->db->quoteName('id') . ' = ' . $this->db->quote($result->id)
		);

		$query->update($this->db->quoteName('#__jlike_content'))->set($fields)->where($conditions);
		$this->db->setQuery($query);
		
		try
		{
			$this->db->execute();
			return true;
		}
		catch (\Exception $e)
		{
			// Don't log error for optional JLike table
			return false;
		}
	}


	//Since jticketing version 1.5
	function fix_db_on_update()
	{
		// Use $this->db instead
		$config = Factory::getConfig();
		$dbprefix = $config->get( 'dbprefix' );

		$xml = simplexml_load_file(JPATH_ADMINISTRATOR . '/components/com_jticketing/jticketing.xml');
		$version = (string)$xml->version;
		$this->version = (float)($version);
		$this->fixIntegrationXrefTable();
		$this->jLikeContentMigration();
		$this->fixEventsTable();
		$this->fixCheckindetailsTable();
		$this->fixJtUsersTable();
		$this->fixVenuesTable();
		$this->updateCoreAttendeeFields();
	}


	/**
	 * Renders the post-installation message
	 */
	private function _renderPostInstallation($status, $parent, $msgBox=array())
	{
		$document = Factory::getDocument();

		?>

		<?php $rows = 1;?>

		<link rel="stylesheet" type="text/css" href=""/>
		<div class="techjoomla-bootstrap" >
		<table class="table-condensed table">
			<thead>
				<tr>
					<th class="title" colspan="2">Extension</th>
					<th width="30%">Status</th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<td colspan="3"></td>
				</tr>
			</tfoot>
			<tbody>
				<tr class="row0">
					<td class="key" colspan="2">JTicketing component</td>
					<td><strong style="color: green">Installed</strong></td>
				</tr>




				<?php if (count($status->modules)) : ?>
				<tr>
					<th>Module</th>
					<th>Client</th>
					<th></th>
				</tr>
				<?php foreach ($status->modules as $module) : ?>
				<tr class="row<?php echo ($rows++ % 2); ?>">
					<td class="key"><?php echo $module['name']; ?></td>
					<td class="key"><?php echo ucfirst($module['client']); ?></td>
					<td><strong style="color: <?php echo ($module['result'])? "green" : "red"?>"><?php echo ($module['result'])?'Installed':'Not installed'; ?></strong></td>
				</tr>
				<?php endforeach;?>
				<?php endif;?>
				<?php if (count($status->plugins)) : ?>
				<tr>
					<th>Plugin</th>
					<th>Group</th>
					<th></th>
				</tr>
				<?php foreach ($status->plugins as $plugin) : ?>
				<tr class="row<?php echo ($rows++ % 2); ?>">
					<td class="key"><?php echo ucfirst($plugin['name']); ?></td>
					<td class="key"><?php echo ucfirst($plugin['group']); ?></td>
					<td><strong style="color: <?php echo ($plugin['result'])? "green" : "red"?>"><?php echo ($plugin['result'])?'Installed':'Not installed'; ?></strong></td>
				</tr>
				<?php endforeach; ?>
				<?php endif; ?>
				<?php if (!empty($status->libraries) and count($status->libraries)) : ?>
				<tr class="row1">
					<th>Library</th>
					<th></th>
					<th></th>
					</tr>
				<?php foreach ($status->libraries as $libraries) : ?>
				<tr class="row2 <?php //echo ($rows++ % 2); ?>">
					<td class="key"><?php echo ucfirst($libraries['name']); ?></td>
					<td class="key"></td>
					<td><strong style="color: <?php echo ($libraries['result'])? "green" : "red"?>"><?php echo ($libraries['result'])?'Installed':'Not installed'; ?></strong>
					<?php
						if(!empty($libraries['result'])) // if installed then only show msg
						{
						echo $mstat=($libraries['status']? "<span class=\"label label-success\">Enabled</span>" : "<span class=\"label label-important\">Disabled</span>");

						}
					?>

					</td>
				</tr>
				<?php endforeach;?>
				<?php endif;?>

				<?php if (!empty($status->applications) and count($status->applications)) :
				 ?>
				<tr class="row1">
					<th>EasySocial App</th>
					<th></th>
					<th></th>
					</tr>
				<?php foreach ($status->applications as $app_install) : ?>
				<tr class="row2 <?php  ?>">
					<td class="key"><?php echo ucfirst($app_install['name']); ?></td>
					<td class="key"></td>
					<td><strong style="color: <?php echo ($app_install['result'])? "green" : "red"?>"><?php echo ($app_install['result'])?'Installed':'Not installed'; ?></strong>
					<?php
						if(!empty($app_install['result'])) // if installed then only show msg
						{
							echo $mstat=($app_install['status']? "<span class=\"label label-success\">Enabled</span>" : "<span class=\"label label-important\">Disabled</span>");

						}
					?>

					</td>
				</tr>
				<?php endforeach;?>
				<?php endif;?>

			</tbody>
		</table>
	</div>
		<?php
	}

	function removeShortDescription()
	{
		// Short description removed from current version
		$db    = Factory::getDbo();
		$query = $this->db->getQuery(true);
		$query->select($this->db->quoteName(array('id', 'short_description', 'long_description')));
		$query->from($this->db->quoteName('#__jticketing_events'));

		$this->db->setQuery($query);
		$short_description = $this->db->loadObjectList();

		if (!empty($short_description))
		{
			foreach ($short_description as $desc)
			{
				$obj = new stdclass;
				$obj->id = $desc->id;
				$obj->long_description = $desc->short_description . ' ' . $desc->long_description;
				$obj->short_description = '';

				if (!$this->db->updateObject('#__jticketing_events', $obj, 'id'))
				{
					return false;
				}
			}
		}
	}

	/**
	 * update event alias field
	 *
	 * @return  void
	 *
	 * @since  1.0
	 */
	public function addEventAlias()
	{
		$db    = Factory::getDbo();
		$query = $this->db->getQuery(true);
		$query->select($this->db->quoteName(array('id', 'title', 'alias')));
		$query->from($this->db->quoteName('#__jticketing_events'));
		$this->db->setQuery($query);
		$events = $this->db->loadObjectList();

		foreach ($events as $event)
		{
			$event->alias = trim($event->alias);

			if (empty($event->alias))
			{
				$event->alias = trim($event->title);
			}

			$obj = new stdclass;
			$obj->id = $event->id;
			$obj->alias = $event->alias;

			if ($obj->alias)
			{
				if (Factory::getConfig()->get('unicodeslugs') == 1)
				{
					$obj->alias = JFilterOutput::stringURLUnicodeSlug($obj->alias);
				}
				else
				{
					$obj->alias = JFilterOutput::stringURLSafe($obj->alias);
				}
			}

			// Check if event with same alias is present
			JTable::addIncludePath(JPATH_ADMINISTRATOR . '/components/com_jticketing/tables');
			$table = JTable::getInstance('Event', 'JticketingTable', array('dbo', $db));

			if ($table->load(array('alias' => $obj->alias)) && ($table->id != $obj->id || $obj->id == 0))
			{
				$msg = Text::_('COM_JTICKETING_SAVE_ALIAS_WARNING');

				while ($table->load(array('alias' => $obj->alias)))
				{
					$obj->alias = StringHelper::increment($obj->alias, 'dash');
				}

				Factory::getApplication()->enqueueMessage($msg, 'warning');
			}

			if (!$this->db->updateObject('#__jticketing_events', $obj, 'id'))
			{
				return false;
			}
		}
	}

	/**
	 * Installed Notifications Templates
	 *
	 * @return  void
	 */
	public function _installNotificationsTemplates()
	{
		JTable::addIncludePath(JPATH_ADMINISTRATOR . '/components/com_tjnotifications/tables');
		require_once JPATH_ADMINISTRATOR . '/components/com_tjnotifications/models/notification.php';
		$notificationsModel = JModelLegacy::getInstance('Notification', 'TJNotificationsModel');

		$existingKeys = array();
		$filePath = JPATH_ADMINISTRATOR . '/components/com_jticketing/jticketingTemplate.json';
		$str = file_get_contents($filePath);
		$json = json_decode($str, true);
		$client = 'com_jticketing';
		$existingKeys = $notificationsModel->getKeys($client);

		if (!empty($json))
		{
			foreach ($json as $template => $array)
			{
				$replacementTagCount = $notificationsModel->getReplacementTagsCount($array['key'], $client);

				// If template doesn't exist then we add notification template.
				if (!in_array($array['key'], $existingKeys))
				{
					$notificationsModel->createTemplates($array);
				}
				else
				{
					$notificationsModel->updateTemplates($array, $client);
				}

				$this->installEasysocialAlert($client, $array['key']);

				// If replacement tags are changed update those
				if (in_array($array['key'], $existingKeys) && isset($array['replacement_tags']) && count($array['replacement_tags']) != $replacementTagCount)
				{
					$notificationsModel->updateReplacementTags($array);
				}
			}
		}
	}
	
	/**
	 * Installed Easysocial alert
	 *
	 * @return  void
	 */
	public function installEasysocialAlert($client, $key)
	{
		$esFilePath = JPATH_ROOT . '/administrator/components/com_easysocial/includes/easysocial.php';

		if (File::exists($esFilePath) && ComponentHelper::isEnabled('com_easysocial'))
		{
			Table::addIncludePath(JPATH_ROOT . '/administrator/components/com_easysocial/tables');
			$db    = Factory::getDbo();
		
			$socialAlertTable = Table::getInstance('Alert', 'SocialTable', array('dbo', $db));
			$socialAlertTable->element = $client;
			$socialAlertTable->rule = $key;
			
			return $socialAlertTable->save($socialAlertTable);
		}
	}

	/**
	 * update venue alias field
	 *
	 * @return  false
	 *
	 * @since  1.0
	 */
	public function addVenueAlias()
	{
		$db    = Factory::getDbo();
		$query = $this->db->getQuery(true);
		$query->select($this->db->quoteName(array('id', 'name', 'alias')));
		$query->from($this->db->quoteName('#__jticketing_venues'));
		$this->db->setQuery($query);
		$venues = $this->db->loadObjectList();

		foreach ($venues as $venue)
		{
			$venue->alias = trim($venue->alias);

			if (empty($venue->alias))
			{
				$venue->alias = trim($venue->name);
			}

			$obj = new stdclass;
			$obj->id = $venue->id;
			$obj->alias = $venue->alias;

			if ($obj->alias)
			{
				if (Factory::getConfig()->get('unicodeslugs') == 1)
				{
					$obj->alias = JFilterOutput::stringURLUnicodeSlug($obj->alias);
				}
				else
				{
					$obj->alias = JFilterOutput::stringURLSafe($obj->alias);
				}
			}

			// Check if venue with same alias is present
			JTable::addIncludePath(JPATH_ADMINISTRATOR . '/components/com_jticketing/tables');
			$table = JTable::getInstance('Venue', 'JticketingTable', array('dbo', $db));

			if ($table->load(array('alias' => $obj->alias)) && ($table->id != $obj->id || $obj->id == 0))
			{
				$msg = Text::_('COM_JTICKETING_VENUE_SAVE_ALIAS_WARNING');

				while ($table->load(array('alias' => $obj->alias)))
				{
					$obj->alias = StringHelper::increment($obj->alias, 'dash');
				}

				Factory::getApplication()->enqueueMessage($msg, 'warning');
			}

			if (!$this->db->updateObject('#__jticketing_venues', $obj, 'id'))
			{
				return false;
			}
		}
	}

	/**
	 * Update core attendee fields values
	 *
	 * @return  void
	 *
	 * @since  1.0
	 */
	public function updateCoreAttendeeFields()
	{
		$db    = Factory::getDbo();
		$query = $this->db->getQuery(true);
		$query->select($this->db->quoteName(array('id', 'placeholder', 'label')));
		$query->from($this->db->quoteName('#__jticketing_attendee_fields'));
		$this->db->setQuery($query);
		$attendeeFields = $this->db->loadObjectList();

		if (!empty($attendeeFields))
		{
			foreach ($attendeeFields as $field)
			{
				$obj = new stdclass;
				$obj->id = $field->id;

				if ($field->id == '1' && $field->placeholder != 'COM_JTICKETING_AF_FNAME' && $field->label != 'COM_JTICKETING_AF_FNAME')
				{
					$obj->placeholder = 'COM_JTICKETING_AF_FNAME';
					$obj->label = 'COM_JTICKETING_AF_FNAME';
				}
				elseif ($field->id == '2' && $field->placeholder != 'COM_JTICKETING_AF_LNAME' && $field->label != 'COM_JTICKETING_AF_LNAME')
				{
					$obj->placeholder = 'COM_JTICKETING_AF_LNAME';
					$obj->label = 'COM_JTICKETING_AF_LNAME';
				}
				elseif ($field->id == '3' && $field->placeholder != 'COM_JTICKETING_AF_PHONE' && $field->label != 'COM_JTICKETING_AF_PHONE')
				{
					$obj->placeholder = 'COM_JTICKETING_AF_PHONE';
					$obj->label = 'COM_JTICKETING_AF_PHONE';
				}
				elseif ($field->id == '4' && $field->placeholder != 'COM_JTICKETING_AF_EMAIL' && $field->label != 'COM_JTICKETING_AF_EMAIL')
				{
					$obj->placeholder = 'COM_JTICKETING_AF_EMAIL';
					$obj->label = 'COM_JTICKETING_AF_EMAIL';
				}

				if (!$this->db->updateObject('#__jticketing_attendee_fields', $obj, 'id'))
				{
					return false;
				}
			}
		}
	}

	/**
	 * Delete Payment plugin logs on installation
	 *
	 * @since 2.0.5
	 *
	 * @return void
	 */
	public function deleteLog()
	{
		// Get log config path
		$config = new JConfig;
		$config->log_path;

		$logsPath = array(
		"cpg__paypal.log", "com_jticketing_paypal.log",
		"com_jticketing_authorizenet.log", "com_jticketing_2checkout.log",
		"com_jticketing_adaptive_paypal.log", "com_jticketing_alphauserpoints.log",
		"com_jticketing_bycheck.log", "com_jticketing_byorder.log",
		"com_jticketing_jomsocialpoints.log", "com_jticketing_linkpoint.log",
		"com_jticketing_payu.log", "com_jticketing_ccavenue.log",
		"com_jticketing_easysocialpoints.log", "com_jticketing_cod.log",
		"com_jticketing_epaydk.log", "com_jticketing_epaydk.log",
		"com_jticketing_ewallet.log", "com_jticketing_eway.log",
		"com_jticketing_ewayrapid3.log", "com_jticketing_ogone.log",
		"com_jticketing_pagseguro.log", "com_jticketing_payfast.log",
		"com_jticketing_paymill.log", "com_jticketing_paypalpro.log",
		"com_jticketing_payumoney.log", "com_jticketing_transfirst.log",
		"com_jticketing_razorpay.log");

		foreach ($logsPath as $path)
		{
			// 1. detele log
			if (!JFile::delete($config->log_path . '/' . $path))
			{
				// 2. if not 1 then clear content
				$output -= file_put_contents($config->log_path . '/' . $path, "");

				// 3. if not 2 then create htaccess
				if ($output == false)
				{
					file_put_contents($config->log_path . '/.htaccess', "Deny from all");
				}
			}
		}
	}

	/**
	 * Uninstalls subextensions (modules, plugins) bundled with the main extension
	 *
	 * @param   JInstaller  $parent  parent
	 *
	 * @return  JObject The subextension uninstallation status
	 */
	private function _uninstallSubextensions($parent)
	{

		// Use $this->db instead

		$status          = new \stdClass;
		$status->modules = array();
		$status->plugins = array();

		$src = $parent->getParent()->getPath('source');

		// Modules uninstallation
		if (count($this->uninstallation_queue['modules']))
		{
			foreach ($this->uninstallation_queue['modules'] as $folder => $modules)
			{
				if (count($modules))
				{
					foreach ($modules as $module => $modulePreferences)
					{
						// Find the module ID
						$sql = $this->db->getQuery(true)->select($db->qn('extension_id'))
						->from($db->qn('#__extensions'))
						->where($db->qn('element') . ' = ' . $db->q($module))
						->where($db->qn('type') . ' = ' . $db->q('module'));
						$this->db->setQuery($sql);
						$extensionIds = $this->db->loadColumn();
		$id = $extensionIds[0] ?? null;

						// Uninstall the module
						if ($id)
						{
							$installer         = new Installer();
							$installer->setDatabase($this->db);
							$result            = $installer->uninstall('module', $id, 1);
							$status->modules[] = array(
								'name' => $module,
								'client' => $folder,
								'result' => $result
							);
						}
					}
				}
			}
		}

		// Plugins uninstallation
		if (count($this->uninstallation_queue['plugins']))
		{
			foreach ($this->uninstallation_queue['plugins'] as $folder => $plugins)
			{
				if (count($plugins))
				{
					foreach ($plugins as $plugin => $published)
					{
						$sql = $this->db->getQuery(true)->select($db->qn('extension_id'))
						->from($db->qn('#__extensions'))
						->where($db->qn('type') . ' = ' . $db->q('plugin'))
						->where($db->qn('element') . ' = ' . $db->q($plugin))
						->where($db->qn('folder') . ' = ' . $db->q($folder));
						$this->db->setQuery($sql);

						$extensionIds = $this->db->loadColumn();
		$id = $extensionIds[0] ?? null;

						if ($id)
						{
							$installer         = new Installer();
							$installer->setDatabase($this->db);
							$result            = $installer->uninstall('plugin', $id);
							$status->plugins[] = array(
								'name' => 'plg_' . $plugin,
								'group' => $folder,
								'result' => $result
							);
						}
					}
				}
			}
		}

		return $status;
	}

	/**
	 * Install Certificate Templates
	 *
	 * @return  void
	 */
	private function installCertificateTemplates()
	{
		if (ComponentHelper::isEnabled('com_tjcertificate'))
		{
			// Joomla 6: JLoader removed - tjcertificate should be autoloaded
			$filePath = JPATH_ADMINISTRATOR . '/components/com_jticketing/certificateTemplate.json';
			$str = file_get_contents($filePath);
			$json = json_decode($str, true);

			if (count($json) != 0)
			{
				$table = TJCERT::table("templates");
				$model = TJCERT::model('Template', array('ignore_request' => true));

				foreach ($json as $template => $tmplArr)
				{
					$table->load(array('unique_code' => $tmplArr['unique_code']));

					if (empty($table->id))
					{
						$model->save($tmplArr);
					}
				}
			}
		}
	}

	/**
	 * Set default bootstrap layouts to load
	 *
	 * @param   string  $type  install, update or discover_update
	 * 
	 * @return void
	 *
	 * @since 4.0.0
	 */
	 public function setDefaultLayout($type)
	 {
		 if ($type == 'install' && JVERSION >= '4.0.0')
		 {
			 $db = Factory::getDbo();
			 $query = $this->db->getQuery(true);
			 $query->select('*');
			 $query->from($this->db->quoteName('#__extensions'));
			 $query->where($this->db->quoteName('type') . ' = ' . $this->db->quote('component'));
			 $query->where($this->db->quoteName('element') . ' = ' . $this->db->quote('com_jticketing'));
			 $this->db->setQuery($query);
			 $data = $db->loadObject();
 
			 $params = json_decode($data->params);
 
			 if (!empty($params) && isset($params->bootstrap_version))
			 {
				 $query = $this->db->getQuery(true);
				 $params->bootstrap_version = 'bs5';
				 $fields = array($this->db->quoteName('params') . ' = ' . $this->db->quote(json_encode($params)));
				 $conditions = array($this->db->quoteName('extension_id') . ' = ' . $data->extension_id);
				 $query->update($this->db->quoteName('#__extensions'))->set($fields)->where($conditions);
				 $this->db->setQuery($query);
				 $this->db->execute();
			 }
		 }
	 }

	 /**
	  * This function add all events menu entry in mainmainu
	  *
	  * @return  boolean
	  *
	  * @since  4.0.2
	  */
	 private function _addMenuItems()
	 {
		$lang = Factory::getLanguage();
		$lang->load('com_jticketing', JPATH_ADMINISTRATOR);
 
		 // Get new component id.
		// Use $this->db instead
		$query = $this->db->getQuery(true);
		$query->select('*');
		$query->from($this->db->quoteName('#__extensions'));
		$query->where($this->db->quoteName('type') . ' = ' . $this->db->quote('component'));
		$query->where($this->db->quoteName('element') . ' = ' . $this->db->quote('com_jticketing'));
		$this->db->setQuery($query);
		$data = $db->loadObject();

		$componentId = 0;

		if (isset($data->extension_id))
		{
			$componentId = $data->extension_id;
		}
 
		 // Get the default menu type
		// Use $this->db instead
		$defaultMenuType = CMSApplication::getInstance('site')->getMenu()->getDefault('workaround_joomla_bug')->menutype;
 
		 // Update the existing menu items.
		 $row               = Table::getInstance('menu');
		 $row->menutype     = $defaultMenuType;
		 $row->title        = Text::_('COM_JTICKETING_ALL_EVENTS_MENU');
		 $row->alias        = 'all-events';
		 $row->path         = 'all-events';
		 $row->access       = 1;
		 $row->link         = 'index.php?option=com_jticketing&view=events&layout=default';
		 $row->type         = 'component';
		 $row->published    = '1';
		 $row->params       = '{"show_filters":1,"show_search_filter":1,"show_category_filter":1}';
		 $row->component_id = $componentId;
		 $row->id           = null;
		 $row->language     = '*';
		 $row->check();
 
		 $isPresent = $this->isMenuItemPresent($row->link);
 
		 if (empty($isPresent))
		 {
			 // Add menu
			 $var = $row->store();
 
			 // Update menu
			 $query = $this->db->getQuery(true);
			 $query->update($this->db->quoteName('#__menu'));
			 $query->set($this->db->quoteName('parent_id') . " = " . $this->db->quote(1));
			 $query->set($this->db->quoteName('level') . " = " . $this->db->quote(1));
			 $query->where($this->db->quoteName('id') . " = " . $this->db->quote($row->id));
			 $this->db->setQuery( $query );
 
			 try
			 {
				 $this->db->execute();
			 }
			 catch (\RuntimeException $e)
			 {
				 $this->setError($e->getMessage());
 
				 return false;
			 }
 
			 // As add all events menu. Use it for display
			 return true;
		 }
	 }

	 /**
	  * check whether menu for link is resent or not
	  *
	  * @return  void
	  *
	  * @since  4.0.2
	  */
	 public function isMenuItemPresent($link, $menutype='mainmenu')
	 {
		 $db    = Factory::getDbo();
		 $query = $this->db->getQuery(true);
		 $query->select($this->db->quoteName(array('id')));
		 $query->from($this->db->quoteName('#__menu'));
 
		 if (!empty($link))
		 {
			 $link = $db->Quote('%' . $db->escape($link, true) . '%');
			 $query->where('(link LIKE ' . $link . ')');
		 }
 
		 $this->db->setQuery($query);
 
		 return (int) ($this->db->loadResult() ?? 0);
	 }

	 /**
	  * This function will create my events menu entry in mainmainu
	  *
	  * @return  boolean
	  *
	  * @since  4.0.2
	  */
	 private function _addMyEventsMenu()
	 {
		 $lang = Factory::getLanguage();
		 $lang->load('com_jticketing', JPATH_ADMINISTRATOR);
		 $db = Factory::getDbo();
 
		 // Get new component id.
		// Use $this->db instead
		$query = $this->db->getQuery(true);
		$query->select('*');
		$query->from($this->db->quoteName('#__extensions'));
		$query->where($this->db->quoteName('type') . ' = ' . $this->db->quote('component'));
		$query->where($this->db->quoteName('element') . ' = ' . $this->db->quote('com_jticketing'));
		$this->db->setQuery($query);
		$data = $db->loadObject();

		$componentId = 0;

		if (isset($data->extension_id))
		{
			$componentId = $data->extension_id;
		}

		 // Get the default menu type
		// Use $this->db instead
		$defaultMenuType = CMSApplication::getInstance('site')->getMenu()->getDefault('workaround_joomla_bug')->menutype;
 
		 // Update the existing menu items.
		 $row               = Table::getInstance ('menu');
		 $row->menutype     = $defaultMenuType;
		 $row->title        = Text::_('COM_JTICKETING_MY_EVENTS_MENU');
		 $row->alias        = 'my-events';
		 $row->path         = 'my-events';
		 $row->access       = 1;
		 $row->link         = 'index.php?option=com_jticketing&view=events&layout=my';
		 $row->type         = 'component';
		 $row->published    = '1';
		 $row->component_id = $componentId;
		 $row->id           = null;
		 $row->language     = '*';
		 $row->check();
 
		 $isPresent = $this->isMenuItemPresent($row->link);
 
		 if (empty($isPresent))
		 {
			 // Add menu
			 $var = $row->store();
 
			 // Update menu
			 $query = $this->db->getQuery(true);
			 $query->update($this->db->quoteName('#__menu'));
			 $query->set($this->db->quoteName('parent_id') . " = " . $this->db->quote(1));
			 $query->set($this->db->quoteName('level') . " = " . $this->db->quote(1));
			 $query->where($this->db->quoteName('id') . " = " . $this->db->quote($row->id));
			 $this->db->setQuery( $query );
			 
			 try
			 {
				 $this->db->execute();
			 }
			 catch (\RuntimeException $e)
			 {
				 $this->setError($e->getMessage());
 
				 return false;
			 }
			 
			 return true;
		 }
	 }	 

	/**
	 * Remove duplicate menu item
	 *
	 * @return boolean
	 *
	 * @since 2.4.0
	 */
	public function menuItemMigration()
	{
		// Use $this->db instead
		$query = $this->db->getQuery(true);

		if (JVERSION >= '4.0.0')
		{
			$table   = new \Joomla\Component\Menus\Administrator\Table\MenuTable($db);
		} 
		else 
		{
			Table::addIncludePath(JPATH_ADMINISTRATOR . '/components/com_menus/tables');
			$table = Table::getInstance('menu', 'MenusTable', array('dbo', $db));
		}

		// Use $this->db instead
		$query = $this->db->getQuery(true);
		$query->select('id');
		$query->from($this->db->quoteName('#__menu'));
		$query->where($this->db->quoteName('menutype') . ' = ' . $this->db->quote('main'));
		$query->where($this->db->quoteName('path') . ' IN ("com-jticketing-title-tjreport", "com-jticketing-regions", "com-jticketing-countries",
					"com-jticketing-vendors", "com-jticketing-title-email-template", "com-jticketing-notifications-subscriptions",
					"com-jticketing-certificate-template", "com-jticketing-certificate-issued", "com-jticketing-title-reminders",
					"com-jticketing-event-tjfield-menu", "com-jticketing-event-tjgroup-menu",
					"com-jticketing-attendee-field-menu", "com-jticketing-attendee-fields-group",
					"com_jticketing_title_tjreport", "com_jticketing_regions", "com_jticketing_countries",
					"com_jticketing_vendors", "com_jticketing_title_email_template", "com_jticketing_notifications_subscriptions",
					"com_jticketing_certificate_template", "com_jticketing_certificate_issued", "com_jticketing_title_reminders",
					"com_jticketing_event_tjfield_menu", "com_jticketing_event_tjgroup_menu",
					"com_jticketing_attendee_field_menu", "com_jticketing_attendee_fields_group")');
		$this->db->setQuery($query);
		$data = $this->db->loadObjectList();

		foreach ($data as $key => $menuItem) 
		{
			$table->delete($menuItem->id);
		}

		return true;
	}

	/**
	 * Add acymailing integration to work with jticketing
	 *
	 * @return boolean
	 *
	 * @since 2.4.0
	 */
	public function addAcyMalingIntegration()
	{
		// check acymailing is installed or not
		if (is_dir(JPATH_ADMINISTRATOR . "/components/com_acym/dynamics"))
		{
			// Get the database object
			// Use $this->db instead
			$query = "SHOW TABLES LIKE " . $this->db->quote($this->db->replacePrefix('#__acym_plugin'));

			// Set the query and execute
			$this->db->setQuery($query);
			$result = (int) ($this->db->loadResult() ?? 0);

			// check database table is exist or not
			if ($result)
			{
				// Get new component id.
				// Use $this->db instead
				$query = $this->db->getQuery(true);
				$query->select('*');
				$query->from($this->db->quoteName('#__acym_plugin'));
				$query->where($this->db->quoteName('folder_name') . ' = ' . $this->db->quote('jticketing'));
				$this->db->setQuery($query);
				$data = $db->loadObject();

				if (!($data && $data->id))
				{
					// Use $this->db instead
					$acymInteObject = new stdclass;
					$acymInteObject->title = 'Jticketing';
					$acymInteObject->folder_name = 'jticketing';
					$acymInteObject->version = '1.0.0';
					$acymInteObject->active = '1';
					$acymInteObject->category = 'Event management';
					$acymInteObject->level = '';
					$acymInteObject->uptodate = '1';
					$acymInteObject->latest_version = '1.0.0';
					$acymInteObject->description = '<a href=\"https://techjoomla.com/jticketing\" target=\"_blank\"> https://techjoomla.com/jticketing<i class=\"fa fa-external-link ms-2\" aria-hidden=\"true\"></i> </a>';
					$acymInteObject->type = 'ADDON';

					if (!$this->db->insertObject('#__acym_plugin', $acymInteObject, 'id'))
					{
						Log::add('Error inserting category', Log::WARNING, 'com_jticketing');

						return false;
					}
				}

			}
		}
	}
}