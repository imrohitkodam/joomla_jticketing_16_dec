<?php
/**
 * @version    SVN: <svn_id>
 * @package    Jlike
 * @author     Techjoomla <extensions@techjoomla.com>
 * @copyright  Copyright (c) 2009-2015 TechJoomla. All rights reserved.
 * @license    GNU General Public License version 2 or later.
 */

defined ('_JEXEC' ) or die ( 'Restricted access');
use Joomla\CMS\Factory;

use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Router\Route;

require_once JPATH_SITE . '/components/com_jlike/helper.php';

/**
 * ElementItemLink. The item link element class.
 *
 * @package     Jlike
 * @subpackage  Plugin
 * @since       2.2
 */
class Elementjlike_Button extends Element
{
	/**
	 * Checks if the element's value is set.
	 *
	 * @param   object  $params  render parameter
	 *
	 * @return boolean
	 *
	 * @since 1.0
	 */
	public function hasValue($params = array())
	{
		return true;
	}

	/**
	 * Edit. Renders the edit form field.
	 *
	 * @return html
	 *
	 * @since 1.0
	 */
	public function edit()
	{
		return null;
	}

	/**
	 * Renders the element.
	 *
	 * @param   object  $params  render parameter
	 *
	 * @return string
	 *
	 * @since 1.0
	 */
	public function render($params = array())
	{
		$params = $this->app->data->create($params);

		$app = Factory::getApplication();

		if ($app->getName() != 'site')
		{
			return;
		}

		if ($app->scope != 'com_zoo')
		{
			return;
		}

		$item_route = Uri::root() . substr(Route::_($this->app->route->item($this->_item), false), strlen(Uri::base(true)) + 1);

		$zooid   = Factory::getApplication()->input->get('item_id');
		$Itemid  = Factory::getApplication()->input->get('Itemid');
		$element = '';
		$element .= 'com_zoo.category';

		if ($zooid)
		{
			$item = $this->app->table->item->get($zooid);
		}
		else
		{
			$item = $this->app->table->item->get($this->_item->id);
		}

		// Not to show anything related to commenting
		$show_comments = -1;
		$jlike_comments = $params->get('jlike_comments');

		if ($jlike_comments)
		{
			// Show comment count
			$show_comments = 1;
		}

		$show_like_buttons = 1;
		$data = array();

		$data = array();
		$data['cont_id'] = $item->id;
		$data['element'] = $element;
		$data['title'] = $item->name;
		$data['title'] = $item->name;
		$data['url'] = $item_route;
		$data['plg_name'] = 'jlike_zoo';
		$data['show_comments'] = $show_comments;
		$data['show_like_buttons'] = $show_like_buttons;

		/* Factory::getApplication()->input->set('data', json_encode(array('cont_id' => $item->id, 'element' => $element, 'title' => $item->name, 'url' =>
		 *  $item_route, 'plg_name' => 'jlike_zoo', 'show_comments' => $show_comments, 'show_like_buttons' =>
		 * $show_like_buttons)));
		*/

		Factory::getApplication()->input->set('data', json_encode($data));

		require_once JPATH_SITE . '/' . 'components/com_jlike/helper.php';
		$jlikehelperObj = new comjlikeHelper;
		$html           = $jlikehelperObj->showlike();

		return $html;
	}
}
