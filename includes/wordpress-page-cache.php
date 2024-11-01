<?php

// *****************************************************************************
// INCLUDES / WORDPRESS-PAGE-CACHE.PHP
// (C) 2013 Peter Newman. All Rights Reserved
// *****************************************************************************

    namespace greatKiwi_byFernTec_teaserMaker_std_v0x1x114_wordpressPageCache ;

// =============================================================================
// get_time_to_live()
// =============================================================================

function get_time_to_live() {

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_wordpressPageCache\get_time_to_live()
    // - - - - - - - - - - - - - - - - - - - - - - -
    // RETURNS the max. number of seconds any created page should live.
    // -------------------------------------------------------------------------

    return 3600 ;
        // NOTE!
        // =====
        // Edit the ABOVE line, if you want/need to use a different time to
        // live
        //
        // The DEFAULT time to live is 3600 seconds (= 1 hour).

    // -------------------------------------------------------------------------

}

// =============================================================================
// get_table_name()
// =============================================================================

function get_table_name() {

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_wordpressPageCache\get_table_name()
    // - - - - - - - - - - - - - - - - - - - - - - -
    // RETURNS the Great Kiwi WordPress Page Cache table name...
    // -------------------------------------------------------------------------

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_basepressMysql\prepend_wordpress_table_name_prefix()
    //      $table_name
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // Prepends the WordPress table prefix to the supplied table name, and
    // returns the result.
    //
    // NOTE!
    // =====
    // From:-
    //      http://codex.wordpress.org/Creating_Tables_with_Plugins
    //
    //    "DATABASE TABLE PREFIX
    //    =====================
    //    In the wp-config.php file, a WordPress site owner can define a
    //    database table prefix. By default, the prefix is "wp_", but you'll
    //    need to check on the actual value and use it to define your database
    //    table name. This value is found in the $wpdb->prefix variable. (If
    //    you're developing for a version of WordPress older than 2.0, you'll
    //    need to use the $table_prefix global variable, which is deprecated in
    //    version 2.1)."
    //
    // -------------------------------------------------------------------------

    return  \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_basepressMysql\prepend_wordpress_table_name_prefix(
                'great_kiwi_basepress_page_cache'
                ) ;
                // NOTE!
                // =====
                // Edit the above table name if you want/need a different one
                // (for this particular WordPress web site, for example).
                //
                // The DEFAULT table name (excluding the WordPress table name
                // prefix), is:-
                //      great_kiwi_basepress_page_cache

    // -------------------------------------------------------------------------

}

// =============================================================================
// get_page()
// =============================================================================

