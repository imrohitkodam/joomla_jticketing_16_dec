Issue 1: 
An error has occurred.
0 Class "JModelLegacy" not found
Call Stack
#	Function	Location
1	()	JROOT/components/com_jgive/models/campaignform.php:49
2	require_once()	JROOT/administrator/components/com_jgive/models/campaign.php:20
3	require_once()	JROOT/administrator/components/com_jgive/controllers/campaigns.php:25
4	require_once()	JROOT/libraries/src/MVC/Controller/BaseController.php:332
5	Joomla\CMS\MVC\Controller\BaseController::getInstance()	JROOT/administrator/components/com_jgive/jgive.php:125
6	require_once()	JROOT/libraries/src/Dispatcher/LegacyComponentDispatcher.php:71
7	Joomla\CMS\Dispatcher\LegacyComponentDispatcher::Joomla\CMS\Dispatcher\{closure}()	JROOT/libraries/src/Dispatcher/LegacyComponentDispatcher.php:73
8	Joomla\CMS\Dispatcher\LegacyComponentDispatcher->dispatch()	JROOT/libraries/src/Component/ComponentHelper.php:361
9	Joomla\CMS\Component\ComponentHelper::renderComponent()	JROOT/libraries/src/Application/AdministratorApplication.php:150
10	Joomla\CMS\Application\AdministratorApplication->dispatch()	JROOT/libraries/src/Application/AdministratorApplication.php:205
11	Joomla\CMS\Application\AdministratorApplication->doExecute()	JROOT/libraries/src/Application/CMSApplication.php:320
12	Joomla\CMS\Application\CMSApplication->execute()	JROOT/administrator/includes/app.php:58
13	require_once()	JROOT/administrator/index.php:32

On this location : http://ttpl-rt-234-php83.local/joomla_62/administrator/index.php?option=com_jgive&view=campaigns&layout=


Issue 2: 
An error has occurred.
0 Class "Toolbar" not found
Call Stack
#	Function	Location
1	()	JROOT/administrator/components/com_jgive/views/donors/view.html.php:104
2	JGiveViewDonors->addToolbar()	JROOT/administrator/components/com_jgive/views/donors/view.html.php:87
3	JGiveViewDonors->display()	JROOT/libraries/src/MVC/Controller/BaseController.php:697
4	Joomla\CMS\MVC\Controller\BaseController->display()	JROOT/administrator/components/com_jgive/controller.php:45
5	JGiveController->display()	JROOT/libraries/src/MVC/Controller/BaseController.php:730
6	Joomla\CMS\MVC\Controller\BaseController->execute()	JROOT/administrator/components/com_jgive/jgive.php:126
7	require_once()	JROOT/libraries/src/Dispatcher/LegacyComponentDispatcher.php:71
8	Joomla\CMS\Dispatcher\LegacyComponentDispatcher::Joomla\CMS\Dispatcher\{closure}()	JROOT/libraries/src/Dispatcher/LegacyComponentDispatcher.php:73
9	Joomla\CMS\Dispatcher\LegacyComponentDispatcher->dispatch()	JROOT/libraries/src/Component/ComponentHelper.php:361
10	Joomla\CMS\Component\ComponentHelper::renderComponent()	JROOT/libraries/src/Application/AdministratorApplication.php:150
11	Joomla\CMS\Application\AdministratorApplication->dispatch()	JROOT/libraries/src/Application/AdministratorApplication.php:205
12	Joomla\CMS\Application\AdministratorApplication->doExecute()	JROOT/libraries/src/Application/CMSApplication.php:320
13	Joomla\CMS\Application\CMSApplication->execute()	JROOT/administrator/includes/app.php:58
14	require_once()	JROOT/administrator/index.php:32

On this location : http://ttpl-rt-234-php83.local/joomla_62/administrator/index.php?option=com_jgive&view=donors

Issue 3: 

