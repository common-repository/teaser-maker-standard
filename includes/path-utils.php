<?php

// ***************************************************************************
// PATH-UTILS.PHP
// (C) 2012-2013 Peter Newman. All Rights Reserved
// ***************************************************************************

    namespace greatKiwi_byFernTec_teaserMaker_std_v0x1x114_pathUtils ;

// ===========================================================================
// path_fragments()
// ===========================================================================

function path_fragments(
    $path                       ,
    $multi_slash = 'reject'
    ) {

    // -----------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_pathUtils\path_fragments(
    //      $path                       ,
    //      $multi_slash = 'reject'
    //      )
    // - - - - - - - - - - - - - - - - - -
    // Splits a filesystem (relative or absolute) path - at the
    // directory separator ("/" or "\") - into separate strings.
    //
    // o    Works with both Linux ("/") and Windows ("\") path
    //      separators (and these can be mixed in the same input
    //      string).
    //
    // o    $multi_slash must be one of:-
    //          --  'allow'
    //          --  'ignore' or;
    //          --  'reject' (the default)
    //
    // o    In other words, by default, "path_fragments()" COMPLAINS
    //      about multiple (2 or more) consecutive slashes.
    //
    //      Because:-
    //          "/path/to//some-file.ext"
    //
    //      (for example), is an invalid pathspec.
    //
    //      But pathspecs with 2 (or more) consecutive pathspecs sometimes
    //      work (depending on the program or O/S it's supplied to).
    //
    //      So maybe you want "path_fragments()" to accept (or ignore)
    //      these too.
    //
    // o    Example 1: ACCEPT:-
    //
    //          path_fragments(
    //              '/path/to//some-file.ext' ;
    //              'accept'
    //              )
    //
    //          generates:-
    //
    //              array(
    //                  "path"              ,
    //                  "to"                ,
    //                  ""                  ,
    //                  "some-file.ext"
    //                  )
    //
    //          In other words, an EMPTY string is generated between
    //          each pair of slashes.
    //
    // o    Example 2: IGNORE:-
    //
    //          path_fragments(
    //              '/path/to//some-file.ext' ;
    //              'ignore'
    //              )
    //
    //          generates:-
    //
    //              array(
    //                  "path"              ,
    //                  "to"                ,
    //                  "some-file.ext"
    //                  )
    //
    //          In other words, any 2+ consecutive slashes are ignored
    //          (and treated as a single slash)
    //
    // o    Using "path_fragments()" with URLs probably ISN'T a good idea.
    //
    //      Because in:-
    //          http://www.example.com/path/to//some-image.gif
    //
    //      (for example), the FIRST "//" is valid - but the SECOND ISN'T.
    //
    //      So not matter how you set:-
    //          $multi_slash
    //
    //      it's impossible to guarantee accurate results.
    //
    //      USE:
    //          path_fragments_url_friendly()
    //
    //      instead.
    //
    // RETURNS:-
    //      o   ARRAY of strings on SUCCESS
    //      o   Error-message STRING on FAILURE
    // -----------------------------------------------------------------------

    // -----------------------------------------------------------------------
    // $multi_slash ?
    // -----------------------------------------------------------------------

    if ( ! in_array( $multi_slash , array( 'reject' , 'accept' , 'ignore' ) , TRUE ) ) {

        return <<<EOT
PROBLEM detected in "path_fragments()"!<br />
<b>Bad (unrecognised) "multi-slash"</b>:-<br />
<div style="margin-left:3%"><code>{$multi_slash}</code></div>
(Should be one of: "reject", "accept", "ignore".)
EOT;

    }

    // -----------------------------------------------------------------------
    // "REJECT"
    // -----------------------------------------------------------------------

    if ( ! in_array( $multi_slash , array( 'accept' , 'ignore' ) , TRUE ) ) {

        // -------------------------------------------------------------------

        $regex_multiple_directory_separators = '/[\/\\\\]{2,}/' ;

        // -------------------------------------------------------------------

        $number_matches = preg_match(
                            $regex_multiple_directory_separators    ,
                            $path
                            ) ;
                            //  preg_match() returns 1 if the pattern
                            //  matches given subject, 0 if it does not,
                            //  or FALSE if an error occurred.

        // -------------------------------------------------------------------

        if ( $number_matches === FALSE ) {

            return <<<EOT
PROBLEM detected in "path_fragments()"!<br />
<b>"preg_match()" failure</b> checking for multiple,
consecutive directory separators.
EOT;

        }

        // -------------------------------------------------------------------

        if ( $number_matches > 0 ) {

            return <<<EOT
PROBLEM detected in "path_fragments()"!<br />
Supplied "path" has <b>two or more consecutive directory separators</b>.
EOT;

        }

        // -------------------------------------------------------------------

    }

    // -----------------------------------------------------------------------
    // "ACCEPT" / "IGNORE"
    // -----------------------------------------------------------------------

    $regex_directory_separator = '/[\/\\\\]/' ;

    // -----------------------------------------------------------------------

    if ( $multi_slash === 'ignore' ) {
        $flags = PREG_SPLIT_NO_EMPTY ;

    } else {
        $flags = NULL ;

    }

    // -----------------------------------------------------------------------

    return preg_split(
                $regex_directory_separator  ,
                $path                       ,
                NULL                        ,
                $flags
                ) ;
                //  Returns an array containing substrings of subject
                //  split along boundaries matched by pattern.

    // -----------------------------------------------------------------------
    // That's that!
    // -----------------------------------------------------------------------

}

// ===========================================================================
// path_fragments_url_friendly()
// ===========================================================================