function get_page(
    $page_name                      ,
    $page_key                       ,
    $question_session_specific      ,
    $question_remote_ip_specific    ,
    $question_user_agent_specific
    ) {

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_wordpressPageCache\get_page(
    //      $page_name                      ,
    //      $page_key                       ,
    //      $question_session_specific      ,
    //      $question_remote_ip_specific    ,
    //      $question_user_agent_specific
    //      )
    // - - - - - - - - - - - - - - - - - - - -
    // RETURNS the PHP/HTML (or whatever), of the specified cached page.
    //
    // If the page hasn't been cached yet, returns the empty string.
    //
    // NOTES!
    // ======
    // Cached pages are stored in the wordPress MySQL database.  This is to
    // eliminate the file access/permission problems that would occur if we to
    // store the cached pages as files on the disk.
    //
    // RETURNS
    //      On SUCCESS!
    //      - - - - - -
    //      $page_content STRING
    //
    //      On FAILURE!
    //      - - - - - -
    //      array( $error_message STRING )
    // -------------------------------------------------------------------------

    // =========================================================================
    // ERROR CHECKING...
    // =========================================================================

    // -------------------------------------------------------------------------
    // NOTE!
    // =====
    // The reason for checking:-
    //      o   $page_name and;
    //      o   $page_key,
    //
    // is that these variables are often supplied in a URL query string (when
    // displaying the cached page).
    //
    // So we want to minimise the risk of (eg) "sql injection" attacks.
    // -------------------------------------------------------------------------

    // -------------------------------------------------------------------------
    // page_name ?
    // -------------------------------------------------------------------------

    if (    ! is_string( $page_name )
            ||
            trim( $page_name ) === ''
            ||
            strlen( $page_name ) > 255
            ||
            ! \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_stringUtils\ctype_alphanumeric_underscore_dash( $page_name )
        ) {

        //  TODO Return error message if BasePress Admin is the caller...

        return '' ;

    }

    // -------------------------------------------------------------------------
    // page_key ?
    // -------------------------------------------------------------------------

    if (    ! is_string( $page_key )
            ||
            trim( $page_key ) === ''
            ||
            strlen( $page_key ) > 255
            ||
            ! \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_stringUtils\ctype_alphanumeric_underscore_dash( $page_key )
        ) {

        //  TODO Return error message if BasePress Admin is the caller...

        return '' ;

    }

    // -------------------------------------------------------------------------
    // question_session_specific ?
    // -------------------------------------------------------------------------

    if ( ! is_bool( $question_session_specific ) ) {

        //  TODO Return error message if BasePress Admin is the caller...

        return '' ;

    }

    // -------------------------------------------------------------------------
    // question_remote_ip_specific ?
    // -------------------------------------------------------------------------

    if ( ! is_bool( $question_remote_ip_specific ) ) {

        //  TODO Return error message if BasePress Admin is the caller...

        return '' ;

    }

    // -------------------------------------------------------------------------
    // question_user_agent_specific ?
    // -------------------------------------------------------------------------

    if ( ! is_bool( $question_user_agent_specific ) ) {

        //  TODO Return error message if BasePress Admin is the caller...

        return '' ;

    }

    // =========================================================================
    // LOAD the MYSQL SUPPORT...
    // =========================================================================

    require_once( dirname( __FILE__ ) . '/basepress-mysql.php' ) ;

    // =========================================================================
    // Configure the MYSQL ERROR HANDLING...
    // =========================================================================

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_basepressMysql\set_error_handling(
    //      $level                  ,
    //      $question_die_on_error
    //      )
    // - - - - - - - - - - - - - - - - - -
    // Sets:-
    //      $GLOBALS['BASEPRESS']['MYSQL']['error_level']
    //      $GLOBALS['BASEPRESS']['MYSQL']['question_die_on_error']
    //
    // to the specified values.
    //
    // $level must be one of:-
    //
    //      'none'          //  NO error messages at all
    //
    //      'user'          //  Simple generic error messages
    //                      //  suitable for front-end where you
    //                      //  want to keep any info. that might
    //                      //  assist hackers to a minimum.
    //
    //      'developer'     //  Detailed error messages (as much
    //                      //  info. as possible.
    //
    // $question_die_on_error must be TRUE or FALSE.
    //
    // RETURNS
    //      On SUCCESS
    //      - - - - -
    //      TRUE
    //
    //      On FAILURE
    //      - - - - -
    //      $error_message STRING
    // -------------------------------------------------------------------------

    $level = 'user' ;

    $question_die_on_error = FALSE ;

    // -------------------------------------------------------------------------

    $result = \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_basepressMysql\set_error_handling(
                    $level                  ,
                    $question_die_on_error
                    ) ;

    // -------------------------------------------------------------------------

    if ( $result !== TRUE ) {

        //  TODO Return error message if BasePress Admin is the caller...

        return '' ;

    }

    // =========================================================================
    // GET the PAGE CACHE TABLE NAME...
    // =========================================================================

    $page_cache_table_name = get_table_name() ;

    // =========================================================================
    // DOES the PAGE CACHE TABLE EXIST ?
    //
    // If NOT, return the empty string...
    // =========================================================================

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_basepressMysql\table_exists(
    //      $table_name
    //      )
    // - - - - - - - - - - - - - - -
    // RETURNS TRUE or FALSE, depending on whether the table exists or not.
    //
    // NOTE!
    // -----
    // $table_name is an ABSOLUTE table name - with the WordPress table
    // prefix prepended if necessary.
    //
    // Call:-
    //
    //      table_exists(
    //          prepend_wordpress_table_name_prefix( $table_name )
    //          )
    //
    // if you want to supply the table name WITHOUT the WordPress table prefix
    // (and have that prefix automatically prepended for you).
    // -------------------------------------------------------------------------

    if ( \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_basepressMysql\table_exists( $page_cache_table_name ) !== TRUE ) {
        return '' ;
    }

    // =========================================================================
    // Get the SESSION ID to use...
    // =========================================================================

    if ( $question_session_specific ) {

        // ---------------------------------------------------------------------

        if ( session_id() === '' ) {
            session_start() ;
        }

        // ---------------------------------------------------------------------

        $session_id = session_id() ;

        // ---------------------------------------------------------------------

    } else {

        // ---------------------------------------------------------------------

        $session_id = 'any' ;

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // Get the REMOTE IP to use...
    // =========================================================================

    if ( $question_remote_ip_specific ) {

        // ---------------------------------------------------------------------

        if (    ! isset( $_SERVER['REMOTE_ADDR'] )
                ||
                trim( $_SERVER['REMOTE_ADDR'] ) === ''
//              ||
//              ! ctype_ip( $_SERVER['REMOTE_ADDR'] )
            ) {

            //  TODO Return error message if BasePress Admin is the caller...

            return '' ;

        }

        // ---------------------------------------------------------------------

        $remote_ip = $_SERVER['REMOTE_ADDR'] ;

        // ---------------------------------------------------------------------

    } else {

        // ---------------------------------------------------------------------

        $remote_ip = 'any' ;

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // Get the USER AGENT to use...
    // =========================================================================

    if ( $question_user_agent_specific ) {

        // ---------------------------------------------------------------------

        if (    ! isset( $_SERVER['HTTP_USER_AGENT'] )
                ||
                trim( $_SERVER['HTTP_USER_AGENT'] ) === ''
            ) {

            //  TODO Return error message if BasePress Admin is the caller...

            return '' ;

        }

        // ---------------------------------------------------------------------

        $remote_user_agent = $_SERVER['HTTP_USER_AGENT'] ;

        // ---------------------------------------------------------------------

    } else {

        // ---------------------------------------------------------------------

        $remote_user_agent = 'any' ;

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // DOES the REQUESTED RECORD EXIST ?
    //
    // If NOT, return the empty string...
    // =========================================================================

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_basepressMysql\get_zero_or_more_records(
    //      $sql
    //      )
    // - - - - - - - - - - - - - - - - - - - - -
    // NOTES!
    // ======
    // 1.   The INPUT $sql should NOT be escaped.
    //
    // 2.   MySQL Data Types AREN'T PRESERVED!
    //      ----------------------------------
    //      In other words, something stored in the DB as a MySQL INT, WON'T
    //      necessarily be returned as a PHP INT.  It comes back as a STRING.
    //
    //      I haven't checked FLOATs and TIMESTAMPS, etc.  But I assume that
    //      the same applies to them.
    //
    //      Why this happens I'm not sure.  But presumably, since we access
    //      the datavase with the WordPress Wpdb class - it's that class's
    //      fault.
    //
    // RETURNS
    //      On SUCCESS
    //      - - - - -
    //      The 0+ records specified by the SQL string (as a PHP numeric
    //      array of records).  Eg:-
    //
    //          $records = array(
    //              0   =>  array(
    //                          'field_name_1'  =>  <field_value_1>     ,
    //                          'field_name_2'  =>  <field_value_2>     ,
    //                          ...                 ...
    //                          'field_name_N'  =>  <field_value_N>
    //                          )
    //              ...
    //              )
    //
    //      On FAILURE
    //      - - - - -
    //      An error message STRING.
    // -------------------------------------------------------------------------

    $sql = <<<EOT
SELECT `page_content` , `last_modified_server_datetime_UTC`
FROM `{$page_cache_table_name}`
WHERE `page_name`='{$page_name}'
AND `page_key`='{$page_key}'
AND `session_id`='{$session_id}'
AND `remote_ip`='{$remote_ip}'
AND `remote_user_agent`='{$remote_user_agent}'
EOT;

    // -------------------------------------------------------------------------

    $records = \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_basepressMysql\get_zero_or_more_records(
                    $sql
                    ) ;

    // -------------------------------------------------------------------------

    if ( is_string( $records ) ) {

        //  TODO Return error message if BasePress Admin is the caller...

        return '' ;

    }

//pr( $records ) ;

    // =========================================================================
    // If NO RECORDS, return the empty string...
    // =========================================================================

    if ( count( $records ) === 0 ) {
        return '' ;
    }

    // =========================================================================
    // If MORE THAN ONE RECORD, return the empty string...
    // =========================================================================

    if ( count( $records ) > 1 ) {

        //  TODO Return error message if BasePress Admin is the caller...

        return '' ;

    }

    // =========================================================================
    // NOTE!
    // -----
    // If we get here, then there's EXACTLY ONE RECORD.
    // =========================================================================

    $page_record = $records[0] ;

//pr( $page_record ) ;

    // =========================================================================
    // Has the PAGE EXPIRED ?
    // =========================================================================

    if (    ( time() - $page_record['last_modified_server_datetime_UTC'] )
            >
            get_time_to_live()
        ) {

        //  TODO ???
        //
        //  Clear the page ?

        return '' ;

    }

    // =========================================================================
    // SUCCESS!
    // =========================================================================

    return $page_record['page_content'] ;

    // =========================================================================
    // That's that!
    // =========================================================================

}

// =============================================================================
// set_page()
// =============================================================================

function set_page(
    $page_name                      ,
    $question_session_specific      ,
    $question_remote_ip_specific    ,
    $question_user_agent_specific   ,
    $question_page_key              ,
    $page_content
    ) {

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_wordpressPageCache\set_page(
    //      $page_name                      ,
    //      $question_session_specific      ,
    //      $question_remote_ip_specific    ,
    //      $question_user_agent_specific   ,
    //      $question_page_key              ,
    //      $page_content
    //      )
    // - - - - - - - - - - - - - - - - - - - -
    // SAVES the specified PHP/HTML (or whatever) "page_content" into the
    // page cache.
    //
    // NOTES!
    // ======
    // 1.   Cached pages are stored in the wordPress MySQL database.  This is to
    //      eliminate the file access/permission problems that would occur if we
    //      to store the cached pages as files on the disk.
    //
    // 2.   This routine auto-creates the page cache table, if that table
    //      doesn't yet exist.
    //
    // RETURNS
    //      On SUCCESS!
    //      - - - - - -
    //      $page_key STRING (= blank string if $question_page_key = FALSE)
    //
    //      On FAILURE!
    //      - - - - - -
    //      array( $error_message STRING )
    // -------------------------------------------------------------------------

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\dpbt() ;

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $page_name ) ;

    // =========================================================================
    // ERROR CHECKING...
    // =========================================================================

    // -------------------------------------------------------------------------
    // NOTE!
    // =====
    // The reason for checking:-
    //      o   $page_name
    //
    // is that this variable is often supplied in a URL query string (when
    // displaying the cached page).
    //
    // So we want to minimise the risk of (eg) "sql injection" attacks.
    //
    // But we also check this variable now (when saving the page to be
    // cached).  So that we know that the page name used will be OK when
    // the cached page is requested for display.
    // -------------------------------------------------------------------------

    // -------------------------------------------------------------------------
    // page_name ?
    // -------------------------------------------------------------------------

    if (    ! is_string( $page_name )
            ||
            trim( $page_name ) === ''
            ||
            strlen( $page_name ) > 255
            ||
            ! \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_stringUtils\ctype_alphanumeric_underscore_dash( $page_name )
        ) {

        $msg = <<<EOT
PROBLEM:&nbsp; Bad "page_name" (must contain max. 255 alphanumeric, "_" and/or "-" characters only)
Detected in:&nbsp; \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_wordpressPageCache\set_page()
EOT;

        return array( $msg ) ;

    }

    // -------------------------------------------------------------------------
    // question_session_specific ?
    // -------------------------------------------------------------------------

    if ( ! is_bool( $question_session_specific ) ) {

        $msg = <<<EOT
PROBLEM:&nbsp; Bad "question_session_specific" (must be TRUE or FALSE)
Detected in:&nbsp; \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_wordpressPageCache\set_page()
EOT;

        return array( $msg ) ;

    }

    // -------------------------------------------------------------------------
    // question_remote_ip_specific ?
    // -------------------------------------------------------------------------

    if ( ! is_bool( $question_remote_ip_specific ) ) {

        $msg = <<<EOT
PROBLEM:&nbsp; Bad "question_remote_ip_specific" (must be TRUE or FALSE)
Detected in:&nbsp; \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_wordpressPageCache\set_page()
EOT;

        return array( $msg ) ;

    }

    // -------------------------------------------------------------------------
    // question_user_agent_specific ?
    // -------------------------------------------------------------------------

    if ( ! is_bool( $question_user_agent_specific ) ) {

        $msg = <<<EOT
PROBLEM:&nbsp; Bad "question_user_agent_specific" (must be TRUE or FALSE)
Detected in:&nbsp; \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_wordpressPageCache\set_page()
EOT;

        return array( $msg ) ;

    }

    // -------------------------------------------------------------------------
    // question_page_key ?
    // -------------------------------------------------------------------------

    if ( ! is_bool( $question_page_key ) ) {

        $msg = <<<EOT
PROBLEM:&nbsp; Bad "question_page_key" (must be TRUE or FALSE)
Detected in:&nbsp; \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_wordpressPageCache\set_page()
EOT;

        return array( $msg ) ;

    }

    // =========================================================================
    // LOAD the MYSQL SUPPORT...
    // =========================================================================

    require_once( dirname( __FILE__ ) . '/basepress-mysql.php' ) ;

    // =========================================================================
    // Configure the MYSQL ERROR HANDLING...
    // =========================================================================

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_basepressMysql\set_error_handling(
    //      $level                  ,
    //      $question_die_on_error
    //      )
    // - - - - - - - - - - - - - - - - - -
    // Sets:-
    //      $GLOBALS['BASEPRESS']['MYSQL']['error_level']
    //      $GLOBALS['BASEPRESS']['MYSQL']['question_die_on_error']
    //
    // to the specified values.
    //
    // $level must be one of:-
    //
    //      'none'          //  NO error messages at all
    //
    //      'user'          //  Simple generic error messages
    //                      //  suitable for front-end where you
    //                      //  want to keep any info. that might
    //                      //  assist hackers to a minimum.
    //
    //      'developer'     //  Detailed error messages (as much
    //                      //  info. as possible.
    //
    // $question_die_on_error must be TRUE or FALSE.
    //
    // RETURNS
    //      On SUCCESS
    //      - - - - -
    //      TRUE
    //
    //      On FAILURE
    //      - - - - -
    //      $error_message STRING
    // -------------------------------------------------------------------------

    $level = 'user' ;

    $question_die_on_error = FALSE ;

    // -------------------------------------------------------------------------

    $result = \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_basepressMysql\set_error_handling(
                    $level                  ,
                    $question_die_on_error
                    ) ;

    // -------------------------------------------------------------------------

    if ( $result !== TRUE ) {
        return array( $msg ) ;
    }

    // =========================================================================
    // GET the PAGE CACHE TABLE NAME...
    // =========================================================================

    $page_cache_table_name = get_table_name() ;

    // =========================================================================
    // DOES the PAGE CACHE TABLE EXIST ?
    //
    // If NOT, CREATE it...
    // =========================================================================

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_basepressMysql\table_exists(
    //      $table_name
    //      )
    // - - - - - - - - - - - - - - -
    // RETURNS TRUE or FALSE, depending on whether the table exists or not.
    //
    // NOTE!
    // -----
    // $table_name is an ABSOLUTE table name - with the WordPress table
    // prefix prepended if necessary.
    //
    // Call:-
    //
    //      table_exists(
    //          prepend_wordpress_table_name_prefix( $table_name )
    //          )
    //
    // if you want to supply the table name WITHOUT the WordPress table prefix
    // (and have that prefix automatically prepended for you).
    // -------------------------------------------------------------------------

    if ( \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_basepressMysql\table_exists( $page_cache_table_name ) !== TRUE ) {

        // =====================================================================
        // CREATE "PAGE CACHE" TABLE
        // =====================================================================

        $sql = <<<EOT
CREATE TABLE {$page_cache_table_name}
(   id                                  INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
    created_server_datetime_UTC         INT UNSIGNED NULL ,
    last_modified_server_datetime_UTC   INT UNSIGNED NULL ,
    page_name                           TINYTEXT NULL ,
    session_id                          TINYTEXT NULL ,
    page_key                            TINYTEXT NULL ,
    remote_ip                           TINYTEXT NULL ,
    remote_user_agent                   TINYTEXT NULL ,
    page_content                        LONGBLOB NULL
)
EOT;

        // ---------------------------------------------------------------------

        global $wpdb ;

        // ---------------------------------------------------------------------

        $number_records_affected = $wpdb->query( $sql ) ;
                                        //  The function returns an integer
                                        //  corresponding to the number of rows
                                        //  affected/selected.  If there is a
                                        //  MySQL error, the function will
                                        //  return FALSE.

        // ---------------------------------------------------------------------

        if ( $number_records_affected === FALSE ) {

            $msg = <<<EOT
PROBLEM:&nbsp; Couldn't create page cache table (#1)
Detected in:&nbsp; \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_wordpressPageCache\set_page()
EOT;

            return array( $msg ) ;

        }

        // ---------------------------------------------------------------------
        // On SUCCESS:-
        //      $wpdb->query()
        //
        // seems to return TRUE (ie; it returns the boolean value "1").
        // ---------------------------------------------------------------------

//pr( $number_records_affected ) ;
//echo "\n" , gettype( $number_records_affected ) , "\n" ;

        // ---------------------------------------------------------------------

        if (    gettype( $number_records_affected ) !== 'boolean'
                ||
                $number_records_affected != 1
            ) {

            $msg = <<<EOT
PROBLEM:&nbsp; Couldn't create page cache table (#2)
Detected in:&nbsp; \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_wordpressPageCache\set_page()
EOT;

            return array( $msg ) ;

        }

        // ---------------------------------------------------------------------

        $question_database_table_just_added = TRUE ;

        // ---------------------------------------------------------------------

    }

    // -------------------------------------------------------------------------

    if ( \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_basepressMysql\table_exists( $page_cache_table_name ) !== TRUE ) {

        $msg = <<<EOT
PROBLEM:&nbsp; Couldn't create page cache table (#3)
Detected in:&nbsp; \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_wordpressPageCache\set_page()
EOT;

        return array( $msg ) ;

    }

    // =========================================================================
    // Get the SESSION ID to use...
    // =========================================================================

    if ( $question_session_specific ) {

        // ---------------------------------------------------------------------

        if ( session_id() === '' ) {
            session_start() ;
        }

        // ---------------------------------------------------------------------

        $session_id = session_id() ;

        // ---------------------------------------------------------------------

    } else {

        // ---------------------------------------------------------------------

        $session_id = 'any' ;

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // Get the REMOTE IP to use...
    // =========================================================================

    if ( $question_remote_ip_specific ) {

        // ---------------------------------------------------------------------

        if (    ! isset( $_SERVER['REMOTE_ADDR'] )
                ||
                trim( $_SERVER['REMOTE_ADDR'] ) === ''
//              ||
//              ! ctype_ip( $_SERVER['REMOTE_ADDR'] )
            ) {

            $msg = <<<EOT
PROBLEM saving cached page:&nbsp; No or bad "remote ip"
Detected in:&nbsp; \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_wordpressPageCache\set_page()
EOT;

            return array( $msg ) ;

        }

        // ---------------------------------------------------------------------

        $remote_ip = $_SERVER['REMOTE_ADDR'] ;

        // ---------------------------------------------------------------------

    } else {

        // ---------------------------------------------------------------------

        $remote_ip = 'any' ;

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // Get the USER AGENT to use...
    // =========================================================================

    if ( $question_user_agent_specific ) {

        // ---------------------------------------------------------------------

        if (    ! isset( $_SERVER['HTTP_USER_AGENT'] )
                ||
                trim( $_SERVER['HTTP_USER_AGENT'] ) === ''
//              ||
//              ! ctype_ip( $_SERVER['HTTP_USER_AGENT'] )
            ) {

            $msg = <<<EOT
PROBLEM saving cached page:&nbsp; No or bad "user agent"
Detected in:&nbsp; \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_wordpressPageCache\set_page()
EOT;

            return array( $msg ) ;

        }

        // ---------------------------------------------------------------------

        $remote_user_agent = $_SERVER['HTTP_USER_AGENT'] ;

        // ---------------------------------------------------------------------

    } else {

        // ---------------------------------------------------------------------

        $remote_user_agent = 'any' ;

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // Get the PAGE KEY to use...
    // =========================================================================

    if ( $question_page_key ) {

        // ---------------------------------------------------------------------
        // NOTE!
        // =====
        // Page key may be max. 255 alphanumeric, "_" and "-" characters.
        // ---------------------------------------------------------------------

        // -------------------------------------------------------------------------
        // string uniqid ([ string $prefix = "" [, bool $more_entropy = false ]] )
        // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
        // Gets a prefixed unique identifier based on the current time in
        // microseconds.
        //
        //      prefix
        //          Can be useful, for instance, if you generate identifiers
        //          simultaneously on several hosts that might happen to generate
        //          the identifier at the same microsecond.
        //
        //          With an empty prefix, the returned string will be 13 characters
        //          long. If more_entropy is TRUE, it will be 23 characters.
        //
        //      more_entropy
        //          If set to TRUE, uniqid() will add additional entropy (using the
        //          combined linear congruential generator) at the end of the return
        //          value, which increases the likelihood that the result will be
        //          unique.
        //
        // Returns the unique identifier, as a string.
        //
        // (PHP 4, PHP 5)
        // -------------------------------------------------------------------------

        $prefix = '' ;
        $more_entropy = TRUE ;

        // ---------------------------------------------------------------------

        $page_key = uniqid( $prefix , $more_entropy ) ;
                        //  23 characters

        // -------------------------------------------------------------------------

        $page_key = str_replace( '.' , '' , $page_key ) ;
                        //  Get rid of the "." that $more_entropy = TRUE adds.

        // -------------------------------------------------------------------------
        // string openssl_random_pseudo_bytes ( int $length [, bool &$crypto_strong ] )
        // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
        // Generates a string of pseudo-random bytes, with the number of bytes
        // determined by the length parameter.
        //
        // It also indicates if a cryptographically strong algorithm was used to
        // produce the pseudo-random bytes, and does this via the optional
        // crypto_strong parameter. It's rare for this to be FALSE, but some systems
        // may be broken or old.
        //
        //      length
        //          The length of the desired string of bytes. Must be a positive
        //          integer. PHP will try to cast this parameter to a non-null
        //          integer to use it.
        //
        //      crypto_strong
        //          If passed into the function, this will hold a boolean value that
        //          determines if the algorithm used was "cryptographically strong",
        //          e.g., safe for usage with GPG, passwords, etc. TRUE if it did,
        //          otherwise FALSE
        //
        // Returns the generated string of bytes on success, or FALSE on failure.
        //
        // (PHP 5 >= 5.3.0)
        // -------------------------------------------------------------------------

        if ( function_exists( 'openssl_random_pseudo_bytes' ) ) {

            // ---------------------------------------------------------------------

            $length = 80 ;

            $binary = openssl_random_pseudo_bytes ( $length ) ;

            // ---------------------------------------------------------------------

            if ( $binary !== FALSE ) {

                $page_key .= '-' . bin2hex( $binary ) ;

            }

            // ---------------------------------------------------------------------

        }

        // -------------------------------------------------------------------------
        // int mt_rand ( void )
        // int mt_rand ( int $min , int $max )
        // - - - - - - - - - - - - - - - - - -
        // Many random number generators of older libcs have dubious or unknown
        // characteristics and are slow. By default, PHP uses the libc random number
        // generator with the rand() function. The mt_rand() function is a drop-in
        // replacement for this. It uses a random number generator with known
        // characteristics using the »  Mersenne Twister, which will produce random
        // numbers four times faster than what the average libc rand() provides.
        //
        // If called without the optional min, max arguments mt_rand() returns a
        // pseudo-random value between 0 and mt_getrandmax(). If you want a random
        // number between 5 and 15 (inclusive), for example, use mt_rand(5, 15).
        //
        //  min
        //      Optional lowest value to be returned (default: 0)
        //
        //  max
        //      Optional highest value to be returned (default: mt_getrandmax())
        //
        // RETURNS
        // A random integer value between min (or 0) and max (or mt_getrandmax(),
        // inclusive), or FALSE if max is less than min.
        //
        // (PHP 4, PHP 5)
        // -------------------------------------------------------------------------

        while ( TRUE ) {

            $rand = mt_rand() ;

            if ( ( strlen( $page_key ) + strlen( $rand ) + 1 ) > 255 ) {
                break ;
            }

            $page_key .= '-' . $rand ;

        }

        // ---------------------------------------------------------------------

    } else {

        // ---------------------------------------------------------------------

        $page_key = '' ;

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // SAVE the PAGE...
    // =========================================================================

    // -------------------------------------------------------------------------
    // NOTE!
    // =====
    // If there's an existing record we can re-use, we re-use that.
    //
    // Otherwise, we add a new record to the database.
    // -------------------------------------------------------------------------

    $sql = <<<EOT
SELECT id
FROM `{$page_cache_table_name}`
WHERE `page_name`='{$page_name}'
AND `session_id`='{$session_id}'
AND `remote_ip`='{$remote_ip}'
AND `remote_user_agent`='{$remote_user_agent}'
EOT;

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_basepressMysql\get_zero_or_more_records(
    //      $sql
    //      )
    // - - - - - - - - - - - - - - - - - - - - -
    // NOTES!
    // ======
    // 1.   The INPUT $sql should NOT be escaped.
    //
    // 2.   MySQL Data Types AREN'T PRESERVED!
    //      ----------------------------------
    //      In other words, something stored in the DB as a MySQL INT, WON'T
    //      necessarily be returned as a PHP INT.  It comes back as a STRING.
    //
    //      I haven't checked FLOATs and TIMESTAMPS, etc.  But I assume that
    //      the same applies to them.
    //
    //      Why this happens I'm not sure.  But presumably, since we access
    //      the datavase with the WordPress Wpdb class - it's that class's
    //      fault.
    //
    // RETURNS
    //      On SUCCESS
    //      - - - - -
    //      The 0+ records specified by the SQL string (as a PHP numeric
    //      array of records).  Eg:-
    //
    //          $records = array(
    //              0   =>  array(
    //                          'field_name_1'  =>  <field_value_1>     ,
    //                          'field_name_2'  =>  <field_value_2>     ,
    //                          ...                 ...
    //                          'field_name_N'  =>  <field_value_N>
    //                          )
    //              ...
    //              )
    //
    //      On FAILURE
    //      - - - - -
    //      An error message STRING.
    // -------------------------------------------------------------------------

    $records = \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_basepressMysql\get_zero_or_more_records(
                    $sql
                    ) ;

    // -------------------------------------------------------------------------

    if ( is_string( $records ) ) {
        return array( $records ) ;
    }

    // -------------------------------------------------------------------------

    if ( count( $records ) === 0 ) {

        // =====================================================================
        // ADD NEW RECORD...
        // =====================================================================

        // -------------------------------------------------------------------------
        // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_basepressMysql\add_record(
        //      $table_name         ,
        //      $raw_record_data
        //      )
        // - - - - - - - - - - - - - - - - - - - - - - - - - - - -
        // $raw_record_data should be like:-
        //
        //      $raw_record_data = array(
        //          'field_name_1'  =>  <field_value_1>     ,
        //          ...
        //          'field_name_N'  =>  <field_value_N>
        //          )
        //
        // In other words, $raw_record_data must be an associative ARRAY of
        //      field name  =>  field_value
        //
        // pairs.  Where:-
        //
        // 1.   At least ONE field must be specified.
        //
        // 2.   Field values can be any of the following PHP data types:-
        //          STRING
        //          INT
        //          FLOAT
        //          TRUE    (stored as 1 in the DB)
        //          FALSE   (stored as 0 in the DB)
        //          NULL    (stored as NULL in the DB)
        //
        //      PHP ARRAY and OBJECT type fields AREN'T allowed.
        //
        // 3.   You DON'T have to supply INT and FLOAT values as PHP
        //      INTs or FLOATS.  They can be supplied as PHP STRINGS
        //      (eg; from $_GET and/or $_POST).  And MySQL will
        //      automatically convert them (before storing them).
        //
        //      NOTE!
        //      -----
        //      Every value that "add_record()" supplies to MySQL will
        //      be supplied in STRING format.  So putting (eg):-
        //          $_GET['id']
        //
        //      into $raw_record_data like:-
        //          $raw_record_data['id'] = (int) $_GET['id']
        //
        //      is pointless.  Since "add_record()" will simply do:-
        //          (string) $raw_record_data['id']
        //
        //      to it before supplying it to MySQL.
        //
        // 4.   The field values MUST NOT be SQL escaped.  You MUST supply
        //      the RAW input data (even the raw $_GET and $_POST data
        //      entered by the user).  And "add_record()" will escape it
        //      for you.
        //
        // ---
        //
        // RETURNS either:-
        //      o   The new record's record ID (as PHP INT) on SUCCESS
        //      o   An error message STRING on FAILURE
        // -------------------------------------------------------------------------

        $now = time() ;

        // ---------------------------------------------------------------------

        $raw_record_data = array(
            'created_server_datetime_UTC'       =>  $now                ,
            'last_modified_server_datetime_UTC' =>  $now                ,
            'page_name'                         =>  $page_name          ,
            'session_id'                        =>  $session_id         ,
            'remote_ip'                         =>  $remote_ip          ,
            'remote_user_agent'                 =>  $remote_user_agent  ,
            'page_key'                          =>  $page_key           ,
            'page_content'                      =>  $page_content
            ) ;

        // ---------------------------------------------------------------------

        $result = \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_basepressMysql\add_record(
                        $page_cache_table_name      ,
                        $raw_record_data
                        ) ;

        // ---------------------------------------------------------------------

        if ( is_string( $result ) ) {
            return $result ;
        }

        // ---------------------------------------------------------------------

    } else {

        // =====================================================================
        // UPDATE EXISTING RECORD...
        // =====================================================================

        // -------------------------------------------------------------------------
        // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_basepressMysql\update_exactly_one_record_by_id(
        //      $table_name         ,
        //      $raw_record_data    ,
        //      $record_id
        //      )
        // - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
        // $raw_record_data should be like:-
        //
        //      $raw_record_data = array(
        //          'field_name_1'  =>  <field_value_1>     ,
        //          ...
        //          'field_name_N'  =>  <field_value_N>
        //          )
        //
        // In other words, $raw_record_data must be an associative ARRAY of
        //      field name  =>  field_value
        //
        // pairs.  Where:-
        //
        // 1.   At least ONE field must be specified.
        //
        // 2.   Field values can be any of the following PHP data types:-
        //          STRING
        //          INT
        //          FLOAT
        //          TRUE    (stored as 1 in the DB)
        //          FALSE   (stored as 0 in the DB)
        //          NULL    (stored as NULL in the DB)
        //
        //      PHP ARRAY and OBJECT type fields aren't allowed (and
        //      will cause an error-message return)
        //
        // 3.   You DON'T have to supply INT and FLOAT values as PHP
        //      INTs or FLOATS.  They can be supplied as PHP STRINGS
        //      (eg; from $_GET and/or $_POST).  And MySQL will
        //      automatically convert them (before storing them).
        //
        //      NOTE!
        //      -----
        //      Every value that "update_record()" supplies to MySQL will
        //      be supplied in STRING format.  So putting (eg):-
        //          $_GET['id']
        //
        //      into $raw_record_data like:-
        //          $raw_record_data['id'] = (int) $_GET['id']
        //
        //      is pointless.  Since "add_record()" will simply do:-
        //          (string) $raw_record_data['id']
        //
        //      to it before supplying it to MySQL.
        //
        // 4.   The field values MUST NOT be SQL escaped.  You MUST supply
        //      the RAW input data (even the raw $_GET and $_POST data
        //      entered by the user).  And "add_record()" will escape it
        //      for you.
        //
        // NOTE!
        // =====
        // $raw_record_data DOESN'T have to include ALL the fields in the record.
        // Only those whoose value you want to update (= set/change).
        //
        // ---
        //
        // $record_id should be a MySQL record id (1+).
        //
        // NOTE that the "id" field name is assumed to be "id" (lowercase).
        //
        // ---
        //
        // RETURNS either:-
        //      o   TRUE on SUCCESS
        //      o   An error message STRING on FAILURE
        // -------------------------------------------------------------------------

//          'page_name'                         =>  $page_name          ,
//          'session_id'                        =>  $session_id         ,
//          'remote_ip'                         =>  $remote_ip          ,
//          'remote_user_agent'                 =>  $remote_user_agent  ,

        $raw_record_data = array(
            'last_modified_server_datetime_UTC' =>  time()              ,
            'page_key'                          =>  $page_key           ,
            'page_content'                      =>  $page_content
            ) ;

        // ---------------------------------------------------------------------

        $result = \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_basepressMysql\update_exactly_one_record_by_id(
                        $page_cache_table_name      ,
                        $raw_record_data            ,
                        $records[0]['id']
                        ) ;

        // ---------------------------------------------------------------------

        if ( is_string( $result ) ) {
            return $result ;
        }

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // SUCCESS!
    // =========================================================================

    return $page_key ;

    // =========================================================================
    // That's that!
    // =========================================================================

}

// =============================================================================
// That's that!
// =============================================================================

