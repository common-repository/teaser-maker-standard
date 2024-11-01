<?php

// *****************************************************************************
// DATASET-MANAGER / SHOW-VIEW-WITH-DHTMLX-GRID.PHP
// (C) 2013 Peter Newman. All Rights Reserved.
// *****************************************************************************

    namespace greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager ;

// =============================================================================
// show_view_with_dhtmlx_grid()
// =============================================================================

function show_view_with_dhtmlx_grid(
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
    // CHECK and DEFAULT the "VIEW REORDS TABLE" (from which we create the
    // DHTMLX GRID to display the records in)...
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

    $selected_views_definition['view_records_table'] =
        $checked_defaulted_view_records_table
        ;

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
    //          [view_records_table] => Array(
    //
    //              [column_defs] => Array(
    //
    //                  [0] => Array(
    //                      [base_slug]                     => tree
    //                      [label]                         => Projects / Categories / URLs
    //                      [question_sortable]             =>
    //                      [raw_value_from]                => Array(
    //                          [method]    => data_table
    //                          [instance]  => tree
    //                          )
    //                      [display_treatments]            => Array()
    //                      [sort_treatments]               => Array()
    //                      [data_field_slug_to_display]    => tree
    //                      [data_field_slug_to_sort_by]    => tree
    //                      [header_halign]                 => center
    //                      [header_valign]                 => middle
    //                      [data_halign]                   => center
    //                      [data_valign]                   => middle
    //                      [width_in_percent]              => 50
    //                      )
    //
    //                  [1] => Array(
    //                      [base_slug]                     => add
    //                      [label]                         => Add
    //                      [question_sortable]             =>
    //                      [raw_value_from]                => Array(
    //                          [method] => data_table
    //                          [instance] => add
    //                          )
    //                      [display_treatments]            => Array()
    //                      [width_in_percent]              => 25
    //                      [sort_treatments]               => Array()
    //                      [data_field_slug_to_display]    => add
    //                      [data_field_slug_to_sort_by]    => add
    //                      [header_halign]                 => center
    //                      [header_valign]                 => middle
    //                      [data_halign]                   => center
    //                      [data_valign]                   => middle
    //                      )
    //
    //                  [2] => Array(
    //                      [base_slug]                     => actions
    //                      [label]                         => Action
    //                      [question_sortable]             =>
    //                      [raw_value_from]                => Array(
    //                          [method]    => data_table
    //                          [instance]  => actions
    //                          )
    //                      [display_treatments]            => Array()
    //                      [width_in_percent]              => 25
    //                      [header_halign]                 => right
    //                      [sort_treatments]               => Array()
    //                      [data_field_slug_to_display]    => actions
    //                      [data_field_slug_to_sort_by]    => actions
    //                      [header_valign]                 => middle
    //                      [data_halign]                   => center
    //                      [data_valign]                   => middle
    //                      )
    //
    //                  )
    //
    //              [get_table_data_function_name]          => \researchAssistant_byFernTec_datasetManager_viewDefs_url_tree\get_table_data
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
    //              )
    //
    //          )
    //
    // -------------------------------------------------------------------------

//pr( $selected_views_definition ) ;

    // =========================================================================
    // CREATE the DHTMLX GRID page for the IFRAME (and SAVE it in the
    // PAGE CACHE)...
    // =========================================================================

    // -------------------------------------------------------------------------
    // create_and_save_views_dhtmlx_grid_page_for_iframe(
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
    //          array(
    //              $page_name      ,
    //              $page_key
    //              )
    //
    //      o   On FAILURE!
    //          - - - - - -
    //          $error_message STRING
    // -------------------------------------------------------------------------

    $result = create_and_save_views_dhtmlx_grid_page_for_iframe(
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
        $page_name      ,
        $page_key
        ) = $result ;

    // =========================================================================
    // Get the URL of the CACHED PAGE...
    // =========================================================================

    require_once( $caller_apps_includes_dir . '/path-utils.php' ) ;

    // -------------------------------------------------------------------------
    // \greatKiwi_pathUtils\wp_path2url(
    //      $path
    //      )
    // - - - - - - - - - - - - - - - - -
    // RETURNS:-
    //      o   $url on SUCCESS
    //      o   array( $error_message ) on FAILURE
    // -------------------------------------------------------------------------

    $iframe_src_path =  dirname( $caller_apps_includes_dir ) . <<<EOT
/remote/get-cached-page.php?page_name={$page_name}&page_key={$page_key}
EOT;

    // -------------------------------------------------------------------------

    $iframe_src_url = \greatKiwi_pathUtils\wp_path2url( $iframe_src_path ) ;

    // -------------------------------------------------------------------------

    if ( is_array( $iframe_src_url ) ) {

        return standard_dataset_manager_error(
            $dataset_manager_home_page_title    ,
            $iframe_src_url[0]                  ,
            $caller_apps_includes_dir           ,
            $question_front_end
            ) ;

    }

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
    // Create the IFRAME HTML...
    // =========================================================================

    $widget_html = <<<EOT
{$view_page_header}
{$view_records_table_header_before_iframe}
<iframe
    src="{$iframe_src_url}"
    width="100%"
    height="800"
    frameborder="0"
    ></iframe>
{$view_records_table_footer_after_iframe}
{$view_page_footer}
EOT;

    // =========================================================================
    // SUCCESS!
    // =========================================================================

    return $widget_html ;

    // =========================================================================
    // That's that!
    // =========================================================================

}

