# Joomla 6 Migration Rules - Old Code vs New Code


## 1. DATABASE ACCESS
### Rule 1.1: Factory::getDbo() → Dependency Injection
```php
// ❌ OLD (Joomla 3/4/5)
$db = Factory::getDbo();


// ✅ NEW (Joomla 6)
// In constructor:
private $db;
public function __construct()
{
   $this->db = Factory::getContainer()->get(DatabaseInterface::class);
}
// Then use: $this->db
```


### Rule 1.2: Database Query Results
```php
// ❌ OLD
$count = (int) ($db->loadColumn()[0] ?? 0);
$result = $db->loadColumn()[0];


// ✅ NEW
$count = (int) ($this->db->loadResult() ?? 0);
$result = $this->db->loadResult();
```


### Rule 1.3: splitSql() Method
```php
// ❌ OLD
$queries = JDatabaseDriver::splitSql($buffer);


// ✅ NEW
$queries = $this->db->splitSql($buffer);
```


## 2. INSTALLER CLASS


### Rule 2.1: Installer Instantiation
```php
// ❌ OLD
$installer = Factory::getContainer()->get(Installer::class);
$installer = new Installer($db);


// ✅ NEW
$installer = new Installer();
// Database is automatically injected from container
```


### Rule 2.2: Set Database on Installer (if needed)
```php
// ✅ NEW (for safety)
$installer = new Installer();
if (method_exists($installer, 'setDatabase'))
{
   $installer->setDatabase($this->db);
}
```


## 3. DEPRECATED CLASSES


### Rule 3.1: CMSObject → stdClass
```php
// ❌ OLD
use Joomla\CMS\Object\CMSObject;
$status = new CMSObject;


// ✅ NEW
$status = new \stdClass;
```


### Rule 3.2: JToolBarHelper → ToolbarHelper
```php
// ❌ OLD
use Joomla\CMS\Toolbar\JToolBarHelper;
JToolBarHelper::title('Title', 'icon.png');
JToolBarHelper::apply('task.apply', 'JTOOLBAR_APPLY');
JToolBarHelper::save('task.save', 'JTOOLBAR_SAVE');
JToolBarHelper::cancel('task.cancel', 'JTOOLBAR_CANCEL');


// ✅ NEW
use Joomla\CMS\Toolbar\ToolbarHelper;
ToolbarHelper::title('Title', 'icon');
ToolbarHelper::apply('task.apply', 'JTOOLBAR_APPLY');
ToolbarHelper::save('task.save', 'JTOOLBAR_SAVE');
ToolbarHelper::cancel('task.cancel', 'JTOOLBAR_CANCEL');
```


### Rule 3.3: JFile → File
```php
// ❌ OLD
use Joomla\CMS\Filesystem\File;
JFile::exists($path);
JFile::delete($path);


// ✅ NEW
use Joomla\Filesystem\File;
File::exists($path);
File::delete($path);
```


### Rule 3.4: JFolder → Folder
```php
// ❌ OLD
use Joomla\CMS\Filesystem\Folder;


JFolder::delete($path);
JFolder::copy($src, $dest);


// ✅ NEW
use Joomla\Filesystem\Folder;
Folder::delete($path);
Folder::copy($src, $dest);
```


### Rule 3.5: JLoader → Modern Autoloading
```php
// ❌ OLD
JLoader::import('components.com_mycomponent.models.mymodel', JPATH_ADMINISTRATOR);
JLoader::registerPrefix('MyPrefix', JPATH_LIBRARIES . '/myprefix');


// ✅ NEW
// Use composer autoloading or require_once with file_exists check
if (file_exists(JPATH_ADMINISTRATOR . '/components/com_mycomponent/models/mymodel.php'))
{
   require_once JPATH_ADMINISTRATOR . '/components/com_mycomponent/models/mymodel.php';
}
```


### Rule 3.6: JError → Exception/RuntimeException
```php
// ❌ OLD
JError::raiseError(500, 'Error message');


// ✅ NEW
throw new RuntimeException('Error message');
// Or use Log::add() for non-fatal errors
Log::add('Error message', Log::ERROR, 'jerror');
```


### Rule 3.7: JResponseJson → JsonResponse
```php
// ❌ OLD
use Joomla\CMS\Response\JsonResponse;
$response = new JResponseJson($data);


// ✅ NEW
use Joomla\CMS\Response\JsonResponse;
$response = new JsonResponse($data);
```


## 4. ERROR HANDLING


