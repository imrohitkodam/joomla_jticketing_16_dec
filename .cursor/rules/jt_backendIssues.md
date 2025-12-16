Issue 1:
An error has occurred.
0 Button not defined for type = CsvExport
Call Stack
#	Function	Location
1	()	JROOT/libraries/src/Toolbar/Toolbar.php:360
2	Joomla\CMS\Toolbar\Toolbar->renderButton()	JROOT/libraries/src/Toolbar/Toolbar.php:327
3	Joomla\CMS\Toolbar\Toolbar->render()	JROOT/administrator/modules/mod_toolbar/src/Dispatcher/Dispatcher.php:37
4	Joomla\Module\Toolbar\Administrator\Dispatcher\Dispatcher->getLayoutData()	JROOT/libraries/src/Dispatcher/AbstractModuleDispatcher.php:63
5	Joomla\CMS\Dispatcher\AbstractModuleDispatcher->dispatch()	JROOT/libraries/src/Helper/ModuleHelper.php:289
6	Joomla\CMS\Helper\ModuleHelper::renderRawModule()	JROOT/libraries/src/Helper/ModuleHelper.php:160
7	Joomla\CMS\Helper\ModuleHelper::renderModule()	JROOT/libraries/src/Document/Renderer/Html/ModuleRenderer.php:99
8	Joomla\CMS\Document\Renderer\Html\ModuleRenderer->render()	JROOT/libraries/src/Document/Renderer/Html/ModulesRenderer.php:51
9	Joomla\CMS\Document\Renderer\Html\ModulesRenderer->render()	JROOT/libraries/src/Document/HtmlDocument.php:575
10	Joomla\CMS\Document\HtmlDocument->getBuffer()	JROOT/libraries/src/Document/HtmlDocument.php:894
11	Joomla\CMS\Document\HtmlDocument->_renderTemplate()	JROOT/libraries/src/Document/HtmlDocument.php:647
12	Joomla\CMS\Document\HtmlDocument->render()	JROOT/libraries/src/Application/CMSApplication.php:1132
13	Joomla\CMS\Application\CMSApplication->render()	JROOT/libraries/src/Application/AdministratorApplication.php:459
14	Joomla\CMS\Application\AdministratorApplication->render()	JROOT/libraries/src/Application/CMSApplication.php:325
15	Joomla\CMS\Application\CMSApplication->execute()	JROOT/administrator/includes/app.php:58
16	require_once()	JROOT/administrator/index.php:32


issue 2 :

An error has occurred.
0 Class "JHtmlSidebar" not found
Call Stack
#	Function	Location
1	()	JROOT/administrator/components/com_jticketing/views/cp/view.html.php:126
2	JticketingViewcp->display()	JROOT/libraries/src/MVC/Controller/BaseController.php:697
3	Joomla\CMS\MVC\Controller\BaseController->display()	JROOT/administrator/components/com_jticketing/controller.php:59
4	JticketingController->display()	JROOT/libraries/src/MVC/Controller/BaseController.php:730
5	Joomla\CMS\MVC\Controller\BaseController->execute()	JROOT/administrator/components/com_jticketing/jticketing.php:113
6	require_once()	JROOT/libraries/src/Dispatcher/LegacyComponentDispatcher.php:71
7	Joomla\CMS\Dispatcher\LegacyComponentDispatcher::Joomla\CMS\Dispatcher\{closure}()	JROOT/libraries/src/Dispatcher/LegacyComponentDispatcher.php:73
8	Joomla\CMS\Dispatcher\LegacyComponentDispatcher->dispatch()	JROOT/libraries/src/Component/ComponentHelper.php:361
9	Joomla\CMS\Component\ComponentHelper::renderComponent()	JROOT/libraries/src/Application/AdministratorApplication.php:150
10	Joomla\CMS\Application\AdministratorApplication->dispatch()	JROOT/libraries/src/Application/AdministratorApplication.php:205
11	Joomla\CMS\Application\AdministratorApplication->doExecute()	JROOT/libraries/src/Application/CMSApplication.php:320
12	Joomla\CMS\Application\CMSApplication->execute()	JROOT/administrator/includes/app.php:58
13	require_once()	


