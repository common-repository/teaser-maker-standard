<?php

// *****************************************************************************
// DATASET-MANAGER / SHOW-VIEW-WITH-WP-LIST-TABLE.PHP
// (C) 2013 Peter Newman. All Rights Reserved.
// *****************************************************************************

    namespace greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager ;

// =============================================================================
// show_view_with_wp_list_table()
// =============================================================================

function show_view_with_wp_list_table(
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
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
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
    // CHECK and DEFAULT the "VIEW RECORDS TABLE" (from which we create the
    // WP LIST TABLE display the records in)...
    // =========================================================================

    require_once( dirname( __FILE__ ) . '/check-and-default-view-records-table.php' ) ;

    // -------------------------------------------------------------------------
    // check_and_default_view_records_table(
    //      $dataset_manager_home_page_title        ,
    //      $caller_apps_includes_dir               ,
    //      $all_application_dataset_definitions    ,
    //      $all_application_view_definitions       ,
    //      $selected_views_definition              ,
    //      $view_title                             ,
    //      $view_slug                              ,
    //      $question_front_end
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - -
    // Checks for:-
    //      $selected_views_definition['view_records_table']
    //
    // defaulting it and it's members as necessary.
    //
    // RETURNS:-
    //      On SUCCESS!
    //      - - - - - -
    //      ARRAY $checked_defaulted_view_records_table
    //
    //      On FAILURE!
    //      - - - - - -
    //      $error_message STRING
    // -------------------------------------------------------------------------

    $checked_defaulted_view_records_table = check_and_default_view_records_table(
                                                $dataset_manager_home_page_title        ,
                                                $caller_apps_includes_dir               ,
                                                $all_application_dataset_definitions    ,
                                                $all_application_view_definitions       ,
                                                $selected_views_definition              ,
                                                $view_title                             ,
                                                $view_slug                              ,
                                                $question_front_end
                                                ) ;

    // -------------------------------------------------------------------------

    if ( is_string( $checked_defaulted_view_records_table ) ) {

        return standard_dataset_manager_error(
                    $dataset_manager_home_page_title            ,
                    $checked_defaulted_view_records_table       ,
                    $caller_apps_includes_dir                   ,
                    $question_front_end
                    ) ;

    }

    // -------------------------------------------------------------------------

    $selected_view_definition['view_records_table'] =
        $checked_defaulted_view_records_table
        ;

    // =========================================================================
    // Create the arguments required by:-
    //
    //      get_wordpress_table_for_dataset(
    //          $singular_name_of_the_listed_records    ,
    //          $plural_name_of_the_listed_records      ,
    //          $column_titles_by_name                  ,
    //          $sortable_columns                       ,
    //          $default_orderby                        ,
    //          $default_order                          ,
    //          $rows_per_page                          ,
    //          $table_data
    //          )
    //
    // These arguments are created from the specified dataset's:-
    //      --  Standard Dataset Manager dataset definition, and;
    //      --  It's dataset records.
    // =========================================================================

    // =========================================================================
    // singular_name_of_the_listed_records
    // =========================================================================

    $singular_name_of_the_listed_records = 'record' ;

    // -------------------------------------------------------------------------

    if (    isset( $selected_views_definition['singular_name_of_the_listed_records'] )
            &&
            is_string( $selected_views_definition['singular_name_of_the_listed_records'] )
        ) {

        if ( trim( $selected_views_definition['singular_name_of_the_listed_records'] ) !== '' ) {
            $singular_name_of_the_listed_records = trim( $selected_views_definition['singular_name_of_the_listed_records'] ) ;
        }

    }

    // =========================================================================
    // plural_name_of_the_listed_records
    // =========================================================================

    $plural_name_of_the_listed_records = 'records' ;

    // -------------------------------------------------------------------------

    if (    isset( $selected_views_definition['plural_name_of_the_listed_records'] )
            &&
            is_string( $selected_views_definition['plural_name_of_the_listed_records'] )
        ) {

        if ( trim( $selected_views_definition['plural_name_of_the_listed_records'] ) !== '' ) {
            $plural_name_of_the_listed_records = trim( $selected_views_definition['plural_name_of_the_listed_records'] ) ;
        }

    }

    // =========================================================================
    // GET the VIEW RECORDS to be displayed...
    // =========================================================================

    // -------------------------------------------------------------------------
    // \researchAssistant_byFernTec_datasetManager_viewDefs_url_tree\get_table_data(
    //      $caller_apps_includes_dir               ,
    //      $all_application_dataset_definitions    ,
    //      $all_application_view_definitions       ,
    //      $selected_views_definition              ,
    //      $view_slug                              ,
    //      $view_title                             ,
    //      $question_front_end                     ,
    //      $data_for
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // Gets the:-
    //      $table_data
    //
    // for the specified view.
    //
    // $data_for must be one of:-
    //      o   'wp-list-table'
    //      o   'dhtmlx-grid'
    //
    // RETURNS
    //      o   On SUCCESS
    //          - - - - -
    //          #   $data_for = 'wp-list-table'
    //                  array(
    //                      ARRAY  $table_data                              ,
    //                      ARRAY  $data_field_slugs_for_column_sorting     ,
    //                      STRING $support_javascript
    //                      )
    //          #   $data_for = 'dhtmlx-grid'
    //                  array(
    //                      ARRAY  $table_data                              ,
    //                      ARRAY  $sort_data                               ,
    //                      ARRAY  $data_field_slugs_for_column_sorting     ,
    //                      STRING $support_javascript
    //                      )
    //
    //          Where:-
    //              $support_javascript
    //          is the Javascript required (for things like "DELETE this
    //          record? ARE YOU SURE?" confirmation, etc),
    //
    //      o   On FAILURE
    //          - - - - -
    //          $error_message STRING
    // -------------------------------------------------------------------------

    if (    ! array_key_exists( 'view_records_table' , $selected_views_definition )
            ||
            ! array_key_exists( 'get_table_data_function_name' , $selected_views_definition['view_records_table'] )
        ) {

        $msg = <<<EOT
PROBLEM:&nbsp; No "view_records_table" + "get_table_data_function_name"
For View:&nbsp; {$view_title}
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\show_view_with_wp_list_table()
EOT;

        return standard_dataset_manager_error(
                    $dataset_manager_home_page_title    ,
                    $msg                                ,
                    $caller_apps_includes_dir           ,
                    $question_front_end
                    ) ;

    }

    // -------------------------------------------------------------------------

    if (    ! is_string( $selected_views_definition['view_records_table']['get_table_data_function_name'] )
            ||
            trim( $selected_views_definition['view_records_table']['get_table_data_function_name'] ) === ''
            ||
            strlen( $selected_views_definition['view_records_table']['get_table_data_function_name'] ) > 999
        ) {

        $msg = <<<EOT
PROBLEM:&nbsp; Bad "view_records_table" + "get_table_data_function_name" (1 to 999 character string expected)
For View:&nbsp; {$view_title}
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\show_view_with_wp_list_table()
EOT;

        return standard_dataset_manager_error(
                    $dataset_manager_home_page_title    ,
                    $msg                                ,
                    $caller_apps_includes_dir           ,
                    $question_front_end
                    ) ;

    }

    // -------------------------------------------------------------------------

    if ( ! function_exists( $selected_views_definition['view_records_table']['get_table_data_function_name'] ) ) {

        $safe_get_table_data_function_name = htmlentities( $selected_views_definition['view_records_table']['get_table_data_function_name'] ) ;

        $msg = <<<EOT
PROBLEM:&nbsp; Bad "view_records_table" + "get_table_data_function_name" (no such function)
For View:&nbsp; {$view_title}
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\show_view_with_wp_list_table()
EOT;

        return standard_dataset_manager_error(
                    $dataset_manager_home_page_title    ,
                    $msg                                ,
                    $caller_apps_includes_dir           ,
                    $question_front_end
                    ) ;

    }

    // -------------------------------------------------------------------------

    $data_for = 'wp-list-table' ;

    // -------------------------------------------------------------------------

    $result = $selected_views_definition['view_records_table']['get_table_data_function_name'](
                    $caller_apps_includes_dir               ,
                    $all_application_dataset_definitions    ,
                    $all_application_view_definitions       ,
                    $selected_views_definition              ,
                    $view_slug                              ,
                    $view_title                             ,
                    $question_front_end                     ,
                    $data_for
                    ) ;

    // -------------------------------------------------------------------------

    if ( is_string( $result ) ) {

        return standard_dataset_manager_error(
                    $dataset_manager_home_page_title    ,
                    $result                             ,
                    $caller_apps_includes_dir           ,
                    $question_front_end
                    ) ;

    }

    // -------------------------------------------------------------------------

    list(
        $table_data                              ,
        $data_field_slugs_for_column_sorting     ,
        $support_javascript
        ) = $result ;

    // =========================================================================
    // column_titles_by_name
    // sortable_columns
    // =========================================================================

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $selected_datasets_dmdd['dataset_records_table'] = array(
    //
    //          [column_defs] => Array(
    //
    //              [0] => Array(
    //                      [base_slug]                     => title
    //                      [label]                         => Project Title
    //                      [question_sortable]             => 1
    //                      [raw_value_from]                => Array(
    //                          [method] => array-storage-field-slug
    //                          [instance] => title
    //                          )
    //
    //                      [display_treatments]            => Array()
    //                      [sort_treatments]               => Array()
    //
    //                      [data_field_slug_to_display]    => title
    //                      [data_field_slug_to_sort_by]    => title
    //                      [header_halign]                 => center
    //                      [header_valign]                 => middle
    //                      [data_halign]                   => center
    //                      [data_valign]                   => middle
    //                      [width_in_percent]              => 50
    //                      )
    //
    //              [1] => Array(
    //                      [base_slug]                     => action
    //                      [label]                         => Action
    //                      [question_sortable]             =>
    //                      [raw_value_from]                => Array(
    //                          [method] => special-type
    //                          [instance] => action
    //                          )
    //
    //                      [display_treatments]            => Array()
    //                      [sort_treatments]               => Array()
    //
    //                      [data_field_slug_to_display]    => action
    //                      [data_field_slug_to_sort_by]    => action
    //                      [header_halign]                 => center
    //                      [header_valign]                 => middle
    //                      [data_halign]                   => center
    //                      [data_valign]                   => middle
    //                      [width_in_percent]              => 50
    //                      )
    //
    //              )
    //
    //          [rows_per_page]                         => 10
    //          [default_data_field_slug_to_orderby]    => title
    //          [default_order]                         => asc
    //          [actions]                               => Array(
    //              [edit]      => edit
    //              [delete]    => delete
    //              )
    //          [action_separator]                      =>
    //          [checked_defaulted_ok]                  => 1
    //
    //          )
    //
    // -------------------------------------------------------------------------

    $column_titles_by_name = array() ;

    $sortable_columns = array() ;

    // -------------------------------------------------------------------------

    if (    isset( $selected_views_definition['view_records_table']['column_defs'] )
            &&
            is_array( $selected_views_definition['view_records_table']['column_defs'] )
            &&
            count( $selected_views_definition['view_records_table']['column_defs'] ) > 0
        ) {

        // ---------------------------------------------------------------------

        $column_titles_by_name = array() ;

        // ---------------------------------------------------------------------

        foreach ( $selected_views_definition['view_records_table']['column_defs'] as $this_column ) {

            // -----------------------------------------------------------------
            // Here we should have (eg):-
            //
            //      $this_column = array(
            //          [base_slug]                     => title
            //          [label]                         => Project Title
            //          [question_sortable]             => 1
            //          [raw_value_from]                => Array(
            //              [method] => array-storage-field-slug
            //              [instance] => title
            //              )
            //
            //          [display_treatments]            => Array()
            //          [sort_treatments]               => Array()
            //
            //          [data_field_slug_to_display]    => title
            //          [data_field_slug_to_sort_by]    => title
            //          [header_halign]                 => center
            //          [header_valign]                 => middle
            //          [data_halign]                   => center
            //          [data_valign]                   => middle
            //          [width_in_percent]              => 50
            //          )
            //
            // -----------------------------------------------------------------

            $this_column['data_field_slug_to_display'] = $this_column['base_slug'] ;

            // -------------------------------------------------------------

            $column_titles_by_name[ $this_column['data_field_slug_to_display'] ] = $this_column['label'] ;

            // -------------------------------------------------------------
            // $sortable_columns should be like (eg):-
            //
            //      $sortable_columns = array(
            //          '<column name in $column_titles_by_name>'   =>  array( '<field name in $table_data>' , TRUE/FALSE )
            //          ...
            //          )
            //
            // Where TRUE/FALSE indicates whether or not the table data is
            // already sorted on this column (use FALSE unless you're sure).
            // -------------------------------------------------------------

            if ( $this_column['question_sortable'] === TRUE ) {

                // -------------------------------------------------------

                $sortable_columns[ $this_column['data_field_slug_to_display'] ] =
                    array( $this_column['data_field_slug_to_sort_by'] , FALSE )
                    ;

                // ---------------------------------------------------------

            }

            // -----------------------------------------------------------------

        }

        // ---------------------------------------------------------------------

    } elseif ( count( $table_data ) > 0 ) {

        // ---------------------------------------------------------------------

        foreach ( $table_data[0] as $name => $value ) {
            $column_titles_by_name[ $name ] = to_title( $name ) ;
        }

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // default_orderby
    // =========================================================================

    $default_orderby = '' ;

    // -------------------------------------------------------------------------

    if (    isset( $selected_views_definition['view_records_table']['default_data_field_slug_to_orderby'] )
            &&
            is_string( $selected_views_definition['view_records_table']['default_data_field_slug_to_orderby'] )
            &&
            in_array(   $selected_views_definition['view_records_table']['default_data_field_slug_to_orderby']     ,
                        $data_field_slugs_for_column_sorting                                        ,
                        TRUE
                        )
        ) {

        $default_orderby = $selected_views_definition['view_records_table']['default_data_field_slug_to_orderby'] ;

//  } elseif ( count( $dataset_records ) > 0 ) {
//
//      $temp = array_keys( $dataset_records[0] ) ;
//
//      if (    in_array(   $temp[0]                                ,
//                          $data_field_slugs_for_column_sorting    ,
//                          TRUE
//                          )
//          ) {
//          $default_orderby = $temp[0] ;
//      }

    }

    // =========================================================================
    // default_order
    // =========================================================================

    $default_order = '' ;

    // -------------------------------------------------------------------------

    if (    isset( $selected_views_definition['view_records_table']['default_order'] )
            &&
            is_string( $selected_views_definition['view_records_table']['default_order'] )
            &&
            in_array(   strtolower( $selected_views_definition['view_records_table']['default_order'] )  ,
                        array( 'asc' , 'desc' )                                                 ,
                        TRUE
                        )
        ) {
        $default_order = strtolower( $selected_views_definition['view_records_table']['default_order'] ) ;

    } else {
        $default_order = 'asc' ;

    }

    // =========================================================================
    // rows_per_page
    // =========================================================================

    $rows_per_page = '' ;

    // -------------------------------------------------------------------------

    if (    isset( $selected_views_definition['view_records_table']['rows_per_page'] )
            &&
            is_scalar( $selected_views_definition['view_records_table']['rows_per_page'] )
        ) {
        $rows_per_page = $selected_views_definition['view_records_table']['rows_per_page'] ;

    } else {
        $rows_per_page = 10 ;

    }

    // =========================================================================
    // GET the HTML for the WordPress Admin "List Table" - which HTML displays
    // the dataset's records...
    // =========================================================================

    require_once( dirname( __FILE__ ) . '/manage-dataset-wp-list-table-inner.php' ) ;

    // -------------------------------------------------------------------------
    // get_wordpress_table_for_dataset(
    //      $singular_name_of_the_listed_records    ,
    //      $plural_name_of_the_listed_records      ,
    //      $column_titles_by_name                  ,
    //      $sortable_columns                       ,
    //      $default_orderby                        ,
    //      $default_order                          ,
    //      $rows_per_page                          ,
    //      $table_data
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - -
    // $sortable_columns should be like (eg):-
    //
    //      $sortable_columns = array(
    //          '<column name in $column_titles_by_name>'   =>  array( '<field name in $table_data>' , TRUE/FALSE )
    //          ...
    //          )
    //
    // Where TRUE/FALSE indicates whether or not the table data is already
    // sorted on this column (use FALSE unless you're sure).
    //
    // RETURNS
    //      $body_content STRING
    // -------------------------------------------------------------------------

    $view_table = get_wordpress_table_for_dataset(
                        $singular_name_of_the_listed_records    ,
                        $plural_name_of_the_listed_records      ,
                        $column_titles_by_name                  ,
                        $sortable_columns                       ,
                        $default_orderby                        ,
                        $default_order                          ,
                        $rows_per_page                          ,
                        $table_data
                        ) ;

    // =========================================================================
    // Get the VIEW's PAGE HEADER...
    // =========================================================================

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

    $view_page_header = get_view_page_header(
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

    // -------------------------------------------------------------------------

    if ( is_array( $view_page_header ) ) {

        return standard_dataset_manager_error(
            $dataset_manager_home_page_title    ,
            $view_page_header[0]                ,
            $caller_apps_includes_dir           ,
            $question_front_end
            ) ;

    }

    // =========================================================================
    // Get the VIEW's PAGE FOOTER...
    // =========================================================================

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

    $view_page_footer = get_view_page_footer(
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

    // -------------------------------------------------------------------------

    if ( is_array( $view_page_footer ) ) {

        return standard_dataset_manager_error(
            $dataset_manager_home_page_title    ,
            $view_page_footer[0]                ,
            $caller_apps_includes_dir           ,
            $question_front_end
            ) ;

    }

    // =========================================================================
    // Get the VIEW RECORD TABLE HEADER BEFORE IFRAME...
    // =========================================================================

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

    $view_records_table_header_before_iframe =
        get_view_records_table_header_before_iframe(
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

    // -------------------------------------------------------------------------

    if ( is_array( $view_records_table_header_before_iframe ) ) {

        return standard_dataset_manager_error(
            $dataset_manager_home_page_title                ,
            $view_records_table_header_before_iframe[0]     ,
            $caller_apps_includes_dir                       ,
            $question_front_end
            ) ;

    }

    // =========================================================================
    // Get the VIEW RECORD TABLE FOOTER AFTER IFRAME...
    // =========================================================================

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

    $view_records_table_footer_after_iframe =
        get_view_records_table_footer_after_iframe(
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

    // -------------------------------------------------------------------------

    if ( is_array( $view_records_table_footer_after_iframe ) ) {

        return standard_dataset_manager_error(
            $dataset_manager_home_page_title                ,
            $view_records_table_footer_after_iframe[0]      ,
            $caller_apps_includes_dir                       ,
            $question_front_end
            ) ;

    }

    // =========================================================================
    // DISPLAY the PAGE...
    // =========================================================================

    return <<<EOT
{$view_page_header}
{$view_records_table_header_before_iframe}
{$view_table}
{$view_records_table_footer_after_iframe}
{$view_page_footer}
{$support_javascript}
EOT;

    // =========================================================================
    // That's that!
    // =========================================================================

}

// =============================================================================
// That's that!
// =============================================================================