function path_fragments_url_friendly(
    $path                       ,
    $multi_slash = 'reject'
    ) {

    // -----------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_pathUtils\path_fragments_url_friendly(
    //      $path                       ,
    //      $multi_slash = 'reject'
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - - - -
    // Like "path_fragments()", but will cope with URL strings (ie; strings
    // that have "://" in them.
    //
    // The double slash ("//") in that character sequence is considered to
    // be OK - and completely ignored as far as $multi-slash is concerned.
    //
    // ---
    //
    // In addition, the "://" is returned as one of the fragments.  Eg:-
    //
    //      path_fragments_url_friendly(
    //          'http://www.example.com/path/to/some-file.txt'
    //          $multi_slash
    //          )
    //
    // returns:-
    //
    //      $path_fragment = array(
    //          'http'              ,
    //          '://'               ,
    //          'www.example.com'   ,
    //          'path'              ,
    //          'to'                ,
    //          'some-file.txt'
    //          )
    //
    // (no matter what $multi_slash is).
    //
    // ---
    //
    // NOTE that because of this, you CAN'T stitch the URL string back
    // together with (eg):-
    //      implode( '/' , $path_fragments )
    //
    // Because you'll get:-
    //      'http/:///www.example.com/path/to/some-file.txt'
    //
    // (which isn't quite right).
    //
    // However:-
    //      $url = str_replace( '/:///' , '://' , implode( '/' , $path_fragments ) ) ;
    //
    // will soon fix this.
    //
    // ---
    //
    // See "path_fragments()" for other/full details.
    //
    // ---
    //
    // RETURNS:-
    //      o   ARRAY of strings on SUCCESS
    //      o   Error-message STRING on FAILURE
    // -----------------------------------------------------------------------

    // -----------------------------------------------------------------------
    // path_fragments(
    //      $path                       ,
    //      $multi_slash = 'reject'
    //      )
    // - - - - - - - - - - - - - - - - -
    // Splits a filesystem (relative or absolute) path - at the
    // directory separator ("/" or "\") - into separate strings.
    //
    // RETURNS:-
    //      o   ARRAY of strings on SUCCESS
    //      o   Error-message STRING on FAILURE
    // -----------------------------------------------------------------------

    // =======================================================================
    // Check for (the first) "://" in the input path - and handle the input
    // string specially if it's found...
    // =======================================================================

    $pos = strpos( $path , '://' ) ;
                //  Returns the position as an integer. If needle is
                //  not found, strpos() will return boolean FALSE.

    // -----------------------------------------------------------------------

    if ( $pos !== FALSE ) {

        // -------------------------------------------------------------------
        // "://" FOUND !
        // -------------------------------------------------------------------

        // -------------------------------------------------------------------
        // Get the path fragments BEFORE the "://"...
        // -------------------------------------------------------------------

        $path_before = substr( $path , 0 , $pos ) ;

        // -------------------------------------------------------------------

        $fragments_before = path_fragments(
                                $path_before        ,
                                $multi_slash
                                ) ;

        // -------------------------------------------------------------------

        if ( ! is_array( $fragments_before ) ) {
            return $fragments_before ;
        }

        // -------------------------------------------------------------------
        // Get the path fragments AFTER the "://"...
        // -------------------------------------------------------------------

        $path_after = substr( $path , $pos + 3 ) ;

        // -------------------------------------------------------------------

        $fragments_after = path_fragments(
                                $path_after     ,
                                $multi_slash
                                ) ;

        // -------------------------------------------------------------------

        if ( ! is_array( $fragments_after ) ) {
            return $fragments_after ;
        }

        // -------------------------------------------------------------------
        // Merge the before and after fragments (and the "://") into a
        // single array...
        // -------------------------------------------------------------------

        $fragments_before[] = '://' ;

        $fragments = array_merge( $fragments_before , $fragments_after ) ;

        // -------------------------------------------------------------------

    } else {

        // -------------------------------------------------------------------
        // NO "://" FOUND!
        // -------------------------------------------------------------------

        $fragments = path_fragments(
                        $path           ,
                        $multi_slash
                        ) ;

        // -------------------------------------------------------------------

        if ( ! is_array( $fragments ) ) {
            return $fragments ;
        }

        // -------------------------------------------------------------------

    }

    // =======================================================================
    // SUCCESS
    // =======================================================================

    return $fragments ;

    // =======================================================================
    // That's that!
    // =======================================================================

}

// ===========================================================================
// clean_path()
// ===========================================================================

