<?php

// *****************************************************************************
// DATASET-MANAGER / APP-DEFS-SUPPORT.PHP
// (C) 2013 Peter Newman. All Rights Reserved.
// *****************************************************************************

    namespace greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager ;

// =============================================================================
// load_app_defs_tree()
// =============================================================================

function load_app_defs_tree(
    $caller_app_slash_plugins_global_namespace      ,
    $caller_apps_includes_dir                       ,
    $question_front_end                             ,
    $tree_root_dir                                  ,
    $core_plugapp_dirs
    ) {

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\load_app_defs_tree(
    //      $caller_app_slash_plugins_global_namespace      ,
    //      $caller_apps_includes_dir                       ,
    //      $question_front_end                             ,
    //      $tree_root_dir                                  ,
    //      $core_plugapp_dirs
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // Loads the application definitions in the specified directory tree.
    //
    // NOTE!    (And I'm not entirely sure this is correct)
    // =====
    // The $tree_root_dir is an "app_defs" dir - that contains one or more
    // dataset and view definitions - as well as the app's "plugin.stuff"
    // dir.
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

    // =========================================================================
    // Init.
    // =========================================================================

    $ns = __NAMESPACE__ ;
    $fn = __FUNCTION__ ;

    // =========================================================================
    // Check the supplied:-
    //      $tree_root_dir
    // =========================================================================

    if (    ! is_string( $tree_root_dir )
            ||
            trim( $tree_root_dir ) === ''
        ) {

        return <<<EOT
PROBLEM:&nbsp; Bad "tree_root_dir" (non-empty string expected)
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

    }

    // -------------------------------------------------------------------------

    if ( ! is_dir( $tree_root_dir ) ) {

        return <<<EOT
PROBLEM:&nbsp; Bad "tree_root_dir" (no such directory)
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

    }

    // =========================================================================
    // LOAD the DIRECTORY TREE...
    // =========================================================================

    require_once( $caller_apps_includes_dir . '/load-directory-tree.php' ) ;

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_dirsFiles\load_directory_tree(
    //      $root_dir
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // Loads the specified directory tree.
    //
    // RETURNS
    //      o   On SUCCESS!
    //          - - - - - -
    //          An ARRAY like (eg):-
    //
    //      o   On FAILURE!
    //          - - - - - -
    //          $error_message STRING
    // -------------------------------------------------------------------------

    $tree = \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_dirsFiles\load_directory_tree(
                $tree_root_dir
                ) ;

    // -------------------------------------------------------------------------

    if ( is_string( $tree ) ) {
        return $tree ;
    }

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $tree = Array(
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

//pr( $tree ) ;

    // =========================================================================
    // Load the APPLICATIONS and DATASET/VIEW DEFINITIONS (etc) (from the
    // loaded directory tree)...
    // =========================================================================

    // -------------------------------------------------------------------------
    // load_applications_dataset_and_view_definitions_etc(
    //      $core_plugapp_dirs                              ,
    //      $caller_app_slash_plugins_global_namespace      ,
    //      $caller_apps_includes_dir                       ,
    //      $question_front_end                             ,
    //      $tree_root_dir                                  ,
    //      $tree_root_dirspec                              ,
    //      $tree
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // RETURNS
    //      o   On SUCCESS!
    //          - - - - - -
    //          An ARRAY like (eg):-
    //
    //      o   On FAILURE!
    //          - - - - - -
    //          $error_message STRING
    // -------------------------------------------------------------------------

    $app_path = '' ;

    // -------------------------------------------------------------------------

    $applications_dataset_and_view_definitions_etc =
        load_applications_dataset_and_view_definitions_etc(
            $core_plugapp_dirs                              ,
            $caller_app_slash_plugins_global_namespace      ,
            $caller_apps_includes_dir                       ,
            $question_front_end                             ,
            $tree_root_dir                                  ,
            $app_path                                       ,
            $tree
            ) ;

    // -------------------------------------------------------------------------

    if ( is_string( $applications_dataset_and_view_definitions_etc ) ) {
        return $applications_dataset_and_view_definitions_etc ;
    }

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
    // SUCCESS!
    // =========================================================================

    return array(
                $tree                                               ,
                $applications_dataset_and_view_definitions_etc
                ) ;

    // =========================================================================
    // That's that!
    // =========================================================================

}

// =============================================================================
// load_applications_dataset_and_view_definitions_etc()
// =============================================================================

function load_applications_dataset_and_view_definitions_etc(
    $core_plugapp_dirs                              ,
    $caller_app_slash_plugins_global_namespace      ,
    $caller_apps_includes_dir                       ,
    $question_front_end                             ,
    $tree_root_dirspec                              ,
    $app_path                                       ,
    $tree
    ) {

    // -------------------------------------------------------------------------
    // load_applications_dataset_and_view_definitions_etc(
    //      $core_plugapp_dirs                              ,
    //      $caller_app_slash_plugins_global_namespace      ,
    //      $caller_apps_includes_dir                       ,
    //      $question_front_end                             ,
    //      $tree_root_dirspec                              ,
    //      $app_path                                       ,
    //      $tree
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // NOTE!    (And I'm not entirely sure this is correct)
    // =====
    // The $tree_root_dir is an "app_defs" dir - that contains one or more
    // dataset and view definitions - as well as the app's "plugin.stuff"
    // dir.
    //
    // RETURNS
    //      o   On SUCCESS!
    //          - - - - - -
    //          An ARRAY like (eg):-
    //
    //      o   On FAILURE!
    //          - - - - - -
    //          $error_message STRING
    // -------------------------------------------------------------------------

    // -------------------------------------------------------------------------
    // NOTE!
    // =====
    // The directory tree we're scanning for "applications" and "dataset
    // definitions" (etc), has those applications and dataset definitions
    // (etc) in dirs and files as follows:-
    //
    //      <some-directory-name>.app/      <-- "application"
    //
    //      <some-filename>.dd.php          <-- "dataset definition"
    //
    //      <some-filename>.view.php        <-- "view definition"
    //
    // -------------------------------------------------------------------------

    // -------------------------------------------------------------------------
    // Here, $tree should be like (eg):-
    //
    //      $tree = Array(
    //
    //          [dirs] => Array(
    //
    //              [/opt/lampp/htdocs/.../_old_] => Array(
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
    //              [/opt/lampp/htdocs/.../research-assistant.app] => Array(    <-- "application"
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
    //              [0] => categories.dd.php            <-- "dataset definition"
    //              [1] => category-resources.php
    //              [2] => projects.dd.php              <-- "dataset definition"
    //              [3] => url-resources.php
    //              [4] => urls.dd.php                  <-- "dataset definition"
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

    // =========================================================================
    // Init.
    // =========================================================================

    $ns = __NAMESPACE__ ;
    $fn = __FUNCTION__ ;

    // -------------------------------------------------------------------------

    require_once( $caller_apps_includes_dir . '/string-utils.php' ) ;

    // -------------------------------------------------------------------------

    $ignore_case_TRUE  = TRUE  ;
    $ignore_case_FALSE = FALSE ;

    // =========================================================================
    // APP_DATA...
    // =========================================================================

    $app_data = array() ;

//pr( $tree_root_dirspec ) ;

    // -------------------------------------------------------------------------

    if ( in_array( 'app-data.php' , $tree['files'] , TRUE ) ) {

        // ---------------------------------------------------------------------

        require_once( $tree_root_dirspec . '/app-data.php' ) ;

        // -------------------------------------------------------------------------
        // \pluginMaker_byFernTec_appStuff_<namespace_name>\get_app_data()
        // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
        // Returns an array holding the application-specific data...
        //
        // RETURNS
        //      o   On SUCCESS!
        //          - - - - - -
        //          ARRAY $app_data
        //
        //      o   On FAILURE!
        //          - - - - - -
        //          $error_message STRING
        // -------------------------------------------------------------------------

        // ---------------------------------------------------------------------
        // Here we should have (eg):-
        //
        //      $tree_root_dirspec =
        //          o   /opt/lampp/htdocs/.../app-defs
        //          o   /opt/lampp/htdocs/.../app-defs/research-assistant.app
        //          o   etc...
        //
        // ---------------------------------------------------------------------

        $app_slug = basename( $tree_root_dirspec ) ;

        $app_slug = substr( $app_slug , 0 , -1 * strlen( '.app' ) ) ;

        $app_slug = str_replace( '-' , '_' , $app_slug ) ;

        // ---------------------------------------------------------------------

        $app_title = \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_stringUtils\to_title( $app_slug ) ;

        // ---------------------------------------------------------------------

        $temp = explode( chr(32) , $app_title ) ;

        $app_title_camel_case = '' ;

        foreach ( $temp as $fragment_index => $fragment_text ) {
            if ( $fragment_index === 0 ) {
                $fragment_text = strtolower( $fragment_text ) ;
            }
            $app_title_camel_case .= $fragment_text ;
        }

        // ---------------------------------------------------------------------

        $function_name = <<<EOT
\\greatKiwi_pluginMaker_appStuff_{$app_title_camel_case}\\get_app_data
EOT;

//        $function_name = <<<EOT
//\\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_appData\\get_app_data
//EOT;

        // ---------------------------------------------------------------------

        if ( function_exists( $function_name ) ) {

            $app_data = $function_name() ;

        } else {

            $app_data = array(
                            'app_slug'              =>  $app_slug               ,
                            'app_title'             =>  $app_title              ,
                            'app_title_camel_case'  =>  $app_title_camel_case
                            ) ;

        }

        // ---------------------------------------------------------------------

    } else {

        // ---------------------------------------------------------------------

        $app_slug = basename( $tree_root_dirspec ) ;

        if ( substr( $app_slug , -4 ) === '.app' ) {
            $app_slug = substr( $app_slug , 0 , -1 * strlen( '.app' ) ) ;
        }

        $app_slug = str_replace( '-' , '_' , $app_slug ) ;

        // ---------------------------------------------------------------------

        $app_title = \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_stringUtils\to_title( $app_slug ) ;

        // ---------------------------------------------------------------------

        $temp = explode( chr(32) , $app_title ) ;

        $app_title_camel_case = '' ;

        foreach ( $temp as $fragment_index => $fragment_text ) {
            if ( $fragment_index === 0 ) {
                $fragment_text = strtolower( $fragment_text ) ;
            }
            $app_title_camel_case .= $fragment_text ;
        }

        // ---------------------------------------------------------------------

        $app_data = array(
                        'app_slug'              =>  $app_slug               ,
                        'app_title'             =>  $app_title              ,
                        'app_title_camel_case'  =>  $app_title_camel_case
                        ) ;

        // ---------------------------------------------------------------------

    }

    // -------------------------------------------------------------------------

    if ( $app_path === '' ) {
        $app_data = array() ;
    }

//pr( $app_data ) ;

    // =========================================================================
    // SUB-APPLICATIONS...
    // =========================================================================

    $sub_apps = array() ;

    // -------------------------------------------------------------------------

    foreach ( $tree['dirs'] as $this_dirspec => $this_dirs_subtree ) {

        // ---------------------------------------------------------------------

        if ( \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_stringUtils\ends_with(
                    $this_dirspec , '.app' , $ignore_case_FALSE
                    ) === TRUE ) {

            // -----------------------------------------------------------------
            // SUB-DIRECTORY IS/CONTAINS AN "APPLICATION"...
            // -----------------------------------------------------------------

            $application_slug = substr( basename( $this_dirspec ) , 0 , -1 * strlen( '.app' ) ) ;

            // -----------------------------------------------------------------

            if ( $app_path === '' ) {
                $sub_app_path = $application_slug ;

            } else {
                $sub_app_path = $app_path . '/' . $application_slug ;

            }

            // -----------------------------------------------------------------

            $result = load_applications_dataset_and_view_definitions_etc(
                            $core_plugapp_dirs                              ,
                            $caller_app_slash_plugins_global_namespace      ,
                            $caller_apps_includes_dir                       ,
                            $question_front_end                             ,
                            $this_dirspec                                   ,
                            $sub_app_path                                   ,
                            $this_dirs_subtree
                            ) ;

            // -----------------------------------------------------------------

            if ( is_string( $result ) ) {
                return $result ;
            }

            // -----------------------------------------------------------------

            $sub_apps[ $application_slug ] = $result ;

            // -----------------------------------------------------------------

        }

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // DATASET DEFINITIONS...
    // =========================================================================

    $dataset_definitions = array() ;

    // -------------------------------------------------------------------------

    foreach ( $tree['files'] as $this_basename ) {

        // ---------------------------------------------------------------------

        if ( ! \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_stringUtils\ends_with( $this_basename , '.dd.php' , $ignore_case_FALSE ) ) {
            continue ;
        }

        // ---------------------------------------------------------------------
        // Here we should have (eg):-
        //
        //      projects.dd.php
        //      projects.v.std.dd.php
        //      projects.v.std-pro.dd.php
        //
        //      reference-urls.dd.php
        //      reference-urls.v.std.dd.php
        //      reference-urls.v.std-pro.dd.php
        //
        // ---------------------------------------------------------------------

        $parts = explode( '.' , $this_basename ) ;

        // ---------------------------------------------------------------------

        $dataset_slug = $parts[0] ;

        // ---------------------------------------------------------------------

//      $dataset_slug = substr( $this_basename , 0 , -1 * strlen( '.dd.php' ) ) ;
//          //  projects
//          //  reference-urls

        // ---------------------------------------------------------------------

        $dataset_slug = str_replace( '-' , '_' , $dataset_slug ) ;
            //  projects
            //  reference_urls

        // ---------------------------------------------------------------------

        if (    $dataset_slug === ''
                ||
                ! ctype_graph( $dataset_slug )
            ) {
            continue ;
        }

        // ---------------------------------------------------------------------

        $dataset_title = \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_stringUtils\to_title( $dataset_slug ) ;

        // ---------------------------------------------------------------------

        $temp = explode( chr(32) , $dataset_title ) ;

        $dataset_title_camel_case = '' ;

        foreach ( $temp as $fragment_index => $fragment_text ) {
            if ( $fragment_index === 0 ) {
                $fragment_text = strtolower( $fragment_text ) ;
            }
            $dataset_title_camel_case .= $fragment_text ;
        }

        // ---------------------------------------------------------------------

        require_once( $tree_root_dirspec . '/' . $this_basename ) ;

        // -------------------------------------------------------------------------
        // get_dataset_details(
        //      $caller_app_slash_plugins_global_namespace      ,
        //      $question_front_end
        //      )
        // - - - - - - - - - - - - - - - - - - - - - - - - - - -
        // Returns an array holding the specified dataset's details - as required
        // by the dataset manager.
        //
        // The returned array is like (eg):-
        //
        //      $dataset_details = array(
        //          'dataset_slug'              =>  'projects'      ,
        //          'dataset_name_singular'     =>  'project'       ,
        //          'dataset_name_plural'       =>  'projects'      ,
        //          'dataset_title_singular'    =>  'Project'       ,
        //          'dataset_title_plural'      =>  'Projects'      ,
        //          'basepress_dataset_handle'  =>  array(...)      ,
        //          ...
        //          ) ;
        //
        // RETURNS
        //      o   On SUCCESS!
        //          - - - - - -
        //          ARRAY $dataset_details
        //
        //      o   On FAILURE!
        //          - - - - - -
        //          $error_message STRING
        // -------------------------------------------------------------------------

//      $function_name =   '\\researchAssistant_byFernTec_datasetManagerDatasetDefs_' .
//      $function_name =   '\\greatKiwi_datasetManager_datasetDef_' .
//              $app_data['app_title_camel_case'] .
//              '_' .
//              $dataset_title_camel_case .
//              '\\get_dataset_details'
//              ;
        $function_name =   '\\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_datasetDef_' .
                $dataset_title_camel_case .
                '\\get_dataset_details'
                ;

        // ---------------------------------------------------------------------

        if ( ! function_exists( $function_name ) ) {
            continue ;
        }

        // ---------------------------------------------------------------------

        $dataset_details = $function_name(
                                $caller_app_slash_plugins_global_namespace      ,
                                $question_front_end
                                ) ;

        // ---------------------------------------------------------------------

        if ( is_string( $dataset_details ) ) {
             return $dataset_details ;
         }

        // ---------------------------------------------------------------------

        if ( ! is_array( $dataset_details ) ) {

            $type = gettype( $dataset_details ) ;

            return <<<EOT
PROBLEM:&nbsp; Bad "dataset details" (expected "array"; received "{$type}")
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        }

        // ---------------------------------------------------------------------

        if ( ! isset( $dataset_details['dataset_slug'] ) ) {

            return <<<EOT
PROBLEM:&nbsp; Bad "dataset details" (no "dataset_slug" field)
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        }

        // ---------------------------------------------------------------------

        if ( $dataset_details['dataset_slug'] !== $dataset_slug ) {

            return <<<EOT
PROBLEM:&nbsp; "dataset slug" mismatch (from filename: "{$dataset_slug}"; from dataset details: "{$dataset_details['dataset_slug']}")
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        }

        // ---------------------------------------------------------------------

        $dataset_definitions[ $dataset_slug ] = $dataset_details ;

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // VIEWS...
    // =========================================================================

    $views = array() ;

    // -------------------------------------------------------------------------

    foreach ( $tree['files'] as $this_basename ) {

        // ---------------------------------------------------------------------

        if ( ! \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_stringUtils\ends_with( $this_basename , '.view.php' , $ignore_case_FALSE ) ) {
            continue ;
        }

        // ---------------------------------------------------------------------

        $view_slug = substr( $this_basename , 0 , -1 * strlen( '.view.php' ) ) ;
            //  projects
            //  reference-urls

        // ---------------------------------------------------------------------

        $view_slug = str_replace( '-' , '_' , $view_slug ) ;
            //  projects
            //  reference_urls

        // ---------------------------------------------------------------------

        if (    $view_slug === ''
                ||
                ! ctype_graph( $view_slug )
            ) {
            continue ;
        }

        // ---------------------------------------------------------------------

        require_once( $tree_root_dirspec . '/' . $this_basename ) ;

        // -------------------------------------------------------------------------
        // get_view_details(
        //      $caller_app_slash_plugins_global_namespace      ,
        //      $question_front_end
        //      )
        // - - - - - - - - - - - - - - - - - - - - - - - - - - -
        // Returns an array holding the specified view's details - as required
        // by the dataset manager.
        //
        // The returned array is like (eg):-
        //
        //      $dataset_details = array(
        //          ...
        //          ) ;
        //
        // RETURNS
        //      o   On SUCCESS!
        //          - - - - - -
        //          ARRAY $dataset_details
        //
        //      o   On FAILURE!
        //          - - - - - -
        //          $error_message STRING
        // -------------------------------------------------------------------------

//      $function_name =   '\\researchAssistant_byFernTec_datasetManager_viewDefs_' .
//              $view_slug .
//              '\\get_view_details'
//              ;

        $view_slug_camel_case = \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_stringUtils\to_camel_case( $view_slug ) ;

        $function_name =   '\\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_viewDef_' .
                $view_slug_camel_case .
                '\\get_view_details'
                ;

        // ---------------------------------------------------------------------

        if ( ! function_exists( $function_name ) ) {
            continue ;
        }

        // ---------------------------------------------------------------------

        $view_details = $function_name(
                            $caller_app_slash_plugins_global_namespace      ,
                            $question_front_end
                            ) ;

        // ---------------------------------------------------------------------

        if ( is_string( $view_details ) ) {
            return $view_details ;
        }

        // ---------------------------------------------------------------------

        if ( ! is_array( $view_details ) ) {

            $type = gettype( $view_details ) ;

            return <<<EOT
PROBLEM:&nbsp; Bad "view details" (expected "array"; received "{$type}")
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        }

        // ---------------------------------------------------------------------

        if ( ! isset( $view_details['view_slug'] ) ) {

            return <<<EOT
PROBLEM:&nbsp; Bad "view details" (no "view_slug" field)
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        }

        // ---------------------------------------------------------------------

        if ( $view_details['view_slug'] !== $view_slug ) {

            return <<<EOT
PROBLEM:&nbsp; "view slug" mismatch (from filename: "{$view_slug}"; from view details: "{$view_details['view_slug']}")
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        }

        // ---------------------------------------------------------------------

        $views[ $view_slug ] = $view_details ;

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // LOAD the plugin/application's CUSTOM PAGES (if it has any)...
    // =========================================================================

    if (    \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_stringUtils\ends_with(
                $tree_root_dirspec , '.app' , $ignore_case_FALSE
                ) === TRUE
        ) {

        // ---------------------------------------------------------------------

        require_once( $caller_apps_includes_dir . '/dataset-manager/custom-page-support.php' ) ;

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

        $custom_pages =
            \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_customPages\load_custom_pages(
                $core_plugapp_dirs      ,
                $tree_root_dirspec
                ) ;

        // ---------------------------------------------------------------------

        if ( is_string( $custom_pages ) ) {
            return $custom_pages ;
        }

        // ---------------------------------------------------------------------

    } else {

        // ---------------------------------------------------------------------

        $custom_pages = array() ;

        // ---------------------------------------------------------------------

    }

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $custom_pages ) ;

    // =========================================================================
    // SUCCESS!
    // =========================================================================

    $applications_dataset_and_view_definitions_etc = array(
        'dirspec'               =>  $tree_root_dirspec      ,
        'app_path'              =>  $app_path               ,
        'app_data'              =>  $app_data               ,
        'sub_apps'              =>  $sub_apps               ,
        'dataset_definitions'   =>  $dataset_definitions    ,
        'views'                 =>  $views                  ,
        'custom_pages'          =>  $custom_pages
        ) ;

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

    // -------------------------------------------------------------------------

    return $applications_dataset_and_view_definitions_etc ;

    // =========================================================================
    // That's that!
    // =========================================================================

}

// =============================================================================
// get_application_dataset_definitions()
// =============================================================================

function get_application_dataset_definitions(
    $applications_dataset_and_view_definitions_etc   ,
    $target_app_path
    ) {

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\
    // get_application_dataset_definitions(
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
    //      o   ARRAY $all_application_dataset_definitions
    //          --> Target app. found - and has 1+ dataset definitions
    //
    //      o   $error_message STRING
    //          --> Error encountered; search abandoned
    //
    //      o   FALSE
    //          --> Target app. NOT found (after searching whole tree)
    // -------------------------------------------------------------------------

    return get_application_xxx_definitions(
                $applications_dataset_and_view_definitions_etc     ,
                $target_app_path                                    ,
                'dataset_definitions'
                ) ;

    // -------------------------------------------------------------------------

}

// =============================================================================
// get_application_view_definitions()
// =============================================================================

function get_application_view_definitions(
    $applications_dataset_and_view_definitions_etc   ,
    $target_app_path
    ) {

    // -------------------------------------------------------------------------
    // get_application_view_definitions(
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
    //      o   ARRAY $all_application_view_definitions
    //          --> Target app. found - and has 1+ dataset definitions
    //
    //      o   $error_message STRING
    //          --> Error encountered; search abandoned
    //
    //      o   FALSE
    //          --> Target app. NOT found (after searching whole tree)
    // -------------------------------------------------------------------------

    return get_application_xxx_definitions(
                $applications_dataset_and_view_definitions_etc     ,
                $target_app_path                                    ,
                'views'
                ) ;

    // -------------------------------------------------------------------------

}

// =============================================================================
// get_applications_custom_pages()
// =============================================================================

function get_applications_custom_pages(
    $applications_dataset_and_view_definitions_etc   ,
    $target_app_path
    ) {

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

    return get_application_xxx_definitions(
                $applications_dataset_and_view_definitions_etc     ,
                $target_app_path                                    ,
                'custom_pages'
                ) ;

    // -------------------------------------------------------------------------

}

// =============================================================================
// get_application_xxx_definitions()
// =============================================================================

function get_application_xxx_definitions(
    $applications_dataset_and_view_definitions_etc     ,
    $target_app_path                                    ,
    $xxx_name
    ) {

    // -------------------------------------------------------------------------
    // get_application_xxx_definitions(
    //      $applications_dataset_and_view_definitions_etc     ,
    //      $target_app_path                                    ,
    //      $xxx_name
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // $xxx_name = "dataset_definitions" | "views" | "custom_pages"
    //
    // $target_app_path is a slash-separated list of nested application
    // slugs dashed.  Like (eg):-
    //
    //      o   "research-assistant"
    //      o   "research-assistant/some-sub-app"
    //      o   etc
    //
    // RETURNS
    //      o   ARRAY $all_application_dataset_definitions
    //          --> Target app. found - and has 1+ dataset definitions
    //      o   ARRAY $all_application_view_definitions
    //          --> Target app. found - and has 1+ view definitions
    //      o   ARRAY $applications_custom_pages
    //          --> Target app. found - and has 0+ custom pages
    //
    //      o   $error_message STRING
    //          --> Error encountered; search abandoned
    //
    //      o   FALSE
    //          --> Target app. NOT found (after searching whole tree)
    // -------------------------------------------------------------------------

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
    //                                          [app_slug]  => app_defs
    //                                          [app_title] => App Defs
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
    //                                                  )
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
    // Init.
    // =========================================================================

    $ns = __NAMESPACE__ ;
    $fn = __FUNCTION__  ;

    // =========================================================================
    // Is this the TARGET APPLICATION ?
    // =========================================================================

    if (    array_key_exists( 'app_path' , $applications_dataset_and_view_definitions_etc )
            &&
            $applications_dataset_and_view_definitions_etc['app_path'] === $target_app_path
        ) {

        // =====================================================================
        // YES!
        // =====================================================================

        if ( $xxx_name === 'custom_pages' ) {

            // -----------------------------------------------------------------

            if ( array_key_exists( $xxx_name , $applications_dataset_and_view_definitions_etc ) ) {

                // -------------------------------------------------------------

                if ( ! is_array( $applications_dataset_and_view_definitions_etc[ $xxx_name ] ) ) {

                    $safe_target_app_path = htmlentities( $target_app_path ) ;

                    return <<<EOT
PROBLEM:&nbsp; Bad "custom_pages" (array expected)
For application:&nbsp; {$safe_target_app_path}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;
                }

                // -------------------------------------------------------------

                return $applications_dataset_and_view_definitions_etc[ $xxx_name ] ;

                // -------------------------------------------------------------


            } else {

                // -------------------------------------------------------------

                return array() ;

                // -------------------------------------------------------------

            }

            // -----------------------------------------------------------------

        } else {

            // -----------------------------------------------------------------

            if (    array_key_exists( $xxx_name , $applications_dataset_and_view_definitions_etc )
                    &&
                    is_array( $applications_dataset_and_view_definitions_etc[ $xxx_name ] )
                    &&
                    count( $applications_dataset_and_view_definitions_etc[ $xxx_name ] ) > 0
                ) {

                return $applications_dataset_and_view_definitions_etc[ $xxx_name ] ;

            } else {

                $safe_target_app_path = htmlentities( $target_app_path ) ;

                return <<<EOT
Sorry, but the "{$safe_target_app_path}" application has NO "{$xxx_name}" definitions<br />
Please select another application (to manage)...
EOT;

            }

           // ------------------------------------------------------------------

        }

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // NO: Search any sub-apps...
    // =========================================================================

    if ( array_key_exists( 'sub_apps' , $applications_dataset_and_view_definitions_etc ) ) {

        // ---------------------------------------------------------------------

        foreach ( $applications_dataset_and_view_definitions_etc['sub_apps'] as $app_slug => $this_application ) {

            // -------------------------------------------------------------------------
            // get_application_xxx_definitions(
            //      $applications_dataset_and_view_definitions_etc     ,
            //      $target_app_path                                    ,
            //      $xxx_name
            //      )
            // - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
            // $xxx_name = "dataset_definitions" | "views"
            //
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

            $result = get_application_xxx_definitions(
                            $this_application   ,
                            $target_app_path    ,
                            $xxx_name
                            ) ;

            // -----------------------------------------------------------------

            if (    is_array( $result )
                    ||
                    is_string( $result )
                ) {
                return $result ;
            }

            // -----------------------------------------------------------------

        }

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // Target app. NOT found!
    // =========================================================================

    return FALSE ;

    // =========================================================================
    // That's that!
    // =========================================================================

}

// =============================================================================
// dataset_exists_in_application()
// =============================================================================

function dataset_exists_in_application(
    $applications_dataset_definitions    ,
    $dataset_slug
    ) {

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\
    // dataset_exists_in_application(
    //      $applications_dataset_definitions   ,
    //      $dataset_slug
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // Returns whether or not the specified dataset exists, in the specified
    // application's dataset definitions...
    //
    // $applications_dataset_definitions is like (eg):-
    //
    //      $applications_dataset_definitions = Array(
    //
    //          [categories] => Array(
    //              [dataset_slug]                      => categories
    //              [dataset_name_singular]             => category
    //              [dataset_name_plural]               => categories
    //              [dataset_title_singular]            => Category
    //              [dataset_title_plural]              => Categories
    //              [basepress_dataset_handle]          => Array(
    //                  [nice_name]     => researchAssistant_byFernTec_categories
    //                  [unique_key]    => 6934fccc-c552-46b0-8db5-87a02...f7adf54
    //                  [version]       => 0.1
    //                  )
    //              [dataset_records_table]             => Array(...)
    //              [zebra_form]                        => Array(...)
    //              [array_storage_record_structure]    => Array(...)
    //              [array_storage_key_field_slug]      => key
    //              )
    //
    //          [projects] => Array(
    //              [dataset_slug]                      => projects
    //              [dataset_name_singular]             => project
    //              [dataset_name_plural]               => projects
    //              [dataset_title_singular]            => Project
    //              [dataset_title_plural]              => Projects
    //              [basepress_dataset_handle]          => Array(
    //                  [nice_name]     => researchAssistant_byFernTec_projects
    //                  [unique_key]    => d2562b23-3c20-4368-92c4-2b...0c9a66
    //                  [version]       => 0.1
    //                  )
    //              [dataset_records_table]             => Array(...)
    //              [zebra_form]                        => Array(...)
    //              [array_storage_record_structure]    => Array(...)
    //              [array_storage_key_field_slug]      => key
    //              )
    //
    //          ...
    //
    //          )
    //
    // RETURNS
    //      o   ARRAY(...dataset definition...)
    //          --> Dataset found
    //
    //      o   $error_message STRING
    //          --> Error encountered; search abandoned
    //
    //      o   FALSE
    //          --> Dataset NOT found
    // -------------------------------------------------------------------------

    if ( ! array_key_exists( $dataset_slug , $applications_dataset_definitions ) ) {
        return FALSE ;
    }

    // -------------------------------------------------------------------------

    return $applications_dataset_definitions[ $dataset_slug ] ;

    // -------------------------------------------------------------------------

}

// =============================================================================
// dataset_exists_in_tree()
// =============================================================================

function dataset_exists_in_tree(
    $applications_dataset_and_view_definitions_etc   ,
    $target_app_path
    ) {

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\
    // dataset_exists_in_tree(
    //      $applications_dataset_and_view_definitions_etc  ,
    //      $target_app_path                                ,
    //      $dataset_slug
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // $target_app_path is a slash-separated list of nested application
    // slugs dashed.  Like (eg):-
    //
    //      o   "research-assistant"
    //      o   "research-assistant/some-sub-app"
    //      o   etc
    //
    // RETURNS
    //      o   ARRAY(...dataset definition...)
    //          --> Dataset found
    //
    //      o   $error_message STRING
    //          --> Error encountered; search abandoned
    //
    //      o   FALSE
    //          --> Dataset NOT found
    // -------------------------------------------------------------------------

    $result = get_application_dataset_definitions(
                    $applications_dataset_and_view_definitions_etc   ,
                    $target_app_path
                    ) ;

    // -------------------------------------------------------------------------

    if (    is_string( $result )
            ||
            $result === FALSE
        ) {
        return $result ;
    }

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $result = Array(
    //
    //          [categories] => Array(
    //              [dataset_slug]                      => categories
    //              [dataset_name_singular]             => category
    //              [dataset_name_plural]               => categories
    //              [dataset_title_singular]            => Category
    //              [dataset_title_plural]              => Categories
    //              [basepress_dataset_handle]          => Array(
    //                  [nice_name]     => researchAssistant_byFernTec_categories
    //                  [unique_key]    => 6934fccc-c552-46b0-8db5-87a02...f7adf54
    //                  [version]       => 0.1
    //                  )
    //              [dataset_records_table]             => Array(...)
    //              [zebra_form]                        => Array(...)
    //              [array_storage_record_structure]    => Array(...)
    //              [array_storage_key_field_slug]      => key
    //              )
    //
    //          [projects] => Array(
    //              [dataset_slug]                      => projects
    //              [dataset_name_singular]             => project
    //              [dataset_name_plural]               => projects
    //              [dataset_title_singular]            => Project
    //              [dataset_title_plural]              => Projects
    //              [basepress_dataset_handle]          => Array(
    //                  [nice_name]     => researchAssistant_byFernTec_projects
    //                  [unique_key]    => d2562b23-3c20-4368-92c4-2b...0c9a66
    //                  [version]       => 0.1
    //                  )
    //              [dataset_records_table]             => Array(...)
    //              [zebra_form]                        => Array(...)
    //              [array_storage_record_structure]    => Array(...)
    //              [array_storage_key_field_slug]      => key
    //              )
    //
    //          ...
    //
    //          )
    //
    // -------------------------------------------------------------------------

    if ( ! array_key_exists( $dataset_slug , $result ) ) {
        return FALSE ;
    }

    // -------------------------------------------------------------------------

    return $result[ $dataset_slug ] ;

    // -------------------------------------------------------------------------

}

// =============================================================================
// That's that!
// =============================================================================