issue3 :

An error has occurred.
0 Class "JHtmlSidebar" not found
Call Stack
#	Function	Location
1	()	JROOT/administrator/components/com_jticketing/views/venues/view.html.php:65
2	JticketingViewVenues->display()	JROOT/libraries/src/MVC/Controller/BaseController.php:697
3	Joomla\CMS\MVC\Controller\BaseController->display()	JROOT/administrator/components/com_jticketing/controller.php:59
4	JticketingController->display()	JROOT/libraries/src/MVC/Controller/BaseController.php:730
5	Joomla\CMS\MVC\Controller\BaseController->execute()	JROOT/administrator/components/com_jticketing/jticketing.php:113
6	require_once()	JROOT/libraries/src/Dispatcher/LegacyComponentDispatcher.php:71
7	Joomla\CMS\Dispatcher\LegacyComponentDispatcher::Joomla\CMS\Dispatcher\{closure}()	JROOT/libraries/src/Dispatcher/LegacyComponentDispatcher.php:73
8	Joomla\CMS\Dispatcher\LegacyComponentDispatcher->dispatch()	JROOT/libraries/src/Component/ComponentHelper.php:361
9	Joomla\CMS\Component\ComponentHelper::renderComponent()	JROOT/libraries/src/Application/AdministratorApplication.php:150
10	Joomla\CMS\Application\AdministratorApplication->dispatch()	JROOT/libraries/src/Application/AdministratorApplication.php:205
11	Joomla\CMS\Application\AdministratorApplication->doExecute()	JROOT/libraries/src/Application/CMSApplication.php:320
12	Joomla\CMS\Application\CMSApplication->execute()	JROOT/administrator/includes/app.php:58
13	require_once()	JROOT/administrator/index.php:32

Issue 4 :

An error has occurred.
0 Joomla\Database\DatabaseQuery::bind(): Argument #2 ($value) could not be passed by reference
Call Stack
#	Function	Location
1	()	JROOT/administrator/components/com_jticketing/models/events.php:175
2	JticketingModelEvents->getListQuery()	JROOT/libraries/src/MVC/Model/ListModel.php:186
3	Joomla\CMS\MVC\Model\ListModel->_getListQuery()	JROOT/libraries/src/MVC/Model/ListModel.php:235
4	Joomla\CMS\MVC\Model\ListModel->getItems()	JROOT/administrator/components/com_jticketing/models/events.php:298
5	JticketingModelEvents->getItems()	JROOT/libraries/src/MVC/View/AbstractView.php:171
6	Joomla\CMS\MVC\View\AbstractView->get()	JROOT/administrator/components/com_jticketing/views/events/view.html.php:58
7	JticketingViewEvents->display()	JROOT/libraries/src/MVC/Controller/BaseController.php:697
8	Joomla\CMS\MVC\Controller\BaseController->display()	JROOT/administrator/components/com_jticketing/controller.php:59
9	JticketingController->display()	JROOT/libraries/src/MVC/Controller/BaseController.php:730
10	Joomla\CMS\MVC\Controller\BaseController->execute()	JROOT/administrator/components/com_jticketing/jticketing.php:113
11	require_once()	JROOT/libraries/src/Dispatcher/LegacyComponentDispatcher.php:71
12	Joomla\CMS\Dispatcher\LegacyComponentDispatcher::Joomla\CMS\Dispatcher\{closure}()	JROOT/libraries/src/Dispatcher/LegacyComponentDispatcher.php:73
13	Joomla\CMS\Dispatcher\LegacyComponentDispatcher->dispatch()	JROOT/libraries/src/Component/ComponentHelper.php:361
14	Joomla\CMS\Component\ComponentHelper::renderComponent()	JROOT/libraries/src/Application/AdministratorApplication.php:150
15	Joomla\CMS\Application\AdministratorApplication->dispatch()	JROOT/libraries/src/Application/AdministratorApplication.php:205
16	Joomla\CMS\Application\AdministratorApplication->doExecute()	JROOT/libraries/src/Application/CMSApplication.php:320
17	Joomla\CMS\Application\CMSApplication->execute()	JROOT/administrator/includes/app.php:58
18	require_once()	JROOT/administrator/index.php:32

