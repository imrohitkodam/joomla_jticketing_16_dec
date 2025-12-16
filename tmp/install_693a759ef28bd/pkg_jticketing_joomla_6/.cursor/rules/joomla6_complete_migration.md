# Complete Joomla 6 Migration Guide for JGive Component

## Overview
This guide provides comprehensive instructions for migrating the JGive component from Joomla 5.x to Joomla 6. All deprecated classes, methods, and patterns have been documented with their replacements.

---

## PART 1: CRITICAL CLASS REPLACEMENTS (REMOVED FROM JOOMLA 6)

### 1.1 Core J-Prefix Classes (MUST REPLACE - NO LONGER AVAILABLE)

| Old Class (Deprecated) | New Class (Joomla 6) | Required Import Statement |
|------------------------|----------------------|---------------------------|
| `JFactory` | `Factory` | `use Joomla\CMS\Factory;` |
| `JURI` | `Uri` | `use Joomla\CMS\Uri\Uri;` |
| `JInput` | `Input` | `use Joomla\Input\Input;` |
| `JPlugin` | `CMSPlugin` | `use Joomla\CMS\Plugin\CMSPlugin;` |
| `JTable` | `Table` | `use Joomla\CMS\Table\Table;` |
| `JRegistry` | `Registry` | `use Joomla\Registry\Registry;` |
| `JUser` | `User` | `use Joomla\CMS\User\User;` |
| `JDatabase` | `DatabaseDriver` | `use Joomla\Database\DatabaseDriver;` |
| `JSession` | `Session` | `use Joomla\CMS\Session\Session;` |
| `JRoute` | `Route` | `use Joomla\CMS\Router\Route;` |
| `JText` | `Text` | `use Joomla\CMS\Language\Text;` |
| `JHtml` | `HTMLHelper` | `use Joomla\CMS\HTML\HTMLHelper;` |
| `JMail` | `Mail` | `use Joomla\CMS\Mail\Mail;` |
| `JDate` | `Date` | `use Joomla\CMS\Date\Date;` |
| `JPath` | `Path` | `use Joomla\Filesystem\Path;` |
| `JObject` | `CMSObject` or `stdClass` | `use Joomla\CMS\Object\CMSObject;` |
| `JFile` | `File` | `use Joomla\Filesystem\File;` |
| `JFolder` | `Folder` | `use Joomla\Filesystem\Folder;` |
| `JForm` | `Form` | `use Joomla\CMS\Form\Form;` |
| `JDocument` | `Document` | `use Joomla\CMS\Document\Document;` |

### 1.2 Helper Classes (J-Prefix Removed)

| Old Class | New Class | Import Statement |
|-----------|-----------|------------------|
| `JComponentHelper` | `ComponentHelper` | `use Joomla\CMS\Component\ComponentHelper;` |
| `JModuleHelper` | `ModuleHelper` | `use Joomla\CMS\Helper\ModuleHelper;` |
| `JPluginHelper` | `PluginHelper` | `use Joomla\CMS\Plugin\PluginHelper;` |
| `JLayoutHelper` | `LayoutHelper` | `use Joomla\CMS\Layout\LayoutHelper;` |
| `JLog` | `Log` | `use Joomla\CMS\Log\Log;` |
| `JLanguageHelper` | `LanguageHelper` | `use Joomla\CMS\Language\LanguageHelper;` |
| `JAccess` | `Access` | `use Joomla\CMS\Access\Access;` |
| `JCache` | `Cache` | `use Joomla\CMS\Cache\Cache;` |
| `JCacheController` | `CacheController` | `use Joomla\CMS\Cache\CacheController;` |
| `JEditor` | `Editor` | `use Joomla\CMS\Editor\Editor;` |
| `JToolbar` | `Toolbar` | `use Joomla\CMS\Toolbar\Toolbar;` |
| `JToolbarHelper` | `ToolbarHelper` | `use Joomla\CMS\Toolbar\ToolbarHelper;` |

### 1.3 Application Classes

