<?php

// *****************************************************************************
// TEASER-MAKER.APP / PLUGIN-STUFF / ADMIN / HOME.PHP
// (C) 2014 Peter Newman. All Rights Reserved.
// *****************************************************************************

    namespace greatKiwi_byFernTec_teaserMaker_std_v0x1x114_adminSection ;

// =============================================================================
// home_page()
// =============================================================================

function home_page() {

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_adminSection\home_page()
    // - - - - - - - - - - - - - - - - - - - - - - - -
    // Echos the admin page proper.
    //
    // RETURNS:
    //      Nothing
    // -------------------------------------------------------------------------

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $_GET = array(
    //                  [page] => teaserMaker
    //                  )
    //
    //      --OR--
    //
    //      $_GET = array(
    //                  [page]          => teaserMaker
    //                  [action]        => manage-projects
    //                  )
    //
    // -------------------------------------------------------------------------

//\pluginPlant_byFernTec_private\pr( $_GET ) ;

    // =========================================================================
    // ERROR CHECKING...
    // =========================================================================

    // -------------------------------------------------------------------------
    // Ignore apparently invalid calls...
    // -------------------------------------------------------------------------

    if (    ! isset( $_GET['page'] )
            ||
            $_GET['page'] !== 'teaserMakerStdV0x1x114'
        ) {
        return ;
    }

    // =========================================================================
    // Get the Admin COMMON stuff...
    // =========================================================================

//    require_once( dirname( __FILE__ ) . '/common.php' ) ;

    // =========================================================================
    // Get the plugin/app CORE DIRECTORIES...
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
    //          'apps_plugin_stuff_dir'             =>  "xxx"   ,   //  (3)
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
    //      \greatKiwi_byFernTec_teaserMaker_std_pluginVersion_appsAPI\get_single_app_defs_root_dir( __FILE__ ) ;
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
    $app_handle     = 'teaser-maker' ;

    // -------------------------------------------------------------------------

    $core_dirs = \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_appsAPI\get_core_plugapp_dirs(
                    $path_in_plugin     ,
                    $app_handle
                    ) ;

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $core_dirs = Array(
    //
    //          [plugin_root_dir]               =>
    //              /opt/lampp/htdocs/plugdev/wp-content/plugins/teaser-maker-v0.1
    //
    //          [plugins_includes_dir]          =>
    //              /opt/lampp/htdocs/plugdev/wp-content/plugins/teaser-maker-v0.1/includes
    //
    //          [plugins_app_defs_dir]          =>
    //              /opt/lampp/htdocs/plugdev/wp-content/plugins/teaser-maker-v0.1/app-defs
    //
    //          [dataset_manager_includes_dir]  =>
    //              /opt/lampp/htdocs/plugdev/wp-content/plugins/teaser-maker-v0.1/includes/dataset-manager
    //
    //          [apps_dot_app_dir]              =>
    //              /opt/lampp/htdocs/plugdev/wp-content/plugins/teaser-maker-v0.1/app-defs/teaser-maker.app
    //
    //          [apps_plugin_stuff_dir]         =>
    //              /opt/lampp/htdocs/plugdev/wp-content/plugins/teaser-maker-v0.1/app-defs/teaser-maker.app/plugin.stuff
    //
    //          )
    //
    // -------------------------------------------------------------------------

//pr( $core_dirs ) ;

    // =========================================================================
    // Call the Standard Dataset Manager...
    // =========================================================================

    require_once( $core_dirs['dataset_manager_includes_dir'] . '/home.php' ) ;

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_pluginVersion_standardDatasetManager\page_controller_wordpress_back_end(
    //      $dataset_manager_dataset_defs_dir               ,
    //      $caller_plugins_includes_dir                    ,
    //      $application_title                              ,
    //      $application_href                               ,
    //      $dataset_manager_home_page_title                ,
    //      $wordpress_admin_page_query_variable_value
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // Displays the currently selected Standard Dataset Manager page.
    //
    // The first time this routine is called, the currently selected Standard
    // Dataset Manager page will be the Standard Dataset Manager HOME page.
    //
    // But from the on, the currently selected Standard Dataset Manager page
    // may be one of the sub-pages selected from the home page, in order to
    // add, edit or delete records from whichever home page listed dataset was
    // selected for editing.
    //
    // RETURNS:
    //      Nothing
    // -------------------------------------------------------------------------

    $dataset_manager_dataset_defs_dir =
        $core_dirs['plugins_app_defs_dir']
        ;

    // -------------------------------------------------------------------------

    $caller_plugins_includes_dir = $core_dirs['plugins_includes_dir'] ;

    $caller_app_slash_plugins_global_namespace = 'pluginPlant_byFernTec' ;

    // -------------------------------------------------------------------------

    $application_title = 'Teaser Maker  Std 0.1.114' ;

    $application_href  = '?page=teaserMakerStdV0x1x114' ;

    // -------------------------------------------------------------------------

    $dataset_manager_home_page_title = 'Admin Home' ;

    // -------------------------------------------------------------------------

    $wordpress_admin_page_query_variable_value = 'teaserMakerStdV0x1x114' ;

    // -------------------------------------------------------------------------

    \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\page_controller_wordpress_back_end(
            $caller_app_slash_plugins_global_namespace      ,
            $dataset_manager_dataset_defs_dir               ,
            $caller_plugins_includes_dir                    ,
            $application_title                              ,
            $application_href                               ,
            $dataset_manager_home_page_title                ,
            $wordpress_admin_page_query_variable_value      ,
            $core_dirs
            ) ;

    // =========================================================================
    // That's that!
    // =========================================================================

}

// =============================================================================
// That's that!
// =============================================================================