An error has occurred.
0 Class "ToolbarHelper" not found
Call Stack
#	Function	Location
1	()	JROOT/administrator/components/com_tjfields/views/fields/view.html.php:107
2	TjfieldsViewFields->addToolbar()	JROOT/administrator/components/com_tjfields/views/fields/view.html.php:56
3	TjfieldsViewFields->display()	JROOT/libraries/src/MVC/Controller/BaseController.php:697
4	Joomla\CMS\MVC\Controller\BaseController->display()	JROOT/administrator/components/com_tjfields/controller.php:62
5	TjfieldsController->display()	JROOT/libraries/src/MVC/Controller/BaseController.php:730
6	Joomla\CMS\MVC\Controller\BaseController->execute()	JROOT/administrator/components/com_tjfields/tjfields.php:80
7	require_once()	JROOT/libraries/src/Dispatcher/LegacyComponentDispatcher.php:71
8	Joomla\CMS\Dispatcher\LegacyComponentDispatcher::Joomla\CMS\Dispatcher\{closure}()	JROOT/libraries/src/Dispatcher/LegacyComponentDispatcher.php:73
9	Joomla\CMS\Dispatcher\LegacyComponentDispatcher->dispatch()	JROOT/libraries/src/Component/ComponentHelper.php:361
10	Joomla\CMS\Component\ComponentHelper::renderComponent()	JROOT/libraries/src/Application/AdministratorApplication.php:150
11	Joomla\CMS\Application\AdministratorApplication->dispatch()	JROOT/libraries/src/Application/AdministratorApplication.php:205
12	Joomla\CMS\Application\AdministratorApplication->doExecute()	JROOT/libraries/src/Application/CMSApplication.php:320
13	Joomla\CMS\Application\CMSApplication->execute()	JROOT/administrator/includes/app.php:58
14	require_once()	JROOT/administrator/index.php:32

On this location : http://ttpl-rt-234-php83.local/joomla_62/administrator/index.php?option=com_tjfields&view=fields&client=com_jgive.campaign

Issue 4: 

An error has occurred.
0 Class "ToolbarHelper" not found
Call Stack
#	Function	Location
1	()	JROOT/administrator/components/com_tjfields/views/groups/view.html.php:112
2	TjfieldsViewGroups->addToolbar()	JROOT/administrator/components/com_tjfields/views/groups/view.html.php:56
3	TjfieldsViewGroups->display()	JROOT/libraries/src/MVC/Controller/BaseController.php:697
4	Joomla\CMS\MVC\Controller\BaseController->display()	JROOT/administrator/components/com_tjfields/controller.php:62
5	TjfieldsController->display()	JROOT/libraries/src/MVC/Controller/BaseController.php:730
6	Joomla\CMS\MVC\Controller\BaseController->execute()	JROOT/administrator/components/com_tjfields/tjfields.php:80
7	require_once()	JROOT/libraries/src/Dispatcher/LegacyComponentDispatcher.php:71
8	Joomla\CMS\Dispatcher\LegacyComponentDispatcher::Joomla\CMS\Dispatcher\{closure}()	JROOT/libraries/src/Dispatcher/LegacyComponentDispatcher.php:73
9	Joomla\CMS\Dispatcher\LegacyComponentDispatcher->dispatch()	JROOT/libraries/src/Component/ComponentHelper.php:361
10	Joomla\CMS\Component\ComponentHelper::renderComponent()	JROOT/libraries/src/Application/AdministratorApplication.php:150
11	Joomla\CMS\Application\AdministratorApplication->dispatch()	JROOT/libraries/src/Application/AdministratorApplication.php:205
12	Joomla\CMS\Application\AdministratorApplication->doExecute()	JROOT/libraries/src/Application/CMSApplication.php:320
13	Joomla\CMS\Application\CMSApplication->execute()	JROOT/administrator/includes/app.php:58
14	require_once()	JROOT/administrator/index.php:32

On this location : http://ttpl-rt-234-php83.local/joomla_62/administrator/index.php?option=com_tjfields&view=groups&client=com_jgive.campaign

Issue 5: 
An error has occurred.
0 Class "HTMLHelperSidebar" not found
Call Stack
#	Function	Location
1	()	JROOT/administrator/components/com_tjfields/views/countries/view.html.php:154
2	TjfieldsViewCountries->addToolbar()	JROOT/administrator/components/com_tjfields/views/countries/view.html.php:68
3	TjfieldsViewCountries->display()	JROOT/libraries/src/MVC/Controller/BaseController.php:697
4	Joomla\CMS\MVC\Controller\BaseController->display()	JROOT/administrator/components/com_tjfields/controller.php:62
5	TjfieldsController->display()	JROOT/libraries/src/MVC/Controller/BaseController.php:730
6	Joomla\CMS\MVC\Controller\BaseController->execute()	JROOT/administrator/components/com_tjfields/tjfields.php:80
7	require_once()	JROOT/libraries/src/Dispatcher/LegacyComponentDispatcher.php:71
8	Joomla\CMS\Dispatcher\LegacyComponentDispatcher::Joomla\CMS\Dispatcher\{closure}()	JROOT/libraries/src/Dispatcher/LegacyComponentDispatcher.php:73
9	Joomla\CMS\Dispatcher\LegacyComponentDispatcher->dispatch()	JROOT/libraries/src/Component/ComponentHelper.php:361
10	Joomla\CMS\Component\ComponentHelper::renderComponent()	JROOT/libraries/src/Application/AdministratorApplication.php:150
11	Joomla\CMS\Application\AdministratorApplication->dispatch()	JROOT/libraries/src/Application/AdministratorApplication.php:205
12	Joomla\CMS\Application\AdministratorApplication->doExecute()	JROOT/libraries/src/Application/CMSApplication.php:320
13	Joomla\CMS\Application\CMSApplication->execute()	JROOT/administrator/includes/app.php:58
14	require_once()	JROOT/administrator/index.php:32