| Old Class | New Class | Import Statement |
|-----------|-----------|------------------|
| `JApplicationCms` | `CMSApplication` | `use Joomla\CMS\Application\CMSApplication;` |
| `JApplicationWeb` | `WebApplication` | `use Joomla\CMS\Application\WebApplication;` |
| `JApplicationAdministrator` | `AdministratorApplication` | `use Joomla\CMS\Application\AdministratorApplication;` |
| `JApplicationSite` | `SiteApplication` | `use Joomla\CMS\Application\SiteApplication;` |
| `JApplicationCli` | `ConsoleApplication` | `use Joomla\CMS\Application\ConsoleApplication;` |

### 1.4 MVC Classes (Models, Views, Controllers)

| Old Class | New Class | Import Statement |
|-----------|-----------|------------------|
| `JModel` | `BaseModel` | `use Joomla\CMS\MVC\Model\BaseModel;` |
| `JModelLegacy` | `BaseDatabaseModel` | `use Joomla\CMS\MVC\Model\BaseDatabaseModel;` |
| `JModelList` | `ListModel` | `use Joomla\CMS\MVC\Model\ListModel;` |
| `JModelAdmin` | `AdminModel` | `use Joomla\CMS\MVC\Model\AdminModel;` |
| `JModelForm` | `FormModel` | `use Joomla\CMS\MVC\Model\FormModel;` |
| `JModelItem` | `ItemModel` | `use Joomla\CMS\MVC\Model\ItemModel;` |
| `JView` | `HtmlView` | `use Joomla\CMS\MVC\View\HtmlView;` |
| `JViewLegacy` | `HtmlView` | `use Joomla\CMS\MVC\View\HtmlView;` |
| `JViewHtml` | `HtmlView` | `use Joomla\CMS\MVC\View\HtmlView;` |
| `JController` | `BaseController` | `use Joomla\CMS\MVC\Controller\BaseController;` |
| `JControllerLegacy` | `BaseController` | `use Joomla\CMS\MVC\Controller\BaseController;` |
| `JControllerAdmin` | `AdminController` | `use Joomla\CMS\MVC\Controller\AdminController;` |
| `JControllerForm` | `FormController` | `use Joomla\CMS\MVC\Controller\FormController;` |

### 1.5 Database Classes

| Old Class | New Class | Import Statement |
|-----------|-----------|------------------|
| `JDatabaseDriver` | `DatabaseDriver` | `use Joomla\Database\DatabaseDriver;` |
| `JDatabaseQuery` | `DatabaseQuery` | `use Joomla\Database\DatabaseQuery;` |
| `JDatabaseIterator` | `DatabaseIterator` | `use Joomla\Database\DatabaseIterator;` |

---

## PART 2: NAMESPACE CHANGES (CRITICAL)

### 2.1 Filesystem Package (MOVED OUT OF CMS)

**OLD NAMESPACE:** `\Joomla\CMS\Filesystem\`  
**NEW NAMESPACE:** `\Joomla\Filesystem\`

```php
// Old (WRONG in Joomla 6):
use Joomla\CMS\Filesystem\File;
use Joomla\CMS\Filesystem\Folder;
use Joomla\CMS\Filesystem\Path;

// New (CORRECT in Joomla 6):
use Joomla\Filesystem\File;
use Joomla\Filesystem\Folder;
use Joomla\Filesystem\Path;
```

**Find and Replace:**
- Find: `use Joomla\CMS\Filesystem\File;`
- Replace: `use Joomla\Filesystem\File;`

- Find: `use Joomla\CMS\Filesystem\Folder;`
- Replace: `use Joomla\Filesystem\Folder;`

- Find: `use Joomla\CMS\Filesystem\Path;`
- Replace: `use Joomla\Filesystem\Path;`

### 2.2 Input Package (MOVED OUT OF CMS)

**OLD NAMESPACE:** `\Joomla\CMS\Input\`  
**NEW NAMESPACE:** `\Joomla\Input\`

```php
// Old (WRONG in Joomla 6):
use Joomla\CMS\Input\Input;
use Joomla\CMS\Input\Cookie;
use Joomla\CMS\Input\Files;

