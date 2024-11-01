<?php

// *****************************************************************************
// DATASET-MANAGER / CUSTOM-PAGES-SUPPORT.PHP
// (C) 2013 Peter Newman. All Rights Reserved.
// *****************************************************************************

    namespace greatKiwi_byFernTec_teaserMaker_std_v0x1x114_customPages ;

// =============================================================================
// load_custom_pages()
// =============================================================================

function load_custom_pages(
    $core_plugapp_dirs      ,
    $app_defs_dir
    ) {

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_customPages\
    // load_custom_pages(
    //      $core_plugapp_dirs      ,
    //      $app_defs_dir
    //      )
    // - - - - - - - - - - - - - - -
    // Loads the specified application's "custom pages" - if it has any...
    //
    // NOTES!
    // ======
    // 1.   The specified application is that specified by:-
    //          $app_defs_dir
    //      This is the dir (or sub-dir) that holds the application's or
    //      sub-application's "dataset" and "view" definitions.  As well as the
    //      app/plugin's "plugin.stuff" dir.
    //
    // 2.   $core_plugapp_dirs is for the plugin/application being run.  It
    //      ISN'T necessarily the plugin/application whose custom pages we're
    //      searching for.
    //
    // RETURNS
    //      o   On SUCCESS
    //              $custom_pages ARRAY
    //
    //              The "custom pages" array is like (eg):-
    //
    //      o   On FAILURE
    //              $error_message STRING
    // -------------------------------------------------------------------------

    // -------------------------------------------------------------------------
    // OVERVIEW
    // ========
    // The "custom pages" are stored as follows:-
    //
    //      <plugin-root-dir>/
    //      +-- app-defs/
    //          +-- this-app.app/       <-- $app_defs_dir
    //              +-- plugin.stuff/
    //                  +-- custom.pages/
    //                      +-- this-custom-page.cp/
    //                      |   +-- page-display-file.php
    //                      |   +-- page-data.php
    //                      |   +-- ...other custom page files...
    //                      +-- that-custom-page.cp/
    //                      |   +-- page-display-file.php
    //                      |   +-- page-data.php
    //                      |   +-- ...other custom page files...
    //                      +-- ...
    //                      +-- the-other-custom-page.cp/
    //                          +-- page-display-file.php
    //                          +-- page-data.php
    //                          +-- ...other custom page files...
    //
    // -------------------------------------------------------------------------

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $core_plugapp_dirs = array(
    //          'plugin_root_dir'                   =>  "xxx"   ,
    //          'plugins_includes_dir'              =>  "xxx"   ,
    //          'plugins_app_defs_dir'              =>  "xxx"   ,
    //          'dataset_manager_includes_dir'      =>  "xxx"   ,
    //          'apps_dot_app_dir'                  =>  "xxx"   ,
    //          'apps_plugin_stuff_dir'             =>  "xxx"
    //          'custom_pages_dir'                  =>  "xxx"
    //          )
    //
    // -------------------------------------------------------------------------

    // =========================================================================
    // Init.
    // =========================================================================

    $ns = __NAMESPACE__ ;
    $fn = __FUNCTION__  ;

    // =========================================================================
    // Get the target application's:-
    //      "custom_pages"
    //
    // dir.
    // =========================================================================

    $target_apps_custom_pages_dir =
        $app_defs_dir .
        '/plugin.stuff/custom.pages'
        ;

    // =========================================================================
    // ANY CUSTOM PAGES ?
    // =========================================================================

    if ( ! is_dir( $target_apps_custom_pages_dir ) ) {
        return array() ;
    }

    // =========================================================================
    // Load the DIRS/FILES in the plugin's "CUSTOM PAGES" dir...
    // =========================================================================

    require_once( $core_plugapp_dirs['plugins_includes_dir'] . '/scandir.php' ) ;

    // -----------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_dirsFiles\
    // super_scandir(
    //      $target_directory
    //      )
    // - - - - - - - - - - --
    // Returns an array of the file and directory basenames from the
    // specified directory.
    //
    // Works in PHP 4 and above.
    //
    // PARAMETERS
    //      $target_directory
    //          The directory that will be scanned.
    //
    // RETURN VALUES
    //      Returns the following array on success, or FALSE on failure.
    //
    //          array(
    //              'dirs'  =>  array(
    //                              [dir_FDE0]      =>  'dir_filespec0'     ,
    //                              [dir_FDE1]      =>  'dir_filespec1'     ,
    //                              [dir_FDE2]      =>  'dir_filespec2'     ,
    //                              ...                 ...
    //                              [dir_FDEn]      =>  'dir_filespecN'
    //                              )
    //              'files' =>  array(
    //                              [file_FDE0]     =>  'file_filespec0'     ,
    //                              [file_FDE1]     =>  'file_filespec1'     ,
    //                              [file_FDE2]     =>  'file_filespec2'     ,
    //                              ...                 ...
    //                              [file_FDEn]     =>  'file_filespecN'
    //                              )
    //              'other' =>  array(
    //                              [other_FDE0]    =>  'other_filespec0'     ,
    //                              [other_FDE1]    =>  'other_filespec1'     ,
    //                              [other_FDE2]    =>  'other_filespec2'     ,
    //                              ...                 ...
    //                              [other_FDEn]    =>  'other_filespecN'
    //                              )
    //              )
    //
    //      If directory is not a directory, then boolean FALSE is returned,
    //      and an error of level E_WARNING is generated.
    // -----------------------------------------------------------------------

    $dirs_and_files =
        \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_dirsFiles\super_scandir(
            $target_apps_custom_pages_dir
            ) ;

    // -----------------------------------------------------------------------

    if ( $dirs_and_files === FALSE ) {

        return <<<EOT
PROBLEM:&nbsp; "super_scandir()" failure loading "custom pages"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

    }

    // -------------------------------------------------------------------------
    // So here we should have (eg):-
    //
    //      <plugins-custom-pages-dir>/
    //      +-- this-custom-page.cp/
    //      |   +-- page-display-file.php
    //      |   +-- page-data.php
    //      |   +-- ...other custom page files...
    //      +-- that-custom-page.cp/
    //      |   +-- page-display-file.php
    //      |   +-- page-data.php
    //      |   +-- ...other custom page files...
    //      +-- ...
    //      +-- the-other-custom-page.cp/
    //          +-- page-display-file.php
    //          +-- page-data.php
    //          +-- ...other custom page files...
    //
    // -------------------------------------------------------------------------

    // =========================================================================
    // LOAD the CUSTOM PAGES...
    // =========================================================================

    $custom_pages = array() ;

    // -------------------------------------------------------------------------

    foreach ( $dirs_and_files['dirs'] as $dir_basename => $dir_pathspec ) {

        // =====================================================================
        // Is this dir a "CUSTOM PAGE" dir ?
        // =====================================================================

        // ---------------------------------------------------------------------
        // Only dirs whose basename:-
        //
        //      1.  Ends in ".cp"
        //
        //      2.  Is otherwise lowercase alphnumeric and dash only (and
        //          at least 1 char long)
        //
        // are custom page dirs....
        // ---------------------------------------------------------------------

        if (    strlen( $dir_basename ) < 4
                ||
                substr( $dir_basename , -3 ) !== '.cp'
            ) {
            continue ;
                //  Skip this dir...
        }

        // =====================================================================
        // PROBABLY a "CUSTOM PAGE" DIR (if the custom page name/slug is OK)...
        // =====================================================================

        $custom_page_name_slash_slug =
            substr( $dir_basename , 0 , -3 )
            ;

        // ---------------------------------------------------------------------

        if (    ! \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_stringUtils\ctype_alphanumeric_dash(
                    $custom_page_name_slash_slug
                    )
                ||
                strtolower( $custom_page_name_slash_slug ) !== $custom_page_name_slash_slug
            ) {

            return <<<EOT
PROBLEM:&nbsp; Bad custom page name/slug (1 or more lowercase alphanumeric or dash characters expected)
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        }

        // =====================================================================
        // Contains "PAGE-DISPLAY-FILE"...
        // =====================================================================

        $page_display_filespec = $dir_pathspec . '/page-display-file.php' ;

        // ---------------------------------------------------------------------

        if ( ! is_file( $page_display_filespec ) ) {
            continue ;
               //  Skip this dir (not a useable custom page)...
        }

        // =====================================================================
        // Require/include the "page display file" - and make sure it contains
        // the page display function...
        // =====================================================================

        require_once( $page_display_filespec ) ;

        // ---------------------------------------------------------------------

        $page_display_routine =
            '\\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_' .
            \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_stringUtils\to_camel_case(
                $custom_page_name_slash_slug
                ) .
            '\\get_page_html'
            ;

        // ----------------------------------------------------------------------

        if ( ! function_exists( $page_display_routine ) ) {
            continue ;
               //  Skip this dir (not a useable custom page)...
        }

        // =====================================================================
        // Default the PAGE DATA...
        // =====================================================================

        $menu_title =
            \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_stringUtils\to_title(
                $custom_page_name_slash_slug
                ) ;
                //  The title for the page on the BACK-END "Home" page screen
                //  (that lists the custom pages).
                //
                //  Can be overridden in the "page data" (file)

        // ---------------------------------------------------------------------

        $general_title =
            $menu_title ;
                //  The title for the page - for use anywhere a "custom page
                //  title" is required.
                //
                //  Can be overridden in the "page data" (file)

        // =====================================================================
        // LOAD the page data from the "PAGE-DATA" file, if there is ONE...
        // =====================================================================

        $page_data_filespec = $dir_pathspec . '/page-data.php' ;

        $page_data = array() ;

        // ---------------------------------------------------------------------

        if ( is_file( $page_data_filespec ) ) {

            // -----------------------------------------------------------------
            // "PAGE DATA" FILE EXISTS
            // -----------------------------------------------------------------

            require_once( $page_data_filespec ) ;

            // -----------------------------------------------------------------

            $get_page_data_function_name =
                '\\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_' .
                \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_stringUtils\to_camel_case(
                    $custom_page_name_slash_slug
                    ) .
                '\\get_page_data'
                ;

            // -----------------------------------------------------------------

            if ( ! function_exists( $get_page_data_function_name ) ) {

                return <<<EOT
PROBLEM:&nbsp; "get_page_data()" function not found (in custom page data file)
For custom page name/slug:&nbsp; {$custom_page_name_slash_slug}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

            }

            // -----------------------------------------------------------------

            $page_data = $get_page_data_function_name() ;

            // -----------------------------------------------------------------

            if ( ! is_array( $page_data ) ) {

                return <<<EOT
PROBLEM:&nbsp; Bad "page data" (defined in custom page's data file) (array expected)
For custom page name/slug:&nbsp; {$custom_page_name_slash_slug}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

            }

            // -----------------------------------------------------------------

            if ( array_key_exists( 'menu_title' , $page_data ) ) {

                // -------------------------------------------------------------

                if (    ! is_string( $page_data['menu_title'] )
                        ||
                        trim( $page_data['menu_title'] ) === ''
                    ) {

                    return <<<EOT
PROBLEM:&nbsp; Bad "menu_title" (defined in custom page's data file) (non-empty string expected)
For custom page name/slug:&nbsp; {$custom_page_name_slash_slug}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

                }

                // -------------------------------------------------------------

                $menu_title = $page_data['menu_title'] ;

                // -------------------------------------------------------------

            }

            // -----------------------------------------------------------------

            if ( array_key_exists( 'general_title' , $page_data ) ) {

                // -------------------------------------------------------------

                if (    ! is_string( $page_data['general_title'] )
                        ||
                        trim( $page_data['general_title'] ) === ''
                    ) {

                    return <<<EOT
PROBLEM:&nbsp; Bad "general_title" (defined in custom page's data file) (non-empty string expected)
For custom page name/slug:&nbsp; {$custom_page_name_slash_slug}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

                }

                // -------------------------------------------------------------

                $general_title = $page_data['general_title'] ;

                // -------------------------------------------------------------

            }

            // -----------------------------------------------------------------

        }

        // =====================================================================
        // ADD this page to the CUSTOM PAGES array...
        // =====================================================================

        $custom_pages[ $custom_page_name_slash_slug ] = array(
            'menu_title'            =>  $menu_title                 ,
            'general_title'         =>  $general_title              ,
            'dirspec'               =>  $dir_pathspec               ,
            'page_display_filespec' =>  $page_display_filespec      ,
            'page_data_filespec'    =>  $page_data_filespec         ,
            'page_data'             =>  $page_data
            ) ;

        // =====================================================================
        // Repeat with the next "CUSTOM PAGES" sub-directory (if there is
        // one)...
        // =====================================================================

    }

    // =========================================================================
    // SUCCESS!
    // =========================================================================

    return $custom_pages ;

    // =========================================================================
    // That's that!
    // =========================================================================

}

// =============================================================================
// That's that!
// =============================================================================

