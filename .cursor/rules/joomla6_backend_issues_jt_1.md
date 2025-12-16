Issue : 

An error has occurred.
0 Class "FormFieldList" not found
Call Stack
#	Function	Location
1	()	JROOT/administrator/components/com_jticketing/models/fields/jtcategories.php:24
2	require_once()	JROOT/libraries/src/Form/FormHelper.php:271
3	Joomla\CMS\Form\FormHelper::loadClass()	JROOT/libraries/src/Form/FormHelper.php:136
4	Joomla\CMS\Form\FormHelper::loadType()	JROOT/libraries/src/Form/FormHelper.php:78
5	Joomla\CMS\Form\FormHelper::loadFieldType()	JROOT/libraries/src/Form/Form.php:1463
6	Joomla\CMS\Form\Form->loadField()	JROOT/libraries/src/Form/Form.php:446
7	Joomla\CMS\Form\Form->getGroup()	JROOT/layouts/joomla/searchtools/default.php:44
8	include()	JROOT/libraries/src/Layout/FileLayout.php:128
9	Joomla\CMS\Layout\FileLayout->render()	JROOT/libraries/src/Layout/LayoutHelper.php:76
10	Joomla\CMS\Layout\LayoutHelper::render()	JROOT/administrator/components/com_jticketing/views/venues/tmpl/default_bs5.php:54
11	include()	JROOT/libraries/src/MVC/View/HtmlView.php:416
12	Joomla\CMS\MVC\View\HtmlView->loadTemplate()	JROOT/administrator/components/com_jticketing/views/venues/tmpl/default.php:19
13	include()	JROOT/libraries/src/MVC/View/HtmlView.php:416
14	Joomla\CMS\MVC\View\HtmlView->loadTemplate()	JROOT/libraries/src/MVC/View/HtmlView.php:204
15	Joomla\CMS\MVC\View\HtmlView->display()	JROOT/administrator/components/com_jticketing/views/venues/view.html.php:66
16	JticketingViewVenues->display()	JROOT/libraries/src/MVC/Controller/BaseController.php:697
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

Issue :

An error has occurred.
0 Class "JHtmlBootstrap" not found
Call Stack
#	Function	Location
1	()	JROOT/administrator/components/com_jticketing/views/attendees/tmpl/default_bs5.php:34
2	include()	JROOT/libraries/src/MVC/View/HtmlView.php:416
3	Joomla\CMS\MVC\View\HtmlView->loadTemplate()	JROOT/administrator/components/com_jticketing/views/attendees/tmpl/default.php:21
4	include()	JROOT/libraries/src/MVC/View/HtmlView.php:416
5	Joomla\CMS\MVC\View\HtmlView->loadTemplate()	JROOT/libraries/src/MVC/View/HtmlView.php:204
6	Joomla\CMS\MVC\View\HtmlView->display()	JROOT/administrator/components/com_jticketing/views/attendees/view.html.php:322
7	JticketingViewAttendees->display()	JROOT/libraries/src/MVC/Controller/BaseController.php:697
8	Joomla\CMS\MVC\Controller\BaseController->display()	JROOT/administrator/components/com_jticketing/controller.php:59
9	JticketingController->display()	JROOT/libraries/src/MVC/Controller/BaseController.php:730
10	Joomla\CMS\MVC\Controller\BaseController->execute()	JROOT/administrator/components/com_jticketing/jticketing.php:114
11	require_once()	JROOT/libraries/src/Dispatcher/LegacyComponentDispatcher.php:71
12	Joomla\CMS\Dispatcher\LegacyComponentDispatcher::Joomla\CMS\Dispatcher\{closure}()	JROOT/libraries/src/Dispatcher/LegacyComponentDispatcher.php:73
13	Joomla\CMS\Dispatcher\LegacyComponentDispatcher->dispatch()	JROOT/libraries/src/Component/ComponentHelper.php:361
14	Joomla\CMS\Component\ComponentHelper::renderComponent()	JROOT/libraries/src/Application/AdministratorApplication.php:150
15	Joomla\CMS\Application\AdministratorApplication->dispatch()	JROOT/libraries/src/Application/AdministratorApplication.php:205
16	Joomla\CMS\Application\AdministratorApplication->doExecute()	JROOT/libraries/src/Application/CMSApplication.php:320
17	Joomla\CMS\Application\CMSApplication->execute()	JROOT/administrator/includes/app.php:58
18	require_once()	JROOT/administrator/index.php:32

