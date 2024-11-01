<?php

// ***************************************************************************
// SHORTCODES / STANDARD-DATASET-MANAGER.PHP
// (For WordPress Front-End)
// (C) 2013 Peter Newman. All Rights Reserved
// ***************************************************************************

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

// =============================================================================
// basepress_standard_dataset_manager
// =============================================================================

function basepress_standard_dataset_manager_shortcode_handler( $atts ) {

    // -------------------------------------------------------------------------
    // The syntax is:-
    //
    //      [basepress-standard-dataset-manager]
    //      [basepress_standard_dataset_manager]
    // -------------------------------------------------------------------------

//ob_start() ;
//pr( $atts ) ;
//return ob_get_clean() ;

    // -------------------------------------------------------------------------
    // NOTE!
    // =====
    // It's assumed that this shortcode handler file is in a plugin
    // includes directory structure like:-
    //
    //      <wordpress-site-root-dir>/wp-content/plugins/
    //      |
    //      +-- <plugin-root-dir>/
    //          |
    //          +-- dataset-manager-dataset-defs/
    //          |   +-- <this-dataset.php>
    //          |   +-- <that-dataset.php>
    //          |   +-- ...
    //          |
    //          +-- includes/
    //              |
    //              +-- dataset-manager/
    //              |   +-- home.php
    //              |   +-- ...other Standard Dataset Manager files...
    //              |
    //              +-- basepress/
    //                  +-- shortcodes/
    //                      +-- <THIS __FILE__.php>
    //                      +-- ...other shortcodes...
    //
    // -------------------------------------------------------------------------

    // =========================================================================
    // Get the CORE PLUGAPP DIRS...
    // =========================================================================

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_appsAPI\get_core_plugapp_dirs(
    //      $path_in_plugin         ,
    //      $app_handle = NULL
    //      )
    // - - - - - - - - - - - - - - - - - -
    // Returns the dirspecs of the main dirs used in a given app.  Ie:-
    //
    //      array(
    //          'plugin_root_dir'                   =>  "xxx"   ,
    //          'plugins_includes_dir'              =>  "xxx"   ,
    //          'plugins_app_defs_dir'              =>  "xxx"   ,
    //          'dataset_manager_includes_dir'      =>  "xxx"   ,   //  (1)
    //          'apps_dot_app_dir'                  =>  "xxx"   ,   //  (2)
    //          'apps_plugin_stuff_dir'             =>  "xxx"       //  (3)
    //          )
    //
    //      (1) This is where most of the "Dataset Manager" includes files
    //          are stored.
    //
    //      (2) If $app_handle === NULL, the returned $apps_dot_app_dir
    //          is NULL too.
    //
    //      (3) If $app_handle === NULL, the returned $apps_plugin_stuff_dir
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

    $path_in_plugin = __FILE__ ;
    $app_handle     = NULL     ;

    // -------------------------------------------------------------------------

    $core_plugapp_dirs = \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_appsAPI\get_core_plugapp_dirs(
                                $path_in_plugin     ,
                                $app_handle
                                ) ;

    // =========================================================================
    // GET the various DIRs used...
    // =========================================================================

//  $plugin_root_dir = dirname( dirname( dirname( dirname( __FILE__ ) ) ) ) ;
    $plugin_root_dir = $core_plugapp_dirs['plugin_root_dir'] ;

    // -------------------------------------------------------------------------

//  $plugin_includes_dir = $plugin_root_dir . '/includes' ;
    $plugin_includes_dir = $core_plugapp_dirs['plugins_includes_dir'] ;

    // -------------------------------------------------------------------------

//  $plugin_dataset_defs_dir = $plugin_root_dir . '/dataset-manager-dataset-defs' ;
    $plugin_dataset_defs_dir = $core_plugapp_dirs['plugins_app_defs_dir'] ;

    // =========================================================================
    // LOAD the STANDARD DATASET MANAGER...
    // =========================================================================

    require_once( $plugin_includes_dir . '/dataset-manager/home.php' ) ;

    // =========================================================================
    // CALL the STANDARD DATASET MANAGER...
    // =========================================================================

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\page_controller_wordpress_front_end(
    //      $dataset_manager_dataset_defs_dir               ,
    //      $caller_plugins_includes_dir                    ,
    //      $application_title                              ,
    //      $application_href                               ,
    //      $dataset_manager_home_page_title
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // Returns the currently selected Standard Dataset Manager page.
    //
    // The first time this routine is called, the currently selected Standard
    // Dataset Manager page will be the Standard Dataset Manager HOME page.
    //
    // But from the on, the currently selected Standard Dataset Manager page
    // may be one of the sub-pages selected from the home page, in order to
    // add, edit or delete records from whichever home page listed dataset was
    // selected for editing.
    //
    // NOTE!
    // =====
    // The returned page may be the page requested proper.  Or it may be just
    // the page header/footer, and an error message.
    //
    // RETURNS:
    //      $page_html STRING
    // -------------------------------------------------------------------------

    $caller_app_slash_plugins_global_namespace = 'researchAssistant_byFernTec' ;

    $dataset_manager_dataset_defs_dir = $plugin_dataset_defs_dir ;

    $caller_plugins_includes_dir = $plugin_includes_dir ;

//  $application_title = 'Research Assistant' ;
    $application_title = \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_appsAPI\get_plugin_title() ;

    $application_href = '' ;

    $dataset_manager_home_page_title = 'Dataset Manager' ;

    // -------------------------------------------------------------------------

    return \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\page_controller_wordpress_front_end(
                $caller_app_slash_plugins_global_namespace      ,
                $dataset_manager_dataset_defs_dir               ,
                $caller_plugins_includes_dir                    ,
                $application_title                              ,
                $application_href                               ,
                $dataset_manager_home_page_title
                ) ;

    // =========================================================================
    // That's that!
    // =========================================================================

}

// =============================================================================
// Add the shortcode...
// =============================================================================

    add_shortcode(
        'basepress-standard-dataset-manager'                    ,
        'basepress_standard_dataset_manager_shortcode_handler'
        ) ;

    // -------------------------------------------------------------------------

    add_shortcode(
        'basepress_standard_dataset_manager'                    ,
        'basepress_standard_dataset_manager_shortcode_handler'
        ) ;

// =============================================================================
// That's that!
// =============================================================================

