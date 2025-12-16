<?php
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;

/**
 * @package		jomLike
 * @author 		Techjoomla http://www.techjoomla.com
 * @copyright 	Copyright (C) 2011-2012 Techjoomla. All rights reserved.
 * @license 	GNU/GPL v2 http://www.gnu.org/licenses/gpl-2.0.html
 */
//Load the xml file
$xml            = simplexml_load_file(JPATH_SITE . '/administrator/components/com_jlike/jlike.xml');
$currentversion = $xml->version;

$day_str     = "'" . implode("','", $this->linechart['days_arr']) . "'";
$like_str    = implode(",", $this->linechart['like_arr']);
$dislike_str = implode(",", $this->linechart['dislike_arr']);
?>

<style type="text/css">
span.latestbutton{
color:#0B55C4;
cursor: pointer;
}
span.latestbutton:hover{
text-decoration:underline;
}
</style>

<script type="text/javascript">
	function vercheck()
	{
		callXML('<?php echo $currentversion; ?>');
		if(document.getElementById('NewVersion').innerHTML.length<220){
			document.getElementById('NewVersion').style.display='inline';
		}
	}

	function callXML(currversion)
	{
		if (window.XMLHttpRequest){
		 	 xhttp=new XMLHttpRequest();
			}
		else // Internet Explorer 5/6
		{
		 	xhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}

		xhttp.open("GET","<?php echo JURI::base(); ?>index.php?option=com_jlike&task=getVersion",false);
		xhttp.send("");
		latestver=xhttp.responseText;

		if(latestver!=null)
		{
			if(currversion == latestver){
				document.getElementById('NewVersion').innerHTML='<span style="display:inline; color:#339F1D;"><?php echo Text::_('COM_JLIKE_LATEST_VERSION'); ?> :'+latestver+' &nbsp;';
			}
			else{
				document.getElementById('NewVersion').innerHTML='<span style="display:inline; color:#FF0000;"><?php echo Text::_('COM_JLIKE_LATEST_VERSION'); ?> :'+latestver+' &nbsp;';
			}
		}
	}
</script>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
  google.load("visualization", "1", {packages:["corechart"]});
  google.setOnLoadCallback(drawChart);
  function drawChart() {
   var data = new google.visualization.DataTable();

		data.addColumn('string', 'Day');
	data.addColumn('number', 'Like Count');
		data.addColumn('number', 'Dislike Count');
	var options = {
	  title: 'JLike Dashboard'
	};

		var like_cnt=[<?php echo $like_str; ?>]
		var dislike_cnt=[<?php echo $dislike_str; ?>]
		var assign_date=[<?php echo $day_str; ?>]

		data.addRows(assign_date.length+1);
		for(var i=0;i<assign_date.length;i++)
		{
			data.setValue(i, 0, assign_date[i].toString());
			data.setValue(i, 1, like_cnt[i]);
			data.setValue(i, 2, dislike_cnt[i]);
		}


	var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
   chart.draw(data, {width: "90%", height: 510,title: 'JLike Dashboard', fontSize:"12", vAxis:{title: 'Number of Likes and Dislikes',  titleTextStyle: {color: '#000000'}}});
  }
</script>


<?php if (JVERSION < 3.0){ ?>
<div class="techjoomla-bootstrap" >
<?php } ?>

<?php if (!$this->checkMigrate){ ?>
			<script src="<?php echo JURI::root() . 'components/com_jlike/assets/scripts/jquery-1.7.1.min.js'; ?>" type="text/javascript"></script>
				<script language="JavaScript">
					function migratelikes(success_msg,error_msg)
						{
							jQuery.ajax({
															url: 'index.php?option=com_jlike&tmpl=component&task=migrateLikes',
															type: 'POST',
															dataType: 'json',
															timeout: 3500,
															error: function(){
																jQuery('#migrate_msg').css("display", "block");
																jQuery('#migrate_msg').addClass("alert alert-error");
																jQuery('#migrate_msg').text(error_msg);
															},
															beforeSend: function(){
																jQuery('#jlike-loading-image').show();
															},
															complete: function(){
																jQuery('#jlike-loading-image').hide();
															},
															success: function(response)
															{
																		jQuery('#migrate_msg').css("display", "block");
																		jQuery('#migrate_msg').addClass("alert alert-success");
																		jQuery('#migrate_msg').text(success_msg);
																		jQuery('#migrate_button').css("display", "none");
															}
							});

						}

				</script>
						<div class="well well-large center">
								<?php
								$limit_populate_link = Route::_(JURI::base() . 'index.php?option=com_jlike&tmpl=component&task=migrateLikes');
								?>
									<div class="alert" id="migrate_msg" style='display:none'></div>
									<div>
										<div class='jlike-loading-image' style="background: url('<?php echo JURI::root() . '/' . 'components' . '/' . 'com_jlike/assets/images/ajax-loading.gif'; ?>') no-repeat scroll 0 0 transparent;display:none;display:none"></div>
										<button class="btn btn-success" style="margin-top:20px;" id="migrate_button" onclick="migratelikes('<?php echo Text::_('COM_JLIKE_MIGRATE_SUCCESS'); ?>','<?php echo Text::_('COM_JLIKE_MIGRATE_ERROR'); ?>')"><?php echo Text::_('Migrate Old Likes data to Jlike'); ?></button>
									</div>
						</div>
<?php } ?>