/*
function clean_path(
    $path                           ,
    $directory_separator = 'linux'
    ) {

    // -----------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_pathUtils\clean_path(
    //      $path                           ,
    //      $directory_separator = 'linux'
    //      )
    // - - - - - - - - - - - - - - - - - - -
    // Removes double (or multiple) slashes (= directory separtors) from
    // the input path.  And converts slashes/directory separators to
    // either Linux ("/") (the default), Windows ("\") or the PHP detected
    // O/S specific default (DIRECTORY_SEPARATOR).
    //
    // Eg:-
    //      clean_path( 'd:\path/to\\some-file.txt' )
    //      ==>     'd:/path/to/some-file.txt'
    //
    //      clean_path( 'path////to/some-file.txt' )
    //      ==>     'path/to/some-file.txt'
    //
    //      clean_path( 'http://path/to//some-file.txt' )
    //      ==>     'http://path/to/some-file.txt'
    //
    //      clean_path( 'd:\path/to//some-file.txt' , 'windows')
    //      ==>     'd:\path\to\some-file.txt'
    //
    // ---
    //
    // $path can be either a file system pathspec or a URL.
    //
    // $directory_separator MUST be one of:-
    //      o   "linux" | "Linux" (the default)
    //      o   "windows" | "Windows"
    //      o   "auto"
    //
    // NOTE!
    // -----
    // From:  http://alanhogan.com/tips/php/directory-separator-not-necessary
    //
    //      "Portable PHP code: DIRECTORY_SEPARATOR is not necessary
    //
    //      In attempting to write cross-platform, portable PHP code, I used
    //      PHP's DIRECTORY_SEPARATOR constant to write path strings, e.g.
    //      "..".DIRECTORY_SEPARATOR."foo", because the "proper" way to do it on
    //      Windows would be "..\foo" while on everything else (Linux, UNIX, Mac
    //      OS X) it would be "../foo".
    //
    //      Well, as Christian on php.net pointed out and the guys at Web Design
    //      Forums confirmed, that's completely unnecessary.  As long as you use
    //      the forward slash, "/", you'll be OK.  Windows doesn't mind it, and
    //      it's best for *nix operating systems.
    //
    //      (Note that DIRECTORY_SEPARATOR is still useful for things like
    //      explode-ing a path that the system gave you. Thanks to Shadowfiend
    //      for pointing this out.)"
    //
    // RETURNS:-
    // The cleaned path (STRING)
    // -----------------------------------------------------------------------

    // =======================================================================
    // Split the path into fragments...
    // =======================================================================

    // -----------------------------------------------------------------------
    // path_fragments_url_friendly(
    //      $path                       ,
    //      $multi_slash = 'reject'
    //      )
    // - - - - - - - - - - - - - - - - -
    // Like "path_fragments()", but will cope with URL strings (ie; strings
    // that have "://" in them.
    //
    // The double slash ("//") in that character sequence is considered to
    // be OK - and completely ignored as far as $multi-slash is concerned.
    //
    // ---
    //
    // In addition, the "://" is returned as one of the fragments.  Eg:-
    //
    //      path_fragments_url_friendly(
    //          'http://www.example.com/path/to/some-file.txt'
    //          $multi_slash
    //          )
    //
    // returns:-
    //
    //      $path_fragment = array(
    //          'http'              ,
    //          '://'               ,
    //          'www.example.com'   ,
    //          'path'              ,
    //          'to'                ,
    //          'some-file.txt'
    //          )
    //
    // (no matter what $multi_slash is).
    //
    // ---
    //
    // NOTE that because of this, you CAN'T stitch the URL string back
    // together with (eg):-
    //      implode( '/' , $path_fragments )
    //
    // Because you'll get:-
    //      'http/:///www.example.com/path/to/some-file.txt'
    //
    // (which isn't quite right).
    //
    // However:-
    //      $url = str_replace( '/:///' , '://' , implode( '/' , $path_fragments ) ) ;
    //
    // will soon fix this.
    //
    // ---
    //
    // See "path_fragments()" for other/full details.
    //
    // ---
    //
    // RETURNS:-
    //      o   ARRAY of strings on SUCCESS
    //      o   Error-message STRING on FAILURE
    // -----------------------------------------------------------------------

    $multi_slash = 'ignore' ;

    // -----------------------------------------------------------------------

    $fragments = path_fragments_url_friendly(
                    $path           ,
                    $multi_slash
                    ) ;

    // -----------------------------------------------------------------------

    if ( ! is_array( $fragments ) ) {
        return $fragments ;
    }

    // -----------------------------------------------------------------------


    // =======================================================================
    // Then reassemble with the required directory separator...
    // =======================================================================

    $directory_separator_char = array = 'linux'
    $directory_separator = 'linux'




    //      $url = str_replace( '/:///' , '://' , implode( '/' , $path_fragments ) ) ;

    // =======================================================================
    // That's that!
    // =======================================================================

}
*/

// ===========================================================================
// path_above()
// ===========================================================================

function path_above( $haystack , $needle ) {

    // -----------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_pathUtils\path_above(
    //      $haystack   ,
    //      $needle
    //      )
    // - - - - - - - - - - - - - - - -
    // $haystack can be either:-
    //      o  A pathspec like:-
    //             /home/~somesite/elfen/wp-content/plugins/senta/case.php
    //
    // or;
    //      o  A URL like:-
    //             http://www.example.com/
    //             http://www.example.com/path/to/whatever
    //             http://www.example.com/path/to/whatever/somefile.jpg
    //             http://www.example.com/path/to/whatever/myscript.php
    //
    // RETURNS:-
    //
    //      o   $path_above if the specified path WAS found.  Eg:-
    //
    //             path_above( 'http://www.example.com/path/to/whatever' , 'to' )
    //                 ==>  "http://www.example.com/path"
    //
    //      o   FALSE if $needle WASN'T found in $haystack.
    //
    //      o   array( $error_message ) on FAILURE
    //
    // -----------------------------------------------------------------------

    // =======================================================================
    // Split the input string into fragments based on the directory
    // separator...
    // =======================================================================

    // -----------------------------------------------------------------------
    // path_fragments_url_friendly(
    //      $path                       ,
    //      $multi_slash = 'reject'
    //      )
    // - - - - - - - - - - - - - - - - -
    // Like "path_fragments()", but will cope with URL strings (ie; strings
    // that have "://" in them.
    //
    // The double slash ("//") in that character sequence is considered to
    // be OK - and completely ignored as far as $multi-slash is concerned.
    //
    // ---
    //
    // In addition, the "://" is returned as one of the fragments.  Eg:-
    //
    //      path_fragments_url_friendly(
    //          'http://www.example.com/path/to/some-file.txt'
    //          $multi_slash
    //          )
    //
    // returns:-
    //
    //      $path_fragment = array(
    //          'http'              ,
    //          '://'               ,
    //          'www.example.com'   ,
    //          'path'              ,
    //          'to'                ,
    //          'some-file.txt'
    //          )
    //
    // (no matter what $multi_slash is).
    //
    // ---
    //
    // NOTE that because of this, you CAN'T stitch the URL string back
    // together with (eg):-
    //      implode( '/' , $path_fragments )
    //
    // Because you'll get:-
    //      'http/:///www.example.com/path/to/some-file.txt'
    //
    // (which isn't quite right).
    //
    // However:-
    //      $url = str_replace( '/:///' , '://' , implode( '/' , $path_fragments ) ) ;
    //
    // will soon fix this.
    //
    // ---
    //
    // See "path_fragments()" for other/full details.
    //
    // ---
    //
    // RETURNS:-
    //      o   ARRAY of strings on SUCCESS
    //      o   Error-message STRING on FAILURE
    // -----------------------------------------------------------------------

    $multi_slash = 'reject' ;

    // -----------------------------------------------------------------------

    $fragments = path_fragments_url_friendly(
                    $haystack       ,
                    $multi_slash
                    ) ;

    // -----------------------------------------------------------------------

    if ( ! is_array( $fragments ) ) {
        return array( $fragments ) ;
    }

    // =======================================================================
    // Build and return the "path above"...
    // =======================================================================

    $out = '' ;

    $comma = '' ;

    // -----------------------------------------------------------------

    foreach ( $fragments as $this_fragment ) {

        if ( $this_fragment === $needle ) {
            $out = str_replace( '/:///' , '://' , $out ) ;
            return $out ;
        }

        $out .= $comma . $this_fragment ;

        $comma = '/' ;

    }

    // ----------------------------------------------------------------

    return FALSE ;

    // =======================================================================
    // That's that!
    // =======================================================================

}

