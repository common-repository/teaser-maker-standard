<?php

// *****************************************************************************
// DATASET-MANAGER / MANAGE-DATASET-WITH-WP-LIST-TABLE.PHP
// (C) 2013 Peter Newman. All Rights Reserved.
// *****************************************************************************

    namespace greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager ;

// =============================================================================
// manage_dataset_with_wp_list_table()
// =============================================================================

function manage_dataset_with_wp_list_table(
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
    ) {

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
    //              ...
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

    // =========================================================================
    // Init.
    // =========================================================================

    $ns = __NAMESPACE__ ;
    $fn = __FUNCTION__ ;

    // =========================================================================
    // CHECK and DEFAULT the "DATASET RECORDS TABLE" (definition) (from which
    // we create the WP LIST TABLE to display the records in)...
    // =========================================================================

    require_once( dirname( __FILE__ ) . '/check-and-default-dataset-records-table.php' ) ;

    // -------------------------------------------------------------------------
    // check_and_default_dataset_records_table(
    //      $dataset_manager_home_page_title        ,
    //      $caller_apps_includes_dir               ,
    //      $all_application_dataset_definitions    ,
    //      $selected_datasets_dmdd                 ,
    //      $dataset_records                        ,
    //      $dataset_title                          ,
    //      $dataset_slug                           ,
    //      $question_front_end
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - -
    // Checks for:-
    //      $selected_datasets_dmdd['dataset_records_table']
    //
    // defaulting it and it's members as necessary.
    //
    // RETURNS:-
    //      On SUCCESS!
    //      - - - - - -
    //      ARRAY $dataset_records_table
    //
    //      On FAILURE!
    //      - - - - - -
    //      $error_message STRING
    // -------------------------------------------------------------------------

    $result = check_and_default_dataset_records_table(
                    $dataset_manager_home_page_title        ,
                    $caller_apps_includes_dir               ,
                    $all_application_dataset_definitions    ,
                    $selected_datasets_dmdd                 ,
                    $dataset_records                        ,
                    $dataset_title                          ,
                    $dataset_slug                           ,
                    $question_front_end
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

    $selected_datasets_dmdd['dataset_records_table'] = $result ;

    // =========================================================================
    // Create the arguments required by:-
    //
    //      get_wordpress_table_for_dataset(
    //          $dataset_slug_singular      ,
    //          $dataset_slug_plural        ,
    //          $column_titles_by_name      ,
    //          $sortable_columns           ,
    //          $default_orderby            ,
    //          $default_order              ,
    //          $rows_per_page              ,
    //          $table_data
    //          )
    //
    // These arguments are created from the specified dataset's:-
    //      --  Standard Dataset Manager dataset definition, and;
    //      --  It's dataset records.
    // =========================================================================

    // -------------------------------------------------------------------------
    // A Standard Dataset Manager dataset definition is like (eg):-
    //
    //      $selected_datasets_dmdd = Array(
    //
    //          [dataset_slug]              => projects
    //          [dataset_name_singular]     => project
    //          [dataset_name_plural]       => projects
    //          [dataset_title_singular]    => Project
    //          [dataset_title_plural]      => Projects
    //          [basepress_dataset_handle]  => Array(
    //              [nice_name]     => researchAssistant_byFernTec_projects
    //              [unique_key]    => d2562b23-3c20-4368-92c4-2b6cd...200c9a66
    //              [version]       => 0.1
    //              )
    //
    //          [dataset_records_table] => Array(
    //
    //              [column_defs] => Array(
    //
    //                  [0] => Array(
    //                          [base_slug]                     => title
    //                          [label]                         => Project Title
    //                          [question_sortable]             => 1
    //                          [raw_value_from]                => Array(
    //                              [method] => array-storage-field-slug
    //                              [instance] => title
    //                              )
    //
    //                          [display_treatments]            => Array()
    //                          [sort_treatments]               => Array()
    //
    //                          [data_field_slug_to_display]    => title
    //                          [data_field_slug_to_sort_by]    => title
    //                          [header_halign]                 => center
    //                          [header_valign]                 => middle
    //                          [data_halign]                   => center
    //                          [data_valign]                   => middle
    //                          [width_in_percent]              => 50
    //                          )
    //
    //                  [1] => Array(
    //                          [base_slug]                     => action
    //                          [label]                         => Action
    //                          [question_sortable]             =>
    //                          [raw_value_from]                => Array(
    //                              [method] => special-type
    //                              [instance] => action
    //                              )
    //
    //                          [display_treatments]            => Array()
    //                          [sort_treatments]               => Array()
    //
    //                          [data_field_slug_to_display]    => action
    //                          [data_field_slug_to_sort_by]    => action
    //                          [header_halign]                 => center
    //                          [header_valign]                 => middle
    //                          [data_halign]                   => center
    //                          [data_valign]                   => middle
    //                          [width_in_percent]              => 50
    //                          )
    //
    //                  )
    //
    //              [rows_per_page]                         => 10
    //              [default_data_field_slug_to_orderby]    => title
    //              [default_order]                         => asc
    //              [actions]                               => Array(
    //                  [edit]      => edit
    //                  [delete]    => delete
    //                  )
    //              [action_separator]                      =>
    //              [checked_defaulted_ok]                  => 1
    //
    //              )
    //
    //          [zebra_form]                        => Array(...)
    //
    //          [array_storage_record_structure]    => Array(...)
    //
    //          [array_storage_key_field_slug]      => key
    //
    //          )
    //
    // -------------------------------------------------------------------------

//pr( $selected_datasets_dmdd ) ;

    // -------------------------------------------------------------------------
    // The dataset's records are like (eg):-
    //
    //      $dataset_records = Array(
    //
    //          [0] => Array(
    //                      [datetime_created_UTC]       =>  1387428878
    //                      [datetime_last_modified_UTC] =>  1387428878
    //                      [key]                        =>  52b27c0e89913
    //                      [title]                      =>  Project 1
    //                      [notes_slash_comments]       =>
    //                      )
    //
    //          ...
    //
    //          )
    //
    // -------------------------------------------------------------------------

//pr( $dataset_records ) ;

    // =========================================================================
    // dataset_slug_singular
    // =========================================================================

    $dataset_slug_singular = 'record' ;

    // -------------------------------------------------------------------------

    if (    isset( $selected_datasets_dmdd['dataset_name_singular'] )
            &&
            is_string( $selected_datasets_dmdd['dataset_name_singular'] )
        ) {

        if ( trim( $selected_datasets_dmdd['dataset_name_singular'] ) !== '' ) {
            $dataset_slug_singular = trim( $selected_datasets_dmdd['dataset_name_singular'] ) ;
        }

    }

    // =========================================================================
    // dataset_slug_plural
    // =========================================================================

    $dataset_slug_plural = 'records' ;

    // -------------------------------------------------------------------------

    if (    isset( $selected_datasets_dmdd['dataset_name_plural'] )
            &&
            is_string( $selected_datasets_dmdd['dataset_name_plural'] )
        ) {

        if ( trim( $selected_datasets_dmdd['dataset_name_plural'] ) !== '' ) {
            $dataset_slug_plural = trim( $selected_datasets_dmdd['dataset_name_plural'] ) ;
        }

    }

    // =========================================================================
    // GET the DATASET RECORDS to be displayed...
    // =========================================================================

    require_once( dirname( __FILE__ ) . '/get-dataset-records-table-data.php' ) ;

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\
    // get_dataset_records_table_data(
    //      $selected_datasets_dmdd     ,
    //      $dataset_records            ,
    //      $dataset_slug               ,
    //      $dataset_title              ,
    //      $question_front_end         ,
    //      $caller_apps_includes_dir   ,
    //      $data_for
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // Gets the:-
    //      $table_data
    //
    // for the specified dataset and it's data.
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

    $data_for = 'wp-list-table' ;

    // -------------------------------------------------------------------------

    $result = get_dataset_records_table_data(
                    $all_application_dataset_definitions    ,
                    $selected_datasets_dmdd                 ,
                    $dataset_records                        ,
                    $dataset_slug                           ,
                    $dataset_title                          ,
                    $question_front_end                     ,
                    $caller_apps_includes_dir               ,
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
        $table_data                             ,
        $data_field_slugs_for_column_sorting    ,
        $support_javascript
        ) = $result ;

//pr( $table_data ) ;

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

    if (    isset( $selected_datasets_dmdd['dataset_records_table']['column_defs'] )
            &&
            is_array( $selected_datasets_dmdd['dataset_records_table']['column_defs'] )
            &&
            count( $selected_datasets_dmdd['dataset_records_table']['column_defs'] ) > 0
        ) {

        // ---------------------------------------------------------------------

        $column_titles_by_name = array() ;

        // ---------------------------------------------------------------------

        foreach ( $selected_datasets_dmdd['dataset_records_table']['column_defs'] as $this_column ) {

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

    } elseif ( count( $dataset_records ) > 0 ) {

        // ---------------------------------------------------------------------

        foreach ( $dataset_records[0] as $name => $value ) {
            $column_titles_by_name[ $name ] = to_title( $name ) ;
        }

        // ---------------------------------------------------------------------

    }

//pr( $column_titles_by_name ) ;

    // =========================================================================
    // default_orderby
    // =========================================================================

//$data_field_slugs_for_column_sorting = array() ;

    $default_orderby = '' ;

    // -------------------------------------------------------------------------

    if (    isset( $selected_datasets_dmdd['dataset_records_table']['default_data_field_slug_to_orderby'] )
            &&
            is_string( $selected_datasets_dmdd['dataset_records_table']['default_data_field_slug_to_orderby'] )
            &&
            in_array(   $selected_datasets_dmdd['dataset_records_table']['default_data_field_slug_to_orderby']     ,
                        $data_field_slugs_for_column_sorting                                        ,
                        TRUE
                        )
        ) {

        $default_orderby = $selected_datasets_dmdd['dataset_records_table']['default_data_field_slug_to_orderby'] ;

    } elseif ( count( $dataset_records ) > 0 ) {

        $temp = array_keys( $dataset_records[0] ) ;

        if (    in_array(   $temp[0]                                ,
                            $data_field_slugs_for_column_sorting    ,
                            TRUE
                            )
            ) {
            $default_orderby = $temp[0] ;
        }

    }

    // =========================================================================
    // default_order
    // =========================================================================

    $default_order = '' ;

    // -------------------------------------------------------------------------

    if (    isset( $selected_datasets_dmdd['dataset_records_table']['default_order'] )
            &&
            is_string( $selected_datasets_dmdd['dataset_records_table']['default_order'] )
            &&
            in_array(   strtolower( $selected_datasets_dmdd['dataset_records_table']['default_order'] )  ,
                        array( 'asc' , 'desc' )                                                 ,
                        TRUE
                        )
        ) {
        $default_order = strtolower( $selected_datasets_dmdd['dataset_records_table']['default_order'] ) ;

    } else {
        $default_order = 'asc' ;

    }

    // =========================================================================
    // rows_per_page
    // =========================================================================

    $rows_per_page = '' ;

    // -------------------------------------------------------------------------

    if (    isset( $selected_datasets_dmdd['dataset_records_table']['rows_per_page'] )
            &&
            is_scalar( $selected_datasets_dmdd['dataset_records_table']['rows_per_page'] )
        ) {
        $rows_per_page = $selected_datasets_dmdd['dataset_records_table']['rows_per_page'] ;

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
    //      $dataset_slug_singular      ,
    //      $dataset_slug_plural        ,
    //      $column_titles_by_name      ,
    //      $sortable_columns           ,
    //      $default_orderby            ,
    //      $default_order              ,
    //      $rows_per_page              ,
    //      $table_data
    //      )
    // - - - - - - - - - - - - - - - - - -
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

    $dataset_table = get_wordpress_table_for_dataset(
                        $dataset_slug_singular      ,
                        $dataset_slug_plural        ,
                        $column_titles_by_name      ,
                        $sortable_columns           ,
                        $default_orderby            ,
                        $default_order              ,
                        $rows_per_page              ,
                        $table_data
                        ) ;

    // =========================================================================
    // Get the HTML for the TOP BUTTON ROW...
    // =========================================================================

    $top_buttons_html = '' ;

    $top_buttons_expander_html = '' ;

    // -------------------------------------------------------------------------

    $standard_left_margin = 'margin-left:1.5em; ' ;

    $left_margin = '' ;

    // -------------------------------------------------------------------------

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $selected_datasets_dmdd ) ;

    if (    isset( $selected_datasets_dmdd['dataset_records_table']['buttons'] )
            &&
            is_array( $selected_datasets_dmdd['dataset_records_table']['buttons'] )
        ) {

        // ---------------------------------------------------------------------
        // Here we should have (eg):-
        //
        //      $selected_datasets_dmdd['dataset_records_table']['buttons'] = array(
        //          array(
        //              'type'  =>  'add_record'
        //              )   ,
        //          array(
        //              'type'                          =>  'custom'                                                            ,
        //              'title'                         =>  'Clone Built-In Layout'                                             ,
        //              'get_button_html_function_name' =>  '\\' . __NAMESPACE__ . '\\get_clone_built_in_layout_button_html'    ,
        //              'extra_args'                    =>  NULL
        //              )   ,
        //          array(
        //              'type'                          =>  'custom'                                                            ,
        //              'title'                         =>  'Clone Custom Layout'                                               ,
        //              'get_button_html_function_name' =>  '\\' . __NAMESPACE__ . '\\get_clone_custom_layout_button_html'      ,
        //              'extra_args'                    =>  NULL
        //              )
        //          array(
        //              'type'  =>  'delete_all_records'
        //              )
        //          array(
        //              'type'  =>  'show_orphaned_records'
        //              )
        //          )
        //
        // ---------------------------------------------------------------------

        foreach ( $selected_datasets_dmdd['dataset_records_table']['buttons'] as $this_button_index => $this_button_data ) {

            // -----------------------------------------------------------------

            $this_button_number = $this_button_index + 1 ;

            // -----------------------------------------------------------------

            if ( $this_button_data['type'] === 'add_record' ) {

                // =============================================================
                // "ADD RECORD" BUTTON ?
                // =============================================================

                if ( array_key_exists( 'max_records' , $selected_datasets_dmdd ) ) {

                    // -----------------------------------------------------------------

                    if (    ! is_numeric( $selected_datasets_dmdd['max_records'] )
                            ||
                            ! \ctype_digit( (string) $selected_datasets_dmdd['max_records'] )
                        ) {

                        $php_int_max = number_format( PHP_INT_MAX ) ;

                        $msg = <<<EOT
PROBLEM:&nbsp; Bad "max_records" (a number - 0 to {$php_int_max} (without the commas,) was expected)
For dataset:&nbsp; {$dataset_title}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

                    }

                    // -----------------------------------------------------------------

                    $max_records = $selected_datasets_dmdd['max_records'] ;

                    // -----------------------------------------------------------------

                } else {

                    // -----------------------------------------------------------------

                    $max_records = INF ;

                    // -----------------------------------------------------------------

                }

                // ---------------------------------------------------------------------

                if ( count( $dataset_records ) < $max_records ) {

                    // -----------------------------------------------------------------

                    require_once( dirname( __FILE__ ) . '/get-dataset-urls.php' ) ;

                    // -------------------------------------------------------------------------
                    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\get_add_record_url(
                    //      $caller_apps_includes_dir   ,
                    //      $question_front_end         ,
                    //      $dataset_slug = NULL
                    //      )
                    // - - - - - - - - - - - - - - - - -
                    // Returns the "add-record" URL.
                    //
                    // If $dataset_slug is NULL, then we use:-
                    //      $_GET['dataset_slug']
                    //
                    // RETURNS
                    //      o   On SUCCESS!
                    //          - - - - - -
                    //          STRING $url
                    //
                    //      o   On FAILURE!
                    //          - - - - - -
                    //          ARRAY( $error_message STRING )
                    // -------------------------------------------------------------------------

                    $url = get_add_record_url(
                                $caller_apps_includes_dir   ,
                                $question_front_end         ,
                                NULL
                                ) ;

                    // -----------------------------------------------------------------

                    if ( is_array( $url ) ) {

                        return standard_dataset_manager_error(
                                    $dataset_manager_home_page_title    ,
                                    $url[0]                             ,
                                    $caller_apps_includes_dir           ,
                                    $question_front_end
                                    ) ;

                    }

                    // -----------------------------------------------------------------

                    $add_record_button = <<<EOT
<a  href="{$url}"
    style="{$left_margin}padding:3px 10px; background-color:#F1F1F1; font-size: 110%; font-weight:normal; text-decoration:none; text-align:left; position:relative; top:1em"
    >Add&nbsp;{$selected_datasets_dmdd['dataset_title_singular']}</a>
EOT;

                    // -----------------------------------------------------------------

                } else {

                    // -----------------------------------------------------------------

                    $add_record_button = '' ;

                    // -----------------------------------------------------------------

                }

                // ---------------------------------------------------------------------

                $top_buttons_html .= $add_record_button ;

                $left_margin = $standard_left_margin ;

                // ---------------------------------------------------------------------

            } elseif ( $this_button_data['type'] === 'delete_all_records' ) {

                // =============================================================
                // "DELETE ALL RECORDS" BUTTON ?
                // =============================================================

                require_once( dirname( __FILE__ ) . '/get-dataset-urls.php' ) ;

                // -------------------------------------------------------------------------
                // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\get_delete_record_url(
                //      $caller_apps_includes_dir   ,
                //      $question_front_end         ,
                //      $dataset_slug = NULL        ,
                //      $record_key = NULL          ,
                //      $view_title = FALSE         ,
                //      $return_to = FALSE          ,
                //      $view_slug = FALSE
                //      )
                // - - - - - - - - - - - - - - - - - - - - - - - - - - - -
                // Returns the "delete-record" URL.
                //
                // If $dataset_slug is NULL, then we use:-
                //      $_GET['dataset_slug']
                //
                // If $record_key:-
                //
                //      o   Is NULL, then we use:-
                //              $_GET['record_key']
                //
                //          (if it's valid)
                //
                //      o   Is "all", then we're deleting ALL the dataset's records.
                //
                // RETURNS
                //      o   On SUCCESS!
                //          - - - - - -
                //          STRING $url
                //
                //      o   On FAILURE!
                //          - - - - - -
                //          ARRAY( $error_message STRING )
                // -------------------------------------------------------------------------

                $dataset_slug = NULL  ;
                $record_key   = 'all' ;

                // ---------------------------------------------------------------------

                $url = get_delete_record_url(
                            $caller_apps_includes_dir   ,
                            $question_front_end         ,
                            $dataset_slug               ,
                            $record_key
                            ) ;

                // ---------------------------------------------------------------------

                if ( is_array( $url ) ) {

                    return standard_dataset_manager_error(
                                $dataset_manager_home_page_title    ,
                                $url[0]                             ,
                                $caller_apps_includes_dir           ,
                                $question_front_end
                                ) ;

                }

                // ---------------------------------------------------------------------

                $dataset_title_singular = trim( $selected_datasets_dmdd['dataset_title_singular'] ) ;

                // ---------------------------------------------------------------------

                $delete_all_records_button = <<<EOT
<a  href="javascript:void()"
    onclick="greatKiwi_datasetManager_questionDeleteAllRecords('{$dataset_title_singular}','{$url}')"
    style="{$left_margin}padding:3px 10px; background-color:#F1F1F1; font-size: 110%; font-weight:normal; text-decoration:none; text-align:left; position:relative; top:1em"
    >Delete All Records</a>
<script type="text/javascript">
    function greatKiwi_datasetManager_questionDeleteAllRecords( dataset_title_singular , delete_url ) {
        if ( dataset_title_singular === '' ) {
            var question = 'DELETE ***ALL*** the\\nRECORDS in this table ?\\n\\nARE YOU SURE ?' ;
        } else {
            var question = 'DELETE ***ALL*** the\\n\\t"' + dataset_title_singular + '"\\nRECORDS in this table ?\\n\\nARE YOU SURE ?' ;
        }
        if ( confirm( question ) ) {
            location.href = delete_url ;
        }
    }
</script>
EOT;

                // -------------------------------------------------------------

                $top_buttons_html .= $delete_all_records_button ;

                $left_margin = $standard_left_margin ;

                // -------------------------------------------------------------

/*
            } elseif ( $this_button_data['type'] === 'show_orphaned_records' ) {

                // =============================================================
                // "SHOW ORPHANED RECORDS" BUTTON ?
                // =============================================================

                if ( count( $orphaned_record_indices ) > 0 ) {

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

                    // ---------------------------------------------------------

                    $orphaned_records_html = get_orphaned_records_table_html(
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

                    // ---------------------------------------------------------

                    if ( is_array( $orphaned_records_html ) ) {

                        return standard_dataset_manager_error(
                                    $dataset_manager_home_page_title    ,
                                    $orphaned_records_html[0]           ,
                                    $caller_apps_includes_dir           ,
                                    $question_front_end
                                    ) ;

                    }

                    // ---------------------------------------------------------

                    if ( $orphaned_records_html !== '' ) {

                        // -----------------------------------------------------

                        $onclick = <<<EOT
great_kiwi_dataset_manager_toggle_orphaned_records(this)
EOT;

                        // -----------------------------------------------------

                        $record_type = trim( $selected_datasets_dmdd['dataset_title_plural'] ) ;

                        // -----------------------------------------------------

                        if ( $record_type === '' ) {
                             $record_type = 'Records' ;
                        }

                        // -----------------------------------------------------

                        $record_type_lc = strtolower( $record_type ) ;

                        // -----------------------------------------------------

                        $orphaned_records_button = <<<EOT
<a  href="javascript:void()"
    onclick="{$onclick}"
    style="{$left_margin}padding:3px 10px; background-color:#F1F1F1; font-size: 110%; font-weight:normal; text-decoration:none; text-align:left; position:relative; top:1em"
    >Show&nbsp;Orphaned&nbsp;{$record_type}</a>
EOT;

                        // -----------------------------------------------------

                        $top_buttons_html .= $orphaned_records_button ;

                        $left_margin = $standard_left_margin ;

                        // -----------------------------------------------------

                        $top_buttons_expander_html .= <<<EOT
<div    id="great_kiwi_dataset_manager_orphaned_records_expander"
        style="margin:4em 0 0 0; display:none">
    <div    style="margin-bottom:0.5em"
            ><a href="javascript:void()"
                onclick="great_kiwi_dataset_manager_question_delete_all_orphaned_records()"
                style="text-decoration:none; color:#21759B"
                /><b>delete ALL orphaned {$record_type_lc}</b></a> (listed in the table below)
            <div><i>Note that you can also delete the orphaned {$record_type_lc} individually.&nbsp; See the table's last column (right). &#X279C;</i></div>
    </div>
    {$orphaned_records_html}
</div>
<form   name="great_kiwi_dataset_manager_delete_orphaned_records"
        action=""
        method="POST"
        style="display:none"
        ><input type="hidden"
                name="delete_orphaned_records"
                value="true"
                /></form>
<script type="text/javascript">
    jQuery( 'div#great_kiwi_dataset_manager_orphaned_records_expander > div > a' ).hover(
        function() { jQuery( this ).css( 'text-decoration' , 'underline' ) } ,
        function() { jQuery( this ).css( 'text-decoration' , 'none' ) }
        ) ;
    function great_kiwi_dataset_manager_toggle_orphaned_records( a_el ) {
        var el = document.getElementById( 'great_kiwi_dataset_manager_orphaned_records_expander' ) ;
        if ( el ) {
            if ( el.style.display === 'none' ) {
                el.style.display = '' ;
                a_el.innerHTML = 'Hide&nbsp;Orphaned&nbsp;{$selected_datasets_dmdd['dataset_title_plural']}' ;
            } else {
                el.style.display = 'none' ;
                a_el.innerHTML = 'Show&nbsp;Orphaned&nbsp;{$selected_datasets_dmdd['dataset_title_plural']}' ;
            }
        }
    }
    function great_kiwi_dataset_manager_question_delete_all_orphaned_records() {
        var msg = 'DELETE ALL orphaned {$record_type_lc}?\\n\\nARE YOU SURE?' ;
        if ( confirm( msg ) ) {
            document.forms['great_kiwi_dataset_manager_delete_orphaned_records'].submit() ;
        }
    }
</script>
EOT;

                        // -----------------------------------------------------

                    }

                    // ---------------------------------------------------------

                }
*/

                // -------------------------------------------------------------

            } elseif ( $this_button_data['type'] === 'custom' ) {

                // =============================================================
                // "CUSTOM" BUTTON ?
                // =============================================================

                // -------------------------------------------------------------
                // Here we should have (eg):-
                //
                //      $this_button_data = array(
                //          'type'                          =>  'custom'                                                            ,
                //          'title'                         =>  'Clone Built-In Layout'                                             ,
                //          'get_button_html_function_name' =>  '\\' . __NAMESPACE__ . '\\get_clone_built_in_layout_button_html'    ,
                //          'extra_args'                    =>  <any-PHP-value>
                //          )
                //
                // -------------------------------------------------------------

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $this_button_data ) ;

                // -------------------------------------------------------------
                // title ?
                // -------------------------------------------------------------

                if ( ! array_key_exists( 'title' , $this_button_data ) ) {

                    // ---------------------------------------------------------

                    $msg = <<<EOT
PROBLEM:&nbsp; Bad "dataset_records_table" + "buttons" + (custom) button# {$this_button_number} (no "title")
For dataset:&nbsp; {$dataset_title}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

                    return standard_dataset_manager_error(
                                $dataset_manager_home_page_title    ,
                                $msg                                ,
                                $caller_apps_includes_dir           ,
                                $question_front_end
                                ) ;

                    // ---------------------------------------------------------

                }

                // -------------------------------------------------------------

                if (    ! is_string( $this_button_data['title'] )
                        ||
                        trim( $this_button_data['title'] ) === ''
                    ) {

                    // ---------------------------------------------------------

                    $msg = <<<EOT
PROBLEM:&nbsp; Bad "dataset_records_table" + "buttons" + (custom) button# {$this_button_number} + "title" (non-empty string expected)
For dataset:&nbsp; {$dataset_title}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

                    return standard_dataset_manager_error(
                                $dataset_manager_home_page_title    ,
                                $msg                                ,
                                $caller_apps_includes_dir           ,
                                $question_front_end
                                ) ;

                    // ---------------------------------------------------------

                }

                // -------------------------------------------------------------

                $button_title = trim( $this_button_data['title'] ) ;

//echo '<br />' , $button_title ;

                // -------------------------------------------------------------
                // get_button_html_function_name ?
                // -------------------------------------------------------------

                if ( ! array_key_exists( 'get_button_html_function_name' , $this_button_data ) ) {

                    // ---------------------------------------------------------

                    $msg = <<<EOT
PROBLEM:&nbsp; Bad "dataset_records_table" + "buttons" + (custom) button# {$this_button_number} (no "get_button_html_function_name")
For dataset:&nbsp; {$dataset_title}
And button:&nbsp; {$button_title}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

                    return standard_dataset_manager_error(
                                $dataset_manager_home_page_title    ,
                                $msg                                ,
                                $caller_apps_includes_dir           ,
                                $question_front_end
                                ) ;

                    // ---------------------------------------------------------

                }

                // -------------------------------------------------------------

                if (    ! is_string( $this_button_data['get_button_html_function_name'] )
                        ||
                        trim( $this_button_data['get_button_html_function_name'] ) === ''
                    ) {

                    // ---------------------------------------------------------

                    $msg = <<<EOT
PROBLEM:&nbsp; Bad "dataset_records_table" + "buttons" + (custom) button# {$this_button_number} + "get_button_html_function_name" (non-blank string expected)
For dataset:&nbsp; {$dataset_title}
And button:&nbsp; {$button_title}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

                    return standard_dataset_manager_error(
                                $dataset_manager_home_page_title    ,
                                $msg                                ,
                                $caller_apps_includes_dir           ,
                                $question_front_end
                                ) ;

                    // ---------------------------------------------------------

                }

                // -------------------------------------------------------------

                if ( ! function_exists( $this_button_data['get_button_html_function_name'] ) ) {

                    // ---------------------------------------------------------

                    $msg = <<<EOT
PROBLEM:&nbsp; Bad "dataset_records_table" + "buttons" + (custom) button# {$this_button_number} + "get_button_html_function_name" (no such function)
For dataset:&nbsp; {$dataset_title}
And button:&nbsp; {$button_title}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

                    return standard_dataset_manager_error(
                                $dataset_manager_home_page_title    ,
                                $msg                                ,
                                $caller_apps_includes_dir           ,
                                $question_front_end
                                ) ;

                    // ---------------------------------------------------------

                }

//echo '<br />' , $this_button_data['get_button_html_function_name'] ;

                // -------------------------------------------------------------
                // extra_args ?
                // -------------------------------------------------------------

                if ( array_key_exists( 'extra_args', $this_button_data ) ) {
                    $extra_args = $this_button_data['extra_args'] ;

                } else {
                    $extra_args = NULL ;

                }

                // -------------------------------------------------------------
                // CALL the FUNCTION...
                // -------------------------------------------------------------

                // -------------------------------------------------------------------------
                // <my_custom_get_button_html_function>(
                //      $caller_apps_includes_dir                   ,
                //      $all_application_dataset_definitions        ,
                //      $selected_datasets_dmdd                     ,
                //      $dataset_records                            ,
                //      $dataset_title                              ,
                //      $dataset_slug                               ,
                //      $question_front_end                         ,
                //      $orphaned_record_indices                    ,
                //      $table_data                                 ,
                //      $data_field_slugs_for_column_sorting        ,
                //      $column_titles_by_name                      ,
                //      $sortable_columns                           ,
                //      $default_orderby                            ,
                //      $default_order                              ,
                //      $rows_per_page                              ,
                //      $button_title                               ,
                //      $extra_args                                 ,
                //      $left_margin
                //      )
                // - - - - - - - - - - - - - - - - - - - - - - - - -
                // $left_margin is:-
                //      o   '' if this is the FIRST button being displayed
                //      o   'margin-left:1.5em; ' for the SECOND/SUBSEQUENT button
                //
                // RETURNS:-
                //      o   On SUCCESS
                //              ARRAY(
                //                  $button_html           STRING
                //                  $buttons_expander_html STRING
                //                  )
                //
                //      o   On FAILURE
                //              $error_message STRING
                // -------------------------------------------------------------------------

                $result = $this_button_data['get_button_html_function_name'](
                                $caller_apps_includes_dir                   ,
                                $all_application_dataset_definitions        ,
                                $selected_datasets_dmdd                     ,
                                $dataset_records                            ,
                                $dataset_title                              ,
                                $dataset_slug                               ,
                                $question_front_end                         ,
                                $orphaned_record_indices                    ,
                                $table_data                                 ,
                                $data_field_slugs_for_column_sorting        ,
                                $column_titles_by_name                      ,
                                $sortable_columns                           ,
                                $default_orderby                            ,
                                $default_order                              ,
                                $rows_per_page                              ,
                                $button_title                               ,
                                $extra_args                                 ,
                                $left_margin
                                ) ;

                // -------------------------------------------------------------

                if ( is_string( $result ) ) {

                    return standard_dataset_manager_error(
                                $dataset_manager_home_page_title    ,
                                $result                             ,
                                $caller_apps_includes_dir           ,
                                $question_front_end
                                ) ;

                }

                // -------------------------------------------------------------

                $top_buttons_html .= $result[0] ;

                $top_buttons_expander_html .= $result[1] ;

                $left_margin = $standard_left_margin ;

                // -------------------------------------------------------------

            } else {

                // =============================================================
                // ERROR !
                // =============================================================

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $this_button_data ) ;

                $safe_button_type = htmlentities( $this_button_data['type'] ) ;

                $msg = <<<EOT
PROBLEM:&nbsp; Unrecognised/unsupported "dataset_records_table" + "buttons" + button# {$this_button_number} + "type" ("{$safe_button_type}")
For dataset:&nbsp; {$dataset_title}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

                return standard_dataset_manager_error(
                            $dataset_manager_home_page_title    ,
                            $msg                                ,
                            $caller_apps_includes_dir           ,
                            $question_front_end
                            ) ;

                // -------------------------------------------------------------

            }

            // -----------------------------------------------------------------

        }

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // "SHOW ORPHANED RECORDS" BUTTON ?
    // =========================================================================

    if ( count( $orphaned_record_indices ) > 0 ) {

        // -------------------------------------------------------------------------
        // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\
        // get_orphaned_records_table_html(
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

        // ---------------------------------------------------------------------

        $orphaned_records_html = get_orphaned_records_table_html(
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

        // ---------------------------------------------------------------------

        if ( is_array( $orphaned_records_html ) ) {

            return standard_dataset_manager_error(
                        $dataset_manager_home_page_title    ,
                        $orphaned_records_html[0]           ,
                        $caller_apps_includes_dir           ,
                        $question_front_end
                        ) ;

        }

        // ---------------------------------------------------------------------

        if ( $orphaned_records_html !== '' ) {

            // -----------------------------------------------------------------

            $onclick = <<<EOT
great_kiwi_dataset_manager_toggle_orphaned_records(this)
EOT;

            // -----------------------------------------------------------------

            $record_type = trim( $selected_datasets_dmdd['dataset_title_plural'] ) ;

            // -----------------------------------------------------------------

            if ( $record_type === '' ) {
                 $record_type = 'Records' ;
            }

            // -----------------------------------------------------------------

            $record_type_lc = strtolower( $record_type ) ;

            // -----------------------------------------------------------------

            $orphaned_records_button = <<<EOT
<a  href="javascript:void()"
    onclick="{$onclick}"
    style="{$left_margin}padding:3px 10px; background-color:#F1F1F1; font-size: 110%; font-weight:normal; text-decoration:none; text-align:left; position:relative; top:1em"
    >Show&nbsp;Orphaned&nbsp;{$record_type}</a>
EOT;

            // -----------------------------------------------------------------

            $top_buttons_html .= $orphaned_records_button ;

            $left_margin = $standard_left_margin ;

            // -----------------------------------------------------------------

            $top_buttons_expander_html .= <<<EOT
<div    id="great_kiwi_dataset_manager_orphaned_records_expander"
        style="margin:4em 0 0 0; display:none">
    <div    style="margin-bottom:0.5em"
            ><a href="javascript:void()"
                onclick="great_kiwi_dataset_manager_question_delete_all_orphaned_records()"
                style="text-decoration:none; color:#21759B"
                /><b>delete ALL orphaned {$record_type_lc}</b></a> (listed in the table below)
            <div><i>Note that you can also delete the orphaned {$record_type_lc} individually.&nbsp; See the table's last column (right). &#X279C;</i></div>
    </div>
    {$orphaned_records_html}
</div>
<form   name="great_kiwi_dataset_manager_delete_orphaned_records"
        action=""
        method="POST"
        style="display:none"
        ><input type="hidden"
                name="delete_orphaned_records"
                value="true"
                /></form>
<script type="text/javascript">
    jQuery( 'div#great_kiwi_dataset_manager_orphaned_records_expander > div > a' ).hover(
        function() { jQuery( this ).css( 'text-decoration' , 'underline' ) } ,
        function() { jQuery( this ).css( 'text-decoration' , 'none' ) }
        ) ;
    function great_kiwi_dataset_manager_toggle_orphaned_records( a_el ) {
        var el = document.getElementById( 'great_kiwi_dataset_manager_orphaned_records_expander' ) ;
        if ( el ) {
            if ( el.style.display === 'none' ) {
                el.style.display = '' ;
                a_el.innerHTML = 'Hide&nbsp;Orphaned&nbsp;{$selected_datasets_dmdd['dataset_title_plural']}' ;
            } else {
                el.style.display = 'none' ;
                a_el.innerHTML = 'Show&nbsp;Orphaned&nbsp;{$selected_datasets_dmdd['dataset_title_plural']}' ;
            }
        }
    }
    function great_kiwi_dataset_manager_question_delete_all_orphaned_records() {
        var msg = 'DELETE ALL orphaned {$record_type_lc}?\\n\\nARE YOU SURE?' ;
        if ( confirm( msg ) ) {
            document.forms['great_kiwi_dataset_manager_delete_orphaned_records'].submit() ;
        }
    }
</script>
EOT;

            // -----------------------------------------------------------------

        }

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // "RAW MODE" BUTTON ?
    // =========================================================================

    if ( function_exists( '\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\is_raw_mode_for_tables' ) ) {

        // ---------------------------------------------------------------------

        if ( \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\is_raw_mode_for_tables() === TRUE ) {
            $raw_mode_is   = 'ON'  ;
            $turn_raw_mode = 'OFF' ;
            $onclick       = 'great_kiwi_dataset_manager_raw_mode_for_tables_OFF(this)' ;

        } else {
            $raw_mode_is   = 'OFF' ;
            $turn_raw_mode = 'ON'  ;
            $onclick       = 'great_kiwi_dataset_manager_raw_mode_for_tables_ON(this)' ;

        }

        // ---------------------------------------------------------------------

        $js_dir_url = \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_appsAPI\get_js_url() ;

        // ---------------------------------------------------------------------

        $toggle_raw_mode_button = <<<EOT
<a  href="javascript:void()"
    onclick="{$onclick}"
    style="{$left_margin}padding:3px 10px; background-color:#F1F1F1; font-size: 110%; font-weight:normal; text-decoration:none; text-align:left; position:relative; top:1em"
    >Raw Mode is {$raw_mode_is}; Turn it {$turn_raw_mode}</a>
<script type="text/javascript"
        src="{$js_dir_url}/scottHamperCookies.js"
        ></script>
<script type="text/javascript">
    function great_kiwi_dataset_manager_raw_mode_for_tables_ON( a_el ) {
        scottHamperCookies.set( 'gk_dm_rawMode_forTables' , '1' ) ;
        location.reload( true ) ;
    }
    function great_kiwi_dataset_manager_raw_mode_for_tables_OFF( a_el ) {
        scottHamperCookies.set( 'gk_dm_rawMode_forTables' , '0' ) ;
        location.reload( true ) ;
    }
</script>
EOT;

        // ---------------------------------------------------------------------

        $top_buttons_html .= $toggle_raw_mode_button ;

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // DISPLAY the PAGE...
    // =========================================================================

    $page_title = 'Manage ' . $selected_datasets_dmdd['dataset_title_plural'] ;

    $page_header = get_page_header(
                        $page_title                 ,
                        $caller_apps_includes_dir   ,
                        $question_front_end
                        ) ;

    // -------------------------------------------------------------------------

    return <<<EOT
{$page_header}
<div>{$top_buttons_html}</div>
{$top_buttons_expander_html}
{$dataset_table}
{$support_javascript}
EOT;

    // =========================================================================
    // That's that!
    // =========================================================================

}

// =============================================================================
// That's that!
// =============================================================================