### Rule 4.1: enqueueMessage() → Log::add()
```php
// ❌ OLD
Factory::getApplication()->enqueueMessage('Error message', 'error');
Factory::getApplication()->enqueueMessage($db->getErrorMsg(), 'warning');


// ✅ NEW
use Joomla\CMS\Log\Log;
Log::add('Error message', Log::ERROR, 'jerror');
Log::add($e->getMessage(), Log::WARNING, 'jerror');
```


### Rule 4.2: Database Error Handling
```php
// ❌ OLD
$db->setQuery($query);
if (!$db->execute())
{
   Factory::getApplication()->enqueueMessage($db->getErrorMsg(), 'error');
}


// ✅ NEW
try
{
   $this->db->setQuery($query);
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
```


## 5. METHOD SIGNATURES


### Rule 5.1: Installer Methods
```php
// ❌ OLD
public function preflight($type, $parent)
public function postflight($type, $parent)
public function install($parent)
public function update($parent)
public function uninstall($parent)


// ✅ NEW
use Joomla\CMS\Installer\InstallerAdapter;


public function preflight(string $type, InstallerAdapter $parent): void
public function postflight(string $type, InstallerAdapter $parent): void
public function install(InstallerAdapter $parent): void
public function update(InstallerAdapter $parent): void
public function uninstall(InstallerAdapter $parent): void
```


### Rule 5.2: View Display Method
```php
// ❌ OLD
public function display($tpl = null)


// ✅ NEW
public function display($tpl = null): void
```


## 6. TOOLBAR ICONS


### Rule 6.1: Icon Names Changed
```php
// ❌ OLD
JToolBarHelper::title('Title', 'edit.png');
JToolBarHelper::custom('task', 'save-new.png', 'save-new_f2.png', 'LABEL');


// ✅ NEW
ToolbarHelper::title('Title', 'edit');
ToolbarHelper::custom('task', 'save-new', 'save-new_f2', 'LABEL');
// Icon extensions (.png) are no longer needed
```


## 7. NAMESPACE IMPORTS


### Rule 7.1: Correct Namespaces
```php
// ❌ OLD
use Joomla\CMS\Object\CMSObject;
use Joomla\CMS\Filesystem\File;
use Joomla\CMS\Filesystem\Folder;
// ✅ NEW


use Joomla\Filesystem\File;
use Joomla\Filesystem\Folder;


use Joomla\CMS\Toolbar\ToolbarHelper;
use Joomla\CMS\Log\Log;
use Joomla\CMS\Installer\InstallerAdapter;
use Joomla\Database\DatabaseInterface;
```


## 8. QUERY BUILDING


### Rule 8.1: Quote String Values
```php
// ❌ OLD
$query->where($db->quoteName('type') . ' = plugin');


// ✅ NEW
$query->where($this->db->quoteName('type') . ' = ' . $this->db->quote('plugin'));
```


### Rule 8.2: whereIn() Method
```php
// ❌ OLD
$query->where($db->quoteName('path') . ' IN ("value1", "value2")');


// ✅ NEW
$paths = ['value1', 'value2'];
$query->whereIn($this->db->quoteName('path'), $paths);
```


## 9. DEPRECATED SHORTCUTS


### Rule 9.1: qn() and q() Shortcuts
```php
// ❌ OLD
$db->qn('field')
$db->q('value')


// ✅ NEW
$this->db->quoteName('field')
$this->db->quote('value')
```
Old HTMLHelper::_('formbehavior.chosen', 'select');


New HTMLHelper::_('behavior.multiselect'); // only for list tables






## 10. FILE OPERATIONS


### Rule 10.1: File Existence Check
```php
// ❌ OLD
if (JFile::exists($path))
if (!file_exists($path))


// ✅ NEW
if (file_exists($path))
```


### Rule 10.2: File Operations with Error Handling
```php
// ❌ OLD
File::delete($path);


// ✅ NEW
try
{
   File::delete($path);
}
catch (\Exception $e)
{
   Log::add('Error deleting file: ' . $e->getMessage(), Log::WARNING, 'jerror');
}




oLd 	filter="JComponentHelper::filterText"
NEw   filter="\Joomla\CMS\Component\ComponentHelper::filterText"


Old class JFormFieldMyField extends JFormFieldGroupedList


New -> add namespace in top then change  JFormFieldGroupedList to  GroupedlistField
Sample 
use Joomla\CMS\Form\Field\GroupedlistField;
class JFormFieldMyField extends GroupedlistField


If constant is present in define file and  the constants used in other file then check and replace with like 


Old    constant
New    \define(constant)
Old use Joomla\CMS\Filesystem\Path; 


new use Joomla\Filesystem\Path;


```