Issue 5:
An error has occurred.
0 Class "JToolBar" not found
Call Stack
#	Function	Location
1	()	JROOT/administrator/components/com_jticketing/views/catimpexp/view.html.php:102
2	JticketingViewCatimpexp->addToolbar()	JROOT/administrator/components/com_jticketing/views/catimpexp/view.html.php:72
3	JticketingViewCatimpexp->display()	JROOT/libraries/src/MVC/Controller/BaseController.php:697
4	Joomla\CMS\MVC\Controller\BaseController->display()	JROOT/administrator/components/com_jticketing/controller.php:59
5	JticketingController->display()	JROOT/libraries/src/MVC/Controller/BaseController.php:730
6	Joomla\CMS\MVC\Controller\BaseController->execute()	JROOT/administrator/components/com_jticketing/jticketing.php:113
7	require_once()	JROOT/libraries/src/Dispatcher/LegacyComponentDispatcher.php:71
8	Joomla\CMS\Dispatcher\LegacyComponentDispatcher::Joomla\CMS\Dispatcher\{closure}()	JROOT/libraries/src/Dispatcher/LegacyComponentDispatcher.php:73
9	Joomla\CMS\Dispatcher\LegacyComponentDispatcher->dispatch()	JROOT/libraries/src/Component/ComponentHelper.php:361
10	Joomla\CMS\Component\ComponentHelper::renderComponent()	JROOT/libraries/src/Application/AdministratorApplication.php:150
11	Joomla\CMS\Application\AdministratorApplication->dispatch()	JROOT/libraries/src/Application/AdministratorApplication.php:205
12	Joomla\CMS\Application\AdministratorApplication->doExecute()	JROOT/libraries/src/Application/CMSApplication.php:320
13	Joomla\CMS\Application\CMSApplication->execute()	JROOT/administrator/includes/app.php:58
14	require_once()	JROOT/administrator/index.php:32

Issue 7:

An error has occurred.
0 Class "JToolBar" not found
Call Stack
#	Function	Location
1	()	JROOT/administrator/components/com_jticketing/views/allticketsales/view.html.php:191
2	JticketingViewallticketsales->setToolBar()	JROOT/administrator/components/com_jticketing/views/allticketsales/view.html.php:169
3	JticketingViewallticketsales->display()	JROOT/libraries/src/MVC/Controller/BaseController.php:697
4	Joomla\CMS\MVC\Controller\BaseController->display()	JROOT/administrator/components/com_jticketing/controller.php:59
5	JticketingController->display()	JROOT/libraries/src/MVC/Controller/BaseController.php:730
6	Joomla\CMS\MVC\Controller\BaseController->execute()	JROOT/administrator/components/com_jticketing/jticketing.php:113
7	require_once()	JROOT/libraries/src/Dispatcher/LegacyComponentDispatcher.php:71
8	Joomla\CMS\Dispatcher\LegacyComponentDispatcher::Joomla\CMS\Dispatcher\{closure}()	JROOT/libraries/src/Dispatcher/LegacyComponentDispatcher.php:73
9	Joomla\CMS\Dispatcher\LegacyComponentDispatcher->dispatch()	JROOT/libraries/src/Component/ComponentHelper.php:361
10	Joomla\CMS\Component\ComponentHelper::renderComponent()	JROOT/libraries/src/Application/AdministratorApplication.php:150
11	Joomla\CMS\Application\AdministratorApplication->dispatch()	JROOT/libraries/src/Application/AdministratorApplication.php:205
12	Joomla\CMS\Application\AdministratorApplication->doExecute()	JROOT/libraries/src/Application/CMSApplication.php:320
13	Joomla\CMS\Application\CMSApplication->execute()	JROOT/administrator/includes/app.php:58
14	require_once()	JROOT/administrator/index.php:32

