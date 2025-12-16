<?php
defined( '_JEXEC' ) or die( ';)' );

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper;

jimport( 'joomla.form.formvalidator' );
HTMLHelper::_('behavior.formvalidator');
HTMLHelper::_('bootstrap.tooltip');
jimport( 'joomla.html.parameter' );
$db=Factory::getDbo();
$result=$this->allincome;
$document =& Factory::getDocument();


$model=$this->getModel('dashboard');
$mntnm_cnt=1;
$i=0;
////////////////////
$session =& Factory::getSession();
$session->set('jticketing_from_date','');
$session->set('jticketing_end_date', '');
$session->set('statsforbar', '');
$session->set('statsforpie', '');
$session->set('statsfor_line_day_str_final', '');
$session->set('statsfor_line_imprs', '');
$session->set('statsfor_line_clicks', '');
$session->set('periodicorderscount', '');
$backdate = date('Y-m-d', strtotime(date('Y-m-d').' - 30 days'));

$kk=0;


///////////////////////////////////

$curdate='';
foreach($this->AllMonthName as $AllMonthName)
{
	$AllMonthName_final[$i]=$AllMonthName['month'];
	$curr_MON=$AllMonthName['month'];
	$month_amt_val[$curr_MON]=0;
		$i++;

}

$emptybarchart=1;
foreach($this->MonthIncome as $MonthIncome)
{
$month_year='';
 $month_year=$MonthIncome->YEARNM;
$month_name=$MonthIncome->MONTHSNAME;

$month_int = (int)$month_name;
$timestamp = mktime(0, 0, 0, $month_int);
$curr_month=date("F", $timestamp);

foreach($this->AllMonthName as $AllMonthName)
{
if(($curr_month==$AllMonthName['month']) and ($MonthIncome->amount) and ($month_year==$AllMonthName['year']))
$month_amt_val[$curr_month]=str_replace(",",'',$MonthIncome->amount);

if($MonthIncome->amount)
$emptybarchart=0;
else
$emptybarchart=1;


}

}
 $month_amt_str=implode(",",$month_amt_val);
 $month_name_str=implode("','",$AllMonthName_final);
 $month_name_str="'".$month_name_str."'";
 $month_array_name=array();

  $js = "

  var linechart_imprs;
	var linechart_clicks;
	var linechart_day_str=new Array();

  function refreshViews()
	{
	jQuery.noConflict();
		fromDate = document.getElementById('from').value;
		toDate = document.getElementById('to').value;
		fromDate1 = new Date(fromDate.toString());
		toDate1 = new Date(toDate.toString());
		difference = toDate1 - fromDate1;
		days = Math.round(difference/(1000*60*60*24));
		if(parseInt(days)<=0)
		{
			alert(\"".Text::_('COM_JTICKETING_START_DATE_LESS_EVENT_END_DATE_ERROR')."\");
			return;

		}
		//Set Session Variables
		jQuery(document).ready(function(){
		var info = {};
		jQuery.ajax({
		    type: 'GET',
		    url: '?option=com_jticketing&controller=dashboard&task=SetsessionForGraph&fromDate='+fromDate+'&toDate='+toDate,
		    dataType: 'json',
		    async:false,
		    success: function(data) {


		    }
		});
 setTimeout(function(){},3000);
 //Make Chart and Get Data
		jQuery.ajax({
		    type: 'GET',
		    url: '?option=com_jticketing&controller=dashboard&task=makechart',
		    async:false,
		    dataType: 'json',
		    success: function(data) {
			jQuery('#bar_chart_graph').html(''+data.barchart);

				document.getElementById('pending_orders').value=data.pending_orders;
				document.getElementById('confirmed_orders').value=data.confirmed_orders;
				document.getElementById('refund_orders').value=data.refund_orders;
				document.getElementById('periodic_orders').innerHTML = data.periodicorderscount;




			google.setOnLoadCallback(drawPieChart);
			drawPieChart();

		    }
		});

		});
	}
	";
  $document->addScriptDeclaration($js);


?>




<form action="index.php" name="adminForm" id="adminForm"  method="post">
	<?php

if(JVERSION>=3.0):

	if(!empty( $this->sidebar)): ?>
	<div id="sidebar" style="widht:5%">
		<div id="j-sidebar-container" class="span2">
			<?php echo $this->sidebar; ?>
		</div>

	</div>

		<div id="j-main-container" class="span10">

	<?php else : ?>
		<div id="j-main-container">
	<?php endif;
endif;
?>
<div class="techjoomla-bootstrap"><!--START techjoomla-bootstrap-->

	<div class="row-fluid">
		<div class="span12">
			<div class="row-fluid">
				<div class="span6">
					<div class="well">
						<?php
						if(!$this->allincome)
						$this->allincome=0;
						echo $title = "<p><strong>".Text::_('COM_JTICKETING_TOTAL_SALES')."&nbsp;".HTMLHelper::tooltip(Text::_('COM_JTICKETING_TOTAL_SALES_DESC') . '.', Text::_('COM_JTICKETING_TOTAL_SALES'))."</strong></p>" ;
						echo $data = "&nbsp;".$this->allincome."&nbsp;".$this->currency;


					?>
					</div><!--well-->
				</div><!--span6-->

				<div class="span6">
					<div class="well">


							  <p><?php echo Text::_('FROM_DATE')."&nbsp;";
									 echo HTMLHelper::_('calendar', $backdate, 'from', 'from', '%Y-%m-%d', array('class'=>'inputbox')); ?></p>
								<p><?php echo Text::_('TO_DATE')."&nbsp;&nbsp;&nbsp;";  echo HTMLHelper::_('calendar', date('Y-m-d'), 'to', 'to', '%Y-%m-%d', array('class'=>'inputbox'));echo "&nbsp;&nbsp";
								 ?><input id="btnRefresh" type="button" value=">>" style="font-weight: bold;" onclick="refreshViews();"/>
								</p>

								 <?php

									if(!$this->tot_periodicorderscount)
									$this->tot_periodicorderscount=0;
									echo $title = "<p></p><p><strong>".Text::_('PERIODIC_INCOME')."&nbsp;".HTMLHelper::tooltip(Text::_('PERIODIC_INCOME_DESC') . '.', Text::_('PERIODIC_INCOME'))."</strong></p>" ;
									echo $data = "<span id='periodic_orders'><p>".$this->tot_periodicorderscount."&nbsp;"."</p></span>";

								 ?>

					</div><!--well-->
				</div><!--span6-->
			</div><!--row-fluid-->


	<div class="row-fluid">
		<div class="span12">
			<div class="row-fluid">
				<div class="span6">
					<div class="well">

						<?php
						echo $title = "<p><strong>".Text::_('MONTHLY_ORDERS_INCOME')."&nbsp;".HTMLHelper::tooltip(Text::_('MONTHLY_ORDERS_INCOME_DESC') . '.', Text::_('MONTHLY_ORDERS_INCOME'))."</strong></p>" ;
						echo $data = "<p>".$this->allincome."&nbsp;".$this->currency."</p>";
						echo $text = "<div id=\"monthin\" style=\"text-align: center; font-size: 16px; font-weight: bold;\"> </div>";
						?>
													<script type="text/javascript" src="http://www.google.com/jsapi"></script>
							<script type="text/javascript">

							// Load the Visualization API and the piechart package.
							google.load('visualization', '1', {'packages':['corechart']});

							// Set a callback to run when the Google Visualization API is loaded.
							google.setOnLoadCallback(drawChart);
							// Create and populate the data table.
							function drawChart() {

							<?php if(!$this->allincome) {?>

							document.getElementById("monthin").innerHTML='<?php  echo '<h5>'.Text::_("NO_STATS").'<h5>'; ?>';
							return;
							<?php } ?>
							var data = new google.visualization.DataTable();

							var raw_dt1=[<?php echo $month_amt_str;?>];
							var raw_data = [raw_dt1];
							var Months = [<?php echo $month_name_str;?>];
							data.addColumn("string", "<?php echo Text::_('BAR_CHART_HAXIS_TITLE');?>");
							data.addColumn("number","<?php echo Text::_('BAR_CHART_VAXIS_TITLE').' ('.$this->currency.')';?>");
							data.addRows(Months.length);

							for (var j = 0; j < Months.length; ++j) {
							  data.setValue(j, 0, Months[j].toString());
							}
							for (var i = 0; i  < raw_data.length; ++i) {
							  for (var j = 1; j  <=(raw_data[i].length); ++j) {
								data.setValue(j-1, i+1, raw_data[i][j-1]);

							  }
							}


							// Create and draw the visualization.
							new google.visualization.ColumnChart(document.getElementById("monthin")).
								draw(data,
									 {title:'<?php echo Text::_("MONTHLY_INCOME_MONTH");?>',
									  width:'48%', height:300,
									  fontSize:'13px',
									  hAxis: {title: "<?php echo Text::_('BAR_CHART_HAXIS_TITLE');?>"},
									  vAxis: {title: "<?php echo Text::_('BAR_CHART_VAXIS_TITLE').' ('.$this->currency.')';?>"}

									  }
								);
							}
							</script>
					</div><!--well-->
				</div><!--span6-->

				<div class="span6">
					<div class="well">

						<?php
						echo $text = "<div id=\"chart_div\" style=\"text-align: center; font-size: 16px; font-weight: bold;\"></div>";
						echo $text = "<div id=\"monthin\" style=\"text-align: center; font-size: 16px; font-weight: bold;\"> </div>";
						?>

			 <?php
			  	if($session->get('statsforpie', ''))
			  	$statsforpie = $session->get('statsforpie', '');
			  	else
			  	$statsforpie = $this->statsforpie;
			  	$currentmonth='';
			  	$pending_orders=$confirmed_orders=$refund_orders=0;


			if(empty($statsforpie))
			{
				$barchart=Text::_('NO_STATS');
				$emptylinechart=1;
			}
			else
			{
			  	if(!empty($statsforpie['P']))
				{

						 $pending_orders= $statsforpie['P'];


			  	}

				if(!empty($statsforpie['C']))
				{

						 $confirmed_orders = $statsforpie['C'];


				}

				if(!empty($statsforpie['RF']))
				{

						 $refund_orders = $statsforpie['RF'];


				}

			}

			$emptylinechart=0;
			if(!$pending_orders and !$confirmed_orders and !$refund_orders)
			$emptylinechart=1;


			 ?>



		   <script type="text/javascript" src="http://www.google.com/jsapi"></script>
			<script type="text/javascript">

			// Load the Visualization API and the piechart package.
			//google.load('visualization', '1', {'packages':['piechart']});

			// Set a callback to run when the Google Visualization API is loaded.
			google.setOnLoadCallback(drawPieChart);

			// Callback that creates and populates a data table,
			// instantiates the pie chart, passes in the data and
			// draws it.
			function drawPieChart() {
				var pending_orders=0;
				var confirmed_orders=0;
				var refund_orders=0;
				pending_orders=parseInt(document.getElementById("pending_orders").value);
				confirmed_orders=parseInt(document.getElementById("confirmed_orders").value);
				refund_orders=parseInt(document.getElementById("refund_orders").value);
				<?php if($emptylinechart) {?>
						document.getElementById("chart_div").innerHTML='<?php  echo '<h5>'.Text::_("NO_STATS").'<h5>'; ?>';
						return;
				<?php } ?>
				if(parseInt(pending_orders)==0 && parseInt(confirmed_orders)==0 && parseInt(refund_orders)==0)
				{
				document.getElementById("chart_div").innerHTML='<?php  echo '<h5>'.Text::_("NO_STATS").'<h5>'; ?>';
				return;
				}
			// Create our data table.
				var data = new google.visualization.DataTable();
				data.addColumn('string', 'Event');
				data.addColumn('number', 'Amount');
				data.addRows([

					['<?php echo Text::_("JT_PSTATUS_PENDING");?>',pending_orders],
					['<?php echo Text::_("JT_PSTATUS_COMPLETED");?>',confirmed_orders],
					['<?php echo Text::_("JT_PSTATUS_REFUNDED");?>',refund_orders]
				]);

				var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
				chart.draw(data, { width: '48%', height: 300,is3D:true,fontSize:'10px',colors: ['#DF0101','#01DF74','#0174DF'],  title: '<?php echo Text::_("PERIODIC_ORDERS").' '.$currentmonth;?> '});
			}
			</script>



 	 <!-- Extra code for zone -->
 	 <input type="hidden" name="pending_orders" id="pending_orders" value="<?php if($pending_orders) echo $pending_orders; else echo '0'; ?>">
 	 <input type="hidden" name="confirmed_orders" id="confirmed_orders" value="<?php if($confirmed_orders) echo $confirmed_orders; else echo '0';  ?>">
 	 <input type="hidden" name="refund_orders" id="refund_orders" value="<?php if($refund_orders) echo $refund_orders; else echo '0'; ?>">
 	   	 <input type="hidden" name="confirmed_orders" id="confirmed_orders" value="<?php if($confirmed_orders) echo $confirmed_orders; else echo '0';  ?>">


 	  <!-- Extra code for zone -->

<script type="text/javascript">
			jQuery(document).ready(function(){
				document.getElementById("pending_orders").value=<?php if($pending_orders) echo $pending_orders; else echo '0'; ?>;
				document.getElementById("confirmed_orders").value=<?php if($confirmed_orders) echo $confirmed_orders; else echo '0'; ?>;
				document.getElementById("refund_orders").value=<?php  if($refund_orders) echo $refund_orders; else echo '0'; ?>;

			});
</script>
				</div><!--well-->
			</div><!--span6-->
		</div><!--row-fluid-->
	</div><!--techjoomla straper -->
</form>

