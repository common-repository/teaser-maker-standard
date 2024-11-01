<?php

// *****************************************************************************
// TEASER-MAKER.APP / APP-DATA.PHP
// (C) 2014 Peter Newman. All Rights Reserved
// *****************************************************************************

    namespace greatKiwi_pluginMaker_appStuff_teaserMaker ;

// =============================================================================
// get_app_data()
// =============================================================================

function get_app_data() {

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_appData\get_app_data()
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // Returns an array holding the application-specific data...
    //
    // RETURNS
    //      o   On SUCCESS!
    //          - - - - - -
    //          ARRAY $app_data
    //
    //      o   On FAILURE!
    //          - - - - - -
    //          $error_message STRING
    // -------------------------------------------------------------------------

    return array(
                'app_slug'                  =>  'teaser_maker'          ,
                'app_title'                 =>  'Teaser Maker'          ,
                'app_title_camel_case'      =>  'teaserMaker'           ,
                'dataset_listing_order'     =>  array(
                                                    'teaser_categories'     ,
                                                    'teasers'               ,
                                                    'teaser_layouts'        ,
                                                    'teaser_styles'         ,
                                                    'teaser_scripts'        ,
                                                    'teaser_settings'
                                                    )
                ) ;

    // =========================================================================
    // That's that!
    // =========================================================================

}

// =============================================================================
// That's that!
// =============================================================================