Issue :

An error has occurred.
0 Class "JHtmlSidebar" not found
Call Stack
#	Function	Location
1	()	JROOT/administrator/components/com_jticketing/views/orders/view.html.php:217
2	JticketingVieworders->display()	JROOT/libraries/src/MVC/Controller/BaseController.php:697
3	Joomla\CMS\MVC\Controller\BaseController->display()	JROOT/administrator/components/com_jticketing/controller.php:59
4	JticketingController->display()	JROOT/libraries/src/MVC/Controller/BaseController.php:730
5	Joomla\CMS\MVC\Controller\BaseController->execute()	JROOT/administrator/components/com_jticketing/jticketing.php:113
6	require_once()	JROOT/libraries/src/Dispatcher/LegacyComponentDispatcher.php:71
7	Joomla\CMS\Dispatcher\LegacyComponentDispatcher::Joomla\CMS\Dispatcher\{closure}()	JROOT/libraries/src/Dispatcher/LegacyComponentDispatcher.php:73
8	Joomla\CMS\Dispatcher\LegacyComponentDispatcher->dispatch()	JROOT/libraries/src/Component/ComponentHelper.php:361
9	Joomla\CMS\Component\ComponentHelper::renderComponent()	JROOT/libraries/src/Application/AdministratorApplication.php:150
10	Joomla\CMS\Application\AdministratorApplication->dispatch()	JROOT/libraries/src/Application/AdministratorApplication.php:205
11	Joomla\CMS\Application\AdministratorApplication->doExecute()	JROOT/libraries/src/Application/CMSApplication.php:320
12	Joomla\CMS\Application\CMSApplication->execute()	JROOT/administrator/includes/app.php:58
13	require_once()	JROOT/administrator/index.php:32

issue :
An error has occurred.
0 Class "JHtmlSelect" not found
Call Stack
#	Function	Location
1	()	JROOT/administrator/components/com_jticketing/views/enrollment/tmpl/attendeemove.php:41
2	include()	JROOT/libraries/src/Layout/FileLayout.php:128
3	Joomla\CMS\Layout\FileLayout->render()	JROOT/libraries/src/Layout/LayoutHelper.php:76
4	Joomla\CMS\Layout\LayoutHelper::render()	JROOT/administrator/components/com_jticketing/views/attendees/view.html.php:291
5	JticketingViewAttendees->display()	JROOT/libraries/src/MVC/Controller/BaseController.php:697
6	Joomla\CMS\MVC\Controller\BaseController->display()	JROOT/administrator/components/com_jticketing/controller.php:59
7	JticketingController->display()	JROOT/libraries/src/MVC/Controller/BaseController.php:730
8	Joomla\CMS\MVC\Controller\BaseController->execute()	JROOT/administrator/components/com_jticketing/jticketing.php:113
9	require_once()	JROOT/libraries/src/Dispatcher/LegacyComponentDispatcher.php:71
10	Joomla\CMS\Dispatcher\LegacyComponentDispatcher::Joomla\CMS\Dispatcher\{closure}()	JROOT/libraries/src/Dispatcher/LegacyComponentDispatcher.php:73
11	Joomla\CMS\Dispatcher\LegacyComponentDispatcher->dispatch()	JROOT/libraries/src/Component/ComponentHelper.php:361
12	Joomla\CMS\Component\ComponentHelper::renderComponent()	JROOT/libraries/src/Application/AdministratorApplication.php:150
13	Joomla\CMS\Application\AdministratorApplication->dispatch()	JROOT/libraries/src/Application/AdministratorApplication.php:205
14	Joomla\CMS\Application\AdministratorApplication->doExecute()	JROOT/libraries/src/Application/CMSApplication.php:320
15	Joomla\CMS\Application\CMSApplication->execute()	JROOT/administrator/includes/app.php:58
16	require_once()	JROOT/administrator/index.php:32