Issue : 
An error has occurred.
0 There is no "chosen" asset of a "preset" type in the registry.
Call Stack
#	Function	Location
1	()	JROOT/libraries/src/WebAsset/WebAssetRegistry.php:135
2	Joomla\CMS\WebAsset\WebAssetRegistry->get()	JROOT/libraries/src/WebAsset/WebAssetManager.php:274
3	Joomla\CMS\WebAsset\WebAssetManager->useAsset()	JROOT/libraries/src/WebAsset/WebAssetManager.php:208
4	Joomla\CMS\WebAsset\WebAssetManager->__call()	JROOT/libraries/src/HTML/Helpers/FormBehavior.php:98
5	Joomla\CMS\HTML\Helpers\FormBehavior::chosen()	JROOT/libraries/src/HTML/HTMLHelper.php:307
6	Joomla\CMS\HTML\HTMLHelper::call()	JROOT/libraries/src/HTML/HTMLHelper.php:150
7	Joomla\CMS\HTML\HTMLHelper::_()	JROOT/administrator/components/com_tjcertificate/views/trainingrecord/tmpl/edit.php:30
8	include()	JROOT/libraries/src/MVC/View/HtmlView.php:416
9	Joomla\CMS\MVC\View\HtmlView->loadTemplate()	JROOT/libraries/src/MVC/View/HtmlView.php:204
10	Joomla\CMS\MVC\View\HtmlView->display()	JROOT/administrator/components/com_tjcertificate/views/trainingrecord/view.html.php:99
11	TjCertificateViewTrainingRecord->display()	JROOT/libraries/src/MVC/Controller/BaseController.php:697
12	Joomla\CMS\MVC\Controller\BaseController->display()	JROOT/administrator/components/com_tjcertificate/controller.php:45
13	TjCertificateController->display()	JROOT/libraries/src/MVC/Controller/BaseController.php:730
14	Joomla\CMS\MVC\Controller\BaseController->execute()	JROOT/administrator/components/com_tjcertificate/tjcertificate.php:31
15	require_once()	JROOT/libraries/src/Dispatcher/LegacyComponentDispatcher.php:71
16	Joomla\CMS\Dispatcher\LegacyComponentDispatcher::Joomla\CMS\Dispatcher\{closure}()	JROOT/libraries/src/Dispatcher/LegacyComponentDispatcher.php:73
17	Joomla\CMS\Dispatcher\LegacyComponentDispatcher->dispatch()	JROOT/libraries/src/Component/ComponentHelper.php:361
18	Joomla\CMS\Component\ComponentHelper::renderComponent()	JROOT/libraries/src/Application/AdministratorApplication.php:150
19	Joomla\CMS\Application\AdministratorApplication->dispatch()	JROOT/libraries/src/Application/AdministratorApplication.php:205
20	Joomla\CMS\Application\AdministratorApplication->doExecute()	JROOT/libraries/src/Application/CMSApplication.php:320
21	Joomla\CMS\Application\CMSApplication->execute()	JROOT/administrator/includes/app.php:58
22	require_once()	JROOT/administrator/index.php:32

issue : 

An error has occurred.
0 There is no "chosen" asset of a "preset" type in the registry.
Call Stack
#	Function	Location
1	()	JROOT/libraries/src/WebAsset/WebAssetRegistry.php:135
2	Joomla\CMS\WebAsset\WebAssetRegistry->get()	JROOT/libraries/src/WebAsset/WebAssetManager.php:274
3	Joomla\CMS\WebAsset\WebAssetManager->useAsset()	JROOT/libraries/src/WebAsset/WebAssetManager.php:208
4	Joomla\CMS\WebAsset\WebAssetManager->__call()	JROOT/libraries/src/HTML/Helpers/FormBehavior.php:98
5	Joomla\CMS\HTML\Helpers\FormBehavior::chosen()	JROOT/libraries/src/HTML/HTMLHelper.php:307
6	Joomla\CMS\HTML\HTMLHelper::call()	JROOT/libraries/src/HTML/HTMLHelper.php:150
7	Joomla\CMS\HTML\HTMLHelper::_()	JROOT/administrator/components/com_tjcertificate/views/bulktrainingrecord/tmpl/edit_bs5.php:27
8	include()	JROOT/libraries/src/MVC/View/HtmlView.php:416
9	Joomla\CMS\MVC\View\HtmlView->loadTemplate()	JROOT/administrator/components/com_tjcertificate/views/bulktrainingrecord/tmpl/edit.php:20
10	include()	JROOT/libraries/src/MVC/View/HtmlView.php:416
11	Joomla\CMS\MVC\View\HtmlView->loadTemplate()	JROOT/libraries/src/MVC/View/HtmlView.php:204
12	Joomla\CMS\MVC\View\HtmlView->display()	JROOT/administrator/components/com_tjcertificate/views/bulktrainingrecord/view.html.php:65
13	TjCertificateViewBulkTrainingRecord->display()	JROOT/libraries/src/MVC/Controller/BaseController.php:697
14	Joomla\CMS\MVC\Controller\BaseController->display()	JROOT/administrator/components/com_tjcertificate/controller.php:45
15	TjCertificateController->display()	JROOT/libraries/src/MVC/Controller/BaseController.php:730
16	Joomla\CMS\MVC\Controller\BaseController->execute()	JROOT/administrator/components/com_tjcertificate/tjcertificate.php:31
17	require_once()	JROOT/libraries/src/Dispatcher/LegacyComponentDispatcher.php:71
18	Joomla\CMS\Dispatcher\LegacyComponentDispatcher::Joomla\CMS\Dispatcher\{closure}()	JROOT/libraries/src/Dispatcher/LegacyComponentDispatcher.php:73
19	Joomla\CMS\Dispatcher\LegacyComponentDispatcher->dispatch()	JROOT/libraries/src/Component/ComponentHelper.php:361
20	Joomla\CMS\Component\ComponentHelper::renderComponent()	JROOT/libraries/src/Application/AdministratorApplication.php:150
21	Joomla\CMS\Application\AdministratorApplication->dispatch()	JROOT/libraries/src/Application/AdministratorApplication.php:205
22	Joomla\CMS\Application\AdministratorApplication->doExecute()	JROOT/libraries/src/Application/CMSApplication.php:320
23	Joomla\CMS\Application\CMSApplication->execute()	JROOT/administrator/includes/app.php:58
24	require_once()	JROOT/administrator/index.php:32

