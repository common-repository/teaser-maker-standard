<?php

// *****************************************************************************
// SHORTCODES / SHORTCODES.PHP
// (C) 2013 Peter Newman. All Rights Reserved
// *****************************************************************************

    // -------------------------------------------------------------------------
    // WORDPRESS SHORTCODES API - OVERVIEW
    // ===================================
    // From:  http://codex.wordpress.org/Shortcode_API
    //
    // SYNOPSIS
    //
    //      // [bartag foo="foo-value"]
    //      function bartag_func( $atts ) {
    //
    //          extract( shortcode_atts( array(
    //              'foo' => 'something',
    //              'bar' => 'something else',
    //              ), $atts ) );
    //
    //          return "foo = {$foo}";
    //
    //      }
    //
    //      add_shortcode( 'bartag', 'bartag_func' );
    //
    // ---
    //
    // Shortcode attributes are entered like this:
    //      [myshortcode foo="bar" bar="bing"]
    //
    // These attributes will be converted into an associative array like the
    // following, passed to the handler function as its $atts parameter:
    //      array( 'foo' => 'bar', 'bar' => 'bing' )
    //
    // The array keys are the attribute names; array values are the
    // corresponding attribute values. In addition, the zeroeth entry
    // ($atts[0]) will hold the string that matched the shortcode regex, but
    // ONLY IF that is different from the callback name. See the discussion
    // of attributes, below.
    //
    // ---
    //
    // Any string returned (not echoed) by the shortcode handler will be
    // inserted into the post body in place of the shortcode itself.
    // -------------------------------------------------------------------------

    // =========================================================================
    // LOAD the various SHORTCODES used...
    // =========================================================================

    // -------------------------------------------------------------------------
    // NOTE!
    // =====
    // Each of the files included below both:-
    //
    //      o   Defines one or more shortcode handlers, and;
    //
    //      o   Call the WordPress "add_shortcode()" API function, to install
    //          those shortcode handlers.
    // -------------------------------------------------------------------------

    // -------------------------------------------------------------------------
    // STANDARD DATASET MANAGER (for WordPress Front-End)
    // -------------------------------------------------------------------------

    require_once( dirname( __FILE__ ) . '/shortcodes/standard-dataset-manager.php' ) ;

// =============================================================================
// That's that!
// =============================================================================