Issue :
An error has occurred.
0 Class "JHtmlSidebar" not found
Call Stack
#	Function	Location
1	()	JROOT/administrator/components/com_jticketing/views/waitinglist/view.html.php:74
2	JTicketingViewWaitinglist->display()	JROOT/libraries/src/MVC/Controller/BaseController.php:697
3	Joomla\CMS\MVC\Controller\BaseController->display()	JROOT/administrator/components/com_jticketing/controller.php:59
4	JticketingController->display()	JROOT/libraries/src/MVC/Controller/BaseController.php:730
5	Joomla\CMS\MVC\Controller\BaseController->execute()	JROOT/administrator/components/com_jticketing/jticketing.php:113
6	require_once()	JROOT/libraries/src/Dispatcher/LegacyComponentDispatcher.php:71
7	Joomla\CMS\Dispatcher\LegacyComponentDispatcher::Joomla\CMS\Dispatcher\{closure}()	JROOT/libraries/src/Dispatcher/LegacyComponentDispatcher.php:73
8	Joomla\CMS\Dispatcher\LegacyComponentDispatcher->dispatch()	JROOT/libraries/src/Component/ComponentHelper.php:361
9	Joomla\CMS\Component\ComponentHelper::renderComponent()	JROOT/libraries/src/Application/AdministratorApplication.php:150
10	Joomla\CMS\Application\AdministratorApplication->dispatch()	JROOT/libraries/src/Application/AdministratorApplication.php:205
11	Joomla\CMS\Application\AdministratorApplication->doExecute()	JROOT/libraries/src/Application/CMSApplication.php:320
12	Joomla\CMS\Application\CMSApplication->execute()	JROOT/administrator/includes/app.php:58
13	require_once()	JROOT/administrator/index.php:32

issue :

An error has occurred.
0 Class "JHtmlSidebar" not found
Call Stack
#	Function	Location
1	()	JROOT/administrator/components/com_jticketing/views/email_config/view.html.php:46
2	jticketingViewemail_config->display()	JROOT/libraries/src/MVC/Controller/BaseController.php:697
3	Joomla\CMS\MVC\Controller\BaseController->display()	JROOT/administrator/components/com_jticketing/controller.php:59
4	JticketingController->display()	JROOT/libraries/src/MVC/Controller/BaseController.php:730
5	Joomla\CMS\MVC\Controller\BaseController->execute()	JROOT/administrator/components/com_jticketing/jticketing.php:113
6	require_once()	JROOT/libraries/src/Dispatcher/LegacyComponentDispatcher.php:71
7	Joomla\CMS\Dispatcher\LegacyComponentDispatcher::Joomla\CMS\Dispatcher\{closure}()	JROOT/libraries/src/Dispatcher/LegacyComponentDispatcher.php:73
8	Joomla\CMS\Dispatcher\LegacyComponentDispatcher->dispatch()	JROOT/libraries/src/Component/ComponentHelper.php:361
9	Joomla\CMS\Component\ComponentHelper::renderComponent()	JROOT/libraries/src/Application/AdministratorApplication.php:150
10	Joomla\CMS\Application\AdministratorApplication->dispatch()	JROOT/libraries/src/Application/AdministratorApplication.php:205
11	Joomla\CMS\Application\AdministratorApplication->doExecute()	JROOT/libraries/src/Application/CMSApplication.php:320
12	Joomla\CMS\Application\CMSApplication->execute()	JROOT/administrator/includes/app.php:58
13	require_once()	JROOT/administrator/index.php:32


issue :

