<?php

// *****************************************************************************
// REMOTE / GET-CACHED-PAGE.PHP
// (C) 2013 Peter Newman. All Rights Reserved
// *****************************************************************************

    // =========================================================================
    // Testing / Debugging
    // =========================================================================

    if ( ! function_exists( 'pr' ) ) {

        function pr( $value , $name = NULL ) {
            if ( $name === NULL ) {
                echo '<pre>' ;
            } else {
                echo '<h2>' , $name , '</h2><pre>' ;
            }
            print_r( $value ) ;
            echo '</pre>' ;
        }

    }

    // =========================================================================
    // ERROR CHECKING
    // =========================================================================

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $_GET = Array(
    //                  [page_name] => great-kiwi-standard-dataset-manager
    //                  [page_key]  => 52c10d3d424465.61838577-d7208...52353-452565991
    //                  )
    //
    // -------------------------------------------------------------------------

//pr( $_GET ) ;

    // -------------------------------------------------------------------------
    // page_name ?
    // -------------------------------------------------------------------------

    if ( ! isset( $_GET['page_name'] ) ) {

        echo <<<EOT
No "page_name"
EOT;

        return ;

    }

    // -------------------------------------------------------------------------

//  require_once( dirname( dirname( __FILE__ ) ) . '/common-for-plugin.php' ) ;

    require_once( dirname( dirname( __FILE__ ) ) . '/apps-api.php' ) ;

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

//  $fn = '\\greatKiwiwipluginMaker_byFernTec\\get_caller_app_slash_plugins_unique_name' ;
//
//  $app_slash_plugin_unique_name = $fn() ;

    $app_slash_plugins_unique_dashed_name =
        \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_appsAPI\get_plugin_slug_dashed()
        ;

    // -------------------------------------------------------------------------

    $allowed_page_names = array(

        $app_slash_plugins_unique_dashed_name . '-great-kiwi-standard-dataset-manager'  =>  array(
            'question_session_specific'     =>  TRUE    ,
            'question_remote_ip_specific'   =>  TRUE    ,
            'question_user_agent_specific'  =>  TRUE    ,
            'question_key_required'         =>  TRUE
            )   ,

        $app_slash_plugins_unique_dashed_name . '-great-kiwi-standard-dataset-manager-add-edit-form'    =>  array(
            'question_session_specific'     =>  TRUE    ,
            'question_remote_ip_specific'   =>  TRUE    ,
            'question_user_agent_specific'  =>  TRUE    ,
            'question_key_required'         =>  TRUE
            )

        ) ;

    // -------------------------------------------------------------------------

    if ( ! array_key_exists( $_GET['page_name'] , $allowed_page_names ) ) {

        echo <<<EOT
Unrecognised/unsupported "page_name"
EOT;

        return ;

    }

    // -------------------------------------------------------------------------

    $page_details = $allowed_page_names[ $_GET['page_name'] ] ;

    // -------------------------------------------------------------------------
    // page_key ?
    // -------------------------------------------------------------------------

    if ( $page_details['question_key_required'] ) {

        // ---------------------------------------------------------------------

        if ( ! isset( $_GET['page_key'] ) ) {

            echo <<<EOT
No "page_key"
EOT;

            return ;

        }

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // Define the INCLUDES dir...
    // =========================================================================

    $includes_dir = dirname( dirname( __FILE__ ) ) . '/includes' ;

    $wp_root_dir = dirname( dirname( dirname( dirname( dirname( __FILE__ ) ) ) ) ) ;

    // =========================================================================
    // GET the SUPPORT ROUTINES required...
    // =========================================================================

    require_once( $includes_dir . '/string-utils.php' ) ;

    require_once( $includes_dir . '/wordpress-page-cache.php' ) ;

    // =========================================================================
    // START WORDPRERSS...
    // =========================================================================

    // -------------------------------------------------------------------------
    // NOTE!
    // =====
    // If we re-wrote:-
    //      "wordpress-page-cache.php"
    //
    // to access the DB without using the WordPress DB support routines, then
    // we could eliminate the need to load WordPress.
    // -------------------------------------------------------------------------

    /**
     * Tells WordPress to load the WordPress theme and output it.
     *
     * @var bool
     */
    define( 'WP_USE_THEMES' , FALSE ) ;

    /** Loads the WordPress Environment and Template */
    require( $wp_root_dir . '/wp-blog-header.php' ) ;

    // =========================================================================
    // LOAD/RETURN the requested PAGE...
    // =========================================================================

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

    if ( $page_details['question_key_required'] ) {
        $page_key = $_GET['page_key'] ;

    } else {
        $page_key = '' ;

    }

    // -------------------------------------------------------------------------

    $page_content = \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_wordpressPageCache\get_page(
                        $_GET['page_name']                              ,
                        $page_key                                       ,
                        $page_details['question_session_specific']      ,
                        $page_details['question_remote_ip_specific']    ,
                        $page_details['question_user_agent_specific']
                        ) ;

    // -------------------------------------------------------------------------

    if ( ! is_array( $page_content ) ) {
        echo $page_content ;
    }

    // =========================================================================
    // That's that
    // =========================================================================

