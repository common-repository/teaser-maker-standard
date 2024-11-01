<?php

// *****************************************************************************
// GREAT-KIWI / APPS-API.PHP
// (C) 2014 Peter Newman. All Rights Reserved.
// *****************************************************************************

    namespace greatKiwi_byFernTec_teaserMaker_std_v0x1x114_appsAPI ;

// =============================================================================
// OVERVIEW!
// ---------
// This file:-
//      a)  Must go in the WordPress plugin's root directory, and;
//      b)  Must be required/included when the plugin starts.
//
// It provides a base set of function so that the plugin itself - and/or any
// "app" defined within the plugin - can find the core directories and files
// (etc), that it needs to run.
//
// NOTES!
// ------
// 1.   The functions defined in this file (and it's includes), are all
//      defined in the:-
//          greatKiwi/appsAPI
//      namespace (so that they're easy to call).
// 2.   The __FILE__ argument to many of these functions is so that...
// =============================================================================

    // -------------------------------------------------------------------------
    // <plugin_root_dir>/apps-api.php
    // - - - - - - - - - - - - - - -
    // Defines:-
    //
    //      get_plugin_root_dir_basename_raw()
    //
    //      get_plugin_slug_dashed()
    //      get_plugin_slug_underscored()
    //      get_plugin_title()
    //      get_plugin_camel_name()
    //      get_plugin_version_raw()
    //      get_plugin_version_alnum()
    //
    //      get_plugin_root_dir()
    //      convert_root_relative_plugin_pathspec_2_absolute()
    //      get_plugins_app_defs_dir()
    //      get_plugins_includes_dir()
    //      get_single_apps_dot_app_dir()
    //      get_core_plugapp_dirs()
    //
    // All in the:-
    //      greatKiwi_byFernTec_teaserMaker_std_v0x1x114_appsAPI
    // namespace.
    //
    // And where:-
    //      get_core_plugapp_dirs()
    //
    // returns:-
    //      array(
    //          'plugin_root_dir'                   =>  "xxx"   ,
    //          'plugins_includes_dir'              =>  "xxx"   ,
    //          'plugins_app_defs_dir'              =>  "xxx"   ,
    //          'dataset_manager_includes_dir'      =>  "xxx"   ,
    //          'apps_dot_app_dir'                  =>  "xxx"   ,
    //          'apps_plugin_stuff_dir'             =>  "xxx"
    //          )
    // -------------------------------------------------------------------------

// =============================================================================
// get_plugin_root_dir_basename_raw()
// =============================================================================

function get_plugin_root_dir_basename_raw() {
    return basename( dirname( __FILE__ ) ) ;
        //  Eg:-
        //  o   research-assistant
        //  o   basepress-logger-v0.1
}

    // -------------------------------------------------------------------------
    // PLUGIN DETAILS FIELD FIXING
    // :::::::::::::::::::::::::::
    // If the FROM file is a PHP file, then we replace any of the following
    // strings encountered:-
    //
    //      "[-*-PLUGIN.DETAILS..SLUG.UNDERSCORED--]"
    //          Eg:  "teaser_maker"
    //              get_plugin_slug_underscored()
    //
    //      "[-*-PLUGIN.DETAILS..SLUG.DASHED--]"
    //          Eg:  "teaser-maker"
    //              get_plugin_slug_dashed()
    //
    //      "[-*-PLUGIN.DETAILS..TITLE--]"
    //          Eg:  "Teaser Maker"
    //              get_plugin_title()
    //
    //      "[-*-PLUGIN.DETAILS..CAMEL.NAME--]"
    //          Eg:  "teaserMaker"
    //              get_plugin_camel_name()
    //
    //      "[-*-PLUGIN.DETAILS..BASE.VERSION.NUMBER.WITH.DOTS--]"
    //          Eg:  "0.1"
    //              get_plugin_base_version_number_with_dots()
    //
    //      "[-*-PLUGIN.DETAILS..BASE.VERSION.NUMBER.DATE.STRING--]"
    //          Eg:  "5 May 2014"
    //              get_plugin_base_version_number_date_string()
    //
    //      "[-*-PLUGIN.DETAILS..SUB.VERSION.NUMBER--]"
    //          Eg:  "123"
    //              get_plugin_sub_version_number()
    //
    //      "[-*-PLUGIN.DETAILS..FULL.VERSION.NUMBER.WITH.DOTS--]"
    //          Eg:  "0.1.123"
    //              get_plugin_full_version_number_with_dots()
    //
    //      "[-*-PLUGIN.DETAILS..BASE.VERSION.NUMBER.ALNUM--]"
    //          Eg:  "0x1"
    //              get_plugin_base_version_number_alnum()
    //
    //      "[-*-PLUGIN.DETAILS..FULL.VERSION.NUMBER.ALNUM--]"
    //          Eg:  "0x1x123"
    //              get_plugin_full_version_number_alnum()
    //
    //      "[-*-PLUGIN.DETAILS..VERSION.SLUG--]"
    //          Eg:  "std"
    //              get_plugin_version_slug()
    //
    //      "[-*-PLUGIN.DETAILS..VERSION.SHORT.TITLE--]"
    //          Eg:  "Std"
    //              get_plugin_version_short_title()
    //
    //      "[-*-PLUGIN.DETAILS..VERSION.LONG.TITLE--]"
    //          Eg:  "Standard"
    //              get_plugin_version_long_title()
    //
    //      "[-*-PLUGIN.DETAILS..CAMEL.AND.VERSION.NAMES.UNDERSCORED--]"
    //          Eg:  "teaserMaker_std"
    //              get_plugin_camel_and_version_names_underscored()
    //
    //      "[-*-PLUGIN.DETAILS..CAMEL.AND.VERSION.NAMES.DASHED--]"
    //          Eg:  "teaserMaker-std"
    //              get_plugin_camel_and_version_names_dashed()
    //
    //      "[-*-PLUGIN.DETAILS..EXPORT.DIRECTORY.BASENAME--]"
    //          Eg:  "teaser-maker-std-v0.1.0"
    //              get_plugin_export_directory_basename()
    //
    //      "[-*-PLUGIN.DETAILS..VERSION.CREATED.DATE.STRING--]"
    //          Eg:  "12 February 2015"
    //              get_plugin_version_created_date_string()
    //
    // with the corresponding value from the plugin's "Plugins"
    // dataset record.
    //
    // NOTES!
    // ======
    // 1.   The ***replaced***
    //          "[-*-PLUGIN.DETAILS..XXX.VERSION.NUMBER.ALNUM--]"
    //
    //      o   Has NO leading "v", and;
    //      o   Has all none alphanumeric charcters replaced with "x"
    //
    //      Eg:-
    //          "0.1"       =>  "0x1"
    //          "1.3beta"   =>  "ax3beta"
    //          "1.7.2"     =>  "1x7x2"
    //
    // 2.   These replacements are mainly made in:-
    //          <plugin-root-directory>/apps-api.php
    //
    //      But we make them in ALL PHP files - in case there are any
    //      strays used in other places.
    // ---------------------------------------------------------------------

