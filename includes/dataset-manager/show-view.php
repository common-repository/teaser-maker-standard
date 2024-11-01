<?php

// *****************************************************************************
// DATASET-MANAGER / SHOW-VIEW.PHP
// (C) 2013 Peter Newman. All Rights Reserved.
// *****************************************************************************

    namespace greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager ;

// =============================================================================
// show_view()
// =============================================================================

function show_view(
    $caller_app_slash_plugins_global_namespace      ,
    $dataset_manager_home_page_title                ,
    $caller_apps_includes_dir                       ,
    $all_application_dataset_definitions            ,
    $all_application_view_definitions               ,
    $view_slug                                      ,
    $question_front_end
    ) {

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\show_view(
    //      $caller_app_slash_plugins_global_namespace      ,
    //      $dataset_manager_home_page_title                ,
    //      $caller_apps_includes_dir                       ,
    //      $all_application_dataset_definitions            ,
    //      $all_application_view_definitions               ,
    //      $view_slug                                      ,
    //      $question_front_end
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // Creates and returns a screen for that implements the specified "view"...
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
    //              ...
    //              )
    //
    //          ...
    //
    //          )
    //
    // $all_application_view_definitions should be like (eg):-
    //
    //      $all_application_view_definitions = Array(
    //
    //          [url_tree] => Array(
    //              [view_slug] => url_tree
    //              [view_title] => URL Tree
    //              ...
    //          )
    //
    //          ...
    //
    //      )
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
    // Get the specified view's definition...
    // =========================================================================

    $selected_views_definition = $all_application_view_definitions[ $view_slug ] ;

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $selected_views_definition = array(
    //
    //          [view_slug]                             => url_tree
    //          [view_title]                            => URL Tree
    //
    //          [singular_name_of_the_listed_records]   => URL Tree
    //          [plural_name_of_the_listed_records]     => URL Tree
    //
    //          [page_header]                           =>  array(
    //                                                          'method'    =>  'standard'
    //                                                          )
    //
    //          [page_footer]                           =>  array(
    //                                                          'method'    =>  'standard'
    //                                                          )
    //
    //          [view_records_table]                    => Array(
    //
    //              [column_defs] => Array(
    //
    //                  [0] => Array(
    //                              [base_slug]             => tree
    //                              [label]                 => Tree
    //                              [question_sortable]     =>
    //                              [raw_value_from]        => Array(
    //                                  [method]    => data_table
    //                                  [instance]  => tree
    //                                  )
    //                              [display_treatments]    =>
    //                              )
    //
    //                  [1] => Array(
    //                              [base_slug]             => action
    //                              [label]                 => Action
    //                              [question_sortable]     =>
    //                              [raw_value_from]        => Array(
    //                                  [method]    => data_table
    //                                  [instance]  => actions
    //                                  )
    //                              [display_treatments]    =>
    //                              )
    //
    //                  )
    //
    //              [get_table_data_function_name]          => "[\\some_namespace_name\\]get_table_data"
    //
    //              [table_header_before_iframe]            =>  array(
    //                                                              'method'    =>  'button-add-dataset'    ,
    //                                                              'instance'  =>  'projects'
    //                                                              )
    //              [table_footer_after_iframe]             =>  array(
    //                                                              'method'    =>  'none'
    //                                                              )
    //
    //              [table_header_in_iframe]                =>  array(
    //                                                              'method'    =>  'none'
    //                                                              )
    //              [table_footer_in_iframe]                =>  array(
    //                                                              'method'    =>  'none'
    //                                                              )
    //
    //              [rows_per_page]                         => 10
    //              [default_data_field_slug_to_orderby]    =>
    //              [default_order]                         =>
    //              [action_separator]                      =>
    //
    //              )
    //
    //          )
    //
    // -------------------------------------------------------------------------

//pr( $selected_views_definition ) ;

    // =========================================================================
    // Get the "View Title" (for error reporting purposes)...
    // =========================================================================

    if (    ! isset( $selected_views_definition['view_title'] )
            ||
            ! is_string( $selected_views_definition['view_title'] )
            ||
            trim( $selected_views_definition['view_title'] ) === ''
        ) {
        $selected_views_definition['view_title'] = to_title( $view_slug ) ;
    }

    // -------------------------------------------------------------------------

    $view_title = $selected_views_definition['view_title'] ;

    // =========================================================================
    // CHECK/DEFAULT the view's PAGE HEADER...
    // =========================================================================

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $selected_views_definition = array(
    //          ...
    //          [page_header]   =>  array(
    //                                  'method'    =>  'none'
    //                                  )
    //          --OR--
    //          [page_header]   =>  array(
    //                                  'method'    =>  'standard'
    //                                  )
    //          ...
    //          )
    //
    // -------------------------------------------------------------------------

    if ( isset( $selected_views_definition['page_header'] ) ) {

        // ---------------------------------------------------------------------

        if ( ! is_array( $selected_views_definition['page_header'] ) ) {

            $msg = <<<EOT
PROBLEM:&nbsp; Bad view "page_header" (not an array)
For view:&nbsp; {$view_title}
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\show_view()
EOT;

            return standard_dataset_manager_error(
                        $dataset_manager_home_page_title        ,
                        $msg                                    ,
                        $caller_apps_includes_dir               ,
                        $question_front_end
                        ) ;

        }

        // ---------------------------------------------------------------------

        if ( ! array_key_exists( 'method' , $selected_views_definition['page_header'] ) ) {

            $msg = <<<EOT
PROBLEM:&nbsp; Bad view "page_header" (no "method")
For view:&nbsp; {$view_title}
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\show_view()
EOT;

            return standard_dataset_manager_error(
                        $dataset_manager_home_page_title        ,
                        $msg                                    ,
                        $caller_apps_includes_dir               ,
                        $question_front_end
                        ) ;

        }

        // ---------------------------------------------------------------------

        if (    ! is_string( $selected_views_definition['page_header']['method'] )
                ||
                trim( $selected_views_definition['page_header']['method'] ) === ''
                ||
                strlen( $selected_views_definition['page_header']['method'] ) > 64
                ||
                ! \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_stringUtils\ctype_alphanumeric_underscore_dash( $selected_views_definition['page_header']['method'] )
            ) {

            $msg = <<<EOT
PROBLEM:&nbsp; Bad view "page_header" (1 to 64 character "alphanumeric underscore dash" type string expected)
For view:&nbsp; {$view_title}
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\show_view()
EOT;

            return standard_dataset_manager_error(
                        $dataset_manager_home_page_title        ,
                        $msg                                    ,
                        $caller_apps_includes_dir               ,
                        $question_front_end
                        ) ;

        }

        // ---------------------------------------------------------------------

    } else {

        // ---------------------------------------------------------------------

        $selected_views_definition['page_header'] = array(
            'method'    =>  'none'
            ) ;

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // CHECK/DEFAULT the view's PAGE FOOTER...
    // =========================================================================

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $selected_views_definition = array(
    //          ...
    //          [page_footer]   =>  array(
    //                                  'method'    =>  'none'
    //                                  )
    //          --OR--
    //          [page_footer]   =>  array(
    //                                  'method'    =>  'standard'
    //                                  )
    //          ...
    //          )
    //
    // -------------------------------------------------------------------------

    if ( isset( $selected_views_definition['page_footer'] ) ) {

        // ---------------------------------------------------------------------

        if ( ! is_array( $selected_views_definition['page_footer'] ) ) {

            $msg = <<<EOT
PROBLEM:&nbsp; Bad view "page_footer" (not an array)
For view:&nbsp; {$view_title}
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\show_view()
EOT;

            return standard_dataset_manager_error(
                        $dataset_manager_home_page_title        ,
                        $msg                                    ,
                        $caller_apps_includes_dir               ,
                        $question_front_end
                        ) ;

        }

        // ---------------------------------------------------------------------

        if ( ! array_key_exists( 'method' , $selected_views_definition['page_footer'] ) ) {

            $msg = <<<EOT
PROBLEM:&nbsp; Bad view "page_footer" (no "method")
For view:&nbsp; {$view_title}
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\show_view()
EOT;

            return standard_dataset_manager_error(
                        $dataset_manager_home_page_title        ,
                        $msg                                    ,
                        $caller_apps_includes_dir               ,
                        $question_front_end
                        ) ;

        }

        // ---------------------------------------------------------------------

    } else {

        // ---------------------------------------------------------------------

        $selected_views_definition['page_footer'] = array(
            'method'    =>  'none'
            ) ;

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // GET the Manage Dataset HTML...
    // =========================================================================

    if (  $question_front_end ) {

        // ---------------------------------------------------------------------

        require_once( dirname( __FILE__ ) . '/show-view-with-dhtmlx-grid.php' ) ;

        // -------------------------------------------------------------------------
        // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\show_view_with_dhtmlx_grid(
        //      $caller_app_slash_plugins_global_namespace      ,
        //      $dataset_manager_home_page_title                ,
        //      $caller_apps_includes_dir                       ,
        //      $all_application_dataset_definitions            ,
        //      $all_application_view_definitions               ,
        //      $selected_views_definition                      ,
        //      $view_title                                     ,
        //      $view_slug                                      ,
        //      $question_front_end
        //      )
        // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
        // Creates and returns a widget for displaying and possibly managing
        // the records shown by the specified view...
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
        //              ...
        //              )
        //
        //          ...
        //
        //          )
        //
        // $all_application_view_definitions should be like (eg):-
        //
        //      $all_application_view_definitions = Array(
        //
        //          [url_tree] => Array(
        //              [view_slug] => url_tree
        //              [view_title] => URL Tree
        //              ...
        //          )
        //
        //          ...
        //
        //      )
        //
        // NOTE!
        // =====
        // The returned widget be the widget requested proper.  Or it may be just
        // (eg;) a header, error message and footer.
        //
        // RETURNS:-
        //      $page_html STRING
        // -------------------------------------------------------------------------

        return show_view_with_dhtmlx_grid(
                    $caller_app_slash_plugins_global_namespace      ,
                    $dataset_manager_home_page_title                ,
                    $caller_apps_includes_dir                       ,
                    $all_application_dataset_definitions            ,
                    $all_application_view_definitions               ,
                    $selected_views_definition                      ,
                    $view_title                                     ,
                    $view_slug                                      ,
                    $question_front_end
                    ) ;

        // ---------------------------------------------------------------------

    } else {

        // ---------------------------------------------------------------------

        require_once( dirname( __FILE__ ) . '/show-view-with-wp-list-table.php' ) ;

        // -------------------------------------------------------------------------
        // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\show_view_with_wp_list_table(
        //      $caller_app_slash_plugins_global_namespace      ,
        //      $dataset_manager_home_page_title                ,
        //      $caller_apps_includes_dir                       ,
        //      $all_application_dataset_definitions            ,
        //      $all_application_view_definitions               ,
        //      $selected_views_definition                      ,
        //      $view_title                                     ,
        //      $view_slug                                      ,
        //      $question_front_end
        //      )
        // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
        // Creates and returns a widget for displaying and possibly managing
        // the records shown by the specified view...
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
        //              ...
        //              )
        //
        //          ...
        //
        //          )
        //
        // $all_application_view_definitions should be like (eg):-
        //
        //      $all_application_view_definitions = Array(
        //
        //          [url_tree] => Array(
        //              [view_slug] => url_tree
        //              [view_title] => URL Tree
        //              ...
        //          )
        //
        //          ...
        //
        //      )
        //
        // NOTE!
        // =====
        // The returned widget be the widget requested proper.  Or it may be just
        // (eg;) a header, error message and footer.
        //
        // RETURNS:-
        //      $page_html STRING
        // -------------------------------------------------------------------------

        return show_view_with_wp_list_table(
                    $caller_app_slash_plugins_global_namespace      ,
                    $dataset_manager_home_page_title                ,
                    $caller_apps_includes_dir                       ,
                    $all_application_dataset_definitions            ,
                    $all_application_view_definitions               ,
                    $selected_views_definition                      ,
                    $view_title                                     ,
                    $view_slug                                      ,
                    $question_front_end
                    ) ;

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // That's that!
    // =========================================================================

}

// =============================================================================
// get_view_page_header()
// =============================================================================

function get_view_page_header(
    $caller_app_slash_plugins_global_namespace      ,
    $dataset_manager_home_page_title                ,
    $caller_apps_includes_dir                       ,
    $all_application_dataset_definitions            ,
    $all_application_view_definitions               ,
    $selected_views_definition                      ,
    $view_title                                     ,
    $view_slug                                      ,
    $question_front_end
    ) {

    // -------------------------------------------------------------------------
    // get_view_page_header(
    //      $caller_app_slash_plugins_global_namespace      ,
    //      $dataset_manager_home_page_title                ,
    //      $caller_apps_includes_dir                       ,
    //      $all_application_dataset_definitions            ,
    //      $all_application_view_definitions               ,
    //      $selected_views_definition                      ,
    //      $view_title                                     ,
    //      $view_slug                                      ,
    //      $question_front_end
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // RETURNS
    //      o   On SUCCESS!
    //          - - - - - -
    //          STRING $page_header_html
    //
    //      o   On FAILURE!
    //          - - - - - -
    //          array( $error_message STRING )
    // -------------------------------------------------------------------------

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $selected_views_definition = array(
    //          ...
    //          [page_header]   =>  array(
    //                                  'method'    =>  'none'
    //                                  )
    //          --OR--
    //          [page_header]   =>  array(
    //                                  'method'    =>  'standard'
    //                                  )
    //          ...
    //          )
    //
    // Where:-
    //      o   "page_header" is both present and an array, and;
    //      o   "page_header" + "method" is both present and a 1 to 64
    //          character "alphanumeric, underscore dash" type string.
    //
    // However:-
    //      o   Whether the specified "method" is recognised/supported, and;
    //      o   Whether the method-specific "instance" and "args" parameters
    //          are present and valid,
    // is UNKNOWN.
    // -------------------------------------------------------------------------

    if ( $selected_views_definition['page_header']['method'] === 'none' ) {

        // =====================================================================
        // "METHOD" = NONE...
        // =====================================================================

        return '' ;

        // ---------------------------------------------------------------------

    } elseif ( $selected_views_definition['page_header']['method'] === 'standard' ) {

        // =====================================================================
        // "METHOD" = STANDARD...
        // =====================================================================

        $page_title = $selected_views_definition['view_title'] ;

        return get_page_header(
                    $page_title                 ,
                    $caller_apps_includes_dir   ,
                    $question_front_end
                    ) ;

        // ---------------------------------------------------------------------

    } else {

        // =====================================================================
        // ERROR
        // =====================================================================

        $safe_method = htmlentities( $selected_views_definition['page_header']['method'] ) ;

        $msg = <<<EOT
PROBLEM:&nbsp; Unrecognised/unsupported view "page_header" + "method" ("{$safe_method}")
For view:&nbsp; {$view_title}
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\get_view_page_header()
EOT;

        return array( $msg ) ;

    }

    // =========================================================================
    // That's that!
    // =========================================================================

}

// =============================================================================
// get_view_page_footer()
// =============================================================================

function get_view_page_footer(
    $caller_app_slash_plugins_global_namespace      ,
    $dataset_manager_home_page_title                ,
    $caller_apps_includes_dir                       ,
    $all_application_dataset_definitions            ,
    $all_application_view_definitions               ,
    $selected_views_definition                      ,
    $view_title                                     ,
    $view_slug                                      ,
    $question_front_end
    ) {

    // -------------------------------------------------------------------------
    // get_view_page_footer(
    //      $caller_app_slash_plugins_global_namespace      ,
    //      $dataset_manager_home_page_title                ,
    //      $caller_apps_includes_dir                       ,
    //      $all_application_dataset_definitions            ,
    //      $all_application_view_definitions               ,
    //      $selected_views_definition                      ,
    //      $view_title                                     ,
    //      $view_slug                                      ,
    //      $question_front_end
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // RETURNS
    //      o   On SUCCESS!
    //          - - - - - -
    //          STRING $page_footer_html
    //
    //      o   On FAILURE!
    //          - - - - - -
    //          array( $error_message STRING )
    // -------------------------------------------------------------------------

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $selected_views_definition = array(
    //          ...
    //          [page_footer]   =>  array(
    //                                  'method'    =>  'none'
    //                                  )
    //          --OR--
    //          [page_footer]   =>  array(
    //                                  'method'    =>  'standard'
    //                                  )
    //          ...
    //          )
    //
    // Where:-
    //      o   "page_footer" is both present and an array, and;
    //      o   "page_footer" + "method" is both present and a 1 to 64
    //          character "alphanumeric, underscore dash" type string.
    //
    // However:-
    //      o   Whether the specified "method" is recognised/supported, and;
    //      o   Whether the method-specific "instance" and "args" parameters
    //          are present and valid,
    // is UNKNOWN.
    // -------------------------------------------------------------------------

    if ( $selected_views_definition['page_footer']['method'] === 'none' ) {

        // =====================================================================
        // "METHOD" = NONE...
        // =====================================================================

        return '' ;

        // ---------------------------------------------------------------------

    } elseif ( $selected_views_definition['page_footer']['method'] === 'standard' ) {

        // =====================================================================
        // "METHOD" = STANDARD...
        // =====================================================================

        return <<<EOT
<br />
<br />
EOT;

        // ---------------------------------------------------------------------

    } else {

        // =====================================================================
        // ERROR
        // =====================================================================

        $safe_method = htmlentities( $selected_views_definition['page_footer']['method'] ) ;

        $msg = <<<EOT
PROBLEM:&nbsp; Unrecognised/unsupported view "page_footer" + "method" ("{$safe_method}")
For view:&nbsp; {$view_title}
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\get_view_page_footer()
EOT;

        return array( $msg ) ;

    }

    // =========================================================================
    // That's that!
    // =========================================================================

}

// =============================================================================
// get_view_records_table_header_before_iframe()
// =============================================================================

function get_view_records_table_header_before_iframe(
    $caller_app_slash_plugins_global_namespace      ,
    $dataset_manager_home_page_title                ,
    $caller_apps_includes_dir                       ,
    $all_application_dataset_definitions            ,
    $all_application_view_definitions               ,
    $selected_views_definition                      ,
    $view_title                                     ,
    $view_slug                                      ,
    $question_front_end
    ) {

    // -------------------------------------------------------------------------
    // get_view_records_table_header_before_iframe(
    //      $caller_app_slash_plugins_global_namespace      ,
    //      $dataset_manager_home_page_title                ,
    //      $caller_apps_includes_dir                       ,
    //      $all_application_dataset_definitions            ,
    //      $all_application_view_definitions               ,
    //      $selected_views_definition                      ,
    //      $view_title                                     ,
    //      $view_slug                                      ,
    //      $question_front_end
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // RETURNS
    //      o   On SUCCESS!
    //          - - - - - -
    //          STRING $view_records_table_before_iframe_header_html
    //
    //      o   On FAILURE!
    //          - - - - - -
    //          array( $error_message STRING )
    // -------------------------------------------------------------------------

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $selected_views_definition = array(
    //          ...
    //          [view_records_table] => Array(
    //              ...
    //              [table_header_before_iframe]    =>  array(
    //                                                      'method'    =>  'none'
    //                                                      )
    //              --OR--
    //              [table_header_before_iframe]    =>  array(
    //                                                      'method'    =>  'button-add-dataset-record'     ,
    //                                                      'instance'  =>  'projects'
    //                                                      )
    //              ...
    //              )
    //          ...
    //          )
    //
    // Where:-
    //      o   "table_header_before_iframe" is both present and an array, and;
    //      o   "table_header_before_iframe" + "method" is both present and a 1
    //          to 64 character "alphanumeric, underscore dash" type string.
    //
    // However:-
    //      o   Whether the specified "method" is recognised/supported, and;
    //      o   Whether the method-specific "instance" and "args" parameters
    //          are present and valid,
    // is UNKNOWN.
    // -------------------------------------------------------------------------

    if ( $selected_views_definition['view_records_table']['table_header_before_iframe']['method'] === 'none' ) {

        // =====================================================================
        // "METHOD" = NONE...
        // =====================================================================

        return '' ;

        // ---------------------------------------------------------------------

    } elseif ( $selected_views_definition['view_records_table']['table_header_before_iframe']['method'] === 'button-add-dataset-record' ) {

        // =====================================================================
        // "METHOD" = BUTTON-ADD-DATASET-RECORD...
        // =====================================================================

        // ---------------------------------------------------------------------
        // Here we should have (eg):-
        //
        //      $selected_views_definition = array(
        //          ...
        //          [view_records_table] => Array(
        //              ...
        //              [table_header_before_iframe]    =>  array(
        //                                                      'method'    =>  'button-add-dataset-record'     ,
        //                                                      'instance'  =>  'projects'                      ,
        //                                                      'args'      =>  array(
        //                                                                          'record_type_title' =>  'Project'
        //                                                                          )
        //                                                      )
        //              ...
        //              )
        //          ...
        //          )
        // ---------------------------------------------------------------------

        // ---------------------------------------------------------------------
        // $dataset_slug
        // ---------------------------------------------------------------------

        if ( ! isset( $selected_views_definition['view_records_table']['table_header_before_iframe']['instance'] ) ) {

            $msg = <<<EOT
PROBLEM:&nbsp; Bad "view_records_table" + "table_header_before_iframe" (no "instance" - for "method" = "button-add-dataset-record")
For view:&nbsp; {$view_title}
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\get_view_records_table_header_before_iframe()
EOT;

            return array( $msg ) ;

        }

        // ---------------------------------------------------------------------

        if (    ! is_string( $selected_views_definition['view_records_table']['table_header_before_iframe']['instance'] )
                ||
                trim( $selected_views_definition['view_records_table']['table_header_before_iframe']['instance'] ) === ''
                ||
                strlen( $selected_views_definition['view_records_table']['table_header_before_iframe']['instance'] ) > 64
            ) {

            $msg = <<<EOT
PROBLEM:&nbsp; Bad "view_records_table" + "table_header_before_iframe" + "instance" (1 to 64 character string expected)
For view:&nbsp; {$view_title}
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\get_view_records_table_header_before_iframe()
EOT;

            return array( $msg ) ;

        }

        // ---------------------------------------------------------------------

        if ( ! array_key_exists(
                    $selected_views_definition['view_records_table']['table_header_before_iframe']['instance']  ,
                    $all_application_dataset_definitions
                    )
            ) {

            $safe_instance = htmlentities( $selected_views_definition['view_records_table']['table_header_before_iframe']['instance'] ) ;

            $msg = <<<EOT
PROBLEM:&nbsp; Bad "view_records_table" + "table_header_before_iframe" + "instance" ("{$safe_instance}" - no such dataset)
For view:&nbsp; {$view_title}
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\get_view_records_table_header_before_iframe()
EOT;

            return array( $msg ) ;

        }

        // ---------------------------------------------------------------------

        $dataset_slug = $selected_views_definition['view_records_table']['table_header_before_iframe']['instance'] ;

        // ---------------------------------------------------------------------
        // $record_type_title
        // ---------------------------------------------------------------------

        $record_type_title = 'Record' ;

        // ---------------------------------------------------------------------

        if (    array_key_exists(
                    'args'                                                                          ,
                    $selected_views_definition['view_records_table']['table_header_before_iframe']
                    )
                &&
                is_array( $selected_views_definition['view_records_table']['table_header_before_iframe']['args'] )
                &&
                array_key_exists(
                    'record_type_title'                                                                     ,
                    $selected_views_definition['view_records_table']['table_header_before_iframe']['args']
                    )
            ) {

            // -----------------------------------------------------------------

            if (    ! is_string( $selected_views_definition['view_records_table']['table_header_before_iframe']['args']['record_type_title'] )
                    ||
                    trim( $selected_views_definition['view_records_table']['table_header_before_iframe']['args']['record_type_title'] ) === ''
                    ||
                    strlen( $selected_views_definition['view_records_table']['table_header_before_iframe']['args']['record_type_title'] ) > 64
                ) {

                $msg = <<<EOT
PROBLEM:&nbsp; Bad "view_records_table" + "table_header_before_iframe" + "args" + "record_type_title (1 to 64 character string expected)
For view:&nbsp; {$view_title}
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\get_view_records_table_header_before_iframe()
EOT;

                return array( $msg ) ;

            }

            // -----------------------------------------------------------------

            $record_type_title = htmlentities(
                $selected_views_definition['view_records_table']['table_header_before_iframe']['args']['record_type_title']
                ) ;

            // -----------------------------------------------------------------

        }

        // -------------------------------------------------------------------------
        // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\get_add_dataset_record_button(
        //      $caller_apps_includes_dir       ,
        //      $question_front_end             ,
        //      $dataset_slug                   ,
        //      $record_type_title              ,
        //      $view_title = FALSE             ,
        //      $return_to = FALSE              ,
        //      $view_slug = FALSE
        //      )
        // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
        // RETURNS
        //      o   On SUCCESS!
        //          - - - - - -
        //          STRING $add_dataset_record_button_html
        //
        //      o   On FAILURE!
        //          - - - - - -
        //          array( $error_message STRING )
        // -------------------------------------------------------------------------

        $return_to  = 'show-view' ;

        // ---------------------------------------------------------------------

        return get_add_dataset_record_button(
                    $caller_apps_includes_dir   ,
                    $question_front_end         ,
                    $dataset_slug               ,
                    $record_type_title          ,
                    $view_title                 ,
                    $return_to                  ,
                    $view_slug
                    ) ;

        // ---------------------------------------------------------------------

    } else {

        // =====================================================================
        // ERROR
        // =====================================================================

        $safe_method = htmlentities( $selected_views_definition['view_records_table']['table_header_before_iframe']['method'] ) ;

        $msg = <<<EOT
PROBLEM:&nbsp; Unrecognised/unsupported "view_records_table" + "table_header_before_iframe" + "method" ("{$safe_method}")
For view:&nbsp; {$view_title}
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\get_view_records_table_header_before_iframe()
EOT;

        return array( $msg ) ;

    }

    // =========================================================================
    // That's that!
    // =========================================================================

}

// =============================================================================
// get_view_records_table_footer_after_iframe()
// =============================================================================

function get_view_records_table_footer_after_iframe(
    $caller_app_slash_plugins_global_namespace      ,
    $dataset_manager_home_page_title                ,
    $caller_apps_includes_dir                       ,
    $all_application_dataset_definitions            ,
    $all_application_view_definitions               ,
    $selected_views_definition                      ,
    $view_title                                     ,
    $view_slug                                      ,
    $question_front_end
    ) {

    // -------------------------------------------------------------------------
    // get_view_records_table_footer_after_iframe(
    //      $caller_app_slash_plugins_global_namespace      ,
    //      $dataset_manager_home_page_title                ,
    //      $caller_apps_includes_dir                       ,
    //      $all_application_dataset_definitions            ,
    //      $all_application_view_definitions               ,
    //      $selected_views_definition                      ,
    //      $view_title                                     ,
    //      $view_slug                                      ,
    //      $question_front_end
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // RETURNS
    //      o   On SUCCESS!
    //          - - - - - -
    //          STRING $view_records_table_before_iframe_header_html
    //
    //      o   On FAILURE!
    //          - - - - - -
    //          array( $error_message STRING )
    // -------------------------------------------------------------------------

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $selected_views_definition = array(
    //          ...
    //          [view_records_table] => Array(
    //              ...
    //              [table_footer_after_iframe]     =>  array(
    //                                                      'method'    =>  'none'
    //                                                      )
    //              ...
    //              )
    //          ...
    //          )
    //
    // Where:-
    //      o   "table_footer_after_iframe" is both present and an array, and;
    //      o   "table_footer_after_iframe" + "method" is both present and a 1
    //          to 64 character "alphanumeric, underscore dash" type string.
    //
    // However:-
    //      o   Whether the specified "method" is recognised/supported, and;
    //      o   Whether the method-specific "instance" and "args" parameters
    //          are present and valid,
    // is UNKNOWN.
    // -------------------------------------------------------------------------

    if ( $selected_views_definition['view_records_table']['table_footer_after_iframe']['method'] === 'none' ) {

        // =====================================================================
        // "METHOD" = NONE...
        // =====================================================================

        return '' ;

        // ---------------------------------------------------------------------

    } else {

        // =====================================================================
        // ERROR
        // =====================================================================

        $safe_method = htmlentities( $selected_views_definition['view_records_table']['table_footer_after_iframe']['method'] ) ;

        $msg = <<<EOT
PROBLEM:&nbsp; Unrecognised/unsupported "view_records_table" + "table_footer_after_iframe" + "method" ("{$safe_method}")
For view:&nbsp; {$view_title}
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\get_view_records_table_footer_after_iframe()
EOT;

        return array( $msg ) ;

    }

    // =========================================================================
    // That's that!
    // =========================================================================

}

// =============================================================================
// That's that!
// =============================================================================

