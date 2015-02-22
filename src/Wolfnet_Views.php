<?php

/**
 * @title         Wolfnet_Views.php
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

class Wolfnet_Views
{

    /* PROPERTIES ******************************************************************************* */

    /**
     * location of images hosted remotely
     * @var string
     */
    public $remoteImages = '//common.wolfnet.com/wordpress/';


    /* CONSTRUCTOR ****************************************************************************** */

    public function __construct()
    {
        $this->templateDir = dirname(__FILE__) . '/template';
    }

    /* Public Methods *************************************************************************** */
    /*  ____        _     _ _        __  __      _   _               _                            */
    /* |  _ \ _   _| |__ | (_) ___  |  \/  | ___| |_| |__   ___   __| |___                        */
    /* | |_) | | | | '_ \| | |/ __| | |\/| |/ _ \ __| '_ \ / _ \ / _` / __|                       */
    /* |  __/| |_| | |_) | | | (__  | |  | |  __/ |_| | | | (_) | (_| \__ \                       */
    /* |_|    \__,_|_.__/|_|_|\___| |_|  |_|\___|\__|_| |_|\___/ \__,_|___/                       */
    /*                                                                                            */
    /* ****************************************************************************************** */

    /* Admin Menus ****************************************************************************** */
    /*                                                                                            */
    /*  /\   _| ._ _  o ._    |\/|  _  ._       _                                                 */
    /* /--\ (_| | | | | | |   |  | (/_ | | |_| _>                                                 */
    /*                                                                                            */
    /* ****************************************************************************************** */

    public function amSettingsPage()
    {
        ob_start(); settings_fields($GLOBALS['wolfnet']->optionGroup); $formHeader = ob_get_clean();
        $productKey = json_decode($GLOBALS['wolfnet']->getProductKey());

        // add the market name
        for($i=1; $i<=count($productKey); $i++) {
            // $productKey[$i-1]->market = strtoupper($GLOBALS['wolfnet']->api->getMarketName($productKey[$i-1]->key));
            $key = $productKey[$i-1]->key;
            $market = $GLOBALS['wolfnet']->getMarketName($key);

            if (!is_wp_error($market)) {
                $productKey[$i-1]->market = strtoupper( $market );
            }
            // $productKey[$i-1]->market = strtoupper( $GLOBALS['wolfnet']->getMarketName( $productKey[$i-1]->key ) );
        }

        $out = $this->parseTemplate('adminSettings.php', array(
            'formHeader' => $formHeader,
            'productKey' => $productKey,
        ));

        echo $out;

        return $out;

    }


    public function amEditCssPage()
    {
        ob_start(); settings_fields($GLOBALS['wolfnet']->CssOptionGroup); $formHeader = ob_get_clean();

        $out = $this->parseTemplate('adminEditCss.php', array(
            'formHeader' => $formHeader,
            'publicCss' => $this->getPublicCss(),
            'adminCss' => $GLOBALS['wolfnet']->admin->getAdminCss(),
        ));

        echo $out;

        return $out;

    }


    public function amSearchManagerPage()
    {
        $key = (array_key_exists("keyid", $_REQUEST)) ? $_REQUEST["keyid"] : "1";
        $productkey = $GLOBALS['wolfnet']->getProductKeyById($key);

        if (!$GLOBALS['wolfnet']->productKeyIsValid($productkey)) {
            $out = $this->parseTemplate('invalidProductKey.php');
        }
        else {

            $out = $this->parseTemplate('adminSearchManager.php', array(
                'searchForm' => ($GLOBALS['wolfnet']->smHttp !== null) ? $GLOBALS['wolfnet']->smHttp['body'] : '',
                'markets' => json_decode($GLOBALS['wolfnet']->getProductKey()),
                'selectedKey' => $key,
                'url' => $GLOBALS['wolfnet']->url,
            ));

        }

        echo $out;

        return $out;

    }


    public function amSupportPage()
    {
        $out = $this->parseTemplate('adminSupport.php', array(
            'imgdir' => $this->remoteImages,
        ));

        echo $out;

        return $out;

    }


    public function getPublicCss()
    {
        return get_option(trim($GLOBALS['wolfnet']->publicCssOptionKey));
    }


    /**
     * This method is used in the context of admin_print_styles to output custom CSS.
     * @return void
     */
    public function adminPrintStyles()
    {
        $adminCss = $GLOBALS['wolfnet']->getAdminCss();
        echo '<style>' . $adminCss . '</style>';

    }


    /* Views ************************************************************************************ */
    /*                                                                                            */
    /* \  / o  _        _                                                                         */
    /*  \/  | (/_ \/\/ _>                                                                         */
    /*                                                                                            */
    /* ****************************************************************************************** */

    public function featuredListingsOptionsFormView(array $args=array())
    {
        $defaultArgs = array(
            'instance_id'     => str_replace('.', '', uniqid('wolfnet_featuredListing_')),
            'markets'         => json_decode($GLOBALS['wolfnet']->getProductKey()),
            'selectedKey'     => (array_key_exists("keyid", $_REQUEST)) ? $_REQUEST["keyid"] : "1",
            );

        $args = array_merge($defaultArgs, $args);

        return $this->parseTemplate('featuredListingsOptions.php', $args);

    }


    public function listingGridOptionsFormView(array $args=array())
    {
        $defaultArgs = array(
            'instance_id'      => str_replace('.', '', uniqid('wolfnet_listingGrid_')),
            'markets'          => json_decode($GLOBALS['wolfnet']->getProductKey()),
            'keyid'            => ''
            );

        $args = array_merge($defaultArgs, $args);

        $args['criteria'] = esc_attr($args['criteria']);

        return $this->parseTemplate('listingGridOptions.php', $args);

    }


    public function quickSearchOptionsFormView(array $args=array())
    {
        $markets = json_decode($GLOBALS['wolfnet']->getProductKey());
        $keyids = array();
        $view = '';

        foreach($markets as $market) {
            array_push($keyids, $market->id);
        }
        $defaultArgs = array(
            'instance_id' => str_replace('.', '', uniqid('wolfnet_quickSearch_')),
            'markets'     => $markets,
            'keyids'      => $keyids,
            'view'        => $view,
            );


        $args = array_merge($defaultArgs, $args);

        return $this->parseTemplate('quickSearchOptions.php', $args);

    }


    public function listingView(array $args=array())
    {
        foreach ($args as $key => $item) {
            $args[$key] = apply_filters('wolfnet_listingView_' . $key, $item);
        }

        return apply_filters('wolfnet_listingView', $this->parseTemplate('listing.php', $args));

    }


    public function listingBriefView(array $args=array())
    {
        foreach ($args as $key => $item) {
            $args[$key] = apply_filters('wolfnet_listingBriefView_' . $key, $item);
        }

        return apply_filters('wolfnet_listingBriefView', $this->parseTemplate('briefListing.php', $args));

    }


    public function listingResultsView(array $args=array())
    {
        foreach ($args as $key => $item) {
            $args[$key] = apply_filters('wolfnet_listingResultsView_' . $key, $item);
        }

        return apply_filters('wolfnet_listingResultsView', $this->parseTemplate('resultsListing.php', $args));

    }


    public function featuredListingView(array $args=array())
    {
        foreach ($args as $key => $item) {
            $args[$key] = apply_filters('wolfnet_featuredListingView_' . $key, $item);
        }

        return apply_filters('wolfnet_featuredListingView', $this->parseTemplate('featuredListings.php', $args));

    }


    public function propertyListView(array $args=array())
    {
        if(!array_key_exists('keyid', $args)) {
            $args['productkey'] = $GLOBALS['wolfnet']->getDefaultProductKey();
        } else {
            $args['productkey'] = $GLOBALS['wolfnet']->getProductKeyById($args["keyid"]);
        }
        $args['itemsPerPage'] = $GLOBALS['wolfnet']->getItemsPerPage();

        $data = $GLOBALS['wolfnet']->apin->sendRequest($args['productkey'], '/search_criteria/sort_option');
        $args['sortOptions'] = $data['responseData']['data']['options'];

        foreach ($args as $key => $item) {
            $args[$key] = apply_filters('wolfnet_propertyListView_' . $key, $item);
        }

        return apply_filters('wolfnet_propertyListView', $this->parseTemplate('propertyList.php', $args));

    }


    public function listingGridView(array $args=array())
    {

        if(!array_key_exists('keyid', $args)) {
            $args['productkey'] = $GLOBALS['wolfnet']->getDefaultProductKey();
        } else {
            $args['productkey'] = $GLOBALS['wolfnet']->getProductKeyById($args["keyid"]);
        }

        $args['itemsPerPage'] = $GLOBALS['wolfnet']->getItemsPerPage();

        // $args['sortOptions'] = $GLOBALS['wolfnet']->apin->sendRequest($args['productkey'], '/search_criteria/sort_option');
        $data = $GLOBALS['wolfnet']->apin->sendRequest($args['productkey'], '/search_criteria/sort_option');
        $args['sortOptions'] = $data['responseData']['data']['options'];

        foreach ($args as $key => $item) {
            $args[$key] = apply_filters('wolfnet_listingGridView_' . $key, $item);
        }

        return apply_filters('wolfnet_listingGridView', $this->parseTemplate('listingGrid.php', $args));

    }


    public function quickSearchView(array $args=array())
    {
        // array containing possible values for "view" arg
        $views = array( "basic" , "legacy");
        //set up a custom css class for the wrapper. default "wolfnet_quickSearch_legacy"
        $args['viewclass'] = "wolfnet_quickSearch_" . ( in_array($args['view'], $views ) ? $args['view'] : "legacy");

        foreach ($args as $key => $item) {
            $args[$key] = apply_filters( 'wolfnet_quickSearchView_' . $key, $item );
        }

        return apply_filters('wolfnet_quickSearchView', $this->parseTemplate('quickSearch.php', $args));

    }


    public function mapView($listingsData, $productKey=null)
    {
        $args = $GLOBALS['wolfnet']->getMapParameters($listingsData, $productKey);
        $args["url"] = $GLOBALS['wolfnet']->url;

        return apply_filters('wolfnet_mapView', $this->parseTemplate('map.php', $args));

    }


    public function hideListingsToolsView($hideId,$showId,$collapseId,$instance_id)
    {
        $args['hideId'] = $hideId;
        $args['showId'] = $showId;
        $args['collapseId'] = $collapseId;
        $args['instance_id'] = $instance_id;

        return apply_filters('wolfnet_hideListingsTools', $this->parseTemplate('hideListingsTools.php', $args));

    }


    public function toolbarView(array $args=array())
    {
        foreach ($args as $key => $item) {
            $args[$key] = apply_filters('wolfnet_toolbarView_' . $key, $item);
        }

        return apply_filters('wolfnet_toolbarView', $this->parseTemplate('toolbar.php', $args));

    }

    public function errorView($error)
    {
        return $this->parseTemplate('error.php', array('error'=>$error));
    }

    public function houseOver($args)
    {

        return $this->parseTemplate('listingHouseover.php', $args);

    }

    /* PRIVATE METHODS ************************************************************************** */
    /*  ____       _            _         __  __      _   _               _                       */
    /* |  _ \ _ __(_)_   ____ _| |_ ___  |  \/  | ___| |_| |__   ___   __| |___                   */
    /* | |_) | '__| \ \ / / _` | __/ _ \ | |\/| |/ _ \ __| '_ \ / _ \ / _` / __|                  */
    /* |  __/| |  | |\ V / (_| | ||  __/ | |  | |  __/ |_| | | | (_) | (_| \__ \                  */
    /* |_|   |_|  |_| \_/ \__,_|\__\___| |_|  |_|\___|\__|_| |_|\___/ \__,_|___/                  */
    /*                                                                                            */
    /* ****************************************************************************************** */

    private function parseTemplate($template, array $vars=array())
    {

        extract($vars, EXTR_OVERWRITE);
        ob_start();
        include $this->templateDir .'/'. $template;
        return ob_get_clean();

    }


}