On this location : http://ttpl-rt-234-php83.local/joomla_62/administrator/index.php?option=com_tjfields&view=countries&client=com_jgive

On this location : http://ttpl-rt-234-php83.local/joomla_62/administrator/index.php?option=com_tjfields&view=regions&client=com_jgive

On this location : http://ttpl-rt-234-php83.local/joomla_62/administrator/index.php?option=com_tjfields&view=cities&client=com_jgive


Issue 1:

An error has occurred.
0 Class "JFormField" not found
Call Stack
#	Function	Location
1	()	JROOT/administrator/components/com_jgive/models/fields/amount.php:24
2	require_once()	JROOT/libraries/src/Form/FormHelper.php:271
3	Joomla\CMS\Form\FormHelper::loadClass()	JROOT/libraries/src/Form/FormHelper.php:136
4	Joomla\CMS\Form\FormHelper::loadType()	JROOT/libraries/src/Form/FormHelper.php:78
5	Joomla\CMS\Form\FormHelper::loadFieldType()	JROOT/libraries/src/Form/Form.php:1463
6	Joomla\CMS\Form\Form->loadField()	JROOT/libraries/src/Form/Form.php:233
7	Joomla\CMS\Form\Form->getField()	JROOT/libraries/src/Form/Form.php:544
8	Joomla\CMS\Form\Form->renderField()	JROOT/administrator/components/com_jgive/views/campaign/tmpl/edit_details_bs5.php:156
9	include()	JROOT/libraries/src/MVC/View/HtmlView.php:416
10	Joomla\CMS\MVC\View\HtmlView->loadTemplate()	JROOT/administrator/components/com_jgive/views/campaign/tmpl/edit_bs5.php:47
11	include()	JROOT/libraries/src/MVC/View/HtmlView.php:416
12	Joomla\CMS\MVC\View\HtmlView->loadTemplate()	JROOT/administrator/components/com_jgive/views/campaign/tmpl/edit.php:20
13	include()	JROOT/libraries/src/MVC/View/HtmlView.php:416
14	Joomla\CMS\MVC\View\HtmlView->loadTemplate()	JROOT/libraries/src/MVC/View/HtmlView.php:204
15	Joomla\CMS\MVC\View\HtmlView->display()	JROOT/administrator/components/com_jgive/views/campaign/view.html.php:144
16	JGiveViewCampaign->display()	JROOT/libraries/src/MVC/Controller/BaseController.php:697
17	Joomla\CMS\MVC\Controller\BaseController->display()	JROOT/administrator/components/com_jgive/controller.php:45
18	JGiveController->display()	JROOT/libraries/src/MVC/Controller/BaseController.php:730
19	Joomla\CMS\MVC\Controller\BaseController->execute()	JROOT/administrator/components/com_jgive/jgive.php:126
20	require_once()	JROOT/libraries/src/Dispatcher/LegacyComponentDispatcher.php:71
21	Joomla\CMS\Dispatcher\LegacyComponentDispatcher::Joomla\CMS\Dispatcher\{closure}()	JROOT/libraries/src/Dispatcher/LegacyComponentDispatcher.php:73
22	Joomla\CMS\Dispatcher\LegacyComponentDispatcher->dispatch()	JROOT/libraries/src/Component/ComponentHelper.php:361
23	Joomla\CMS\Component\ComponentHelper::renderComponent()	JROOT/libraries/src/Application/AdministratorApplication.php:150
24	Joomla\CMS\Application\AdministratorApplication->dispatch()	JROOT/libraries/src/Application/AdministratorApplication.php:205
25	Joomla\CMS\Application\AdministratorApplication->doExecute()	JROOT/libraries/src/Application/CMSApplication.php:320
26	Joomla\CMS\Application\CMSApplication->execute()	JROOT/administrator/includes/app.php:58
27	require_once()	JROOT/administrator/index.php:32

