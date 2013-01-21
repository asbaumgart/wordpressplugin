<?php

/**
 * This is an HTML template file for the Grid Widget. This template is meant to wrap a
 * set of listing views. This file should ideally contain very little PHP.
 *
 * @package       com.wolfnet.wordpress
 * @subpackage    listing.template
 * @title         listingGrid.php
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

<div id="<?php echo $instanceId; ?>" class="wolfnet_widget wolfnet_listingGrid">

	<?php if ( array_key_exists( 'title', $options ) && trim( $options['title']['value'] ) != '' ) { ?>

		<h2><?php echo $options['title']['value']; ?></h2>

	<?php } ?>

	<?php echo ( isset($listingContent) ) ? $listingContent : 'No Listings to Display.'; ?>
</div>

<div class="wolfnet_clearfix"></div>

<script type="text/javascript">

	if ( typeof jQuery != 'undefined' ) {

		var usesPagination = "<?php echo $options['title']['paginated']; ?>";

		jQuery( document ).ready( function () {
			
			if (usesPagination == true) {
				jQuery( '#<?php echo $instanceId; ?>' ).wolfnetPaginationToolbar();
			}

			jQuery( '#<?php echo $instanceId; ?>' ).wolfnetResultsToolbar();

			jQuery( '#<?php echo $instanceId; ?>' ).wolfnetListingGrid();
			
			jQuery( '#<?php echo $instanceId; ?>' ).wolfnetResultsToolbar();

			if (usesPagination == true) {
				jQuery( '#<?php echo $instanceId; ?>' ).wolfnetPaginationToolbar();
			}

		} );

	} /* END: If jQuery Exists */

</script>