issue :

An error has occurred.
0 Call to undefined method JlikeControllerReminder::getInput()
Call Stack
#	Function	Location
1	()	JROOT/administrator/components/com_jlike/controllers/reminder.php:45
2	JlikeControllerReminder->__construct()	JROOT/libraries/src/MVC/Controller/BaseController.php:349
3	Joomla\CMS\MVC\Controller\BaseController::getInstance()	JROOT/administrator/components/com_jlike/jlike.php:76
4	require_once()	JROOT/libraries/src/Dispatcher/LegacyComponentDispatcher.php:71
5	Joomla\CMS\Dispatcher\LegacyComponentDispatcher::Joomla\CMS\Dispatcher\{closure}()	JROOT/libraries/src/Dispatcher/LegacyComponentDispatcher.php:73
6	Joomla\CMS\Dispatcher\LegacyComponentDispatcher->dispatch()	JROOT/libraries/src/Component/ComponentHelper.php:361
7	Joomla\CMS\Component\ComponentHelper::renderComponent()	JROOT/libraries/src/Application/AdministratorApplication.php:150
8	Joomla\CMS\Application\AdministratorApplication->dispatch()	JROOT/libraries/src/Application/AdministratorApplication.php:205
9	Joomla\CMS\Application\AdministratorApplication->doExecute()	JROOT/libraries/src/Application/CMSApplication.php:320
10	Joomla\CMS\Application\CMSApplication->execute()	JROOT/administrator/includes/app.php:58
11	require_once()	JROOT/administrator/index.php:32

Issue :