Referance link : http://ttpl-rt-234-php83.local/joomla_62/administrator/index.php?option=com_jgive&view=campaign&layout=edit

Issue 2: 

An error has occurred.
0 Class "HTMLHelperSidebar" not found
Call Stack
#	Function	Location
1	()	JROOT/administrator/components/com_jgive/views/donors/view.html.php:132
2	JGiveViewDonors->addToolbar()	JROOT/administrator/components/com_jgive/views/donors/view.html.php:88
3	JGiveViewDonors->display()	JROOT/libraries/src/MVC/Controller/BaseController.php:697
4	Joomla\CMS\MVC\Controller\BaseController->display()	JROOT/administrator/components/com_jgive/controller.php:45
5	JGiveController->display()	JROOT/libraries/src/MVC/Controller/BaseController.php:730
6	Joomla\CMS\MVC\Controller\BaseController->execute()	JROOT/administrator/components/com_jgive/jgive.php:126
7	require_once()	JROOT/libraries/src/Dispatcher/LegacyComponentDispatcher.php:71
8	Joomla\CMS\Dispatcher\LegacyComponentDispatcher::Joomla\CMS\Dispatcher\{closure}()	JROOT/libraries/src/Dispatcher/LegacyComponentDispatcher.php:73
9	Joomla\CMS\Dispatcher\LegacyComponentDispatcher->dispatch()	JROOT/libraries/src/Component/ComponentHelper.php:361
10	Joomla\CMS\Component\ComponentHelper::renderComponent()	JROOT/libraries/src/Application/AdministratorApplication.php:150
11	Joomla\CMS\Application\AdministratorApplication->dispatch()	JROOT/libraries/src/Application/AdministratorApplication.php:205
12	Joomla\CMS\Application\AdministratorApplication->doExecute()	JROOT/libraries/src/Application/CMSApplication.php:320
13	Joomla\CMS\Application\CMSApplication->execute()	JROOT/administrator/includes/app.php:58
14	require_once()	JROOT/administrator/index.php:32

Referance link : http://ttpl-rt-234-php83.local/joomla_62/administrator/index.php?option=com_jgive&view=donors

Issue 3:

An error has occurred.
0 Class "jFactory" not found
Call Stack
#	Function	Location
1	()	JROOT/administrator/components/com_tjfields/views/fields/tmpl/default_bs5.php:35
2	include()	JROOT/libraries/src/MVC/View/HtmlView.php:416
3	Joomla\CMS\MVC\View\HtmlView->loadTemplate()	JROOT/administrator/components/com_tjfields/views/fields/tmpl/default.php:20
4	include()	JROOT/libraries/src/MVC/View/HtmlView.php:416
5	Joomla\CMS\MVC\View\HtmlView->loadTemplate()	JROOT/libraries/src/MVC/View/HtmlView.php:204
6	Joomla\CMS\MVC\View\HtmlView->display()	JROOT/administrator/components/com_tjfields/views/fields/view.html.php:63
7	TjfieldsViewFields->display()	JROOT/libraries/src/MVC/Controller/BaseController.php:697
8	Joomla\CMS\MVC\Controller\BaseController->display()	JROOT/administrator/components/com_tjfields/controller.php:62
9	TjfieldsController->display()	JROOT/libraries/src/MVC/Controller/BaseController.php:730
10	Joomla\CMS\MVC\Controller\BaseController->execute()	JROOT/administrator/components/com_tjfields/tjfields.php:80
11	require_once()	JROOT/libraries/src/Dispatcher/LegacyComponentDispatcher.php:71
12	Joomla\CMS\Dispatcher\LegacyComponentDispatcher::Joomla\CMS\Dispatcher\{closure}()	JROOT/libraries/src/Dispatcher/LegacyComponentDispatcher.php:73
13	Joomla\CMS\Dispatcher\LegacyComponentDispatcher->dispatch()	JROOT/libraries/src/Component/ComponentHelper.php:361
14	Joomla\CMS\Component\ComponentHelper::renderComponent()	JROOT/libraries/src/Application/AdministratorApplication.php:150
15	Joomla\CMS\Application\AdministratorApplication->dispatch()	JROOT/libraries/src/Application/Administrathttp://ttpl-rt-234-php83.local/joomla_62/administrator/index.php?option=com_tjfields&view=fields&client=com_jgive.campaignorApplication.php:205
16	Joomla\CMS\Application\AdministratorApplication->doExecute()	JROOT/libraries/src/Application/CMSApplication.php:320
17	Joomla\CMS\Application\CMSApplication->execute()	JROOT/administrator/includes/app.php:58
18	require_once()	JROOT/administrator/index.php:32