// =============================================================================
// get_xxx()
// =============================================================================

function get_xxx( $pattern_or_value , $default ) {
    $token = '[--PLUGIN.DETAILS..' ;
    if ( substr( $pattern_or_value , 0 , strlen( $token ) ) === $token ) {
        return $default ;
    }
    return $pattern_or_value ;
}

// =============================================================================
// get_plugin_slug_underscored()
// =============================================================================

function get_plugin_slug_underscored() {
    //  Eg:  "teaser_maker"
    return get_xxx(
                'teaser_maker'    ,
                'plugin_workshop'
                ) ;
}

// =============================================================================
// get_plugin_slug_dashed()
// =============================================================================

function get_plugin_slug_dashed() {
    //  Eg:  "teaser-maker"
    return get_xxx(
                'teaser-maker'     ,
                'plugin-workshop'
                ) ;
}

// =============================================================================
// get_plugin_title()
// =============================================================================

function get_plugin_title() {
    //  Eg:  "Teaser Maker"
    return get_xxx(
                'Teaser Maker'   ,
                'Plugin Workshop'
                ) ;
}

// =============================================================================
// get_plugin_camel_name()
// =============================================================================

function get_plugin_camel_name() {
    //  Eg:  "teaserMaker"
    return get_xxx(
                'teaserMaker'  ,
                'pluginWorkshop'
                ) ;
}

// =============================================================================
// get_plugin_base_version_number_with_dots()
// =============================================================================

function get_plugin_base_version_number_with_dots() {
    //  Eg:  "0.1"
    return get_xxx(
                '0.1'     ,
                'latest'
                ) ;
}

// =============================================================================
// get_plugin_base_version_number_date_string()
// =============================================================================

function get_plugin_base_version_number_date_string() {
    //  Eg:  "5 May 2014"
    return get_xxx(
                '5 May 2014'     ,
                'latest'
                ) ;
}

// =============================================================================
// get_plugin_sub_version_number()
// =============================================================================

function get_plugin_sub_version_number() {
    //  Eg:  "123"
    return get_xxx(
                '114'     ,
                'latest'
                ) ;
}

// =============================================================================
// get_plugin_full_version_number_with_dots()
// =============================================================================

function get_plugin_full_version_number_with_dots() {
    //  Eg:  "0.1.123"
    return get_xxx(
                '0.1.114'     ,
                'latest'
                ) ;
}

// =============================================================================
// get_plugin_base_version_number_alnum()
// =============================================================================

function get_plugin_base_version_number_alnum() {
    //  Eg:  "0x1"
    return get_xxx(
                '0x1'     ,
                'latest'
                ) ;
}

// =============================================================================
// get_plugin_full_version_number_alnum()
// =============================================================================

function get_plugin_full_version_number_alnum() {
    //  Eg:  "0x1x123"
    return get_xxx(
                '0x1x114'     ,
                'latest'
                ) ;
}

// =============================================================================
// get_plugin_version_slug()
// =============================================================================

function get_plugin_version_slug() {
    //  Eg:  "std"
    return get_xxx(
                'std'     ,
                'dev'
                ) ;
}

// =============================================================================
// get_plugin_version_short_title()
// =============================================================================

function get_plugin_version_short_title() {
    //  Eg:  "Std"
    return get_xxx(
                'Std'     ,
                'Dev'
                ) ;
}

// =============================================================================
// get_plugin_version_long_title()
// =============================================================================

function get_plugin_version_long_title() {
    //  Eg:  "Standard"
    return get_xxx(
                'Standard'     ,
                'Test/Dev'
                ) ;
}

// =============================================================================
// get_plugin_camel_and_version_names_underscored()
// =============================================================================

function get_plugin_camel_and_version_names_underscored() {
    //  Eg:  "teaserMaker_std"
    return get_xxx(
                'teaserMaker_std'     ,
                'pluginWorkshop_dev'
                ) ;
}

// =============================================================================
// get_plugin_camel_and_version_names_dashed()
// =============================================================================

function get_plugin_camel_and_version_names_dashed() {
    //  Eg:  "teaserMaker-std"
    return get_xxx(
                'teaserMaker-std'      ,
                'pluginWorkshop-dev'
                ) ;
}

// =============================================================================
// get_plugin_export_directory_basename()
// =============================================================================

function get_plugin_export_directory_basename() {
    //  Eg:  "teaser-maker-std-v0.1.0"
    return get_xxx(
                'teaser-maker-std-v0.1.114'      ,
                'pluginWorkshop-dev-v0.1.0'
                ) ;
}

// =============================================================================
// get_plugin_version_created_date_string()
// =============================================================================