An error has occurred.
0 Class "JHtmlSidebar" not found
Call Stack
#	Function	Location
1	()	JROOT/administrator/components/com_jticketing/views/pdftemplates/view.html.php:223
2	JticketingViewPDFTemplates->addToolbar()	JROOT/administrator/components/com_jticketing/views/pdftemplates/view.html.php:172
3	JticketingViewPDFTemplates->display()	JROOT/libraries/src/MVC/Controller/BaseController.php:697
4	Joomla\CMS\MVC\Controller\BaseController->display()	JROOT/administrator/components/com_jticketing/controller.php:59
5	JticketingController->display()	JROOT/libraries/src/MVC/Controller/BaseController.php:730
6	Joomla\CMS\MVC\Controller\BaseController->execute()	JROOT/administrator/components/com_jticketing/jticketing.php:113
7	require_once()	JROOT/libraries/src/Dispatcher/LegacyComponentDispatcher.php:71
8	Joomla\CMS\Dispatcher\LegacyComponentDispatcher::Joomla\CMS\Dispatcher\{closure}()	JROOT/libraries/src/Dispatcher/LegacyComponentDispatcher.php:73
9	Joomla\CMS\Dispatcher\LegacyComponentDispatcher->dispatch()	JROOT/libraries/src/Component/ComponentHelper.php:361
10	Joomla\CMS\Component\ComponentHelper::renderComponent()	JROOT/libraries/src/Application/AdministratorApplication.php:150
11	Joomla\CMS\Application\AdministratorApplication->dispatch()	JROOT/libraries/src/Application/AdministratorApplication.php:205
12	Joomla\CMS\Application\AdministratorApplication->doExecute()	JROOT/libraries/src/Application/CMSApplication.php:320
13	Joomla\CMS\Application\CMSApplication->execute()	JROOT/administrator/includes/app.php:58
14	require_once()	JROOT/administrator/index.php:32


issue :

An error has occurred.
0 Class "JHtmlSidebar" not found
Call Stack
#	Function	Location
1	()	JROOT/administrator/components/com_jticketing/views/coupons/view.html.php:237
2	JticketingViewCoupons->addToolbar()	JROOT/administrator/components/com_jticketing/views/coupons/view.html.php:181
3	JticketingViewCoupons->display()	JROOT/libraries/src/MVC/Controller/BaseController.php:697
4	Joomla\CMS\MVC\Controller\BaseController->display()	JROOT/administrator/components/com_jticketing/controller.php:59
5	JticketingController->display()	JROOT/libraries/src/MVC/Controller/BaseController.php:730
6	Joomla\CMS\MVC\Controller\BaseController->execute()	JROOT/administrator/components/com_jticketing/jticketing.php:113
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
0 Class "JHtmlSidebar" not found
Call Stack
#	Function	Location
1	()	JROOT/administrator/components/com_jticketing/views/attendeecorefields/view.html.php:98
2	JticketingViewAttendeeCoreFields->addToolbar()	JROOT/administrator/components/com_jticketing/views/attendeecorefields/view.html.php:61
3	JticketingViewAttendeeCoreFields->display()	JROOT/libraries/src/MVC/Controller/BaseController.php:697
4	Joomla\CMS\MVC\Controller\BaseController->display()	JROOT/administrator/components/com_jticketing/controller.php:59
5	JticketingController->display()	JROOT/libraries/src/MVC/Controller/BaseController.php:730
6	Joomla\CMS\MVC\Controller\BaseController->execute()	JROOT/administrator/components/com_jticketing/jticketing.php:113
7	require_once()	JROOT/libraries/src/Dispatcher/LegacyComponentDispatcher.php:71
8	Joomla\CMS\Dispatcher\LegacyComponentDispatcher::Joomla\CMS\Dispatcher\{closure}()	JROOT/libraries/src/Dispatcher/LegacyComponentDispatcher.php:73
9	Joomla\CMS\Dispatcher\LegacyComponentDispatcher->dispatch()	JROOT/libraries/src/Component/ComponentHelper.php:361
10	Joomla\CMS\Component\ComponentHelper::renderComponent()	JROOT/libraries/src/Application/AdministratorApplication.php:150
11	Joomla\CMS\Application\AdministratorApplication->dispatch()	JROOT/libraries/src/Application/AdministratorApplication.php:205
12	Joomla\CMS\Application\AdministratorApplication->doExecute()	JROOT/libraries/src/Application/CMSApplication.php:320
13	Joomla\CMS\Application\CMSApplication->execute()	JROOT/administrator/includes/app.php:58
14	require_once()	JROOT/administrator/index.php:32


issue :

