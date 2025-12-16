Issue : 

An error has occurred.
0 Class "JObserverUpdater" not found
Call Stack
#	Function	Location
1	()	JROOT/administrator/components/com_jticketing/tables/event.php:356
2	JTicketingTableEvent->__construct()	JROOT/libraries/src/Table/Table.php:352
3	Joomla\CMS\Table\Table::getInstance()	JROOT/components/com_jticketing/models/eventform.php:66
4	JticketingModelEventForm->getTable()	JROOT/libraries/src/MVC/Model/AdminModel.php:1090
5	Joomla\CMS\MVC\Model\AdminModel->populateState()	JROOT/libraries/src/MVC/Model/StateBehaviorTrait.php:59
6	Joomla\CMS\MVC\Model\BaseModel->getState()	JROOT/libraries/src/MVC/Model/AdminModel.php:1035
7	Joomla\CMS\MVC\Model\AdminModel->getItem()	JROOT/components/com_jticketing/models/eventform.php:244
8	JticketingModelEventForm->getItem()	JROOT/administrator/components/com_jticketing/models/event.php:38
9	JTicketingModelEvent->loadFormData()	JROOT/libraries/src/MVC/Model/FormBehaviorTrait.php:108
10	Joomla\CMS\MVC\Model\FormModel->loadForm()	JROOT/components/com_jticketing/models/eventform.php:82
11	JticketingModelEventForm->getForm()	JROOT/libraries/src/MVC/View/AbstractView.php:171
12	Joomla\CMS\MVC\View\AbstractView->get()	JROOT/administrator/components/com_jticketing/views/event/view.html.php:81
13	JTicketingViewEvent->display()	JROOT/libraries/src/MVC/Controller/BaseController.php:697
14	Joomla\CMS\MVC\Controller\BaseController->display()	JROOT/administrator/components/com_jticketing/controller.php:59
15	JticketingController->display()	JROOT/libraries/src/MVC/Controller/BaseController.php:730
16	Joomla\CMS\MVC\Controller\BaseController->execute()	JROOT/administrator/components/com_jticketing/jticketing.php:114
17	require_once()	JROOT/libraries/src/Dispatcher/LegacyComponentDispatcher.php:71
18	Joomla\CMS\Dispatcher\LegacyComponentDispatcher::Joomla\CMS\Dispatcher\{closure}()	JROOT/libraries/src/Dispatcher/LegacyComponentDispatcher.php:73
19	Joomla\CMS\Dispatcher\LegacyComponentDispatcher->dispatch()	JROOT/libraries/src/Component/ComponentHelper.php:361
20	Joomla\CMS\Component\ComponentHelper::renderComponent()	JROOT/libraries/src/Application/AdministratorApplication.php:150
21	Joomla\CMS\Application\AdministratorApplication->dispatch()	JROOT/libraries/src/Application/AdministratorApplication.php:205
22	Joomla\CMS\Application\AdministratorApplication->doExecute()	JROOT/libraries/src/Application/CMSApplication.php:320
23	Joomla\CMS\Application\CMSApplication->execute()	JROOT/administrator/includes/app.php:58
24	require_once()	JROOT/administrator/index.php:32

Issue :

An error has occurred.
0 Call to undefined method Joomla\CMS\Factory::getDatabase()
Call Stack
#	Function	Location
1	()	JROOT/administrator/components/com_hierarchy/models/hierarchy.php:246
2	HierarchyModelHierarchy->getSubUsers()	JROOT/administrator/components/com_jticketing/helpers/jticketing.php:446
3	JticketingHelper::getSubusers()	JROOT/administrator/components/com_jticketing/models/fields/subuserfilter.php:72
4	JFormFieldSubuserfilter->getOptions()	JROOT/administrator/components/com_jticketing/models/fields/subuserfilter.php:44
5	JFormFieldSubuserfilter->getInput()	JROOT/libraries/src/Form/FormField.php:492
6	Joomla\CMS\Form\FormField->__get()	JROOT/libraries/src/Form/Field/ListField.php:252
7	Joomla\CMS\Form\Field\ListField->__get()	JROOT/layouts/joomla/searchtools/default/filters.php:35
8	include()	JROOT/libraries/src/Layout/FileLayout.php:128
9	Joomla\CMS\Layout\FileLayout->render()	JROOT/libraries/src/Layout/FileLayout.php:636
10	Joomla\CMS\Layout\FileLayout->sublayout()	JROOT/layouts/joomla/searchtools/default.php:97
11	include()	JROOT/libraries/src/Layout/FileLayout.php:128
12	Joomla\CMS\Layout\FileLayout->render()	JROOT/libraries/src/Layout/LayoutHelper.php:76
13	Joomla\CMS\Layout\LayoutHelper::render()	JROOT/administrator/components/com_jticketing/views/attendees/tmpl/default_bs5.php:57
14	include()	JROOT/libraries/src/MVC/View/HtmlView.php:416
15	Joomla\CMS\MVC\View\HtmlView->loadTemplate()	JROOT/administrator/components/com_jticketing/views/attendees/tmpl/default.php:21
16	include()	JROOT/libraries/src/MVC/View/HtmlView.php:416
17	Joomla\CMS\MVC\View\HtmlView->loadTemplate()	JROOT/libraries/src/MVC/View/HtmlView.php:204
18	Joomla\CMS\MVC\View\HtmlView->display()	JROOT/administrator/components/com_jticketing/views/attendees/view.html.php:322
19	JticketingViewAttendees->display()	JROOT/libraries/src/MVC/Controller/BaseController.php:697
20	Joomla\CMS\MVC\Controller\BaseController->display()	JROOT/administrator/components/com_jticketing/controller.php:59
21	JticketingController->display()	JROOT/libraries/src/MVC/Controller/BaseController.php:730
22	Joomla\CMS\MVC\Controller\BaseController->execute()	JROOT/administrator/components/com_jticketing/jticketing.php:114
23	require_once()	JROOT/libraries/src/Dispatcher/LegacyComponentDispatcher.php:71
24	Joomla\CMS\Dispatcher\LegacyComponentDispatcher::Joomla\CMS\Dispatcher\{closure}()	JROOT/libraries/src/Dispatcher/LegacyComponentDispatcher.php:73
25	Joomla\CMS\Dispatcher\LegacyComponentDispatcher->dispatch()	JROOT/libraries/src/Component/ComponentHelper.php:361
26	Joomla\CMS\Component\ComponentHelper::renderComponent()	JROOT/libraries/src/Application/AdministratorApplication.php:150
27	Joomla\CMS\Application\AdministratorApplication->dispatch()	JROOT/libraries/src/Application/AdministratorApplication.php:205
28	Joomla\CMS\Application\AdministratorApplication->doExecute()	JROOT/libraries/src/Application/CMSApplication.php:320
29	Joomla\CMS\Application\CMSApplication->execute()	JROOT/administrator/includes/app.php:58
30	require_once()	JROOT/administrator/index.php:32