function get_plugin_version_created_date_string() {
    //  Eg:  "5 May 2014"
    return get_xxx(
                '12 Jul 2014'     ,
                'latest'
                ) ;
}

// =============================================================================
// get_page_query_variable_value()
// =============================================================================

function get_page_query_variable_value() {
    //  Eg:  "teaserMaker"
    return get_xxx(
                'teaserMakerStdV0x1x114'  ,
                'pluginPlant'
                ) ;
}

// -----------------------------------------------------------------------------
// -----------------------------------------------------------------------------

// =============================================================================
// get_plugin_root_dir()
// =============================================================================

//if ( ! function_exists( 'get_plugin_root_dir' ) ) {

    // -------------------------------------------------------------------------

    function get_plugin_root_dir(
        $path_in_plugin
        ) {

        // -------------------------------------------------------------------------
        // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_appsAPI\get_plugin_root_dir( $path_in_plugin )
        // - - - - - - - - - - - - - - - - - - - - - - - - - - - -
        // Returns the plugin's root directory.  Eg:-
        //      $path_in_plugin =
        //          '/home/joe/public_html/wp-content/plugins/my-plugin/includes/string-utils.php'
        //          ;
        //      get_plugin_root_dir( $pathspec )
        //
        // would return:-
        //      "/home/joe/public_html/wp-content/plugins/my-plugin"
        //
        // $path_in_plugin should be a file, directory or link path in the
        // plugin from which (and for which) this function is called.  Typically,
        // one uses __FILE__ for this purpose.  Eg:-
        //      get_plugin_root_dir( __FILE__ )
        //
        // Exits with an error message if the plugin root directory can't be returned
        // (for whatever reason).
        //
        // NOTE!
        // -----
        // You must supply a file system PATHSPEC to this function (NOT a URL).
        // -------------------------------------------------------------------------

        // =========================================================================
        // Convert "\" to "/" (for Windows compatability)...
        // =========================================================================

        $path_in_plugin = str_replace( '\\' , '/' , $path_in_plugin ) ;

        // =========================================================================
        // Replace multiple consecutive "/" with a single "/"...
        //
        // NOTE!
        // -----
        // This is to eliminate problems with paths that contain un-necessary
        // duplicate slashes...
        // =========================================================================

        // -------------------------------------------------------------------------
        // mixed preg_replace ( mixed $pattern , mixed $replacement , mixed $subject [, int $limit = -1 [, int &$count ]] )
        // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
        // Searches subject for matches to pattern and replaces them with replacement.
        //
        //      pattern
        //          The pattern to search for. It can be either a string or an array
        //          with strings.
        //
        //          Several PCRE modifiers are also available, including the
        //          deprecated 'e' (PREG_REPLACE_EVAL), which is specific to this
        //          function.
        //
        //      replacement
        //          The string or an array with strings to replace. If this
        //          parameter is a string and the pattern parameter is an array, all
        //          patterns will be replaced by that string. If both pattern and
        //          replacement parameters are arrays, each pattern will be replaced
        //          by the replacement counterpart. If there are fewer elements in
        //          the replacement array than in the pattern array, any extra
        //          patterns will be replaced by an empty string.
        //
        //          replacement may contain references of the form \\n or (since PHP
        //          4.0.4) $n, with the latter form being the preferred one. Every
        //          such reference will be replaced by the text captured by the n'th
        //          parenthesized pattern. n can be from 0 to 99, and \\0 or $0
        //          refers to the text matched by the whole pattern. Opening
        //          parentheses are counted from left to right (starting from 1) to
        //          obtain the number of the capturing subpattern. To use backslash
        //          in replacement, it must be doubled ("\\\\" PHP string).
        //
        //          When working with a replacement pattern where a backreference is
        //          immediately followed by another number (i.e.: placing a literal
        //          number immediately after a matched pattern), you cannot use the
        //          familiar \\1 notation for your backreference. \\11, for example,
        //          would confuse preg_replace() since it does not know whether you
        //          want the \\1 backreference followed by a literal 1, or the \\11
        //          backreference followed by nothing. In this case the solution is
        //          to use \${1}1. This creates an isolated $1 backreference,
        //          leaving the 1 as a literal.
        //
        //          When using the deprecated e modifier, this function escapes some
        //          characters (namely ', ", \ and NULL) in the strings that replace
        //          the backreferences. This is done to ensure that no syntax errors
        //          arise from backreference usage with either single or double
        //          quotes (e.g. 'strlen(\'$1\')+strlen("$2")'). Make sure you are
        //          aware of PHP's string syntax to know exactly how the interpreted
        //          string will look.
        //
        //      subject
        //          The string or an array with strings to search and replace.
        //
        //          If subject is an array, then the search and replace is performed
        //          on every entry of subject, and the return value is an array as
        //          well.
        //
        //      limit
        //          The maximum possible replacements for each pattern in each
        //          subject string. Defaults to -1 (no limit).
        //
        //      count
        //          If specified, this variable will be filled with the number of
        //          replacements done.
        //
        // preg_replace() returns an array if the subject parameter is an array, or
        // a string otherwise.
        //
        // If matches are found, the new subject will be returned, otherwise subject
        // will be returned unchanged or NULL if an error occurred.
        //
        // ERRORS/EXCEPTIONS
        //      An E_DEPRECATED level error is emitted when passing in the "\e"
        //      modifier.
        //
        // (PHP 4, PHP 5)
        //
        // CHANGELOG
        //      Version     Description
        //      -------     -------------------------------------------------
        //      5.5.0       The /e modifier is deprecated. Use
        //                  preg_replace_callback() instead. See the
        //                  PREG_REPLACE_EVAL documentation for additional
        //                  information about security risks.
        //      5.1.0       Added the count parameter
        //      4.0.4       Added the '$n' form for the replacement parameter
        //      4.0.2       Added the limit parameter
        // -------------------------------------------------------------------------

        $pattern = '/\/+/' ;

        $replacement = '/' ;

        // -------------------------------------------------------------------------

        $path_in_plugin = preg_replace(
                                $pattern        ,
                                $replacement    ,
                                $path_in_plugin
                                ) ;

        // -------------------------------------------------------------------------

        if ( $path_in_plugin === NULL ) {

            $msg = <<<EOT
PROBLEM:&nbsp; "preg_replace()" failure removing duplicate path separators
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_appsAPI\\get_plugin_root_dir()
EOT;

            die( $msg ) ;

        }

        // =========================================================================
        // Eliminate leading and trailing slashes...
        // =========================================================================

        $path_in_plugin = trim( $path_in_plugin , '/' ) ;

        // =========================================================================
        // Split the path into it's components...
        // =========================================================================

        $path_parts = explode( '/' , $path_in_plugin ) ;

        // =========================================================================
        // Search from the bottom up for:-
        //      "wp-content/plugins"
        // =========================================================================

        $count = count( $path_parts ) ;

        $plugin_root_dir = NULL ;

        // -------------------------------------------------------------------------

        for ( $i = $count - 1 ; $i >= 0 ; $i-- ) {

            // ---------------------------------------------------------------------

            if (    $path_parts[$i] === 'wp-content'
                    &&
                    $i + 1 < $count
                    &&
                    $path_parts[ $i + 1 ] === 'plugins'
                    &&
                    $i + 2 < $count
                ) {

                // -------------------------------------------------------------------------
                // array array_slice ( array $array , int $offset [, int $length = NULL [, bool $preserve_keys = false ]] )
                // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
                // array_slice() returns the sequence of elements from the array array as
                // specified by the offset and length parameters.
                //
                //      array
                //          The input array.
                //
                //      offset
                //          If offset is non-negative, the sequence will start at that
                //          offset in the array. If offset is negative, the sequence will
                //          start that far from the end of the array.
                //
                //      length
                //          If length is given and is positive, then the sequence will have
                //          up to that many elements in it. If the array is shorter than the
                //          length, then only the available array elements will be present.
                //          If length is given and is negative then the sequence will stop
                //          that many elements from the end of the array. If it is omitted,
                //          then the sequence will have everything from offset up until the
                //          end of the array.
                //
                //      preserve_keys
                //          Note that array_slice() will reorder and reset the numeric array
                //          indices by default. You can change this behaviour by setting
                //          preserve_keys to TRUE.
                //
                // Returns the slice.
                //
                // (PHP 4, PHP 5)
                //
                // CHANGELOG
                //      Version     Description
                //      -------     --------------------------------------------------------
                //      5.2.4       The default value of the length parameter was changed to
                //                  NULL. A NULL length now tells the function to use the
                //                  length of array. Prior to this version, a NULL length
                //                  was taken to mean a zero length (nothing will be
                //                  returned).
                //      5.0.2       The optional preserve_keys parameter was added.
                // -------------------------------------------------------------------------

                $plugin_root_dir = array_slice( $path_parts , 0 , $i + 3 ) ;

                $plugin_root_dir = '/' . implode( '/' , $plugin_root_dir ) ;

                // -----------------------------------------------------------------

                if ( ! is_dir( $plugin_root_dir ) ) {

                    $msg = <<<EOT
PROBLEM:&nbsp; WordPress plugin root dir not found (in supplied path)
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_appsAPI\\get_plugin_root_dir()
EOT;

                    die( $msg ) ;

                }

                // -----------------------------------------------------------------

                return $plugin_root_dir ;

                // -----------------------------------------------------------------

            }

            // ---------------------------------------------------------------------

        }

        // =========================================================================
        // FAILURE!
        // =========================================================================

        $msg = <<<EOT
PROBLEM:&nbsp; WordPress plugin root dir not found (in supplied path)
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_appsAPI\\get_plugin_root_dir()
EOT;

        die( $msg ) ;

        // =========================================================================
        // That's that!
        // =========================================================================

    }

    // -------------------------------------------------------------------------

