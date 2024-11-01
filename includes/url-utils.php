<?php

// *****************************************************************************
// INCLUDES / URL-UTILS.PHP
// (C) 2013 Peter Newman. All Rights Reserved
// *****************************************************************************

    namespace greatKiwi_byFernTec_teaserMaker_std_v0x1x114_urlUtils ;

// =============================================================================
// get_query_adjusted_current_page_url()
// =============================================================================

function get_query_adjusted_current_page_url(
    $query_changes         = array()    ,
    $question_amp          = FALSE      ,
    $question_die_on_error = FALSE
    ) {

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_urlUtils\get_query_adjusted_current_page_url(
    //      $query_changes = array()        ,
    //      $question_amp = FALSE           ,
    //      $question_die_on_error = FALSE
    //      ) ;
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // Attempts to retrieve the current page URL from $_SERVER.
    //
    // If successful, returns the URL with the query part adjusted as
    // requested.
    //
    // RETURNS
    //      o   On SUCCESS!
    //          -----------
    //          $query_adjusted_current_page_url STRING
    //
    //      o   On FAILURE!
    //          -----------
    //          If $question_die_on_error = TRUE
    //              Doesn't return
    //          If $question_die_on_error = FALSE
    //              array( $error_message STRING )
    // -------------------------------------------------------------------------

    // =========================================================================
    // GET the CURRENT PAGE URL...
    // =========================================================================

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_urlUtils\get_current_page_url(
    //      $question_die_on_error = FALSE
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // Attempts to retrieve the current page URL from $_SERVER.
    //
    // RETURNS
    //      o   On SUCCESS!
    //          -----------
    //          $current_page_url STRING
    //
    //      o   On FAILURE!
    //          -----------
    //          If $question_die_on_error = TRUE
    //              Doesn't return
    //          If $question_die_on_error = FALSE
    //              array( $error_message STRING )
    // -------------------------------------------------------------------------

    $result = get_current_page_url(
                    $question_die_on_error
                    ) ;

    // -------------------------------------------------------------------------

    if ( is_array( $result ) ) {
        return $result ;
    }

    // =========================================================================
    // ADJUST the QUERY STRING...
    // =========================================================================

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_urlUtils\adjust_query(
    //      $input_url                  ,
    //      $query_changes = array()    ,
    //      $question_amp = FALSE
    //      )
    // - - - - - - - - - - - - - - - - -
    // Takes an input URL and adjusts it's query params as specified.
    //
    // ---
    //
    // $query_changes is like:-
    //
    //      $query_changes = array(
    //                          'name1'     =>  NULL
    //                          'name2'     =>  'xxx'
    //                          )
    //
    // If the value is NULL, then the query parameter is removed (if it
    // exists).  Otherwise, the query parameter is set (silently overwriting
    // any existing value).
    //
    // ---
    //
    // RETURNS:-
    //      o   STRING $adjusted_url on SUCCESS
    //      o   ARRAY( $error_message ) on FAILURE
    // -------------------------------------------------------------------------

    $result = adjust_query(
                    $result             ,
                    $query_changes      ,
                    $question_amp
                    ) ;

    // -------------------------------------------------------------------------

    if (    is_array( $result )
            &&
            $question_die_on_error
        ) {
        die( $result[0] ) ;
    }

    // -------------------------------------------------------------------------

    return $result ;

    // =========================================================================
    // That's that!
    // =========================================================================

}

// =============================================================================
// get_current_page_url()
// =============================================================================

function get_current_page_url(
    $question_die_on_error = FALSE
    ) {

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_urlUtils\get_current_page_url(
    //      $question_die_on_error = FALSE
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // Attempts to retrieve the current page URL from $_SERVER.
    //
    // RETURNS
    //      o   On SUCCESS!
    //          -----------
    //          $current_page_url STRING
    //
    //      o   On FAILURE!
    //          -----------
    //          If $question_die_on_error = TRUE
    //              Doesn't return
    //          If $question_die_on_error = FALSE
    //              array( $error_message STRING )
    // -------------------------------------------------------------------------

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $_SERVER = array(
    //          [SERVER_SOFTWARE]       =>  Apache/2.2.21 (Unix) DAV/2 mod_ssl/2.2.21 OpenSSL/1.0.0c PHP/5.3.8 mod_apreq2-20090110/2.7.1 mod_perl/2.0.5 Perl/v5.10.1
    //          [REQUEST_URI]           =>  /plugdev/wp-admin/admin.php?page=wooDeals&action=add-batch&promotion_id=5219d0422b4f1
    //          [UNIQUE_ID]             =>  UhvU-H8AAQEAAA19Nl4AAAAC
    //          [HTTP_HOST]             =>  localhost
    //          [HTTP_USER_AGENT]       =>  Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:23.0) Gecko/20100101 Firefox/23.0
    //          [HTTP_ACCEPT]           =>  text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8
    //          [HTTP_ACCEPT_LANGUAGE]  =>  en-US,en;q=0.5
    //          [HTTP_ACCEPT_ENCODING]  =>  gzip, deflate
    //          [HTTP_REFERER]          =>  http://localhost/plugdev/wp-admin/admin.php?page=wooDeals&action=add-batch&promotion_id=5219d0422b4f1
    //          [HTTP_COOKIE]           =>  xxx
    //          [HTTP_CONNECTION]       =>  keep-alive
    //          [HTTP_CACHE_CONTROL]    =>  max-age=0
    //          [CONTENT_TYPE]          =>  application/x-www-form-urlencoded
    //          [CONTENT_LENGTH]        =>  133
    //          [PATH]                  =>  /usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin
    //          [SERVER_SIGNATURE]      =>  xxx
    //          [SERVER_NAME]           =>  localhost
    //          [SERVER_ADDR]           =>  127.0.0.1
    //          [SERVER_PORT]           =>  80
    //          [REMOTE_ADDR]           =>  127.0.0.1
    //          [DOCUMENT_ROOT]         =>  /opt/lampp/htdocs
    //          [SERVER_ADMIN]          =>  you@example.com
    //          [SCRIPT_FILENAME]       =>  /opt/lampp/htdocs/plugdev/wp-admin/admin.php
    //          [REMOTE_PORT]           =>  50136
    //          [GATEWAY_INTERFACE]     =>  CGI/1.1
    //          [SERVER_PROTOCOL]       =>  HTTP/1.1
    //          [REQUEST_METHOD]        =>  POST
    //          [QUERY_STRING]          =>  page=wooDeals&action=add-batch&promotion_id=5219d0422b4f1
    //          [SCRIPT_NAME]           =>  /plugdev/wp-admin/admin.php
    //          [PHP_SELF]              =>  /plugdev/wp-admin/admin.php
    //          [REQUEST_TIME]          =>  1377555708
    //          )
    //
    // -------------------------------------------------------------------------

    $fn = __FUNCTION__ ;

    $ns = __NAMESPACE__ ;

    // -------------------------------------------------------------------------

    $url = 'http' ;

    // -------------------------------------------------------------------------

    if (    isset( $_SERVER['HTTPS'] )
            &&
            $_SERVER['HTTPS'] === 'on'
        ) {
        $url = 'https' ;

    } elseif ( isset( $_SERVER['PROTOCOL'] ) ) {

        $protocol_components = explode( '/' , $_SERVER['PROTOCOL'] ) ;

        if ( count( $protocol_components ) > 0 ) {

            $protocol = trim( $protocol_components[0] ) ;

            if (    $protocol !== ''
                    &&
                    ctype_alpha( $protocol )
                ) {
                $url = strtolower( $protocol ) ;
            }

        }

    }

    // -------------------------------------------------------------------------

    $url .= '://' ;

    // -------------------------------------------------------------------------

    //  TODO Username and password

    // -------------------------------------------------------------------------

    if ( isset( $_SERVER['HTTP_HOST'] ) ) {
        $url .= $_SERVER['HTTP_HOST'] ;

    } elseif ( isset( $_SERVER['SERVER_NAME'] ) ) {
        $url .= $_SERVER['SERVER_NAME'] ;

    } elseif ( isset( $_SERVER['SERVER_ADDR'] ) ) {
        $url .= $_SERVER['SERVER_ADDR'] ;

    } else {

        $msg = <<<EOT
PROBLEM:&nbsp; Can't find domain/host name for current page
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        if ( $question_die_on_error ) {
            die( $msg ) ;

        } else {
            return array( $msg ) ;

        }

    }

    // -------------------------------------------------------------------------

    if (    isset( $_SERVER['SERVER_PORT'] )
            &&
            $_SERVER['SERVER_PORT'] != 80
        ) {
        $url .= ':' . $_SERVER['SERVER_PORT'] ;
    }

    // -------------------------------------------------------------------------

    if ( ! isset( $_SERVER['REQUEST_URI'] ) ) {

        //  TODO    Try to get path, query and fragment separately
        //          (instead of throwing error).

        $msg = <<<EOT
PROBLEM:&nbsp; No REQUEST_URI for current page
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        if ( $question_die_on_error ) {
            die( $msg ) ;

        } else {
            return array( $msg ) ;

        }

    }

    // -------------------------------------------------------------------------

    $url .= $_SERVER['REQUEST_URI'] ;

    // -------------------------------------------------------------------------

    return $url ;

    // -------------------------------------------------------------------------

}

// =============================================================================
// adjust_query()
// =============================================================================

function adjust_query(
    $input_url                  ,
    $query_changes = array()    ,
    $question_amp = FALSE
    ) {

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_urlUtils\adjust_query(
    //      $input_url                  ,
    //      $query_changes = array()    ,
    //      $question_amp = FALSE
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // Takes an input URL and adjusts it's query params as specified.
    //
    // ---
    //
    // $query_changes is like:-
    //
    //      $query_changes = array(
    //                          'name1'     =>  NULL
    //                          'name2'     =>  'xxx'
    //                          )
    //
    // If the value is NULL, then the query parameter is removed (if it
    // exists).  Otherwise, the query parameter is set (silently overwriting
    // any existing value).
    //
    // ---
    //
    // RETURNS:-
    //      o   STRING $adjusted_url on SUCCESS
    //      o   ARRAY( $error_message ) on FAILURE
    // -------------------------------------------------------------------------

    // =========================================================================
    // Init.
    // =========================================================================

    $fn = __FUNCTION__ ;

    $ns = __NAMESPACE__ ;

    // =========================================================================
    // Split the input URL into it's components...
    // =========================================================================

    // -------------------------------------------------------------------------
    // mixed parse_url ( string $url [, int $component = -1 ] )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // This function parses a URL and returns an associative array containing
    // any of the various components of the URL that are present.
    //
    // This function is not meant to validate the given URL, it only breaks it
    // up into the above listed parts. Partial URLs are also accepted,
    // parse_url() tries its best to parse them correctly.
    //
    //      url
    //          The URL to parse.  Invalid characters are replaced by _.
    //
    //      component
    //          Specify one of PHP_URL_SCHEME, PHP_URL_HOST, PHP_URL_PORT,
    //          PHP_URL_USER, PHP_URL_PASS, PHP_URL_PATH, PHP_URL_QUERY or
    //          PHP_URL_FRAGMENT to retrieve just a specific URL component as a
    //          string (except when PHP_URL_PORT is given, in which case the
    //          return value will be an integer).
    //
    // RETURNS
    //      On seriously malformed URLs, parse_url() may return FALSE.
    //
    //      If the component parameter is omitted, an associative array is
    //      returned. At least one element will be present within the array.
    //      Potential keys within this array are:
    //
    //          scheme - e.g. http
    //          host
    //          port
    //          user
    //          pass
    //          path
    //          query - after the question mark ?
    //          fragment - after the hashmark #
    //
    // If the component parameter is specified, parse_url() returns a string (or
    // an integer, in the case of PHP_URL_PORT) instead of an array. If the
    // requested component doesn't exist within the given URL, NULL will be
    // returned.
    // -------------------------------------------------------------------------

//pr( $input_url ) ;

    $url_components = parse_url( $input_url ) ;

    // -------------------------------------------------------------------------

    if ( $url_components === FALSE ) {

        $msg = <<<EOT
PROBLEM:&nbsp; "adjust_query()" seems to have been an invalid URL
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        return array( $msg ) ;

    }

//pr( $url_components ) ;

    // =========================================================================
    // Parse the input QUERY STRING (if there is one)...
    // =========================================================================

    $query_in = array() ;

    // -------------------------------------------------------------------------

    if ( isset( $url_components['query'] ) ) {

        // -------------------------------------------------------------------------
        // void parse_str ( string $str [, array &$arr ] )
        // - - - - - - - - - - - - - - - - - - - - - - - -
        // Parses str as if it were the query string passed via a URL and sets
        // variables in the current scope.
        //
        // Note:    To get the current QUERY_STRING, you may use the variable
        //          $_SERVER['QUERY_STRING']. Also, you may want to read the section
        //          on variables from external sources.
        //
        // Note:    The magic_quotes_gpc setting affects the output of this
        //          function, as parse_str() uses the same mechanism that PHP uses
        //          to populate the $_GET, $_POST, etc. variables.
        //
        //      str
        //          The input string.
        //
        //      arr
        //          If the second parameter arr is present, variables are stored in
        //          this variable as array elements instead.
        //
        // No value is returned.
        // -------------------------------------------------------------------------

        parse_str( $url_components['query'] , $query_in ) ;

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // UPDATE the QUERY string...
    // =========================================================================

    $query_out = $query_in ;

    // -------------------------------------------------------------------------

    foreach ( $query_changes as $name => $value ) {

        if ( $value === NULL ) {
            unset( $query_out[ $name ] ) ;

        } else {
            $query_out[ $name ] = $value ;

        }

    }

    // =========================================================================
    // Return the result...
    // =========================================================================

    // -------------------------------------------------------------------------
    //          scheme - e.g. http
    //          host
    //          port
    //          user
    //          pass
    //          path
    //          query - after the question mark ?
    //          fragment - after the hashmark #
    // -------------------------------------------------------------------------

    // -------------------------------------------------------------------------
    //  Basic URL format...
    //      scheme://domain:port/path?query_string#fragment_id
    // -------------------------------------------------------------------------

    // -------------------------------------------------------------------------
    //  Username and password...
    //      It is possible to specify a username (and password!) in a URL. For
    //      instance, when you specify an ftp: URL, your browser automatically
    //      logs in as user "anonymous" to the ftp server being connected to.
    //      You can specify a different username to use with the following
    //      syntax:
    //
    //          ftp://username@hostname/
    //
    //      Assuming a password is required, your browser will then prompt you
    //      for one.
    //
    //      It is even possible, but inadvisable, to put a password in a URL:
    //
    //          ftp://username:password@hostname/
    // -------------------------------------------------------------------------

    $url = '' ;

    // -------------------------------------------------------------------------

    if ( isset( $url_components['scheme'] ) ) {
        $url = $url_components['scheme'] . '://' ;
    }

    // -------------------------------------------------------------------------

    $at = '' ;

    // -------------------------------------------------------------------------

    if ( isset( $url_components['user'] ) ) {
        $url .= $url_components['user'] ;
        $at = '@' ;
    }

    // -------------------------------------------------------------------------

    if ( isset( $url_components['pass'] ) ) {
        $url .= ':' . $url_components['pass'] ;
        $at = '@' ;
    }

    // -------------------------------------------------------------------------

    if ( isset( $url_components['host'] ) ) {
        $url .= $at . $url_components['host'] ;
    }

    // -------------------------------------------------------------------------

    if ( isset( $url_components['port'] ) ) {
        $url .= ':' . $url_components['port'] ;
    }

    // -------------------------------------------------------------------------

    if ( isset( $url_components['path'] ) ) {
        $url .= $url_components['path'] ;
    }

    // -------------------------------------------------------------------------

    $query = '' ;

    $comma = '?' ;

    if ( $question_amp ) {
        $amp = '&amp;' ;
    } else {
        $amp = '&' ;
    }

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $query_out ) ;

    foreach ( $query_out as $name => $value ) {
        $query .= $comma . $name . '=' . urlencode( $value ) ;
        $comma = $amp ;
    }

    // -------------------------------------------------------------------------

    $url .= $query ;

    // -------------------------------------------------------------------------

    if ( isset( $url_components['fragment'] ) ) {
        $url .= '#' . $url_components['fragment'] ;
    }

    // -------------------------------------------------------------------------

    return $url ;

    // =========================================================================
    // That's that!
    // =========================================================================

}

// =============================================================================
// That's that!
// =============================================================================