referance link : http://ttpl-rt-234-php83.local/joomla_62/administrator/index.php?option=com_tjfields&view=fields&client=com_jgive.campaign

Issue 4: 

An error has occurred.
0 Class "JFormField" not found
Call Stack
#	Function	Location
1	()	JROOT/administrator/components/com_tjfields/models/fields/createdby.php:20
2	require_once()	JROOT/libraries/src/Form/FormHelper.php:271
3	Joomla\CMS\Form\FormHelper::loadClass()	JROOT/libraries/src/Form/FormHelper.php:136
4	Joomla\CMS\Form\FormHelper::loadType()	JROOT/libraries/src/Form/FormHelper.php:78
5	Joomla\CMS\Form\FormHelper::loadFieldType()	JROOT/libraries/src/Form/Form.php:1463
6	Joomla\CMS\Form\Form->loadField()	JROOT/libraries/src/Form/Form.php:233
7	Joomla\CMS\Form\Form->getField()	JROOT/libraries/src/Form/Form.php:488
8	Joomla\CMS\Form\Form->getLabel()	JROOT/administrator/components/com_tjfields/views/group/tmpl/edit_bs5.php:77
9	include()	JROOT/libraries/src/MVC/View/HtmlView.php:416
10	Joomla\CMS\MVC\View\HtmlView->loadTemplate()	JROOT/administrator/components/com_tjfields/views/group/tmpl/edit.php:20
11	include()	JROOT/libraries/src/MVC/View/HtmlView.php:416
12	Joomla\CMS\MVC\View\HtmlView->loadTemplate()	JROOT/libraries/src/MVC/View/HtmlView.php:204
13	Joomla\CMS\MVC\View\HtmlView->display()	JROOT/administrator/components/com_tjfields/views/group/view.html.php:53
14	TjfieldsViewGroup->display()	JROOT/libraries/src/MVC/Controller/BaseController.php:697
15	Joomla\CMS\MVC\Controller\BaseController->display()	JROOT/administrator/components/com_tjfields/controller.php:62
16	TjfieldsController->display()	JROOT/libraries/src/MVC/Controller/BaseController.php:730
17	Joomla\CMS\MVC\Controller\BaseController->execute()	JROOT/administrator/components/com_tjfields/tjfields.php:80
18	require_once()	JROOT/libraries/src/Dispatcher/LegacyComponentDispatcher.php:71
19	Joomla\CMS\Dispatcher\LegacyComponentDispatcher::Joomla\CMS\Dispatcher\{closure}()	JROOT/libraries/src/Dispatcher/LegacyComponentDispatcher.php:73
20	Joomla\CMS\Dispatcher\LegacyComponentDispatcher->dispatch()	JROOT/libraries/src/Component/ComponentHelper.php:361
21	Joomla\CMS\Component\ComponentHelper::renderComponent()	JROOT/libraries/src/Application/AdministratorApplication.php:150
22	Joomla\CMS\Application\AdministratorApplication->dispatch()	JROOT/libraries/src/Application/AdministratorApplication.php:205
23	Joomla\CMS\Application\AdministratorApplication->doExecute()	JROOT/libraries/src/Application/CMSApplication.php:320
24	Joomla\CMS\Application\CMSApplication->execute()	JROOT/administrator/includes/app.php:58
25	require_once()	JROOT/administrator/index.php:32

Referance link : http://ttpl-rt-234-php83.local/joomla_62/administrator/index.php?option=com_tjfields&view=group&layout=edit&client=com_jgive.campaign

Issue 5: 

