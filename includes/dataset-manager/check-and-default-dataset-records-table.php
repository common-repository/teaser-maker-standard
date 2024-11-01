<?php

// *****************************************************************************
// DATASET-MANAGER / CHECK-AND-DEFAULT-DATASET-RECORDS-TABLE.PHP
// (C) 2013 Peter Newman. All Rights Reserved
// *****************************************************************************

    namespace greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager ;

// =============================================================================
// check_and_default_dataset_records_table()
// =============================================================================

function check_and_default_dataset_records_table(
    $dataset_manager_home_page_title        ,
    $caller_apps_includes_dir               ,
    $all_application_dataset_definitions    ,
    $selected_datasets_dmdd                 ,
    $dataset_records                        ,
    $dataset_title                          ,
    $dataset_slug                           ,
    $question_front_end
    ) {

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

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $selected_datasets_dmdd = array(
    //          'dataset_slug'                      =>  'projects'      ,
    //          'dataset_name_singular'             =>  'project'       ,
    //          'dataset_name_plural'               =>  'projects'      ,
    //          'dataset_title_singular'            =>  'Project'       ,
    //          'dataset_title_plural'              =>  'Projects'      ,
    //          'basepress_dataset_handle'          =>  array(...)      ,
    //          'dataset_records_table'             =>  array(...)      ,
    //          'zebra_form'                        =>  array(...)      ,
    //          'array_storage_record_structure'    =>  array(...)      ,
    //          'array_storage_key_field_slug'      =>  'key'
    //          )
    //
    // Where $selected_datasets_dmdd['dataset_records_table'] is like (eg):-
    //
    //      $selected_datasets_dmdd['dataset_records_table'] = array(
    //
    //          'column_defs'   =>  array(
    //
    //      //      array(
    //      //          'base_slug'                     =>  'xxx'
    //      //          'label'                         =>  'Xxx' OR ''/NULL (means use "to_title( <base slug> )"
    //      //          'question_sortable'             =>  TRUE OR FALSE/NULL
    //      //          'raw_value_from'                =>  array(
    //      //                                                  'method'    =>  'array-storage-field-slug'      ,
    //      //                                                  'instance'  =>  "xxx"
    //      //                                                  )   ,
    //      //                                              --OR--
    //      //                                              array(
    //      //                                                  'method'    =>  'special-type'                  ,
    //      //                                                  'instance'  =>  "action"
    //      //                                                  )   ,
    //      //                                              --OR--
    //      //                                              array(
    //      //                                                  'method'    =>  'foreign-field'                 ,
    //      //                                                  'instance'  =>  "<target-field-name>"
    //      //                                                  'args'      =>  array(
    //      //                                                                      array(
    //      //                                                                          'pointer_field_array_storage_slug'  =>  '<pointer_field_slug>'  ,
    //      //                                                                          'foreign_dataset'                   =>  '<dataset_slug>'
    //      //                                                                          )   ,
    //      //                                                                      ...
    //      //                                                                      )
    //      //                                                  )   ,
    //      //
    //      //          'width_in_percent'              =>  1 to 100 (All columns must add up 100%.  Though
    //      //                                              some columns may be left 0/NULL or unspecified -
    //      //                                              in which case the leftover width will be evenly
    //      //                                              distributed amongst these columns.
    //      //          'header_halign'                 =>  'left' | 'center' | 'right'
    //      //          'header_valign'                 =>  'top' | 'middle' | 'bottom'
    //      //          'data_halign'                   =>  'left' | 'center' | 'right'
    //      //          'data_valign'                   =>  'top' | 'middle' | 'bottom'
    //      //
    //      //          'data_field_slug_to_display'    =>  "xxx" (generated automatically; DON'T specify)
    //      //          'data_field_slug_to_sort_by'    =>  "xxx" (generated automatically; DON'T specify)
    //      //          )   ,
    //
    //              array(
    //                  'base_slug'                     =>  'title'             ,
    //                  'label'                         =>  'Project Title'     ,
    //                  'question_sortable'             =>  TRUE                ,
    //                  'raw_value_from'                =>  array(
    //                                                          'method'    =>  'array-storage-field-slug'  ,
    //                                                          'instance'  =>  'title'
    //                                                          )   ,
    //                  'display_treatments'            =>  NULL    ,
    //                  'sort_treatments'               =>  NULL
    //                  )   ,
    //
    //              array(
    //                  'base_slug'                     =>  'action'            ,
    //                  'label'                         =>  'Action'            ,
    //                  'question_sortable'             =>  FALSE               ,
    //                  'raw_value_from'                =>  array(
    //                                                          'method'    =>  'special-type'  ,
    //                                                          'instance'  =>  'action'
    //                                                          )   ,
    //                  'display_treatments'            =>  NULL    ,
    //                  'sort_treatments'               =>  NULL
    //                  )
    //
    //              )   ,
    //
    //          [rows_per_page]                      => 10
    //          [default_data_field_slug_to_orderby] => title
    //          [default_order]                      => asc
    //          [actions]                            => Array(
    //                                                      [edit]   => edit
    //                                                      [delete] => delete
    //                                                      )
    //          [action_separator] =>
    //
    //          )
    //
    // -------------------------------------------------------------------------

    // =========================================================================
    // Init.
    // =========================================================================

    $ns = __NAMESPACE__ ;
    $fn = __FUNCTION__ ;

    // =========================================================================
    // INIT the OUTPUT table...
    // =========================================================================

    if ( array_key_exists( 'dataset_records_table' , $selected_datasets_dmdd ) ) {

        // ---------------------------------------------------------------------
        // Is Array ?
        // ---------------------------------------------------------------------

        if ( ! is_array( $selected_datasets_dmdd['dataset_records_table'] ) ) {

            return <<<EOT
PROBLEM: Bad "dataset_records_table" (not an array)
For dataset:&nbsp; {$dataset_title}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        }

        // ---------------------------------------------------------------------
        // Already Checked/Defaulted ?
        // ---------------------------------------------------------------------

        if (    array_key_exists( 'checked_defaulted_ok' , $selected_datasets_dmdd['dataset_records_table'] )
                &&
                $selected_datasets_dmdd['dataset_records_table']['checked_defaulted_ok'] === TRUE
            ) {
            return TRUE ;
        }

        // ---------------------------------------------------------------------
        // OUTPUT Dataset Records Table = INPUT Dataset Records Table
        // ---------------------------------------------------------------------

        $dataset_records_table = $selected_datasets_dmdd['dataset_records_table'] ;

        unset( $dataset_records_table['checked_defaulted_ok'] ) ;

        // ---------------------------------------------------------------------

    } else {

        // ---------------------------------------------------------------------
        // OUTPUT Dataset Records Table = Empty Array
        //
        // (Which we'll fill from the "Dataset Records" - if there are any.)
        // ---------------------------------------------------------------------

        $dataset_records_table = array() ;

        // ---------------------------------------------------------------------

    }

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $dataset_title ) ;

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $dataset_records_table ) ;

    // =========================================================================
    // Check/default the COLUMN DEFS...
    // =========================================================================

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $dataset_records_table['column_defs'] = array(
    //
    //      //  array(
    //      //      'base_slug'                     =>  'xxx'
    //      //      'label'                         =>  'Xxx' OR ''/NULL (means use "to_title( <base slug> )"
    //      //      'question_sortable'             =>  TRUE OR FALSE/NULL
    //      //      'raw_value_from'                =>  array(
    //      //                                              'method'    =>  'array-storage-field-slug'      ,
    //      //                                              'instance'  =>  "xxx"
    //      //                                              )   ,
    //      //                                          --OR--
    //      //                                          array(
    //      //                                              'method'    =>  'special-type'                  ,
    //      //                                              'instance'  =>  "action"
    //      //                                              )   ,
    //      //                                          --OR--
    //      //                                          array(
    //      //                                              'method'    =>  'foreign-field'                 ,
    //      //                                              'instance'  =>  "<target-field-name>"
    //      //                                              'args'      =>  array(
    //      //                                                                  array(
    //      //                                                                      'pointer_field_array_storage_slug'  =>  '<pointer_field_slug>'  ,
    //      //                                                                      'foreign_dataset'                   =>  '<dataset_slug>'
    //      //                                                                      )   ,
    //      //                                                                  ...
    //      //                                                                  )
    //      //                                              )   ,
    //      //
    //      //      'width_in_percent'              =>  1 to 100 (All columns must add up 100%.  Though
    //      //                                          some columns may be left 0/NULL or unspecified -
    //      //                                          in which case the leftover width will be evenly
    //      //                                          distributed amongst these columns.
    //      //      'header_halign'                 =>  'left' | 'center' | 'right'
    //      //      'header_valign'                 =>  'top' | 'middle' | 'bottom'
    //      //      'data_halign'                   =>  'left' | 'center' | 'right'
    //      //      'data_valign'                   =>  'top' | 'middle' | 'bottom'
    //      //
    //      //      'data_field_slug_to_display'    =>  "xxx" (generated automatically; DON'T specify)
    //      //      'data_field_slug_to_sort_by'    =>  "xxx" (generated automatically; DON'T specify)
    //      //      )   ,
    //
    //          array(
    //              'base_slug'                     =>  'title'             ,
    //              'label'                         =>  'Project Title'     ,
    //              'question_sortable'             =>  TRUE                ,
    //              'raw_value_from'                =>  array(
    //                                                      'method'    =>  'array-storage-field-slug'  ,
    //                                                      'instance'  =>  'title'
    //                                                      )   ,
    //              'display_treatments'            =>  NULL    ,
    //              'sort_treatments'               =>  NULL
    //              )   ,
    //
    //          array(
    //              'base_slug'                     =>  'action'            ,
    //              'label'                         =>  'Action'            ,
    //              'question_sortable'             =>  FALSE               ,
    //              'raw_value_from'                =>  array(
    //                                                      'method'    =>  'special-type'  ,
    //                                                      'instance'  =>  'action'
    //                                                      )   ,
    //              'display_treatments'            =>  NULL    ,
    //              'sort_treatments'               =>  NULL
    //              )
    //
    //          )
    //
    // -------------------------------------------------------------------------

    if ( array_key_exists( 'column_defs' , $dataset_records_table ) ) {

        // ---------------------------------------------------------------------

        if ( ! is_array( $dataset_records_table['column_defs'] ) ) {

            return <<<EOT
PROBLEM: Bad "dataset_records_table" + "column_defs" (not an array)
For dataset:&nbsp; {$dataset_title}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        }

        // ---------------------------------------------------------------------

    } elseif (  $dataset_records_table['column_defs'] === NULL
                ||
                $dataset_records_table['column_defs'] === TRUE
                ||
                $dataset_records_table['column_defs'] === FALSE
        ) {

        // ---------------------------------------------------------------------

        $dataset_records_table['column_defs'] === array() ;

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // "RAW MODE" ?
    // =========================================================================

    if (    function_exists( '\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\is_raw_mode_for_tables' )
            &&
            \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\is_raw_mode_for_tables() === TRUE
        ) {

        // -----------------------------------------------------------------

        $dataset_records_table['column_defs'] = array() ;

        // -----------------------------------------------------------------

    }

    // =========================================================================
    // AUTO-CREATE the COLUMN DEFS (from the ARRAY STORAGE records)?
    // =========================================================================

    if ( array_key_exists( 'auto_create_column_defs' , $dataset_records_table ) ) {

        // ---------------------------------------------------------------------

        if (    ! function_exists( '\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\is_raw_mode_for_tables' )
                ||
                \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\is_raw_mode_for_tables() !== TRUE
            ) {

            // -------------------------------------------------------------------------
            // auto_create_column_defs(
            //      $selected_datasets_dmdd             ,
            //      $dataset_records_table_definition   ,
            //      $dataset_title
            //      )
            // - - - - - - - - - - - - - - - - - - - - -
            // Auto-creates the Dataset Records Table Columns from the Array Storage
            // Record definition.
            //
            // RETURNS
            //      o   On SUCCESS!
            //              $updated_column_defs ARRAY
            //
            //      o   On FAILURE!
            //              $error_message STRING
            // -------------------------------------------------------------------------

            $updated_column_defs = auto_create_column_defs(
                                        $selected_datasets_dmdd     ,
                                        $dataset_records_table      ,
                                        $dataset_title
                                        ) ;

            // -----------------------------------------------------------------

            if ( is_string( $updated_column_defs ) ) {
                return $updated_column_defs ;
            }

            // -----------------------------------------------------------------

            $dataset_records_table['column_defs'] = $updated_column_defs ;

            // -----------------------------------------------------------------

        }

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // AUTO-CREATE the COLUMN DEFS (from the DATASET records)?
    // =========================================================================

    if ( count( $dataset_records_table['column_defs'] ) < 1 ) {

        // ---------------------------------------------------------------------
        // DEFAULT the DATA FIELD DEFINITIONS from the DATASET RECORDS...
        // ---------------------------------------------------------------------

        if ( count( $dataset_records ) < 1 ) {

            return <<<EOT
PROBLEM defaulting the "dataset_records_table" from the dataset's records (there are NO dataset records to default the table columns from)
For dataset:&nbsp; {$dataset_title}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        }

        // ---------------------------------------------------------------------

        if ( ! is_array( $dataset_records[0] ) ) {

            return <<<EOT
PROBLEM defaulting the "dataset_records_table" from the dataset's records (the dataset records are invalid - the first record is NOT an array)
For dataset:&nbsp; {$dataset_title}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        }

        // ---------------------------------------------------------------------

        if ( count( $dataset_records[0] ) < 1 ) {

            return <<<EOT
PROBLEM defaulting the "dataset_records_table" from the dataset's records (the first dataset record has NO fields)
For dataset:&nbsp; {$dataset_title}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        }

        // ---------------------------------------------------------------------
        // Generate the table data from the FIRST DATASET RECORD...
        //
        // TODO ???
        //
        //  o   Generate from just the fields common to all records ?
        //
        //  o   Generate from every field found in all records ?
        // ---------------------------------------------------------------------

        $dataset_records_table['column_defs'] = array() ;

        // ---------------------------------------------------------------------

        foreach ( $dataset_records[0] as $name => $value ) {

            // -----------------------------------------------------------------

            $dataset_records_table['column_defs'][] = array(
                'base_slug'                     =>  $name                                                                                   ,
                'label'                         =>  \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_stringUtils\to_title( $name )   ,
                'question_sortable'             =>  TRUE                                                                                    ,
                'raw_value_from'                =>  array(
                                                        'method'    =>  'array-storage-field-slug'  ,
                                                        'instance'  =>  $name
                                                        )   ,
                'display_treatments'            =>  NULL    ,
                'sort_treatments'               =>  NULL
                ) ;

            // -----------------------------------------------------------------

        }

        // ---------------------------------------------------------------------
        // Add the DEFAULT ACTIONS COLUMN...
        // ---------------------------------------------------------------------

        $dataset_records_table['column_defs'][] = array(
            'base_slug'             =>  'action'    ,
            'label'                 =>  'Action'    ,
            'question_sortable'     =>  FALSE       ,
            'raw_value_from'        =>  array(
                                            'method'    =>  'special-type'      ,
                                            'instance'  =>  'record-action'
                                            )   ,
            'display_treatments'    =>  NULL    ,
            'sort_treatments'       =>  NULL
            ) ;

        // ---------------------------------------------------------------------

    }

//pr( $dataset_records_table['column_defs'] ) ;

    // =========================================================================
    // Finish checking and defaulting the COLUMN DEFS...
    // =========================================================================

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $dataset_records_table['column_defs'] = array(
    //
    //      //  array(
    //      //      'base_slug'                     =>  'xxx'
    //      //      'label'                         =>  'Xxx' OR ''/NULL (means use "to_title( <base slug> )"
    //      //      'question_sortable'             =>  TRUE OR FALSE/NULL
    //      //      'raw_value_from'                =>  array(
    //      //                                              'method'    =>  'array-storage-field-slug'      ,
    //      //                                              'instance'  =>  "xxx"
    //      //                                              )   ,
    //      //                                          --OR--
    //      //                                          array(
    //      //                                              'method'    =>  'special-type'                  ,
    //      //                                              'instance'  =>  "action"
    //      //                                              )   ,
    //      //                                          --OR--
    //      //                                          array(
    //      //                                              'method'    =>  'foreign-field'                 ,
    //      //                                              'instance'  =>  "<target-field-name>"
    //      //                                              'args'      =>  array(
    //      //                                                                  array(
    //      //                                                                      'pointer_field_array_storage_slug'  =>  '<pointer_field_slug>'  ,
    //      //                                                                      'foreign_dataset'                   =>  '<dataset_slug>'
    //      //                                                                      )   ,
    //      //                                                                  ...
    //      //                                                                  )
    //      //                                              )   ,
    //      //
    //      //      'display_treatments'            =>  NULL    ,
    //      //      'sort_treatments'               =>  NULL    ,
    //      //
    //      //      'width_in_percent'              =>  1 to 100 (All columns must add up 100%.  Though
    //      //                                          some columns may be left 0/NULL or unspecified -
    //      //                                          in which case the leftover width will be evenly
    //      //                                          distributed amongst these columns.
    //      //      'header_halign'                 =>  'left' | 'center' | 'right'
    //      //      'header_valign'                 =>  'top' | 'middle' | 'bottom'
    //      //      'data_halign'                   =>  'left' | 'center' | 'right'
    //      //      'data_valign'                   =>  'top' | 'middle' | 'bottom'
    //      //
    //      //      'data_field_slug_to_display'    =>  "xxx" (generated automatically; DON'T specify)
    //      //      'data_field_slug_to_sort_by'    =>  "xxx" (generated automatically; DON'T specify)
    //      //      )   ,
    //
    //          array(
    //              'base_slug'                     =>  'title'             ,
    //              'label'                         =>  'Project Title'     ,
    //              'question_sortable'             =>  TRUE                ,
    //              'raw_value_from'                =>  array(
    //                                                      'method'    =>  'array-storage-field-slug'  ,
    //                                                      'instance'  =>  'title'
    //                                                      )   ,
    //              'display_treatments'            =>  NULL    ,
    //              'sort_treatments'               =>  NULL
    //              )   ,
    //
    //          array(
    //              'base_slug'                     =>  'action'            ,
    //              'label'                         =>  'Action'            ,
    //              'question_sortable'             =>  FALSE               ,
    //              'raw_value_from'                =>  array(
    //                                                      'method'    =>  'special-type'  ,
    //                                                      'instance'  =>  'action'
    //                                                      )   ,
    //              'display_treatments'            =>  NULL    ,
    //              'sort_treatments'               =>  NULL
    //              )
    //
    //          )
    //
    // -------------------------------------------------------------------------

    $total_widths_in_percent_so_far = 0 ;

    $number_columns_with_unspecified_width = 0 ;

    // -------------------------------------------------------------------------

    $allowed_haligns = array( 'left' , 'center' , 'right' ) ;
    $allowed_valigns = array( 'top' , 'middle' , 'bottom' ) ;

    // -------------------------------------------------------------------------

    foreach ( $dataset_records_table['column_defs'] as $this_index => $this_column_def ) {

        // ---------------------------------------------------------------------

        $column_number = $this_index + 1 ;

        // =====================================================================
        // BASE_SLUG ?
        // =====================================================================

        // ---------------------------------------------------------------------
        // If NOT specified, we try to default it from the "instance" in:-
        //
        //      'raw_value_from' =>  array(
        //                              'method'    =>  'array-storage-field-slug'      ,
        //                              'instance'  =>  "xxx"
        //                              )   ,
        //                          --OR--
        //                          array(
        //                              'method'    =>  'special-type'          ,
        //                              'instance'  =>  "action"
        //                              )   ,
        //                          --OR--
        //                          array(
        //                              'method'    =>  'foreign-field'         ,
        //                              'instance'  =>  "<target-field-name>"
        //                              )
        //
        // But if this ISN'T possible, it's a FATAL error.
        // =====================================================================

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
                        array(  'array-storage-field-slug'      ,
                                'special-type'                  ,
                                'foreign-field'
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

                $dataset_records_table['column_defs'][ $this_index ]['base_slug'] =
                    $this_column_def['raw_value_from']['instance']
                    ;

            } else {

                return <<<EOT
PROBLEM: Bad "dataset_records_table" + "column_defs" - for column# {$column_number} (no "base_slug")
For dataset:&nbsp; {$dataset_title}
Detected in:&nbsp; \\{$ns}\\{$fn}()
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
PROBLEM: Bad "dataset_records_table" + "column_defs" + "base_slug" - for column# {$column_number} (1 to 64 character, variable name like string expected)
For dataset:&nbsp; {$dataset_title}
Detected in:&nbsp; \\{$ns}\\{$fn}()
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
        //          'method'    =>  'array-storage-field-slug'      ,
        //          'instance'  =>  "xxx"
        //          )
        //
        //      --OR--
        //
        //      $this_column_def['raw_value_from'] = array(
        //          'method'    =>  'special-type'                  ,
        //          'instance'  =>  "action"
        //          )
        //
        //      --OR--
        //
        //      $this_column_def['raw_value_from'] = array(
        //          'method'    =>  'foreign-field'                 ,
        //          'instance'  =>  "<target-field-name>"
        //          'args'      =>  array(
        //                              array(
        //                                  'pointer_field_array_storage_slug'  =>  '<pointer_field_slug>'  ,
        //                                  'foreign_dataset'                   =>  '<dataset_slug>'
        //                                  )   ,
        //                              ...
        //                              )
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

            $dataset_records_table['column_defs'][ $this_index ]['raw_value_from'] = array(
                'method'    =>  'array-storage-field-slug'                                          ,
                'instance'  =>  $dataset_records_table['column_defs'][ $this_index ]['base_slug']
                ) ;

            // -----------------------------------------------------------------

        } else {

            // -----------------------------------------------------------------

            if ( ! is_array( $this_column_def['raw_value_from'] ) ) {

                return <<<EOT
PROBLEM: Bad "dataset_records_table" + "column_defs" + "raw_value_from" - for column# {$column_number}) (array expected)
For dataset:&nbsp; {$dataset_title}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

            }

            // -----------------------------------------------------------------

            if ( ! isset( $this_column_def['raw_value_from']['method'] ) ) {

                return <<<EOT
PROBLEM: Bad "dataset_records_table" + "column_defs" + "raw_value_from" - for column# {$column_number}) (no "method")
For dataset:&nbsp; {$dataset_title}
Detected in:&nbsp; \\{$ns}\\{$fn}()
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
PROBLEM: Bad "dataset_records_table" + "column_defs" + "raw_value_from" + "method" - for column# {$column_number} (1 to 64 character, alphanumeric underscore dash type string expected)
For dataset:&nbsp; {$dataset_title}
Detected in:&nbsp; \\{$ns}\\{$fn}()
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
PROBLEM: Bad "dataset_records_table" + "column_defs" + "label" - for column# {$column_number} (possibly empty string expected)
For dataset:&nbsp; {$dataset_title}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

            }

        } else {

            $dataset_records_table['column_defs'][ $this_index ]['label'] =
                \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_stringUtils\to_title(
                    $dataset_records_table['column_defs'][ $this_index ]['base_slug']
                    ) ;

        }

        // =====================================================================
        // QUESTION_SORTABLE ?
        // =====================================================================

        if ( isset( $this_column_def['question_sortable'] ) ) {

            if ( ! is_bool( $this_column_def['question_sortable'] ) ) {

                return <<<EOT
PROBLEM: Bad "dataset_records_table" + "column_defs" + "question_sortable" - for column# {$column_number} (TRUE or FALSE expected)
For dataset:&nbsp; {$dataset_title}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

            }

        } else {

            $dataset_records_table['column_defs'][ $this_index ]['question_sortable'] = FALSE ;

        }

        // =====================================================================
        // DISPLAY_TREATMENTS ?
        // =====================================================================

        if ( isset( $this_column_def['display_treatments'] ) ) {

            if ( ! is_array( $this_column_def['display_treatments'] ) ) {

                return <<<EOT
PROBLEM: Bad "dataset_records_table" + "column_defs" + "display_treatments" - for column# {$column_number} (array expected)
For dataset:&nbsp; {$dataset_title}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

            }

        } else {

            $dataset_records_table['column_defs'][ $this_index ]['display_treatments'] = array() ;

        }

        // =====================================================================
        // SORT_TREATMENTS ?
        // =====================================================================

        if ( isset( $this_column_def['sort_treatments'] ) ) {

            if ( ! is_array( $this_column_def['sort_treatments'] ) ) {

                return <<<EOT
PROBLEM: Bad "dataset_records_table" + "column_defs" + "sort_treatments" - for column# {$column_number} (array expected)
For dataset:&nbsp; {$dataset_title}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

            }

        } else {

            $dataset_records_table['column_defs'][ $this_index ]['sort_treatments'] = array() ;

        }

        // =====================================================================
        // DATA_FIELD_SLUG_TO_DISPLAY ?
        // =====================================================================

        if ( count( $dataset_records_table['column_defs'][ $this_index ]['display_treatments'] ) > 0 ) {

            $dataset_records_table['column_defs'][ $this_index ]['data_field_slug_to_display'] =
                $dataset_records_table['column_defs'][ $this_index ]['base_slug'] . '_display'
                ;

        } else {

            $dataset_records_table['column_defs'][ $this_index ]['data_field_slug_to_display'] =
                $dataset_records_table['column_defs'][ $this_index ]['base_slug']
                ;

        }

        // =====================================================================
        // DATA_FIELD_SLUG_TO_SORT_BY ?
        // =====================================================================

        if (    $dataset_records_table['column_defs'][ $this_index ]['question_sortable']
                &&
                count( $dataset_records_table['column_defs'][ $this_index ]['sort_treatments'] ) > 0
            ) {

            $dataset_records_table['column_defs'][ $this_index ]['data_field_slug_to_sort_by'] =
                $dataset_records_table['column_defs'][ $this_index ]['base_slug'] . '_sort'
                ;

        } else {

            $dataset_records_table['column_defs'][ $this_index ]['data_field_slug_to_sort_by'] =
                $dataset_records_table['column_defs'][ $this_index ]['base_slug']
                ;

        }

        // =====================================================================
        // HEADER_HALIGN ?
        // =====================================================================

        if ( isset( $this_column_def['header_halign'] ) ) {

            if ( ! in_array( $this_column_def['header_halign'] , $allowed_haligns , TRUE ) ) {

                return <<<EOT
PROBLEM: Bad "dataset_records_table" + "column_defs" ("header_halign" must be "left", "center", "right" - for ALL columns)
For dataset:&nbsp; {$dataset_title}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

            }

        } else {

            $dataset_records_table['column_defs'][ $this_index ]['header_halign'] = 'center' ;

        }

        // =====================================================================
        // HEADER_VALIGN ?
        // =====================================================================

        if ( isset( $this_column_def['header_valign'] ) ) {

            if ( ! in_array( $this_column_def['header_valign'] , $allowed_valigns , TRUE ) ) {

                return <<<EOT
PROBLEM: Bad "dataset_records_table" + "column_defs" ("header_valign" must be "top", "middle", "bottom" - for ALL columns)
For dataset:&nbsp; {$dataset_title}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

            }

        } else {

            $dataset_records_table['column_defs'][ $this_index ]['header_valign'] = 'middle' ;

        }

        // =====================================================================
        // DATA_HALIGN ?
        // =====================================================================

        if ( isset( $this_column_def['data_halign'] ) ) {

            if ( ! in_array( $this_column_def['data_halign'] , $allowed_haligns , TRUE ) ) {

                return <<<EOT
PROBLEM: Bad "dataset_records_table" + "column_defs" ("data_halign" must be "left", "center", "right" - for ALL columns)
For dataset:&nbsp; {$dataset_title}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

            }

        } else {

            $dataset_records_table['column_defs'][ $this_index ]['data_halign'] = 'center' ;

        }

        // =====================================================================
        // DATA_VALIGN ?
        // =====================================================================

        if ( isset( $this_column_def['data_valign'] ) ) {

            if ( ! in_array( $this_column_def['data_valign'] , $allowed_valigns , TRUE ) ) {

                return <<<EOT
PROBLEM: Bad "dataset_records_table" + "column_defs" ("data_valign" must be "top", "middle", "bottom" - for ALL columns)
For dataset:&nbsp; {$dataset_title}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

            }

        } else {

            $dataset_records_table['column_defs'][ $this_index ]['data_valign'] = 'middle' ;

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

                $dataset_records_table['column_defs'][ $this_index ]['width_in_percent'] = 0 ;

                $number_columns_with_unspecified_width++ ;

            } elseif (  ! is_scalar( $this_column_def['width_in_percent'] )
                        ||
                        $this_column_def['width_in_percent'] > 100
                ) {

                return <<<EOT
PROBLEM: Bad "dataset_records_table" + "column_defs" ("width_in_percent" must be 1 to 100 or 0/NULL/unspecified - for ALL columns)
For dataset:&nbsp; {$dataset_title}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

            }

        } else {

            $dataset_records_table['column_defs'][ $this_index ]['width_in_percent'] = 0 ;

            $number_columns_with_unspecified_width++ ;

        }

        // ---------------------------------------------------------------------

        $total_widths_in_percent_so_far +=
            $dataset_records_table['column_defs'][ $this_index ]['width_in_percent']
            ;

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // WIDTH_IN_PERCENT ?
    // =========================================================================

    if ( $total_widths_in_percent_so_far > 100 ) {

        return <<<EOT
PROBLEM: Bad "dataset_records_table" + "column_defs" (total "width_in_percent" must be no more than 100)
For dataset:&nbsp; {$dataset_title}
Detected in:&nbsp; \\{$ns}\\{$fn}()
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
PROBLEM: Bad "dataset_records_table" + "column_defs" (too little "width_in_percent" left ({$leftover_width_available}%), to distribute amongst the ({$number_columns_with_unspecified_width}) unspecified columns)
For dataset:&nbsp; {$dataset_title}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        }

        // ---------------------------------------------------------------------

        $leftover_width_per_column =
            $leftover_width_available / $number_columns_with_unspecified_width ;

        // ---------------------------------------------------------------------

        foreach ( $dataset_records_table['column_defs'] as $this_index => $this_column_def ) {

            if ( $this_column_def['width_in_percent'] == 0 ) {

                $dataset_records_table['column_defs'][ $this_index ]['width_in_percent'] =
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
PROBLEM: Bad "dataset_records_table" + "column_defs" (total "width_in_percent" must be (approx.) 100)
For dataset:&nbsp; {$dataset_title}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

    }

    // =========================================================================
    // DEFAULT_DATA_FIELD_SLUG_TO_ORDERBY ?
    // =========================================================================

    if ( ! isset( $dataset_records_table['default_data_field_slug_to_orderby'] ) ) {

        // ---------------------------------------------------------------------
        // default_data_field_slug_to_orderby
        //      =>  'xxx' || ''/NULL (means orderby FIRST available data field)
        // ---------------------------------------------------------------------

        foreach ( $dataset_records_table['column_defs'] as $this_index => $this_column_def ) {

            if ( $this_column_def['question_sortable'] ) {

                $dataset_records_table['default_data_field_slug_to_orderby'] =
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

    if ( ! isset( $dataset_records_table['default_order'] ) ) {

        // ---------------------------------------------------------------------
        // default_order
        //      =>  'asc' OR 'desc' OR ''/NULL (means default to "asc")
        // ---------------------------------------------------------------------

        $dataset_records_table['default_order'] = 'asc' ;

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // ACTIONS ?
    // =========================================================================

    if ( ! isset( $dataset_records_table['actions'] ) ) {

        // ---------------------------------------------------------------------
        // actions
        //      =>  array(
        //              'edit'      =>  'edit'      ,
        //              'delete'    =>  'delete'
        //              )
        // ---------------------------------------------------------------------

        $dataset_records_table['actions'] = array(
            'edit'      =>  'edit'      ,
            'delete'    =>  'delete'
            ) ;

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // ACTION_SEPARATOR ?
    // =========================================================================

    if ( ! isset( $dataset_records_table['action_separator'] ) ) {

        // ---------------------------------------------------------------------
        // action_separator
        //      =>  ' &nbsp;&nbsp; '
        // ---------------------------------------------------------------------

        $dataset_records_table['action_separator'] = ' &nbsp;&nbsp; ' ;

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // SUCCESS!
    // =========================================================================

    $dataset_records_table['checked_defaulted_ok'] = TRUE ;

    // -------------------------------------------------------------------------

    return $dataset_records_table ;

    // =========================================================================
    // That's that!
    // =========================================================================

}

// =============================================================================
// auto_create_column_defs()
// =============================================================================

function auto_create_column_defs(
    $selected_datasets_dmdd     ,
    $dataset_records_table      ,
    $dataset_title
    ) {

    // -------------------------------------------------------------------------
    // auto_create_column_defs(
    //      $selected_datasets_dmdd     ,
    //      $dataset_records_table      ,
    //      $dataset_title
    //      )
    // - - - - - - - - - - - - - - - - -
    // Auto-creates the Dataset Records Table Columns from the Array Storage
    // Record definition.
    //
    // RETURNS
    //      o   On SUCCESS!
    //              $updated_column_defs ARRAY
    //
    //      o   On FAILURE!
    //              $error_message STRING
    // -------------------------------------------------------------------------

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $dataset_records_table['auto_create_column_defs'] = array(
    //          'include'       =>  'all'
    //                              --OR--
    //                              array(
    //                                  '<array-storage-field-slug-to-include-1>'   ,
    //                                  '<array-storage-field-slug-to-include-2>'   ,
    //                                  ...
    //                                  '<array-storage-field-slug-to-include-N>'
    //                                  )
    //          'exclude'       =>  'none'
    //                              --OR--
    //                              array(
    //                                  '<array-storage-field-slug-to-exclude-1>'   ,
    //                                  '<array-storage-field-slug-to-exclude-2>'   ,
    //                                  ...
    //                                  '<array-storage-field-slug-to-exclude-N>'
    //                                  )
    //          )                                                                                   ,
    //
    // -------------------------------------------------------------------------

    // =========================================================================
    // Init.
    // =========================================================================

    $ns = __NAMESPACE__ ;
    $fn = __FUNCTION__ ;

    // =========================================================================
    // Get the ARRAY STORAGE FIELD SLUGS...
    // =========================================================================

    //  Very simple version...

    $array_storage_field_slugs = array() ;

    foreach ( $selected_datasets_dmdd['array_storage_record_structure'] as $this_field ) {

        //  TODO Error Checking ???

        $array_storage_field_slugs[] = $this_field['slug'] ;

    }

    // =========================================================================
    // include ?
    // =========================================================================

    if ( ! array_key_exists( 'include' , $dataset_records_table['auto_create_column_defs'] ) ) {

        // ---------------------------------------------------------------------

        $include = $array_storage_field_slugs ;

        // ---------------------------------------------------------------------

    } elseif ( $dataset_records_table['auto_create_column_defs']['include'] === 'all' ) {

        // ---------------------------------------------------------------------

        $include = $array_storage_field_slugs ;

        // ---------------------------------------------------------------------

    } elseif (  ! is_array( $dataset_records_table['auto_create_column_defs']['include'] )
                ||
                count( $dataset_records_table['auto_create_column_defs']['include'] ) < 1
        ) {

        // ---------------------------------------------------------------------

        return <<<EOT
PROBLEM:&nbsp; Bad "dataset_records_table" + "auto_create_column_defs" + "include" ("all" or non-empty array expected)
For dataset:&nbsp; {$dataset_title}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        // ---------------------------------------------------------------------

    } else {

        // ---------------------------------------------------------------------

        $include = $dataset_records_table['auto_create_column_defs']['include'] ;

        // ---------------------------------------------------------------------

        foreach ( $include as $this_index => $this_candidate_array_storage_field_slug ) {

            if ( ! in_array( $this_candidate_array_storage_field_slug , $array_storage_field_slugs , TRUE ) ) {

                $entry_number = $this_index + 1 ;

                return <<<EOT
PROBLEM:&nbsp; Bad "dataset_records_table" + "auto_create_column_defs" + "include" + entry# {$entry_number} (array storage field slug expected)
For dataset:&nbsp; {$dataset_title}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

            }

        }

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // exclude ?
    // =========================================================================

    if ( ! array_key_exists( 'exclude' , $dataset_records_table['auto_create_column_defs'] ) ) {

        // ---------------------------------------------------------------------

        $exclude = $array_storage_field_slugs ;

        // ---------------------------------------------------------------------

    } elseif ( $dataset_records_table['auto_create_column_defs']['exclude'] === 'none' ) {

        // ---------------------------------------------------------------------

        $exclude = array() ;

        // ---------------------------------------------------------------------

    } elseif (  ! is_array( $dataset_records_table['auto_create_column_defs']['exclude'] )
                ||
                count( $dataset_records_table['auto_create_column_defs']['exclude'] ) < 1
        ) {

        // ---------------------------------------------------------------------

        return <<<EOT
PROBLEM:&nbsp; Bad "dataset_records_table" + "auto_create_column_defs" + "exclude" ("none" or non-empty array expected)
For dataset:&nbsp; {$dataset_title}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        // ---------------------------------------------------------------------

    } else {

        // ---------------------------------------------------------------------

        $exclude = $dataset_records_table['auto_create_column_defs']['exclude'] ;

        // ---------------------------------------------------------------------

        foreach ( $exclude as $this_index => $this_candidate_array_storage_field_slug ) {

            if ( ! in_array( $this_candidate_array_storage_field_slug , $array_storage_field_slugs , TRUE ) ) {

                $entry_number = $this_index + 1 ;

                return <<<EOT
PROBLEM:&nbsp; Bad "dataset_records_table" + "auto_create_column_defs" + "exclude" + entry# {$entry_number} (array storage field slug expected)
For dataset:&nbsp; {$dataset_title}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

            }

        }

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // Get the COLUMN "BASE_SLUGS" that have already been defined...
    // =========================================================================

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      <dataset-records-table-definition>['column_defs'] = array(
    //
    //          array(
    //              'base_slug'                     =>  'title'     ,
    //              'label'                         =>  'Title'     ,
    //              'question_sortable'             =>  TRUE        ,
    //              'raw_value_from'                =>  array(
    //                                                      'method'    =>  'array-storage-field-slug'      ,
    //                                                      'instance'  =>  'title'
    //                                                      )   ,
    //              'display_treatments'            =>  array(
    //                                                      array(
    //                                                          'method'    =>  'bold'
    //                                                          )
    //                                                      )
    //              )
    //
    //          ...
    //
    //          )
    //
    // -------------------------------------------------------------------------

    $pre_defined_column_indices_by_base_slug = array() ;

    // -------------------------------------------------------------------------

    foreach ( $dataset_records_table['column_defs'] as $this_index => $this_column_def ) {

        // ---------------------------------------------------------------------

        $column_number = $this_index + 1 ;

        // ---------------------------------------------------------------------

        if ( ! is_array( $this_column_def ) ) {

            return <<<EOT
PROBLEM:&nbsp; Bad "dataset_records_table" + "column_defs" + column# {$column_number} (array expected)
For dataset:&nbsp; {$dataset_title}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        }

        // ---------------------------------------------------------------------

        if ( ! array_key_exists( 'base_slug' , $this_column_def ) ) {

            return <<<EOT
PROBLEM:&nbsp; Bad "dataset_records_table" + "column_defs" + column# {$column_number} (no "base_slug")
For dataset:&nbsp; {$dataset_title}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        }

        // ---------------------------------------------------------------------

        if (    ! is_string( $this_column_def['base_slug'] )
                ||
                trim( $this_column_def['base_slug'] ) === ''
            ) {

            return <<<EOT
PROBLEM:&nbsp; Bad "dataset_records_table" + "column_defs" + column# {$column_number} + "base_slug" (non-empty string expected)
For dataset:&nbsp; {$dataset_title}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        }

        // ---------------------------------------------------------------------

        $pre_defined_column_indices_by_base_slug[ $this_column_def['base_slug'] ] = $this_index ;

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // Create the UPDATED COLUMN DEFS...
    // =========================================================================

    // -------------------------------------------------------------------------
    // NOTE!
    // =====
    // A "column definition" is like (eg):-
    //
    //      <dataset-records-table-definition>['column_defs'] = array(
    //
    //          array(
    //              'base_slug'                     =>  'title'     ,
    //              'label'                         =>  'Title'     ,
    //              'question_sortable'             =>  TRUE        ,
    //              'raw_value_from'                =>  array(
    //                                                      'method'    =>  'array-storage-field-slug'      ,
    //                                                      'instance'  =>  'title'
    //                                                      )   ,
    //              'display_treatments'            =>  array(
    //                                                      array(
    //                                                          'method'    =>  'bold'
    //                                                          )
    //                                                      )
    //              )
    //
    //          ...
    //
    //          )
    //
    // -------------------------------------------------------------------------

    $updated_column_defs = array() ;

    // -------------------------------------------------------------------------
    // FIRST:   Add any pre-defined columns that aren't in the array storage
    //          record structure...
    // -------------------------------------------------------------------------

    foreach ( $pre_defined_column_indices_by_base_slug as $this_base_slug => $this_index ) {

        // ---------------------------------------------------------------------

        if ( ! in_array( $this_base_slug , $array_storage_field_slugs , TRUE ) ) {

            $updated_column_defs[] =
                $dataset_records_table['column_defs'][
                    $pre_defined_column_indices_by_base_slug[ $this_base_slug ]
                    ] ;

        }

        // ---------------------------------------------------------------------

    }

    // -------------------------------------------------------------------------
    // THEN:    Add in the included but NOT excluded array storage record
    //          fields...
    // -------------------------------------------------------------------------

    foreach ( $array_storage_field_slugs as $this_array_storage_field_slug ) {

        // ---------------------------------------------------------------------

        if ( ! in_array( $this_array_storage_field_slug , $include , TRUE ) ) {
            continue ;
        }

        // ---------------------------------------------------------------------

        if ( in_array( $this_array_storage_field_slug , $exclude , TRUE ) ) {
            continue ;
        }

        // ---------------------------------------------------------------------

        if ( array_key_exists( $this_array_storage_field_slug , $pre_defined_column_indices_by_base_slug ) ) {

            // -----------------------------------------------------------------

            $updated_column_defs[] =
                $dataset_records_table['column_defs'][
                    $pre_defined_column_indices_by_base_slug[ $this_array_storage_field_slug ]
                    ] ;

            // -----------------------------------------------------------------

        } else {

            // -----------------------------------------------------------------

            $label =
                \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_stringUtils\to_title(
                    $this_array_storage_field_slug
                    ) ;

            // -----------------------------------------------------------------

            $updated_column_defs[] = array(
                'base_slug'             =>  $this_array_storage_field_slug                      ,
                'label'                 =>  $label                                              ,
                'question_sortable'     =>  TRUE                                                ,
                'raw_value_from'        =>  array(
                                                'method'    =>  'array-storage-field-slug'      ,
                                                'instance'  =>  $this_array_storage_field_slug
                                                )
                ) ;

            // -----------------------------------------------------------------

        }

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // Add the "ACTION" column - but only if any "record actions" are
    // specified...
    // =========================================================================

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $dataset_records_table = array(
    //
    //          ...
    //
    //          'record_actions'    =>  array(
    //
    //                                      array(
    //                                          'type'          =>  'standard'      ,
    //                                          'slug'          =>  'edit'          ,
    //                                          'link_title'    =>  'edit'
    //                                          )   ,
    //
    //                                      array(
    //                                          'type'          =>  'standard'      ,
    //                                          'slug'          =>  'delete'        ,
    //                                          'link_title'    =>  'delete'
    //                                          )   ,
    //
    //          //                          array(
    //          //                              'type'          =>  'custom'                        ,
    //          //                              'slug'          =>  'select-export-dirs-files'      ,
    //          //                              'link_title'    =>  'select/export dirs/files'
    //          //                              )
    //
    //                                      )   ,
    //
    //          ...
    //
    //          )
    //
    // -------------------------------------------------------------------------

    if (    array_key_exists( 'record_actions' , $dataset_records_table )
            &&
            is_array( $dataset_records_table['record_actions'] )
            &&
            count( $dataset_records_table['record_actions'] ) > 0
        ) {

        // ---------------------------------------------------------------------

        $updated_column_defs[] = array(
            'base_slug'                     =>  'action'            ,
            'label'                         =>  'Action'            ,
            'question_sortable'             =>  FALSE               ,
            'raw_value_from'                =>  array(
                                                    'method'    =>  'special-type'      ,
                                                    'instance'  =>  'record-action'
                                                    )   ,
            'display_treatments'            =>  NULL
            ) ;

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // SUCCESS!
    // =========================================================================

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $updated_column_defs ) ;

    return $updated_column_defs ;

    // =========================================================================
    // That's that!
    // =========================================================================

}

// =============================================================================
// That's that!
// =============================================================================

