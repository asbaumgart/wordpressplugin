<?php

/**
 * This is the filmStripWidget object. This object inherites from the base WP_Widget object and 
 * defines the display and functionality of this specific widget.
 * 
 * @see http://codex.wordpress.org/Widgets_API
 * @see http://core.trac.wordpress.org/browser/tags/3.3.2/wp-includes/widgets.php
 * 
 * @package			com.mlsfinder.wordpress.listing
 * @title			featuredListingsShortcode.php
 * @extends			com_ajmichels_wppf_shortcode_shortcode
 * @contributors	AJ Michels (aj.michels@wolfnet.com)
 * @version			1.0
 * @copyright		Copyright (c) 2012, WolfNet Technologies, LLC
 * 
 */

class com_mlsfinder_wordpress_listing_featuredListingsShortcode
extends com_ajmichels_wppf_shortcode_shortcode
{
	
	
	/* PROPERTIES ******************************************************************************* */
	
	public $tag = 'FeaturedListings';
	
	/**
	 * This property holds an array of different options that are available for each widget instance.
	 *
	 * @type	array
	 * 
	 */
	protected $attributes = array('wait' => false, 'waitLen' => 1, 'speed' => 50 );
	
	
	/* PUBLIC METHODS *************************************************************************** */
	
	public function execute ( $attr, $content = null ) {
		$data = array(
					'listings'	=> $this->getListingService()->getListings(), 
					'options'	=> $this->getAttributesData( $attr )
					);
		$this->getListingFilmStripView()->out( $data );
	}
	
	
	/* ACCESSORS ******************************************************************************** */
	
	public function getListingService ()
	{
		return $this->listingService;
	}
	
	
	public function setListingService ( com_mlsfinder_wordpress_listing_service $service )
	{
		$this->listingService = $service;
	}
	
	
	public function getListingFilmStripView ()
	{
		return $this->listingFilmStripView;
	}
	
	
	public function setListingFilmStripView ( com_ajmichels_wppf_interface_iView $view )
	{
		$this->listingFilmStripView = $view;
	}
	
	
}