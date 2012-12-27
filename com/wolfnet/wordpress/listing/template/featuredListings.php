<?php

/**
 * This is an HTML template file for the Listing Film Strip Widget. This template is meant to wrap a
 * set of listing views. This file should ideally contain very little PHP.
 *
 * @package       com.wolfnet.wordpress
 * @subpackage    listing.template
 * @title         featuredListings.php
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

?>

<?php if ( array_key_exists( 'title', $options ) && trim( $options['title']['value'] ) != '' ) { ?>
	<h2><?php echo $options['title']['value']; ?></h2>
<?php } ?>

<div id="<?php echo $instanceId; ?>" class="wolfnet_widget wolfnet_featuredListings">
	<?php echo ( isset($listingContent) ) ? $listingContent : 'No Listings to Display.'; ?>
</div>

<script type="text/javascript">

	if ( typeof jQuery != 'undefined' ) {

		jQuery( document ).ready( function () {

			jQuery( '#<?php echo $instanceId; ?>' ).wolfnetScrollingItems( {
				'autoPlay'  : <?php echo $autoPlay; ?>,
				'direction' : '<?php echo $direction; ?>',
				'speed'     : <?php echo $speed; ?>
			} );

		} );

	} /* END: If jQuery Exists */

</script>
