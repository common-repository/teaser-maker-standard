<?php

// *****************************************************************************
// DATASET-MANAGER / HOME.PHP
// (C) 2013 Peter Newman. All Rights Reserved.
// *****************************************************************************

    namespace greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager ;

// =============================================================================
// page_controller_wordpress_front_end()
// =============================================================================

function page_controller_wordpress_front_end(
    $caller_app_slash_plugins_global_namespace      ,
    $dataset_manager_dataset_defs_dir               ,
    $caller_plugins_includes_dir                    ,
    $application_title                              ,
    $application_href                               ,
    $dataset_manager_home_page_title                ,
    $core_plugapp_dirs                              ,
    $display_options    = array()                   ,
    $submission_options = array()
    ) {

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\
    // page_controller_wordpress_front_end(
    //      $caller_app_slash_plugins_global_namespace      ,
    //      $dataset_manager_dataset_defs_dir               ,
    //      $caller_plugins_includes_dir                    ,
    //      $application_title                              ,
    //      $application_href                               ,
    //      $dataset_manager_home_page_title                ,
    //      $core_plugapp_dirs                              ,
    //      $display_options    = array()                   ,
    //      $submission_options = array()
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
    // NOTES!
    // ======
    // 1.   The page to be displayed is specified by the $_GET parameters.  Ie:-
    //
    //          $_GET = array(
    //                      [page] => pluginMaker
    //                      )       //  Displays the "Home" page
    //
    //          --OR--
    //
    //          $_GET = array(
    //                      [page]          =>  pluginMaker
    //                      [action]        =>  manage-dataset
    //                      [dataset_slug]  =>  projects
    //                      )       //  Displays the "Manage Projects Dataset"
    //                              //   page
    //
    //          --ETC, ETC--
    //
    // 2.   The returned page may be the page requested proper.  Or it may be
    //      just the page header/footer, and an error message.
    //
    // RETURNS:
    //      $page_html STRING
    // -------------------------------------------------------------------------

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $_GET = array(
    //                  [page] => pluginMaker
    //                  )
    //
    //      --OR--
    //
    //      $_GET = array(
    //                  [page]          =>  pluginMaker
    //                  [action]        =>  manage-dataset
    //                  [dataset_slug]  =>  projects
    //                  )
    //
    // -------------------------------------------------------------------------

    // =========================================================================
    // CALL the PAGE CONTROLLER routine PROPER...
    // =========================================================================

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\
    // page_controller_common(
    //      $caller_app_slash_plugins_global_namespace      ,
    //      $dataset_manager_dataset_defs_dir               ,
    //      $caller_plugins_includes_dir                    ,
    //      $application_title                              ,
    //      $application_href                               ,
    //      $dataset_manager_home_page_title                ,
    //      $core_plugapp_dirs                              ,
    //      $question_front_end                             ,
    //      $display_options                                ,
    //      $submission_options
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // Creates and returns the currently selected Standard Dataset Manager
    // page.
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

    $question_front_end = TRUE ;

    // -------------------------------------------------------------------------

    return page_controller_common(
            $caller_app_slash_plugins_global_namespace      ,
            $dataset_manager_dataset_defs_dir               ,
            $caller_plugins_includes_dir                    ,
            $application_title                              ,
            $application_href                               ,
            $dataset_manager_home_page_title                ,
            $core_plugapp_dirs                              ,
            $question_front_end                             ,
            $display_options                                ,
            $submission_options
            ) ;

    // =========================================================================
    // That's that!
    // =========================================================================

}

// =============================================================================
// page_controller_wordpress_back_end()
// =============================================================================

function page_controller_wordpress_back_end(
    $caller_app_slash_plugins_global_namespace      ,
    $dataset_manager_dataset_defs_dir               ,
    $caller_plugins_includes_dir                    ,
    $application_title                              ,
    $application_href                               ,
    $dataset_manager_home_page_title                ,
    $wordpress_admin_page_query_variable_value      ,
    $core_plugapp_dirs                              ,
    $display_options    = array()                   ,
    $submission_options = array()
    ) {

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\
    // page_controller_wordpress_back_end(
    //      $caller_app_slash_plugins_global_namespace      ,
    //      $dataset_manager_dataset_defs_dir               ,
    //      $caller_plugins_includes_dir                    ,
    //      $application_title                              ,
    //      $application_href                               ,
    //      $dataset_manager_home_page_title                ,
    //      $wordpress_admin_page_query_variable_value      ,
    //      $core_plugapp_dirs                              ,
    //      $display_options    = array()                   ,
    //      $submission_options = array()
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
    // NOTE!
    // =====
    // The returned page may be the page requested proper.  Or it may be just
    // the page header/footer, and an error message.
    //
    // RETURNS:
    //      Nothing
    // -------------------------------------------------------------------------

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $_GET = array(
    //                  [page] => protoPress
    //                  )
    //
    //      --OR--
    //
    //      $_GET = array(
    //                  [page]          =>  protoPress
    //                  [action]        =>  manage-dataset
    //                  [dataset_slug]  =>  projects
    //                  )
    //
    // -------------------------------------------------------------------------

    // =========================================================================
    // ERROR CHECKING...
    // =========================================================================

    // -------------------------------------------------------------------------
    // Ignore apparently invalid calls...
    // -------------------------------------------------------------------------

    if (    ! isset( $_GET['page'] )
            ||
            $_GET['page'] !== $wordpress_admin_page_query_variable_value
        ) {
        return ;
    }

    // =========================================================================
    // CALL the PAGE CONTROLLER routine PROPER...
    // =========================================================================

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\
    // page_controller_common(
    //      $caller_app_slash_plugins_global_namespace      ,
    //      $dataset_manager_dataset_defs_dir               ,
    //      $caller_plugins_includes_dir                    ,
    //      $application_title                              ,
    //      $application_href                               ,
    //      $dataset_manager_home_page_title                ,
    //      $core_plugapp_dirs                              ,
    //      $question_front_end                             ,
    //      $display_options    = array()                   ,
    //      $submission_options = array()
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // Creates and returns the currently selected Standard Dataset Manager
    // page.
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

    $question_front_end = FALSE ;

    // -------------------------------------------------------------------------

    echo page_controller_common(
            $caller_app_slash_plugins_global_namespace      ,
            $dataset_manager_dataset_defs_dir               ,
            $caller_plugins_includes_dir                    ,
            $application_title                              ,
            $application_href                               ,
            $dataset_manager_home_page_title                ,
            $core_plugapp_dirs                              ,
            $question_front_end
            ) ;

    // =========================================================================
    // That's that!
    // =========================================================================

}

// =============================================================================
// page_controller_common()
// =============================================================================

function page_controller_common(
    $caller_app_slash_plugins_global_namespace      ,
    $dataset_manager_dataset_defs_dir               ,
    $caller_plugins_includes_dir                    ,
    $application_title                              ,
    $application_href                               ,
    $dataset_manager_home_page_title                ,
    $core_plugapp_dirs                              ,
    $question_front_end                             ,
    $display_options    = array()                   ,
    $submission_options = array()
    ) {

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\
    // page_controller_common(
    //      $caller_app_slash_plugins_global_namespace      ,
    //      $dataset_manager_dataset_defs_dir               ,
    //      $caller_plugins_includes_dir                    ,
    //      $application_title                              ,
    //      $application_href                               ,
    //      $dataset_manager_home_page_title                ,
    //      $question_front_end                             ,
    //      $display_options    = array()                   ,
    //      $submission_options = array()
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // Creates and returns the currently selected Standard Dataset Manager
    // page.
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

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $_GET = array(
    //                  [page] => protoPress
    //                  )
    //
    //      --OR--
    //
    //      $_GET = array(
    //                  [page]          =>  protoPress
    //                  [action]        =>  manage-dataset
    //                  [dataset_slug]  =>  projects
    //                  )
    //
    // -------------------------------------------------------------------------

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $_GET ) ;

    // =========================================================================
    // Init.
    // =========================================================================

    $ns = __NAMESPACE__ ;
    $fn = __FUNCTION__  ;

    // =========================================================================
    // Get the Standard Dataset Manager COMMON stuff...
    // =========================================================================

    require_once( dirname( __FILE__ ) . '/common.php' ) ;

    // =========================================================================
    // HOME PAGE RAW MODE ?
    // =========================================================================

    $home_page_raw_mode_support_filespec = dirname( __FILE__ ) . '/home-page-raw-mode-support.php' ;

    // -------------------------------------------------------------------------

    if ( is_file( $home_page_raw_mode_support_filespec ) ) {

        // =====================================================================
        // RAW MODE ON...
        // =====================================================================

        require_once( $home_page_raw_mode_support_filespec ) ;

        $question_home_page_raw_mode = TRUE ;

        // ---------------------------------------------------------------------

    } else {

        // =====================================================================
        // RAW MODE OFF...
        // =====================================================================

        $question_home_page_raw_mode = FALSE ;

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // TABLES/FORMS RAW MODE ?
    // =========================================================================

    $table_forms_raw_mode_support_filespec = dirname( __FILE__ ) . '/raw-mode-support.php' ;

    if ( is_file( $table_forms_raw_mode_support_filespec ) ) {
        require_once( $table_forms_raw_mode_support_filespec ) ;
    }

    // =========================================================================
    // Set the link back to the application that's calling the Standard Dataset
    // Manager (which link goes in the Dataset Managers page and sub-page
    // headers)...
    // =========================================================================

    $GLOBALS['GREAT_KIWI']['STANDARD_DATASET_MANAGER']['calling_application_title'] =
        $application_title
        ;

    $GLOBALS['GREAT_KIWI']['STANDARD_DATASET_MANAGER']['calling_application_wordpress_admin_href'] =
        $application_href
        ;

    // =========================================================================
    // LOAD the plugin's "app_defs" directory tree (and the datasets and
    // views, etc, defined therein)...
    // =========================================================================

    require_once( dirname( __FILE__ ) . '/app-defs-support.php' ) ;

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\
    // load_app_defs_tree(
    //      $caller_app_slash_plugins_global_namespace      ,
    //      $caller_apps_includes_dir                       ,
    //      $question_front_end                             ,
    //      $tree_root_dir                                  ,
    //      $core_plugapp_dirs
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // Loads the application definitions in the specified directory tree.
    //
    // RETURNS:
    //      o   On SUCCESS!
    //          - - - - - -
    //          ARRAY(
    //              ARRAY $app_defs_directory_tree                          ,
    //              ARRAY $applications_dataset_and_view_definitions_etc
    //              )
    //
    //      o   On FAILURE!
    //          - - - - - -
    //          $error_message STRING
    // -------------------------------------------------------------------------

    $result = load_app_defs_tree(
                    $caller_app_slash_plugins_global_namespace      ,
                    $caller_plugins_includes_dir                    ,
                    $question_front_end                             ,
                    $dataset_manager_dataset_defs_dir               ,
                    $core_plugapp_dirs
                    ) ;

    // -------------------------------------------------------------------------

    if ( is_string( $result ) ) {

        return standard_dataset_manager_error(
                    $dataset_manager_home_page_title    ,
                    $result                             ,
                    $caller_plugins_includes_dir        ,
                    $question_front_end
                    ) ;

    }

    // -------------------------------------------------------------------------

    list(
        $app_defs_directory_tree                          ,
        $applications_dataset_and_view_definitions_etc
        ) = $result ;

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $app_defs_directory_tree = Array(
    //
    //          [dirs] => Array(
    //
    //              [/opt/lampp/htdocs/plugdev/wp-content/plugins/research-assistant/app-defs/_old_] => Array(
    //                  [dirs]  => Array()
    //                  [files] => Array(
    //                      [0] => projects.php
    //                      [1] => reference-url-resources.php
    //                      [2] => reference-urls.php
    //                      )
    //                  [other] => Array(
    //                      [0] => .
    //                      [1] => ..
    //                      )
    //                  )
    //
    //              [/opt/lampp/htdocs/plugdev/wp-content/plugins/research-assistant/app-defs/research-assistant.app] => Array(
    //                  [dirs]  => Array()
    //                  [files] => Array()
    //                  [other] => Array(
    //                      [0] => .
    //                      [1] => ..
    //                      )
    //                  )
    //
    //              )
    //
    //          [files] => Array(
    //              [0] => categories.bak
    //              [1] => categories.php
    //              [2] => categories.php-thp.html
    //              [3] => category-resources.bak
    //              [4] => category-resources.php
    //              [5] => projects.bak
    //              [6] => projects.php
    //              [7] => url-resources.bak
    //              [8] => url-resources.php
    //              [9] => urls.bak
    //              [10] => urls.php
    //              )
    //
    //          [other] => Array(
    //              [0] => .
    //              [1] => ..
    //              )
    //
    //          )
    //
    // -------------------------------------------------------------------------

//pr( $app_defs_directory_tree ) ;

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $applications_dataset_and_view_definitions_etc = array(
    //
    //          [dirspec]               => /opt/lampp/htdocs.../app-defs
    //
    //          [app_path]              =>
    //
    //          [app_data]              => Array(
    //                                          [app_slug]  => dataset_manager_dataset_defs
    //                                          [app_title] => Dataset Manager Dataset Defs
    //                                          )
    //
    //          [sub_apps]              => Array(
    //
    //              [research-assistant] => Array(
    //
    //                  [dirspec]               => /opt/lampp/htdocs/.../research-assistant.app
    //
    //                  [app_path]              => research-assistant
    //
    //                  [app_data]              => Array(
    //                                                  [app_slug]              => research_assistant
    //                                                  [app_title]             => Research Assistant
    //                                                  [dataset_listing_order] => Array(
    //                                                      [0] => projects
    //                                                      [1] => categories
    //                                                      [2] => urls
    //                                                      )
    //
    //                  )
    //
    //                  [sub_apps]            => Array()
    //
    //                  [dataset_definitions] => Array(
    //
    //                      [categories] => Array(
    //                          [dataset_slug]                      => categories
    //                          [dataset_name_singular]             => category
    //                          [dataset_name_plural]               => categories
    //                          [dataset_title_singular]            => Category
    //                          [dataset_title_plural]              => Categories
    //                          [basepress_dataset_handle]          => Array(
    //                              [nice_name]     => researchAssistant_byFernTec_categories
    //                              [unique_key]    => 6934fccc-c552-46b0-8db5-87a02...f7adf54
    //                              [version]       => 0.1
    //                              )
    //                          [dataset_records_table]             => Array(...)
    //                          [zebra_form]                        => Array(...)
    //                          [array_storage_record_structure]    => Array(...)
    //                          [array_storage_key_field_slug]      => key
    //                          )
    //
    //                      [projects] => Array(
    //                          [dataset_slug]                      => projects
    //                          [dataset_name_singular]             => project
    //                          [dataset_name_plural]               => projects
    //                          [dataset_title_singular]            => Project
    //                          [dataset_title_plural]              => Projects
    //                          [basepress_dataset_handle]          => Array(
    //                              [nice_name]     => researchAssistant_byFernTec_projects
    //                              [unique_key]    => d2562b23-3c20-4368-92c4-2b...0c9a66
    //                              [version]       => 0.1
    //                              )
    //                          [dataset_records_table]             => Array(...)
    //                          [zebra_form]                        => Array(...)
    //                          [array_storage_record_structure]    => Array(...)
    //                          [array_storage_key_field_slug]      => key
    //                          )
    //
    //                      [urls] => Array(
    //                          [dataset_slug]                      => urls
    //                          [dataset_name_singular]             => url
    //                          [dataset_name_plural]               => urls
    //                          [dataset_title_singular]            => URL
    //                          [dataset_title_plural]              => URLs
    //                          [basepress_dataset_handle]          => Array(
    //                              [nice_name]     => researchAssistant_byFernTec_urls
    //                              [unique_key]    => 7d800cd3-8787-49ea-9058-68db...5097b13
    //                              [version]       => 0.1
    //                              )
    //                          [dataset_records_table]             => Array(...)
    //                          [zebra_form]                        => Array(...)
    //                          [array_storage_record_structure]    => Array(...)
    //                          [array_storage_key_field_slug]      => key
    //                          )
    //
    //                      )
    //
    //                  [views] => Array(
    //
    //                      [url_tree] => Array(
    //                          [view_slug] => url_tree
    //                          ...
    //                          )
    //
    //                      )
    //
    //                  )
    //              )
    //
    //          [dataset_definitions]   => Array()
    //
    //          [views]                 => Array()
    //
    //          )
    //
    // -------------------------------------------------------------------------

//pr( $applications_dataset_and_view_definitions_etc ) ;

    // =========================================================================
    // SUB-PAGE SUPPORT...
    // =========================================================================

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $_GET = array(
    //                  [page] => researchAssistant
    //                  )
    //
    //      --OR--
    //
    //      $_GET = array(
    //                  [page]          =>  protoPress
    //                  [action]        =>  manage-dataset
    //                  [application]   =>  research-assistant/tree-version
    //                  [dataset_slug]  =>  projects
    //                  )
    //
    // -------------------------------------------------------------------------

    if ( array_key_exists( 'action' , $_GET ) ) {

        // ---------------------------------------------------------------------

        if ( $_GET['action'] === 'custom-page' ) {

            // =================================================================
            // CUSTOM-PAGE
            // =================================================================

            // -------------------------------------------------------------------------
            // do_custom_page(
            //      $core_plugapp_dirs                                  ,
            //      $applications_dataset_and_view_definitions_etc      ,
            //      $question_front_end
            //      )
            // - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
            // Handles a GET call with:-
            //      $_GET['action'] = 'custom-page'
            //
            // RETURNS
            //      o   On SUCCESS
            //              $page_html STRING
            //              (The HTML for the page to be displayed.)
            //
            //      o   On FAILURE
            //              ARRAY( $error_message ) STRING
            // -------------------------------------------------------------------------

            $result = do_custom_page(
                            $core_plugapp_dirs                                  ,
                            $applications_dataset_and_view_definitions_etc      ,
                            $question_front_end
                            ) ;

            // -----------------------------------------------------------------

            if ( is_array( $result ) ) {

                return standard_dataset_manager_error(
                            $dataset_manager_home_page_title    ,
                            $result[0]                          ,
                            $caller_plugins_includes_dir        ,
                            $question_front_end
                            ) ;

            }

            // -----------------------------------------------------------------

            return $result ;

            // -----------------------------------------------------------------

        } else {

            // =================================================================
            // NOT "CUSTOM PAGE"
            // =================================================================

            $allowed_standard_actions = array(

                'manage-dataset'    =>  NULL    ,

                'add-record'        =>  array(
                                            'basename'      =>  'add-edit-record.php'                                   ,
                                            'function_name' =>  '\\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\add_edit_record'   ,
                                            'object_type'   =>  'dataset'
                                            )   ,

                'edit-record'       =>  array(
                                            'basename'      =>  'add-edit-record.php'                                   ,
                                            'function_name' =>  '\\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\add_edit_record'   ,
                                            'object_type'   =>  'dataset'
                                            )   ,

                'delete-record'     =>  array(
                                            'basename'      =>  'delete-record.php'                                     ,
                                            'function_name' =>  '\\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\delete_record'     ,
                                            'object_type'   =>  'dataset'
                                            )   ,

                'show-view'         =>  array(
                                            'basename'      =>  'show-view.php'                                         ,
                                            'function_name' =>  '\\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\show_view'         ,
                                            'object_type'   =>  'view'
                                            )

                ) ;

            // -----------------------------------------------------------------

            if ( $question_home_page_raw_mode === TRUE ) {

                $allowed_standard_actions['view-raw'] = array(
                    'basename'      =>  'home-page-raw-mode-support/view-raw.php'                                     ,
                    'function_name' =>  '\\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\view_raw'     ,
                    'object_type'   =>  'dataset'
                    ) ;

                $allowed_standard_actions['export-raw'] = array(
                    'basename'      =>  'home-page-raw-mode-support/export-raw.php'                                     ,
                    'function_name' =>  '\\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\export_raw'     ,
                    'object_type'   =>  'dataset'
                    ) ;

                $allowed_standard_actions['import-raw'] = array(
                    'basename'      =>  'home-page-raw-mode-support/import-raw.php'                                     ,
                    'function_name' =>  '\\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\import_raw'     ,
                    'object_type'   =>  'dataset'
                    ) ;

            }

            // -----------------------------------------------------------------

            if (    $_GET['action'] === 'custom'
                    ||
                    array_key_exists( $_GET['action'] , $allowed_standard_actions )
                ) {

                // :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
                // AN ALLOWED ACTION "STANDARD" ACTION - OR A "CUSTOM" ACTION -
                // WAS REQUESTED...
                // :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

                // =============================================================
                // application_path ?
                // =============================================================

                if ( array_key_exists( 'application' , $_GET ) ) {
                    $application_path = trim( $_GET['application'] ) ;

                } else {
                    $application_path = '' ;

                }

                // =============================================================
                // GET the application's DATASET DEFINITIONS...
                // =============================================================

                // -------------------------------------------------------------------------
                // get_application_dataset_definitions(
                //      $applications_dataset_and_view_definitions_etc   ,
                //      $target_app_path
                //      )
                // - - - - - - - - - - - - - - - - - - - - - - - - - - - -
                // RETURNS
                //      o   ARRAY $all_application_dataset_definitions
                //          --> Target app. found - and has 1+ dataset definitions
                //
                //      o   $error_message STRING
                //          --> Error encountered; search abandoned
                //
                //      o   FALSE
                //          --> Target app. NOT found (after searching whole tree)
                // -------------------------------------------------------------------------

                $result =  get_application_dataset_definitions(
                                $applications_dataset_and_view_definitions_etc   ,
                                $application_path
                                ) ;

                // -------------------------------------------------------------

                if ( is_array( $result ) ) {

                    $all_application_dataset_definitions = $result ;

                } elseif ( is_string( $result ) ) {

                    return standard_dataset_manager_error(
                                $dataset_manager_home_page_title    ,
                                $result                             ,
                                $caller_plugins_includes_dir        ,
                                $question_front_end
                                ) ;

                } else {

                    $msg = <<<EOT
DATASET MANAGER PROBLEM:&nbsp; Unrecognised/unsupported application ("{$application_path}")
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

                    return standard_dataset_manager_error(
                                $dataset_manager_home_page_title    ,
                                $msg                                ,
                                $caller_plugins_includes_dir        ,
                                $question_front_end
                                ) ;

                }

                // =============================================================
                // Is this a VIEW-RELATED ACTION ?
                // =============================================================

                if (    $_GET['action'] !== 'custom'
                        &&
                        is_array( $allowed_standard_actions[ $_GET['action'] ] )
                        &&
                        array_key_exists( 'object_type' , $allowed_standard_actions[ $_GET['action'] ] )
                        &&
                        $allowed_standard_actions[ $_GET['action'] ]['object_type'] === 'view'
                    ) {
                    $question_view_related_action = TRUE ;

                } else {
                    $question_view_related_action = FALSE ;

                }

                // =============================================================
                // GET the application's VIEW DEFINITIONS (if needed)...
                // =============================================================

                if ( $question_view_related_action ) {

                    // -------------------------------------------------------------------------
                    // get_application_view_definitions(
                    //      $applications_dataset_and_view_definitions_etc   ,
                    //      $target_app_path
                    //      )
                    // - - - - - - - - - - - - - - - - - - - - - - - - - - - -
                    // RETURNS
                    //      o   ARRAY $all_application_view_definitions
                    //          --> Target app. found - and has 1+ view definitions
                    //
                    //      o   $error_message STRING
                    //          --> Error encountered; search abandoned
                    //
                    //      o   FALSE
                    //          --> Target app. NOT found (after searching whole tree)
                    // -------------------------------------------------------------------------

                    $result =  get_application_view_definitions(
                                    $applications_dataset_and_view_definitions_etc   ,
                                    $application_path
                                    ) ;

                    // ---------------------------------------------------------

                    if ( is_array( $result ) ) {

                        $all_application_view_definitions = $result ;

                    } elseif ( is_string( $result ) ) {

                        return standard_dataset_manager_error(
                                    $dataset_manager_home_page_title    ,
                                    $result                             ,
                                    $caller_plugins_includes_dir        ,
                                    $question_front_end
                                    ) ;

                    } else {

                        $msg = <<<EOT
DATASET MANAGER PROBLEM:&nbsp; Unrecognised/unsupported application ("{$application_path}")
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

                        return standard_dataset_manager_error(
                                    $dataset_manager_home_page_title    ,
                                    $msg                                ,
                                    $caller_plugins_includes_dir        ,
                                    $question_front_end
                                    ) ;

                    }

                    // ---------------------------------------------------------

                }

                // =============================================================
                // dataset_slug ?
                // =============================================================

                if ( $question_view_related_action ) {

                    // ---------------------------------------------------------

                    if (    isset( $_GET['dataset_slug'] )
                            &&
                            ! array_key_exists( $_GET['dataset_slug'] , $all_application_dataset_definitions )
                        ) {

                        $safe_dataset_slug = htmlentities( $_GET['dataset_slug'] ) ;

                        $msg = <<<EOT
DATASET MANAGER PROBLEM:&nbsp; Unrecognised/unsupported dataset: "{$safe_dataset_slug}"
Specified for "action" = "{$_GET['action']}" request
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

                        return standard_dataset_manager_error(
                            $dataset_manager_home_page_title    ,
                            $msg                                ,
                            $caller_plugins_includes_dir        ,
                            $question_front_end
                            ) ;

                    }

                    // ---------------------------------------------------------

                } else {

                    // ---------------------------------------------------------

                    if ( ! isset( $_GET['dataset_slug'] ) ) {

                        $msg = <<<EOT
DATASET MANAGER PROBLEM:&nbsp; No dataset specified (for "action" = "{$_GET['action']}" request)
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

                        return standard_dataset_manager_error(
                            $dataset_manager_home_page_title    ,
                            $msg                                ,
                            $caller_plugins_includes_dir        ,
                            $question_front_end
                            ) ;

                    }

                    // ---------------------------------------------------------

                    if ( ! array_key_exists( $_GET['dataset_slug'] , $all_application_dataset_definitions ) ) {

                        $safe_dataset_slug = htmlentities( $_GET['dataset_slug'] ) ;

                        $msg = <<<EOT
DATASET MANAGER PROBLEM:&nbsp; Unrecognised/unsupported dataset: "{$safe_dataset_slug}"
Specified for "action" = "{$_GET['action']}" request
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

                        return standard_dataset_manager_error(
                            $dataset_manager_home_page_title    ,
                            $msg                                ,
                            $caller_plugins_includes_dir        ,
                            $question_front_end
                            ) ;

                    }

                    // ---------------------------------------------------------

                }

                // =============================================================
                // view_slug ?
                // =============================================================

                if ( $question_view_related_action ) {

                    // ---------------------------------------------------------

                    if ( ! isset( $_GET['view_slug'] ) ) {

                        $msg = <<<EOT
DATASET MANAGER PROBLEM:&nbsp; No VIEW specified (for "action" = "{$_GET['action']}" request)
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

                        return standard_dataset_manager_error(
                            $dataset_manager_home_page_title    ,
                            $msg                                ,
                            $caller_plugins_includes_dir        ,
                            $question_front_end
                            ) ;

                    }

                    // ---------------------------------------------------------

                    if ( ! array_key_exists( $_GET['view_slug'] , $all_application_view_definitions ) ) {

                        $safe_view_slug = htmlentities( $_GET['view_slug'] ) ;

                        $msg = <<<EOT
DATASET MANAGER PROBLEM:&nbsp; Unrecognised/unsupported view: "{$safe_view_slug}"
Specified for "action" = "{$_GET['action']}" request
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

                        return standard_dataset_manager_error(
                            $dataset_manager_home_page_title    ,
                            $msg                                ,
                            $caller_plugins_includes_dir        ,
                            $question_front_end
                            ) ;

                    }

                    // ---------------------------------------------------------

                } else {

                    // ---------------------------------------------------------

                    $all_application_view_definitions = NULL ;

                    // ---------------------------------------------------------

                }

                // =============================================================
                // LOAD and INITIALISE the ARRAY STORAGE...
                // =============================================================

                require_once( $caller_plugins_includes_dir . '/array-storage.php' ) ;

                // -------------------------------------------------------------------------
                // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_arrayStorage\
                // init(
                //      $default_storage_method         ,
                //      $json_data_files_dir = NULL     ,
                //      $supported_datasets = array()
                //      )
                // - - - - - - - - - - - - - - - - -
                // You MUST call this function - to initialise the array starage system -
                // BEFORE calling any of the array storage functions proper.  Ie; before
                // calling:-
                //      o   load()
                //      o   load_numerically_indexed()
                //      o   save()
                //      o   save_numerically_indexed()
                //      o   (etc)
                //
                // $supported_datasets must be a (possibly empty) array like (eg):-
                //
                //      $supported_datasets = array(
                //          <dataset-slug>  =>  <array-storage-specs>
                //          ...
                //          )
                //
                // Eg:-
                //
                //      $supported_datasets = array(
                //
                //          'projects'    =>  array(
                //                                  'storage_method'            =>  NULL        ,
                //                                  'json_filespec'             =>  NULL        ,
                //                                  'basepress_dataset_handle'  =>  array(
                //                                      'nice_name'     =>  'protoPress_byFernTec_test'             ,
                //                                      'unique_key'    =>  'a6acf950-63d3-11e3-949a-0800200c9a66'  ,
                //                                      'version'       =>  '0.1'
                //                                      )
                //                                  )   ,
                //
                //          ...
                //
                //          )
                //
                // RETURNS
                //      o   On SUCCESS
                //          - - - - -
                //          TRUE
                //
                //      o   On FAILURE
                //          - - - - -
                //          $error_message STRING
                // -------------------------------------------------------------------------

                $default_storage_method = 'basepress-dataset' ;
                $json_data_files_dir    = NULL ;
                $supported_datasets     = array() ;

                // -------------------------------------------------------------

                foreach ( $all_application_dataset_definitions as $dataset_slug => $dataset_details ) {

                    $supported_datasets[ $dataset_slug ] = array(
                        'storage_method'            =>  NULL                                            ,
                        'json_filespec'             =>  NULL                                            ,
                        'basepress_dataset_handle'  =>  $dataset_details['basepress_dataset_handle']
                        ) ;

                }

                // -------------------------------------------------------------

                $result = \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_arrayStorage\init(
                                $default_storage_method     ,
                                $json_data_files_dir        ,
                                $supported_datasets
                                ) ;

                // -------------------------------------------------------------

                if ( is_string( $result ) ) {

                    return standard_dataset_manager_error(
                        $dataset_manager_home_page_title    ,
                        $result                             ,
                        $caller_plugins_includes_dir        ,
                        $question_front_end
                        ) ;

                }

                // =============================================================
                // Call the "ACTION" HANDLER ROUTINE...
                // =============================================================

                if ( $_GET['action'] === 'custom' ) {

                    // -------------------------------------------------------------------------
                    // call_custom_action_handler(
                    //      $caller_app_slash_plugins_global_namespace      ,
                    //      $dataset_manager_home_page_title                ,
                    //      $caller_plugins_includes_dir                    ,
                    //      $all_application_dataset_definitions            ,
                    //      $question_front_end
                    //      )
                    // - - - - - - - - - - - - - - - - - - - - - - - - - - -
                    // Returns (the HTML for) the page to be displayed.
                    //
                    // NOTE!
                    // =====
                    // The page to be displayed might be the requested page proper.  Or it
                    // might just be some error message.
                    // -------------------------------------------------------------------------

                    return call_custom_action_handler(
                                $caller_app_slash_plugins_global_namespace      ,
                                $dataset_manager_home_page_title                ,
                                $caller_plugins_includes_dir                    ,
                                $all_application_dataset_definitions            ,
                                $question_front_end
                                ) ;

                    // ---------------------------------------------------------

                } else  {

                    // -------------------------------------------------------------------------
                    // call_standard_action_handler(
                    //      $caller_app_slash_plugins_global_namespace      ,
                    //      $dataset_manager_home_page_title                ,
                    //      $caller_plugins_includes_dir                    ,
                    //      $all_application_dataset_definitions            ,
                    //      $all_application_view_definitions               ,
                    //      $question_front_end                             ,
                    //      $allowed_standard_actions                       ,
                    //      $question_view_related_action                   ,
                    //      $display_options    = array()                   ,
                    //      $submission_options = array()
                    //      )
                    // - - - - - - - - - - - - - - - - - - - - - - - - - - -
                    // Returns (the HTML for) the page to be displayed.
                    //
                    // NOTE!
                    // =====
                    // The page to be displayed might be the requested page proper.  Or it
                    // might just be some error message.
                    // -------------------------------------------------------------------------

                    return call_standard_action_handler(
                                $caller_app_slash_plugins_global_namespace      ,
                                $dataset_manager_home_page_title                ,
                                $caller_plugins_includes_dir                    ,
                                $all_application_dataset_definitions            ,
                                $all_application_view_definitions               ,
                                $question_front_end                             ,
                                $allowed_standard_actions                       ,
                                $question_view_related_action                   ,
                                $display_options                                ,
                                $submission_options
                                ) ;

                    // ---------------------------------------------------------

                }

                // -------------------------------------------------------------

            } else {

                // =============================================================
                // ERROR
                // =============================================================

                //  NYI - Just IGNORE this action request (and display the
                //  Dataset Manager "Home Page" screen)...

                // -------------------------------------------------------------

            }

            // -----------------------------------------------------------------

        }

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // GET the APPLICATIONS and DATASETS LISTING (for the HOME PAGE PROPER)...
    // =========================================================================

    require_once( dirname( __FILE__ ) . '/home-support.php' ) ;

    // -------------------------------------------------------------------------
    // list_applications_and_their_datasets_and_views_etc(
    //      $caller_app_slash_plugins_global_namespace          ,
    //      $caller_apps_includes_dir                           ,
    //      $question_front_end                                 ,
    //      $applications_dataset_and_view_definitions_etc      ,
    //      $application_slug                                   ,
    //      $application_path                                   ,
    //      $level
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // RETURNS
    //      o   On SUCCESS!
    //          - - - - - -
    //          $applications_and_datasets_html STRING
    //
    //      o   On FAILURE!
    //          - - - - - -
    //          array( $error_message STRING )
    // -------------------------------------------------------------------------

    $application_slug = '' ;
    $application_path = '' ;
    $level            = 0 ;

    // -------------------------------------------------------------------------

    $applications_and_datasets_html = list_applications_and_their_datasets_and_views_etc(
                                            $caller_app_slash_plugins_global_namespace          ,
                                            $caller_plugins_includes_dir                        ,
                                            $question_front_end                                 ,
                                            $applications_dataset_and_view_definitions_etc      ,
                                            $application_slug                                   ,
                                            $application_path                                   ,
                                            $level
                                            ) ;

    // -------------------------------------------------------------------------

    if ( is_array( $applications_and_datasets_html ) ) {

        return standard_dataset_manager_error(
            $dataset_manager_home_page_title        ,
            $applications_and_datasets_html[0]      ,
            $caller_plugins_includes_dir            ,
            $question_front_end
            ) ;

    }

    // =========================================================================
    // Create and return the HOME PAGE PROPER...
    // =========================================================================

    $page_header = get_page_header(
                        $dataset_manager_home_page_title    ,
                        $caller_plugins_includes_dir        ,
                        $question_front_end
                        ) ;

    // -------------------------------------------------------------------------

    return <<<EOT
{$page_header}
<br />
{$applications_and_datasets_html}
<br />
<br />
EOT;

    // =========================================================================
    // That's that!
    // =========================================================================

}

// =============================================================================
// call_standard_action_handler()
// =============================================================================

function call_standard_action_handler(
    $caller_app_slash_plugins_global_namespace      ,
    $dataset_manager_home_page_title                ,
    $caller_plugins_includes_dir                    ,
    $all_application_dataset_definitions            ,
    $all_application_view_definitions               ,
    $question_front_end                             ,
    $allowed_standard_actions                       ,
    $question_view_related_action                   ,
    $display_options    = array()                   ,
    $submission_options = array()
    ) {

    // -------------------------------------------------------------------------
    // call_standard_action_handler(
    //      $caller_app_slash_plugins_global_namespace      ,
    //      $dataset_manager_home_page_title                ,
    //      $caller_plugins_includes_dir                    ,
    //      $all_application_dataset_definitions            ,
    //      $all_application_view_definitions               ,
    //      $question_front_end                             ,
    //      $allowed_standard_actions                       ,
    //      $question_view_related_action                   ,
    //      $display_options    = array()                   ,
    //      $submission_options = array()
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // Returns (the HTML for) the page to be displayed.
    //
    // NOTE!
    // =====
    // The page to be displayed might be the requested page proper.  Or it
    // might just be some error message.
    // -------------------------------------------------------------------------

    if (    is_array( $allowed_standard_actions[ $_GET['action'] ] )
            &&
            isset( $allowed_standard_actions[ $_GET['action'] ]['basename'] )
            &&
            is_string( $allowed_standard_actions[ $_GET['action'] ]['basename'] )
        ) {
        $basename = trim( $allowed_standard_actions[ $_GET['action'] ]['basename'] ) ;

    } else {
        $basename = '' ;

    }

    // -------------------------------------------------------------------------

    if ( $basename === '' ) {
        $basename = $_GET['action'] . '.php' ;
    }

    // -------------------------------------------------------------------------

    require_once( dirname( __FILE__ ) . '/' . $basename ) ;

    // -------------------------------------------------------------------------

    if (    is_array( $allowed_standard_actions[ $_GET['action'] ] )
            &&
            isset( $allowed_standard_actions[ $_GET['action'] ]['function_name'] )
            &&
            is_string( $allowed_standard_actions[ $_GET['action'] ]['function_name'] )
        ) {
        $action_fn = trim( $allowed_standard_actions[ $_GET['action'] ]['function_name'] ) ;

    } else {
        $action_fn = '' ;

    }

    // -------------------------------------------------------------------------

    if (    $action_fn === ''
            ||
            ! function_exists( $action_fn )
        ) {

        $action_name_with_underscores = str_replace( '-' , '_' , $_GET['action'] ) ;
            //  Eg: "manage-datasets" => "manage_datasets"

//      $action_fn = '\\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\' . $action_name_with_underscores ;
        $action_fn = __NAMESPACE__ . '\\' . $action_name_with_underscores ;

    }

    // -------------------------------------------------------------------------
    // The action handlers are like (eg):-
    //
    //  "DATASET" RELATED HANDLERS...
    //
    //      \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\
    //      manage_dataset(
    //          $caller_app_slash_plugins_global_namespace      ,
    //          $dataset_manager_home_page_title                ,
    //          $caller_plugins_includes_dir                    ,
    //          $all_application_dataset_definitions            ,
    //          $dataset_slug                                   ,
    //          $question_front_end                             ,
    //          $display_options                                ,
    //          $submission_options
    //          )
    //
    // "VIEW" RELATED HANDLERS...
    //
    //      \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\
    //      manage_dataset(
    //          $caller_app_slash_plugins_global_namespace      ,
    //          $dataset_manager_home_page_title                ,
    //          $caller_plugins_includes_dir                    ,
    //          $all_application_dataset_definitions            ,
    //          $all_application_view_definitions               ,
    //          $view_slug                                      ,
    //          $question_front_end
    //          )
    //
    // And:-
    //
    //  o   RETURNS a (possibly error message only) screen as appropriate
    //      for the action concerned
    //
    //  o   RETURNS
    //          $page_html STRING
    // -------------------------------------------------------------------------

    if ( $question_view_related_action ) {

        return $action_fn(
                    $caller_app_slash_plugins_global_namespace      ,
                    $dataset_manager_home_page_title                ,
                    $caller_plugins_includes_dir                    ,
                    $all_application_dataset_definitions            ,
                    $all_application_view_definitions               ,
                    $_GET['view_slug']                              ,
                    $question_front_end
                    ) ;

    } else {

        return $action_fn(
                    $caller_app_slash_plugins_global_namespace      ,
                    $dataset_manager_home_page_title                ,
                    $caller_plugins_includes_dir                    ,
                    $all_application_dataset_definitions            ,
                    $_GET['dataset_slug']                           ,
                    $question_front_end                             ,
                    $display_options                                ,
                    $submission_options
                    ) ;

    }

    // -------------------------------------------------------------------------

}

// =============================================================================
// call_custom_action_handler()
// =============================================================================

function call_custom_action_handler(
    $caller_app_slash_plugins_global_namespace      ,
    $dataset_manager_home_page_title                ,
    $caller_plugins_includes_dir                    ,
    $all_application_dataset_definitions            ,
    $question_front_end
    ) {

    // -------------------------------------------------------------------------
    // call_custom_action_handler(
    //      $caller_app_slash_plugins_global_namespace      ,
    //      $dataset_manager_home_page_title                ,
    //      $caller_plugins_includes_dir                    ,
    //      $all_application_dataset_definitions            ,
    //      $question_front_end
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // Returns (the HTML for) the page to be displayed.
    //
    // NOTE!
    // =====
    // The page to be displayed might be the requested page proper.  Or it
    // might just be some error message.
    // -------------------------------------------------------------------------

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $_GET = Array(
    //                  [page]          => researchAssistant
    //                  [action]        => custom
    //                  [action_slug]   => select-dirs-files
    //                  [application]   => plugin-exporter
    //                  [dataset_slug]  => plugins
    //                  [record_key]    => 52f8561b5c068
    //                  )
    //
    // -------------------------------------------------------------------------

//pr( $_GET ) ;

    // -------------------------------------------------------------------------
    // NOTE!
    // =====
    // The custom action to be run is described in the dataset's:-
    //      "custom_actions"
    //
    // parameter.  Eg:-
    //
    //      <dataset>['custom_actions'] = array(
    //
    //          array(
    //              'slug'      =>  'select-dirs-files'                     ,
    //              'args'      =>  array(
    //                                  'include_filespec'              =>  'select-dirs-and-files.php'     ,
    //                                  'namespace_and_function_name'   =>  'select_dirs_and_files'
    //                                  )
    //              )
    //
    //          )
    //
    // -------------------------------------------------------------------------

    // =========================================================================
    // Init.
    // =========================================================================

    $ns = __NAMESPACE__ ;
    $fn = __FUNCTION__  ;

    // =========================================================================
    // Get stuff for ERROR MESSAGES...
    // =========================================================================

    $safe_dataset_title = htmlentities( \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_stringUtils\to_title( $_GET['dataset_slug'] ) ) ;

    $safe_action_slug = htmlentities( $_GET['action_slug'] ) ;

    // =========================================================================
    // GET/CHECK the dataset's CUSTOM ACTIONS...
    // =========================================================================

    $selected_datasets_dmdd = $all_application_dataset_definitions[ $_GET['dataset_slug'] ] ;

    // -------------------------------------------------------------------------
    // validate_and_index_datasets_custom_actions(
    //      $selected_datasets_dmdd     ,
    //      $dataset_title
    //      )
    // - - - - - - - - - - - - - - - - - - - - - -
    // Checks that the specified dataset's:-
    //      "custom_actions"
    //
    // parameter is present - and reasonably valid looking.
    //
    // $custom_actions should be (eg):-
    //
    //      $custom_actions = array(
    //
    //          array(
    //              'slug'      =>  'select-dirs-files'                     ,
    //              'args'      =>  array(
    //                                  'include_filespec'              =>  'select-dirs-and-files.php'     ,
    //                                  'namespace_and_function_name'   =>  'select_dirs_and_files'
    //                                  )
    //              )
    //
    //          )
    //
    // RETURNS
    //      o   On SUCCESS!
    //          - - - - - -
    //          ARRAY $custom_action_indices_by_slug
    //
    //      o   On FAILURE!
    //          - - - - - -
    //          $error_message STRING
    // -------------------------------------------------------------------------

    $custom_action_indices_by_slug = validate_and_index_datasets_custom_actions(
                                        $selected_datasets_dmdd     ,
                                        $safe_dataset_title
                                        ) ;

    // -------------------------------------------------------------------------

    if ( is_string( $custom_action_indices_by_slug ) ) {

        return standard_dataset_manager_error(
            $dataset_manager_home_page_title        ,
            $custom_action_indices_by_slug          ,
            $caller_plugins_includes_dir            ,
            $question_front_end
            ) ;

    }

    // =========================================================================
    // Is the specified CUSTOM ACTION VALID ?
    // =========================================================================

    if ( ! array_key_exists(
            $_GET['action_slug']            ,
            $custom_action_indices_by_slug
            )
        ) {

        $msg = <<<EOT
PROBLEM: Unrecognised/unsupported custom action "{$safe_action_slug}"
For dataset:&nbsp; {$safe_dataset_title}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        return standard_dataset_manager_error(
            $dataset_manager_home_page_title    ,
            $msg                                ,
            $caller_plugins_includes_dir        ,
            $question_front_end
            ) ;

    }

    // =========================================================================
    // PROCESS the CUSTOM ACTION...
    // =========================================================================

    $custom_action_details = $selected_datasets_dmdd['custom_actions'][
                                $custom_action_indices_by_slug[ $_GET['action_slug'] ]
                                ] ;

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $custom_action_details = array(
    //          [slug] => select-dirs-files
    //          [args] => Array(
    //                          [include_filespec]              => select-dirs-and-files.php
    //                          [namespace_and_function_name]   => select_dirs_and_files
    //                          )
    //          )
    //
    // -------------------------------------------------------------------------

//pr( $custom_action_details ) ;

    // -------------------------------------------------------------------------
    // include_filespec ?
    // -------------------------------------------------------------------------

    if ( ! isset( $custom_action_details['args']['include_filespec'] ) ) {

        $msg = <<<EOT
PROBLEM: No "include_filespec"
For dataset:&nbsp; {$safe_dataset_title}
And custom action:&nbsp; "{$safe_action_slug}"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        return standard_dataset_manager_error(
            $dataset_manager_home_page_title    ,
            $msg                                ,
            $caller_plugins_includes_dir        ,
            $question_front_end
            ) ;

    }

    // -------------------------------------------------------------------------

    if (    ! is_string( $custom_action_details['args']['include_filespec'] )
            ||
            trim( $custom_action_details['args']['include_filespec'] ) === ''
            ||
            strlen( $custom_action_details['args']['include_filespec'] ) > 999
        ) {

        $msg = <<<EOT
PROBLEM: Bad "include_filespec" (1 to 999 character string expected)
For dataset:&nbsp; {$safe_dataset_title}
And custom action:&nbsp; "{$safe_action_slug}"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        return standard_dataset_manager_error(
            $dataset_manager_home_page_title    ,
            $msg                                ,
            $caller_plugins_includes_dir        ,
            $question_front_end
            ) ;

    }

    // -------------------------------------------------------------------------

    if ( ! is_file( $custom_action_details['args']['include_filespec'] ) ) {

        $msg = <<<EOT
PROBLEM: Bad "include_filespec" (no such file)
For dataset:&nbsp; {$safe_dataset_title}
And custom action:&nbsp; "{$safe_action_slug}"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        return standard_dataset_manager_error(
            $dataset_manager_home_page_title    ,
            $msg                                ,
            $caller_plugins_includes_dir        ,
            $question_front_end
            ) ;

    }

    // -------------------------------------------------------------------------

    require_once( $custom_action_details['args']['include_filespec'] ) ;

    // -------------------------------------------------------------------------
    // namespace_and_function_name ?
    // -------------------------------------------------------------------------

    if ( ! isset( $custom_action_details['args']['namespace_and_function_name'] ) ) {

        $msg = <<<EOT
PROBLEM: No "namespace_and_function_name"
For dataset:&nbsp; {$safe_dataset_title}
And custom action:&nbsp; "{$safe_action_slug}"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        return standard_dataset_manager_error(
            $dataset_manager_home_page_title    ,
            $msg                                ,
            $caller_plugins_includes_dir        ,
            $question_front_end
            ) ;

    }

    // -------------------------------------------------------------------------

    if (    ! is_string( $custom_action_details['args']['namespace_and_function_name'] )
            ||
            trim( $custom_action_details['args']['namespace_and_function_name'] ) === ''
            ||
            strlen( $custom_action_details['args']['namespace_and_function_name'] ) > 255
        ) {

        $msg = <<<EOT
PROBLEM: Bad "namespace_and_function_name" (1 to 255 character string expected)
For dataset:&nbsp; {$safe_dataset_title}
And custom action:&nbsp; "{$safe_action_slug}"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        return standard_dataset_manager_error(
            $dataset_manager_home_page_title    ,
            $msg                                ,
            $caller_plugins_includes_dir        ,
            $question_front_end
            ) ;

    }

    // -------------------------------------------------------------------------

    if ( ! function_exists( $custom_action_details['args']['namespace_and_function_name'] ) ) {

        $msg = <<<EOT
PROBLEM: Bad "namespace_and_function_name" (no such function)
For dataset:&nbsp; {$safe_dataset_title}
And custom action:&nbsp; "{$safe_action_slug}"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        return standard_dataset_manager_error(
            $dataset_manager_home_page_title    ,
            $msg                                ,
            $caller_plugins_includes_dir        ,
            $question_front_end
            ) ;

    }

    // -------------------------------------------------------------------------
    // The action handlers are like (eg):-
    //
    //  "DATASET" RELATED HANDLERS...
    //
    //      \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\
    //      manage_dataset(
    //          $caller_app_slash_plugins_global_namespace      ,
    //          $dataset_manager_home_page_title                ,
    //          $caller_plugins_includes_dir                    ,
    //          $all_application_dataset_definitions            ,
    //          $dataset_slug                                   ,
    //          $question_front_end
    //          )
    //
    // "VIEW" RELATED HANDLERS...
    //
    //      \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\
    //      manage_dataset(
    //          $caller_app_slash_plugins_global_namespace      ,
    //          $dataset_manager_home_page_title                ,
    //          $caller_plugins_includes_dir                    ,
    //          $all_application_dataset_definitions            ,
    //          $all_application_view_definitions               ,
    //          $view_slug                                      ,
    //          $question_front_end
    //          )
    //
    // And:-
    //
    //  o   RETURNS a (possibly error message only) screen as appropriate
    //      for the action concerned
    //
    //  o   RETURNS
    //          $page_html STRING
    // -------------------------------------------------------------------------

    return $custom_action_details['args']['namespace_and_function_name'](
                $caller_app_slash_plugins_global_namespace      ,
                $dataset_manager_home_page_title                ,
                $caller_plugins_includes_dir                    ,
                $all_application_dataset_definitions            ,
                $_GET['dataset_slug']                           ,
                $question_front_end
                ) ;

    // -------------------------------------------------------------------------

}

// =============================================================================
// do_custom_page()
// =============================================================================

function do_custom_page(
    $core_plugapp_dirs                                  ,
    $applications_dataset_and_view_definitions_etc      ,
    $question_front_end
    ) {

    // -------------------------------------------------------------------------
    // do_custom_page(
    //      $core_plugapp_dirs                                  ,
    //      $applications_dataset_and_view_definitions_etc      ,
    //      $question_front_end
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // Handles a GET call with:-
    //      $_GET['action'] = 'custom-page'
    //
    // RETURNS
    //      o   On SUCCESS
    //              $page_html STRING
    //              (The HTML for the page to be displayed.)
    //
    //      o   On FAILURE
    //              ARRAY( $error_message ) STRING
    // -------------------------------------------------------------------------

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $_GET = Array(
    //                  [page]          => pluginPlant
    //                  [action]        => custom-page
    //                  [application]   => selexporter
    //                  [custom_page]   => export-pages
    //                  )
    //
    // -------------------------------------------------------------------------

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $_GET ) ;

    // =========================================================================
    // Init...
    // =========================================================================

    $ns = __NAMESPACE__ ;
    $fn = __FUNCTION__  ;

    // =========================================================================
    // application ?
    // =========================================================================

    if ( ! array_key_exists( 'application' , $_GET ) ) {

        $msg = <<<EOT
PROBLEM:&nbsp; No "application"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        return array( $msg ) ;

    }

    // -------------------------------------------------------------------------

    if (    ! is_string( $_GET['application'] )
            ||
            trim( $_GET['application'] ) === ''
        ) {

        $msg = <<<EOT
PROBLEM:&nbsp; Bad "application" (non-empty string expected)
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        return array( $msg ) ;

    }

    // -------------------------------------------------------------------------

    $safe_application_path = htmlentities( $_GET['application'] ) ;

    // =========================================================================
    // custom_page ?
    // =========================================================================

    if ( ! array_key_exists( 'custom_page' , $_GET ) ) {

        $msg = <<<EOT
PROBLEM:&nbsp; No "custom_page"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        return array( $msg ) ;

    }

    // -------------------------------------------------------------------------

    if (    ! is_string( $_GET['custom_page'] )
            ||
            trim( $_GET['custom_page'] ) === ''
        ) {

        $msg = <<<EOT
PROBLEM:&nbsp; Bad "custom_page" (non-empty string expected)
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        return array( $msg ) ;

    }

    // -------------------------------------------------------------------------

    $safe_custom_page = htmlentities( $_GET['custom_page'] ) ;

    // =========================================================================
    // GET the application's CUSTOM PAGES (if it has any)...
    // =========================================================================

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\
    // get_applications_custom_pages(
    //      $applications_dataset_and_view_definitions_etc   ,
    //      $target_app_path
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // $target_app_path is a slash-separated list of nested application
    // slugs dashed.  Like (eg):-
    //
    //      o   "research-assistant"
    //      o   "research-assistant/some-sub-app"
    //      o   etc
    //
    // RETURNS
    //      o   ARRAY $applications_custom_pages
    //          --> Target app. found - and has 0+ custom pages
    //
    //      o   $error_message STRING
    //          --> Error encountered; search abandoned
    //
    //      o   FALSE
    //          --> Target app. NOT found (after searching whole tree)
    // -------------------------------------------------------------------------

    $custom_pages = get_applications_custom_pages(
                        $applications_dataset_and_view_definitions_etc   ,
                        $_GET['application']
                        ) ;

    // -------------------------------------------------------------------------

    if ( $custom_pages === FALSE ) {

        $msg = <<<EOT
PROBLEM:&nbsp; Unrecognised/unsupported "application" ("{$safe_application_path}")
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        return array( $msg ) ;

    }

    // -------------------------------------------------------------------------

    if ( is_string( $custom_pages ) ) {
        return array( $custom_pages ) ;
    }

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $custom_pages = Array(
    //
    //          [export-pages] => Array(
    //              [menu_title]            => Export Pages
    //              [general_title]         => Export Pages
    //              [dirspec]               => /opt/.../custom.pages/export-pages.cp
    //              [page_display_filespec] => /opt/.../custom.pages/export-pages.cp/page-display-file.php
    //              [page_data_filespec]    => /opt/.../custom.pages/export-pages.cp/page-data.php
    //              [page_data]             => Array(
    //                                              [menu_title] => Export Pages
    //                                              [general_title] => Export Pages
    //                                              )
    //              )
    //
    //          ...
    //
    //          )
    //
    // -------------------------------------------------------------------------

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $custom_pages ) ;

    // =========================================================================
    // custom_page OK ?
    // =========================================================================

    if ( ! array_key_exists( $_GET['custom_page'] , $custom_pages ) ) {

        $msg = <<<EOT
PROBLEM:&nbsp; Unrecognised/unsupported "custom_page" ("{$safe_custom_page}")
For application:&nbsp; {$safe_application_path}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        return array( $msg ) ;

    }

    // -------------------------------------------------------------------------

    $the_custom_page = $custom_pages[ $_GET['custom_page'] ] ;

    // -------------------------------------------------------------------------

    if ( ! is_array( $the_custom_page ) ) {

        $msg = <<<EOT
PROBLEM:&nbsp; Bad custom page definition (array expected)
For application:&nbsp; {$safe_application_path}
And custom page:&nbsp; {$safe_custom_page}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        return array( $msg ) ;

    }

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $the_custom_page = Array(
    //          [menu_title]            => Export Pages
    //          [general_title]         => Export Pages
    //          [dirspec]               => /opt/.../custom.pages/export-pages.cp
    //          [page_display_filespec] => /opt/.../custom.pages/export-pages.cp/page-display-file.php
    //          [page_data_filespec]    => /opt/.../custom.pages/export-pages.cp/page-data.php
    //          [page_data]             => Array(
    //                                          [menu_title]    => Export Pages
    //                                          [general_title] => Export Pages
    //                                          )
    //          )
    //
    // -------------------------------------------------------------------------

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $the_custom_page ) ;

    // =========================================================================
    // Page display file ?
    // =========================================================================

    if ( ! array_key_exists( 'page_display_filespec' , $the_custom_page ) ) {

        $msg = <<<EOT
PROBLEM:&nbsp; Bad custom page (no "page display filespec")
For application:&nbsp; {$safe_application_path}
And custom page:&nbsp; {$safe_custom_page}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        return array( $msg ) ;

    }

    // -------------------------------------------------------------------------

    if (    ! is_string( $the_custom_page['page_display_filespec'] )
            ||
            trim( $the_custom_page['page_display_filespec'] ) === ''
        ) {

        $msg = <<<EOT
PROBLEM:&nbsp; Bad "page display filespec" (non-empty string expected)
For application:&nbsp; {$safe_application_path}
And custom page:&nbsp; {$safe_custom_page}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        return array( $msg ) ;

    }

    // -------------------------------------------------------------------------

    if ( ! is_file( $the_custom_page['page_display_filespec'] ) ) {

        $msg = <<<EOT
PROBLEM:&nbsp; Bad "page display filespec" (file not found)
For application:&nbsp; {$safe_application_path}
And custom page:&nbsp; {$safe_custom_page}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        return array( $msg ) ;

    }

    // -------------------------------------------------------------------------

    require_once( $the_custom_page['page_display_filespec'] ) ;

    // =========================================================================
    // Page display routine ?
    // =========================================================================

    $page_display_routine =
        '\\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_' .
        \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_stringUtils\to_camel_case(
            $_GET['custom_page']
            ) .
        '\\get_page_html'
        ;

    // --------------------------------------------------------------------------

    if ( ! function_exists( $page_display_routine ) ) {

        $msg = <<<EOT
PROBLEM:&nbsp; Bad page display file (page display routine not found)
For application:&nbsp; {$safe_application_path}
And custom page:&nbsp; {$safe_custom_page}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        return array( $msg ) ;

    }

    // =========================================================================
    // Display the page...
    // =========================================================================

    return $page_display_routine(
                $core_plugapp_dirs                                  ,
                $applications_dataset_and_view_definitions_etc      ,
                $custom_pages                                       ,
                $the_custom_page                                    ,
                $question_front_end
                ) ;

    // =========================================================================
    // That's that!
    // =========================================================================

}
// =============================================================================
// standard_dataset_manager_error()
// =============================================================================

function standard_dataset_manager_error(
    $page_title                 ,
    $error_message              ,
    $caller_apps_includes_dir   ,
    $question_front_end
    ) {

    // -------------------------------------------------------------------------

    $page_header = get_page_header(
                        $page_title                 ,
                        $caller_apps_includes_dir   ,
                        $question_front_end
                        ) ;

    // -------------------------------------------------------------------------

    $error_message = nl2br( $error_message ) ;

    // -------------------------------------------------------------------------

    return <<<EOT
{$page_header}

<p style="color:#AA0000">{$error_message}</p>

<br />
<br />
EOT;

    // -------------------------------------------------------------------------

}

// =============================================================================
// That's that!
// =============================================================================