//}

// =============================================================================
// convert_root_relative_plugin_pathspec_2_absolute()
// =============================================================================

//if ( ! function_exists( 'convert_root_relative_plugin_pathspec_2_absolute' ) ) {

    // -------------------------------------------------------------------------

    function convert_root_relative_plugin_pathspec_2_absolute(
        $path_in_plugin             ,
        $root_relative_pathspec
        ) {

        // -------------------------------------------------------------------------
        // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_appsAPI\convert_root_relative_plugin_pathspec_2_absolute(
        //      $path_in_plugin             ,
        //      $root_relative_pathspec
        //      )
        // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
        // Returns the absolute path to the specified plugin root relative
        // pathspec.
        //
        // $path_in_plugin should be a file, directory or link path in the
        // plugin (or "app") from which this function is called.  Typically,
        // one uses __FILE__ for this purpose.  Eg:-
        //
        //      $path_in_plugin =
        //          '/home/joseph/public_html/wp-content/plugins/my-plugin/includes/string-utils.php'
        //          ;
        //      $root_relative_pathspec =
        //          'app-defs'
        //          ;
        //      convert_root_relative_plugin_pathspec_2_absolute(
        //          $path_in_plugin             ,
        //          $root_relative_pathspec
        //          ) ;
        //
        // would return:-
        //
        //      "/home/joseph/public_html/wp-content/plugins/my-plugin/app-defs"
        //
        // Exits with an error message if the pathspec can't be returned (eg;
        // doesn't exist).
        // -------------------------------------------------------------------------

        // -------------------------------------------------------------------------
        // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_appsAPI\get_plugin_root_dir( $path_in_plugin )
        // - - - - - - - - - - - - - - - - - - - - - - - - - - - -
        // Returns the plugin's root directory.  Eg:-
        //      $path_in_plugin =
        //          '/home/joe/public_html/wp-content/plugins/my-plugin/includes/string-utils.php'
        //          ;
        //      get_plugin_root_dir( $pathspec )
        //
        // would return:-
        //      "/home/joe/public_html/wp-content/plugins/my-plugin"
        //
        // $path_in_plugin should be a file, directory or link path in the
        // plugin from which (and for which) this function is called.  Typically,
        // one uses __FILE__ for this purpose.  Eg:-
        //      get_plugin_root_dir( __FILE__ )
        //
        // Exits with an error message if the plugin root directory can't be returned
        // (for whatever reason).
        //
        // NOTE!
        // -----
        // You must supply a file system PATHSPEC to this function (NOT a URL).
        // -------------------------------------------------------------------------

        $absolute_pathspec =
            get_plugin_root_dir( $path_in_plugin ) .
            '/' .
            trim( $root_relative_pathspec , '/' )
            ;

        // -------------------------------------------------------------------------

        if ( ! file_exists( $absolute_pathspec ) ) {

            $msg = <<<EOT
PROBLEM:&nbsp; Bad plugin root relative pathspec (doesn't exist)
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_appsAPI\\convert_root_relative_plugin_pathspec_2_absolute()
EOT;

            die( $msg ) ;

        }

        // -------------------------------------------------------------------------

        return $absolute_pathspec ;

        // -------------------------------------------------------------------------

    }

    // -------------------------------------------------------------------------

//}

// =============================================================================
// get_plugins_app_defs_dir()
// =============================================================================

//if ( ! function_exists( 'get_plugins_app_defs_dir' ) ) {

    function get_plugins_app_defs_dir(
        $path_in_plugin
        ) {

        // -------------------------------------------------------------------------
        // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_appsAPI\get_plugins_app_defs_dir(
        //      $path_in_plugin
        //      )
        // - - - - - - - - - - - - - - - - - - - - - -
        // Returns the dirspec of the root of the directory tree in which the
        // plugin's "apps" and "datasets" etc are defined.
        //
        // $path_in_plugin should be a file, directory or link path in the
        // plugin (or "app") from which this function is called.  Typically,
        // one uses __FILE__ for this purpose.  Eg:-
        //
        //      \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_appsAPI\get_plugins_app_defs_dir( __FILE__ ) ;
        //
        // Exits with an error message if the directory can't be returned (eg;
        // doesn't exist).
        //
        // NOTE!
        // -----
        // These "apps" and "datasets" (etc) are typically defined in a directory
        // tree structure like (eg):-
        //
        //      /plugins/this-plugin/
        //      +-- app-defs/
        //      +-- includes/
        //      +-- js/
        //      +-- admin/
        //      +-- remote/
        //      +-- ...etc...
        //      +-- this-plugin.php
        //      +-- ...etc...
        //
        // -------------------------------------------------------------------------

        // -------------------------------------------------------------------------
        // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_appsAPI\convert_root_relative_plugin_pathspec_2_absolute(
        //      $path_in_plugin             ,
        //      $root_relative_pathspec
        //      )
        // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
        // Returns the absolute path to the specified plugin root relative
        // pathspec.
        //
        // $path_in_plugin should be a file, directory or link path in the
        // plugin (or "app") from which this function is called.  Typically,
        // one uses __FILE__ for this purpose.  Eg:-
        //
        //      $path_in_plugin =
        //          '/home/joseph/public_html/wp-content/plugins/my-plugin/includes/string-utils.php'
        //          ;
        //      $root_relative_pathspec =
        //          'app-defs'
        //          ;
        //      convert_root_relative_plugin_pathspec_2_absolute(
        //          $path_in_plugin             ,
        //          $root_relative_pathspec
        //          ) ;
        //
        // would return:-
        //
        //      "/home/joseph/public_html/wp-content/plugins/my-plugin/app-defs"
        //
        // Exits with an error message if the pathspec can't be returned (eg;
        // doesn't exist).
        // -------------------------------------------------------------------------

        return convert_root_relative_plugin_pathspec_2_absolute(
                    $path_in_plugin                     ,
                    'dataset-manager-dataset-defs'
                    ) ;

        // -------------------------------------------------------------------------

    }

    // -------------------------------------------------------------------------

//}

// =============================================================================
// get_plugins_includes_dir()
// =============================================================================

//if ( ! function_exists( 'get_plugins_includes_dir' ) ) {

    function get_plugins_includes_dir(
        $path_in_plugin
        ) {

        // -------------------------------------------------------------------------
        // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_appsAPI\get_plugins_includes_dir(
        //      $path_in_plugin
        //      )
        // - - - - - - - - - - - - - - - - - - - - - -
        // Returns the dirspec of the root of the directory tree in which the
        // plugin's "apps" and "datasets" etc are defined.
        //
        // $path_in_plugin should be a file, directory or link path in the
        // plugin (or "app") from which this function is called.  Typically,
        // one uses __FILE__ for this purpose.  Eg:-
        //
        //      \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_appsAPI\get_plugins_includes_dir( __FILE__ ) ;
        //
        // Exits with an error message if the directory can't be returned (eg;
        // doesn't exist).
        //
        // NOTE!
        // -----
        // These "apps" and "datasets" (etc) are typically defined in a directory
        // tree structure like (eg):-
        //
        //      /plugins/this-plugin/
        //      +-- app-defs/
        //      +-- includes/
        //      +-- js/
        //      +-- admin/
        //      +-- remote/
        //      +-- ...etc...
        //      +-- this-plugin.php
        //      +-- ...etc...
        //
        // -------------------------------------------------------------------------

        // -------------------------------------------------------------------------
        // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_appsAPI\convert_root_relative_plugin_pathspec_2_absolute(
        //      $path_in_plugin             ,
        //      $root_relative_pathspec
        //      )
        // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
        // Returns the absolute path to the specified plugin root relative
        // pathspec.
        //
        // $path_in_plugin should be a file, directory or link path in the
        // plugin (or "app") from which this function is called.  Typically,
        // one uses __FILE__ for this purpose.  Eg:-
        //
        //      $path_in_plugin =
        //          '/home/joseph/public_html/wp-content/plugins/my-plugin/includes/string-utils.php'
        //          ;
        //      $root_relative_pathspec =
        //          'app-defs'
        //          ;
        //      convert_root_relative_plugin_pathspec_2_absolute(
        //          $path_in_plugin             ,
        //          $root_relative_pathspec
        //          ) ;
        //
        // would return:-
        //
        //      "/home/joseph/public_html/wp-content/plugins/my-plugin/app-defs"
        //
        // Exits with an error message if the pathspec can't be returned (eg;
        // doesn't exist).
        // -------------------------------------------------------------------------

        return convert_root_relative_plugin_pathspec_2_absolute(
                    $path_in_plugin     ,
                    'includes'
                    ) ;

        // -------------------------------------------------------------------------

    }

    // -------------------------------------------------------------------------

//}

// =============================================================================
// get_single_apps_dot_app_dir()
// =============================================================================

//if ( ! function_exists( 'get_single_apps_dot_app_dir' ) ) {

    // -------------------------------------------------------------------------

    function get_single_apps_dot_app_dir(
        $path_in_plugin     ,
        $app_handle
        ) {

        // -------------------------------------------------------------------------
        // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_appsAPI\get_single_apps_dot_app_dir(
        //      $path_in_plugin
        //      $app_handle
        //      )
        // - - - - - - - - - - - - - - - - - - - - - - -
        // Returns the dirspec of the specified app's ".app" dir.
        //
        // $path_in_plugin should be a file, directory or link path in the
        // plugin (or "app") from which this function is called.  Typically,
        // one uses __FILE__ for this purpose.  Eg:-
        //
        //      \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_appsAPI\get_single_app_defs_root_dir( __FILE__ ) ;
        //
        // $app_handle should be either:-
        //
        //      o   A single "app slug" - eg; "research-assistant" - as a
        //          STRING.  For which the returned dirspec might be (eg):-
        //
        //              /home/joe/.../plugins/some-plugin/app-defs/research-assistant.app
        //
        // Or:-
        //
        //      o   An array of (nested) app slugs.  Eg:-
        //
        //              array(
        //                  'some-app'          ,
        //                  'child-app'         ,
        //                  'grandchild-app'
        //                  [...]
        //                  )
        //
        //          For which the returned dirspec might be (eg):-
        //
        //              /home/joe/.../plugins/some-plugin/app-defs/some-app.app/child-app.app/grandchild-app.app
        //
        // Exits with an error message if the directory can't be returned (eg;
        // doesn't exist).
        //
        // NOTE!
        // -----
        // These "apps" and "datasets" (etc) are typically defined in a directory
        // tree structure like (eg):-
        //
        //      /plugins/this-plugin/
        //      +-- app-defs/
        //      |   +-- some-app.app/
        //      |   |   +-- child-app.app/
        //      |   |       +-- grandchild-app.app
        //      |   |           +-- etc...
        //      |   +-- another-app.app/
        //      |       +-- ...
        //      +-- includes/
        //      +-- js/
        //      +-- admin/
        //      +-- remote/
        //      +-- ...etc...
        //      +-- this-plugin.php
        //      +-- ...etc...
        //
        // -------------------------------------------------------------------------

        if ( is_array( $app_handle ) ) {
            $app_path = '' ;

            foreach ( $app_handle as $app_slug ) {
                $app_path .= '/' . $app_slug . '.app' ;
            }

        } else {
            $app_path = '/' . $app_handle . '.app' ;

        }

        // ---------------------------------------------------------------------

        return convert_root_relative_plugin_pathspec_2_absolute(
                    $path_in_plugin     ,
                    $app_path
                    ) ;

        // ---------------------------------------------------------------------

    }

    // -------------------------------------------------------------------------

//}

// =============================================================================
// get_core_plugapp_dirs()
// =============================================================================

//if ( ! function_exists( 'get_core_plugapp_dirs' ) ) {

    // -------------------------------------------------------------------------

    function get_core_plugapp_dirs_base(
        $path_in_plugin     ,
        $app_handle = NULL
        ) {

        // -------------------------------------------------------------------------
        // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_appsAPI\
        // get_core_plugapp_dirs_base(
        //      $path_in_plugin         ,
        //      $app_handle = NULL
        //      )
        // - - - - - - - - - - - - - - -
        // Returns the dirspecs of the main dirs used in a given app.  Ie:-
        //
        //      array(
        //          'plugin_root_dir'                   =>  "xxx"   ,
        //          'plugins_includes_dir'              =>  "xxx"   ,
        //          'plugins_app_defs_dir'              =>  "xxx"   ,
        //          'dataset_manager_includes_dir'      =>  "xxx"   ,   //  (1)
        //          'apps_dot_app_dir'                  =>  "xxx"   ,   //  (2)
        //          'apps_plugin_stuff_dir'             =>  "xxx"       //  (3)
        //          'custom_pages_dir'                  =>  "xxx"       //  (4)
        //          )
        //
        //      (1) This is where most of the "Dataset Manager" includes files
        //          are stored.
        //
        //      (2) If $app_handle === NULL, the returned 'apps_dot_app_dir'
        //          is NULL too.
        //
        //      (3) If $app_handle === NULL, the returned 'apps_plugin_stuff_dir'
        //          is NULL too.
        //
        //      (4) If $app_handle === NULL, the returned 'custom_pages_dir'
        //          is NULL too.
        //
        // ---
        //
        // $path_in_plugin should be a file, directory or link path in the
        // plugin (or "app") from which this function is called.  Typically,
        // one uses __FILE__ for this purpose.  Eg:-
        //
        //      \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_appsAPI\get_single_app_defs_root_dir( __FILE__ ) ;
        //
        // ---
        //
        // $app_handle should be either:-
        //
        //      o   A single "app slug" - eg; "research-assistant" - as a
        //          STRING.  For which the returned dirspec might be (eg):-
        //
        //              /home/joe/.../plugins/some-plugin/app-defs/research-assistant.app
        //
        // Or:-
        //
        //      o   An array of (nested) app slugs.  Eg:-
        //
        //              array(
        //                  'some-app'          ,
        //                  'child-app'         ,
        //                  'grandchild-app'
        //                  [...]
        //                  )
        //
        //          For which the returned dirspec might be (eg):-
        //
        //              /home/joe/.../plugins/some-plugin/app-defs/some-app.app/child-app.app/grandchild-app.app
        //
        // Exits with an error message if the directory can't be returned (eg;
        // doesn't exist).
        //
        // NOTE!
        // -----
        // These "apps" and "datasets" (etc) are typically defined in a directory
        // tree structure like (eg):-
        //
        //      /plugins/this-plugin/
        //      +-- app-defs/
        //      |   +-- some-app.app/
        //      |   |   +-- child-app.app/
        //      |   |       +-- grandchild-app.app
        //      |   |           +-- etc...
        //      |   +-- another-app.app/
        //      |       +-- ...
        //      +-- includes/
        //      +-- js/
        //      +-- admin/
        //      +-- remote/
        //      +-- ...etc...
        //      +-- this-plugin.php
        //      +-- ...etc...
        //
        // -------------------------------------------------------------------------

        // -------------------------------------------------------------------------
        // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_appsAPI\get_plugin_root_dir( $path_in_plugin )
        // - - - - - - - - - - - - - - - - - - - - - - - - - - - -
        // Returns the plugin's root directory.  Eg:-
        //      $path_in_plugin =
        //          '/home/joe/public_html/wp-content/plugins/my-plugin/includes/string-utils.php'
        //          ;
        //      get_plugin_root_dir( $pathspec )
        //
        // would return:-
        //      "/home/joe/public_html/wp-content/plugins/my-plugin"
        //
        // $path_in_plugin should be a file, directory or link path in the
        // plugin from which (and for which) this function is called.  Typically,
        // one uses __FILE__ for this purpose.  Eg:-
        //      get_plugin_root_dir( __FILE__ )
        //
        // Exits with an error message if the plugin root directory can't be returned
        // (for whatever reason).
        //
        // NOTE!
        // -----
        // You must supply a file system PATHSPEC to this function (NOT a URL).
        // -------------------------------------------------------------------------

        $ns = __NAMESPACE__ ;
        $fn = __FUNCTION__  ;

        // ---------------------------------------------------------------------
        // plugin_root_dir
        // ---------------------------------------------------------------------

        $plugin_root_dir = get_plugin_root_dir( $path_in_plugin ) ;

        // ---------------------------------------------------------------------

        $out = array(
                    'plugin_root_dir'   =>  $plugin_root_dir
                    ) ;

//echo '<br />' , $plugin_root_dir ;

        // ---------------------------------------------------------------------
        // plugins_includes_dir
        // plugins_apps_defs_dir
        // dataset_manager_include_files_dir
        // ---------------------------------------------------------------------

        $plugin_root_relative_dirs_to_get = array(
            'plugins_includes_dir'              =>  'includes'                      ,
            'plugins_app_defs_dir'              =>  'app-defs'                      ,
            'dataset_manager_includes_dir'      =>  'includes/dataset-manager'
            ) ;

        // ---------------------------------------------------------------------

        foreach ( $plugin_root_relative_dirs_to_get as $key => $plugin_root_relative_dirspec ) {

            // -----------------------------------------------------------------

            $absolute_pathspec =
                $plugin_root_dir .
                '/' .
                $plugin_root_relative_dirspec
                ;

//echo '<br />' , $absolute_pathspec ;

            // -----------------------------------------------------------------

            if ( ! is_dir( $absolute_pathspec ) ) {

                $safe_plugin_root_relative_dirspec = htmlentities( $plugin_root_relative_dirspec ) ;

                $msg = <<<EOT
PROBLEM:&nbsp; Bad plugin root relative dirspec ("{$safe_plugin_root_relative_dirspec}" - no such dir)
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

                die( nl2br( $msg ) ) ;

            }

            // -----------------------------------------------------------------

            $out[ $key ] = $absolute_pathspec ;

            // -----------------------------------------------------------------

        }

        // ---------------------------------------------------------------------
        // apps_dot_app_dir
        // apps_plugin_stuff_dir
        // custom_pages_dir
        // ---------------------------------------------------------------------

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $app_handle ) ;
//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( \gettype( $app_handle ) ) ;

        if ( is_array( $app_handle ) ) {

            $app_path = '' ;

            foreach ( $app_handle as $app_slug ) {
                $app_path .= '/' . $app_slug . '.app' ;
            }

        } elseif ( is_string( $app_handle ) ) {

            $app_path = '/' . $app_handle . '.app' ;

        } else {

            $app_path = NULL ;

        }

        // ---------------------------------------------------------------------

        if ( $app_path === NULL ) {

            // -----------------------------------------------------------------

            $out['apps_dot_app_dir'] = NULL ;

            $out['apps_plugin_stuff_dir'] = NULL ;

            $out['custom_pages_dir'] = NULL ;

            // -----------------------------------------------------------------

        } else {

            // -----------------------------------------------------------------

            $absolute_pathspec =
                $plugin_root_dir .
                '/app-defs' .
                $app_path
                ;

//echo '<br />' , $absolute_pathspec;

            // -----------------------------------------------------------------

            if ( ! is_dir( $absolute_pathspec ) ) {

                $msg = <<<EOT
PROBLEM:&nbsp; Bad "app handle" (no such app)
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

                die( nl2br( $msg ) ) ;

            }

            // -----------------------------------------------------------------

            $out['apps_dot_app_dir'] = $absolute_pathspec ;

            // -----------------------------------------------------------------

            $absolute_pathspec .=
                '/plugin.stuff'
                ;

//echo '<br />' , $absolute_pathspec;

            // -----------------------------------------------------------------

            if ( ! is_dir( $absolute_pathspec ) ) {

                $msg = <<<EOT
PROBLEM:&nbsp; App's "plugin.stuff" dir not found
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

                die( nl2br( $msg ) ) ;

            }

            // -----------------------------------------------------------------

            $out['apps_plugin_stuff_dir'] = $absolute_pathspec ;

            // -----------------------------------------------------------------

            $absolute_pathspec .=
                '/custom.pages'
                ;

//echo '<br />' , $absolute_pathspec;

            // -----------------------------------------------------------------

            if ( is_dir( $absolute_pathspec ) ) {
                $out['custom_pages_dir'] = $absolute_pathspec ;

            } else {
                $out['custom_pages_dir'] = '' ;

            }

            // -----------------------------------------------------------------

        }

        // ---------------------------------------------------------------------
        // SUCCESS!
        // ---------------------------------------------------------------------

        return $out ;

        // ---------------------------------------------------------------------
        // That's that!
        // ---------------------------------------------------------------------

    }

    // -------------------------------------------------------------------------

