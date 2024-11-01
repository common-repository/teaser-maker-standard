<?php

// *****************************************************************************
// DATASET-MANAGER / CHECK-AND-DEFAULT-VIEW-RECORDS-TABLE.PHP
// (C) 2013 Peter Newman. All Rights Reserved
// *****************************************************************************

    namespace greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager ;

// =============================================================================
// check_and_default_view_records_table()
// =============================================================================

function check_and_default_view_records_table(
    $dataset_manager_home_page_title        ,
    $caller_apps_includes_dir               ,
    $all_application_dataset_definitions    ,
    $all_application_view_definitions       ,
    $selected_views_definition              ,
    $view_title                             ,
    $view_slug                              ,
    $question_front_end
    ) {

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
    //                                  [method]    => data-table
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
    //                                  [method]    => data-table
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
    // VIEW_RECORDS_TABLE ?
    // =========================================================================

    if ( ! array_key_exists( 'view_records_table' , $selected_views_definition ) ) {

        return <<<EOT
PROBLEM: No "view_records_table"
For view:&nbsp; {$view_title}
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\check_and_default_view_records_table()
EOT;

    }

    // -------------------------------------------------------------------------

    if ( ! is_array( $selected_views_definition['view_records_table'] ) ) {

        return <<<EOT
PROBLEM: Bad "view_records_table" (not an array)
For view:&nbsp; {$view_title}
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\check_and_default_view_records_table()
EOT;

    }

    // -------------------------------------------------------------------------
    // Already Checked/Defaulted ?
    // -------------------------------------------------------------------------

//  if (    array_key_exists( 'checked_defaulted_ok' , $selected_views_definition['view_records_table'] )
//          &&
//          $selected_views_definition['view_records_table']['checked_defaulted_ok'] === TRUE
//      ) {
//      return TRUE ;
//  }

    // =========================================================================
    // INIT the OUTPUT "view_records_table"...
    // =========================================================================

    $view_records_table = $selected_views_definition['view_records_table'] ;

    // -------------------------------------------------------------------------

    unset( $view_records_table['checked_defaulted_ok'] ) ;

    // =========================================================================
    // COLUMN DEFS ?
    // =========================================================================

    if ( ! array_key_exists( 'column_defs' , $view_records_table ) ) {

        return <<<EOT
PROBLEM: No "view_records_table" + "column_defs"
For view:&nbsp; {$view_title}
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\check_and_default_view_records_table()
EOT;

    }

    // -------------------------------------------------------------------------

    if ( ! is_array( $view_records_table['column_defs'] ) ) {

        return <<<EOT
PROBLEM: Bad "view_records_table" + "column_defs" (not an array)
For view:&nbsp; {$view_title}
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\check_and_default_view_records_table()
EOT;

    }

    // -------------------------------------------------------------------------

    if ( count( $view_records_table['column_defs'] ) < 1 ) {

        return <<<EOT
PROBLEM: Bad "view_records_table" + "column_defs" (NO columns are defined)
For view:&nbsp; {$view_title}
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\check_and_default_view_records_table()
EOT;

    }

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $view_records_table['column_defs'] = array(
    //
    //         [0] => Array(
    //                      [base_slug]             => tree
    //                      [label]                 => Projects / Categories / URLs
    //                      [question_sortable]     =>
    //                      [raw_value_from]        => Array(
    //                          [method]    => data-table
    //                          [instance]  => tree
    //                          )
    //                      [display_treatments]    =>
    //                      )
    //
    //          [1] => Array(
    //                      [base_slug]             => add
    //                      [label]                 => Add
    //                      [question_sortable]     =>
    //                      [raw_value_from]        => Array(
    //                          [method]    => data-table
    //                          [instance]  => add
    //                          )
    //                      [display_treatments]    =>
    //                      )
    //
    //          [2] => Array(
    //                      [base_slug]             => actions
    //                      [label]                 => Action
    //                      [question_sortable]     =>
    //                      [raw_value_from]        => Array(
    //                          [method]    => data-table
    //                          [instance]  => actions
    //                          )
    //                      [display_treatments]    =>
    //                      )
    //
    //          )
    //
    // -------------------------------------------------------------------------

//pr( $view_records_table['column_defs'] ) ;

    // =========================================================================
    // CHECK/DEFAULT the individual COLUMN DEFS...
    // =========================================================================

    $total_widths_in_percent_so_far = 0 ;

    $number_columns_with_unspecified_width = 0 ;

    // -------------------------------------------------------------------------

    $allowed_haligns = array( 'left' , 'center' , 'right' ) ;
    $allowed_valigns = array( 'top' , 'middle' , 'bottom' ) ;

    // -------------------------------------------------------------------------

    foreach ( $view_records_table['column_defs'] as $this_index => $this_column_def ) {

        // ---------------------------------------------------------------------

        $column_number = $this_index + 1 ;

        // =====================================================================
        // BASE_SLUG ?
        // =====================================================================

        // ---------------------------------------------------------------------
        // If NOT specified, we try to default it from the "instance" in:-
        //
        //      'raw_value_from' =>  array(
        //                              'method'    =>  'data-table'    ,
        //                              'instance'  =>  "<field_name>"
        //                              )
        //
        // But if this ISN'T possible, it's a FATAL error.
        // ---------------------------------------------------------------------

        if (    ! array_key_exists( 'base_slug' , $this_column_def )
                ||
                $this_column_def['base_slug'] === NULL
            ) {

            // -----------------------------------------------------------------

            if (    array_key_exists( 'raw_value_from' , $this_column_def )
                    &&
                    is_array( $this_column_def['raw_value_from'] )
                    &&
                    array_key_exists( 'method' , $this_column_def['raw_value_from'] )
                    &&
                    in_array(
                        $this_column_def['raw_value_from']['method']    ,
                        array(  'data-table'
                                )   ,
                        TRUE
                        )
                    &&
                    array_key_exists( 'instance' , $this_column_def['raw_value_from'] )
                    &&
                    is_string( $this_column_def['raw_value_from']['instance'] )
                    &&
                    trim( $this_column_def['raw_value_from']['instance'] ) !== ''
                    &&
                    \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_stringUtils\ctype_varname( $this_column_def['raw_value_from']['instance'] )
                    &&
                    strlen( $this_column_def['raw_value_from']['instance'] ) <= 64
                ) {

                $view_records_table['column_defs'][ $this_index ]['base_slug'] =
                    $this_column_def['raw_value_from']['instance']
                    ;

            } else {

                return <<<EOT
PROBLEM: Bad "view_records_table" + "column_defs" - for column# {$column_number} (no "base_slug")
For view:&nbsp; {$view_title}
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\check_and_default_view_records_table()
EOT;

            }

            // -----------------------------------------------------------------

        } else {

            // -----------------------------------------------------------------

            if (    ! is_string( $this_column_def['base_slug'] )
                    ||
                    trim( $this_column_def['base_slug'] ) === ''
                    ||
                    ! \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_stringUtils\ctype_varname( $this_column_def['base_slug'] )
                    ||
                    strlen( $this_column_def['base_slug'] ) > 64
                ) {

                return <<<EOT
PROBLEM: Bad "view_records_table" + "column_defs" + "base_slug" - for column# {$column_number} (1 to 64 character variable name like string expected)
For view:&nbsp; {$view_title}
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\check_and_default_view_records_table()
EOT;

            }

            // -----------------------------------------------------------------

        }

        // =====================================================================
        // RAW_VALUE_FROM ? (MUST be specified)...
        // =====================================================================

        // ---------------------------------------------------------------------
        // Here we should have:-
        //
        //      $this_column_def['raw_value_from'] = array(
        //          'method'    =>  'data-table'                ,
        //          'instance'  =>  "<data table field name>"
        //          )
        //
        // But if:-
        //      $this_column_def['raw_value_from']
        //
        // ISN'T specified, we'll try to default it from:-
        //      $this_column_def['base_slug']
        //
        // Though if this ISN'T possible, it's a FATAL error.
        // ---------------------------------------------------------------------

        if (    ! array_key_exists( 'raw_value_from' , $this_column_def )
                ||
                $this_column_def['raw_value_from'] === NULL
            ) {

            // -----------------------------------------------------------------

            $view_records_table['column_defs'][ $this_index ]['raw_value_from'] = array(
                'method'    =>  'data-table'                                                    ,
                'instance'  =>  $view_records_table['column_defs'][ $this_index ]['base_slug']
                ) ;

            // -----------------------------------------------------------------

        } else {

            // -----------------------------------------------------------------

            if ( ! is_array( $this_column_def['raw_value_from'] ) ) {

                return <<<EOT
PROBLEM: Bad "view_records_table" + "column_defs" + "raw_value_from" - for column# {$column_number}) (array expected)
For view:&nbsp; {$view_title}
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\check_and_default_view_records_table()
EOT;

            }

            // -----------------------------------------------------------------

            if ( ! isset( $this_column_def['raw_value_from']['method'] ) ) {

                return <<<EOT
PROBLEM: Bad "view_records_table" + "column_defs" + "raw_value_from" - for column# {$column_number}) (no "method")
For view:&nbsp; {$view_title}
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\check_and_default_view_records_table()
EOT;

            }

            // -----------------------------------------------------------------

            if (    ! is_string( $this_column_def['raw_value_from']['method'] )
                    ||
                    trim( $this_column_def['raw_value_from']['method'] ) === ''
                    ||
                    ! \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_stringUtils\ctype_alphanumeric_underscore_dash( $this_column_def['raw_value_from']['method'] )
                    ||
                    strlen( $this_column_def['raw_value_from']['method'] ) > 64
                ) {

                return <<<EOT
PROBLEM: Bad "view_records_table" + "column_defs" + "raw_value_from" + "method" - for column# {$column_number} (1 to 64 character, alphanumeric underscore dash type string expected)
For view:&nbsp; {$view_title}
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\check_and_default_view_records_table()
EOT;

            }

            // -----------------------------------------------------------------

        }

        // =====================================================================
        // LABEL ?
        // =====================================================================

        // ---------------------------------------------------------------------
        // If NOT specified, defaults to:-
        //      to_title( 'base_slug' )
        //
        // NOTE!
        // =====
        // Empty string labels (= untitled columns) are ALLOWED.
        // =====================================================================

        if ( isset( $this_column_def['label'] ) ) {

            if ( ! is_string( $this_column_def['label'] ) ) {

                return <<<EOT
PROBLEM: Bad "view_records_table" + "column_defs" + "label" - for column# {$column_number} (possibly empty string expected)
For view:&nbsp; {$view_title}
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\check_and_default_view_records_table()
EOT;

            }

        } else {

            $view_records_table['column_defs'][ $this_index ]['label'] =
                to_title( $view_records_table['column_defs'][ $this_index ]['base_slug'] )
                ;

        }

        // =====================================================================
        // QUESTION_SORTABLE ?
        // =====================================================================

        if ( isset( $this_column_def['question_sortable'] ) ) {

            if ( ! is_bool( $this_column_def['question_sortable'] ) ) {

                return <<<EOT
PROBLEM: Bad "view_records_table" + "column_defs" + "question_sortable" - for column# {$column_number} (TRUE or FALSE expected)
For view:&nbsp; {$view_title}
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\check_and_default_view_records_table()
EOT;

            }

        } else {

            $view_records_table['column_defs'][ $this_index ]['question_sortable'] = FALSE ;

        }

        // =====================================================================
        // DISPLAY_TREATMENTS ?
        // =====================================================================

        if ( isset( $this_column_def['display_treatments'] ) ) {

            if ( ! is_array( $this_column_def['display_treatments'] ) ) {

                return <<<EOT
PROBLEM: Bad "view_records_table" + "column_defs" + "display_treatments" - for column# {$column_number} (array expected)
For view:&nbsp; {$view_title}
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\check_and_default_view_records_table()
EOT;

            }

        } else {

            $view_records_table['column_defs'][ $this_index ]['display_treatments'] = array() ;

        }

        // =====================================================================
        // SORT_TREATMENTS ?
        // =====================================================================

        if ( isset( $this_column_def['sort_treatments'] ) ) {

            if ( ! is_array( $this_column_def['sort_treatments'] ) ) {

                return <<<EOT
PROBLEM: Bad "view_records_table" + "column_defs" + "sort_treatments" - for column# {$column_number} (array expected)
For view:&nbsp; {$view_title}
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\check_and_default_view_records_table()
EOT;

            }

        } else {

            $view_records_table['column_defs'][ $this_index ]['sort_treatments'] = array() ;

        }

        // =====================================================================
        // DATA_FIELD_SLUG_TO_DISPLAY ?
        // =====================================================================

        if ( count( $view_records_table['column_defs'][ $this_index ]['display_treatments'] ) > 0 ) {

            $view_records_table['column_defs'][ $this_index ]['data_field_slug_to_display'] =
                $view_records_table['column_defs'][ $this_index ]['base_slug'] . '_display'
                ;

        } else {

            $view_records_table['column_defs'][ $this_index ]['data_field_slug_to_display'] =
                $view_records_table['column_defs'][ $this_index ]['base_slug']
                ;

        }

        // =====================================================================
        // DATA_FIELD_SLUG_TO_SORT_BY ?
        // =====================================================================

        if (    $view_records_table['column_defs'][ $this_index ]['question_sortable']
                &&
                count( $view_records_table['column_defs'][ $this_index ]['sort_treatments'] ) > 0
            ) {

            $view_records_table['column_defs'][ $this_index ]['data_field_slug_to_sort_by'] =
                $view_records_table['column_defs'][ $this_index ]['base_slug'] . '_sort'
                ;

        } else {

            $view_records_table['column_defs'][ $this_index ]['data_field_slug_to_sort_by'] =
                $view_records_table['column_defs'][ $this_index ]['base_slug']
                ;

        }

        // =====================================================================
        // HEADER_HALIGN ?
        // =====================================================================

        if ( isset( $this_column_def['header_halign'] ) ) {

            if ( ! in_array( $this_column_def['header_halign'] , $allowed_haligns , TRUE ) ) {

                return <<<EOT
PROBLEM: Bad "view_records_table" + "column_defs" ("header_halign" must be "left", "center", "right" - for ALL columns)
For view:&nbsp; {$view_title}
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\check_and_default_view_records_table()
EOT;

            }

        } else {

            $view_records_table['column_defs'][ $this_index ]['header_halign'] = 'center' ;

        }

        // =====================================================================
        // HEADER_VALIGN ?
        // =====================================================================

        if ( isset( $this_column_def['header_valign'] ) ) {

            if ( ! in_array( $this_column_def['header_valign'] , $allowed_valigns , TRUE ) ) {

                return <<<EOT
PROBLEM: Bad "view_records_table" + "column_defs" ("header_valign" must be "top", "middle", "bottom" - for ALL columns)
For view:&nbsp; {$view_title}
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\check_and_default_view_records_table()
EOT;

            }

        } else {

            $view_records_table['column_defs'][ $this_index ]['header_valign'] = 'middle' ;

        }

        // =====================================================================
        // DATA_HALIGN ?
        // =====================================================================

        if ( isset( $this_column_def['data_halign'] ) ) {

            if ( ! in_array( $this_column_def['data_halign'] , $allowed_haligns , TRUE ) ) {

                return <<<EOT
PROBLEM: Bad "view_records_table" + "column_defs" ("data_halign" must be "left", "center", "right" - for ALL columns)
For view:&nbsp; {$view_title}
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\check_and_default_view_records_table()
EOT;

            }

        } else {

            $view_records_table['column_defs'][ $this_index ]['data_halign'] = 'center' ;

        }

        // =====================================================================
        // DATA_VALIGN ?
        // =====================================================================

        if ( isset( $this_column_def['data_valign'] ) ) {

            if ( ! in_array( $this_column_def['data_valign'] , $allowed_valigns , TRUE ) ) {

                return <<<EOT
PROBLEM: Bad "view_records_table" + "column_defs" ("data_valign" must be "top", "middle", "bottom" - for ALL columns)
For view:&nbsp; {$view_title}
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\check_and_default_view_records_table()
EOT;

            }

        } else {

            $view_records_table['column_defs'][ $this_index ]['data_valign'] = 'middle' ;

        }

        // =====================================================================
        // WIDTH_IN_PERCENT ?
        // =====================================================================

        // ---------------------------------------------------------------------
        // 1 to 100 or 0/NULL/unspecified
        //
        // All columns must add up 100%.  Though some columns may be left
        // 0/NULL or unspecified - in which case the leftover width will be
        // evenly distributed amongst these columns.
        // ---------------------------------------------------------------------

        if ( isset( $this_column_def['width_in_percent'] ) ) {

            if ( $this_column_def['width_in_percent'] === NULL ) {

                $view_records_table['column_defs'][ $this_index ]['width_in_percent'] = 0 ;

                $number_columns_with_unspecified_width++ ;

            } elseif (  ! is_scalar( $this_column_def['width_in_percent'] )
                        ||
                        $this_column_def['width_in_percent'] > 100
                ) {

                return <<<EOT
PROBLEM: Bad "view_records_table" + "column_defs" ("width_in_percent" must be 1 to 100 or 0/NULL/unspecified - for ALL columns)
For view:&nbsp; {$view_title}
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\check_and_default_view_records_table()
EOT;

            }

        } else {

            $view_records_table['column_defs'][ $this_index ]['width_in_percent'] = 0 ;

            $number_columns_with_unspecified_width++ ;

        }

        // ---------------------------------------------------------------------

        $total_widths_in_percent_so_far +=
            $view_records_table['column_defs'][ $this_index ]['width_in_percent']
            ;

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // WIDTH_IN_PERCENT ?
    // =========================================================================

    if ( $total_widths_in_percent_so_far > 100 ) {

        return <<<EOT
PROBLEM: Bad "view_records_table" + "column_defs" (total "width_in_percent" must be no more than 100)
For view:&nbsp; {$view_title}
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\check_and_default_view_records_table()
EOT;

    }

    // -------------------------------------------------------------------------

    if ( $number_columns_with_unspecified_width > 0 ) {

        // ---------------------------------------------------------------------
        // min column width is 1%...
        // ---------------------------------------------------------------------

        $leftover_width_required = $number_columns_with_unspecified_width ;

        $leftover_width_available = 100 - $total_widths_in_percent_so_far ;

        // ---------------------------------------------------------------------

        if ( $leftover_width_required > $leftover_width_available ) {

            $leftover_width_available = round( $leftover_width_available , 1 ) ;

            return <<<EOT
PROBLEM: Bad "view_records_table" + "column_defs" (too little "width_in_percent" left ({$leftover_width_available}%), to distribute amongst the ({$number_columns_with_unspecified_width}) unspecified columns)
For view:&nbsp; {$view_title}
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\check_and_default_view_records_table()
EOT;

        }

        // ---------------------------------------------------------------------

        $leftover_width_per_column =
            $leftover_width_available / $number_columns_with_unspecified_width ;

        // ---------------------------------------------------------------------

        foreach ( $view_records_table['column_defs'] as $this_index => $this_column_def ) {

            if ( $this_column_def['width_in_percent'] == 0 ) {

                $view_records_table['column_defs'][ $this_index ]['width_in_percent'] =
                    $leftover_width_per_column
                    ;

                $total_widths_in_percent_so_far += $leftover_width_per_column ;

            }

        }

        // ---------------------------------------------------------------------

    }

    // -------------------------------------------------------------------------

    if (    $total_widths_in_percent_so_far < 98
            ||
            $total_widths_in_percent_so_far > 102
        ) {

        return <<<EOT
PROBLEM: Bad "view_records_table" + "column_defs" (total "width_in_percent" must be (approx.) 100)
For view:&nbsp; {$view_title}
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\check_and_default_view_records_table()
EOT;

    }

    // =========================================================================
    // GET_TABLE_DATA_FUNCTION_NAME ?
    // =========================================================================

    if ( ! isset( $view_records_table['get_table_data_function_name'] ) ) {

        return <<<EOT
PROBLEM: No "view_records_table" + "get_table_data_function_name"
For view:&nbsp; {$view_title}
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\check_and_default_view_records_table()
EOT;

    }

    // -------------------------------------------------------------------------

    if (    ! is_string( $view_records_table['get_table_data_function_name'] )
            ||
            trim( $view_records_table['get_table_data_function_name'] ) === ''
            ||
            strlen( $view_records_table['get_table_data_function_name'] ) > 255
        ) {

        return <<<EOT
PROBLEM: Bad "view_records_table" + "get_table_data_function_name" (1 to 255 character string expected)
For view:&nbsp; {$view_title}
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\check_and_default_view_records_table()
EOT;

    }

    // -------------------------------------------------------------------------

    if ( ! function_exists( $view_records_table['get_table_data_function_name'] ) ) {

        return <<<EOT
PROBLEM: Bad "view_records_table" + "get_table_data_function_name" (function not found)
For view:&nbsp; {$view_title}
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\check_and_default_view_records_table()
EOT;

    }

    // =========================================================================
    // TABLE_HEADER_BEFORE_IFRAME ?
    // =========================================================================

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $view_records_table['table_header_before_iframe'] = array(
    //          'method'    =>  'none'
    //          )
    //
    //      --OR--
    //
    //      $view_records_table['table_header_before_iframe'] = array(
    //          'method'    =>  'button-add-dataset-record'     ,
    //          'instance'  =>  'projects'
    //          )
    //
    // -------------------------------------------------------------------------

    if ( isset( $view_records_table['table_header_before_iframe'] ) ) {

        // ---------------------------------------------------------------------

        if ( ! is_array( $view_records_table['table_header_before_iframe'] ) ) {

            return <<<EOT
PROBLEM: Bad "view_records_table" + "table_header_before_iframe" (array expected)
For view:&nbsp; {$view_title}
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\check_and_default_view_records_table()
EOT;

        }

        // ---------------------------------------------------------------------

        if ( ! array_key_exists( 'method' , $view_records_table['table_header_before_iframe'] ) ) {

            return <<<EOT
PROBLEM: Bad "view_records_table" + "table_header_before_iframe" (no "method")
For view:&nbsp; {$view_title}
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\check_and_default_view_records_table()
EOT;

        }

        // ---------------------------------------------------------------------

        if (    ! is_string( $view_records_table['table_header_before_iframe']['method'] )
                ||
                trim( $view_records_table['table_header_before_iframe']['method'] ) === ''
                ||
                strlen( $view_records_table['table_header_before_iframe']['method'] ) > 64
                ||
                ! \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_stringUtils\ctype_alphanumeric_underscore_dash( $view_records_table['table_header_before_iframe']['method'] )
            ) {

            return <<<EOT
PROBLEM: Bad "view_records_table" + "table_header_before_iframe" + "method" (1 to 64 character "alphanumeric underscore dash" type string expected)
For view:&nbsp; {$view_title}
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\check_and_default_view_records_table()
EOT;

        }

        // ---------------------------------------------------------------------

    } else {

        // ---------------------------------------------------------------------

        $view_records_table['table_header_before_iframe'] = array(
            'method'    =>  'none'
            ) ;

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // TABLE_FOOTER_AFTER_IFRAME ?
    // =========================================================================

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $view_records_table['table_footer_after_iframe'] = array(
    //          'method'    =>  'none'
    //          )
    //
    //      --OR--
    //
    //      $view_records_table['table_footer_after_iframe'] = array(
    //          'method'    =>  'button-add-dataset-record'     ,
    //          'instance'  =>  'projects'
    //          )
    //
    // -------------------------------------------------------------------------

    if ( isset( $view_records_table['table_footer_after_iframe'] ) ) {

        // ---------------------------------------------------------------------

        if ( ! is_array( $view_records_table['table_footer_after_iframe'] ) ) {

            return <<<EOT
PROBLEM: Bad "view_records_table" + "table_footer_after_iframe" (array expected)
For view:&nbsp; {$view_title}
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\check_and_default_view_records_table()
EOT;

        }

        // ---------------------------------------------------------------------

        if ( ! array_key_exists( 'method' , $view_records_table['table_footer_after_iframe'] ) ) {

            return <<<EOT
PROBLEM: Bad "view_records_table" + "table_footer_after_iframe" (no "method")
For view:&nbsp; {$view_title}
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\check_and_default_view_records_table()
EOT;

        }

        // ---------------------------------------------------------------------

        if (    ! is_string( $view_records_table['table_footer_after_iframe']['method'] )
                ||
                trim( $view_records_table['table_footer_after_iframe']['method'] ) === ''
                ||
                strlen( $view_records_table['table_footer_after_iframe']['method'] ) > 64
                ||
                ! \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_stringUtils\ctype_alphanumeric_underscore_dash( $view_records_table['table_footer_after_iframe']['method'] )
            ) {

            return <<<EOT
PROBLEM: Bad "view_records_table" + "table_footer_after_iframe" + "method" (1 to 64 character "alphanumeric underscore dash" type string expected)
For view:&nbsp; {$view_title}
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\check_and_default_view_records_table()
EOT;

        }

        // ---------------------------------------------------------------------

    } else {

        // ---------------------------------------------------------------------

        $view_records_table['table_footer_after_iframe'] = array(
            'method'    =>  'none'
            ) ;

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // TABLE_HEADER_IN_IFRAME ?
    // =========================================================================

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $view_records_table['table_header_in_iframe'] = array(
    //          'method'    =>  'none'
    //          )
    //
    //      --OR--
    //
    //      $view_records_table['table_header_in_iframe'] = array(
    //          'method'    =>  'button-add-dataset-record'     ,
    //          'instance'  =>  'projects'
    //          )
    //
    // -------------------------------------------------------------------------

    if ( isset( $view_records_table['table_header_in_iframe'] ) ) {

        // ---------------------------------------------------------------------

        if ( ! is_array( $view_records_table['table_header_in_iframe'] ) ) {

            return <<<EOT
PROBLEM: Bad "view_records_table" + "table_header_in_iframe" (array expected)
For view:&nbsp; {$view_title}
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\check_and_default_view_records_table()
EOT;

        }

        // ---------------------------------------------------------------------

        if ( ! array_key_exists( 'method' , $view_records_table['table_header_in_iframe'] ) ) {

            return <<<EOT
PROBLEM: Bad "view_records_table" + "table_header_in_iframe" (no "method")
For view:&nbsp; {$view_title}
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\check_and_default_view_records_table()
EOT;

        }

        // ---------------------------------------------------------------------

        if (    ! is_string( $view_records_table['table_header_in_iframe']['method'] )
                ||
                trim( $view_records_table['table_header_in_iframe']['method'] ) === ''
                ||
                strlen( $view_records_table['table_header_in_iframe']['method'] ) > 64
                ||
                ! \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_stringUtils\ctype_alphanumeric_underscore_dash( $view_records_table['table_header_in_iframe']['method'] )
            ) {

            return <<<EOT
PROBLEM: Bad "view_records_table" + "table_header_in_iframe" + "method" (1 to 64 character "alphanumeric underscore dash" type string expected)
For view:&nbsp; {$view_title}
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\check_and_default_view_records_table()
EOT;

        }

        // ---------------------------------------------------------------------

    } else {

        // ---------------------------------------------------------------------

        $view_records_table['table_header_in_iframe'] = array(
            'method'    =>  'none'
            ) ;

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // TABLE_FOOTER_IN_IFRAME ?
    // =========================================================================

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $view_records_table['table_footer_in_iframe'] = array(
    //          'method'    =>  'none'
    //          )
    //
    //      --OR--
    //
    //      $view_records_table['table_footer_in_iframe'] = array(
    //          'method'    =>  'button-add-dataset-record'     ,
    //          'instance'  =>  'projects'
    //          )
    //
    // -------------------------------------------------------------------------

    if ( isset( $view_records_table['table_footer_in_iframe'] ) ) {

        // ---------------------------------------------------------------------

        if ( ! is_array( $view_records_table['table_footer_in_iframe'] ) ) {

            return <<<EOT
PROBLEM: Bad "view_records_table" + "table_footer_in_iframe" (array expected)
For view:&nbsp; {$view_title}
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\check_and_default_view_records_table()
EOT;

        }

        // ---------------------------------------------------------------------

        if ( ! array_key_exists( 'method' , $view_records_table['table_footer_in_iframe'] ) ) {

            return <<<EOT
PROBLEM: Bad "view_records_table" + "table_footer_in_iframe" (no "method")
For view:&nbsp; {$view_title}
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\check_and_default_view_records_table()
EOT;

        }

        // ---------------------------------------------------------------------

        if (    ! is_string( $view_records_table['table_footer_in_iframe']['method'] )
                ||
                trim( $view_records_table['table_footer_in_iframe']['method'] ) === ''
                ||
                strlen( $view_records_table['table_footer_in_iframe']['method'] ) > 64
                ||
                ! \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_stringUtils\ctype_alphanumeric_underscore_dash( $view_records_table['table_footer_in_iframe']['method'] )
            ) {

            return <<<EOT
PROBLEM: Bad "view_records_table" + "table_footer_in_iframe" + "method" (1 to 64 character "alphanumeric underscore dash" type string expected)
For view:&nbsp; {$view_title}
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\check_and_default_view_records_table()
EOT;

        }

        // ---------------------------------------------------------------------

    } else {

        // ---------------------------------------------------------------------

        $view_records_table['table_footer_in_iframe'] = array(
            'method'    =>  'none'
            ) ;

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // ROWS_PER_PAGE ?
    // =========================================================================

    if ( isset( $view_records_table['rows_per_page'] ) ) {

        // ---------------------------------------------------------------------

        if (    ! is_numeric( $view_records_table['rows_per_page'] )
                ||
                trim( $view_records_table['rows_per_page'] ) === ''
                ||
                ! ctype_digit( (string) $view_records_table['rows_per_page'] )
            ) {

            return <<<EOT
PROBLEM: Bad "view_records_table" + "rows_per_page" (number 0+ expected)
For view:&nbsp; {$view_title}
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\check_and_default_view_records_table()
EOT;

        }

        // ---------------------------------------------------------------------

    } else {

        // ---------------------------------------------------------------------

        $view_records_table['rows_per_page'] = 10 ;

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // DEFAULT_DATA_FIELD_SLUG_TO_ORDERBY ?
    // =========================================================================

    if ( ! isset( $view_records_table['default_data_field_slug_to_orderby'] ) ) {

        // ---------------------------------------------------------------------
        // default_data_field_slug_to_orderby
        //      =>  'xxx' || ''/NULL (means orderby FIRST available data field)
        // ---------------------------------------------------------------------

        foreach ( $view_records_table['column_defs'] as $this_index => $this_column_def ) {

            if ( $this_column_def['question_sortable'] ) {

                $view_records_table['default_data_field_slug_to_orderby'] =
                    $this_column_def['data_field_slug_to_sort_by']
                    ;

                break ;

            }

        }

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // DEFAULT_ORDER ?
    // =========================================================================

    if ( ! isset( $view_records_table['default_order'] ) ) {

        // ---------------------------------------------------------------------
        // default_order
        //      =>  'asc' OR 'desc' OR ''/NULL (means default to "asc")
        // ---------------------------------------------------------------------

        $view_records_table['default_order'] = 'asc' ;

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // ACTION_SEPARATOR ?
    // =========================================================================

    if ( ! isset( $view_records_table['action_separator'] ) ) {

        // ---------------------------------------------------------------------
        // action_separator
        //      =>  ' &nbsp;&nbsp; '
        // ---------------------------------------------------------------------

        $view_records_table['action_separator'] = ' &nbsp;&nbsp; ' ;

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // SUCCESS!
    // =========================================================================

//  $view_records_table['checked_defaulted_ok'] = TRUE ;

    // -------------------------------------------------------------------------

    return $view_records_table ;

    // =========================================================================
    // That's that!
    // =========================================================================

}

// =============================================================================
// That's that!
// =============================================================================

