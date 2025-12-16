issue :

An error has occurred.
0 Call to undefined method stdClass::get()
Call Stack
#	Function	Location
1	()	JROOT/administrator/components/com_jticketing/views/venues/view.html.php:96
2	JticketingViewVenues->addToolbar()	JROOT/administrator/components/com_jticketing/views/venues/view.html.php:65
3	JticketingViewVenues->display()	JROOT/libraries/src/MVC/Controller/BaseController.php:697
4	Joomla\CMS\MVC\Controller\BaseController->display()	JROOT/administrator/components/com_jticketing/controller.php:59
5	JticketingController->display()	JROOT/libraries/src/MVC/Controller/BaseController.php:730
6	Joomla\CMS\MVC\Controller\BaseController->execute()	JROOT/administrator/components/com_jticketing/jticketing.php:114
7	require_once()	JROOT/libraries/src/Dispatcher/LegacyComponentDispatcher.php:71
8	Joomla\CMS\Dispatcher\LegacyComponentDispatcher::Joomla\CMS\Dispatcher\{closure}()	JROOT/libraries/src/Dispatcher/LegacyComponentDispatcher.php:73
9	Joomla\CMS\Dispatcher\LegacyComponentDispatcher->dispatch()	JROOT/libraries/src/Component/ComponentHelper.php:361
10	Joomla\CMS\Component\ComponentHelper::renderComponent()	JROOT/libraries/src/Application/AdministratorApplication.php:150
11	Joomla\CMS\Application\AdministratorApplication->dispatch()	JROOT/libraries/src/Application/AdministratorApplication.php:205
12	Joomla\CMS\Application\AdministratorApplication->doExecute()	JROOT/libraries/src/Application/CMSApplication.php:320
13	Joomla\CMS\Application\CMSApplication->execute()	JROOT/administrator/includes/app.php:58
14	require_once()	JROOT/administrator/index.php:32

issue : 

Fatal error: Access level to ToolbarButtonCsvExport::fetchButton() must be public (as in class Joomla\CMS\Toolbar\ToolbarButton) in /var/www/ttpl-rt-234-php83.local/public/jt_joomla_6/libraries/techjoomla/tjtoolbar/button/csvexport.php on line 68

Compile Error: Access level to ToolbarButtonCsvExport::fetchButton() must be public (as in class Joomla\CMS\Toolbar\ToolbarButton)

issue :

An error has occurred.
0 Class "Toolbar" not found
Call Stack
#	Function	Location
1	()	JROOT/administrator/components/com_jticketing/views/catimpexp/view.html.php:103
2	JticketingViewCatimpexp->addToolbar()	JROOT/administrator/components/com_jticketing/views/catimpexp/view.html.php:72
3	JticketingViewCatimpexp->display()	JROOT/libraries/src/MVC/Controller/BaseController.php:697
4	Joomla\CMS\MVC\Controller\BaseController->display()	JROOT/administrator/components/com_jticketing/controller.php:59
5	JticketingController->display()	JROOT/libraries/src/MVC/Controller/BaseController.php:730
6	Joomla\CMS\MVC\Controller\BaseController->execute()	JROOT/administrator/components/com_jticketing/jticketing.php:114
7	require_once()	JROOT/libraries/src/Dispatcher/LegacyComponentDispatcher.php:71
8	Joomla\CMS\Dispatcher\LegacyComponentDispatcher::Joomla\CMS\Dispatcher\{closure}()	JROOT/libraries/src/Dispatcher/LegacyComponentDispatcher.php:73
9	Joomla\CMS\Dispatcher\LegacyComponentDispatcher->dispatch()	JROOT/libraries/src/Component/ComponentHelper.php:361
10	Joomla\CMS\Component\ComponentHelper::renderComponent()	JROOT/libraries/src/Application/AdministratorApplication.php:150
11	Joomla\CMS\Application\AdministratorApplication->dispatch()	JROOT/libraries/src/Application/AdministratorApplication.php:205
12	Joomla\CMS\Application\AdministratorApplication->doExecute()	JROOT/libraries/src/Application/CMSApplication.php:320
13	Joomla\CMS\Application\CMSApplication->execute()	JROOT/administrator/includes/app.php:58
14	require_once()	JROOT/administrator/index.php:32

