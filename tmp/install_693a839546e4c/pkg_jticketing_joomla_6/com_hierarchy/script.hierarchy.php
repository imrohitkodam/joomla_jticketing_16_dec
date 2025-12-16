<?php
/**
 * @version    SVN: <svn_id>
 * @package    Com_Hierarchy
 * @copyright  Copyright (C) 2016 - 2022 Techjoomla. All rights reserved.
 * @license    GNU General Public License version 2 or later; see http://www.gnu.org/licenses/gpl-2.0.html
 * Hierarchy Management Extension is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 */

// No direct access
defined('_JEXEC') or die;
use Joomla\CMS\Factory;
use Joomla\CMS\Installer\InstallerHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Installer\Installer;
use Joomla\CMS\Installer\InstallerAdapter;
use Joomla\CMS\Log\Log;
use Joomla\Database\DatabaseInterface;

/**
 * Hierarchy Installer
 *
 * @since  1.0.0
 */
class Com_HierarchyInstallerScript
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
	private $oldversion = "";

	private array $installation_queue = array(
		'plugins' => array(
			'privacy' => array(
				'hierarchy' => 1,
			),
			'actionlog' => array(
				'hierarchy' => 1,
			)
		)
	);

	private array $uninstall_queue = array(
		'plugins' => array(
			'privacy' => array(
				'hierarchy' => 1
			),
			'actionlog' => array(
				'hierarchy' => 1
			)
		)
	);

	/**
	 * method to run before an install/update/uninstall method
	 *
	 * @param   string            $type    install, update or discover_update
	 * @param   InstallerAdapter  $parent  Parent installer adapter
	 *
	 * @return void
	 */
	public function preflight(string $type, InstallerAdapter $parent): void
	{
	}

	/**
	 * method to install the component
	 *
	 * @param   InstallerAdapter  $parent  Parent installer adapter
	 *
	 * @return  void
	 */
	public function install(InstallerAdapter $parent): void
	{
	}

	/**
	 * method to update the component
	 *
	 * @param   InstallerAdapter  $parent  Parent installer adapter
	 *
	 * @return void
	 */
	public function update(InstallerAdapter $parent): void
	{
		$this->installSqlFiles($parent);
	}

	/**
	 * installSqlFiles
	 *
	 * @param   InstallerAdapter  $parent  Parent installer adapter
	 *
	 * @return  void
	 */
	public function installSqlFiles(InstallerAdapter $parent): void
	{
		// Obviously you may have to change the path and name if your installation SQL file ;)
		if (method_exists($parent, 'extension_root'))
		{
			$sqlfile = $parent->getPath('extension_root') . '/admin/sql/install.mysql.utf8.sql';
		}
		else
		{
			$sqlfile = $parent->getParent()->getPath('extension_root') . '/sql/install.mysql.utf8.sql';
		}

		// Check if SQL file exists
		if (!file_exists($sqlfile))
		{
			Log::add('Hierarchy: SQL file not found: ' . $sqlfile, Log::WARNING, 'com_hierarchy');
			return;
		}

		// Don't modify below this line
		$buffer = file_get_contents($sqlfile);

		if ($buffer !== false && !empty($buffer))
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
							return;
						}
					}
				}
			}
		}
	}

	/**
	 * Runs after install, update or discover_update
	 *
	 * @param   string            $type    install, update or discover_update
	 * @param   InstallerAdapter  $parent  Parent installer adapter
	 *
	 * @return  void
	 */
	public function postflight(string $type, InstallerAdapter $parent): void
	{
		// Install subextensions
		$status = $this->_installSubextensions($parent);
	}

	/**
	 * Installs subextensions (modules, plugins) bundled with the main extension
	 *
	 * @param   InstallerAdapter  $parent  Parent installer adapter
	 * 
	 * @return \stdClass The subextension installation status
	 */
	private function _installSubextensions(InstallerAdapter $parent): \stdClass
	{
		$src = $parent->getParent()->getPath('source');

		$status          = new \stdClass();
		$status->modules = array();
		$status->plugins = array();

		// Plugins installation
		if (count($this->installation_queue['plugins']))
		{
			foreach ($this->installation_queue['plugins'] as $folder => $plugins)
			{
				if (count($plugins))
				{
					foreach ($plugins as $plugin => $published)
					{
						$path = "$src/plugins/$folder/$plugin";

						if (!is_dir($path))
						{
							$path = "$src/plugins/$folder/plg_$plugin";
						}

						if (!is_dir($path))
						{
							$path = "$src/plugins/$plugin";
						}

						if (!is_dir($path))
						{
							$path = "$src/plugins/plg_$plugin";
						}

						if (!is_dir($path))
						{
							continue;
						}

						// Was the plugin already installed?
						$query = $this->db->getQuery(true)
							->select('COUNT(*)')
							->from($this->db->quoteName('#__extensions'))
							->where($this->db->quoteName('element') . ' = ' . $this->db->quote($plugin))
							->where($this->db->quoteName('folder') . ' = ' . $this->db->quote($folder));
						$this->db->setQuery($query);
						$count = (int) ($this->db->loadResult() ?? 0);

						$installer = new Installer();
						$installer->setDatabase($this->db);
						$result    = $installer->install($path);

						$status->plugins[] = array(
							'name'   => $plugin,
							'group'  => $folder,
							'result' => $result,
							'status' => $published,
						);

						if ($published && !$count)
						{
							$query = $this->db->getQuery(true)
								->update($this->db->quoteName('#__extensions'))
								->set($this->db->quoteName('enabled') . ' = ' . $this->db->quote('1'))
								->where($this->db->quoteName('element') . ' = ' . $this->db->quote($plugin))
								->where($this->db->quoteName('folder') . ' = ' . $this->db->quote($folder));
							$this->db->setQuery($query);
							$this->db->execute();
						}
					}
				}
			}
		}

		return $status;
	}

	/**
	 * Runs on uninstallation
	 *
	 * @param   InstallerAdapter  $parent  Parent installer adapter
	 *
	 * @return  void
	 */
	public function uninstall(InstallerAdapter $parent): void
	{
		// Uninstall subextensions
		$status = $this->_uninstallSubextensions($parent);
	}

	/**
	 * Uninstalls subextensions (modules, plugins) bundled with the main extension
	 *
	 * @param   InstallerAdapter  $parent  Parent installer adapter
	 * 
	 * @return \stdClass The subextension uninstallation status
	 */
	private function _uninstallSubextensions(InstallerAdapter $parent): \stdClass
	{
		$status          = new \stdClass();
		$status->modules = array();
		$status->plugins = array();

		$src = $parent->getParent()->getPath('source');

		// Plugins uninstallation
		if (count($this->uninstall_queue['plugins']))
		{
			foreach ($this->uninstall_queue['plugins'] as $folder => $plugins)
			{
				if (count($plugins))
				{
					foreach ($plugins as $plugin => $published)
					{
						$sql = $this->db->getQuery(true)
							->select($this->db->quoteName('extension_id'))
							->from($this->db->quoteName('#__extensions'))
							->where($this->db->quoteName('type') . ' = ' . $this->db->quote('plugin'))
							->where($this->db->quoteName('element') . ' = ' . $this->db->quote($plugin))
							->where($this->db->quoteName('folder') . ' = ' . $this->db->quote($folder));
						$this->db->setQuery($sql);
						$extensionIds = $this->db->loadColumn();
						$id = $extensionIds[0] ?? null;

						if ($id)
						{
							$installer = new Installer();
							$installer->setDatabase($this->db);
							$result    = $installer->uninstall('plugin', (int) $id);
							$status->plugins[] = array(
								'name'   => 'plg_' . $plugin,
								'group'  => $folder,
								'result' => $result,
							);
						}
					}
				}
			}
		}

		return $status;
	}
}