// New (CORRECT in Joomla 6):
use Joomla\Input\Input;
use Joomla\Input\Cookie;
use Joomla\Input\Files;
```

**Find and Replace:**
- Find: `use Joomla\CMS\Input\`
- Replace: `use Joomla\Input\`

### 2.3 HTTP Package (MOVED OUT OF CMS)

**OLD NAMESPACE:** `\Joomla\CMS\Http\`  
**NEW NAMESPACE:** `\Joomla\Http\`

```php
// Old:
use Joomla\CMS\Http\Http;
use Joomla\CMS\Http\HttpFactory;

// New:
use Joomla\Http\Http;
use Joomla\Http\HttpFactory;
```

---

## PART 3: METHOD CHANGES

### 3.1 JFactory Method Replacements

```php
// Old:
$app = JFactory::getApplication();
$db = JFactory::getDbo();
$user = JFactory::getUser();
$session = JFactory::getSession();
$config = JFactory::getConfig();
$document = JFactory::getDocument();
$mailer = JFactory::getMailer();
$language = JFactory::getLanguage();
$uri = JFactory::getURI();

// New:
use Joomla\CMS\Factory;

$app = Factory::getApplication();
$db = Factory::getContainer()->get('DatabaseDriver');
$user = Factory::getUser();
$session = Factory::getSession();
$config = Factory::getConfig();
$document = Factory::getDocument();
$mailer = Factory::getMailer();
$language = Factory::getLanguage();
$uri = Uri::getInstance(); // Note: NOT Factory::getURI()
```

### 3.2 JURI (CRITICAL - COMPLETELY REMOVED)

```php
// Old:
$root = JURI::root();
$base = JURI::base();
$current = JURI::current();
$uri = JURI::getInstance();
JURI::base(true); // Relative path

// New:
use Joomla\CMS\Uri\Uri;

$root = Uri::root();
$base = Uri::base();
$current = Uri::current();
$uri = Uri::getInstance();
Uri::base(true); // Relative path
```

**Find and Replace:**
- Find: `JURI::`
- Replace: `Uri::`
- Add at top: `use Joomla\CMS\Uri\Uri;`

### 3.3 Application Input Property (CHANGED)

```php
// Old:
$value = $app->input->get('foo');
$value = Factory::getApplication()->input->get('foo');

// New:
$value = $app->getInput()->get('foo');
$value = Factory::getApplication()->getInput()->get('foo');
```

**Find and Replace:**
- Find: `->input->`
- Replace: `->getInput()->`

### 3.4 Database getNullDate() (DEPRECATED)

```php
// Old:
if ($this->item->created !== $this->db->getNullDate()) {
    echo $this->item->created;
}

// New:
if ($this->item->created !== null) {
    echo $this->item->created;
}
```

**Find and Replace:**
- Find: `->getNullDate()`
- Replace: `null`

### 3.5 Table getInstance() (CHANGED)

```php
// Old:
$table = JTable::getInstance('content', 'JTable');
$table = Table::getInstance('content');

// New:
use Joomla\CMS\Table\Content;
$table = new Content(Factory::getContainer()->get('DatabaseDriver'));

// OR for custom tables:
$table = $this->getTable('YourTableName');
```

### 3.6 Model getItem() Returns stdClass (CHANGED)

```php
// Old (Registry object):
$item = $model->getItem(1);
echo $item->get('title');

// New (stdClass object):
$item = $model->getItem(1);
echo $item->title; // Direct property access
```

### 3.7 Image createThumbs() (RENAMED)

```php
// Old:
$image->createThumbs('50x50');

