Issues :


An error has occurred.
0 Class "FormFieldText" not found
Call Stack
#	Function	Location
1	()	JROOT/administrator/components/com_jticketing/models/fields/price.php:24
2	require_once()	JROOT/libraries/src/Form/FormHelper.php:271
3	Joomla\CMS\Form\FormHelper::loadClass()	JROOT/libraries/src/Form/FormHelper.php:136
4	Joomla\CMS\Form\FormHelper::loadType()	JROOT/libraries/src/Form/FormHelper.php:78
5	Joomla\CMS\Form\FormHelper::loadFieldType()	JROOT/libraries/src/Form/Form.php:1463
6	Joomla\CMS\Form\Form->loadField()	JROOT/libraries/src/Form/Form.php:446
7	Joomla\CMS\Form\Form->getGroup()	JROOT/layouts/JTsubformlayouts/layouts/bs5/subform/repeatable/section.php:42
8	include()	JROOT/libraries/src/Layout/FileLayout.php:128
9	Joomla\CMS\Layout\FileLayout->render()	JROOT/libraries/src/Layout/FileLayout.php:636
10	Joomla\CMS\Layout\FileLayout->sublayout()	JROOT/layouts/JTsubformlayouts/layouts/bs5/subform/repeatable.php:65
11	include()	JROOT/libraries/src/Layout/FileLayout.php:128
12	Joomla\CMS\Layout\FileLayout->render()	JROOT/libraries/src/Form/Field/SubformField.php:274
13	Joomla\CMS\Form\Field\SubformField->getInput()	JROOT/libraries/src/Form/FormField.php:492
14	Joomla\CMS\Form\FormField->__get()	JROOT/libraries/src/Form/Field/SubformField.php:97
15	Joomla\CMS\Form\Field\SubformField->__get()	JROOT/libraries/src/Form/Form.php:469
16	Joomla\CMS\Form\Form->getInput()	JROOT/administrator/components/com_jticketing/views/event/tmpl/edit_bs5.php:113
17	include()	JROOT/libraries/src/MVC/View/HtmlView.php:416
18	Joomla\CMS\MVC\View\HtmlView->loadTemplate()	JROOT/administrator/components/com_jticketing/views/event/tmpl/edit.php:20
19	include()	JROOT/libraries/src/MVC/View/HtmlView.php:416
20	Joomla\CMS\MVC\View\HtmlView->loadTemplate()	JROOT/libraries/src/MVC/View/HtmlView.php:204
21	Joomla\CMS\MVC\View\HtmlView->display()	JROOT/administrator/components/com_jticketing/views/event/view.html.php:173
22	JTicketingViewEvent->display()	JROOT/libraries/src/MVC/Controller/BaseController.php:697
23	Joomla\CMS\MVC\Controller\BaseController->display()	JROOT/administrator/components/com_jticketing/controller.php:59
24	JticketingController->display()	JROOT/libraries/src/MVC/Controller/BaseController.php:730
25	Joomla\CMS\MVC\Controller\BaseController->execute()	JROOT/administrator/components/com_jticketing/jticketing.php:114
26	require_once()	JROOT/libraries/src/Dispatcher/LegacyComponentDispatcher.php:71
27	Joomla\CMS\Dispatcher\LegacyComponentDispatcher::Joomla\CMS\Dispatcher\{closure}()	JROOT/libraries/src/Dispatcher/LegacyComponentDispatcher.php:73
28	Joomla\CMS\Dispatcher\LegacyComponentDispatcher->dispatch()	JROOT/libraries/src/Component/ComponentHelper.php:361
29	Joomla\CMS\Component\ComponentHelper::renderComponent()	JROOT/libraries/src/Application/AdministratorApplication.php:150
30	Joomla\CMS\Application\AdministratorApplication->dispatch()	JROOT/libraries/src/Application/AdministratorApplication.php:205
31	Joomla\CMS\Application\AdministratorApplication->doExecute()	JROOT/libraries/src/Application/CMSApplication.php:320
32	Joomla\CMS\Application\CMSApplication->execute()	JROOT/administrator/includes/app.php:58
33	require_once()	JROOT/administrator/index.php:32