issue:

An error has occurred.
0 Class "Toolbar" not found
Call Stack
#	Function	Location
1	()	JROOT/administrator/components/com_jticketing/views/allticketsales/view.html.php:192
2	JticketingViewallticketsales->setToolBar()	JROOT/administrator/components/com_jticketing/views/allticketsales/view.html.php:170
3	JticketingViewallticketsales->display()	JROOT/libraries/src/MVC/Controller/BaseController.php:697
4	Joomla\CMS\MVC\Controller\BaseController->display()	JROOT/administrator/components/com_jticketing/controller.php:59
5	JticketingController->display()	JROOT/libraries/src/MVC/Controller/BaseController.php:730
6	Joomla\CMS\MVC\Controller\BaseController->execute()	JROOT/administrator/components/com_jticketing/jticketing.php:114
7	require_once()	JROOT/libraries/src/Dispatcher/LegacyComponentDispatcher.php:71
8	Joomla\CMS\Dispatcher\LegacyComponentDispatcher::Joomla\CMS\Dispatcher\{closure}()	JROOT/libraries/src/Dispatcher/LegacyComponentDispatcher.php:73
9	Joomla\CMS\Dispatcher\LegacyComponentDispatcher->dispatch()	JROOT/libraries/src/Component/ComponentHelper.php:361
10	Joomla\CMS\Component\ComponentHelper::renderComponent()	JROOT/libraries/src/Application/AdministratorApplication.php:150
11	Joomla\CMS\Application\AdministratorApplication->dispatch()	JROOT/libraries/src/Application/AdministratorApplication.php:205
12	Joomla\CMS\Application\AdministratorApplication->doExecute()	JROOT/libraries/src/Application/CMSApplication.php:320
13	Joomla\CMS\Application\CMSApplication->execute()	JROOT/administrator/includes/app.php:58
14	require_once()	JROOT/administrator/index.php:32


issue:

An error has occurred.
0 Class "FormFieldList" not found
Call Stack
#	Function	Location
1	()	JROOT/administrator/components/com_jticketing/models/fields/eventslist.php:26
2	require_once()	JROOT/libraries/src/Form/FormHelper.php:271
3	Joomla\CMS\Form\FormHelper::loadClass()	JROOT/libraries/src/Form/FormHelper.php:136
4	Joomla\CMS\Form\FormHelper::loadType()	JROOT/libraries/src/Form/FormHelper.php:78
5	Joomla\CMS\Form\FormHelper::loadFieldType()	JROOT/libraries/src/Form/Form.php:1463
6	Joomla\CMS\Form\Form->loadField()	JROOT/libraries/src/Form/Form.php:446
7	Joomla\CMS\Form\Form->getGroup()	JROOT/layouts/joomla/searchtools/default.php:44
8	include()	JROOT/libraries/src/Layout/FileLayout.php:128
9	Joomla\CMS\Layout\FileLayout->render()	JROOT/libraries/src/Layout/LayoutHelper.php:76
10	Joomla\CMS\Layout\LayoutHelper::render()	JROOT/administrator/components/com_jticketing/views/orders/tmpl/default_bs5.php:48
11	include()	JROOT/libraries/src/MVC/View/HtmlView.php:416
12	Joomla\CMS\MVC\View\HtmlView->loadTemplate()	JROOT/administrator/components/com_jticketing/views/orders/tmpl/default.php:21
13	include()	JROOT/libraries/src/MVC/View/HtmlView.php:416
14	Joomla\CMS\MVC\View\HtmlView->loadTemplate()	JROOT/libraries/src/MVC/View/HtmlView.php:204
15	Joomla\CMS\MVC\View\HtmlView->display()	JROOT/administrator/components/com_jticketing/views/orders/view.html.php:221
16	JticketingVieworders->display()	JROOT/libraries/src/MVC/Controller/BaseController.php:697
17	Joomla\CMS\MVC\Controller\BaseController->display()	JROOT/administrator/components/com_jticketing/controller.php:59
18	JticketingController->display()	JROOT/libraries/src/MVC/Controller/BaseController.php:730
19	Joomla\CMS\MVC\Controller\BaseController->execute()	JROOT/administrator/components/com_jticketing/jticketing.php:114
20	require_once()	JROOT/libraries/src/Dispatcher/LegacyComponentDispatcher.php:71
21	Joomla\CMS\Dispatcher\LegacyComponentDispatcher::Joomla\CMS\Dispatcher\{closure}()	JROOT/libraries/src/Dispatcher/LegacyComponentDispatcher.php:73
22	Joomla\CMS\Dispatcher\LegacyComponentDispatcher->dispatch()	JROOT/libraries/src/Component/ComponentHelper.php:361
23	Joomla\CMS\Component\ComponentHelper::renderComponent()	JROOT/libraries/src/Application/AdministratorApplication.php:150
24	Joomla\CMS\Application\AdministratorApplication->dispatch()	JROOT/libraries/src/Application/AdministratorApplication.php:205
25	Joomla\CMS\Application\AdministratorApplication->doExecute()	JROOT/libraries/src/Application/CMSApplication.php:320
26	Joomla\CMS\Application\CMSApplication->execute()	JROOT/administrator/includes/app.php:58
27	require_once()	JROOT/administrator/index.php:32