<form action="" id="adminForm" name="adminForm" method="post" >
<?php if (!empty($this->sidebar)) { ?>
	<div id="j-sidebar-container" class="span2">
		<?php echo $this->sidebar; ?>
	</div>
	<div id="j-main-container" class="span10">
<?php }
								else
								{ ?>
	<div id="j-main-container">
<?php }?>
		<div class="pull-right">
				<div class="jlikeinnerdiv">
					<div class="jlikeinnerdiv"><?php echo Text::_('COM_JLIKE_FROM_DATE'); ?></div>
					<div class="jlikeinnerdiv"><?php	echo HTMLHelper::_('calendar', $this->fromdate, "fromdate", "fromdate", '%Y-%m-%d'); ?></div>
				</div>
				<div class="jlikeinnerdiv">
						<div class="jlikeinnerdiv"> <?php echo Text::_('COM_JLIKE_TO_DATE'); ?></div>
						<div class="jlikeinnerdiv"> <?php	echo HTMLHelper::_('calendar', $this->todate, "todate", "todate", '%Y-%m-%d'); ?></div>
				</div>
				<input type="button" class="btn  btn-small btn-primary" value="Go" onclick="document.adminForm.submit();">
		</div>
		<div style="clear:both"></div>
 <div id="chart_div"></div>
<input type="hidden" name="task" value=""/>
<input type="hidden" name="option" value="com_jlike"/>
<?php echo HTMLHelper::_('form.token'); ?>
</div>
</form>
<?php
$logo_path = '<img src="' . JURI::base() . 'components/com_jlike/assets/images/techjoomla.png" alt="TechJoomla" style="vertical-align:text-top;"/>';
?>
<table style="margin-bottom:5px;width:100%; border-top:thin solid #e5e5e5;table-layout:fixed;">
<tbody>
	<tr>
		<td style="text-align:left;width:25%;">
			<a href="http://techjoomla.com/index.php?option=com_billets&view=tickets&layout=form&Itemid=18" target="_blank"><?php echo Text::_('TechJoomla Support Center'); ?></a>
			<br/>
			<a href="http://extensions.joomla.org/extensions/extension-specific/jomsocial-extensions/16990" target="_blank"><?php echo Text::_("Leave JED Feedback"); ?>
			</a>
			<br/>
			<!-- twitter button code -->
			<a href="https://twitter.com/techjoomla" class="twitter-follow-button" data-show-count="false">Follow @techjoomla</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
			<br/>
			<!-- facebook button code -->
			<div id="fb-root"></div>
			<script>(function(d, s, id) {
			  var js, fjs = d.getElementsByTagName(s)[0];
			  if (d.getElementById(id)) return;
			  js = d.createElement(s); js.id = id;
			  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
			  fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));</script>
			<div class="fb-like" data-href="https://www.facebook.com/techjoomla" data-send="true" data-layout="button_count" data-width="250" data-show-faces="false" data-font="verdana"></div>

			<!-- Place this tag where you want the +1 button to render. -->
			<div class="g-plusone" data-annotation="inline" data-width="300" data-href="https://plus.google.com/102908017252609853905"></div>
			<!-- Place this tag after the last +1 button tag. -->
			<script type="text/javascript">
			(function() {
			var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
			po.src = 'https://apis.google.com/js/plusone.js';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
			})();
			</script>
		</td>

		<td style="text-align:center;width:50%;">
			<?php echo Text::_("COM_JLIKE_INTRO"); ?>
			<br/>
			<?php echo Text::_("COM_JLIKE_COPY_RIGHT"); ?>
			<br />
			<?php echo Text::_("COM_JLIKE_VERSION") . ' ' . $currentversion; ?>
			<br/>
			<span class="latestbutton" onclick="vercheck();">
				<?php echo Text::_('COM_JLIKE_CHECK_LATEST_VERSION'); ?>
			</span>
			<span id='NewVersion' style="padding-top:5px; color:#000000; font-weight:bold; padding-left:5px;"></span>
		</td>

		<td style="text-align:right;width:25%;">
			<a href='http://techjoomla.com/' taget='_blank'>
			<?php echo $logo_path; ?>
			</a>
		</td>
	</tr>
</tbody>
</table>
<?php if (JVERSION < 3.0){ ?>
</div>
<?php } ?>