An error has occurred.
0 Class "ToolbarHelper" not found
Call Stack
#	Function	Location
1	()	JROOT/administrator/components/com_tjfields/views/country/view.html.php:93
2	TjfieldsViewCountry->addToolbar()	JROOT/administrator/components/com_tjfields/views/country/view.html.php:53
3	TjfieldsViewCountry->display()	JROOT/libraries/src/MVC/Controller/BaseController.php:697
4	Joomla\CMS\MVC\Controller\BaseController->display()	JROOT/administrator/components/com_tjfields/controller.php:62
5	TjfieldsController->display()	JROOT/libraries/src/MVC/Controller/BaseController.php:730
6	Joomla\CMS\MVC\Controller\BaseController->execute()	JROOT/administrator/components/com_tjfields/tjfields.php:80
7	require_once()	JROOT/libraries/src/Dispatcher/LegacyComponentDispatcher.php:71
8	Joomla\CMS\Dispatcher\LegacyComponentDispatcher::Joomla\CMS\Dispatcher\{closure}()	JROOT/libraries/src/Dispatcher/LegacyComponentDispatcher.php:73
9	Joomla\CMS\Dispatcher\LegacyComponentDispatcher->dispatch()	JROOT/libraries/src/Component/ComponentHelper.php:361
10	Joomla\CMS\Component\ComponentHelper::renderComponent()	JROOT/libraries/src/Application/AdministratorApplication.php:150
11	Joomla\CMS\Application\AdministratorApplication->dispatch()	JROOT/libraries/src/Application/AdministratorApplication.php:205
12	Joomla\CMS\Application\AdministratorApplication->doExecute()	JROOT/libraries/src/Application/CMSApplication.php:320
13	Joomla\CMS\Application\CMSApplication->execute()	JROOT/administrator/includes/app.php:58
14	require_once()	JROOT/administrator/index.php:32

Referance link : http://ttpl-rt-234-php83.local/joomla_62/administrator/index.php?option=com_tjfields&view=country&layout=edit&client=com_jgive

Issue 6:

An error has occurred.
0 Class "ToolbarHelper" not found
Call Stack
#	Function	Location
1	()	JROOT/administrator/components/com_tjfields/views/country/view.html.php:93
2	TjfieldsViewCountry->addToolbar()	JROOT/administrator/components/com_tjfields/views/country/view.html.php:53
3	TjfieldsViewCountry->display()	JROOT/libraries/src/MVC/Controller/BaseController.php:697
4	Joomla\CMS\MVC\Controller\BaseController->display()	JROOT/administrator/components/com_tjfields/controller.php:62
5	TjfieldsController->display()	JROOT/libraries/src/MVC/Controller/BaseController.php:730
6	Joomla\CMS\MVC\Controller\BaseController->execute()	JROOT/administrator/components/com_tjfields/tjfields.php:80
7	require_once()	JROOT/libraries/src/Dispatcher/LegacyComponentDispatcher.php:71
8	Joomla\CMS\Dispatcher\LegacyComponentDispatcher::Joomla\CMS\Dispatcher\{closure}()	JROOT/libraries/src/Dispatcher/LegacyComponentDispatcher.php:73
9	Joomla\CMS\Dispatcher\LegacyComponentDispatcher->dispatch()	JROOT/libraries/src/Component/ComponentHelper.php:361
10	Joomla\CMS\Component\ComponentHelper::renderComponent()	JROOT/libraries/src/Application/AdministratorApplication.php:150
11	Joomla\CMS\Application\AdministratorApplication->dispatch()	JROOT/libraries/src/Application/AdministratorApplication.php:205
12	Joomla\CMS\Application\AdministratorApplication->doExecute()	JROOT/libraries/src/Application/CMSApplication.php:320
13	Joomla\CMS\Application\CMSApplication->execute()	JROOT/administrator/includes/app.php:58
14	require_once()	JROOT/administrator/index.php:32

http://ttpl-rt-234-php83.local/joomla_62/administrator/index.php?option=com_tjfields&view=region&layout=edit&client=com_jgive