issue:


Fatal error: Access level to ToolbarButtonCsvExport::fetchButton() must be public (as in class Joomla\CMS\Toolbar\ToolbarButton) in /var/www/ttpl-rt-234-php83.local/public/jt_joomla_6/libraries/techjoomla/tjtoolbar/button/csvexport.php on line 68
FatalError
HTTP 500 Whoops, looks like something went wrong.
Compile Error: Access level to ToolbarButtonCsvExport::fetchButton() must be public (as in class Joomla\CMS\Toolbar\ToolbarButton)

issue:

An error has occurred.
0 Call to undefined method stdClass::get()
Call Stack
#	Function	Location
1	()	JROOT/administrator/components/com_jticketing/views/attendeecorefields/view.html.php:82
2	JticketingViewAttendeeCoreFields->addToolbar()	JROOT/administrator/components/com_jticketing/views/attendeecorefields/view.html.php:61
3	JticketingViewAttendeeCoreFields->display()	JROOT/libraries/src/MVC/Controller/BaseController.php:697
4	Joomla\CMS\MVC\Controller\BaseController->display()	JROOT/administrator/components/com_jticketing/controller.php:59
5	JticketingController->display()	JROOT/libraries/src/MVC/Controller/BaseController.php:730
6	Joomla\CMS\MVC\Controller\BaseController->execute()	JROOT/administrator/components/com_jticketing/jticketing.php:114
7	require_once()	JROOT/libraries/src/Dispatcher/LegacyComponentDispatcher.php:71
8	Joomla\CMS\Dispatcher\LegacyComponentDispatcher::Joomla\CMS\Dispatcher\{closure}()	JROOT/libraries/src/Dispatcher/LegacyComponentDispatcher.php:73
9	Joomla\CMS\Dispatcher\LegacyComponentDispatcher->dispatch()	JROOT/libraries/src/Component/ComponentHelper.php:361
10	Joomla\CMS\Component\ComponentHelper::renderComponent()	JROOT/libraries/src/Application/AdministratorApplication.php:150
11	Joomla\CMS\Application\AdministratorApplication->dispatch()	JROOT/libraries/src/Application/AdministratorApplication.php:205
12	Joomla\CMS\Application\AdministratorApplication->doExecute()	JROOT/libraries/src/Application/CMSApplication.php:320
13	Joomla\CMS\Application\CMSApplication->execute()	JROOT/administrator/includes/app.php:58
14	require_once()	JROOT/administrator/index.php:32