## 11. CONFIGURATION ACCESS


### Rule 11.1: Configuration Remains Same
```php
// ✅ Still works in Joomla 6
$config = Factory::getConfig();
$dbname = $config->get('db');
$dbprefix = $config->get('dbprefix');
```


## 12. COMPLETE EXAMPLE


### Before (Joomla 3/4/5)
```php
<?php
use Joomla\CMS\Factory;
use Joomla\CMS\Toolbar\JToolBarHelper;
use Joomla\CMS\MVC\View\HtmlView;


class MyView extends HtmlView
{
   public function display($tpl = null)
   {
       $db = Factory::getDbo();
       $query = $db->getQuery(true)
           ->select('*')
           ->from($db->quoteName('#__mytable'));
       $db->setQuery($query);
       $results = $db->loadObjectList();
      
       JToolBarHelper::title('My Title', 'edit.png');
       JToolBarHelper::save('task.save', 'JTOOLBAR_SAVE');
      
       parent::display($tpl);
   }
}
```


### After (Joomla 6)
```php
<?php
use Joomla\CMS\Factory;
use Joomla\CMS\Toolbar\ToolbarHelper;
use Joomla\CMS\MVC\View\HtmlView;
use Joomla\CMS\Log\Log;
use Joomla\Database\DatabaseInterface;


class MyView extends HtmlView
{
   private $db;
  
   public function __construct()
   {
       parent::__construct();
       $this->db = Factory::getContainer()->get(DatabaseInterface::class);
   }
  
   public function display($tpl = null): void
   {
       try
       {
           $query = $this->db->getQuery(true)
               ->select('*')
               ->from($this->db->quoteName('#__mytable'));
           $this->db->setQuery($query);
           $results = $this->db->loadObjectList();
          
           ToolbarHelper::title('My Title', 'edit');
           ToolbarHelper::save('task.save', 'JTOOLBAR_SAVE');
          
           parent::display($tpl);
       }
       catch (\RuntimeException $e)
       {
           Log::add($e->getMessage(), Log::ERROR, 'jerror');
       }
   }
}
```


OLD -> JHtmlSidebar::render()




New -> /**
	 * Render the sidebar for Joomla 6
	 *
	 * @return string  The rendered sidebar HTML
	 *
	 * @since  2.0.0
	 */
	protected function renderSidebar()
	{
		// Check if the submenu exists
		$input = $this->app->input;
		$option = $input->get('option');
		
		// Get the submenu items
		$menu = $this->app->getMenu('administrator');
		
		if (!$menu)
		{
			return '';
		}
		
		// For Joomla 6, we'll render a simple sidebar
		// You can customize this based on your component's needs
		$sidebar = '';
		
		// Try to get submenu from the helper if it exists
		if (class_exists('TjnotificationsHelper') && method_exists('TjnotificationsHelper', 'getSubmenu'))
		{
			$submenu = TjnotificationsHelper::getSubmenu('notifications');
			
			if (!empty($submenu))
			{
				$sidebar .= '<div class="sidebar">';
				$sidebar .= '<ul class="nav flex-column">';
				
				foreach ($submenu as $item)
				{
					$active = ($item['active']) ? ' active' : '';
					$sidebar .= '<li class="nav-item' . $active . '">';
					$sidebar .= '<a class="nav-link" href="' . $item['link'] . '">' . $item['name'] . '</a>';
					$sidebar .= '</li>';
				}
				
				$sidebar .= '</ul>';
				$sidebar .= '</div>';
			}
		}
		
		return $sidebar;
	}
Change helper as per your component.


## Quick Reference Checklist


When upgrading code to Joomla 6:
- [ ] Replace Factory::getDbo() with dependency injection
- [ ] Change JToolBarHelper to ToolbarHelper
- [ ] Remove .png from icon names
- [ ] Replace CMSObject with stdClass
- [ ] Add type hints to all methods
- [ ] Add return type declarations
- [ ] Wrap database operations in try-catch
- [ ] Replace enqueueMessage() with Log::add()
- [ ] Use quoteName() and quote() instead of qn() and q()
- [ ] Update namespace imports
- [ ] Remove JVERSION conditionals
- [ ] Replace JFile/JFolder with File/Folder
- [ ] Remove JLoader usage
- [ ] Add InstallerAdapter type hints
- [ ] Test all functionality




