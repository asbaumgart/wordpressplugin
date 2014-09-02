<?php

/**
 *
 * @title         listing.php
 * @copyright     Copyright (c) 2012, 2013, WolfNet Technologies, LLC
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
 */

?>

<div id="wolfnet_listing_<?php echo $listing['property_id']; ?>" class="wolfnet_listing" itemscope>
    <a href="<?php echo $listing['property_url']; ?>" rel="follow">
        <span class="wolfnet_listingImage"><img src="<?php echo $listing['thumbnail_url']; ?>" alt="Property for sale at <?php echo $listing['address']; ?>" /></span>
        <span class="wolfnet_price" itemprop="price"><?php echo $listing['listing_price']; ?></span>
        <span class="wolfnet_bed_bath" title="<?php echo $listing['bedsbaths_full']; ?>"><?php echo $listing['bedsbaths']; ?></span>
        <span title="<?php echo $listing['address']; ?>">
            <span class="wolfnet_address"><?php echo $listing['display_address']; ?></span>
            <span class="wolfnet_location" itemprop="locality"><?php echo $listing['location']; ?></span>
            <span class="wolfnet_full_address" itemprop="street-address" style="display:none;"><?php echo $listing['address']; ?></span>
        </span>
        <?php // if (property_exists($listing, 'branding') && ($listing['branding']['brokerLogo'] != '' || $listing['branding']['content'] != '')) { ?>
        <?php // is courtesy_text the correct replacement for $listing->branding->content ? ?>
        <?php if (array_key_exists('branding', $listing) && ($listing['branding']['logo'] != '' || $listing['branding']['courtesy_text'] != '')) { ?>
        <div class="wolfnet_branding">
            <?php if (trim($listing['branding']['logo']) !== '') { ?>
                <span class="wolfnet_brokerLogo<?php echo ($listing['branding']['type']=='idx') ? ' wolfnet_idxLogo' : ''; ?>">
                    <img src="<?php echo $listing['branding']['logo']; ?>" />
                </span>
            <?php } ?>
            <span class="wolfnet_brandingMessage"><?php echo $listing['branding']['courtesy_text']; ?></span>
        </div>
        <?php } ?>
    </a>
</div>