// =============================================================================
// create_and_save_views_dhtmlx_grid_page_for_iframe()
// =============================================================================

function create_and_save_views_dhtmlx_grid_page_for_iframe(
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
    // create_and_save_views_dhtmlx_grid_page_for_iframe(
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
    //          array(
    //              $page_name      ,
    //              $page_key
    //              )
    //
    //      o   On FAILURE!
    //          - - - - - -
    //          $error_message STRING
    // -------------------------------------------------------------------------

    // =========================================================================
    // Get the URLs of the DHTMLX "codebase" and "imgs" dirs...
    // =========================================================================

    require_once( $caller_apps_includes_dir . '/path-utils.php' ) ;

    // -------------------------------------------------------------------------
    // \greatKiwi_pathUtils\wp_path2url(
    //      $path
    //      )
    // - - - - - - - - - - - - - - - - -
    // RETURNS:-
    //      o   $url on SUCCESS
    //      o   array( $error_message ) on FAILURE
    // -------------------------------------------------------------------------

    $codebase_path =    dirname( $caller_apps_includes_dir ) .
                        '/js/dhtmlxGrid/dhtmlxGrid/codebase'
                        ;

    // -------------------------------------------------------------------------

    $codebase_url = \greatKiwi_pathUtils\wp_path2url( $codebase_path ) ;

    // -------------------------------------------------------------------------

    if ( is_array( $codebase_url ) ) {
        return $codebase_url[0] ;
    }

    // -------------------------------------------------------------------------

    $imgs_url = $codebase_url . '/imgs/' ;

    // =========================================================================
    // Get the various DHTMLX Grid setup strings (etc) required...
    // =========================================================================

    $column_titles  = '' ;
    $column_widthsP = '' ;
    $column_halign  = '' ;
    $column_valign  = '' ;

    $header_styles  = array() ;

    $comma = '' ;

    foreach ( $selected_views_definition['view_records_table']['column_defs'] as $this_column_def ) {

        $column_titles  .= $comma . $this_column_def['label']                           ;
        $column_widthsP .= $comma . $this_column_def['width_in_percent']                ;
        $column_halign  .= $comma . $this_column_def['data_halign']                     ;
        $column_valign  .= $comma . $this_column_def['data_valign']                     ;

        $header_styles[] = 'text-align:' . $this_column_def['header_halign'] . ';' ;

        $comma = ',' ;

    }

    $header_styles = json_encode( $header_styles ) ;

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

        return <<<EOT
PROBLEM:&nbsp; No "view_records_table" + "get_table_data_function_name"
For View:&nbsp; {$view_title}
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\show_view_with_dhtmlx_grid()
EOT;

    }

    // -------------------------------------------------------------------------

    if (    ! is_string( $selected_views_definition['view_records_table']['get_table_data_function_name'] )
            ||
            trim( $selected_views_definition['view_records_table']['get_table_data_function_name'] ) === ''
            ||
            strlen( $selected_views_definition['view_records_table']['get_table_data_function_name'] ) > 999
        ) {

        return <<<EOT
PROBLEM:&nbsp; Bad "view_records_table" + "get_table_data_function_name" (1 to 999 character string expected)
For View:&nbsp; {$view_title}
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\show_view_with_dhtmlx_grid()
EOT;

    }

    // -------------------------------------------------------------------------

    if ( ! function_exists( $selected_views_definition['view_records_table']['get_table_data_function_name'] ) ) {

        $safe_get_table_data_function_name = htmlentities( $selected_views_definition['view_records_table']['get_table_data_function_name'] ) ;

        return <<<EOT
PROBLEM:&nbsp; Bad "view_records_table" + "get_table_data_function_name" (no such function)
For View:&nbsp; {$view_title}
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\show_view_with_dhtmlx_grid()
EOT;

    }

    // -------------------------------------------------------------------------

    $data_for = 'dhtmlx-grid' ;

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
        return $result ;
    }

    // -------------------------------------------------------------------------

    list(
        $table_data                             ,
        $sort_data                              ,
        $data_field_slugs_for_column_sorting    ,
        $support_javascript
        ) = $result ;

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $table_data = array(
    //
    //          [0] => Array(
    //                      [project_title]     => Glavin 2
    //                      [category_title]    => Macabre
    //                      [url_title_display] => Google
    //                      [url_display]       => http://www.google.co.nz
    //                      [action]            => edit    delete
    //                      )
    //
    //          [1] => Array(
    //                      [project_title]     => Glavin 2
    //                      [category_title]    => Macabre
    //                      [url_title_display] => Fern 2
    //                      [url_display]       => http://www.ferntechnology.com
    //                      [action]            => edit    delete
    //                      )
    //
    //          )
    //
    // -------------------------------------------------------------------------

//pr( $table_data ) ;

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $sort_data = array(
    //
    //          [project_title] => Array(
    //              [0] => Glavin 2
    //              )
    //
    //          [category_title] => Array(
    //              [0] => Macabre
    //              )
    //
    //          [url_title] => Array(
    //              [0] => Google
    //              [1] => Fern 2
    //              )
    //
    //          [url] => Array(
    //              [0] => http://www.google.co.nz
    //              [1] => http://www.ferntechnology.com
    //              )
    //
    //          )
    //
    // -------------------------------------------------------------------------

//pr( $sort_data ) ;

    // =========================================================================
    // Create the arrays required to support the table sorting in
    // Javascript...
    // =========================================================================

    // -------------------------------------------------------------------------
    // bool natcasesort ( array &$array )
    // - - - - - - - - - - - - - - - - -
    // natcasesort() is a case insensitive version of natsort().
    //
    // This function implements a sort algorithm that orders alphanumeric
    // strings in the way a human being would while maintaining key/value
    // associations. This is described as a "natural ordering".
    //
    // PARAMETERS
    //
    //      array
    //          The input array.
    //
    // RETURN VALUES
    //      Returns TRUE on success or FALSE on failure.
    //
    // (PHP 4, PHP 5)
    //
    // EXAMPLES
    //
    //      Standard Sorting
    //      - - - - - - - -
    //          Array(
    //              [0] => IMG0.png
    //              [1] => IMG3.png
    //              [2] => img1.png
    //              [3] => img10.png
    //              [4] => img12.png
    //              [5] => img2.png
    //              )
    //
    //      Natural Order Sorting (Case-Insensitive)
    //      - - - - - - - - - - - - - - - - - - - -
    //          Array(
    //              [0] => IMG0.png
    //              [4] => img1.png
    //              [3] => img2.png
    //              [5] => IMG3.png
    //              [2] => img10.png
    //              [1] => img12.png
    //              )
    // -------------------------------------------------------------------------

    foreach ( $sort_data as $name => $values ) {

        // =====================================================================
        // SORT the VALUES...
        // =====================================================================

        if ( natcasesort( $values ) !== TRUE ) {

            return <<<EOT
PROBLEM sorting table columns:&nbsp; "natcasesort()" failure
Detectd in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\show_view_with_dhtmlx_grid()
EOT;

        }

        // =====================================================================
        // CREATE the JS-REQUIRED ARRAY...
        // =====================================================================

        $values_js = array() ;

        $index = 1 ;

        // ---------------------------------------------------------------------

        foreach ( $values as $this_value ) {
            $values_js[ $this_value ] = $index ;
            $index++ ;
        }

        // =====================================================================
        // Update $sort_data...
        // =====================================================================

        $sort_data[ $name ] = $values_js ;

        // ---------------------------------------------------------------------

    }

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $sort_data = array(
    //
    //          [project_title] => Array(
    //              [Glavin 2] => 1
    //              )
    //
    //          [category_title] => Array(
    //              [Macabre] => 1
    //              )
    //
    //          [url_title] => Array(
    //              [Fern 2] => 1
    //              [Google] => 2
    //              )
    //
    //          [url] => Array(
    //              [http://www.ferntechnology.com] => 1
    //              [http://www.google.co.nz] => 2
    //              )
    //
    //          )
    //
    // -------------------------------------------------------------------------

//pr( $sort_data ) ;

    // =========================================================================
    // Create the DHTMLX "doInitGrid()" Javascript to add the table Column
    // Sorting support...
    // =========================================================================

    $dhtmlx_table_sorting_support_global     = '' ;
    $dhtmlx_table_sorting_support_doInitGrid = '' ;

    $setColSortingArg = '' ;

    $comma = '' ;

    $customSortFunctions = '' ;

    // -------------------------------------------------------------------------

    if ( count( $sort_data ) > 0 ) {

        // ---------------------------------------------------------------------
        // From DHTMLX Docs
        //  http://docs.dhtmlx.com/doku.php?id=dhtmlxgrid:sorting
        // ======================================================
        //
        // Sorting Types
        // -------------
        // The way of sorting depends on column sorting types. There are 4
        // predefined sorting types:
        //
        //  str  - Data will be sorted as strings (case sensitive)
        //
        //  int  - Data will be sorted as numbers (numbers must be in JS
        //         recognizable format, or the user can apply number formating
        //         feature of the grid);
        //
        //  date - Data will be sorted as a date (dates must be in JS
        //         recognizable format, or the user can apply date formating
        //         feature of the grid);
        //
        //  na   - Sorting is not available for a column (a column will not
        //         react on a header click and sortRows() calls)
        //
        // Sorting types are assigned to columns in the following way:
        //
        //      //grid.setColSorting(list_of_values);
        //      grid.setColSorting("int,str,na,str");
        //          // define sorting state for columns 0-3
        //
        // Custom Sorting (PROFESSIONAL ONLY)
        // - - - - - - - - - - - - - - - - -
        // It should be noted that 4 existing sorting types are not enough to
        // cover all use-cases, so the grid allows to create custom sorting
        // types. Basically the user should define a function that will receive
        // two values and the required order of sorting. The return value will
        // be as follows:
        //
        //      valueA > valueB => return 1
        //      valueA < valueB => return -1
        //
        // The following method should be used to setting custom sorting:
        //
        //      grid.setCustomSorting(func, col);
        //
        //      The parameters are as follows:
        //
        //          func - function to use for comparison;
        //          col - index of the column to apply custom sorting to.
        //
        // Also, if unknown type was used as parameter of setColSorting - grid
        // will try to locate the function with the same name and use it as
        // sorting function. The snippets below show some common use-cases.
        //
        // Case Insensitive Sorting
        // - - - - - - - - - - - -
        //
        //      function str_custom(a,b,order){    // the name of the function must be > than 5 chars
        //          if (order=="asc")
        //              return (a.toLowerCase()>b.toLowerCase()?1:-1);
        //          else
        //              return (a.toLowerCase()>b.toLowerCase()?-1:1);
        //      }
        //      grid.setColSorting("int,str_custom,na,str"); // define sorting state for columns 0-3
        //
        // Custom Time Sorting
        // - - - - - - - - - -
        // This type of custom sorting can be applied for such data as 14:56:
        //
        //      function time_custom(a,b,order){
        //          a=a.split(":")
        //          b=a.split(":")
        //          if (a[0]==b[0])
        //               return (a[1]>b[1]?1:-1)*(order=="asc"?1:-1);
        //          else
        //               return (a[0]>b[0]?1:-1)*(order=="asc"?1:-1);
        //      }
        //      grid.setColSorting("int,time_custom,na,str");
        //
        // Custom Date Sorting
        // - - - - - - - - - -
        // One more type of custom sorting can be for such data as dd/mm/yyyy
        // (the user doesn't need it, if he is using setDateFormat()
        // functionality):
        //
        //      function date_custom(a,b,order){
        //          a=a.split("/")
        //          b=b.split("/")
        //          if (a[2]==b[2]){
        //              if (a[1]==b[1])
        //                  return (a[0]>b[0]?1:-1)*(order=="asc"?1:-1);
        //              else
        //                  return (a[1]>b[1]?1:-1)*(order=="asc"?1:-1);
        //          } else
        //               return (a[2]>b[2]?1:-1)*(order=="asc"?1:-1);
        //      }
        //      grid.setColSorting("int,date_custom,na,st
        // ---------------------------------------------------------------------

        foreach ( $selected_views_definition['view_records_table']['column_defs'] as $this_column_def ) {

            // -----------------------------------------------------------------

            if ( $this_column_def['question_sortable'] ) {

                // -------------------------------------------------------------
                // Column is SORTABLE...
                // -------------------------------------------------------------

                $sort_slug = $this_column_def['data_field_slug_to_sort_by'] ;

                // -------------------------------------------------------------

                $js_custom_sort_function_name = <<<EOT
gk_sdm_byFernTec_customSort_{$sort_slug}
EOT;

                // -------------------------------------------------------------

                $customSortFunctions .= <<<EOT
function {$js_custom_sort_function_name}( a , b , order ) {
alert( a + ' --- ' + b + ' --- ' + order ) ;
    var retval = 0 ;
    if ( window.greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager_dhtmlxGrid_sortData['{$sort_slug}'][a] < window.greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager_dhtmlxGrid_sortData['{$sort_slug}'][b] ) {
        retval = -1 ;
    } else if ( window.greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager_dhtmlxGrid_sortData['{$sort_slug}'][a] > window.greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager_dhtmlxGrid_sortData['{$sort_slug}'][b] ) {
        retval = 1 ;
    }
alert( retval ) ;
    if ( order === 'asc' ) {
        return retval ;
    }
    return -retval ;
}\n
EOT;

                // -------------------------------------------------------------

/*
                $setColSortingArg .= <<<EOT
{$comma}{$js_custom_sort_function_name}
EOT;
*/

                $setColSortingArg .= <<<EOT
{$comma}str
EOT;

                // -------------------------------------------------------------

            } else {

                // -------------------------------------------------------------
                // Column is NOT SORTABLE...
                // -------------------------------------------------------------

                $setColSortingArg .= <<<EOT
{$comma}na
EOT;

                // -------------------------------------------------------------

            }

            // -----------------------------------------------------------------

            $comma = ',' ;

            // -----------------------------------------------------------------

        }

        // ---------------------------------------------------------------------

        $sort_data_js = json_encode( $sort_data ) ;

        // ---------------------------------------------------------------------

        $dhtmlx_table_sorting_support_global = <<<EOT
window.greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager_dhtmlxGrid_sortData = {$sort_data_js} ;
{$customSortFunctions}
EOT;

        // ---------------------------------------------------------------------

        $dhtmlx_table_sorting_support_doInitGrid = <<<EOT
mygrid.setColSorting('{$setColSortingArg}') ;\n
EOT;

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // Add the required Javascript support routines to the
    // "support_javascript"...
    // =========================================================================

/*
    if ( $support_javascript !== '' ) {

        // ---------------------------------------------------------------------

//      $plugin_root_url = dirname( $caller_apps_includes_dir ) ;

        // ---------------------------------------------------------------------

//<script type="text/javascript" src="{$plugin_root_url}/js/nyman-martin-getElementsByClassName.js"></script>

        $support_javascript = <<<EOT
<script type="text/javascript">

    function researchAssistant_byFernTec_get_ancestor( start_el , like ) {
        // -----------------------------------------------------------------------
        // researchAssistant_byFernTec_get_ancestor( start_el , like )
        // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
        // "like" is an object (associative array) like:-
        //
        //      {   tagName                 :   "xxx"
        //          class                   :   "xxx"
        //          id                      :   "xxx"
        //          <property_name_1>       :   <property_value_1>
        //          ...
        //          <property_name_N>       :   <property_value_N>
        //          }
        //
        // All the name = value pairs are optional.  Just specify what you need
        // to identify the ancestor that you're looking for.
        //
        // Returns false if no such ancestor found.
        // -----------------------------------------------------------------------
        var current_el = start_el.parentNode ;
        var all_properties_match ;
        while ( current_el !== document ) {
            all_properties_match = true ;
            for ( name in like ) {
                if ( name === 'tagName' ) {
                    if ( ! current_el[ name ] === undefined || current_el[ name ].toUpperCase() !== like[ name ].toUpperCase() ) {
                        all_properties_match = false ;
                        break ;
                    }
                } else {
                    if ( ! current_el[ name ] === undefined || current_el[ name ] !== like[ name ] ) {
                        all_properties_match = false ;
                        break ;
                    }
                }
            }
            if ( all_properties_match ) {
                return current_el ;
            }
            current_el = current_el.parentNode ;
        }
        return false ;
    }

    function researchAssistant_byFernTec_in_list( list , string_or_number , exact ) {
        //  ------------------------------------------------------------------
        //  in_list( list , string_or_number , exact )
        //  - - - - - - - - - - - - - - - - - - - - -
        //  Check if the specified element is in the specified list.  Where
        //  by list we mean a list of numbers and/or strings.  Eg:-
        //      mylist = [ 1 , 2 , 3 ... ]
        //      mylist = [ 'one' , 'two' , 'three' ... ]
        //      mylist = [ 'one' , 2 , 'three' ... ]
        //
        //  "exact" defaults to false.
        //
        //  Returns true or false.
        //  ------------------------------------------------------------------
        if ( ! exact ) {
            var exact = false ;
        }
        var i , j=list.length ;
        if ( exact ) {
            for ( i=0 ; i<j ; i++ ) {
                if ( list[i] === string_or_number ) {
                    return true ;
                }
            }
        } else {
            for ( i=0 ; i<j ; i++ ) {
                if ( list[i] == string_or_number ) {
                    return true ;
                }
            }
        }
        return false ;
    }

    //  From: http://jamesroberts.name/blog/2010/02/22/string-functions-for-javascript-trim-to-camel-case-to-dashed-and-to-underscore/
    function researchAssistant_byFernTec_toCamelCase( instr ) {
	    return instr.replace( /(\-[a-z])/g , function(\$1){return \$1.toUpperCase().replace('-','')} )
    }

    function researchAssistant_byFernTec_setStyles( el , styles ) {
        //  "styles" is an object of name = value pairs.  Eg:-
        //      styles = {
        //          font-weight :   'bold'      ,
        //          font-size   :   '110%'
        //          }
        for ( var name in styles ) {
            el.style[ researchAssistant_byFernTec_toCamelCase( name ) ] = styles[ name ] ;
        }
    }

{$support_javascript}

</script>
EOT;

    }
*/

    // =========================================================================
    // CONVERT the TABLE DATA to the (field values only) JSARRAY format
    // expected by DHTMLX Grid...
    // =========================================================================

    $table_data_for_dhtmlx = array() ;

    // -------------------------------------------------------------------------

    foreach ( $table_data as $this_index => $this_record ) {
        $table_data_for_dhtmlx[] = array_values( $this_record ) ;
    }

    // -------------------------------------------------------------------------

    $table_data_for_dhtmlx = json_encode( $table_data_for_dhtmlx ) ;

//pr( $table_data_for_dhtmlx ) ;

    // =========================================================================
    // Create the HTML for the page to go in the IFRAME...
    // =========================================================================

    // -------------------------------------------------------------------------
    // NOTE!
    // =====
    // The WordPress front-end and back-end CSS and Javascript/jQuery both
    // interfere with the DHTMLX Grid (CSS and Javascript) (though the amount
    // of interference does depend on (eg); the fron-end theme and template
    // used, for example).
    //
    // To prevent this happening, we've little choice but to embed the DHTMLX
    // GRID in an IFRAME.
    // -------------------------------------------------------------------------

    $page_html = <<<EOT
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

    <head>
        <title>Manage "{$view_title}" View</title>
        <link rel="STYLESHEET" type="text/css" href="{$codebase_url}/dhtmlxgrid.css">
        <script type="text/javascript" src="{$codebase_url}/dhtmlxcommon.js"></script>
        <script type="text/javascript" src="{$codebase_url}/dhtmlxgrid.js"></script>
        <script type="text/javascript" src="{$codebase_url}/dhtmlxgridcell.js"></script>
    </head>

    <body>
<div    id="mygrid_container"
        ></div>

<script type="text/javascript">

    var mygrid;

    var mygrids_data = {$table_data_for_dhtmlx} ;

    {$dhtmlx_table_sorting_support_global}

    function doInitGrid(){

        mygrid = new dhtmlXGridObject('mygrid_container');

        mygrid.setImagePath("{$imgs_url}");

        mygrid.enableAutoWidth(true);
        mygrid.enableAutoHeight(true);

        mygrid.setHeader('{$column_titles}',null,{$header_styles});
        mygrid.setInitWidthsP('{$column_widthsP}');
        mygrid.setColAlign('{$column_halign}');
        mygrid.setColVAlign('{$column_valign}');

        mygrid.setSkin("light");

        {$dhtmlx_table_sorting_support_doInitGrid}

        mygrid.init();

        mygrid.parse( mygrids_data , 'jsarray' ) ;

    }

    doInitGrid() ;

</script>

{$support_javascript}

    </body>
</html>
EOT;

    // =========================================================================
    // SAVE the page in the BASEPRESS PAGE CACHE...
    // =========================================================================

    require_once( $caller_apps_includes_dir . '/wordpress-page-cache.php' ) ;

    // -------------------------------------------------------------------------
    // \greatKiwi_wordpressPageCache\set_page(
    //      $page_name                      ,
    //      $question_session_specific      ,
    //      $question_remote_ip_specific    ,
    //      $question_user_agent_specific   ,
    //      $question_page_key              ,
    //      $page_content
    //      )
    // - - - - - - - - - - - - - - - - - - -
    // SAVES the specified PHP/HTML (or whatever) "page_content" into the
    // page cache.
    //
    // NOTES!
    // ======
    // 1.   Cached pages are stored in the wordPress MySQL database.  This is to
    //      eliminate the file access/permission problems that would occur if we
    //      to store the cached pages as files on the disk.
    //
    // 2.   This routine auto-creates the page cache table, if that table
    //      doesn't yet exist.
    //
    // RETURNS
    //      On SUCCESS!
    //      - - - - - -
    //      $page_key STRING (= blank string if $question_page_key = FALSE)
    //
    //      On FAILURE!
    //      - - - - - -
    //      array( $error_message STRING )
    // -------------------------------------------------------------------------

    $fn =   <<<EOT
\\{$caller_app_slash_plugins_global_namespace}\\get_caller_app_slash_plugins_unique_name
EOT;

    $page_name = $fn() . '-great-kiwi-standard-dataset-manager' ;

    $question_session_specific    = TRUE ;
    $question_remote_ip_specific  = TRUE ;
    $question_user_agent_specific = TRUE ;
    $question_page_key            = TRUE ;

    // -------------------------------------------------------------------------

    $page_key = \greatKiwi_wordpressPageCache\set_page(
                    $page_name                      ,
                    $question_session_specific      ,
                    $question_remote_ip_specific    ,
                    $question_user_agent_specific   ,
                    $question_page_key              ,
                    $page_html
                    ) ;

    // -------------------------------------------------------------------------

    if ( is_array( $page_key ) ) {
        return $page_key[0] ;
    }

    // =========================================================================
    // SUCCESS!
    // =========================================================================

    return array(
                $page_name      ,
                $page_key
                ) ;

    // =========================================================================
    // That's that
    // =========================================================================

}

// =============================================================================
// That's that!
// =============================================================================