An error has occurred.
0 Class "JFormField" not found
Call Stack
#	Function	Location
1	()	JROOT/administrator/components/com_jgive/models/fields/imagedisplay.php:22
2	require_once()	JROOT/libraries/src/Form/FormHelper.php:271
3	Joomla\CMS\Form\FormHelper::loadClass()	JROOT/libraries/src/Form/FormHelper.php:136
4	Joomla\CMS\Form\FormHelper::loadType()	JROOT/libraries/src/Form/FormHelper.php:78
5	Joomla\CMS\Form\FormHelper::loadFieldType()	JROOT/libraries/src/Form/Form.php:1463
6	Joomla\CMS\Form\Form->loadField()	JROOT/libraries/src/Form/Form.php:446
7	Joomla\CMS\Form\Form->getGroup()	JROOT/layouts/joomla/form/field/subform/repeatable/section.php:47
8	include()	JROOT/libraries/src/Layout/FileLayout.php:128
9	Joomla\CMS\Layout\FileLayout->render()	JROOT/libraries/src/Layout/FileLayout.php:636
10	Joomla\CMS\Layout\FileLayout->sublayout()	JROOT/layouts/joomla/form/field/subform/repeatable.php:70
11	include()	JROOT/libraries/src/Layout/FileLayout.php:128
12	Joomla\CMS\Layout\FileLayout->render()	JROOT/libraries/src/Form/Field/SubformField.php:274
13	Joomla\CMS\Form\Field\SubformField->getInput()	JROOT/libraries/src/Form/FormField.php:1070
14	Joomla\CMS\Form\FormField->renderField()	JROOT/libraries/src/Form/Form.php:547
15	Joomla\CMS\Form\Form->renderField()	JROOT/administrator/components/com_jgive/views/campaign/tmpl/edit_bs5.php:58
16	include()	JROOT/libraries/src/MVC/View/HtmlView.php:416
17	Joomla\CMS\MVC\View\HtmlView->loadTemplate()	JROOT/administrator/components/com_jgive/views/campaign/tmpl/edit.php:20
18	include()	JROOT/libraries/src/MVC/View/HtmlView.php:416
19	Joomla\CMS\MVC\View\HtmlView->loadTemplate()	JROOT/libraries/src/MVC/View/HtmlView.php:204
20	Joomla\CMS\MVC\View\HtmlView->display()	JROOT/administrator/components/com_jgive/views/campaign/view.html.php:144
21	JGiveViewCampaign->display()	JROOT/libraries/src/MVC/Controller/BaseController.php:697
22	Joomla\CMS\MVC\Controller\BaseController->display()	JROOT/administrator/components/com_jgive/controller.php:45
23	JGiveController->display()	JROOT/libraries/src/MVC/Controller/BaseController.php:730
24	Joomla\CMS\MVC\Controller\BaseController->execute()	JROOT/administrator/components/com_jgive/jgive.php:126
25	require_once()	JROOT/libraries/src/Dispatcher/LegacyComponentDispatcher.php:71
26	Joomla\CMS\Dispatcher\LegacyComponentDispatcher::Joomla\CMS\Dispatcher\{closure}()	JROOT/libraries/src/Dispatcher/LegacyComponentDispatcher.php:73
27	Joomla\CMS\Dispatcher\LegacyComponentDispatcher->dispatch()	JROOT/libraries/src/Component/ComponentHelper.php:361
28	Joomla\CMS\Component\ComponentHelper::renderComponent()	JROOT/libraries/src/Application/AdministratorApplication.php:150
29	Joomla\CMS\Application\AdministratorApplication->dispatch()	JROOT/libraries/src/Application/AdministratorApplication.php:205
30	Joomla\CMS\Application\AdministratorApplication->doExecute()	JROOT/libraries/src/Application/CMSApplication.php:320
31	Joomla\CMS\Application\CMSApplication->execute()	JROOT/administrator/includes/app.php:58
32	require_once()	JROOT/administrator/index.php:32

http://ttpl-rt-234-php83.local/joomla_62/administrator/index.php?option=com_jgive&view=campaign&layout=edit