An error has occurred.
0 Class "FormFieldList" not found
Call Stack
#	Function	Location
1	()	JROOT/administrator/components/com_jticketing/models/fields/vendoreventslist.php:26
2	require_once()	JROOT/libraries/src/Form/FormHelper.php:271
3	Joomla\CMS\Form\FormHelper::loadClass()	JROOT/libraries/src/Form/FormHelper.php:136
4	Joomla\CMS\Form\FormHelper::loadType()	JROOT/libraries/src/Form/FormHelper.php:78
5	Joomla\CMS\Form\FormHelper::loadFieldType()	JROOT/libraries/src/Form/Form.php:1463
6	Joomla\CMS\Form\Form->loadField()	JROOT/libraries/src/Form/Form.php:233
7	Joomla\CMS\Form\Form->getField()	JROOT/libraries/src/Form/Form.php:488
8	Joomla\CMS\Form\Form->getLabel()	JROOT/administrator/components/com_jticketing/views/coupon/tmpl/edit_bs5.php:51
9	include()	JROOT/libraries/src/MVC/View/HtmlView.php:416
10	Joomla\CMS\MVC\View\HtmlView->loadTemplate()	JROOT/administrator/components/com_jticketing/views/coupon/tmpl/edit.php:21
11	include()	JROOT/libraries/src/MVC/View/HtmlView.php:416
12	Joomla\CMS\MVC\View\HtmlView->loadTemplate()	JROOT/libraries/src/MVC/View/HtmlView.php:204
13	Joomla\CMS\MVC\View\HtmlView->display()	JROOT/administrator/components/com_jticketing/views/coupon/view.html.php:88
14	JticketingViewCoupon->display()	JROOT/libraries/src/MVC/Controller/BaseController.php:697
15	Joomla\CMS\MVC\Controller\BaseController->display()	JROOT/administrator/components/com_jticketing/controller.php:59
16	JticketingController->display()	JROOT/libraries/src/MVC/Controller/BaseController.php:730
17	Joomla\CMS\MVC\Controller\BaseController->execute()	JROOT/administrator/components/com_jticketing/jticketing.php:114
18	require_once()	JROOT/libraries/src/Dispatcher/LegacyComponentDispatcher.php:71
19	Joomla\CMS\Dispatcher\LegacyComponentDispatcher::Joomla\CMS\Dispatcher\{closure}()	JROOT/libraries/src/Dispatcher/LegacyComponentDispatcher.php:73
20	Joomla\CMS\Dispatcher\LegacyComponentDispatcher->dispatch()	JROOT/libraries/src/Component/ComponentHelper.php:361
21	Joomla\CMS\Component\ComponentHelper::renderComponent()	JROOT/libraries/src/Application/AdministratorApplication.php:150
22	Joomla\CMS\Application\AdministratorApplication->dispatch()	JROOT/libraries/src/Application/AdministratorApplication.php:205
23	Joomla\CMS\Application\AdministratorApplication->doExecute()	JROOT/libraries/src/Application/CMSApplication.php:320
24	Joomla\CMS\Application\CMSApplication->execute()	JROOT/administrator/includes/app.php:58
25	require_once()	JROOT/administrator/index.php:32

Issue :

An error has occurred.
0 There is no "chosen" asset of a "preset" type in the registry.
Call Stack
#	Function	Location
1	()	JROOT/libraries/src/WebAsset/WebAssetRegistry.php:135
2	Joomla\CMS\WebAsset\WebAssetRegistry->get()	JROOT/libraries/src/WebAsset/WebAssetManager.php:274
3	Joomla\CMS\WebAsset\WebAssetManager->useAsset()	JROOT/libraries/src/WebAsset/WebAssetManager.php:208
4	Joomla\CMS\WebAsset\WebAssetManager->__call()	JROOT/libraries/src/HTML/Helpers/FormBehavior.php:98
5	Joomla\CMS\HTML\Helpers\FormBehavior::chosen()	JROOT/libraries/src/HTML/HTMLHelper.php:307
6	Joomla\CMS\HTML\HTMLHelper::call()	JROOT/libraries/src/HTML/HTMLHelper.php:150
7	Joomla\CMS\HTML\HTMLHelper::_()	JROOT/administrator/components/com_jticketing/views/attendeecorefields/tmpl/default.php:20
8	include()	JROOT/libraries/src/MVC/View/HtmlView.php:416
9	Joomla\CMS\MVC\View\HtmlView->loadTemplate()	JROOT/libraries/src/MVC/View/HtmlView.php:204
10	Joomla\CMS\MVC\View\HtmlView->display()	JROOT/administrator/components/com_jticketing/views/attendeecorefields/view.html.php:64
11	JticketingViewAttendeeCoreFields->display()	JROOT/libraries/src/MVC/Controller/BaseController.php:697
12	Joomla\CMS\MVC\Controller\BaseController->display()	JROOT/administrator/components/com_jticketing/controller.php:59
13	JticketingController->display()	JROOT/libraries/src/MVC/Controller/BaseController.php:730
14	Joomla\CMS\MVC\Controller\BaseController->execute()	JROOT/administrator/components/com_jticketing/jticketing.php:114
15	require_once()	JROOT/libraries/src/Dispatcher/LegacyComponentDispatcher.php:71
16	Joomla\CMS\Dispatcher\LegacyComponentDispatcher::Joomla\CMS\Dispatcher\{closure}()	JROOT/libraries/src/Dispatcher/LegacyComponentDispatcher.php:73
17	Joomla\CMS\Dispatcher\LegacyComponentDispatcher->dispatch()	JROOT/libraries/src/Component/ComponentHelper.php:361
18	Joomla\CMS\Component\ComponentHelper::renderComponent()	JROOT/libraries/src/Application/AdministratorApplication.php:150
19	Joomla\CMS\Application\AdministratorApplication->dispatch()	JROOT/libraries/src/Application/AdministratorApplication.php:205
20	Joomla\CMS\Application\AdministratorApplication->doExecute()	JROOT/libraries/src/Application/CMSApplication.php:320
21	Joomla\CMS\Application\CMSApplication->execute()	JROOT/administrator/includes/app.php:58
22	require_once()	JROOT/administrator/index.php:32