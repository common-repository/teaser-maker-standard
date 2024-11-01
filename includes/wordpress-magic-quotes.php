<?php

// *****************************************************************************
// WORDPRESS-MAGIC-QUOTES.PHP
// (C) 2014 Peter Newman. All rights Reserved.
// *****************************************************************************

    namespace greatKiwi_byFernTec_teaserMaker_std_v0x1x114_wordpressMagicQuotes ;

// -----------------------------------------------------------------------------
// OVERVIEW
// ========
// WordPress has the bug/feature that since Version 3.0 at least, "magic
// quotes" are always ON.
//
// Which means that the value returned by:-
//          get_magic_quotes_gpc()
//
// is meaningless. Because under WordPress, "magic quotes" are always ON.
//
// Not only that, but under WordPress 3+, $_SERVER is also magic quoted, in
// addition to $_GET, $_POST and $_COOKIE.
//
// See the following for more details of this:-
//      o   wp_magic_quotes()
//      o   http://codex.wordpress.org/Function_Reference/wp_magic_quotes
//      o   http://wordpress.stackexchange.com/questions/21693/wordpress-and-magic-quotes
// -----------------------------------------------------------------------------

// =============================================================================
// question_magic_quotes_gpc()
// =============================================================================

function question_magic_quotes_gpc() {

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_wordpressMagicQuotes\
    // question_magic_quotes_gpc()
    // - - - - - - - - - - - - - -
    // RETURNS
    //      o   TRUE if $_GET, $_POST and $_COOKIE values have had
    //          "addslashes()" done to them (and thus, need to be run
    //          through "stripslashes()" before use).
    //      o   FALSE otherwise.
    // -------------------------------------------------------------------------

    if (    defined( 'ABSPATH' )
            &&
            function_exists( '\wp_magic_quotes' )       //  since WP 3.0
            &&
            function_exists( '\stripslashes_deep' )     //  since WP 2.0
            &&
            function_exists( '\add_magic_quotes' )      //  since WP 0.71
        ) {
        return TRUE ;
    }

    // -------------------------------------------------------------------------

    return get_magic_quotes_gpc() ;

    // -------------------------------------------------------------------------

}

// =============================================================================
// question_magic_quotes_server()
// =============================================================================

function question_magic_quotes_server() {

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_wordpressMagicQuotes\
    // question_magic_quotes_server()
    // - - - - - - - - - - - - - - -
    // RETURNS
    //      o   TRUE if $_SERVER values have had "addslashes()" done to them
    //          (and thus, need to be run through "stripslashes()" before use).
    //      o   FALSE otherwise.
    // -------------------------------------------------------------------------

    if (    defined( 'ABSPATH' )
            &&
            function_exists( '\wp_magic_quotes' )       //  since WP 3.0
            &&
            function_exists( '\stripslashes_deep' )     //  since WP 2.0
            &&
            function_exists( '\add_magic_quotes' )      //  since WP 0.71
        ) {
        return TRUE ;
    }

    // -------------------------------------------------------------------------

    return FALSE ;

    // -------------------------------------------------------------------------

}

// =============================================================================
// That's that!
// =============================================================================