Issue 1:
An error has occurred.
0 Call to a member function getCampaignUrl() on null
Call Stack
#	Function	Location
1	()	JROOT/plugins/system/jgiveactivities/helper.php:620
2	PlgSystemJgiveActivitiesHelper->addCampaignActivity()	JROOT/plugins/system/jgiveactivities/jgiveactivities.php:282
3	PlgSystemJgiveActivities->onAfterJGCampaignCreate()	JROOT/libraries/src/Plugin/CMSPlugin.php:386
4	Joomla\CMS\Plugin\CMSPlugin->Joomla\CMS\Plugin\{closure}()	JROOT/libraries/vendor/joomla/event/src/Dispatcher.php:454
5	Joomla\Event\Dispatcher->dispatch()	JROOT/libraries/src/Application/EventAware.php:111
6	Joomla\CMS\Application\WebApplication->triggerEvent()	JROOT/components/com_jgive/models/campaignform.php:845
7	JGiveModelCampaignForm->save()	JROOT/administrator/components/com_jgive/controllers/campaign.php:192
8	JGiveControllerCampaign->save()	JROOT/libraries/src/MVC/Controller/BaseController.php:730
9	Joomla\CMS\MVC\Controller\BaseController->execute()	JROOT/administrator/components/com_jgive/jgive.php:126
10	require_once()	JROOT/libraries/src/Dispatcher/LegacyComponentDispatcher.php:71
11	Joomla\CMS\Dispatcher\LegacyComponentDispatcher::Joomla\CMS\Dispatcher\{closure}()	JROOT/libraries/src/Dispatcher/LegacyComponentDispatcher.php:73
12	Joomla\CMS\Dispatcher\LegacyComponentDispatcher->dispatch()	JROOT/libraries/src/Component/ComponentHelper.php:361
13	Joomla\CMS\Component\ComponentHelper::renderComponent()	JROOT/libraries/src/Application/AdministratorApplication.php:150
14	Joomla\CMS\Application\AdministratorApplication->dispatch()	JROOT/libraries/src/Application/AdministratorApplication.php:205
15	Joomla\CMS\Application\AdministratorApplication->doExecute()	JROOT/libraries/src/Application/CMSApplication.php:320
16	Joomla\CMS\Application\CMSApplication->execute()	JROOT/administrator/includes/app.php:58
17	require_once()	JROOT/administrator/index.php:32

issue occured while created and tried to save campaign


Issue 1:

An error has occurred.
0 Class "JFormField" not found
Call Stack
#	Function	Location
1	()	JROOT/media/com_jgive/fields/legend.php:37
2	require_once()	JROOT/libraries/src/Form/FormHelper.php:271
3	Joomla\CMS\Form\FormHelper::loadClass()	JROOT/libraries/src/Form/FormHelper.php:136
4	Joomla\CMS\Form\FormHelper::loadType()	JROOT/libraries/src/Form/FormHelper.php:78
5	Joomla\CMS\Form\FormHelper::loadFieldType()	JROOT/libraries/src/Form/Form.php:1463
6	Joomla\CMS\Form\Form->loadField()	JROOT/libraries/src/Form/Form.php:304
7	Joomla\CMS\Form\Form->getFieldset()	JROOT/libraries/src/Form/Form.php:565
8	Joomla\CMS\Form\Form->renderFieldset()	JROOT/administrator/components/com_config/tmpl/component/default.php:111
9	include()	JROOT/libraries/src/MVC/View/HtmlView.php:416
10	Joomla\CMS\MVC\View\HtmlView->loadTemplate()	JROOT/libraries/src/MVC/View/HtmlView.php:204
11	Joomla\CMS\MVC\View\HtmlView->display()	JROOT/administrator/components/com_config/src/View/Component/HtmlView.php:135
12	Joomla\Component\Config\Administrator\View\Component\HtmlView->display()	JROOT/libraries/src/MVC/Controller/BaseController.php:697
13	Joomla\CMS\MVC\Controller\BaseController->display()	JROOT/administrator/components/com_config/src/Controller/DisplayController.php:64
14	Joomla\Component\Config\Administrator\Controller\DisplayController->display()	JROOT/libraries/src/MVC/Controller/BaseController.php:730
15	Joomla\CMS\MVC\Controller\BaseController->execute()	JROOT/libraries/src/Dispatcher/ComponentDispatcher.php:143
16	Joomla\CMS\Dispatcher\ComponentDispatcher->dispatch()	JROOT/libraries/src/Component/ComponentHelper.php:361
17	Joomla\CMS\Component\ComponentHelper::renderComponent()	JROOT/libraries/src/Application/AdministratorApplication.php:150
18	Joomla\CMS\Application\AdministratorApplication->dispatch()	JROOT/libraries/src/Application/AdministratorApplication.php:205
19	Joomla\CMS\Application\AdministratorApplication->doExecute()	JROOT/libraries/src/Application/CMSApplication.php:320
20	Joomla\CMS\Application\CMSApplication->execute()	JROOT/administrator/includes/app.php:58
21	require_once()	JROOT/administrator/index.php:32

Referance link : http://ttpl-rt-234-php83.local/joomla_63/administrator/index.php?option=com_config&view=component&component=com_jgive&path=&return=aHR0cDovL3R0cGwtcnQtMjM0LXBocDgzLmxvY2FsL2pvb21sYV82My9hZG1pbmlzdHJhdG9yL2luZGV4LnBocD9vcHRpb249Y29tX2pnaXZlJnZpZXc9Y2FtcGFpZ25z