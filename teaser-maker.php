<?php

/*
	Plugin Name: Teaser Maker Std v0.1.114
	Plugin URI: http://ferntechnology.com/
    Description: Quickly create "teasers", that point to articles/pages/content (etc) on either your own and/or external sites.
	Author: Fern Technology
	Version: 0.1.114
	Version Date: 12 Jul 2014
    Copyright: (C) 2014 Peter Newman. All Rights Reserved
	Author URI: http://ferntechnology.com/
	Text Domain: teaser-maker
	Domain Path: /lang
*/

// *****************************************************************************
// TEASER-MAKER / TEASER-MAKER.PHP
// (C) 2013-2014 Peter Newman. All Rights Reserved.
// *****************************************************************************

    // =========================================================================
    // Testing/Debugging...
    // =========================================================================

    // -------------------------------------------------------------------------
    // <plugin_root_dir>/test-debug.php
    // SYNOPSIS
    // ================================
    // Defines:-
    //
    //      o   pr( $value , [ $name = NULL ] )
    //
    // All in the namespace:-
    //      greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug
    // -------------------------------------------------------------------------

    require_once( dirname( __FILE__ ) . '/test-debug.php' ) ;

    // =========================================================================
    // Load the APPS API (if necessary), and the PLUGIN PROPER...
    // =========================================================================

    $filespec = dirname( __FILE__ ) . '/teaser-maker-proper.php' ;

    // -------------------------------------------------------------------------

    if ( ! is_file( $filespec ) ) {

        require_once( dirname( __FILE__ ) . '/apps-api.php' ) ;

        $filespec = dirname( __FILE__ ) . '/app-defs/teaser-maker.app/plugin.stuff/teaser-maker-proper.php' ;

    }

    // -------------------------------------------------------------------------

    require_once( $filespec ) ;

// =============================================================================
// That's that!
// =============================================================================