// ======================================================================
// path_below()
// ======================================================================

function path_below( $haystack , $needle ) {

    // ------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_pathUtils\path_below(
    //      $haystack   ,
    //      $needle
    //      )
    // - - - - - - - - - - - - - - - -
    // $haystack can be either:-
    //     o  A pathspec like:-
    //             /home/~somesite/elfen/wp-content/plugins/senta/case.php
    //
    // or;
    //     o  A URL like:-
    //             http://www.example.com/
    //             http://www.example.com/path/to/whatever
    //             http://www.example.com/path/to/whatever/somefile.jpg
    //             http://www.example.com/path/to/whatever/myscript.php
    //
    // RETURNS:-
    //
    //      o  $path_below if the specified path WAS found.  Eg:-
    //
    //             path_below( 'http://www.example.com/path/to/whatever' , 'to' )
    //                 ==>  "whatever"
    //
    //      o   FALSE if $needle WASN'T found in $haystack.
    //
    //      o   array( $error_message ) on FAILURE
    //
    // -----------------------------------------------------------------

    // =======================================================================
    // Split the input string into fragments based on the directory
    // separator...
    // =======================================================================

    // -----------------------------------------------------------------------
    // path_fragments_url_friendly(
    //      $path                       ,
    //      $multi_slash = 'reject'
    //      )
    // - - - - - - - - - - - - - - - - -
    // Like "path_fragments()", but will cope with URL strings (ie; strings
    // that have "://" in them.
    //
    // The double slash ("//") in that character sequence is considered to
    // be OK - and completely ignored as far as $multi-slash is concerned.
    //
    // ---
    //
    // In addition, the "://" is returned as one of the fragments.  Eg:-
    //
    //      path_fragments_url_friendly(
    //          'http://www.example.com/path/to/some-file.txt'
    //          $multi_slash
    //          )
    //
    // returns:-
    //
    //      $path_fragment = array(
    //          'http'              ,
    //          '://'               ,
    //          'www.example.com'   ,
    //          'path'              ,
    //          'to'                ,
    //          'some-file.txt'
    //          )
    //
    // (no matter what $multi_slash is).
    //
    // ---
    //
    // NOTE that because of this, you CAN'T stitch the URL string back
    // together with (eg):-
    //      implode( '/' , $path_fragments )
    //
    // Because you'll get:-
    //      'http/:///www.example.com/path/to/some-file.txt'
    //
    // (which isn't quite right).
    //
    // However:-
    //      $url = str_replace( '/:///' , '://' , implode( '/' , $path_fragments ) ) ;
    //
    // will soon fix this.
    //
    // ---
    //
    // See "path_fragments()" for other/full details.
    //
    // ---
    //
    // RETURNS:-
    //      o   ARRAY of strings on SUCCESS
    //      o   Error-message STRING on FAILURE
    // -----------------------------------------------------------------------

    $multi_slash = 'reject' ;

    // -----------------------------------------------------------------------

    $fragments = path_fragments_url_friendly(
                    $haystack       ,
                    $multi_slash
                    ) ;

    // -----------------------------------------------------------------------

    if ( ! is_array( $fragments ) ) {
        return array( $fragments ) ;
    }

    // =======================================================================
    // Build and return the "path below"...
    // =======================================================================

    $out = '' ;

    $comma = '' ;

    $needle_found = FALSE ;

    // -----------------------------------------------------------------

    foreach ( $fragments as $this_fragment ) {

        if ( $needle_found ) {

            $out .= $comma . $this_fragment ;

            $comma = '/' ;

        } else {

            if ( $this_fragment === $needle ) {
                $needle_found = TRUE ;
            }

        }

    }

    // -----------------------------------------------------------------

    if ( $needle_found ) {
        return $out ;
    }

    // ----------------------------------------------------------------

    return FALSE ;

    // ----------------------------------------------------------------

}

// =============================================================================
// wp_path2url_or_die()
// =============================================================================

