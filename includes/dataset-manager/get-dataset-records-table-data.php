<?php

// *****************************************************************************
// DATASET-MANAGER / GET-DATASET-RECORDS-TABLE-DATA.PHP
// (C) 2013 Peter Newman. All Rights Reserved.
// *****************************************************************************

    namespace greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager ;

// =============================================================================
// get_dataset_records_table_data()
// =============================================================================

function get_dataset_records_table_data(
    $all_application_dataset_definitions    ,
    $selected_datasets_dmdd                 ,
    $dataset_records                        ,
    $dataset_slug                           ,
    $dataset_title                          ,
    $question_front_end                     ,
    $caller_apps_includes_dir               ,
    $data_for
    ) {

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\get_dataset_records_table_data(
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

//pr( $dataset_records ) ;

//\greatKiwi_basepressLogger\pr( $dataset_records ) ;

//pr( $_GET ) ;

    // -------------------------------------------------------------------------
    // NOTE!
    // =====
    // $table_data is constructed from:-
    //      $selected_datasets_dmdd['dataset_records_table'], and;
    //      $dataset_records
    //
    // $selected_datasets_dmdd['dataset_records_table'] is like (eg):-
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
    //                  'display_treatments'            =>  array()
    //                  'sort_treatments'               =>  array()
    //                  'data_field_slug_to_display'    =>  title
    //                  'data_field_slug_to_sort_by'    =>  title
    //                  'header_halign'                 =>  center
    //                  'header_valign'                 =>  middle
    //                  'data_halign'                   =>  center
    //                  'data_valign'                   =>  middle
    //                  'width_in_percent'              =>  50
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
    //                  'display_treatments'            =>  array()
    //                  'sort_treatments'               =>  array()
    //                  'data_field_slug_to_display'    =>  action
    //                  'data_field_slug_to_sort_by'    =>  action
    //                  'header_halign'                 =>  center
    //                  'header_valign'                 =>  middle
    //                  'data_halign'                   =>  center
    //                  'data_valign'                   =>  middle
    //                  'width_in_percent'              =>  50
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
    //          [action_separator]                  =>
    //
    //          [checked_defaulted_ok]              => 1
    //
    //          )
    //
    // NOTE!
    // =====
    // On entry, it's assumed that:-
    //     $selected_datasets_dmdd['dataset_records_table']
    //
    // has been checked/defaulted by:-
    //     check_and_default_dataset_records_table()
    //
    // And thus it, and all it's required members, are present and correct.
    // -------------------------------------------------------------------------

//pr( $selected_datasets_dmdd['dataset_records_table'] ) ;

    // =========================================================================
    // Init...
    // =========================================================================

    $ns = __NAMESPACE__ ;
    $fn = __FUNCTION__ ;

    // =========================================================================
    // $data_for
    // =========================================================================

    if ( ! in_array(
                $data_for                                   ,
                array( 'wp-list-table' , 'dhtmlx-grid' )    ,
                TRUE
                )
        ) {

        $safe_data_for = htmlentities( $data_for ) ;

        return <<<EOT
PROBLEM Getting Dataset Records Table Data:&nbsp; Unrecognised/unsupported "data_for" ("{$safe_data_for}")
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\get_dataset_records_table_data()
EOT;

    }

    // =========================================================================
    // Make sure that the Dataset Records Table has been CHECKED and DEFAULTED
    // OK...
    // =========================================================================

    if ( ! array_key_exists( 'dataset_records_table' , $selected_datasets_dmdd ) ) {

        return <<<EOT
PROBLEM Getting Dataset Records Table Data:&nbsp; "dataset_records_table" NOT defined
For dataset:&nbsp; {$dataset_title}
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\get_dataset_records_table_data()
EOT;

    }

    // -------------------------------------------------------------------------

    if (    ! is_array( $selected_datasets_dmdd['dataset_records_table'] )
            ||
            count( $selected_datasets_dmdd['dataset_records_table'] ) < 1
        ) {

        return <<<EOT
PROBLEM Getting Dataset Records Table Data:&nbsp; Bad "dataset_records_table" (non-empty array expected)
For dataset:&nbsp; {$dataset_title}
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\get_dataset_records_table_data()
EOT;

    }

    // -------------------------------------------------------------------------

    if (    ! array_key_exists( 'checked_defaulted_ok' , $selected_datasets_dmdd['dataset_records_table'] )
            ||
            $selected_datasets_dmdd['dataset_records_table']['checked_defaulted_ok'] !== TRUE
        ) {

        return <<<EOT
PROBLEM Getting Dataset Records Table Data:&nbsp; "dataset_records_table" doesn't seem to have been checked and defaulted yet
For dataset:&nbsp; {$dataset_title}
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\get_dataset_records_table_data()
EOT;

    }

    // =========================================================================
    // Init. the various internal and output variables used...
    // =========================================================================

    $data_field_slugs_for_column_sorting = array() ;

    $question_delete_record_javascript_required = FALSE ;

    // =========================================================================
    // Init. the "loaded datasets" array - where we cache the foreign datasets
    // that might be accessed when filling "foreign fields", for example...
    // =========================================================================

    // -------------------------------------------------------------------------
    // load_dataset(
    //      $all_application_dataset_definitions    ,
    //      $caller_apps_includes_dir               ,
    //      &$loaded_datasets                       ,
    //      $dataset_slug                           ,
    //      $dataset_key_field_slug = NULL          ,
    //      $dataset_title          = NULL          ,
    //      $dataset_records        = NULL          ,
    //      $record_indices_by_key  = NULL
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - -
    // Adds the specified dataset to $loaded_datasets (unless it's already
    // loaded).
    //
    // NOTE!
    // =====
    // 1.   Each of:-
    //          o   $dataset_key_field_slug
    //          o   $dataset_title
    //          o   $dataset_records
    //          o   $record_indices_by_key
    //
    //      is only loaded if it wasn't supplied on input.
    //
    // 2.   $loaded_datasets is like (eg):-
    //
    //          $loaded_datasets = array(
    //
    //              <dataset_slug>  =>  array(
    //                                      'title'                 =>  "xxx"           ,
    //                                      'records'               =>  array(...)      ,
    //                                      'key_field_slug'        =>  "xxx" or NULL
    //                                      'record_indices_by_key' =>  array(...)
    //                                      )   ,
    //
    //              ...
    //
    //              )
    //
    // RETURNS
    //      o   TRUE on SUCCESS
    //      o   $error_message STRING on FAILURE
    // -------------------------------------------------------------------------

    $loaded_datasets = array() ;

    // -------------------------------------------------------------------------

    $dataset_key_field_slug = NULL ;
    $record_indices_by_key  = NULL ;

    // -------------------------------------------------------------------------

    $result = load_dataset(
                    $all_application_dataset_definitions    ,
                    $caller_apps_includes_dir               ,
                    $loaded_datasets                        ,
                    $dataset_slug                           ,
                    $dataset_key_field_slug                 ,
                    $dataset_title                          ,
                    $dataset_records                        ,
                    $record_indices_by_key
                    ) ;
                    //  Add the current dataset (whoose records we're
                    //  displaying), into the $loaded_datasets array

    // -------------------------------------------------------------------------

    if ( is_string( $result ) ) {
        return $result ;
    }

    // =========================================================================
    // Do the "PRE GET TABLE DATA" function (if there is one)...
    // =========================================================================

    if (    array_key_exists( 'pre_get_table_data_function_name' , $selected_datasets_dmdd['dataset_records_table'] )
            &&
            is_string( $selected_datasets_dmdd['dataset_records_table']['pre_get_table_data_function_name'] )
            &&
            trim( $selected_datasets_dmdd['dataset_records_table']['pre_get_table_data_function_name'] ) !== ''
        ) {

        // ----------------------------------------------------------------------

        if ( ! function_exists( $selected_datasets_dmdd['dataset_records_table']['pre_get_table_data_function_name'] ) ) {

            return <<<EOT
PROBLEM Getting Dataset Records Table Data:&nbsp; "dataset_records_table" + "pre_get_table_data_function_name" doesn't exist
For dataset:&nbsp; {$dataset_title}
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\get_dataset_records_table_data()
EOT;

        }

        // -------------------------------------------------------------------------
        // <my_custom_pre_get_table_data_function>(
        //      $dataset_slug                           ,
        //      $dataset_title                          ,
        //      $question_front_end                     ,
        //      $caller_apps_includes_dir               ,
        //      &$all_application_dataset_definitions   ,
        //      &$selected_datasets_dmdd                ,
        //      &$dataset_records                       ,
        //      &$loaded_datasets
        //      )
        // - - - - - - - - - - - - - - - - - - - - - - -
        // This function can update any of:-
        //      o   $all_application_dataset_definitions   ,
        //      o   $selected_datasets_dmdd                ,
        //      o   $dataset_records                       ,
        //      o   $loaded_datasets
        //
        // if it wants to (to sort the dataset records to be displayed, for
        // example).
        //
        // It should also return a (possibly empty) array containing the
        // arguments (if any), it wants to return to the main "get dataset records
        // table data" function.
        //
        // RETURNS
        //      o   On SUCCESS
        //              $custom_get_table_data_function_data ARRAY
        //
        //      o   On FAILURE
        //              $error_message STRING
        // -------------------------------------------------------------------------

        $custom_get_table_data_function_data =
            $selected_datasets_dmdd['dataset_records_table']['pre_get_table_data_function_name'](
                $dataset_slug                           ,
                $dataset_title                          ,
                $question_front_end                     ,
                $caller_apps_includes_dir               ,
                $all_application_dataset_definitions    ,
                $selected_datasets_dmdd                 ,
                $dataset_records                        ,
                $loaded_datasets
                ) ;

        // ---------------------------------------------------------------------

        if ( is_string( $custom_get_table_data_function_data ) ) {
            return $custom_get_table_data_function_data ;
        }

        // ---------------------------------------------------------------------

        if ( ! is_array( $custom_get_table_data_function_data ) ) {

            return <<<EOT
PROBLEM:&nbsp; Bad "dataset_records_table" + "pre_get_table_data_function_name" return value (possibly empty array expected)
For dataset:&nbsp; {$dataset_title}
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\get_dataset_records_table_data()
EOT;

        }

        // ---------------------------------------------------------------------

    } else {

        // ---------------------------------------------------------------------

        $custom_get_table_data_function_data = array() ;

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // Get the ARRAY STORAGE field indices and slugs - for the array storage
    // fields that are Base64 encoded...
    // =========================================================================

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\
    // get_pre_check_base64_encoded_array_storage_field_indices_by_slug(
    //      $selected_datasets_dmdd
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // RETURNS
    //      On SUCCESS!
    //          ARRAY $pre_check_base64_encoded_array_storage_field_indices_by_slug
    //
    //      On FAILURE
    //          $error_message string
    // -------------------------------------------------------------------------

    $pre_check_base64_encoded_array_storage_field_indices_by_slug =
        get_pre_check_base64_encoded_array_storage_field_indices_by_slug(
            $selected_datasets_dmdd
            ) ;

    // -------------------------------------------------------------------------

    if ( is_string( $pre_check_base64_encoded_array_storage_field_indices_by_slug ) ) {
        return $pre_check_base64_encoded_array_storage_field_indices_by_slug ;
    }

    // =========================================================================
    // LOOP OVER the COLUMN DEFINITIONS - adding each column/field to the output
    // table data in turn..
    // =========================================================================

    $table_data = array() ;

    $sort_data = array() ;
        //  This array is like (eg):-
        //
        //      $sort_data = array(
        //          '<sort_field_slug_1>'   =>  array(...values_1...)
        //          '<sort_field_slug_2>'   =>  array(...values_2...)
        //          ...
        //          '<sort_field_slug_3>'   =>  array(...values_3...)
        //          )

    // -------------------------------------------------------------------------

    foreach ( $selected_datasets_dmdd['dataset_records_table']['column_defs'] as $this_column_index => $this_column_def ) {

        // ---------------------------------------------------------------------

        $column_number = $this_column_index + 1 ;

        // =====================================================================
        // The "RAW_VALUE_FROM" field tells us how to get the field value
        // for each column...
        // =====================================================================

        if ( $this_column_def['raw_value_from']['method'] === 'array-storage-field-slug' ) {

            // =================================================================
            // ARRAY-STORAGE-FIELD-SLUG
            // =================================================================

            // -----------------------------------------------------------------
            // Here we should have (eg):-
            //
            //      $this_column_def['raw_value_from'] = array(
            //          'method'    =>  'array-storage-field-slug'      ,
            //          'instance'  =>  "xxx"
            //          )
            //
            // -----------------------------------------------------------------

            // =================================================================
            // "INSTANCE" OK?
            // =================================================================

            if (    ! is_string( $this_column_def['raw_value_from']['instance'] )
                    ||
                    trim( $this_column_def['raw_value_from']['instance'] ) === ''
                    ||
                    ! \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_stringUtils\ctype_varname( $this_column_def['raw_value_from']['instance'] )
                    ||
                    strlen( $this_column_def['raw_value_from']['instance'] ) > 64
                ) {

                return <<<EOT
PROBLEM Displaying Dataset Records:&nbsp; Bad "dataset_records_table" + "column_defs" + "raw_value_from" + "instance" - for column# {$column_number} (1 to 64 character, variable name type string expected)
For dataset:&nbsp; {$dataset_title}
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\get_dataset_records_table_data()
EOT;

            }

            // =================================================================
            // Get this column's TABLE DATA for all the dataset records...
            // =================================================================

            foreach ( $dataset_records as $record_index => $record_data ) {

                // =============================================================
                // RECORD HAS "INSTANCE" FIELD ?
                // =============================================================

                if ( ! array_key_exists( $this_column_def['raw_value_from']['instance'] , $record_data ) ) {

                    $record_number = $record_index + 1 ;

                    $safe_instance = htmlentities( $this_column_def['raw_value_from']['instance'] ) ;

                    return <<<EOT
PROBLEM Displaying Dataset Records:&nbsp; Bad "dataset_records_table" + "column_defs" + "raw_value_from" + "instance" - for column# {$column_number} (dataset record# {$record_number} has NO "{$safe_instance}" field)
For dataset:&nbsp; {$dataset_title}
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\get_dataset_records_table_data()
EOT;

                }

                // =============================================================
                // GET THE RAW FIELD VALUE...
                // =============================================================

                $raw_field_value = $record_data[ $this_column_def['raw_value_from']['instance'] ] ;

                // =============================================================
                // BASE64 DECODE the raw field value, if required...
                // =============================================================

                if ( array_key_exists(
                            $this_column_def['raw_value_from']['instance']                  ,
                            $pre_check_base64_encoded_array_storage_field_indices_by_slug
                            )
                    ) {
                    $raw_field_value = base64_decode( $raw_field_value ) ;
                }

                // =============================================================
                // SAVE THE "DISPLAY" VALUE
                // =============================================================

                $display_value = $raw_field_value ;

                // -------------------------------------------------------------------------
                // apply_display_treatments_to_field_value(
                //      $all_application_dataset_definitions    ,
                //      $selected_datasets_dmdd                 ,
                //      $dataset_records                        ,
                //      $dataset_slug                           ,
                //      $dataset_title                          ,
                //      $question_front_end                     ,
                //      $caller_apps_includes_dir               ,
                //      $this_column_def_index                  ,
                //      $this_column_def                        ,
                //      $this_dataset_record_index              ,
                //      $this_dataset_record_data               ,
                //      &$custom_get_table_data_function_data   ,
                //      &$field_value
                //      )
                // - - - - - - - - - - - - - - - - - - - - - - -
                // Applies the specified "treatments" to the current field's value...
                //
                // RETURNS
                //      o   On SUCCESS!
                //          - - - - - -
                //          TRUE
                //
                //      o   On FAILURE!
                //          - - - - - -
                //          $error_message STRING
                // -------------------------------------------------------------------------

                $result = apply_display_treatments_to_field_value(
                                $all_application_dataset_definitions    ,
                                $selected_datasets_dmdd                 ,
                                $dataset_records                        ,
                                $dataset_slug                           ,
                                $dataset_title                          ,
                                $question_front_end                     ,
                                $caller_apps_includes_dir               ,
                                $this_column_index                      ,
                                $this_column_def                        ,
                                $record_index                           ,
                                $record_data                            ,
                                $custom_get_table_data_function_data    ,
                                $display_value
                                ) ;

                // -------------------------------------------------------------

                if ( is_string( $result ) ) {
                    return $result ;
                }

                // -------------------------------------------------------------

                if ( array_key_exists( $record_index , $table_data ) ) {

                    $table_data[ $record_index ][ $this_column_def['data_field_slug_to_display'] ] = $display_value ;

                } else {

                    $table_data[ $record_index ] = array(
                        $this_column_def['data_field_slug_to_display'] => $display_value
                        ) ;

                }

                // =============================================================
                // SAVE THE "SORT" VALUE (if there is one)...
                // =============================================================

                if ( $this_column_def['question_sortable'] ) {

                    // ---------------------------------------------------------

                    $sort_value = $raw_field_value ;

//                  // -------------------------------------------------------------------------
//                  // apply_sort_treatments_to_field_value(
//                  //      $all_application_dataset_definitions    ,
//                  //      $selected_datasets_dmdd                 ,
//                  //      $dataset_records                        ,
//                  //      $dataset_slug                           ,
//                  //      $dataset_title                          ,
//                  //      $question_front_end                     ,
//                  //      $caller_apps_includes_dir               ,
//                  //      $this_column_def_index                  ,
//                  //      $this_column_def                        ,
//                  //      $this_dataset_record_index              ,
//                  //      $this_dataset_record_data               ,
//                  //      &$custom_get_table_data_function_data   ,
//                  //      &$field_value
//                  //      )
//                  // - - - - - - - - - - - - - - - - - - - - - - -
//                  // Applies the specified "treatments" to the current field's value...
//                  //
//                  // RETURNS
//                  //      o   On SUCCESS!
//                  //          - - - - - -
//                  //          TRUE
//                  //
//                  //      o   On FAILURE!
//                  //          - - - - - -
//                  //          $error_message STRING
//                  // -------------------------------------------------------------------------
//
//                  $result = apply_sort_treatments_to_field_value(
//                                  $all_application_dataset_definitions    ,
//                                  $selected_datasets_dmdd                 ,
//                                  $dataset_records                        ,
//                                  $dataset_slug                           ,
//                                  $dataset_title                          ,
//                                  $question_front_end                     ,
//                                  $caller_apps_includes_dir               ,
//                                  $this_column_index                      ,
//                                  $this_column_def                        ,
//                                  $record_index                           ,
//                                  $record_data                            ,
//                                  $custom_get_table_data_function_data    ,
//                                  $sort_value
//                                  ) ;
//
//                  // ---------------------------------------------------------
//
//                  if ( is_string( $result ) ) {
//                      return $result ;
//                  }

                    // ---------------------------------------------------------

                    if ( $data_for === 'wp-list-table' ) {

                        // -----------------------------------------------------

                        if ( array_key_exists( $record_index , $table_data ) ) {

                            $table_data[ $record_index ][ $this_column_def['data_field_slug_to_sort_by'] ] = $sort_value ;

                        } else {

                            $table_data[ $record_index ] = array(
                                $this_column_def['data_field_slug_to_sort_by'] => $sort_value
                                ) ;

                        }

                        // -----------------------------------------------------

                    } elseif ( $data_for === 'dhtmlx-grid' ) {

                        // -----------------------------------------------------
                        // $sort_data is like (eg):-
                        //
                        //      $sort_data = array(
                        //          '<sort_field_slug_1>'   =>  array(...values_1...)
                        //          '<sort_field_slug_2>'   =>  array(...values_2...)
                        //          ...
                        //          '<sort_field_slug_3>'   =>  array(...values_3...)
                        //          )
                        //
                        // NOTE!
                        // =====
                        // When adding the values, we DON'T add duplicates.
                        // -----------------------------------------------------

                        if ( array_key_exists(
                                $this_column_def['data_field_slug_to_sort_by']  ,
                                $sort_data
                                )
                            ) {

                            if ( ! in_array(    $sort_value                                                     ,
                                                $sort_data[ $this_column_def['data_field_slug_to_sort_by'] ]    ,
                                                TRUE
                                                )
                                ) {
                                $sort_data[ $this_column_def['data_field_slug_to_sort_by'] ][] = $sort_value ;
                            }

                        } else {

                            $sort_data[ $this_column_def['data_field_slug_to_sort_by'] ] = array(
                                $sort_value
                                ) ;

                        }

                        // -----------------------------------------------------

                    }

                    // ---------------------------------------------------------

                }

                // =============================================================
                // Repeat with the NEXT RECORD (if there is one)...
                // =============================================================

            }

            // -----------------------------------------------------------------

        } elseif ( $this_column_def['raw_value_from']['method'] === 'special-type' ) {

            // =================================================================
            // SPECIAL-TYPE
            // =================================================================

            // -----------------------------------------------------------------
            // Check the "instance" parameter...
            // -----------------------------------------------------------------

            if (    ! is_string( $this_column_def['raw_value_from']['instance'] )
                    ||
                    trim( $this_column_def['raw_value_from']['instance'] ) === ''
                ) {

                return <<<EOT
PROBLEM Displaying Dataset Records:&nbsp; Bad "dataset_records_table" + "column_defs" + "raw_value_from" + "instance" - for column# {$column_number} (non-empty string expected)
For dataset:&nbsp; {$dataset_title}
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\get_dataset_records_table_data()
EOT;

            }

            // =================================================================
            // PROCESS the SPECIAL TYPE's "instance"...
            // =================================================================

            if ( $this_column_def['raw_value_from']['instance'] === 'record-action' ) {

                // :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
                // "SPECIAL_TYPE" = "ACTION"...
                // :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

                // -------------------------------------------------------------
                // Here we should have (eg):-
                //
                //      $this_column_def['raw_value_from'] = array(
                //          'method'    =>  'special-type'                  ,
                //          'instance'  =>  "record-action"
                //          )
                //
                // In other words, this column is an "Action" column.
                //
                // Where each record has zero or more "actions" - as specified
                // by the Dataset Records Table's:-
                //     "record_actions"
                //
                // parameter.  Which is like (eg):-
                //
                //      <dataset records table>['record_actions'] = array(
                //          array(
                //              'type'          =>  'standard'      ,
                //              'slug'          =>  'edit'          ,
                //              'link_title'    =>  'edit'
                //              )   ,
                //          array(
                //              'type'          =>  'standard'      ,
                //              'slug'          =>  'delete'        ,
                //              'link_title'    =>  'delete'
                //              )   ,
                //          array(
                //              'type'          =>  'custom'                ,
                //              'slug'          =>  'select-dirs-files'     ,
                //              'link_title'    =>  'select files'
                //              )
                //          )
                //
                // Which will typically be displayed in the table's "Action"
                // column - as clickable links like (eg):-
                //     edit   delete   select files
                //
                // -------------------------------------------------------------

                // =============================================================
                // Get the ARRAY STORAGE KEY FIELD SLUG (for those actions,
                // eg:-
                //      o   edit
                //      o   delete
                //
                // that need it...
                // =============================================================

                $array_storage_key_field_slug = '' ;

                // -------------------------------------------------------------

                if ( isset( $selected_datasets_dmdd['array_storage_key_field_slug'] ) ) {

                    // ---------------------------------------------------------

                    if (    ! is_string( $selected_datasets_dmdd['array_storage_key_field_slug'] )
                            ||
                            trim( $selected_datasets_dmdd['array_storage_key_field_slug'] ) === ''
                            ||
                            ! \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_stringUtils\ctype_varname( $selected_datasets_dmdd['array_storage_key_field_slug'] )
                        ) {

                        return <<<EOT
PROBLEM Displaying Dataset Records:&nbsp; Bad "dataset_records_table" + "array_storage_key_field_slug" (must be a non-blank variable-name like string)
For dataset:&nbsp; {$dataset_title}
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\get_dataset_records_table_data()
EOT;

                    }

                    // ---------------------------------------------------------

                    $array_storage_key_field_slug = $selected_datasets_dmdd['array_storage_key_field_slug'] ;

                    // ---------------------------------------------------------

                }

                // =============================================================
                // DEFAULT the RECORD ACTIONS...
                // =============================================================

                // -------------------------------------------------------------
                // Here we should have (eg):-
                //
                //      $selected_datasets_dmdd['dataset_records_table']['record_actions'] = array(
                //          array(
                //              'type'          =>  'standard'      ,
                //              'slug'          =>  'edit'          ,
                //              'link_title'    =>  'edit'
                //              )   ,
                //          array(
                //              'type'          =>  'standard'      ,
                //              'slug'          =>  'delete'        ,
                //              'link_title'    =>  'delete'
                //              )   ,
                //          array(
                //              'type'          =>  'custom'                ,
                //              'slug'          =>  'select-dirs-files'     ,
                //              'link_title'    =>  'select files'
                //              )
                //          )
                //
                // -------------------------------------------------------------

                if ( ! isset( $selected_datasets_dmdd['dataset_records_table']['record_actions'] ) ) {

                    // ---------------------------------------------------------

                    if ( $array_storage_key_field_slug === '' ) {

                        $selected_datasets_dmdd['dataset_records_table']['record_actions'] = array() ;

                    } else {

                        $selected_datasets_dmdd['dataset_records_table']['record_actions'] = array(
                            array(
                                'type'          =>  'standard'      ,
                                'slug'          =>  'edit'          ,
                                'link_title'    =>  'edit'
                                )   ,
                            array(
                                'type'          =>  'standard'      ,
                                'slug'          =>  'delete'        ,
                                'link_title'    =>  'delete'
                                )
                            ) ;

                    }

                    // ---------------------------------------------------------

                }

                // =============================================================
                // CHECK the RECORD ACTIONS (1)...
                // =============================================================

                // -------------------------------------------------------------
                // Here we should have (eg):-
                //
                //      $selected_datasets_dmdd['dataset_records_table']['record_actions'] = array(
                //          array(
                //              'type'          =>  'standard'      ,
                //              'slug'          =>  'edit'          ,
                //              'link_title'    =>  'edit'
                //              )   ,
                //          array(
                //              'type'          =>  'standard'      ,
                //              'slug'          =>  'delete'        ,
                //              'link_title'    =>  'delete'
                //              )   ,
                //          array(
                //              'type'          =>  'custom'                ,
                //              'slug'          =>  'select-dirs-files'     ,
                //              'link_title'    =>  'select files'
                //              )
                //          )
                //
                // -------------------------------------------------------------

                if ( ! is_array( $selected_datasets_dmdd['dataset_records_table']['record_actions'] ) ) {

                    return <<<EOT
PROBLEM Displaying Dataset Records:&nbsp; Bad "dataset_records_table" + "record_actions" (not an array)
For dataset:&nbsp; {$dataset_title}
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\get_dataset_records_table_data()
EOT;

                }

                // -------------------------------------------------------------

                $allowed_record_action_types = array(
                    'standard'      ,
                    'custom'
                    ) ;

                // -------------------------------------------------------------

                $custom_record_action_indices_by_slug = array() ;
                    //  By default, we assume that there are NO "custom" record
                    //  actions...

                // -------------------------------------------------------------

                foreach ( $selected_datasets_dmdd['dataset_records_table']['record_actions'] as $this_record_action_index => $this_record_action_details ) {

                    // ---------------------------------------------------------

                    $record_action_number = $this_record_action_index + 1 ;

                    // ---------------------------------------------------------
                    // type ?
                    // ---------------------------------------------------------

                    if ( ! isset( $this_record_action_details['type'] ) ) {

                        return <<<EOT
PROBLEM Displaying Dataset Records:&nbsp; Bad "dataset_records_table" record action# {$record_action_number} (no "type")
For dataset:&nbsp; {$dataset_title}
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\get_dataset_records_table_data()
EOT;

                    }

                    // ---------------------------------------------------------

                    if (    ! is_string( $this_record_action_details['type'] )
                            ||
                            trim( $this_record_action_details['type'] ) === ''
                        ) {

                        return <<<EOT
PROBLEM Displaying Dataset Records:&nbsp; Bad "dataset_records_table" + record action# {$record_action_number} + "type" (non-empty string expected)
For dataset:&nbsp; {$dataset_title}
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\get_dataset_records_table_data()
EOT;

                    }

                    // ---------------------------------------------------------

                    if ( ! in_array( $this_record_action_details['type'] , $allowed_record_action_types , TRUE ) ) {

                        $safe_type = htmlentities( $this_record_action_details['type'] ) ;

                        return <<<EOT
PROBLEM Displaying Dataset Records:&nbsp; Unrecognised/unsupported "dataset_records_table" + record action# {$record_action_number} + "type" ("{$safe_type}")
For dataset:&nbsp; {$dataset_title}
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\get_dataset_records_table_data()
EOT;

                    }

                    // ---------------------------------------------------------
                    // slug ?
                    // ---------------------------------------------------------

                    if ( ! isset( $this_record_action_details['slug'] ) ) {

                        return <<<EOT
PROBLEM Displaying Dataset Records:&nbsp; Bad "dataset_records_table" record action# {$record_action_number} (no "slug")
For dataset:&nbsp; {$dataset_title}
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\get_dataset_records_table_data()
EOT;

                    }

                    // ---------------------------------------------------------

                    if (    ! is_string( $this_record_action_details['slug'] )
                            ||
                            trim( $this_record_action_details['slug'] ) === ''
                            ||
                            strlen( $this_record_action_details['slug'] ) > 64
                            ||
                            ! \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_stringUtils\ctype_alphanumeric_underscore_dash( $this_record_action_details['slug'] )
                        ) {

                        return <<<EOT
PROBLEM Displaying Dataset Records:&nbsp; Bad "dataset_records_table" + record action# {$record_action_number} + "slug" (1 to 64 character "alphanumeric underscore dash" type string expected)
For dataset:&nbsp; {$dataset_title}
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\get_dataset_records_table_data()
EOT;

                    }

                    // ---------------------------------------------------------
                    // link_title ?
                    // ---------------------------------------------------------

                    if ( ! isset( $this_record_action_details['link_title'] ) ) {

                        return <<<EOT
PROBLEM Displaying Dataset Records:&nbsp; Bad "dataset_records_table" record action# {$record_action_number} (no "link_title")
For dataset:&nbsp; {$dataset_title}
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\get_dataset_records_table_data()
EOT;

                    }

                    // ---------------------------------------------------------

                    if (    ! is_string( $this_record_action_details['link_title'] )
                            ||
                            trim( $this_record_action_details['link_title'] ) === ''
                            ||
                            strlen( $this_record_action_details['link_title'] ) > 255
                        ) {

                        return <<<EOT
PROBLEM Displaying Dataset Records:&nbsp; Bad "dataset_records_table" + record action# {$record_action_number} + "link_title" (1 to 255 character string expected)
For dataset:&nbsp; {$dataset_title}
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\get_dataset_records_table_data()
EOT;

                    }

                    // ---------------------------------------------------------
                    // Record any custom record actions found...
                    // ---------------------------------------------------------

                    if ( $this_record_action_details['type'] === 'custom' ) {

                        $custom_record_action_indices_by_slug[
                            $this_record_action_details['slug']
                            ] = $this_record_action_index
                            ;

                    }

                    // ---------------------------------------------------------

                }

                // =============================================================
                // CHECK the CUSTOM ACTIONS (but only if at least one
                // record action points to a custom action)...
                // =============================================================

                if ( count( $custom_record_action_indices_by_slug ) > 0 ) {

                    // =========================================================
                    // CHECK the dataset's CUSTOM ACTIONS array...
                    // =========================================================

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
                    //                                  'plugin_stuff_relative_filespec'    =>  'select-dirs-and-files.php'     ,
                    //                                  'namespace_and_function_name'       =>  'select_dirs_and_files'
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

                    $custom_action_indices_by_slug =
                        validate_and_index_datasets_custom_actions(
                            $selected_datasets_dmdd     ,
                            $dataset_title
                            ) ;

                    // ---------------------------------------------------------

                    if ( is_string( $custom_action_indices_by_slug ) ) {
                        return $custom_action_indices_by_slug ;
                    }

                    // ---------------------------------------------------------
                    // Here we should have (eg):-
                    //
                    //      $custom_action_indices_by_slug = Array(
                    //          [select-export-dirs-files] => 0
                    //          )
                    //
                    // ---------------------------------------------------------

//pr( $custom_action_indices_by_slug , '$custom_action_indices_by_slug' ) ;

                    // =========================================================
                    // CHECK that the specified CUSTOM RECORD ACTIONS have a
                    // matching entry in the CUSTOM ACTIONS array...
                    // =========================================================

                    // ---------------------------------------------------------
                    // Here we should have (eg):-
                    //
                    //      $custom_record_action_indices_by_slug = Array(
                    //          select-dirs-files => [2]
                    //          )
                    //
                    // ---------------------------------------------------------

//pr( $custom_record_action_indices_by_slug , '$custom_record_action_indices_by_slug' ) ;

                    // ---------------------------------------------------------

                    foreach ( $custom_record_action_indices_by_slug as $record_action_slug => $record_action_index ) {

                        // ------------------------------------------------------

                        if ( ! array_key_exists( $record_action_slug , $custom_action_indices_by_slug ) ) {

                            $record_action_number = $record_action_index + 1 ;

                            $safe_record_action_slug = htmlentities( $record_action_slug ) ;

                            return <<<EOT
PROBLEM Displaying Dataset Records:&nbsp; Bad "dataset_records_table" + record action# {$record_action_number} + "slug" ("{$safe_record_action_slug}" - dataset has NO matching "custom action")
For dataset:&nbsp; {$dataset_title}
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\get_dataset_records_table_data()
EOT;

                        }

                        // -----------------------------------------------------

                    }

                    // ---------------------------------------------------------

                }

                // =============================================================
                // Check/default the ACTION SEPARATOR...
                // =============================================================

                if ( isset( $selected_datasets_dmdd['dataset_records_table']['action_separator'] ) ) {

                    // ---------------------------------------------------------

                    if ( ! is_string( $selected_datasets_dmdd['dataset_records_table']['action_separator'] ) ) {

                        return <<<EOT
PROBLEM Displaying Dataset Records:&nbsp; Bad "dataset_records_table" + "action_separator" (not a string)
For dataset:&nbsp; {$dataset_title}
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\get_dataset_records_table_data()
EOT;

                    }

                    // ---------------------------------------------------------

                } else {

                    // ---------------------------------------------------------

                    $selected_datasets_dmdd['dataset_records_table']['action_separator'] = ' &nbsp; ' ;

                    // ---------------------------------------------------------

                }

                // =============================================================
                // Set this column's TABLE DATA for all the dataset records...
                // =============================================================

                foreach ( $dataset_records as $record_index => $record_data ) {

                    // -------------------------------------------------------------------------
                    // get_action_column_value_for_dataset_record(
                    //      $all_application_dataset_definitions            ,
                    //      $caller_apps_includes_dir                       ,
                    //      $question_front_end                             ,
                    //      $selected_datasets_dmdd                         ,
                    //      $dataset_records                                ,
                    //      $dataset_slug                                   ,
                    //      $dataset_title                                  ,
                    //      $array_storage_key_field_slug                   ,
                    //      $dataset_record_index                           ,
                    //      $dataset_record_data                            ,
                    //      $column_index                                   ,
                    //      $column_number                                  ,
                    //      $column_def                                     ,
                    //      &$custom_get_table_data_function_data           ,
                    //      &$question_delete_record_javascript_required
                    //      )
                    // - - - - - - - - - - - - - - - - - - - - - - - - - - -
                    // RETURNS
                    //      o   On SUCCESS!
                    //          - - - - - -
                    //          $column_value (HTML) STRING
                    //
                    //          And updates:-
                    //              $question_delete_record_javascript_required
                    //          to TRUE, if required.
                    //
                    //      o   On FAILURE!
                    //          - - - - - -
                    //          ARRAY( $error_message STRING )
                    // -------------------------------------------------------------------------

                    $column_value = get_action_column_value_for_dataset_record(
                                        $all_application_dataset_definitions            ,
                                        $caller_apps_includes_dir                       ,
                                        $question_front_end                             ,
                                        $selected_datasets_dmdd                         ,
                                        $dataset_records                                ,
                                        $dataset_slug                                   ,
                                        $dataset_title                                  ,
                                        $array_storage_key_field_slug                   ,
                                        $record_index                                   ,
                                        $record_data                                    ,
                                        $this_column_index                              ,
                                        $column_number                                  ,
                                        $this_column_def                                ,
                                        $custom_get_table_data_function_data            ,
                                        $question_delete_record_javascript_required
                                        ) ;

                    // ---------------------------------------------------------

                    if ( is_array( $column_value ) ) {
                        return $column_value[0] ;
                    }

                    // ---------------------------------------------------------

                    if ( array_key_exists( $record_index , $table_data ) ) {

                        $table_data[ $record_index ][ $this_column_def['data_field_slug_to_display'] ] = $column_value ;

                    } else {

                        $table_data[ $record_index ] = array(
                            $this_column_def['data_field_slug_to_display'] => $column_value
                            ) ;

                    }

                    // ---------------------------------------------------------

                }

                // -------------------------------------------------------------

            } else {

                // :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
                // UNRECOGNISED / UNSUPPORTED "SPECIAL_TYPE"...
                // :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

                $safe_instance = htmlentities( $this_column_def['raw_value_from']['instance'] ) ;

                return <<<EOT
PROBLEM Displaying Dataset Records:&nbsp; Unrecognised/unsupported "dataset_records_table" + "column_defs" + "raw_value_from" + (special-type) "instance" + "{$safe_instance}" - for column# {$column_number}
For dataset:&nbsp; {$dataset_title}
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\get_dataset_records_table_data()
EOT;

                // -------------------------------------------------------------

            }

            // ------------------------------------------------------------------

        } elseif ( $this_column_def['raw_value_from']['method'] === 'foreign-field' ) {

            // =================================================================
            // FOREIGN-FIELD
            // =================================================================

            // -------------------------------------------------------------
            // Here we should have (eg):-
            //
            //      $this_column_def['raw_value_from'] = array(
            //          'method'    =>  'foreign-field'             ,
            //          'instance'  =>  "<target-field-name>"       ,
            //          'args'      =>  array(
            //                              array(
            //                                  'pointer_field_array_storage_slug'  =>  '<pointer_field_slug>'  ,
            //                                  'foreign_dataset'                   =>  '<dataset_slug>'
            //                                  )   ,
            //                              ...
            //                              )
            //          )
            //
            // -----------------------------------------------------------------

            if (    ! is_string( $this_column_def['raw_value_from']['instance'] )
                    ||
                    trim( $this_column_def['raw_value_from']['instance'] ) === ''
                    ||
                    ! \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_stringUtils\ctype_varname( $this_column_def['raw_value_from']['instance'] )
                    ||
                    strlen( $this_column_def['raw_value_from']['instance'] ) > 64
                ) {

                return <<<EOT
PROBLEM Displaying Dataset Records:&nbsp; Bad "dataset_records_table" + "column_defs" + "raw_value_from" + (foreign-field) "instance" - for column# {$column_number} (max. 64 character, variable-name like string required)
For dataset:&nbsp; {$dataset_title}
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\get_dataset_records_table_data()
EOT;

            }

            // ------------------------------------------------------------------

            if ( ! is_array( $this_column_def['raw_value_from']['args'] ) ) {

                return <<<EOT
PROBLEM Displaying Dataset Records:&nbsp; Bad "dataset_records_table" + "column_defs" + "raw_value_from" + (foreign-field) "args" - for column# {$column_number} (array required)
For dataset:&nbsp; {$dataset_title}
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\get_dataset_records_table_data()
EOT;

            }

            // ------------------------------------------------------------------

            $target_array_storage_field_slug =
                $this_column_def['raw_value_from']['instance']
                ;

            // ------------------------------------------------------------------

            $records_to_traverse =
                $this_column_def['raw_value_from']['args']
                ;

            // =================================================================
            // Get this field's TABLE DATA for all the dataset records...
            // =================================================================

            foreach ( $dataset_records as $record_index => $record_data ) {

                // =============================================================
                // GET the RAW FIELD VALUE...
                // =============================================================

                // -------------------------------------------------------------------------
                // get_foreign_field_value(
                //      $start_record_data                      ,
                //      $records_to_traverse                    ,
                //      $target_array_storage_field_slug        ,
                //      &$loaded_datasets                       ,
                //      $all_application_dataset_definitions    ,
                //      $caller_apps_includes_dir               ,
                //      &$custom_get_table_data_function_data
                //      )
                // - - - - - - - - - - - - - - - - - - - - -
                // Returns the specified foreign field value.
                //
                // $records_to_traverse is like (eg):-
                //
                //      $records_to_traverse = array(
                //  //      <array-storage-field-slug-in-current-record>    =>  <dataset-slug-to-go-to>
                //          'category_key'                                  =>  'categories'
                //          'project_key'                                   =>  'projects'
                //          )
                //
                // $loaded_datasets is like (eg):-
                //
                //      $loaded_datasets = array(
                //
                //          <dataset_slug>  =>  array(
                //                                  'title'                 =>  "xxx"           ,
                //                                  'records'               =>  array(...)      ,
                //                                  'key_field_slug'        =>  "xxx" or NULL
                //                                  'record_indices_by_key' =>  array(...)
                //                                  )   ,
                //
                //          ...
                //
                //          )
                //
                // RETURNS
                //      o   array(
                //              $ok = TRUE              ,
                //              $foreign_field_value        //  (any PHP type)
                //              ) on SUCCESS
                //      o   array(
                //              $ok = FALSE             ,
                //              $error_message STRING
                //              ) on FAILURE
                // -------------------------------------------------------------------------

                $result = get_foreign_field_value(
                                $record_data                            ,
                                $records_to_traverse                    ,
                                $target_array_storage_field_slug        ,
                                $loaded_datasets                        ,
                                $all_application_dataset_definitions    ,
                                $caller_apps_includes_dir               ,
                                $custom_get_table_data_function_data
                                ) ;

                // -------------------------------------------------------------

                list( $ok , $raw_field_value ) = $result ;

                // -------------------------------------------------------------

                if ( $ok !== TRUE ) {
                    return $raw_field_value ;
                }

                // =============================================================
                // SAVE the "DISPLAY" VALUE...
                // =============================================================

                $display_value = $raw_field_value ;

                // -------------------------------------------------------------------------
                // apply_display_treatments_to_field_value(
                //      $all_application_dataset_definitions    ,
                //      $selected_datasets_dmdd                 ,
                //      $dataset_records                        ,
                //      $dataset_slug                           ,
                //      $dataset_title                          ,
                //      $question_front_end                     ,
                //      $caller_apps_includes_dir               ,
                //      $this_column_def_index                  ,
                //      $this_column_def                        ,
                //      $this_dataset_record_index              ,
                //      $this_dataset_record_data               ,
                //      &$custom_get_table_data_function_data   ,
                //      &$field_value
                //      )
                // - - - - - - - - - - - - - - - - - - - - - - -
                // Applies the specified "treatments" to the current field's value...
                //
                // RETURNS
                //      o   On SUCCESS!
                //          - - - - - -
                //          TRUE
                //
                //      o   On FAILURE!
                //          - - - - - -
                //          $error_message STRING
                // -------------------------------------------------------------------------

                $result = apply_display_treatments_to_field_value(
                                $all_application_dataset_definitions    ,
                                $selected_datasets_dmdd                 ,
                                $dataset_records                        ,
                                $dataset_slug                           ,
                                $dataset_title                          ,
                                $question_front_end                     ,
                                $caller_apps_includes_dir               ,
                                $this_column_index                      ,
                                $this_column_def                        ,
                                $record_index                           ,
                                $record_data                            ,
                                $custom_get_table_data_function_data    ,
                                $display_value
                                ) ;

                // -------------------------------------------------------------

                if ( is_string( $result ) ) {
                    return $result ;
                }

                // -------------------------------------------------------------

                if ( array_key_exists( $record_index , $table_data ) ) {

                    $table_data[ $record_index ][ $this_column_def['data_field_slug_to_display'] ] = $display_value ;

                } else {

                    $table_data[ $record_index ] = array(
                        $this_column_def['data_field_slug_to_display'] => $display_value
                        ) ;

                }

                // =============================================================
                // SAVE the "SORT" VALUE (if there is one)...
                // =============================================================

                if ( $this_column_def['question_sortable'] ) {

                    // ---------------------------------------------------------

                    $sort_value = $raw_field_value ;

//                  // -------------------------------------------------------------------------
//                  // apply_sort_treatments_to_field_value(
//                  //      $all_application_dataset_definitions    ,
//                  //      $selected_datasets_dmdd                 ,
//                  //      $dataset_records                        ,
//                  //      $dataset_slug                           ,
//                  //      $dataset_title                          ,
//                  //      $question_front_end                     ,
//                  //      $caller_apps_includes_dir               ,
//                  //      $this_column_def_index                  ,
//                  //      $this_column_def                        ,
//                  //      $this_dataset_record_index              ,
//                  //      $this_dataset_record_data               ,
//                  //      &$custom_get_table_data_function_data   ,
//                  //      &$field_value
//                  //      )
//                  // - - - - - - - - - - - - - - - - - - - - - - -
//                  // Applies the specified "treatments" to the current field's value...
//                  //
//                  // RETURNS
//                  //      o   On SUCCESS!
//                  //          - - - - - -
//                  //          TRUE
//                  //
//                  //      o   On FAILURE!
//                  //          - - - - - -
//                  //          $error_message STRING
//                  // -------------------------------------------------------------------------
//
//                  $result = apply_sort_treatments_to_field_value(
//                                  $all_application_dataset_definitions    ,
//                                  $selected_datasets_dmdd                 ,
//                                  $dataset_records                        ,
//                                  $dataset_slug                           ,
//                                  $dataset_title                          ,
//                                  $question_front_end                     ,
//                                  $caller_apps_includes_dir               ,
//                                  $this_column_index                      ,
//                                  $this_column_def                        ,
//                                  $record_index                           ,
//                                  $record_data                            ,
//                                  $custom_get_table_data_function_data    ,
//                                  $sort_value
//                                  ) ;
//
//                  // ---------------------------------------------------------
//
//                  if ( is_string( $result ) ) {
//                      return $result ;
//                  }

                    // ---------------------------------------------------------

                    if ( $data_for === 'wp-list-table' ) {

                        // -----------------------------------------------------

                        if ( array_key_exists( $record_index , $table_data ) ) {

                            $table_data[ $record_index ][ $this_column_def['data_field_slug_to_sort_by'] ] = $sort_value ;

                        } else {

                            $table_data[ $record_index ] = array(
                                $this_column_def['data_field_slug_to_sort_by'] => $sort_value
                                ) ;

                        }

                        // -----------------------------------------------------

                    } elseif ( $data_for === 'dhtmlx-grid' ) {

                        // -----------------------------------------------------
                        // $sort_data is like (eg):-
                        //
                        //      $sort_data = array(
                        //          '<sort_field_slug_1>'   =>  array(...values_1...)
                        //          '<sort_field_slug_2>'   =>  array(...values_2...)
                        //          ...
                        //          '<sort_field_slug_3>'   =>  array(...values_3...)
                        //          )
                        //
                        // NOTE!
                        // =====
                        // When adding the values, we DON'T add duplicates.
                        // -----------------------------------------------------

                        if ( array_key_exists(
                                $this_column_def['data_field_slug_to_sort_by']  ,
                                $sort_data
                                )
                            ) {

                            if ( ! in_array(    $sort_value                                                     ,
                                                $sort_data[ $this_column_def['data_field_slug_to_sort_by'] ]    ,
                                                TRUE
                                                )
                                ) {
                                $sort_data[ $this_column_def['data_field_slug_to_sort_by'] ][] = $sort_value ;
                            }

                        } else {

                            $sort_data[ $this_column_def['data_field_slug_to_sort_by'] ] = array(
                                $sort_value
                                ) ;

                        }

                        // -----------------------------------------------------

                    }

                    // ---------------------------------------------------------

                }

                // =============================================================
                // Repeat with the NEXT RECORD (if there is one)...
                // =============================================================

            }

            // ------------------------------------------------------------------

        } elseif ( $this_column_def['raw_value_from']['method'] === 'custom-function' ) {

            // =================================================================
            // CUSTOM-FUNCTION
            // =================================================================

            // -------------------------------------------------------------
            // Here we should have (eg):-
            //
            //      $this_column_def['raw_value_from'] = array(
            //          'method'    =>  'custom-function'                                               ,
            //          'instance'  =>  "function-name-including-namespace-prefix-if-there-is-one>"     ,
            //          'args'      =>  array()
            //          )
            //
            // -----------------------------------------------------------------

            // -----------------------------------------------------------------
            // instance ?
            // -----------------------------------------------------------------

            if ( ! array_key_exists( 'instance' , $this_column_def['raw_value_from'] ) ) {

                return <<<EOT
PROBLEM:&nbsp; No "dataset_records_table" + "column_defs" + "raw_value_from" + (custom-function) "instance" - for column# {$column_number}
For dataset:&nbsp; {$dataset_title}
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\get_dataset_records_table_data()
EOT;

            }

            // -----------------------------------------------------------------

            if (    ! is_string( $this_column_def['raw_value_from']['instance'] )
                    ||
                    trim( $this_column_def['raw_value_from']['instance'] ) === ''
                    ||
                    strlen( $this_column_def['raw_value_from']['instance'] ) > 512
                ) {

                return <<<EOT
PROBLEM:&nbsp; Bad "dataset_records_table" + "column_defs" + "raw_value_from" + (custom-function) "instance" - for column# {$column_number} (1 to 512 character string required)
For dataset:&nbsp; {$dataset_title}
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\get_dataset_records_table_data()
EOT;

            }

            // -----------------------------------------------------------------

            if ( ! function_exists( $this_column_def['raw_value_from']['instance'] ) ) {

                return <<<EOT
PROBLEM:&nbsp; Bad "dataset_records_table" + "column_defs" + "raw_value_from" + (custom-function) "instance" - for column# {$column_number} (no such function)
For dataset:&nbsp; {$dataset_title}
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\get_dataset_records_table_data()
EOT;

            }

            // =================================================================
            // Get this column's TABLE DATA for all the dataset records...
            // =================================================================

            foreach ( $dataset_records as $record_index => $record_data ) {

                // =============================================================
                // GET THE RAW FIELD VALUE...
                // =============================================================

                // -------------------------------------------------------------------------
                // <my_custom_get_dataset_record_column_value_function>(
                //      $all_application_dataset_definitions    ,
                //      $selected_datasets_dmdd                 ,
                //      $dataset_records                        ,
                //      $dataset_slug                           ,
                //      $dataset_title                          ,
                //      $question_front_end                     ,
                //      $caller_apps_includes_dir               ,
                //      $this_column_def_index                  ,
                //      $this_column_def                        ,
                //      $this_dataset_record_index              ,
                //      $this_dataset_record_data               ,
                //      &$custom_get_table_data_function_data   ,
                //      &$loaded_datasets
                //      )
                // - - - - - - - - - - - - - - - - - - - - - - - - - - -
                // Returns the specified column value...
                //
                // $loaded_datasets is like:-
                //
                //      $loaded_datasets = array(
                //
                //          <dataset_slug>  =>  array(
                //                                  'title'                 =>  "xxx"           ,
                //                                  'records'               =>  array(...)      ,
                //                                  'key_field_slug'        =>  "xxx" or NULL
                //                                  'record_indices_by_key' =>  array(...)
                //                                  )   ,
                //
                //          ...
                //
                //          )
                //
                // RETURNS
                //      o   On SUCCESS!
                //          - - - - - -
                //          $field_value STRING
                //
                //      o   On FAILURE!
                //          - - - - - -
                //          array( $error_message STRING )
                // -------------------------------------------------------------------------

                $raw_field_value = $this_column_def['raw_value_from']['instance'](
                                        $all_application_dataset_definitions    ,
                                        $selected_datasets_dmdd                 ,
                                        $dataset_records                        ,
                                        $dataset_slug                           ,
                                        $dataset_title                          ,
                                        $question_front_end                     ,
                                        $caller_apps_includes_dir               ,
                                        $this_column_index                      ,
                                        $this_column_def                        ,
                                        $record_index                           ,
                                        $record_data                            ,
                                        $custom_get_table_data_function_data    ,
                                        $loaded_datasets
                                        ) ;

                // -------------------------------------------------------------

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $raw_field_value ) ;

                if ( is_array( $raw_field_value ) ) {
                    return $raw_field_value[0] ;
                }

                // =============================================================
                // SAVE THE "DISPLAY" VALUE
                // =============================================================

                $display_value = $raw_field_value ;

                // -------------------------------------------------------------------------
                // apply_display_treatments_to_field_value(
                //      $all_application_dataset_definitions    ,
                //      $selected_datasets_dmdd                 ,
                //      $dataset_records                        ,
                //      $dataset_slug                           ,
                //      $dataset_title                          ,
                //      $question_front_end                     ,
                //      $caller_apps_includes_dir               ,
                //      $this_column_def_index                  ,
                //      $this_column_def                        ,
                //      $this_dataset_record_index              ,
                //      $this_dataset_record_data               ,
                //      &$custom_get_table_data_function_data   ,
                //      &$field_value
                //      )
                // - - - - - - - - - - - - - - - - - - - - - - -
                // Applies the specified "treatments" to the current field's value...
                //
                // RETURNS
                //      o   On SUCCESS!
                //          - - - - - -
                //          TRUE
                //
                //      o   On FAILURE!
                //          - - - - - -
                //          $error_message STRING
                // -------------------------------------------------------------------------

                $result = apply_display_treatments_to_field_value(
                                $all_application_dataset_definitions    ,
                                $selected_datasets_dmdd                 ,
                                $dataset_records                        ,
                                $dataset_slug                           ,
                                $dataset_title                          ,
                                $question_front_end                     ,
                                $caller_apps_includes_dir               ,
                                $this_column_index                      ,
                                $this_column_def                        ,
                                $record_index                           ,
                                $record_data                            ,
                                $custom_get_table_data_function_data    ,
                                $display_value
                                ) ;

                // -------------------------------------------------------------

                if ( is_string( $result ) ) {
                    return $result ;
                }

                // -------------------------------------------------------------

                if ( array_key_exists( $record_index , $table_data ) ) {

                    $table_data[ $record_index ][ $this_column_def['data_field_slug_to_display'] ] = $display_value ;

                } else {

                    $table_data[ $record_index ] = array(
                        $this_column_def['data_field_slug_to_display'] => $display_value
                        ) ;

                }

                // =============================================================
                // SAVE THE "SORT" VALUE (if there is one)...
                // =============================================================

                if ( $this_column_def['question_sortable'] ) {

                    // ---------------------------------------------------------

                    $sort_value = $raw_field_value ;

//                  // -------------------------------------------------------------------------
//                  // apply_sort_treatments_to_field_value(
//                  //      $all_application_dataset_definitions    ,
//                  //      $selected_datasets_dmdd                 ,
//                  //      $dataset_records                        ,
//                  //      $dataset_slug                           ,
//                  //      $dataset_title                          ,
//                  //      $question_front_end                     ,
//                  //      $caller_apps_includes_dir               ,
//                  //      $this_column_def_index                  ,
//                  //      $this_column_def                        ,
//                  //      $this_dataset_record_index              ,
//                  //      $this_dataset_record_data               ,
//                  //      &$custom_get_table_data_function_data   ,
//                  //      &$field_value
//                  //      )
//                  // - - - - - - - - - - - - - - - - - - - - - - -
//                  // Applies the specified "treatments" to the current field's value...
//                  //
//                  // RETURNS
//                  //      o   On SUCCESS!
//                  //          - - - - - -
//                  //          TRUE
//                  //
//                  //      o   On FAILURE!
//                  //          - - - - - -
//                  //          $error_message STRING
//                  // -------------------------------------------------------------------------
//
//                  $result = apply_sort_treatments_to_field_value(
//                                  $all_application_dataset_definitions    ,
//                                  $selected_datasets_dmdd                 ,
//                                  $dataset_records                        ,
//                                  $dataset_slug                           ,
//                                  $dataset_title                          ,
//                                  $question_front_end                     ,
//                                  $caller_apps_includes_dir               ,
//                                  $this_column_index                      ,
//                                  $this_column_def                        ,
//                                  $record_index                           ,
//                                  $record_data                            ,
//                                  $custom_get_table_data_function_data    ,
//                                  $sort_value
//                                  ) ;
//
//                  // ---------------------------------------------------------
//
//                  if ( is_string( $result ) ) {
//                      return $result ;
//                  }

                    // ---------------------------------------------------------

                    if ( $data_for === 'wp-list-table' ) {

                        // -----------------------------------------------------

                        if ( array_key_exists( $record_index , $table_data ) ) {

                            $table_data[ $record_index ][ $this_column_def['data_field_slug_to_sort_by'] ] = $sort_value ;

                        } else {

                            $table_data[ $record_index ] = array(
                                $this_column_def['data_field_slug_to_sort_by'] => $sort_value
                                ) ;

                        }

                        // -----------------------------------------------------

                    } elseif ( $data_for === 'dhtmlx-grid' ) {

                        // -----------------------------------------------------
                        // $sort_data is like (eg):-
                        //
                        //      $sort_data = array(
                        //          '<sort_field_slug_1>'   =>  array(...values_1...)
                        //          '<sort_field_slug_2>'   =>  array(...values_2...)
                        //          ...
                        //          '<sort_field_slug_3>'   =>  array(...values_3...)
                        //          )
                        //
                        // NOTE!
                        // =====
                        // When adding the values, we DON'T add duplicates.
                        // -----------------------------------------------------

                        if ( array_key_exists(
                                $this_column_def['data_field_slug_to_sort_by']  ,
                                $sort_data
                                )
                            ) {

                            if ( ! in_array(    $sort_value                                                     ,
                                                $sort_data[ $this_column_def['data_field_slug_to_sort_by'] ]    ,
                                                TRUE
                                                )
                                ) {
                                $sort_data[ $this_column_def['data_field_slug_to_sort_by'] ][] = $sort_value ;
                            }

                        } else {

                            $sort_data[ $this_column_def['data_field_slug_to_sort_by'] ] = array(
                                $sort_value
                                ) ;

                        }

                        // -----------------------------------------------------

                    }

                    // ---------------------------------------------------------

                }

                // =============================================================
                // Repeat with the NEXT RECORD (if there is one)...
                // =============================================================

            }

            // -----------------------------------------------------------------

        } else {

            // =============================================================
            // ERROR
            // =============================================================

            $method = htmlentities( $this_column_def['raw_value_from']['method'] ) ;

            return <<<EOT
PROBLEM Displaying Dataset Records:&nbsp; Unrecognised/unsupported "dataset_records_table" + "column_defs" + "raw_value_from" + "method" ("{$method}") - for column# {$column_number}
For dataset:&nbsp; {$dataset_title}
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\get_dataset_records_table_data()
EOT;

            // ------------------------------------------------------------------

        }

        // =====================================================================
        // This data field is available for column sorting...
        // =====================================================================

        $data_field_slugs_for_column_sorting[] = $this_column_def['base_slug'] ;

        // =====================================================================
        // Repeat with the NEXT Dataset Records Table data FIELD (if there is
        // one)...
        // =====================================================================

    }

    // =========================================================================
    // Run the TABLE DATA CUSTOMISATION function (if there is one)...
    // =========================================================================

    // -------------------------------------------------------------------------
    // Here we might have (eg):-
    //
    //      $selected_datasets_dmdd['dataset_records_table']['table_data_customisation'] = array(
    //          'function_name'     =>  "xxx"
    //          'extra_args'        =>  NULL | FALSE | array() | array(...)
    //          )
    //
    // -------------------------------------------------------------------------

    if (    array_key_exists( 'table_data_customisation' , $selected_datasets_dmdd['dataset_records_table'] )
            &&
            is_array( $selected_datasets_dmdd['dataset_records_table']['table_data_customisation'] )
            &&
            count( $selected_datasets_dmdd['dataset_records_table']['table_data_customisation'] ) > 0
        ) {

        // ---------------------------------------------------------------------
        // function_name ?
        // ---------------------------------------------------------------------

        if ( ! array_key_exists( 'function_name' , $selected_datasets_dmdd['dataset_records_table']['table_data_customisation'] ) ) {

            return <<<EOT
PROBLEM:&nbsp; No "dataset_records_table" + "table_data_customisation" + "function_name"
For dataset:&nbsp; {$dataset_title}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        }

        // ---------------------------------------------------------------------

        if (    ! is_string( $selected_datasets_dmdd['dataset_records_table']['table_data_customisation']['function_name'] )
                ||
                trim( $selected_datasets_dmdd['dataset_records_table']['table_data_customisation']['function_name'] ) === ''
            ) {

            return <<<EOT
PROBLEM:&nbsp; Bad "dataset_records_table" + "table_data_customisation" + "function_name" (non-empty string expected)
For dataset:&nbsp; {$dataset_title}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        }

        // ---------------------------------------------------------------------

        if ( ! function_exists( $selected_datasets_dmdd['dataset_records_table']['table_data_customisation']['function_name'] ) ) {

            return <<<EOT
PROBLEM:&nbsp; Bad "dataset_records_table" + "table_data_customisation" + "function_name" (function not found)
For dataset:&nbsp; {$dataset_title}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        }

        // ---------------------------------------------------------------------
        // extra_args ?
        // ---------------------------------------------------------------------

        if (    array_key_exists( 'extra_args' , $selected_datasets_dmdd['dataset_records_table']['table_data_customisation'] )
                &&
                is_array( $selected_datasets_dmdd['dataset_records_table']['table_data_customisation']['extra_args'] )
            ) {
            $extra_args = $selected_datasets_dmdd['dataset_records_table']['table_data_customisation']['extra_args'] ;

        } else {
            $extra_args = array() ;

        }

        // -------------------------------------------------------------------------
        // <my-table-data-customisation-function>(
        //      $all_application_dataset_definitions    ,
        //      $selected_datasets_dmdd                 ,
        //      $dataset_records                        ,
        //      $dataset_slug                           ,
        //      $dataset_title                          ,
        //      $question_front_end                     ,
        //      $caller_apps_includes_dir               ,
        //      $data_for                               ,
        //      $loaded_datasets                        ,
        //      &$custom_get_table_data_function_data   ,
        //      &$table_data                            ,
        //      &$sort_data                             ,
        //      &$data_field_slugs_for_column_sorting
        //      )
        // - - - - - - - - - - - - - - - - - - - - - - -
        // Allows you to update any of the following:-
        //      o   $custom_get_table_data_function_data
        //      o   $table_data
        //      o   $sort_data
        //      o   $data_field_slugs_for_column_sorting
        //
        // as required.
        //
        // ---
        //
        // On ENTRY, the $table_data rows will match the $dataset_records rows ONE
        // FOR ONE.  With $table_data having the record info to be displayed in the
        // Dataset Records Table columns.
        //
        // So now you can add new rows, delete old rows, or re-arrange the
        // $table_data rows as reuired.
        //
        // Say you had a "Posts" dataset, that listed a bunch of "posts" that acted
        // very much like WordPress "posts".  Eg:-
        //
        //     $table_data = array(
        //         array(
        //             'title' =>  'Woochester City Gardens'   ,
        //             'text'  =>  "xxx"                       ,
        //             ...
        //             )
        //         array(
        //             'title' =>  'Shifting House'    ,
        //             'text'  =>  "xxx"               ,
        //             ...
        //             )
        //         ...
        //         )
        //
        // And you wanted to display these posts by category.  Eg:-
        //
        //     o   Home Stuff
        //             Shifting House
        //             ...
        //     o   Photography
        //             Woochester City Gardens
        //             ...
        //     o   ...
        //
        // Then this CUSTOM TABLE DATA routine might re-arrange and add to the input
        // $table_data rows as follows:-
        //
        //     $table_data = array(
        //         array(
        //             'title' =>  'HOME STUFF'        ,
        //             'text'  =>  "xxx"               ,
        //             ...
        //             )
        //         array(
        //             'title' =>  '>>> Shifting House'    ,
        //             'text'  =>  "xxx"                   ,
        //             ...
        //             )
        //         ...
        //         array(
        //             'title' =>  'PHOTOGRAPHY'       ,
        //             'text'  =>  "xxx"               ,
        //             ...
        //             )
        //         array(
        //             'title' =>  '>>> Woochester City Gardens'   ,
        //             'text'  =>  "xxx"                           ,
        //             ...
        //             )
        //         ...
        //         )
        //
        // NOTES!
        // ------
        // 1.   $data_for = "wp-list-table" | "dhtmlx-grid"
        //
        // 2.   The field names in $dataset_table are the ARRAY STORAGE field
        //      names
        //
        //      The field names in $table_data are the Dataset Records Table
        //      COLUMN names.
        //
        // 3.   $sort_data is only used if $data_for = "dhtmlx-grid".  For
        //      $data_for = "wp-list-table", "$sort_data is the EMPRY array.
        //
        // RETURNS
        //      o   On SUCCESS
        //              TRUE
        //
        //      o   On FAILURE
        //              $error_message STRING
        // -------------------------------------------------------------------------

        $result = $selected_datasets_dmdd['dataset_records_table']['table_data_customisation']['function_name'](
                        $all_application_dataset_definitions    ,
                        $selected_datasets_dmdd                 ,
                        $dataset_records                        ,
                        $dataset_slug                           ,
                        $dataset_title                          ,
                        $question_front_end                     ,
                        $caller_apps_includes_dir               ,
                        $data_for                               ,
                        $loaded_datasets                        ,
                        $custom_get_table_data_function_data    ,
                        $table_data                             ,
                        $sort_data                              ,
                        $data_field_slugs_for_column_sorting
                        ) ;

        // ---------------------------------------------------------------------

        if ( is_string( $result ) ) {
            return $result ;
        }

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // CREATE the SUPPORT JAVASCRIPT (if required)...
    // =========================================================================

    $support_javascript = '' ;

    // -------------------------------------------------------------------------
    // Delete Record Support ?
    // -------------------------------------------------------------------------

    if ( $question_delete_record_javascript_required === TRUE ) {

        // ---------------------------------------------------------------------

        if ( $question_front_end ) {

            // -----------------------------------------------------------------

            require_once( $caller_apps_includes_dir . '/url-utils.php' ) ;

            // -------------------------------------------------------------------------
            // \greatKiwi_urlUtils\get_query_adjusted_current_page_url(
            //      $query_changes = array()        ,
            //      $question_amp = FALSE           ,
            //      $question_die_on_error = FALSE
            //      ) ;
            // - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
            // Attempts to retrieve the current page URL from $_SERVER.
            //
            // If successful, returns the URL with the query part adjusted as
            // requested.
            //
            // RETURNS
            //      o   On SUCCESS!
            //          -----------
            //          $query_adjusted_current_page_url STRING
            //
            //      o   On FAILURE!
            //          -----------
            //          If $question_die_on_error = TRUE
            //              Doesn't return
            //          If $question_die_on_error = FALSE
            //              array( $error_message STRING )
            // -------------------------------------------------------------------------

            $query_changes = array(
                                'action'        =>  'delete-record'                 ,
                                'dataset_slug'  =>  '_DATASET_SLUG_GOES_HERE_'      ,
                                'record_key'    =>  '_RECORD_KEY_GOES_HERE_'
                                ) ;

            // -----------------------------------------------------------------

            if (    isset( $_GET['application'] )
                    &&
                    trim( $_GET['application'] ) !== ''
                    &&
                    strlen( $_GET['application'] ) <= 64
                    &&
                    \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_stringUtils\ctype_alphanumeric_underscore_dash( $_GET['application'] )
                ) {
                $query_changes['application'] = $_GET['application'] ;

            } else {
                $query_changes['application'] = NULL ;

            }

            // -----------------------------------------------------------------

            $question_amp = FALSE ;

            $question_die_on_error = FALSE ;

            $base_href = \greatKiwi_urlUtils\get_query_adjusted_current_page_url(
                            $query_changes              ,
                            $question_amp               ,
                            $question_die_on_error
                            ) ;

            if ( is_array( $base_href ) ) {
                return $base_href[0] ;
            }

            // -----------------------------------------------------------------

        } else {

            // -----------------------------------------------------------------

            if (    isset( $_GET['application'] )
                    &&
                    trim( $_GET['application'] ) !== ''
                    &&
                    strlen( $_GET['application'] ) <= 64
                    &&
                    \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_stringUtils\ctype_alphanumeric_underscore_dash( $_GET['application'] )
                ) {
                $application = '&application=' . $_GET['application'] ;

            } else {
                $application = '' ;

            }

            // -----------------------------------------------------------------

            $base_href = admin_url() . <<<EOT
/admin.php?page={$_GET['page']}&action=delete-record{$application}&dataset_slug=_DATASET_SLUG_GOES_HERE_&record_key=_RECORD_KEY_GOES_HERE_
EOT;

            // -----------------------------------------------------------------

        }

        // ---------------------------------------------------------------------

        require_once( $caller_apps_includes_dir . '/path-utils.php' ) ;

        // -------------------------------------------------------------------------
        // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_pathUtils\wp_path2url(
        //      $path
        //      )
        // - - - - - -
        // RETURNS:-
        //      o   $url on SUCCESS
        //      o   array( $error_message ) on FAILURE
        // -------------------------------------------------------------------------

        $js_files_url = \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_pathUtils\wp_path2url(
                            dirname( __FILE__ ) . '/js'
                            ) ;

        // ---------------------------------------------------------------------

        if ( is_array( $js_files_url ) ) {
            return $js_files_url[0] ;
        }

        // -------------------------------------------------------------------------
        // greatKiwi_datasetManager_question_delete_record_proper(
        //      a_el                    ,
        //      dataset_slug            ,
        //      record_key              ,
        //      question_front_end      ,
        //      base_href
        //      )
        // - - - - - - - - - - - - - - - - - - - - - - - - - - - -
        // Pops up a "DELETE this record, ARE YOU SURE?" box - and calls the
        // specified "base_href" to selected the specified record if the user
        // answers Yes.
        //
        // "base_href" is like (eg):-
        //      http://www.thissite.com/[XXX]&dataset_slug=_DATASET_SLUG_GOES_HERE_[&YYY]&record_key=_RECORD_KEY_GOES_HERE_[&ZZZ]
        // -------------------------------------------------------------------------

        if ( $question_front_end ) {
            $question_front_end_js = 'true' ;
        } else {
            $question_front_end_js = 'false' ;
        }

        // ---------------------------------------------------------------------

        $support_javascript = <<<EOT
<script type="text/javascript" src="{$js_files_url}/common.js"></script>
<script type="text/javascript" src="{$js_files_url}/delete-record.js"></script>
<script type="text/javascript">
    function greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager_questionDeleteRecord(
        a_el        ,
        record_key
        ) {
        // ---------------------------------------------------------------------
        greatKiwi_datasetManager_question_delete_record_proper(
            a_el                        ,
            '{$_GET['dataset_slug']}'   ,
            record_key                  ,
            {$question_front_end_js}    ,
            '{$base_href}'
            ) ;
        // ---------------------------------------------------------------------
    }
</script>
EOT;

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // SUCCESS!
    // =========================================================================

//pr( $table_data ) ;

//pr( $sort_data ) ;

    if ( $data_for === 'wp-list-table' ) {

        return array(
                    $table_data                             ,
                    $data_field_slugs_for_column_sorting    ,
                    $support_javascript
                    ) ;

    } elseif ( $data_for === 'dhtmlx-grid' ) {

        return array(
                    $table_data                             ,
                    $sort_data                              ,
                    $data_field_slugs_for_column_sorting    ,
                    $support_javascript
                    ) ;

    }

    // =========================================================================
    // That's that!
    // =========================================================================

}

// =============================================================================
// get_foreign_field_value()
// =============================================================================

function get_foreign_field_value(
    $start_record_data                      ,
    $records_to_traverse                    ,
    $target_array_storage_field_slug        ,
    &$loaded_datasets                       ,
    $all_application_dataset_definitions    ,
    $caller_apps_includes_dir               ,
    &$custom_get_table_data_function_data
    ) {

    // -------------------------------------------------------------------------
    // get_foreign_field_value(
    //      $start_record_data                      ,
    //      $records_to_traverse                    ,
    //      $target_array_storage_field_slug        ,
    //      &$loaded_datasets                       ,
    //      $all_application_dataset_definitions    ,
    //      $caller_apps_includes_dir               ,
    //      &$custom_get_table_data_function_data
    //      )
    // - - - - - - - - - - - - - - - - - - - - -
    // Returns the specified foreign field value.
    //
    // $records_to_traverse is like (eg):-
    //
    //      $records_to_traverse = array(
    //          [0] => Array(
    //                  [pointer_field_array_storage_slug] => parent_key
    //                  [foreign_dataset]                  => categories
    //                  )   ,
    //          [1] => Array(
    //                  [pointer_field_array_storage_slug] => parent_key
    //                  [foreign_dataset]                  => projects
    //                  )
    //          )
    //
    // $loaded_datasets is like (eg):-
    //
    //      $loaded_datasets = array(
    //
    //          <dataset_slug>  =>  array(
    //                                  'title'                 =>  "xxx"           ,
    //                                  'records'               =>  array(...)      ,
    //                                  'key_field_slug'        =>  "xxx" or NULL
    //                                  'record_indices_by_key' =>  array(...)
    //                                  )   ,
    //
    //          ...
    //
    //          )
    //
    // RETURNS
    //      o   array(
    //              $ok = TRUE              ,
    //              $foreign_field_value        //  (any PHP type)
    //              ) on SUCCESS
    //      o   array(
    //              $ok = FALSE             ,
    //              $error_message STRING
    //              ) on FAILURE
    // -------------------------------------------------------------------------

    $success = TRUE  ;
    $failure = FALSE ;

    // -------------------------------------------------------------------------

    $current_record_data = $start_record_data ;

    // -------------------------------------------------------------------------

//pr( $records_to_traverse ) ;

    foreach ( $records_to_traverse as $this_record_to_traverse ) {

        // ---------------------------------------------------------------------
        // Here we should have (eg):-
        //
        //      $this_record_to_traverse = array(
        //          [pointer_field_array_storage_slug] => parent_key
        //          [foreign_dataset]                  => categories
        //          )
        //
        // ---------------------------------------------------------------------

        $array_storage_pointer_field_slug = $this_record_to_traverse['pointer_field_array_storage_slug'] ;

        $dataset_slug_to_goto = $this_record_to_traverse['foreign_dataset'] ;

        // ---------------------------------------------------------------------
        // Make sure that there's a:-
        //      $array_storage_pointer_field_slug
        //
        // field in the current record...
        // ---------------------------------------------------------------------

        if ( ! array_key_exists( $array_storage_pointer_field_slug , $current_record_data ) ) {

//pr( $array_storage_pointer_field_slug ) ;
//pr( $current_record_data ) ;

            $msg = <<<EOT
PROBLEM:&nbsp;&nbsp; Pointer field "{$array_storage_pointer_field_slug}" not found in current dataset record
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\get_foreign_field_value()
EOT;

            return array( $failure , $msg ) ;

        }

        // ---------------------------------------------------------------------
        // If the target dataset ISN'T in $loaded_datasets yet, then LOAD it...
        // ---------------------------------------------------------------------

        if ( ! array_key_exists( $dataset_slug_to_goto , $loaded_datasets ) ) {

            // -------------------------------------------------------------------------
            // load_dataset(
            //      $all_application_dataset_definitions    ,
            //      $caller_apps_includes_dir               ,
            //      &$loaded_datasets                       ,
            //      $dataset_slug                           ,
            //      $dataset_key_field_slug = NULL          ,
            //      $dataset_title          = NULL          ,
            //      $dataset_records        = NULL          ,
            //      $record_indices_by_key  = NULL
            //      )
            // - - - - - - - - - - - - - - - - - - - - - - -
            // Adds the specified dataset to $loaded_datasets (unless it's already
            // loaded).
            //
            // NOTE!
            // =====
            // 1.   Each of:-
            //          o   $dataset_key_field_slug
            //          o   $dataset_title
            //          o   $dataset_records
            //          o   $record_indices_by_key
            //
            //      is only loaded if it wasn't supplied on input.
            //
            // 2.   $loaded_datasets is like (eg):-
            //
            //          $loaded_datasets = array(
            //
            //              <dataset_slug>  =>  array(
            //                                      'title'                 =>  "xxx"           ,
            //                                      'records'               =>  array(...)      ,
            //                                      'key_field_slug'        =>  "xxx" or NULL
            //                                      'record_indices_by_key' =>  array(...)
            //                                      )   ,
            //
            //              ...
            //
            //              )
            //
            // RETURNS
            //      o   TRUE on SUCCESS
            //      o   $error_message STRING on FAILURE
            // -------------------------------------------------------------------------

            $dataset_key_field_slug = NULL ;
            $dataset_title          = NULL ;
            $dataset_records        = NULL ;
            $record_indices_by_key  = NULL ;

            // -----------------------------------------------------------------

            $result = load_dataset(
                            $all_application_dataset_definitions    ,
                            $caller_apps_includes_dir               ,
                            $loaded_datasets                        ,
                            $dataset_slug_to_goto                   ,
                            $dataset_key_field_slug                 ,
                            $dataset_title                          ,
                            $dataset_records                        ,
                            $record_indices_by_key
                            ) ;

            // -----------------------------------------------------------------

            if ( is_string( $result ) ) {
                return array( $failure , $result ) ;
            }

            // -----------------------------------------------------------------

        }

        // ---------------------------------------------------------------------
        // Get the target dataset's details...
        // ---------------------------------------------------------------------

        $target_dataset_details = $loaded_datasets[ $dataset_slug_to_goto ] ;

        // ---------------------------------------------------------------------
        // Here we should have (eg):-
        //
        //      $target_dataset_details = array(
        //          'title'                 =>  "xxx"           ,
        //          'records'               =>  array(...)      ,
        //          'key_field_slug'        =>  "xxx" or NULL
        //          'record_indices_by_key' =>  array(...)
        //          )
        //
        // ---------------------------------------------------------------------

        // ---------------------------------------------------------------------
        // Replace $current_record_data with the pointed to target dataset
        // record...
        // ---------------------------------------------------------------------

//pr( $loaded_datasets ) ;

        $target_record_key = $current_record_data[ $array_storage_pointer_field_slug ] ;

//pr( $target_record_key ) ;

        // ---------------------------------------------------------------------

        if ( ! array_key_exists(
                    $target_record_key                                  ,
                    $target_dataset_details['record_indices_by_key']
                    )
            ) {

            $msg = <<<EOT
PROBLEM:&nbsp; Target record not found - whilst searching for foreigh field value
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\get_foreign_field_value()
EOT;

            return array( $failure , $msg ) ;

        }

        // ---------------------------------------------------------------------

        $current_record_data = $target_dataset_details['records'][
                                    $target_dataset_details['record_indices_by_key'][ $target_record_key ]
                                    ] ;

        // ---------------------------------------------------------------------
        // Repeat with the next target dataset (if there is one)...
        // ---------------------------------------------------------------------

    }

    // -------------------------------------------------------------------------
    // Check that the target field exists, in the last retrieved record...
    // -------------------------------------------------------------------------

    if ( ! isset( $current_record_data[ $target_array_storage_field_slug ] ) ) {

        $target_array_storage_field_slug = htmlentities( $target_array_storage_field_slug ) ;

        $msg = <<<EOT
PROBLEM:&nbsp;&nbsp; Target dataset field "{$target_array_storage_field_slug}" not found (in target dataset record)
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\get_foreign_field_value()
EOT;

        return array( $failure , $msg ) ;

    }

    // -------------------------------------------------------------------------
    // SUCCESS!
    // -------------------------------------------------------------------------

    return  array(
                $success                                                    ,
                $current_record_data[ $target_array_storage_field_slug ]
                ) ;

    // =========================================================================
    // That's that!
    // =========================================================================

}


// =============================================================================
// load_dataset()
// =============================================================================

function load_dataset(
    $all_application_dataset_definitions    ,
    $caller_apps_includes_dir               ,
    &$loaded_datasets                       ,
    $dataset_slug                           ,
    $dataset_key_field_slug = NULL          ,
    $dataset_title          = NULL          ,
    $dataset_records        = NULL          ,
    $record_indices_by_key  = NULL
    ) {

    // -------------------------------------------------------------------------
    // load_dataset(
    //      $all_application_dataset_definitions    ,
    //      $caller_apps_includes_dir               ,
    //      &$loaded_datasets                       ,
    //      $dataset_slug                           ,
    //      $dataset_key_field_slug = NULL          ,
    //      $dataset_title          = NULL          ,
    //      $dataset_records        = NULL          ,
    //      $record_indices_by_key  = NULL
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - -
    // Adds the specified dataset to $loaded_datasets (unless it's already
    // loaded).
    //
    // NOTE!
    // =====
    // 1.   Each of:-
    //          o   $dataset_key_field_slug
    //          o   $dataset_title
    //          o   $dataset_records
    //          o   $record_indices_by_key
    //
    //      is only loaded if it wasn't supplied on input.
    //
    // 2.   $loaded_datasets is like (eg):-
    //
    //          $loaded_datasets = array(
    //
    //              <dataset_slug>  =>  array(
    //                                      'title'                 =>  "xxx"           ,
    //                                      'records'               =>  array(...)      ,
    //                                      'key_field_slug'        =>  "xxx" or NULL
    //                                      'record_indices_by_key' =>  array(...)
    //                                      )   ,
    //
    //              ...
    //
    //              )
    //
    // RETURNS
    //      o   TRUE on SUCCESS
    //      o   $error_message STRING on FAILURE
    // -------------------------------------------------------------------------

    // -------------------------------------------------------------------------
    // Already loaded ?
    // -------------------------------------------------------------------------

    if ( array_key_exists( $dataset_slug , $loaded_datasets ) ) {
        return TRUE ;
    }

    // -------------------------------------------------------------------------
    // Get the DATASET KEY FIELD SLUG (if necessary)...
    // -------------------------------------------------------------------------

    if (    ! is_string( $dataset_key_field_slug )
            ||
            trim( $dataset_key_field_slug ) === ''
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

        $dataset_key_field_slug = get_dataset_key_field_slug(
                                        $all_application_dataset_definitions    ,
                                        $dataset_slug
                                        ) ;

        // ---------------------------------------------------------------------

        if ( is_array( $dataset_key_field_slug ) ) {
            return $dataset_key_field_slug[0] ;
        }

        // ---------------------------------------------------------------------

     }

    // -------------------------------------------------------------------------
    // Get the DATASET TITLE (if necessary)...
    // -------------------------------------------------------------------------

    if (    ! is_string( $dataset_title )
            ||
            trim( $dataset_title ) === ''
        ) {
        $dataset_title = \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_stringUtils\to_title( $dataset_slug ) ;
    }

    // -------------------------------------------------------------------------
    // Get the DATASET RECORDS (if necessary)...
    // -------------------------------------------------------------------------

    if ( ! is_array( $dataset_records ) ) {

        // ---------------------------------------------------------------------

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
            return $dataset_records ;
        }

        // -------------------------------------------------------------------------

    }

    // -------------------------------------------------------------------------
    // Get the RECORD INDICES BY KEY (if necessary)...
    // -------------------------------------------------------------------------

    if ( ! is_array( $record_indices_by_key ) ) {

        // ---------------------------------------------------------------------

        require_once( dirname( __FILE__ ) . '/common.php' ) ;

        // -------------------------------------------------------------------------
        // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\get_dataset_record_indices_by_key(
        //      $dataset_title      ,
        //      $dataset_records    ,
        //      $key_field_slug
        //      )
        // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
        // RETURNS:-
        //      o   (array) $record_indices_by_id on SUCCESS
        //      o   (string) $error_message on FAILURE
        // -------------------------------------------------------------------------

        $record_indices_by_key = get_dataset_record_indices_by_key(
                                    $dataset_title              ,
                                    $dataset_records            ,
                                    $dataset_key_field_slug
                                    ) ;

        // ---------------------------------------------------------------------

        if ( is_string( $record_indices_by_key ) ) {
            return $record_indices_by_key ;
        }

        // ---------------------------------------------------------------------

    }

    // -------------------------------------------------------------------------
    // ADD the DATASET...
    // -------------------------------------------------------------------------

    $loaded_datasets[ $dataset_slug ] = array(
        'title'                 =>  $dataset_title              ,
        'records'               =>  $dataset_records            ,
        'key_field_slug'        =>  $dataset_key_field_slug     ,
        'record_indices_by_key' =>  $record_indices_by_key
        ) ;

    // -------------------------------------------------------------------------
    // SUCCESS!
    // -------------------------------------------------------------------------

    return TRUE ;

    // =========================================================================
    // That's that!
    // =========================================================================

}

// =============================================================================
// apply_display_treatments_to_field_value()
// =============================================================================

function apply_display_treatments_to_field_value(
    $all_application_dataset_definitions    ,
    $selected_datasets_dmdd                 ,
    $dataset_records                        ,
    $dataset_slug                           ,
    $dataset_title                          ,
    $question_front_end                     ,
    $caller_apps_includes_dir               ,
    $this_column_def_index                  ,
    $this_column_def                        ,
    $this_dataset_record_index              ,
    $this_dataset_record_data               ,
    &$custom_get_table_data_function_data   ,
    &$field_value
    ) {

    // -------------------------------------------------------------------------
    // apply_display_treatments_to_field_value(
    //      $all_application_dataset_definitions    ,
    //      $selected_datasets_dmdd                 ,
    //      $dataset_records                        ,
    //      $dataset_slug                           ,
    //      $dataset_title                          ,
    //      $question_front_end                     ,
    //      $caller_apps_includes_dir               ,
    //      $this_column_def_index                  ,
    //      $this_column_def                        ,
    //      $this_dataset_record_index              ,
    //      $this_dataset_record_data               ,
    //      &$custom_get_table_data_function_data   ,
    //      &$field_value
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - -
    // Applies the column's "display treatments" (if any), to the specified
    // field value...
    //
    // RETURNS
    //      o   On SUCCESS!
    //          - - - - - -
    //          TRUE
    //
    //      o   On FAILURE!
    //          - - - - - -
    //          $error_message STRING
    // -------------------------------------------------------------------------

    if ( ! array_key_exists( 'display_treatments' , $this_column_def ) ) {
        return TRUE ;
    }

    // -------------------------------------------------------------------------

    $ns = __NAMESPACE__ ;
    $fn = __FUNCTION__  ;

    // -------------------------------------------------------------------------
    // The recognised/supported treatments are:-
    //
    //      $this_column_def['display_treatments'] = array(
    //
    //          array(
    //              'method'    =>  'bold'
    //              )
    //
    //          array(
    //              'method'    =>  'to-clickable-url'
    //              'args'      =>  array(
    //                                  'text'          =>  "Xxx"
    //                                      //  (Optional; if not specified the field value is used)
    //                                  'url'           =>  "xxx"
    //                                      //  (Optional; if not specified the field value is used)
    //                                  'attributes'    =>  array(
    //                                                          //  Eg;
    //                                                          'target'    =>  "_blank", etc
    //                                                          'class'     =>  "xxx"
    //                                                          'style'     =>  "xxx"
    //                                                          //  ...etc...
    //                                                          )
    //                                      //  Optional
    //                                  )
    //              )
    //
    //          array(
    //              'method'    =>  'micro-datetime-utc-pretty'
    //              'instance'  =>  NULL | "<date-format-for-seconds-part>"
    //              )
    //              //  Converts date/time like:-
    //              //      123456789.1234
    //              //      (seconds.usec as float)
    //              //  to (eg):-
    //              //      3 Feb 2014 14:02:15 134,800 us
    //
    //          array(
    //              'method'    =>  'yes-no'
    //              'args'      =>  array(
    //                                  'custom_conversions'    =>  array(
    //                                      'TRUE'  =>  'Yes'       ,
    //                                      'FALSE' =>  '&mdash;'
    //                                      )
    //                                  )
    //              )
    //              //  Assumes the field contains a boolean (TRUE/FALSE)
    //              //  value, which it displays as the strings "yes" or
    //              //  "no"
    //
    //          array(
    //              'method'    =>  'password'
    //              )
    //              //  Displays the field value as the same number of "*"
    //
    //          array(
    //              'method'    =>  'image'
    //              'args'      =>  array()
    //              )
    //              //  The raw_field value is assumed to be an image URL.
    //              //  And the image is displayed.
    //
    //          array(
    //              'method'    =>  'htmlentities'
    //              )
    //
    //          array(
    //              'method'    =>  'wrapper'
    //              'args'      =>  array(
    //                                  'before'    =>  "xxx"   ,
    //                                  'after'     =>  "xxx"
    //                                  )
    //              )
    //
    //          )
    //
    // -------------------------------------------------------------------------

    $column_number = $this_column_def_index + 1 ;

    // -------------------------------------------------------------------------

    if ( ! is_array( $this_column_def['display_treatments'] ) ) {

        return <<<EOT
PROBLEM Displaying Dataset Records:&nbsp; Bad "dataset_records_table" + "column_defs" + "display_treatments" - for column# {$column_number} (array expected)
For dataset:&nbsp; {$dataset_title}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

    }

    // -------------------------------------------------------------------------

    foreach ( $this_column_def['display_treatments'] as $this_index => $this_treatment ) {

        // ---------------------------------------------------------------------

        $treatment_number = $this_index + 1 ;

        // ---------------------------------------------------------------------

        if ( ! is_array( $this_treatment ) ) {

            return <<<EOT
PROBLEM Displaying Dataset Records:&nbsp; Bad "dataset_records_table" + "column_defs" + "display_treatments" + treatment# ($treatment_number) - for column# {$column_number} (array expected)
For dataset:&nbsp; {$dataset_title}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        }

        // ---------------------------------------------------------------------

        if ( ! array_key_exists( 'method' , $this_treatment ) ) {

            return <<<EOT
PROBLEM Displaying Dataset Records:&nbsp; Bad "dataset_records_table" + "column_defs" + "display_treatments" + treatment# ($treatment_number) - for column# {$column_number} (no "method")
For dataset:&nbsp; {$dataset_title}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        }

        // ---------------------------------------------------------------------

        if (    ! is_string( $this_treatment['method'] )
                ||
                trim( $this_treatment['method'] ) === ''
                ||
                strlen( $this_treatment['method'] ) > 64
                ||
                ! \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_stringUtils\ctype_alphanumeric_underscore_dash( $this_treatment['method'] )
            ) {

            return <<<EOT
PROBLEM Displaying Dataset Records:&nbsp; Bad "dataset_records_table" + "column_defs" + "display_treatments" + treatment# ($treatment_number) + "method" - for column# {$column_number} (bad "method")
For dataset:&nbsp; {$dataset_title}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        }

        // ---------------------------------------------------------------------

        if ( $this_treatment['method'] === 'bold' ) {

            // =================================================================
            // BOLD
            // =================================================================

            // -----------------------------------------------------------------
            //  array(
            //      'method'    =>  'bold'
            //      )
            // -----------------------------------------------------------------

            $field_value = <<<EOT
<strong>{$field_value}</strong>
EOT;

            // -----------------------------------------------------------------

        } elseif ( $this_treatment['method'] === 'to-clickable-url' ) {

            // =================================================================
            // TO-CLICKABLE-URL
            // =================================================================

            // -----------------------------------------------------------------
            //  array(
            //      'method'    =>  'to-clickable-url'
            //      'args'      =>  array(
            //                          'text'          =>  "Xxx"
            //                              //  (Optional; if not specified the field value is used)
            //                          'url'           =>  "xxx"
            //                              //  (Optional; if not specified the field value is used)
            //                          'attributes'    =>  array(
            //                                                  //  Eg;
            //                                                  'target'    =>  "_blank", etc
            //                                                  'class'     =>  "xxx"
            //                                                  'style'     =>  "xxx"
            //                                                  //  ...etc...
            //                                                  )
            //                              //  Optional
            //                          )
            //      )
            // -----------------------------------------------------------------

            if ( isset( $this_treatment['args'] ) ) {

                if ( ! is_array( $this_treatment['args'] ) ) {

                    return <<<EOT
PROBLEM Displaying Dataset Records:&nbsp; Bad "dataset_records_table" + "column_defs" + "display_treatments" + treatment# ($treatment_number) + "args" - for column# {$column_number} (bad "args" - array expected)
For dataset:&nbsp; {$dataset_title}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

                }

            } else {

                $this_treatment['args'] = array() ;

            }

            // -----------------------------------------------------------------

            $href = $field_value ;
            $text = $field_value ;

            // -----------------------------------------------------------------

            if ( isset( $this_treatment['args']['url'] ) ) {

                if ( ! is_string( $this_treatment['args']['url'] ) ) {

                    return <<<EOT
PROBLEM Displaying Dataset Records:&nbsp; Bad "dataset_records_table" + "column_defs" + "display_treatments" + treatment# ($treatment_number) + "args" + "url" - for column# {$column_number} (possibly empty string expected)
For dataset:&nbsp; {$dataset_title}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

                }

                $href = $this_treatment['args']['url'] ;

            }

            // -----------------------------------------------------------------

            if ( isset( $this_treatment['args']['text'] ) ) {

                if (    ! is_string( $this_treatment['args']['text'] )
                        ||
                        trim( $this_treatment['args']['text'] ) === ''
                    ) {

                    return <<<EOT
PROBLEM Displaying Dataset Records:&nbsp; Bad "dataset_records_table" + "column_defs" + "display_treatments" + treatment# ($treatment_number) + "args" + "text" - for column# {$column_number} (non-empty string expected)
For dataset:&nbsp; {$dataset_title}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

                }

                $text = $this_treatment['args']['text'] ;

            }

            // -----------------------------------------------------------------

            $attributes = '' ;
            $comma = '' ;

            // -----------------------------------------------------------------

            if ( isset( $this_treatment['args']['attributes'] ) ) {

                // -------------------------------------------------------------

                if ( ! is_array( $this_treatment['args']['attributes'] ) ) {

                    return <<<EOT
PROBLEM Displaying Dataset Records:&nbsp; Bad "dataset_records_table" + "column_defs" + "display_treatments" + treatment# ($treatment_number) + "args" + "attributes" - for column# {$column_number} (possibly empty array expected)
For dataset:&nbsp; {$dataset_title}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

                }

                // -------------------------------------------------------------

                foreach ( $this_treatment['args']['attributes'] as $name => $value ) {

                    $attributes .= <<<EOT
{$comma}{$name}="{$value}"
EOT;

                    $comma = chr(32) ;

                }

                // -------------------------------------------------------------

            }

            // -----------------------------------------------------------------

            $field_value = <<<EOT
<a href="{$href}"{$attributes}>{$text}</a>
EOT;

            // -----------------------------------------------------------------

        } elseif ( $this_treatment['method'] === 'micro-datetime-utc-pretty' ) {

            // =================================================================
            // MICRO-DATETIME-UTC-PRETTY
            // =================================================================

            // -----------------------------------------------------------------
            // array(
            //     'method'    =>  'micro-datetime-utc-pretty'
            //     'instance'  =>  NULL | "<date-format-for-seconds-part>"
            //     )
            //     //  Converts date/time like:-
            //     //      123456789.1234
            //     //      (seconds.usec as float)
            //     //  to (eg):-
            //     //      3 Feb 2014 14:02:15 134,800 us
            // -----------------------------------------------------------------

            if ( trim( $field_value ) !== '' ) {

                // -------------------------------------------------------------

                $parts = explode( '.' , $field_value ) ;

                // -------------------------------------------------------------

                if (    count( $parts ) === 2
                        &&
                        ctype_digit( $parts[0] )
                        &&
                        ctype_digit( $parts[1] )
                    ) {

                    // ---------------------------------------------------------

                    $seconds = $parts[0] ;

                    // ---------------------------------------------------------

                    if (    isset( $this_treatment['instance'] )
                            &&
                            is_string( $this_treatment['instance'] )
                            &&
                            trim( $this_treatment['instance'] ) !== ''
                        ) {
                        $format = $this_treatment['instance'] ;

                    } else {
                        $format = 'j M Y\&\n\b\s\p\; G:i:s' ;

                    }

                    // ---------------------------------------------------------

                    $pretty_seconds = date( $format , $seconds ) ;

                    // ---------------------------------------------------------

                    $micro_seconds = $parts[1] ;

                    // ---------------------------------------------------------

                    if ( strlen( $micro_seconds ) < 6 ) {
                        $micro_seconds = str_pad( $micro_seconds , 6 , '0' , STR_PAD_RIGHT ) ;

                    } elseif ( strlen( $micro_seconds ) > 6 ) {
                        $micro_seconds = substr( $micro_seconds , 0 , 6 ) ;

                    }

                    // ---------------------------------------------------------

                    $pretty_micro_seconds = substr( $micro_seconds , 0 , 3 ) .
                                            ',' .
                                            substr( $micro_seconds , 3  ) .
                                            '&nbsp;&micro;s'
                                            ;

                    // ---------------------------------------------------------

                    $field_value = <<<EOT
{$pretty_seconds}&nbsp; {$pretty_micro_seconds}
EOT;

                    // ---------------------------------------------------------

                }

                // -------------------------------------------------------------

            }

            // -----------------------------------------------------------------

        } elseif ( $this_treatment['method'] === 'yes-no' ) {

            // =================================================================
            // YES-NO
            // =================================================================

            // -----------------------------------------------------------------
            //  array(
            //      'method'    =>  'yes-no'
            //      'args'      =>  array(
            //                          'custom_conversions'    =>  array(
            //                              'TRUE'  =>  'Yes'       ,
            //                              'FALSE' =>  '&mdash;'
            //                              )
            //                          )
            //      )
            // -----------------------------------------------------------------

            if (    isset( $this_treatment['args'] )
                    &&
                    is_array( $this_treatment['args'] )
                    &&
                    isset( $this_treatment['args']['custom_conversions'] )
                ) {

                if ( $field_value ) {

                    if (    isset( $this_treatment['args']['custom_conversions']['TRUE'] )
                            &&
                            is_scalar( $this_treatment['args']['custom_conversions']['TRUE'] )
                        ) {
                        $field_value = $this_treatment['args']['custom_conversions']['TRUE'] ;

                    } else {
                        $field_value = 'yes' ;

                    }

                } else {

                    if (    isset( $this_treatment['args']['custom_conversions']['FALSE'] )
                            &&
                            is_scalar( $this_treatment['args']['custom_conversions']['FALSE'] )
                        ) {
                        $field_value = $this_treatment['args']['custom_conversions']['FALSE'] ;

                    } else {
                        $field_value = 'no' ;

                    }

                }

            } else {

                if ( $field_value ) {
                    $field_value = 'yes' ;

                } else {
                    $field_value = 'no' ;

                }

            }

            // -----------------------------------------------------------------

        } elseif ( $this_treatment['method'] === 'password' ) {

            // =================================================================
            // PASSWORD
            // =================================================================

            // -----------------------------------------------------------------
            //  array(
            //      'method'    =>  'password'
            //      )
            // -----------------------------------------------------------------

            $field_value = str_repeat( '*' , strlen( $field_value ) ) ;

            // -----------------------------------------------------------------

        } elseif ( $this_treatment['method'] === 'image' ) {

            // =================================================================
            // IMAGE
            // =================================================================

            // -----------------------------------------------------------------
            //  array(
            //      'method'    =>  'image'
            //      'args'      =>  array()
            //      )
            // -----------------------------------------------------------------

            if (    is_string( $field_value )
                    &&
                    trim( $field_value ) !== ''
                ) {

                $ext = pathinfo( $field_value , PATHINFO_EXTENSION ) ;

                $image_extensions = array(
                    'gif'       ,
                    'png'       ,
                    'jpeg'      ,
                    'jpg'       ,
                    'jpe'
                    ) ;

                if ( in_array( strtolower( $ext ) , $image_extensions , TRUE ) ) {

                    $title =    \htmlentities(
                                    \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_stringUtils\to_title(
                                        \strip_tags(
                                            \basename( $field_value )
                                            )
                                        )
                                    ) ;

                    $style = '' ;

                    if (    array_key_exists( 'args' , $this_treatment )
                            &&
                            array_key_exists( 'style' , $this_treatment['args'] )
                            &&
                            is_string( $this_treatment['args']['style'] )
                            &&
                            trim( $this_treatment['args']['style'] ) !== ''
                        ) {

                        $style = 'style="' . trim( $this_treatment['args']['style'] ) . '"' ;

                    }

                    $field_value = <<<EOT
<a  target="_blank"
    href="{$field_value}"
    style="text-decoration:none"
    title="{$title}"
    ><img   border="0"
            src="{$field_value}"
            {$style}
            alt="{$title}"
            /></a>
EOT;

//echo '<br />' , htmlentities( $field_value ) ;

                }

            }

            // -----------------------------------------------------------------

        } elseif ( $this_treatment['method'] === 'htmlentities' ) {

            // =================================================================
            // HTMLENTITIES
            // =================================================================

            // -----------------------------------------------------------------
            //  array(
            //      'method'    =>  'htmlentities'
            //      )
            // -----------------------------------------------------------------

            $field_value = htmlentities( $field_value ) ;

            // -----------------------------------------------------------------

        } elseif ( $this_treatment['method'] === 'wrapper' ) {

            // =================================================================
            // WRAPPER
            // =================================================================

            // -----------------------------------------------------------------
            //  array(
            //      'method'    =>  'wrapper'
            //      'args'      =>  array(
            //                          'before'    =>  "xxx"   ,
            //                          'after'     =>  "xxx"
            //                          )
            //      )
            // -----------------------------------------------------------------

            if (    ! array_key_exists( 'args' , $this_treatment )
                    ||
                    ! is_array( $this_treatment['args'] )
                ) {

                return <<<EOT
PROBLEM Displaying Dataset Records:&nbsp; Bad "dataset_records_table" + "column_defs" + "display_treatments" + treatment# ($treatment_number) + "args" - for column# {$column_number} (array expected)
For dataset:&nbsp; {$dataset_title}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

            }

            // -----------------------------------------------------------------

            if (    array_key_exists( 'before' , $this_treatment['args'] )
                    &&
                    is_string( $this_treatment['args']['before'] )
                ) {

                $field_value = $this_treatment['args']['before'] . $field_value ;

            }

            // -----------------------------------------------------------------

            if (    array_key_exists( 'after' , $this_treatment['args'] )
                    &&
                    is_string( $this_treatment['args']['after'] )
                ) {

                $field_value .= $this_treatment['args']['after'] ;

            }

            // -----------------------------------------------------------------

        } else {

            // =================================================================
            // ERROR
            // =================================================================

            $safe_method = htmlenities( $this_treatment['method'] ) ;

            return <<<EOT
PROBLEM Displaying Dataset Records:&nbsp; Unrecognised/unsupported "dataset_records_table" + "column_defs" + "display_treatments" + treatment# ($treatment_number) + "method" + ("{$safe_method}") - for column# {$column_number}
For dataset:&nbsp; {$dataset_title}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        }

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // SUCCESS!
    // =========================================================================

    return TRUE ;

    // =========================================================================
    // That's that!
    // =========================================================================

}

// =============================================================================
// get_action_column_value_for_dataset_record()
// =============================================================================

function get_action_column_value_for_dataset_record(
    $all_application_dataset_definitions            ,
    $caller_apps_includes_dir                       ,
    $question_front_end                             ,
    $selected_datasets_dmdd                         ,
    $dataset_records                                ,
    $dataset_slug                                   ,
    $dataset_title                                  ,
    $array_storage_key_field_slug                   ,
    $dataset_record_index                           ,
    $dataset_record_data                            ,
    $column_index                                   ,
    $column_number                                  ,
    $column_def                                     ,
    &$custom_get_table_data_function_data           ,
    &$question_delete_record_javascript_required
    ) {

    // -------------------------------------------------------------------------
    // get_action_column_value_for_dataset_record(
    //      $all_application_dataset_definitions            ,
    //      $caller_apps_includes_dir                       ,
    //      $question_front_end                             ,
    //      $selected_datasets_dmdd                         ,
    //      $dataset_records                                ,
    //      $dataset_slug                                   ,
    //      $dataset_title                                  ,
    //      $array_storage_key_field_slug                   ,
    //      $dataset_record_index                           ,
    //      $dataset_record_data                            ,
    //      $column_index                                   ,
    //      $column_number                                  ,
    //      $column_def                                     ,
    //      &$custom_get_table_data_function_data           ,
    //      &$question_delete_record_javascript_required
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // RETURNS
    //      o   On SUCCESS!
    //          - - - - - -
    //          $column_value (HTML) STRING
    //
    //          And updates:-
    //              $question_delete_record_javascript_required
    //          to TRUE, if required.
    //
    //      o   On FAILURE!
    //          - - - - - -
    //          ARRAY( $error_message STRING )
    // -------------------------------------------------------------------------

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $selected_datasets_dmdd['dataset_records_table']['record_actions'] = array(
    //          array(
    //              'type'          =>  'standard'      ,
    //              'slug'          =>  'edit'          ,
    //              'link_title'    =>  'edit'
    //              )   ,
    //          array(
    //              'type'          =>  'standard'      ,
    //              'slug'          =>  'delete'        ,
    //              'link_title'    =>  'delete'
    //              )   ,
    //          array(
    //              'type'          =>  'custom'                ,
    //              'slug'          =>  'select-dirs-files'     ,
    //              'link_title'    =>  'select files'
    //              )
    //          )
    //
    // NOTE!
    // =====
    // The presence of the:-
    //      "type"
    //      "slug"
    //      "link_title"
    //
    // parameters has already been checked for.  As well as some basic
    // checks as to the validity of their respective values.
    // -------------------------------------------------------------------------

    $column_value = '' ;

    $action_comma = '' ;

    // -------------------------------------------------------------------------

    foreach ( $selected_datasets_dmdd['dataset_records_table']['record_actions'] as $record_action_index => $record_action_details ) {

        // ---------------------------------------------------------------------

        $record_action_number = $record_action_index + 1 ;

        // ---------------------------------------------------------------------
        // Here we should have (eg):-
        //
        //      $record_action_details = array(
        //          'type'          =>  'standard'      ,
        //          'slug'          =>  'edit'          ,
        //          'link_title'    =>  'edit'
        //          )
        //
        //      --OR--
        //
        //      $record_action_details = array(
        //          'type'          =>  'standard'      ,
        //          'slug'          =>  'delete'        ,
        //          'link_title'    =>  'delete'
        //          )
        //
        //      --OR--
        //
        //      $record_action_details = array(
        //          'type'          =>  'custom'                ,
        //          'slug'          =>  'select-dirs-files'     ,
        //          'link_title'    =>  'select files'
        //          )
        //
        // ---------------------------------------------------------------------

        if ( $record_action_details['type'] === 'standard' ) {

            // -------------------------------------------------------------------------
            // process_standard_record_action_for_dataset_record(
            //      $all_application_dataset_definitions            ,
            //      $caller_apps_includes_dir                       ,
            //      $question_front_end                             ,
            //      $selected_datasets_dmdd                         ,
            //      $dataset_records                                ,
            //      $dataset_slug                                   ,
            //      $dataset_title                                  ,
            //      $array_storage_key_field_slug                   ,
            //      $dataset_record_index                           ,
            //      $dataset_record_data                            ,
            //      $column_index                                   ,
            //      $column_number                                  ,
            //      $column_def                                     ,
            //      &$custom_get_table_data_function_data           ,
            //      &$question_delete_record_javascript_required    ,
            //      &$column_value                                  ,
            //      $action_comma                                   ,
            //      $record_action_index                            ,
            //      $record_action_number                           ,
            //      $record_action_details
            //      )
            // - - - - - - - - - - - - - - - - - - - - - - - - - - -
            // RETURNS
            //      o   On SUCCESS!
            //          - - - - - -
            //          TRUE
            //
            //          And updates:-
            //
            //          1)  $column_value, and;
            //
            //          2)  $question_delete_record_javascript_required
            //              to TRUE, if required.
            //
            //      o   On FAILURE!
            //          - - - - - -
            //          $error_message STRING
            // -------------------------------------------------------------------------

            $result = process_standard_record_action_for_dataset_record(
                            $all_application_dataset_definitions            ,
                            $caller_apps_includes_dir                       ,
                            $question_front_end                             ,
                            $selected_datasets_dmdd                         ,
                            $dataset_records                                ,
                            $dataset_slug                                   ,
                            $dataset_title                                  ,
                            $array_storage_key_field_slug                   ,
                            $dataset_record_index                           ,
                            $dataset_record_data                            ,
                            $column_index                                   ,
                            $column_number                                  ,
                            $column_def                                     ,
                            $custom_get_table_data_function_data            ,
                            $question_delete_record_javascript_required     ,
                            $column_value                                   ,
                            $action_comma                                   ,
                            $record_action_index                            ,
                            $record_action_number                           ,
                            $record_action_details
                            ) ;

            // -----------------------------------------------------------------

        } elseif ( $record_action_details['type'] === 'custom' ) {

            // -----------------------------------------------------------------

            $result = process_custom_record_action_for_dataset_record(
                            $all_application_dataset_definitions            ,
                            $caller_apps_includes_dir                       ,
                            $question_front_end                             ,
                            $selected_datasets_dmdd                         ,
                            $dataset_records                                ,
                            $dataset_slug                                   ,
                            $dataset_title                                  ,
                            $array_storage_key_field_slug                   ,
                            $dataset_record_index                           ,
                            $dataset_record_data                            ,
                            $column_index                                   ,
                            $column_number                                  ,
                            $column_def                                     ,
                            $custom_get_table_data_function_data            ,
                            $question_delete_record_javascript_required     ,
                            $column_value                                   ,
                            $action_comma                                   ,
                            $record_action_index                            ,
                            $record_action_number                           ,
                            $record_action_details
                            ) ;

            // -----------------------------------------------------------------

        } else {

            // -----------------------------------------------------------------

            $safe_type = htmlentities( $this_record_action_details['type'] ) ;

            return <<<EOT
PROBLEM Displaying Dataset Records:&nbsp; Unrecognised/unsupported "dataset_records_table" + record action# {$record_action_number} + "type" ("{$safe_type}")
For dataset:&nbsp; {$dataset_title}
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\get_action_column_value_for_dataset_record()
EOT;

            // -----------------------------------------------------------------

        }

        // ---------------------------------------------------------------------

        if ( is_string( $result ) ) {
            return array( $result ) ;
        }

        // ---------------------------------------------------------------------

        $action_comma = $selected_datasets_dmdd['dataset_records_table']['action_separator'] ;

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // SUCCESS!
    // =========================================================================

    return $column_value ;

    // =========================================================================
    // That's that!
    // =========================================================================

}

// =============================================================================
// process_standard_record_action_for_dataset_record()
// =============================================================================

function process_standard_record_action_for_dataset_record(
    $all_application_dataset_definitions            ,
    $caller_apps_includes_dir                       ,
    $question_front_end                             ,
    $selected_datasets_dmdd                         ,
    $dataset_records                                ,
    $dataset_slug                                   ,
    $dataset_title                                  ,
    $array_storage_key_field_slug                   ,
    $dataset_record_index                           ,
    $dataset_record_data                            ,
    $column_index                                   ,
    $column_number                                  ,
    $column_def                                     ,
    &$custom_get_table_data_function_data           ,
    &$question_delete_record_javascript_required    ,
    &$column_value                                  ,
    $action_comma                                   ,
    $record_action_index                            ,
    $record_action_number                           ,
    $record_action_details
    ) {

    // -------------------------------------------------------------------------
    // process_standard_record_action_for_dataset_record(
    //      $all_application_dataset_definitions            ,
    //      $caller_apps_includes_dir                       ,
    //      $question_front_end                             ,
    //      $selected_datasets_dmdd                         ,
    //      $dataset_records                                ,
    //      $dataset_slug                                   ,
    //      $dataset_title                                  ,
    //      $array_storage_key_field_slug                   ,
    //      $dataset_record_index                           ,
    //      $dataset_record_data                            ,
    //      $column_index                                   ,
    //      $column_number                                  ,
    //      $column_def                                     ,
    //      &$custom_get_table_data_function_data           ,
    //      &$question_delete_record_javascript_required    ,
    //      &$column_value                                  ,
    //      $action_comma                                   ,
    //      $record_action_index                            ,
    //      $record_action_number                           ,
    //      $record_action_details
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // RETURNS
    //      o   On SUCCESS!
    //          - - - - - -
    //          TRUE
    //
    //          And updates:-
    //
    //          1)  $column_value, and;
    //
    //          2)  $question_delete_record_javascript_required
    //              to TRUE, if required.
    //
    //      o   On FAILURE!
    //          - - - - - -
    //          $error_message STRING
    // -------------------------------------------------------------------------

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $record_action_details = array(
    //          'type'          =>  'standard'      ,
    //          'slug'          =>  'edit'          ,
    //          'link_title'    =>  'edit'
    //          )
    //
    //      --OR--
    //
    //      $record_action_details = array(
    //          'type'          =>  'standard'      ,
    //          'slug'          =>  'delete'        ,
    //          'link_title'    =>  'delete'
    //          )
    //
    // NOTE!
    // =====
    // The presence of the:-
    //      "type"
    //      "slug"
    //      "link_title"
    //
    // parameters has already been checked for.  As well as some basic
    // checks as to the validity of their respective values.
    // -------------------------------------------------------------------------

    if ( $record_action_details['slug'] === 'edit' ) {

        // =================================================================
        // EDIT
        // =================================================================

        if ( $array_storage_key_field_slug === '' ) {

            return <<<EOT
PROBLEM Displaying Dataset Records:&nbsp; No "dataset_records_table" + "array_storage_key_field_slug" (this value is required for record action = "edit")
For dataset:&nbsp; {$dataset_title}
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\process_standard_record_action_for_dataset_record()
EOT;

        }

        // -----------------------------------------------------------------

        if ( ! isset( $dataset_record_data[ $array_storage_key_field_slug ] ) ) {

            return <<<EOT
PROBLEM Displaying Dataset Records:&nbsp; Can't edit record (because it has no "{$array_storage_key_field_slug}" (= key) field)
For dataset:&nbsp; {$dataset_title}
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\process_standard_record_action_for_dataset_record()
EOT;

        }

        // -------------------------------------------------------------------------
        // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\
        // is_record_key(
        //      $candidate_record_key
        //      )
        // - - - - - - - - - - - - - - - - -
        // RETURNS
        //      o   On SUCCESS
        //              TRUE
        //
        //      o   On FAILURE
        //              FALSE
        // -------------------------------------------------------------------------

        if ( ! \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\is_record_key(
                    $dataset_record_data[ $array_storage_key_field_slug ]
                    )
            ) {

            return <<<EOT
PROBLEM Displaying Dataset Records:&nbsp; Can't edit record (because it's "{$array_storage_key_field_slug}" field is invalid)
For dataset:&nbsp; {$dataset_title}
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\process_standard_record_action_for_dataset_record()
EOT;

        }

        // -----------------------------------------------------------------

        require_once( dirname( __FILE__ ) . '/get-dataset-urls.php' ) ;

        // -------------------------------------------------------------------------
        // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\get_edit_record_url(
        //      $caller_apps_includes_dir   ,
        //      $question_front_end         ,
        //      $dataset_slug = NULL        ,
        //      $record_key = NULL
        //      )
        // - - - - - - - - - - - - - - - - - - - - - - - - - - -
        // Returns the "edit-record" URL.
        //
        // If $dataset_slug is NULL, then we use:-
        //      $_GET['dataset_slug']
        //
        // If $record_key is NULL, then we use:-
        //      $_GET['record_key']
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

        $href = get_edit_record_url(
                    $caller_apps_includes_dir                       ,
                    $question_front_end                             ,
                    $_GET['dataset_slug']                           ,
                    $dataset_record_data[ $array_storage_key_field_slug ]
                    ) ;

        // -----------------------------------------------------------------

        if ( is_array( $href ) ) {
            return $href[0] ;
        }

        // -----------------------------------------------------------------

        if ( $question_front_end ) {

            $column_value .= <<<EOT
{$action_comma}<a
    href="javascript:void()"
    onclick="window.parent.location.href='{$href}'"
    style="text-decoration:none">{$record_action_details['link_title']}</a>
EOT;
            //  Because the link we're clicking is in an IFRAME

        } else {

            $column_value .= <<<EOT
{$action_comma}<a href="{$href}" style="text-decoration:none">{$record_action_details['link_title']}</a>
EOT;

        }

        // -----------------------------------------------------------------

    } elseif ( $record_action_details['slug'] === 'delete' ) {

        // =================================================================
        // DELETE
        // =================================================================

        if ( $array_storage_key_field_slug === '' ) {

            return <<<EOT
PROBLEM Displaying Dataset Records:&nbsp; No "dataset_records_table" + "array_storage_key_field_slug" (this value is required for action = "delete")
For dataset:&nbsp; {$dataset_title}
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\process_standard_record_action_for_dataset_record()
EOT;

        }

        // -----------------------------------------------------------------

        if ( ! isset( $dataset_record_data[ $array_storage_key_field_slug ] ) ) {

            return <<<EOT
PROBLEM Displaying Dataset Records:&nbsp; Can't delete record (because it has no "{$array_storage_key_field_slug}" (= key) field)
For dataset:&nbsp; {$dataset_title}
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\process_standard_record_action_for_dataset_record()
EOT;

        }

        // -------------------------------------------------------------------------
        // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\
        // is_record_key(
        //      $candidate_record_key
        //      )
        // - - - - - - - - - - - - - - - - -
        // RETURNS
        //      o   On SUCCESS
        //              TRUE
        //
        //      o   On FAILURE
        //              FALSE
        // -------------------------------------------------------------------------

        if ( ! \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\is_record_key(
                    $dataset_record_data[ $array_storage_key_field_slug ]
                    )
            ) {

            return <<<EOT
PROBLEM Displaying Dataset Records:&nbsp; Can't delete record (because it's "{$array_storage_key_field_slug}" field is invalid)
For dataset:&nbsp; {$dataset_title}
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\process_standard_record_action_for_dataset_record()
EOT;

        }

        // -----------------------------------------------------------------

        $column_value .= <<<EOT
{$action_comma}<a
    href="javascript:void()"
    style="text-decoration:none"
    onclick="greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager_questionDeleteRecord(this,'{$dataset_record_data[$array_storage_key_field_slug]}')"
    >{$record_action_details['link_title']}</a>
EOT;

        // -----------------------------------------------------------------

        $question_delete_record_javascript_required = TRUE ;

        // -----------------------------------------------------------------

    } else {

        // =====================================================================
        // ERROR (UNRECOGNISED/UNSUPPORTED RECORD ACTION "SLUG")
        // =====================================================================

        $safe_slug = htmlentities( $record_action_details['slug'] ) ;

        return <<<EOT
PROBLEM Displaying Dataset Records:&nbsp; Unrecognised/unsupported "dataset_records_table" + record action# {$record_action_number} + "slug" ("{$safe_slug}")
For dataset:&nbsp; {$dataset_title}
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\process_standard_record_action_for_dataset_record()
EOT;

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // SUCCESS!
    // =========================================================================

    return TRUE ;

    // =========================================================================
    // That's that!
    // =========================================================================

}

// =============================================================================
// process_custom_record_action_for_dataset_record()
// =============================================================================

function process_custom_record_action_for_dataset_record(
    $all_application_dataset_definitions            ,
    $caller_apps_includes_dir                       ,
    $question_front_end                             ,
    $selected_datasets_dmdd                         ,
    $dataset_records                                ,
    $dataset_slug                                   ,
    $dataset_title                                  ,
    $array_storage_key_field_slug                   ,
    $dataset_record_index                           ,
    $dataset_record_data                            ,
    $column_index                                   ,
    $column_number                                  ,
    $column_def                                     ,
    &$custom_get_table_data_function_data           ,
    &$question_delete_record_javascript_required    ,
    &$column_value                                  ,
    $action_comma                                   ,
    $record_action_index                            ,
    $record_action_number                           ,
    $record_action_details
    ) {

    // -------------------------------------------------------------------------
    // process_custom_record_action_for_dataset_record(
    //      $all_application_dataset_definitions            ,
    //      $caller_apps_includes_dir                       ,
    //      $question_front_end                             ,
    //      $selected_datasets_dmdd                         ,
    //      $dataset_records                                ,
    //      $dataset_slug                                   ,
    //      $dataset_title                                  ,
    //      $array_storage_key_field_slug                   ,
    //      $dataset_record_index                           ,
    //      $dataset_record_data                            ,
    //      $column_index                                   ,
    //      $column_number                                  ,
    //      $column_def                                     ,
    //      &$custom_get_table_data_function_data           ,
    //      &$question_delete_record_javascript_required    ,
    //      &$column_value                                  ,
    //      $action_comma                                   ,
    //      $record_action_index                            ,
    //      $record_action_number                           ,
    //      $record_action_details
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // RETURNS
    //      o   On SUCCESS!
    //          - - - - - -
    //          TRUE
    //
    //          And updates:-
    //
    //          1)  $column_value, and;
    //
    //          2)  $question_delete_record_javascript_required
    //              to TRUE, if required.
    //
    //      o   On FAILURE!
    //          - - - - - -
    //          $error_message STRING
    // -------------------------------------------------------------------------

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $record_action_details = array(
    //          'type'          =>  'custom'                ,
    //          'slug'          =>  'select-dirs-files'     ,
    //          'link_title'    =>  'select files'
    //          )
    //
    // NOTE!
    // =====
    // The presence of the:-
    //      "type"
    //      "slug"
    //      "link_title"
    //
    // parameters has already been checked for.  As well as some basic
    // checks as to the validity of their respective values.
    // -------------------------------------------------------------------------

    // -------------------------------------------------------------------------
    // NOTE!
    // =====
    // The "custom actions" are defined by the dataset's "custom_actions"
    // parameter.  Ie:-
    //
    //      $selected_datasets_dmdd['custom_actions'] = array(
    //
    //          array(
    //              'slug'      =>  'select-dirs-files'                     ,
    //              'args'      =>  array(
    //                                  'plugin_stuff_relative_filespec'    =>  'select-dirs-and-files.php'     ,
    //                                  'namespace_and_function_name'       =>  'select_dirs_and_files'
    //                                  )
    //              )
    //
    //          )
    //
    // NOTE!
    // =====
    // The presence of the:-
    //      "slug" and;
    //      "args"
    //
    // parameters has already been checked for.  As well as some basic
    // checks of to the validity of their respective values.
    // -------------------------------------------------------------------------

    // =========================================================================
    // Get the CUSTOM ACTION pointed to by the record action...
    // =========================================================================

    $custom_action_details = NULL ;

    // -------------------------------------------------------------------------

    foreach ( $selected_datasets_dmdd['custom_actions'] as $this_custom_action_index => $this_custom_action_details ) {

        if ( $this_custom_action_details['slug'] === $record_action_details['slug'] ) {
            $custom_action_details = $this_custom_action_details ;


        }

    }

    // -------------------------------------------------------------------------

    if ( ! is_array( $custom_action_details ) ) {

        return <<<EOT
PROBLEM Displaying Dataset Records:&nbsp; Bad record action# {$record_action_number} ("{$record_action_details['slug']}" - matching custom action not found)
For dataset:&nbsp; {$dataset_title}
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\process_custom_record_action_for_dataset_record()
EOT;

    }

    // =========================================================================
    // Process the CUSTOM ACTION pointed to by the record action...
    // =========================================================================

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $custom_action_details = array(
    //          'slug'      =>  'select-dirs-files'                     ,
    //          'args'      =>  array(
    //                              'plugin_stuff_relative_filespec'    =>  'select-dirs-and-files.php'     ,
    //                              'namespace_and_function_name'       =>  'select_dirs_and_files'
    //                              )
    //          )
    //
    // -------------------------------------------------------------------------

    if ( $array_storage_key_field_slug === '' ) {

        return <<<EOT
PROBLEM Displaying Dataset Records:&nbsp; No "dataset_records_table" + "array_storage_key_field_slug" (this value is required for custom record actions)
For dataset:&nbsp; {$dataset_title}
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\process_custom_record_action_for_dataset_record()
EOT;

    }

    // -----------------------------------------------------------------

    if ( ! isset( $dataset_record_data[ $array_storage_key_field_slug ] ) ) {

        return <<<EOT
PROBLEM Displaying Dataset Records:&nbsp; Can't create custom record action (because record has no "{$array_storage_key_field_slug}" (= key) field)
For dataset:&nbsp; {$dataset_title}
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\process_custom_record_action_for_dataset_record()
EOT;

    }

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\
    // is_record_key(
    //      $candidate_record_key
    //      )
    // - - - - - - - - - - - - - - - - -
    // RETURNS
    //      o   On SUCCESS
    //              TRUE
    //
    //      o   On FAILURE
    //              FALSE
    // -------------------------------------------------------------------------

    if ( ! \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\is_record_key(
                $dataset_record_data[ $array_storage_key_field_slug ]
                )
        ) {

        return <<<EOT
PROBLEM Displaying Dataset Records:&nbsp; Can't create custom record action (because record's "{$array_storage_key_field_slug}" field is invalid)
For dataset:&nbsp; {$dataset_title}
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\process_custom_record_action_for_dataset_record()
EOT;

    }

    // -----------------------------------------------------------------

    require_once( dirname( __FILE__ ) . '/get-dataset-urls.php' ) ;

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\get_custom_record_action_url(
    //      $caller_apps_includes_dir   ,
    //      $question_front_end         ,
    //      $dataset_slug = NULL        ,
    //      $action_slug = NULL         ,
    //      $record_key = NULL          ,
    //      $view_title = FALSE         ,
    //      $return_to = FALSE          ,
    //      $view_slug = FALSE
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // Returns the specififed CUSTOM RECORD ACTION URL.
    //
    // If $dataset_slug is NULL, then we use:-
    //      $_GET['dataset_slug']
    //
    // If $action_slug is NULL, then we use:-
    //      $_GET['action_slug']
    //
    // If $record_key is NULL, then we use:-
    //      $_GET['record_key']
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

    $href = get_custom_record_action_url(
                $caller_apps_includes_dir                               ,
                $question_front_end                                     ,
                $_GET['dataset_slug']                                   ,
                $custom_action_details['slug']                          ,
                $dataset_record_data[ $array_storage_key_field_slug ]
                ) ;

    // -----------------------------------------------------------------

    if ( is_array( $href ) ) {
        return $href[0] ;
    }

    // -----------------------------------------------------------------

    if ( $question_front_end ) {

        $column_value .= <<<EOT
{$action_comma}<a
    href="javascript:void()"
    onclick="window.parent.location.href='{$href}'"
    style="text-decoration:none">{$record_action_details['link_title']}</a>
EOT;
            //  Because the link we're clicking is in an IFRAME

    } else {

        $column_value .= <<<EOT
{$action_comma}<a href="{$href}" style="text-decoration:none">{$record_action_details['link_title']}</a>
EOT;

    }

    // =========================================================================
    // SUCCESS!
    // =========================================================================

    return TRUE ;

    // =========================================================================
    // That's that!
    // =========================================================================

}

// =============================================================================
// That's that!
// =============================================================================

