<?php

/**
 * This action is responsible for enqueuing any resources such as JavaScript and CSS that are
 * needed for any code generated by the plugin in public ares of the site.
 *
 * @package       com.wolfnet.wordpress
 * @subpackage    action
 * @title         enqueueResources.php
 * @extends       com_greentiedev_wppf_action_action
 * @contributors  AJ Michels (aj.michels@wolfnet.com)
 * @version       1.0
 * @copyright     Copyright (c) 2012, WolfNet Technologies, LLC
 *
 *                This program is free software; you can redistribute it and/or
 *                modify it under the terms of the GNU General Public License
 *                as published by the Free Software Foundation; either version 2
 *                of the License, or (at your option) any later version.
 *
 *                This program is distributed in the hope that it will be useful,
 *                but WITHOUT ANY WARRANTY; without even the implied warranty of
 *                MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *                GNU General Public License for more details.
 *
 *                You should have received a copy of the GNU General Public License
 *                along with this program; if not, write to the Free Software
 *                Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 *
 */
class com_wolfnet_wordpress_action_enqueueResources
extends com_greentiedev_wppf_action_action
{


	/* PROPERTIES ******************************************************************************* */

	/**
	 * This property holds the URL string to the plugin directory. This URL is needed to accurately
	 * define the path to the resource files.
	 *
	 * @type  string
	 *
	 */
	private $pluginUrl = '';


	/* PUBLIC METHODS *************************************************************************** */

	/**
	 * This method is executed by the ActionManager when any hooks that this action is registered to
	 * are encountered.  It is currently handling the following resources: wolfnet.min.js,
	 * jquery.filmStrip.min.js, and wolfnet.min.css.
	 *
	 * @return  void
	 *
	 */
	public function execute ()
	{
		$this->log( 'Action EnqueueResources' );
		$url = $this->getPluginUrl();

		wp_enqueue_script( 'tooltipjs',               $url . 'js/jquery.tooltip.src.js',               array('jquery') );
		wp_enqueue_script( 'imagesloadedjs',          $url . 'js/jquery.imagesloaded.src.js',          array('jquery') );
		wp_enqueue_script( 'mousewheeljs',            $url . 'js/jquery.mousewheel.src.js',            array('jquery') );
		wp_enqueue_script( 'smoothdivscrolljs',       $url . 'js/jquery.smoothDivScroll-1.2.src.js',   array('mousewheeljs','jquery-ui-core','jquery-ui-widget','jquery-effects-core') );
		wp_enqueue_script( 'wolfnetscrollingitemsjs', $url . 'js/jquery.wolfnetScrollingItems.src.js', array('smoothdivscrolljs') );
		wp_enqueue_script( 'wolfnetquicksearchjs',    $url . 'js/jquery.wolfnetQuickSearch.src.js',    array('jquery') );
		wp_enqueue_script( 'wolfnetlistinggridjs',    $url . 'js/jquery.wolfnetListingGrid.src.js',    array('jquery','tooltipjs','imagesloadedjs') );
		wp_enqueue_script( 'wolfnetpropertylistjs',   $url . 'js/jquery.wolfnetPropertyList.src.js',   array('jquery') );
		wp_enqueue_script( 'wolfnetjs',               $url . 'js/wolfnet.src.js',                             array('jquery','tooltipjs') );

		wp_enqueue_style(  'wolfnetcss',              $url . 'css/wolfnet.src.css',                           array(), false, 'screen' );
	}


	/* ACCESSORS ******************************************************************************** */


	/**
	 * GETTER: This method is a getter for the pluginUrl property.
	 *
	 * @return  string  The absolute URL to this plugin's directory.
	 *
	 */
	public function getPluginUrl ()
	{
		return $this->pluginUrl;
	}

	/**
	 * SETTER: This method is a setter for the pluginUrl property.
	 *
	 * @param   string  $url  The absolute URL to this plugin's directory.
	 * @return  void
	 *
	 */
	public function setPluginUrl ( $url )
	{
		$this->pluginUrl = $url;
	}


}