// New:
$image->createThumbnails('50x50');
```

**Find and Replace:**
- Find: `->createThumbs(`
- Replace: `->createThumbnails(`

### 3.8 File/Folder exists() (USE PHP NATIVE)

```php
// Old:
use Joomla\Filesystem\File;
use Joomla\Filesystem\Folder;

if (File::exists($path)) { }
if (Folder::exists($path)) { }

// New (Preferred - Native PHP):
if (is_file($path)) { }
if (is_dir($path)) { }

// OR still use Joomla:
if (File::exists($path)) { } // Still works but native is preferred
```

### 3.9 isCli() Method (CHANGED)

```php
// Old:
if ($app->isCli()) {
    // Do something
}

// New:
use Joomla\CMS\Application\ConsoleApplication;

if ($app instanceof ConsoleApplication) {
    // Do something
}
```

### 3.10 TagsHelper postStoreProcess() (CHANGED SIGNATURE)

```php
// Old:
$tagsHelper->postStoreProcess($item);

// New:
$tagsHelper->postStore($item, $newTags, $replace = true, $remove = false);
```

### 3.11 Finder/Smart Search Helpers (CHANGED)

```php
// Old:
require_once JPATH_ADMINISTRATOR . '/components/com_finder/helpers/indexer/helper.php';
FinderIndexerHelper::getFinderPluginId();

// New:
use Joomla\Component\Finder\Administrator\Helper\FinderHelper;
FinderHelper::getFinderPluginId();
```

---

## PART 4: PLUGIN CHANGES

### 4.1 Plugin Class Extension

```php
// Old:
class PlgSystemExample extends JPlugin
{
    // ...
}

// New:
use Joomla\CMS\Plugin\CMSPlugin;

class PlgSystemExample extends CMSPlugin
{
    // ...
}
```

### 4.2 Remove $app Property Access in Plugins

```php
// Old:
class PlgSystemExample extends CMSPlugin
{
    public function onAfterRoute()
    {
        $app = $this->app; // DEPRECATED
    }
}

// New:
class PlgSystemExample extends CMSPlugin
{
    public function onAfterRoute()
    {
        $app = $this->getApplication();
    }
}
```

**Find and Replace in Plugins:**
- Find: `$this->app`
- Replace: `$this->getApplication()`

### 4.3 Remove cleanCache $clientId Parameter

```php
// Old:
protected function cleanCache($group = null, $clientId = 0)
{
    parent::cleanCache($group, $clientId);
}

// New:
protected function cleanCache($group = null)
{
    parent::cleanCache($group);
}
```

---

## PART 5: CONSTANTS CHANGES

### 5.1 JPATH_PLATFORM (REMOVED)

```php
// Old:
defined('JPATH_PLATFORM') or die;

// New:
defined('_JEXEC') or die;
```

**Find and Replace:**
- Find: `defined('JPATH_PLATFORM')`
- Replace: `defined('_JEXEC')`

### 5.2 Component Path Constants (REMOVED)

These constants are NO LONGER AVAILABLE:
- `JPATH_COMPONENT`
- `JPATH_COMPONENT_SITE`
- `JPATH_COMPONENT_ADMINISTRATOR`

```php
// Old:
require_once JPATH_COMPONENT . '/helpers/helper.php';

// New:
require_once JPATH_ADMINISTRATOR . '/components/com_jgive/helpers/helper.php';
// OR
require_once JPATH_SITE . '/components/com_jgive/helpers/helper.php';
```

### 5.3 Timezone GMT → UTC

```php
// Old:
$date->setTimezone('GMT');
$tz = 'GMT';

// New:
$date->setTimezone('UTC');
$tz = 'UTC';
```

**Find and Replace:**
- Find: `'GMT'`
- Replace: `'UTC'`

---

## PART 6: jimport() STATEMENTS (REMOVE ALL)

**ALL `jimport()` statements MUST BE REMOVED** and replaced with proper `use` statements.

```php
// Old:
jimport('joomla.application.component.helper');
jimport('joomla.filesystem.file');
jimport('joomla.filesystem.folder');

// New:
use Joomla\CMS\Component\ComponentHelper;
use Joomla\Filesystem\File;
use Joomla\Filesystem\Folder;
```

**Find and Replace:**
- Find all: `jimport(`
- Remove entire line
- Add proper `use` statement at top of file

---

## PART 7: DEPRECATED CLASSES TO AVOID

These classes have NO direct replacement or should use alternatives:

| Deprecated Class | Alternative |
|------------------|-------------|
| `CMSObject` | Use `stdClass` or specific classes |
| `\Joomla\CMS\Adapter\Adapter` | Removed - No replacement |
| `\Joomla\CMS\Adapter\AdapterInstance` | Removed - No replacement |
| `LegacyErrorHandlingTrait` | Removed from CategoryNode and Changelog |

---

## PART 8: HTTP RESPONSE CHANGES

### 8.1 PSR-7 Response Object (NO MORE MAGIC PROPERTIES)

```php
// Old:
$response = $http->get($url);
echo $response->body;
echo $response->code;

// New:
$response = $http->get($url);
echo $response->getBody();
echo $response->getStatusCode();
```

---

## PART 9: COMPLETE FIND & REPLACE LIST

### Priority 1: Critical Replacements

1. **JURI Class:**
   - Find: `JURI::`
   - Replace: `Uri::`
   - Add import: `use Joomla\CMS\Uri\Uri;`

2. **JFactory Class:**
   - Find: `JFactory::`
   - Replace: `Factory::`
   - Add import: `use Joomla\CMS\Factory;`

3. **Input Namespace:**
   - Find: `use Joomla\CMS\Input\`
   - Replace: `use Joomla\Input\`

4. **Filesystem Namespace:**
   - Find: `use Joomla\CMS\Filesystem\`
   - Replace: `use Joomla\Filesystem\`

5. **Application Input:**
   - Find: `->input->`
   - Replace: `->getInput()->`

### Priority 2: J-Prefix Classes

6. **JText:**
   - Find: `JText::`
   - Replace: `Text::`
   - Add import: `use Joomla\CMS\Language\Text;`

7. **JRoute:**
   - Find: `JRoute::`
   - Replace: `Route::`
   - Add import: `use Joomla\CMS\Router\Route;`

8. **JHtml:**
   - Find: `JHtml::`
   - Replace: `HTMLHelper::`
   - Add import: `use Joomla\CMS\HTML\HTMLHelper;`

9. **JSession:**
   - Find: `JSession::`
   - Replace: `Session::`
   - Add import: `use Joomla\CMS\Session\Session;`

10. **JComponentHelper:**
    - Find: `JComponentHelper::`
    - Replace: `ComponentHelper::`
    - Add import: `use Joomla\CMS\Component\ComponentHelper;`

11. **JPluginHelper:**
    - Find: `JPluginHelper::`
    - Replace: `PluginHelper::`
    - Add import: `use Joomla\CMS\Plugin\PluginHelper;`

12. **JModuleHelper:**
    - Find: `JModuleHelper::`
    - Replace: `ModuleHelper::`
    - Add import: `use Joomla\CMS\Helper\ModuleHelper;`

### Priority 3: MVC Classes

13. **JModelLegacy:**
    - Find: `extends JModelLegacy`
    - Replace: `extends BaseDatabaseModel`
    - Add import: `use Joomla\CMS\MVC\Model\BaseDatabaseModel;`

14. **JModelList:**
    - Find: `extends JModelList`
    - Replace: `extends ListModel`
    - Add import: `use Joomla\CMS\MVC\Model\ListModel;`

15. **JModelAdmin:**
    - Find: `extends JModelAdmin`
    - Replace: `extends AdminModel`
    - Add import: `use Joomla\CMS\MVC\Model\AdminModel;`

16. **JViewLegacy:**
    - Find: `extends JViewLegacy`
    - Replace: `extends HtmlView`
    - Add import: `use Joomla\CMS\MVC\View\HtmlView;`

17. **JControllerLegacy:**
    - Find: `extends JControllerLegacy`
    - Replace: `extends BaseController`
    - Add import: `use Joomla\CMS\MVC\Controller\BaseController;`

18. **JControllerAdmin:**
    - Find: `extends JControllerAdmin`
    - Replace: `extends AdminController`
    - Add import: `use Joomla\CMS\MVC\Controller\AdminController;`

19. **JControllerForm:**
    - Find: `extends JControllerForm`
    - Replace: `extends FormController`
    - Add import: `use Joomla\CMS\MVC\Controller\FormController;`

### Priority 4: Other Classes

20. **JTable:**
    - Find: `extends JTable`
    - Replace: `extends Table`
    - Add import: `use Joomla\CMS\Table\Table;`

21. **JPlugin:**
    - Find: `extends JPlugin`
    - Replace: `extends CMSPlugin`
    - Add import: `use Joomla\CMS\Plugin\CMSPlugin;`

22. **JRegistry:**
    - Find: `new JRegistry`
    - Replace: `new Registry`
    - Add import: `use Joomla\Registry\Registry;`

23. **JDate:**
    - Find: `new JDate`
    - Replace: `new Date`
    - Add import: `use Joomla\CMS\Date\Date;`

### Priority 5: Constants & Others

24. **JPATH_PLATFORM:**
    - Find: `JPATH_PLATFORM`
    - Replace: `_JEXEC`

25. **jimport():**
    - Find: `jimport(`
    - Remove entire line
    - Add appropriate `use` statement

26. **getNullDate():**
    - Find: `->getNullDate()`
    - Replace: `null`

27. **GMT Timezone:**
    - Find: `'GMT'`
    - Replace: `'UTC'`

28. **createThumbs:**
    - Find: `->createThumbs(`
    - Replace: `->createThumbnails(`

---

## PART 10: EXECUTION INSTRUCTIONS FOR CURSOR AI

### Step-by-Step Process:

1. **BACKUP**: Create a backup of the entire JGive component before starting

2. **SCAN**: Scan all PHP files in the following directories:
   - `/administrator/components/com_jgive/`
   - `/components/com_jgive/`
   - `/plugins/*/jgive/`
   - `/modules/*/mod_jgive*/`

3. **PRIORITY ORDER**: Apply changes in this order:
   - First: JURI and JFactory replacements
   - Second: Namespace changes (Input, Filesystem, HTTP)
   - Third: All other J-prefix classes
   - Fourth: Method signature changes
   - Fifth: Constants and cleanup

4. **FOR EACH FILE**:
   - Apply all relevant find/replace operations
   - Add necessary `use` statements at the top (after namespace, before class)
   - Remove all `jimport()` statements
   - Ensure proper indentation and formatting
   - Add a comment `// Updated for Joomla 6 compatibility` at top if significant changes

5. **PRESERVE**:
   - Maintain existing functionality
   - Keep comments and documentation
   - Preserve custom business logic
   - Don't change database queries unless deprecated methods are used

6. **TEST MARKERS**: Add TODO comments where manual testing may be needed:
   ```php
   // TODO: Test this after Joomla 6 migration - Table instantiation changed
   ```

7. **VALIDATION**: After all changes, verify:
   - All files have proper namespace declarations
   - All files have necessary `use` statements
   - No `jimport()` statements remain
   - No J-prefix classes remain (except in comments/strings)
   - No `JURI::` calls remain

---

## PART 11: COMMON PATTERNS TO WATCH FOR

### Pattern 1: Factory Database Access
```php
// Old:
$db = JFactory::getDbo();

// New:
use Joomla\CMS\Factory;
$db = Factory::getContainer()->get('DatabaseDriver');
// OR in most cases:
$db = Factory::getDbo(); // Still works in Joomla 6
```

### Pattern 2: Getting Application
```php
// Old:
$app = JFactory::getApplication();

// New:
use Joomla\CMS\Factory;
$app = Factory::getApplication();
```

### Pattern 3: URL Building
```php
// Old:
$url = JURI::root() . 'index.php?option=com_jgive';

// New:
use Joomla\CMS\Uri\Uri;
$url = Uri::root() . 'index.php?option=com_jgive';
```

### Pattern 4: Language Strings
```php
// Old:
echo JText::_('COM_JGIVE_TITLE');

// New:
use Joomla\CMS\Language\Text;
echo Text::_('COM_JGIVE_TITLE');
```

### Pattern 5: Component Parameters
```php
// Old:
$params = JComponentHelper::getParams('com_jgive');

// New:
use Joomla\CMS\Component\ComponentHelper;
$params = ComponentHelper::getParams('com_jgive');
```

---

## NOTES:

- This guide covers ALL major deprecations from Joomla 5.x to 6.0
- Some methods may still work but are deprecated - replace them anyway
- Always test the component after migration with BC plugin DISABLED
- Check error logs after each major change
- Use PHPStan or similar tools to catch remaining issues

---

## SOURCE REFERENCES:
- Joomla Manual: Migrations 5.4 to 6.0
- Joomla API Documentation (6.0.x)
- Joomla Developer Network

---

**END OF MIGRATION GUIDE**