//}

// =============================================================================
// Cache the "CORE PLUGAPP DIRS" (for easy access)...
// =============================================================================

function get_core_plugapp_dirs(
    $path_in_plugin         ,
    $app_handle = NULL
    ) {

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_appsAPI\
    // get_core_plugapp_dirs(
    //      $path_in_plugin         ,
    //      $app_handle = NULL
    //      )
    // - - - - - - - - - - - - - - -
    // Returns the dirspecs of the main dirs used in a given app.  Ie:-
    //
    //      array(
    //          'plugin_root_dir'                   =>  "xxx"   ,
    //          'plugins_includes_dir'              =>  "xxx"   ,
    //          'plugins_app_defs_dir'              =>  "xxx"   ,
    //          'dataset_manager_includes_dir'      =>  "xxx"   ,   //  (1)
    //          'apps_dot_app_dir'                  =>  "xxx"   ,   //  (2)
    //          'apps_plugin_stuff_dir'             =>  "xxx"       //  (3)
    //          'custom_pages_dir'                  =>  "xxx"       //  (4)
    //          )
    //
    //      (1) This is where most of the "Dataset Manager" includes files
    //          are stored.
    //
    //      (2) If $app_handle === NULL, the returned 'apps_dot_app_dir'
    //          is NULL too.
    //
    //      (3) If $app_handle === NULL, the returned 'apps_plugin_stuff_dir'
    //          is NULL too.
    //
    //      (4) If $app_handle === NULL, the returned 'custom_pages_dir'
    //          is NULL too.

    // ---
    //
    // $path_in_plugin should be a file, directory or link path in the
    // plugin (or "app") from which this function is called.  Typically,
    // one uses __FILE__ for this purpose.  Eg:-
    //
    //      \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_appsAPI\get_single_app_defs_root_dir( __FILE__ ) ;
    //
    // ---
    //
    // $app_handle should be either:-
    //
    //      o   A single "app slug" - eg; "research-assistant" - as a
    //          STRING.  For which the returned dirspec might be (eg):-
    //
    //              /home/joe/.../plugins/some-plugin/app-defs/research-assistant.app
    //
    // Or:-
    //
    //      o   An array of (nested) app slugs.  Eg:-
    //
    //              array(
    //                  'some-app'          ,
    //                  'child-app'         ,
    //                  'grandchild-app'
    //                  [...]
    //                  )
    //
    //          For which the returned dirspec might be (eg):-
    //
    //              /home/joe/.../plugins/some-plugin/app-defs/some-app.app/child-app.app/grandchild-app.app
    //
    // Exits with an error message if the directory can't be returned (eg;
    // doesn't exist).
    //
    // NOTE!
    // -----
    // These "apps" and "datasets" (etc) are typically defined in a directory
    // tree structure like (eg):-
    //
    //      /plugins/this-plugin/
    //      +-- app-defs/
    //      |   +-- some-app.app/
    //      |   |   +-- child-app.app/
    //      |   |       +-- grandchild-app.app
    //      |   |           +-- etc...
    //      |   +-- another-app.app/
    //      |       +-- ...
    //      +-- includes/
    //      +-- js/
    //      +-- admin/
    //      +-- remote/
    //      +-- ...etc...
    //      +-- this-plugin.php
    //      +-- ...etc...
    //
    // -------------------------------------------------------------------------

//  if ( ! isset( $GLOBALS['GREAT_KIWI']['BY_FERN_TEC']['_teaserMaker_std_']['_v0x1x114_']['core_plugapp_dirs'] ) ) {
//
//      $GLOBALS['GREAT_KIWI']['BY_FERN_TEC']['_teaserMaker_std_']['_v0x1x114_']['core_plugapp_dirs'] =
//          get_core_plugapp_dirs_base(
//              $path_in_plugin     ,
//              $app_handle
//              ) ;
//
//  }
//
//  // -------------------------------------------------------------------------
//
//  return $GLOBALS['GREAT_KIWI']['BY_FERN_TEC']['_teaserMaker_std_']['_v0x1x114_']['core_plugapp_dirs'] ;

    // -------------------------------------------------------------------------

    return get_core_plugapp_dirs_base(
                $path_in_plugin     ,
                $app_handle
                ) ;

    // -------------------------------------------------------------------------

}

// =============================================================================
// get_plugin_url()
// =============================================================================

function get_plugin_url() {
    return \plugins_url() . '/' . get_plugin_root_dir_basename_raw() ;
}

// =============================================================================
// get_js_url()
// =============================================================================

function get_js_url() {
    return get_plugin_url() . '/js' ;
}

// =============================================================================
// get_images_url()
// =============================================================================

function get_images_url() {
    return get_plugin_url() . '/images' ;
}

// =============================================================================
// That's that!
// =============================================================================

