<?php

// *****************************************************************************
// PROTO-PRESS / ADMIN / MANAGE-DATASET.PHP
// (C) 2013 Peter Newman. All Rights Reserved.
// *****************************************************************************

    namespace greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager ;

// =============================================================================
// manage_dataset()
// =============================================================================

function manage_dataset(
    $caller_app_slash_plugins_global_namespace      ,
    $dataset_manager_home_page_title                ,
    $caller_apps_includes_dir                       ,
    $all_application_dataset_definitions            ,
    $dataset_slug                                   ,
    $question_front_end
    ) {

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\manage_dataset(
    //      $caller_app_slash_plugins_global_namespace      ,
    //      $dataset_manager_home_page_title                ,
    //      $caller_apps_includes_dir                       ,
    //      $all_application_dataset_definitions            ,
    //      $dataset_slug                                   ,
    //      $question_front_end
    //      )
    // - - - - - - - - - - - - - - - -
    // Creates and returns a screen for adding, editing and deleting records
    // of the specified dataset.
    //
    // $all_application_dataset_definitions should be like (eg):-
    //
    //      $all_application_dataset_definitions = Array(
    //
    //          [projects] => Array(    //  <== "dataset_slug"
    //              [dataset_slug]              => projects
    //              [dataset_name_singular]     => project
    //              [dataset_name_plural]       => projects
    //              [dataset_title_singular]    => Project
    //              [dataset_title_plural]      => Projects
    //              [basepress_dataset_handle]  => array(...)
    //              )
    //
    //          ...
    //
    //          )
    //
    // NOTE!
    // =====
    // The returned page may be the page requested proper.  Or it may be just
    // the page header/footer, and an error message.
    //
    // RETURNS:-
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

//pr( $_GET ) ;

    // =========================================================================
    // Get the specified dataset's DATASET MANAGER DATASET DEFINITION...
    // =========================================================================

    $selected_datasets_dmdd = $all_application_dataset_definitions[ $dataset_slug ] ;
                                    //  dmdd = Dataset Manager Dataset Definition

    // =========================================================================
    // LOAD the DATASET RECORDS from array storage...
    // =========================================================================

    require_once( $caller_apps_includes_dir . '/array-storage.php' ) ;

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_arrayStorage\load_numerically_indexed(
    //      $dataset_name                       ,
    //      $question_die_on_error = FALSE
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // Loads and returns the specified PHP numerically indexed array.
    //
    // RETURNS
    //      o   On SUCCESS
    //          - - - - -
    //          ARRAY $array
    //          A possibly empty PHP numerically indexed ARRAY.
    //
    //      o   On FAILURE
    //          - - - - -
    //          $error_message STRING
    // -------------------------------------------------------------------------

    $question_die_on_error = TRUE ;

    $dataset_records = \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_arrayStorage\load_numerically_indexed(
                            $dataset_slug               ,
                            $question_die_on_error
                            ) ;

    // -------------------------------------------------------------------------

    if ( is_string( $dataset_records ) ) {

        return standard_dataset_manager_error(
            $dataset_manager_home_page_title    ,
            $dataset_records                    ,
            $caller_apps_includes_dir           ,
            $question_front_end
            ) ;

    }

    // -------------------------------------------------------------------------

//pr( $dataset_records ) ;

    // =========================================================================
    // Get the "Dataset Title" (for error reporting purposes)...
    // =========================================================================

    if (    isset( $selected_datasets_dmdd['dataset_title_plural'] )
            &&
            is_string( $selected_datasets_dmdd['dataset_title_plural'] )
            &&
            trim( $selected_datasets_dmdd['dataset_title_plural'] ) !== ''
        ) {
        $dataset_title = $selected_datasets_dmdd['dataset_title_plural'] ;

    } else {
        $dataset_title = to_title( $dataset_slug ) ;

    }

    // =========================================================================
    // GET the ORPHANED RECORDS (if needed)...
    // =========================================================================

    // -------------------------------------------------------------------------
    // orphaned_records_supported()
    // - - - - - - - - - - - - - -
    // RETURNS TRUE or FALSE - depending on whether or not we should support
    // the handling of "orphaned records".  (In other words, should we:-
    //      o   Display the "show/hide orphaned records" button, and;
    //      o   Support the deleting of orphaned records,
    //      o   etc.
    //
    // NOTE!
    // =====
    // 1.   Orphaned records are supported unless the plugin's
    //          $version_names
    //
    //      array (if the plugin has one), has:-
    //          'support_orphaned_records'  =  FALSE
    //
    //      See:-
    //          \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_pluginMaker\
    //          get_all_version_names()
    //
    //      in the plugin's:-
    //          .../app-defs/xxx.app/plugin.stuff/version-names.php
    //
    //      file (for more info).
    //
    // 2.   Thus orphaned records ARE supported - unless you explicitly switch
    //      OFF that support in the plugin's "version-names.php" file.
    // -------------------------------------------------------------------------

    $orphaned_record_indices = NULL ;

    // -------------------------------------------------------------------------

//  if (    (   isset( $selected_datasets_dmdd['dataset_records_table']['error_if_orphaned_records'] )
//              &&
//              $selected_datasets_dmdd['dataset_records_table']['error_if_orphaned_records'] === TRUE
//          )
//          ||
//          question_show_orphaned_records_button( $selected_datasets_dmdd )
//      ) {

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\
    // orphaned_records_supported(
    //      $app_handle = NULL
    //      )
    // - - - - - - - - - - - - - -
    // RETURNS
    //      o   On SUCCESS
    //              TRUE or FALSE - depending on whether or not we should
    //              support the handling of "orphaned records".  (In other
    //              words, should we:-
    //              -   Display the "show/hide orphaned records" button, and;
    //              -   Support the deleting of orphaned records,
    //              -   etc.)
    //
    //      o   On FAILURE
    //              $error_message STRING
    //
    // NOTE!
    // =====
    // 1.   Orphaned records are supported unless the plugin's
    //          $version_names
    //
    //      array (if the plugin has one), has:-
    //          'support_orphaned_records' = FALSE
    //
    //      See:-
    //          \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_pluginMaker\
    //          get_all_version_names()
    //
    //      in the plugin's:-
    //          .../app-defs/xxx.app/plugin.stuff/version-names.php
    //
    //      file (for more info).
    //
    // 2.   Thus orphaned records ARE supported - unless you explicitly switch
    //      OFF that support in the plugin's "version-names.php" file.
    //
    // 3.   $app_handle defaults to:-
    //          $_GET['application']
    //      (if it exists).
    // -------------------------------------------------------------------------

    if ( orphaned_records_supported() ) {

        // ---------------------------------------------------------------------

        require_once( dirname( __FILE__ ) . '/orphaned-records.php' ) ;

        // -------------------------------------------------------------------------
        // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\
        // get_orphaned_record_indices(
        //      $all_application_dataset_definitions    ,
        //      $caller_apps_includes_dir               ,
        //      $selected_datasets_dmdd                 ,
        //      $dataset_records                        ,
        //      $dataset_slug                           ,
        //      $dataset_title                          ,
        //      $question_front_end
        //      )
        // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
        // Returns a (possibly empty) ARRAY contain the indices (in the
        // $dataset_records array), of the orphaned records in that array (if
        // there are any).
        //
        // RETURNS
        //      o   On SUCCESS
        //          - - - - -
        //          (Possibly empty) $orphaned_record_indices ARRAY
        //
        //      o   On FAILURE
        //          - - - - -
        //          $error_message STRING
        // -------------------------------------------------------------------------

//      if ( $question_front_end ) {
//          $data_for = 'dhtmlx-grid' ;
//
//      } else {
//          $data_for = 'wp-list-table' ;
//
//      }

        // ---------------------------------------------------------------------

        $orphaned_record_indices = get_orphaned_record_indices(
                                        $all_application_dataset_definitions    ,
                                        $caller_apps_includes_dir               ,
                                        $selected_datasets_dmdd                 ,
                                        $dataset_records                        ,
                                        $dataset_slug                           ,
                                        $dataset_title                          ,
                                        $question_front_end
                                        ) ;

        // ---------------------------------------------------------------------

        if ( is_string( $orphaned_record_indices ) ) {

            return standard_dataset_manager_error(
                        $dataset_manager_home_page_title    ,
                        $orphaned_record_indices            ,
                        $caller_apps_includes_dir           ,
                        $question_front_end
                        ) ;

        }

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // DO "ERROR IF ORPHANED INDICES"...
    // =========================================================================

/*
    if (    isset( $selected_datasets_dmdd['dataset_records_table']['error_if_orphaned_records'] )
            &&
            $selected_datasets_dmdd['dataset_records_table']['error_if_orphaned_records'] === TRUE
            &&
            count( $orphaned_record_indices ) > 0
        ) {

        // =====================================================================
        // Handle Form Submission ?
        // =====================================================================

        // ---------------------------------------------------------------------
        // Here we should have (eg):-
        //
        //      $_POST = Array()
        //
        //      --OR--
        //
        //      $_POST = Array(
        //                  [delete-orphaned-records] => true
        //                  )
        //
        // ---------------------------------------------------------------------

//pr( $_POST ) ;

        // ---------------------------------------------------------------------

        if (    count( $_POST ) > 0
                &&
                isset( $_POST['delete_orphaned_records'] )
                &&
                $_POST['delete_orphaned_records'] === 'true'
            ) {

            // -------------------------------------------------------------------------
            // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\delete_orphaned_records(
            //      $all_application_dataset_definitions    ,
            //      $caller_apps_includes_dir               ,
            //      $selected_datasets_dmdd                 ,
            //      &$dataset_records                       ,
            //      $dataset_slug                           ,
            //      $dataset_title                          ,
            //      $question_front_end                     ,
            //      $orphaned_record_indices
            //      )
            // - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
            // Deletes the specified orphaned records (from $dataset records - both
            // in memory and on disk)...
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

            $result = delete_orphaned_records(
                            $all_application_dataset_definitions    ,
                            $caller_apps_includes_dir               ,
                            $selected_datasets_dmdd                 ,
                            $dataset_records                        ,
                            $dataset_slug                           ,
                            $dataset_title                          ,
                            $question_front_end                     ,
                            $orphaned_record_indices
                            ) ;

            // -----------------------------------------------------------------

            if ( is_string( $result ) ) {

                return standard_dataset_manager_error(
                            $dataset_manager_home_page_title    ,
                            $orphaned_record_indices[0]         ,
                            $caller_apps_includes_dir           ,
                            $question_front_end
                            ) ;

            }

            // -----------------------------------------------------------------

        } else {

            // -------------------------------------------------------------------------
            // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\get_orphaned_records_table_html(
            //      $all_application_dataset_definitions    ,
            //      $caller_apps_includes_dir               ,
            //      $selected_datasets_dmdd                 ,
            //      $dataset_records                        ,
            //      $dataset_slug                           ,
            //      $dataset_title                          ,
            //      $question_front_end                     ,
            //      $orphaned_record_indices                ,
            //      $data_for
            //      )
            // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
            // Returns the HTML for a table to display/delete the orphaned records in
            // the dataset.
            //
            // $data_for must be one of:-
            //      o   'wp-list-table'
            //      o   'dhtmlx-grid'
            //
            // RETURNS
            //      o   On SUCCESS
            //          - - - - -
            //          (Possibly empty) $orphaned_records_html STRING
            //
            //      o   On FAILURE
            //          - - - - -
            //          array( $error_message STRING )
            // -------------------------------------------------------------------------

            if ( $question_front_end ) {
                $data_for = 'dhtmlx-grid' ;

            } else {
                $data_for = 'wp-list-table' ;

            }

            // -----------------------------------------------------------------

            $orphaned_records_table_html = get_orphaned_records_table_html(
                                                $all_application_dataset_definitions    ,
                                                $caller_apps_includes_dir               ,
                                                $selected_datasets_dmdd                 ,
                                                $dataset_records                        ,
                                                $dataset_slug                           ,
                                                $dataset_title                          ,
                                                $question_front_end                     ,
                                                $orphaned_record_indices                ,
                                                $data_for
                                                ) ;

            // -----------------------------------------------------------------

            if ( is_array( $orphaned_records_table_html ) ) {
                $orphaned_records_table_html = $orphaned_records_table_html[0] ;
            }

            // -----------------------------------------------------------------

            $onclick = <<<EOT
document.forms['delete_orphaned_records'].submit()
EOT;

            // -----------------------------------------------------------------

            $out = <<<EOT
<br />
Oops, the "{$dataset_title}" dataset contains the following orphaned records...
<div style="position:relative; top:-3.5em; padding-right:1em">{$orphaned_records_table_html}
<a href="javascript:void()" onclick="{$onclick}">Click here to DELETE the ORPHANED RECORDS...</a></div>
<form name="delete_orphaned_records" action="" method="POST"><input type="hidden" name="delete_orphaned_records" value="true" /></form>
EOT;

            // -----------------------------------------------------------------

            $out = str_replace( "\n" , '' , $out ) ;

            // -----------------------------------------------------------------

            return standard_dataset_manager_error(
                        $dataset_manager_home_page_title    ,
                        $out                                ,
                        $caller_apps_includes_dir           ,
                        $question_front_end
                        ) ;

            // -----------------------------------------------------------------

        }

        // ---------------------------------------------------------------------

    }
*/

    // =========================================================================
    // Handle "DELETE ORPHANED RECORDS" form submission...
    // =========================================================================

//  if (    question_show_orphaned_records_button( $selected_datasets_dmdd )
//          &&

    if (    is_array( $orphaned_record_indices )
            &&
            count( $orphaned_record_indices ) > 0
        ) {

        // =====================================================================
        // Handle Form Submission ?
        // =====================================================================

        // ---------------------------------------------------------------------
        // Here we should have (eg):-
        //
        //      $_POST = Array()
        //
        //      --OR--
        //
        //      $_POST = Array(
        //                  [delete-orphaned-records] => true
        //                  )
        //
        // ---------------------------------------------------------------------

//pr( $_POST ) ;

        // ---------------------------------------------------------------------

        if (    count( $_POST ) > 0
                &&
                array_key_exists( 'delete_orphaned_records' , $_POST )
                &&
                $_POST['delete_orphaned_records'] === 'true'
            ) {

            // -------------------------------------------------------------------------
            // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\
            // delete_orphaned_records(
            //      $all_application_dataset_definitions    ,
            //      $caller_apps_includes_dir               ,
            //      $selected_datasets_dmdd                 ,
            //      &$dataset_records                       ,
            //      $dataset_slug                           ,
            //      $dataset_title                          ,
            //      $question_front_end                     ,
            //      $orphaned_record_indices
            //      )
            // - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
            // Deletes the specified orphaned records (from $dataset records - both
            // in memory and on disk)...
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

            $result = delete_orphaned_records(
                            $all_application_dataset_definitions    ,
                            $caller_apps_includes_dir               ,
                            $selected_datasets_dmdd                 ,
                            $dataset_records                        ,
                            $dataset_slug                           ,
                            $dataset_title                          ,
                            $question_front_end                     ,
                            $orphaned_record_indices
                            ) ;

            // -----------------------------------------------------------------

            if ( is_string( $result ) ) {

                return standard_dataset_manager_error(
                            $dataset_manager_home_page_title    ,
                            $orphaned_record_indices[0]         ,
                            $caller_apps_includes_dir           ,
                            $question_front_end
                            ) ;

            }

            // -----------------------------------------------------------------

            $orphaned_record_indices = get_orphaned_record_indices(
                                            $all_application_dataset_definitions    ,
                                            $caller_apps_includes_dir               ,
                                            $selected_datasets_dmdd                 ,
                                            $dataset_records                        ,
                                            $dataset_slug                           ,
                                            $dataset_title                          ,
                                            $question_front_end
                                            ) ;

            // -----------------------------------------------------------------

            if ( is_string( $orphaned_record_indices ) ) {

                return standard_dataset_manager_error(
                            $dataset_manager_home_page_title    ,
                            $orphaned_record_indices[0]         ,
                            $caller_apps_includes_dir           ,
                            $question_front_end
                            ) ;

            }

            // -----------------------------------------------------------------

        }

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // SINGLE RECORD MODE ?
    // =========================================================================

    if (    array_key_exists( 'question_single_record_mode' , $selected_datasets_dmdd )
            &&
            $selected_datasets_dmdd['question_single_record_mode'] === TRUE
        ) {

        // -------------------------------------------------------------------------
        // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\get_dataset_key_field_slug(
        //      $all_application_dataset_definitions    ,
        //      $dataset_slug
        //      )
        // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
        // Returns the dataset's (array storage) key field slug.
        //
        // RETURNS
        //      o   $array_storage_key_field_slug STRING on SUCCESS
        //      o   array( $error_message STRING ) on FAILURE
        // -------------------------------------------------------------------------

        $key_field_slug = get_dataset_key_field_slug(
                                $all_application_dataset_definitions    ,
                                $dataset_slug
                                ) ;

        // ---------------------------------------------------------------------

        if ( is_array( $key_field_slug ) ) {
            return nl2br( $key_field_slug[0] ) ;
        }

        // ---------------------------------------------------------------------

        require_once( dirname( __FILE__ ) . '/add-edit-record.php' ) ;

        // -------------------------------------------------------------------------
        // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\add_edit_record(
        //      $caller_app_slash_plugins_global_namespace      ,
        //      $home_page_title                                ,
        //      $caller_apps_includes_dir                       ,
        //      $all_application_dataset_definitions            ,
        //      $dataset_slug                                   ,
        //      $question_front_end                             ,
        //      $display_options    = array()                   ,
        //      $submission_options = array()
        //      )
        // - - - - - - - - - - - - - - - - - - - - - - - - -
        // Outputs a screen for adding or editing a record to/of the specified
        // dataset.
        //
        // $all_application_dataset_definitions should be like (eg):-
        //
        //      $all_application_dataset_definitions = Array(
        //
        //          [projects] => Array(    //  <== "dataset_slug"
        //              [dataset_slug]              => projects
        //              [dataset_name_singular]     => project
        //              [dataset_name_plural]       => projects
        //              [dataset_title_singular]    => Project
        //              [dataset_title_plural]      => Projects
        //              [basepress_dataset_handle]  => array(...)
        //              )
        //
        //          ...
        //
        //          )
        //
        // RETURNS:-
        //      Nothing
        // -------------------------------------------------------------------------

        // -------------------------------------------------------------------------
        // add_edit_record() expects:-
        //                                                                                   t
        //      $_GET = array(
        //                  [page]          =>  protoPress
        //                  [action]        =>  add-record
        //                  [dataset_slug]  =>  projects
        //                  )
        //
        //      --OR--
        //
        //      $_GET = array(
        //                  [page]          =>  protoPress
        //                  [action]        =>  edit-record
        //                  [dataset_slug]  =>  projects
        //                  [record_key]    =>  "xxx"
        //                  )
        //
        // -------------------------------------------------------------------------

        if ( count( $dataset_records ) > 0 ) {

            $_GET['action']     = 'edit-record' ;
            $_GET['record_key'] = $dataset_records[0][ $key_field_slug ] ;
                //  Edit the FIRST (and should be only) record

        } else {

            $_GET['action'] = 'add-record' ;

        }

        // ---------------------------------------------------------------------

        $display_options    = array() ;
        $submission_options = array() ;

        // ---------------------------------------------------------------------

        return add_edit_record(
                    $caller_app_slash_plugins_global_namespace      ,
                    $dataset_manager_home_page_title                ,
                    $caller_apps_includes_dir                       ,
                    $all_application_dataset_definitions            ,
                    $dataset_slug                                   ,
                    $question_front_end                             ,
                    $display_options                                ,
                    $submission_options
                    ) ;

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // GET the Manage Dataset HTML...
    // =========================================================================

    if (  $question_front_end ) {

        // ---------------------------------------------------------------------

        require_once( dirname( __FILE__ ) . '/manage-dataset-with-dhtmlx-grid.php' ) ;

        // -------------------------------------------------------------------------
        // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\manage_dataset_with_dhtmlx_grid(
        //      $caller_app_slash_plugins_global_namespace      ,
        //      $dataset_manager_home_page_title                ,
        //      $caller_apps_includes_dir                       ,
        //      $all_application_dataset_definitions            ,
        //      $selected_datasets_dmdd                         ,
        //      $dataset_records                                ,
        //      $dataset_title                                  ,
        //      $dataset_slug                                   ,
        //      $question_front_end                             ,
        //      $orphaned_record_indices
        //      )
        // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
        // Creates and returns a widget for adding, editing and deleting records
        // of the specified dataset.
        //
        // $all_application_dataset_definitions should be like (eg):-
        //
        //      $all_application_dataset_definitions = Array(
        //
        //          [projects] => Array(    //  <== "dataset_slug"
        //              [dataset_slug]              => projects
        //              [dataset_name_singular]     => project
        //              [dataset_name_plural]       => projects
        //              [dataset_title_singular]    => Project
        //              [dataset_title_plural]      => Projects
        //              [basepress_dataset_handle]  => array(...)
        //              )
        //
        //          ...
        //
        //          )
        //
        // NOTE!
        // =====
        // The returned widget be the widget requested proper.  Or it may be just
        // (eg;) a header, error message and footer.
        //
        // RETURNS:-
        //      $page_html STRING
        // -------------------------------------------------------------------------

        return manage_dataset_with_dhtmlx_grid(
                    $caller_app_slash_plugins_global_namespace      ,
                    $dataset_manager_home_page_title                ,
                    $caller_apps_includes_dir                       ,
                    $all_application_dataset_definitions            ,
                    $selected_datasets_dmdd                         ,
                    $dataset_records                                ,
                    $dataset_title                                  ,
                    $dataset_slug                                   ,
                    $question_front_end                             ,
                    $orphaned_record_indices
                    ) ;

        // ---------------------------------------------------------------------

    } else {

        // ---------------------------------------------------------------------

        require_once( dirname( __FILE__ ) . '/manage-dataset-with-wp-list-table.php' ) ;

        // -------------------------------------------------------------------------
        // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\manage_dataset_with_wp_list_table(
        //      $caller_app_slash_plugins_global_namespace      ,
        //      $dataset_manager_home_page_title                ,
        //      $caller_apps_includes_dir                       ,
        //      $all_application_dataset_definitions            ,
        //      $selected_datasets_dmdd                         ,
        //      $dataset_records                                ,
        //      $dataset_title                                  ,
        //      $dataset_slug                                   ,
        //      $question_front_end                             ,
        //      $orphaned_record_indices
        //      )
        // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
        // Creates and returns a widget for adding, editing and deleting records
        // of the specified dataset.
        //
        // $all_application_dataset_definitions should be like (eg):-
        //
        //      $all_application_dataset_definitions = Array(
        //
        //          [projects] => Array(    //  <== "dataset_slug"
        //              [dataset_slug]              => projects
        //              [dataset_name_singular]     => project
        //              [dataset_name_plural]       => projects
        //              [dataset_title_singular]    => Project
        //              [dataset_title_plural]      => Projects
        //              [basepress_dataset_handle]  => array(...)
        //              )
        //
        //          ...
        //
        //          )
        //
        // NOTE!
        // =====
        // The returned widget be the widget requested proper.  Or it may be just
        // (eg;) a header, error message and footer.
        //
        // RETURNS:-
        //      $page_html STRING
        // -------------------------------------------------------------------------

        return manage_dataset_with_wp_list_table(
                    $caller_app_slash_plugins_global_namespace      ,
                    $dataset_manager_home_page_title                ,
                    $caller_apps_includes_dir                       ,
                    $all_application_dataset_definitions            ,
                    $selected_datasets_dmdd                         ,
                    $dataset_records                                ,
                    $dataset_title                                  ,
                    $dataset_slug                                   ,
                    $question_front_end                             ,
                    $orphaned_record_indices
                    ) ;

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // That's that!
    // =========================================================================

}

// =============================================================================
// question_show_orphaned_records_button()
// =============================================================================

/*
function question_show_orphaned_records_button(
    $selected_datasets_dmdd
    ) {

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $selected_datasets_dmdd['dataset_records_table'] = array(
    //          ...
    //          'buttons'   =>  array(
    //              array(
    //                  'type'  =>  'add_record'
    //                  )   ,
    //              array(
    //                  'type'                          =>  'custom'                                                            ,
    //                  'title'                         =>  'Clone Built-In Layout'                                             ,
    //                  'get_button_html_function_name' =>  '\\' . __NAMESPACE__ . '\\get_clone_built_in_layout_button_html'    ,
    //                  'extra_args'                    =>  NULL
    //                  )   ,
    //              array(
    //                  'type'                          =>  'custom'                                                            ,
    //                  'title'                         =>  'Clone Custom Layout'                                               ,
    //                  'get_button_html_function_name' =>  '\\' . __NAMESPACE__ . '\\get_clone_custom_layout_button_html'      ,
    //                  'extra_args'                    =>  NULL
    //                  )   ,
    //              array(
    //                  'type'  =>  'delete_all_records'
    //                  )   ,
    //              array(
    //                  'type'  =>  'show_orphaned_records'
    //                  )
    //              )
    //          ...
    //          )
    //
    // -------------------------------------------------------------------------

    if (    array_key_exists( 'buttons' , $selected_datasets_dmdd['dataset_records_table'] )
            &&
            is_array( $selected_datasets_dmdd['dataset_records_table']['buttons'] )
        ) {

        // ---------------------------------------------------------------------

         foreach ( $selected_datasets_dmdd['dataset_records_table']['buttons'] as $this_button ) {

            if (    array_key_exists( 'type' , $this_button )
                    &&
                    $this_button['type'] === 'show_orphaned_records'
                ) {
                return TRUE ;
            }

        }

        // ---------------------------------------------------------------------

    }

    // -------------------------------------------------------------------------

    return FALSE ;

    // -------------------------------------------------------------------------

}
*/

// =============================================================================
// That's that!
// =============================================================================

