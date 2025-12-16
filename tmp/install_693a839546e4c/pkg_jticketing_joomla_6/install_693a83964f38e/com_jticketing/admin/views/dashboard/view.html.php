<?php

// no direct access
defined( '_JEXEC' ) or die( ';)' );

use Joomla\CMS\Factory;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Toolbar\Toolbar;
use Joomla\CMS\MVC\View\HtmlView;
use Joomla\CMS\Toolbar\ToolbarHelper;
use Joomla\CMS\Component\ComponentHelper;

class jticketingViewDashboard extends HtmlView
{

	function display($tpl = null)
	{
		$params = ComponentHelper::getParams('com_jticketing');
		$integration = $params->get('integration');

		// Native Event Manager.
		if($integration<1)
		{
		?>
			<div class="alert alert-info alert-help-inline">
		<?php echo Text::_('COMJTICKETING_INTEGRATION_NOTICE');
		?>
			</div>
		<?php
			return false;
		}

		$mainframe = Factory::getApplication();
		$JticketingHelper=new JticketingHelperadmin();
		$JticketingHelper->addSubmenu('dashboard');
		if(JVERSION>='3.0')
		$this->sidebar = // Joomla 6: JHtmlSidebar removedrender();


		$this->_setToolBar();
		$com_params=ComponentHelper::getParams('com_jticketing');
		$this->currency = $com_params->get('currency');

		// Get data from the model
		$allincome =  $this->get( 'AllOrderIncome');
		$MonthIncome =  $this->get( 'MonthIncome');
		$AllMonthName = $this->get( 'Allmonths');
		$orderscount = $this->get( 'orderscount');

		$tot_periodicorderscount =$this->get( 'periodicorderscount');
		$this->tot_periodicorderscount=$tot_periodicorderscount ;
		$model=$this->getModel();
	    $statsforbar= $model->statsforbar();
		$this->statsforbar=$statsforbar;

		//calling line-graph function
	    $statsforpie= $model->statsforpie();
		$this->statsforpie=$statsforpie;


		// Get data from the model
		$this->allincome=$allincome;

		$this->MonthIncome=$MonthIncome;
		$this->AllMonthName=$AllMonthName;
		parent::display($tpl);

	}//function display ends here

	function _setToolBar()
	{
		$document =Factory::getDocument();
		HTMLHelper::_('stylesheet', 'components/com_jticketing/css/jticketing.css');
		$bar = ToolBar::getInstance('toolbar');
		ToolbarHelper::title( Text::_( 'JT_SOCIAL' ), 'icon-48-jticketing.png' );
		ToolbarHelper::preferences('com_jticketing');
	}

}// class