function wp_path2url_or_die( $path ) {

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_pathUtils\wp_path2url_or_die(
    //      $path
    //      )
    // - - - - - - - - - - - - - - - - - - - -
    // RETURNS:-
    //      The requested URL.
    //
    // Unless an error occurs, it which case it issues an error message and
    // exit()s.
    // -------------------------------------------------------------------------

    $url = wp_path2url( $path ) ;
                // RETURNS:-
                //      o   $url on SUCCESS
                //      o   array( $error_message ) on FAILURE

    // -------------------------------------------------------------------------

    if ( is_array( $url ) ) {
        die( $url[0] ) ;
    }

    // -------------------------------------------------------------------------

    return $url ;

    // -------------------------------------------------------------------------

}

// =============================================================================
// wp_path2url()
// =============================================================================

function wp_path2url(
    $path
    ) {

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_pathUtils\
    // wp_path2url(
    //      $path
    //      )
    // - - - - - -
    // RETURNS:-
    //      o   $url on SUCCESS
    //      o   array( $error_message ) on FAILURE
    // -------------------------------------------------------------------------

    // =======================================================================
    // Get the URL of the WordPress root dir...
    // =======================================================================

    // -----------------------------------------------------------------------
    // path_above(
    //      $haystack   ,
    //      $needle
    //      )
    // - - - - - - - - -
    // $haystack can be either:-
    //      o  A pathspec like:-
    //             /home/~somesite/elfen/wp-content/plugins/senta/case.php
    //
    // or;
    //      o  A URL like:-
    //             http://www.example.com/
    //             http://www.example.com/path/to/whatever
    //             http://www.example.com/path/to/whatever/somefile.jpg
    //             http://www.example.com/path/to/whatever/myscript.php
    //
    // RETURNS:-
    //
    //      o   $path_above if the specified path WAS found.  Eg:-
    //
    //             path_above( 'http://www.example.com/path/to/whatever' , 'to' )
    //                 ==>  "http://www.example.com/path"
    //
    //      o   FALSE if $needle WASN'T found in $haystack.
    //
    //      o   array( $error_message ) on FAILURE
    //
    // -----------------------------------------------------------------------

    $result = path_above( get_stylesheet_uri() , 'wp-content' ) ;
                // RETURNS:-
                //      o   $path_above if the specified path fragment WAS
                //          found.
                //      o   FALSE if $needle WASN'T found in $haystack.
                //      o   array( $error_message ) on FAILURE

    // -----------------------------------------------------------------------

    if ( $result === FALSE ) {

        $basename = basename( __FILE__ ) ;
        $function_name = __FUNCTION__ ;

        $msg = <<<EOT
PROBLEM: Path to URL conversion failure!<br />
We can't find the WordPress root directory's URL.
Detected in (function:) "{$function_name}" (file:) "{$basename}"
EOT;

        return array( $msg ) ;

    } elseif ( is_array( $result ) ) {

        return $result ;

    }

    // -----------------------------------------------------------------------

    $wordpress_root_dir_url = $result ;

    // =======================================================================
    // Get the path from the WordPress root dir to the dir/file specified...
    // =======================================================================

    if ( ! defined( 'ABSPATH' ) ) {

        $basename      = basename( __FILE__ ) ;
        $function_name = __FUNCTION__ ;

        $msg = <<<EOT
PROBLEM: Path to URL conversion failure!<br />
We don't seem to be running WordPress!<br />
(ABSPATH is NOT defined.)<br />
Detected in (function:) "{$function_name}" (file:) "{$basename}"
EOT;

        return array( $msg ) ;

    }

    // -----------------------------------------------------------------------

    $wordpress_root_dir_slash = rtrim( ABSPATH , '/' ) . '/' ;

    // -----------------------------------------------------------------------

    if (    substr( $path , 0 , strlen( $wordpress_root_dir_slash ) )
            !==
            $wordpress_root_dir_slash
        ) {

        $basename      = basename( __FILE__ ) ;
        $function_name = __FUNCTION__ ;

        $msg = <<<EOT
PROBLEM: Path to URL conversion failure!<br />
The specified "path" doesn't seem to be a WordPress path.<br />
(It's not in the WordPress directory tree.)
Detected in (function:) "{$function_name}" (file:) "{$basename}"
EOT;

        return array( $msg ) ;

    }

    // -----------------------------------------------------------------------

    $path_part = substr( $path , strlen( $wordpress_root_dir_slash ) ) ;

    // -----------------------------------------------------------------------

    $path_part = str_replace( chr(32) , '%20' , $path_part ) ;
//  $path_part = str_replace( chr(32) , '+'   , $path_part ) ;

    // -----------------------------------------------------------------------

    return  $wordpress_root_dir_url .
            '/' .
            $path_part
            ;

    // =======================================================================
    // That's that!
    // =======================================================================

}

// ===========================================================================
// wp_url2path()
// ===========================================================================

function wp_url2path(
    $url
    ) {

    // -----------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_pathUtils\
    // wp_url2path(
    //      $url
    //      )
    // - - - - - - - - - - - - - - - - -
    // RETURNS:-
    //      o   $pathspec on SUCCESS
    //      o   array( $error_message ) on FAILURE
    // -----------------------------------------------------------------------

    // =======================================================================
    // Get the WordPress root dir...
    // =======================================================================

    if ( ! defined( 'ABSPATH' ) ) {

        $basename      = basename( __FILE__ ) ;
        $function_name = __FUNCTION__ ;

        $msg = <<<EOT
PROBLEM: URL to path conversion failure!<br />
We don't seem to be running WordPress!<br />
(ABSPATH is NOT defined.)<br />
Detected in (function:) "{$function_name}" (file:) "{$basename}"
EOT;

        return array( $msg ) ;

    }

    // -----------------------------------------------------------------------

    $wordpress_root_dir = rtrim( ABSPATH , '/' ) ;

    // =======================================================================
    // Get the path from the WordPress root dir to the file specified by the
    // URL...
    // =======================================================================

    // ------------------------------------------------------------------
    // path_below(
    //      $haystack   ,
    //      $needle
    //      )
    // - - - - - - - - -
    // $haystack can be either:-
    //     o  A pathspec like:-
    //             /home/~somesite/elfen/wp-content/plugins/senta/case.php
    //
    // or;
    //     o  A URL like:-
    //             http://www.example.com/
    //             http://www.example.com/path/to/whatever
    //             http://www.example.com/path/to/whatever/somefile.jpg
    //             http://www.example.com/path/to/whatever/myscript.php
    //
    // RETURNS:-
    //
    //      o  $path_below if the specified path WAS found.  Eg:-
    //
    //             path_below( 'http://www.example.com/path/to/whatever' , 'to' )
    //                 ==>  "whatever"
    //
    //      o   FALSE if $needle WASN'T found in $haystack.
    //
    //      o   array( $error_message ) on FAILURE
    //
    // -----------------------------------------------------------------

    $ignore_case_FALSE = FALSE ;

    // -------------------------------------------------------------------------
    // File in "wp-content" ?
    // -------------------------------------------------------------------------

    $result = path_below( $url , 'wp-content' ) ;
                // RETURNS:-
                //      o   $path_below, if the specified path fragment WAS
                //          found.
                //      o   FALSE if $needle WASN'T found in $haystack.
                //      o   array( $error_message ) on FAILURE

    // ---------------------------------------------------------------------

    if ( is_string( $result ) ) {
        return $wordpress_root_dir . '/wp-content/' . $result ;

    } elseif ( is_array( $result ) ) {
        return $result ;

    }

    // -----------------------------------------------------------------------
    // File in "wp-admin" ?
    // -----------------------------------------------------------------------

    $result = path_below( $url , 'wp-admin' ) ;
                // RETURNS:-
                //      o   $path_below, if the specified path fragment WAS
                //          found.
                //      o   FALSE if $needle WASN'T found in $haystack.
                //      o   array( $error_message ) on FAILURE

    // ---------------------------------------------------------------------

    if ( is_string( $result ) ) {
        return $wordpress_root_dir . '/wp-admin/' . $result ;

    } elseif ( is_array( $result ) ) {
        return $result ;

    }

    // -----------------------------------------------------------------------
    // File in "wp-includes" ?
    // -----------------------------------------------------------------------

    $result = path_below( $url , 'wp-includes' ) ;
                // RETURNS:-
                //      o   $path_below, if the specified path fragment WAS
                //          found.
                //      o   FALSE if $needle WASN'T found in $haystack.
                //      o   array( $error_message ) on FAILURE

    // ---------------------------------------------------------------------

    if ( is_string( $result ) ) {
        return $wordpress_root_dir . '/wp-includes/' . $result ;

    } elseif ( is_array( $result ) ) {
        return $result ;

    }

    // =======================================================================
    // If we get here, then the dir/file pointed to by the URL ISN'T in
    // any of:-
    //      o   wp-admin
    //      o   wp-content
    //      o   wp-includes
    //
    // The only possibilities left are that:-
    //      o   It's in the WordPress root dir itself, or;
    //      o   It's in some other sub-directory of the WordPress root dir.
    // =======================================================================

    //  For now, however, we'll flag it away as:-
    //      URL 2 path conversion failure

    // -------------------------------------------------------------------------

    $basename = basename( __FILE__ ) ;
    $function_name = __FUNCTION__ ;

    $msg = <<<EOT
PROBLEM: URL to path conversion failure!<br />
We can't find the dir/file pointed to by:-
<div style="margin-left:3%; font-weight:bold">{$url}</div>
Detected in (function:) "{$function_name}" (file:) "{$basename}"
EOT;

    return array( $msg ) ;

    // =======================================================================
    // That's that!
    // =======================================================================

}

// ===========================================================================
// wp_url_split()
// ===========================================================================

function wp_url_split(
    $url
    ) {

    // -----------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_pathUtils\wp_url_split(
    //      $url
    //      )
    // - - - - - - - - - - - - - - - - -
    // Split a WP URL into:-
    //      o   The URL to the WordPress root dir, and
    //      o   The path below the WordPress root dir.
    //
    // Eg:-
    //
    //      http://192.168.1.82/acmeinc/wp-content/themes/outrageous/images/logo.gif
    //      -->     URL to WP root dir:  http://192.168.1.82/acmeinc
    //      --> Path below WP root dir:  wp-content/themes/outrageous/images/logo.gif
    //
    //      http://www.example.com/wp-content/themes/outrageous/images/logo.gif
    //      -->     URL to WP root dir:  http://www.example.com
    //      --> Path below WP root dir:  wp-content/themes/outrageous/images/logo.gif
    //
    //      http://101.202.303.404/~acme/wp-content/themes/outrageous/images/logo.gif
    //      -->     URL to WP root dir:  http://101.202.303.404/~acme
    //      --> Path below WP root dir:  wp-content/themes/outrageous/images/logo.gif
    //
    // NOTES!
    // ------
    // 1.   The URL to be split MUST point to a dir/file/link in one of:-
    //          o   wp-admin
    //          o   wp-content
    //          o   wp-includes
    //
    //      Otherwise, we can't reliably determine where the site's WordPress
    //      root directory is.
    //
    // 2.   The URL MUST be that of some dir, file or link.  It CAN'T be that
    //      of a POST or PAGE or the like.
    //
    //      Because these are of the form (eg):-
    //          http://www.example.com/?page_id=57  (Traditional WP URL)
    //      or;
    //          http://www.example.com/about/       (SEO friendly WP URL)
    //
    //      neither of which meets the criteria in Note 1).
    //
    // 3.   Dirs/files in:-
    //      a)  The WordPress root directory, or;
    //      b)  Any sub-directory thereof (apart from "wp-admin", "wp-content"
    //          and "wp-includes"),
    //
    //      also CAN'T be handled.
    //
    //      (Because again, these DON'T meet the criteria of Note 1).
    //
    //      We could perhaps upgrade the routine to cope with these.  But it
    //      starts getting complicated and unreliable.  So for now, dirs/files
    //      in these places won't have their URLs split.
    //
    // 4.   You CAN'T use the following file/directory entry names:-
    //          o   wp-admin
    //          o   wp-content
    //          o   wp-includes
    //
    //      anywhere else in the URLs you want to split.  (Because
    //      obviously, this will may this URL splitting routine).
    //
    // RETURNS:-
    //      o   array( $wordpress_root_dir_url , $path_below ) on SUCCESS
    //      o   $error_message on FAILURE
    // -----------------------------------------------------------------------

    // =======================================================================
    // Get the WordPress root dir...
    // =======================================================================

    if ( ! defined( 'ABSPATH' ) ) {

        $basename      = basename( __FILE__ ) ;
        $function_name = __FUNCTION__ ;

        $msg = <<<EOT
PROBLEM: WordPress URL split failure!<br />
We don't seem to be running WordPress!<br />
(ABSPATH is NOT defined.)<br />
Detected in (function:) "{$function_name}" (file:) "{$basename}"
EOT;

        return array( $msg ) ;

    }

    // -----------------------------------------------------------------------

    $wordpress_root_dir = rtrim( ABSPATH , '/' ) ;

    // =======================================================================
    // Try to split the URL on one of:-
    //      o   wp-admin
    //      o   wp-content
    //      o   wp-includes
    // =======================================================================

    // -----------------------------------------------------------------------
    // path_above(
    //      $haystack   ,
    //      $needle
    //      )
    // - - - - - - - - -
    // $haystack can be either:-
    //      o  A pathspec like:-
    //             /home/~somesite/elfen/wp-content/plugins/senta/case.php
    //
    // or;
    //      o  A URL like:-
    //             http://www.example.com/
    //             http://www.example.com/path/to/whatever
    //             http://www.example.com/path/to/whatever/somefile.jpg
    //             http://www.example.com/path/to/whatever/myscript.php
    //
    // RETURNS:-
    //
    //      o   $path_above if the specified path WAS found.  Eg:-
    //
    //             path_above( 'http://www.example.com/path/to/whatever' , 'to' )
    //                 ==>  "http://www.example.com/path"
    //
    //      o   FALSE if $needle WASN'T found in $haystack.
    //
    //      o   array( $error_message ) on FAILURE
    //
    // -----------------------------------------------------------------------

    $ignore_case_FALSE = FALSE ;

    // -------------------------------------------------------------------------
    // Dir/File in "wp-content" ?
    // -------------------------------------------------------------------------

    $result = path_above( $url , 'wp-content' ) ;
                // RETURNS:-
                //      o   $path_above, if the specified path fragment WAS
                //          found.
                //      o   FALSE if $needle WASN'T found in $haystack.
                //      o   array( $error_message ) on FAILURE

    // ---------------------------------------------------------------------

    if ( is_string( $result ) ) {

        return array(
                    $result                                 ,
                    substr( $url , strlen( $result ) + 1 )
                    ) ;

    } elseif ( is_array( $result ) ) {

        return $result ;

    }

    // -----------------------------------------------------------------------
    // Dir/File in "wp-admin" ?
    // -----------------------------------------------------------------------

    $result = path_above( $url , 'wp-admin' ) ;
                // RETURNS:-
                //      o   $path_above, if the specified path fragment WAS
                //          found.
                //      o   FALSE if $needle WASN'T found in $haystack.
                //      o   array( $error_message ) on FAILURE

    // ---------------------------------------------------------------------

    if ( is_string( $result ) ) {

        return array(
                    $result                                     ,
                    substr( $url , strlen( $result ) + 1 )
                    ) ;

    } elseif ( is_array( $result ) ) {

        return $result ;

    }

    // -----------------------------------------------------------------------
    // File in "wp-includes" ?
    // -----------------------------------------------------------------------

    $result = path_above( $url , 'wp-includes' ) ;
                // RETURNS:-
                //      o   $path_above, if the specified path fragment WAS
                //          found.
                //      o   FALSE if $needle WASN'T found in $haystack.
                //      o   array( $error_message ) on FAILURE

    // ---------------------------------------------------------------------

    if ( is_string( $result ) ) {

        return array(
                    $result                                     ,
                    substr( $url , strlen( $result ) + 1 )
                    ) ;

    } elseif ( is_array( $result ) ) {

        return $result ;

    }

    // =======================================================================
    // If we get here, then the dir/file pointed to by the URL ISN'T in
    // any of:-
    //      o   wp-admin
    //      o   wp-content
    //      o   wp-includes
    //
    // The only possibilities left are that:-
    //      o   It's in the WordPress root dir itself, or;
    //      o   It's in some other sub-directory of the WordPress root dir.
    // =======================================================================

    //  For now, however, we'll flag it away as:-
    //      URL 2 path conversion failure

    // -------------------------------------------------------------------------

    $basename = basename( __FILE__ ) ;
    $function_name = __FUNCTION__ ;

    $msg = <<<EOT
PROBLEM: WordPress URL split failure!<br />
We can't find the dir/file pointed to by:-
<div style="margin-left:3%; font-weight:bold">{$url}</div>
Detected in (function:) "{$function_name}" (file:) "{$basename}"
EOT;

    return array( $msg ) ;

    // =======================================================================
    // That's that!
    // =======================================================================

}

// ===========================================================================
// path_utils__find_ancestor_dir()
// path_utils__find_ancestor_dir_containing()
// ===========================================================================

function path_utils__find_ancestor_dir(
    $start_dir  ,
    $targets
    ) {

    return path_utils__find_ancestor_dir_containing(
                $start_dir  ,
                $targets
                ) ;

}

// ---------------------------------------------------------------------------

function path_utils__find_ancestor_dir_containing(
    $start_dir  ,
    $targets
    ) {

    // -----------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_pathUtils\path_utils__find_ancestor_dir(
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_pathUtils\path_utils__find_ancestor_dir_containing(
    //      $start_dir  ,
    //      $targets
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // Find the ancestor directory (if any), that contains the specified
    // $target dirs and files.
    //
    // ---
    //
    // $start_dir MUST be the target directory or BELOW it.
    //
    // NOTE!  $start_dir must be either a directory or a file.  If it's
    //        a file (eg:-
    //
    //              $dir = path_utils__find_ancestor_dir_containing(
    //                          __FILE__    ,
    //                          $targets
    //                          )
    //
    //        then we start at the directory the file is in.
    //
    // ---
    //
    // $targets is like (eg):-
    //
    //      $targets = array(
    //          'allOf'     =>  array(
    //              'wp-admin'      =>  'dir'       ,
    //              'wp-content'    =>  'dir'       ,
    //              'wp-includes'   =>  'dir'       ,
    //              'index.php'     =>  'file'
    //              )   ,
    //          'anyOf'     =>  array()
    //          )
    //
    // Where both "allOf' and 'anyOf' are OPTIONAL (though at least ONE
    // must be provided).
    //
    // ---
    //
    // RETURNS:-
    //      o   The target directory's pathspec (STRING) - if the target
    //          directory was FOUND
    //      o   FALSE if the target directory WASN'T FOUND
    //      o   array( $error_message_string ) on FAILURE
    // -----------------------------------------------------------------------

    // =======================================================================
    // $start_dir ?
    // =======================================================================

    if ( is_file( $start_dir ) ) {

        $start_dir = dirname( $start_dir ) ;

    } else {

        if ( ! is_dir( $start_dir ) ) {

            $msg = <<<EOT
PROBLEM: "path_utils__find_ancestor_dir_containing()" failure!
"\$start_dir" doesn't exist.
EOT;

            return array( $msg ) ;

        }

    }

    // =======================================================================
    // Search for the target dir...
    // =======================================================================

    $this_dir = $start_dir ;

    // -----------------------------------------------------------------------

    while ( $this_dir !== '' && $this_dir !== '.' ) {

        // ===================================================================
        // HAS ALL OF ?
        // ===================================================================

        $has_all_of = TRUE ;

        // -------------------------------------------------------------------

        if ( isset( $targets['allOf'] ) ) {

            // ---------------------------------------------------------------

            foreach ( $targets['allOf'] as $basename => $type ) {

                // -----------------------------------------------------------

                $pathspec = $this_dir . '/' . $basename ;

                // -----------------------------------------------------------

                if ( $type === 'dir' ) {

                    if ( ! is_dir( $pathspec ) ) {
                        $has_all_of = FALSE ;
                        break ;
                    }

                } elseif ( $type === 'file' ) {

                    if ( ! is_file( $pathspec ) ) {
                        $has_all_of = FALSE ;
                        break ;
                    }

                } else {

                    $msg = <<<EOT
PROBLEM: "path_utils__find_ancestor_dir_containing()" failure!
Bad "\$type" ("{$type}").&nbsp; Must be 'dir' or 'file'.
EOT;

                    return array( $msg ) ;

                }

                // -----------------------------------------------------------

            }

            // ---------------------------------------------------------------

        }

        // -------------------------------------------------------------------

        if ( $has_all_of === TRUE ) {
            return $this_dir ;
        }

        // ===================================================================
        // HAS ANY OF ?
        // ===================================================================

        $has_any_of = FALSE ;

        // -------------------------------------------------------------------

        if ( isset( $targets['anyOf'] ) ) {

            // ---------------------------------------------------------------

            foreach ( $targets['anyOf'] as $basename => $type ) {

                // -----------------------------------------------------------

                $pathspec = $this_dir . '/' . $basename ;

                // -----------------------------------------------------------

                if ( $type === 'dir' ) {

                    if ( is_dir( $pathspec ) ) {
                        $has_any_of = TRUE ;
                        break ;
                    }

                } elseif ( $type === 'file' ) {

                    if ( is_file( $pathspec ) ) {
                        $has_any_of = TRUE ;
                        break ;
                    }

                } else {

                    $msg = <<<EOT
PROBLEM: "path_utils__find_ancestor_dir_containing()" failure!
Bad "\$type" ("{$type}").&nbsp; Must be 'dir' or 'file'.
EOT;

                    return array( $msg ) ;

                }

                // -----------------------------------------------------------

            }

            // ---------------------------------------------------------------

        }

        // -------------------------------------------------------------------

        if ( $has_any_of === TRUE ) {
            return $this_dir ;
        }

        // ===================================================================
        // Repeat with current dir's parent (if there is one)...
        // ===================================================================

        $this_dir = dirname( $this_dir ) ;

        // -------------------------------------------------------------------

    }

    // =======================================================================
    // Target Directory NOT Found
    // =======================================================================

    return FALSE ;

    // =======================================================================
    // That's that!
    // =======================================================================

}

// ===========================================================================
// path_utils__get_tree_root_relative_dirspec()
// ===========================================================================

function path_utils__get_tree_root_relative_dirspec(
    $tree_root_dirspec          ,
    $dir_to_make_relative
    ) {

    // -----------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_pathUtils\path_utils__get_tree_root_relative_dirspec(
    //      $tree_root_dirspec          ,
    //      $dir_to_make_relative
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // RETURNS:-
    //      o   (STRING) $tree_root_relative_dirspec on SUCCESS
    //      o   (ARRAY) array( $error_message ) on FAILURE
    // -----------------------------------------------------------------------

    // -----------------------------------------------------------------------
    // NOTE!
    // -----
    // "substr()" returns the extracted part of string; or FALSE on failure,
    // or an empty string.
    // -----------------------------------------------------------------------

    if (    substr( $dir_to_make_relative , 0 , strlen( $tree_root_dirspec ) )
            !==
            $tree_root_dirspec
        ) {

        $msg = <<<EOT
PROBLEM: "path_utils__get_tree_root_relative_dirspec()" failure!<br />
"\$dir_to_make_relative" doesn't start with "\$tree_root_dirspec".
EOT;

        return array( $msg ) ;

    }

    // -----------------------------------------------------------------------

    $tree_root_dirspec = rtrim( $tree_root_dirspec , '/' ) . '/' ;

    $dir_to_make_relative = rtrim( $dir_to_make_relative , '/' ) . '/' ;

    // -----------------------------------------------------------------------

    $tree_root_relative_dirspec =
        substr( $dir_to_make_relative , strlen( $tree_root_dirspec ) )
        ;

    // -----------------------------------------------------------------------

    $tree_root_relative_dirspec = trim( $tree_root_relative_dirspec , '/' ) ;

    // -----------------------------------------------------------------------

    return $tree_root_relative_dirspec ;

    // =======================================================================
    // That's that!
    // =======================================================================

}

// =============================================================================
// That's that!
// =============================================================================

