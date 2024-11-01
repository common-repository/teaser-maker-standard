<?php

// *****************************************************************************
// DATASET-MANAGER / ORPHANED-RECORDS.PHP
// (C) 2013 Peter Newman. All Rights Reserved.
// *****************************************************************************

    namespace greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager ;

// =============================================================================
// get_orphaned_record_indices()
// =============================================================================

function get_orphaned_record_indices(
    $all_application_dataset_definitions    ,
    $caller_apps_includes_dir               ,
    $selected_datasets_dmdd                 ,
    $dataset_records                        ,
    $dataset_slug                           ,
    $dataset_title                          ,
    $question_front_end
    ) {

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

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $dataset_records_table = array(
    //          ...
    //          'buttons'   =>  array(
    //                              ...
    //                              array(
    //                                  'type'  =>  'show_orphaned_records'
    //                                  )
    //                              ...
    //                              )   ,
    //          ...
    //          )
    //          //  NOTE!   On entry to this routine, it's assumed that the
    //          //          "show_orphaned_records" button was requested (in
    //          //          the dataset definition).  As this currently
    //          //          executing routine wouldn't have been called
    //          //          otherwise.)
    //
    //      $selected_datasets_dmdd = array(
    //          ...
    //          'dataset_slug'                      =>  'urls'                              ,
    //          'dataset_name_singular'             =>  'url'                               ,
    //          'dataset_name_plural'               =>  'urls'                              ,
    //          'dataset_title_singular'            =>  'URL'                               ,
    //          'dataset_title_plural'              =>  'URLs'                              ,
    //          'basepress_dataset_handle'          =>  $basepress_dataset_handle           ,
    //          'dataset_records_table'             =>  $dataset_records_table              ,
    //          'zebra_form'                        =>  $zebra_form                         ,
    //          'array_storage_record_structure'    =>  $array_storage_record_structure     ,
    //          'array_storage_key_field_slug'      =>  'key'                               ,
    //          ...
    //      //  'parent_details'                            =>  array(
    //      //      'type'                  =>  'none'              ,
    //      //      'type_specific_args'    =>  <any_PHP_value>     //  (this key and value, if specified,  are IGNORED)
    //      //      )
    //      //      //  This dataset's records have NO PARENT.  They may however
    //      //      //  have CHILDREN (see "child_dataset_slugs", below).
    //          ...
    //      //  'parent_details'                            =>  array(
    //      //      'type'                  =>  'single-parent-key-field'   .
    //      //      'type_specific_args'    =>  array(
    //      //          'parent_dataset_slug'                       =>  'xxx'   ,
    //      //          'parent_dataset_key_field_slug'             =>  'yyy'
    //      //          )
    //      //      )
    //      //      //  This dataset's records ***may*** optionally have a PARENT.
    //      //      //  o   "parent_dataset_slug" must be a non-empty string.
    //      //      //  o   The array storage record's:-
    //      //      //          "<parent_dataset_key_field_slug>"
    //      //      //      field may contain either:-
    //      //      //          --  The empty string (in which case, this child
    //      //      //              record has NO parent), or;
    //      //      //          --  A "record key" from the parent dataset.
    //      //      //
    //      //      //  The dataset records may have CHILDREN too (see
    //      //      //  "child_dataset_slugs", below).
    //          ...
    //      //  'parent_details'                            =>  array(
    //      //      'type'                  =>  'parent-type-and-key-fields'
    //      //      'type_specific_args'    =>  array(
    //      //          'parent_type_field_slug'            =>  'parent_is'     ,
    //      //          'parent_key_field_slug'             =>  'parent_key'    ,
    //      //          'parent_dataset_slugs_by_value'     =>  array(
    //      //              'document'  =>  'documents'     ,
    //      //              'section'   =>  'sections'
    //      //              )
    //      //          )
    //      //      )
    //      //      //  This dataset's records ***may*** optionally have a PARENT.
    //      //      //  o   If the "parent_type_field_slug" field contains the
    //      //      //      empty string, then this record has NO parent (and
    //      //      //      the "parent_key_field_slug" field in IGNORED).
    //      //      //  o   If the "parent_type_field_slug" field contains a
    //      //      //      non-empty string, then the:-
    //      //      //          "parent_dataset_slugs_by_value"
    //      //      //      field maps values in the "parent_type_field_slug"
    //      //      //      field, to the dataset the record belongs to.
    //      //      //
    //      //      //  The dataset records may have CHILDREN too (see
    //      //      //  "child_dataset_slugs", below).
    //          ...
    //      //  'parent_details'                            =>  array(
    //      //      'type'                  =>  'separate-parent-key-fields'
    //      //      'type_specific_args'    =>  array(
    //      //          'parent_dataset_slugs_by_key_field_slug'    =>  array(
    //      //              'document_key'  =>  'documents'     ,
    //      //              'section_key'   =>  'sections'
    //      //              )
    //      //      )
    //      //      //  This dataset's records ***may*** optionally have a PARENT.
    //      //      //  o   If ALL of the "parent dataset key" fields contain
    //      //      //      the empty string, then the record concerned has
    //      //      //      NO parent.
    //      //      //  o   If exactly ONE of the "parent dataset key" fields
    //      //      //      contains a non-empty string value, then the record
    //      //      //      concerned has the parent specified.
    //      //      //  o   If MORE THAN ONE of the "parent dataset key" fields
    //      //      //      has a non-empty string value, then it's an ERROR.
    //      //      //
    //      //      //  The dataset records may have CHILDREN too (see
    //      //      //  "child_dataset_slugs", below).
    //          ...
    //          'child_dataset_slugs'                       =>  array( 'shots' )
    //          ...
    //          )
    //
    // NOTES
    // =====
    // 1.   It's the dataset definition's:-
    //          o   "parent_details" and;
    //          o   "child_dataset_slugs"
    //
    //      fields that we use to identify the ORPHANED RECORD with.
    //
    // 2.   These fields are also used when DELETING RECORDS (see
    //      "delete-record.php").
    // -------------------------------------------------------------------------

    // =========================================================================
    // Init.
    // =========================================================================

    $ns = __NAMESPACE__ ;
    $fn = __FUNCTION__  ;

    // =========================================================================
    // If there's NO "parent_details" field, then this dataset has NO
    // orphaned records...
    // =========================================================================

    if ( ! array_key_exists( 'parent_details' , $selected_datasets_dmdd ) ) {
        return array() ;
    }

    // =========================================================================
    // parent_details ?
    // =========================================================================

    if ( ! is_array( $selected_datasets_dmdd['parent_details'] ) ) {

        return <<<EOT
PROBLEM:&nbsp; Bad <dataset-definition> + "parent_details" (array expected)
For dataset:&nbsp; {$dataset_title}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

    }

    // =========================================================================
    // parent_details + type ?
    // =========================================================================

    if ( ! array_key_exists( 'type' , $selected_datasets_dmdd['parent_details'] ) ) {

        return <<<EOT
PROBLEM:&nbsp; No <dataset-definition> + "parent_details" + "type"
For dataset:&nbsp; {$dataset_title}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

    }

    // -------------------------------------------------------------------------

    if (    ! is_string( $selected_datasets_dmdd['parent_details']['type'] )
            ||
            trim( $selected_datasets_dmdd['parent_details']['type'] ) === ''
        ) {

        return <<<EOT
PROBLEM:&nbsp; Bad <dataset-definition> + "parent_details" + "type" (non-empty string expected)
For dataset:&nbsp; {$dataset_title}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

    }

    // =========================================================================
    // "type" === "none" means NO orphaned records...
    // =========================================================================

    if ( $selected_datasets_dmdd['parent_details']['type'] === 'none' ) {
        return array() ;
    }

    // =========================================================================
    // parent_details + type_specific_args ?
    // =========================================================================

    if ( ! array_key_exists( 'type_specific_args' , $selected_datasets_dmdd['parent_details'] ) ) {

        return <<<EOT
PROBLEM:&nbsp; No <dataset-definition> + "parent_details" + "type_specific_args"
For dataset:&nbsp; {$dataset_title}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

    }

    // -------------------------------------------------------------------------

    if (    ! is_array( $selected_datasets_dmdd['parent_details']['type_specific_args'] )
            ||
            count( $selected_datasets_dmdd['parent_details']['type_specific_args'] ) < 1
        ) {

        return <<<EOT
PROBLEM:&nbsp; Bad <dataset-definition> + "parent_details" + "type_specific_args" (non-empty array expected)
For dataset:&nbsp; {$dataset_title}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

    }

    // =========================================================================
    // Identifying the orphaned records is now:-
    //      <dataset definition> + parent_details + type
    // specific...
    // =========================================================================

    if ( $selected_datasets_dmdd['parent_details']['type'] === 'single-parent-key-field' ) {

        // -------------------------------------------------------------------------
        // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\
        // get_orphaned_record_indices_by_single_parent_key_field(
        //      $all_application_dataset_definitions    ,
        //      $caller_apps_includes_dir               ,
        //      $selected_datasets_dmdd                 ,
        //      $child_dataset_records                  ,
        //      $child_dataset_slug                     ,
        //      $child_dataset_title                    ,
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

        return get_orphaned_record_indices_by_single_parent_key_field(
                    $all_application_dataset_definitions    ,
                    $caller_apps_includes_dir               ,
                    $selected_datasets_dmdd                 ,
                    $dataset_records                        ,
                    $dataset_slug                           ,
                    $dataset_title                          ,
                    $question_front_end
                    ) ;

        // ---------------------------------------------------------------------

    } elseif ( $selected_datasets_dmdd['parent_details']['type'] === 'parent-type-and-key-fields' ) {

        // -------------------------------------------------------------------------
        // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\
        // get_orphaned_record_indices_by_parent_type_and_key_fields(
        //      $all_application_dataset_definitions    ,
        //      $caller_apps_includes_dir               ,
        //      $selected_datasets_dmdd                 ,
        //      $child_dataset_records                  ,
        //      $child_dataset_slug                     ,
        //      $child_dataset_title                    ,
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

        return get_orphaned_record_indices_by_parent_type_and_key_fields(
                    $all_application_dataset_definitions    ,
                    $caller_apps_includes_dir               ,
                    $selected_datasets_dmdd                 ,
                    $dataset_records                        ,
                    $dataset_slug                           ,
                    $dataset_title                          ,
                    $question_front_end
                    ) ;

        // ---------------------------------------------------------------------

//  } elseif ( $selected_datasets_dmdd['parent_details']['type'] === 'separate-parent-key-fields' ) {

        // ---------------------------------------------------------------------

        //  TODO !!!

        // ---------------------------------------------------------------------

    } else {

        // ---------------------------------------------------------------------

        $safe_type = htmlentities( $selected_datasets_dmdd['parent_details']['type'] ) ;

        return <<<EOT
PROBLEM:&nbsp; Unrecognised/unsupported <dataset-definition> + "parent_details" + "type" ("{$safe_type}")
For dataset:&nbsp; {$dataset_title}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // That's that!
    // =========================================================================

}

// =============================================================================
// get_orphaned_record_indices_by_single_parent_key_field()
// =============================================================================

function get_orphaned_record_indices_by_single_parent_key_field(
    $all_application_dataset_definitions    ,
    $caller_apps_includes_dir               ,
    $selected_datasets_dmdd                 ,
    $child_dataset_records                  ,
    $child_dataset_slug                     ,
    $child_dataset_title                    ,
    $question_front_end
    ) {

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\
    // get_orphaned_record_indices_by_single_parent_key_field(
    //      $all_application_dataset_definitions    ,
    //      $caller_apps_includes_dir               ,
    //      $selected_datasets_dmdd                 ,
    //      $child_dataset_records                  ,
    //      $child_dataset_slug                     ,
    //      $child_dataset_title                    ,
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

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $selected_datasets_dmdd = array(
    //          ...
    //          'parent_details'                            =>  array(
    //              'type'                  =>  'single-parent-key-field'   .
    //              'type_specific_args'    =>  array(
    //                  'parent_dataset_slug'                       =>  'xxx'   ,
    //                  'parent_dataset_key_field_slug'             =>  'yyy'
    //                  )
    //              )
    //              //  This dataset's records ***may*** optionally have a PARENT.
    //              //  o   "parent_dataset_slug" must be a non-empty string.
    //              //  o   The array storage record's:-
    //              //          "<parent_dataset_key_field_slug>"
    //              //      field may contain either:-
    //              //          --  The empty string (in which case, this child
    //              //              record has NO parent), or;
    //              //          --  A "record key" from the parent dataset.
    //              //
    //              //  The dataset records may have CHILDREN too (see
    //              //  "child_dataset_slugs", below).
    //          ...
    //          'child_dataset_slugs'                       =>  array( 'shots' )
    //          ...
    //          )
    //
    // -------------------------------------------------------------------------

    // =========================================================================
    // Init.
    // =========================================================================

    $ns = __NAMESPACE__ ;
    $fn = __FUNCTION__  ;

    // =========================================================================
    // parent_dataset_slug ?
    // =========================================================================

    if ( ! array_key_exists( 'parent_dataset_slug' , $selected_datasets_dmdd['parent_details']['type_specific_args'] ) ) {

        return <<<EOT
PROBLEM:&nbsp; No <dataset-definition> + "parent_details" + "type_specific_args" + "parent_dataset_slug"
For dataset:&nbsp; {$dataset_title}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

    }

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\
    // is_dataset_slug(
    //      $candidate_dataset_slug                         ,
    //      $all_application_dataset_definitions = NULL
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // Is:-
    //      $candidate_dataset_slug
    //
    // a 1 to 64 character alphanumeric underscore string?
    //
    // ---
    //
    // And if:-
    //      $all_application_dataset_definitions
    //
    // is an ARRAY, we also check if:-
    //      $candidate_dataset_slug
    //
    // is a key of that array.
    //
    // ---
    //
    // RETURNS
    //      o   On SUCCESS
    //              TRUE
    //
    //      o   On FAILURE
    //              $error_message STRING
    // -------------------------------------------------------------------------

    $result = is_dataset_slug(
                    $selected_datasets_dmdd['parent_details']['type_specific_args']['parent_dataset_slug']  ,
                    $all_application_dataset_definitions
                    ) ;

    // -------------------------------------------------------------------------

    if ( is_string( $result ) ) {
        return $result ;
    }

    // =========================================================================
    // parent_dataset_key_field_slug ?
    // =========================================================================

    if ( ! array_key_exists( 'parent_dataset_key_field_slug' , $selected_datasets_dmdd['parent_details']['type_specific_args'] ) ) {

        return <<<EOT
PROBLEM:&nbsp; No <dataset-definition> + "parent_details" + "type_specific_args" + "parent_dataset_key_field_slug"
For dataset:&nbsp; {$dataset_title}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

    }

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\
    // is_field_slug(
    //      $candidate_field_slug
    //      )
    // - - - - - - - - - - - - -
    // Is:-
    //      $candidate_field_slug
    //
    // a 1 to 64 character alphanumeric underscore string?
    //
    // RETURNS
    //      o   On SUCCESS
    //              TRUE
    //
    //      o   On FAILURE
    //              $error_message STRING
    // -------------------------------------------------------------------------

    $result = is_field_slug(
                    $selected_datasets_dmdd['parent_details']['type_specific_args']['parent_dataset_key_field_slug']
                    ) ;

    // -------------------------------------------------------------------------

    if ( is_string( $result ) ) {
        return $result ;
    }

    // =========================================================================
    // Load the PARENT DATASET...
    // =========================================================================

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\
    // get_dataset_title_records_key_field_slug_and_record_indices_by_key(
    //      $all_application_dataset_definitions    ,
    //      $dataset_slug
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - -
    // RETURNS
    //      o   On SUCCESS
    //              ARRAY(
    //                  $dataset_title                  STRING
    //                  $dataset_records                ARRAY
    //                  $array_storage_key_field_slug   STRING
    //                  $record_indices_by_key          ARRAY
    //                  )
    //
    //      o   On FAILURE
    //              $error_message STRING
    // -------------------------------------------------------------------------

    $result = get_dataset_title_records_key_field_slug_and_record_indices_by_key(
                    $all_application_dataset_definitions                                                    ,
                    $selected_datasets_dmdd['parent_details']['type_specific_args']['parent_dataset_slug']
                    ) ;

    // -------------------------------------------------------------------------

    if ( is_string( $result ) ) {
        return $result ;
    }

    // -------------------------------------------------------------------------

    list(
        $parent_dataset_title               ,
        $parent_dataset_records             ,
        $parent_dataset_key_field_slug      ,
        $parent_record_indices_by_key
        ) = $result ;

    // =========================================================================
    // LOOP over the CHILD dataset records, to find the ORPHANED ones
    // (if any)...
    // =========================================================================

    $child_datasets_parent_key_field_slug =
        $selected_datasets_dmdd['parent_details']['type_specific_args']['parent_dataset_key_field_slug']
        ;

    // -------------------------------------------------------------------------

    $orphaned_record_indices = array() ;

    // -------------------------------------------------------------------------

    foreach ( $child_dataset_records as $this_child_index => $this_child_data ) {

        // ---------------------------------------------------------------------

        if ( ! array_key_exists(
                    $child_datasets_parent_key_field_slug       ,
                    $this_child_data
                    )
            ) {

            return <<<EOT
PROBLEM:&nbsp; No "{$child_datasets_parent_key_field_slug}" field (in child record)
For dataset:&nbsp; {$child_dataset_title}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        }

        // ---------------------------------------------------------------------

        $parent_key = $this_child_data[ $child_datasets_parent_key_field_slug ] ;

        // ---------------------------------------------------------------------
        // We'll class child records with an invalid parent key as
        // ORPHANED records...
        // ---------------------------------------------------------------------

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
        // ---------------------------------------------------------------------------

        if ( is_record_key( $parent_key ) !== TRUE ) {
            $orphaned_record_indices[] = $this_child_index ;
            continue ;
        }

        // ---------------------------------------------------------------------

        if ( ! array_key_exists(
                    $parent_key                     ,
                    $parent_record_indices_by_key
                    )
            ) {
            $orphaned_record_indices[] = $this_child_index ;
        }

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // SUCCESS!
    // =========================================================================

    return $orphaned_record_indices ;

    // =========================================================================
    // That's that!
    // =========================================================================

}

// =============================================================================
// get_orphaned_record_indices_by_parent_type_and_key_fields()
// =============================================================================

function get_orphaned_record_indices_by_parent_type_and_key_fields(
    $all_application_dataset_definitions    ,
    $caller_apps_includes_dir               ,
    $selected_datasets_dmdd                 ,
    $child_dataset_records                  ,
    $child_dataset_slug                     ,
    $child_dataset_title                    ,
    $question_front_end
    ) {

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\
    // get_orphaned_record_indices_by_parent_type_and_key_fields(
    //      $all_application_dataset_definitions    ,
    //      $caller_apps_includes_dir               ,
    //      $selected_datasets_dmdd                 ,
    //      $child_dataset_records                  ,
    //      $child_dataset_slug                     ,
    //      $child_dataset_title                    ,
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

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $selected_datasets_dmdd = array(
    //          ...
    //          'parent_details'                            =>  array(
    //              'type'                  =>  'parent-type-and-key-fields'
    //              'type_specific_args'    =>  array(
    //                  'parent_type_field_slug'            =>  'parent_is'     ,
    //                  'parent_key_field_slug'             =>  'parent_key'    ,
    //                  'parent_dataset_slugs_by_value'     =>  array(
    //                      'document'  =>  'documents'     ,
    //                      'section'   =>  'sections'
    //                      )
    //                  )
    //              )
    //              //  This dataset's records ***may*** optionally have a PARENT.
    //              //  o   If the "parent_type_field_slug" field contains the
    //              //      empty string, then this record has NO parent (and
    //              //      the "parent_key_field_slug" field in IGNORED).
    //              //  o   If the "parent_type_field_slug" field contains a
    //              //      non-empty string, then the:-
    //              //          "parent_dataset_slugs_by_value"
    //              //      field maps values in the "parent_type_field_slug"
    //              //      field, to the dataset the record belongs to.
    //              //
    //              //  The dataset records may have CHILDREN too (see
    //              //  "child_dataset_slugs", below).
    //          ...
    //          'child_dataset_slugs'                       =>  array( 'shots' )
    //          ...
    //          )
    //
    // -------------------------------------------------------------------------

    // =========================================================================
    // Init.
    // =========================================================================

    $ns = __NAMESPACE__ ;
    $fn = __FUNCTION__  ;

    // =========================================================================
    // parent_type_field_slug ?
    // =========================================================================

    if ( ! array_key_exists( 'parent_type_field_slug' , $selected_datasets_dmdd['parent_details']['type_specific_args'] ) ) {

        return <<<EOT
PROBLEM:&nbsp; No <dataset-definition> + "parent_details" + "type_specific_args" + "parent_type_field_slug"
For dataset:&nbsp; {$dataset_title}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

    }

    // -------------------------------------------------------------------------

    if (    ! is_string( $selected_datasets_dmdd['parent_details']['type_specific_args']['parent_type_field_slug'] )
            ||
            (   trim( $selected_datasets_dmdd['parent_details']['type_specific_args']['parent_type_field_slug'] ) !== ''
                &&
                ! \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_stringUtils\ctype_alphanumeric_underscore_dash(
                        $selected_datasets_dmdd['parent_details']['type_specific_args']['parent_type_field_slug']
                        )
            )
        ) {

        return <<<EOT
PROBLEM:&nbsp; No <dataset-definition> + "parent_details" + "type_specific_args" + "parent_type_field_slug" (empty or alphanumeric underscore dash string expected)
For dataset:&nbsp; {$dataset_title}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

    }

    // =========================================================================
    // parent_key_field_slug ?
    // =========================================================================

    if ( ! array_key_exists( 'parent_key_field_slug' , $selected_datasets_dmdd['parent_details']['type_specific_args'] ) ) {

        return <<<EOT
PROBLEM:&nbsp; No <dataset-definition> + "parent_details" + "type_specific_args" + "parent_key_field_slug"
For dataset:&nbsp; {$dataset_title}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

    }

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\
    // is_field_slug(
    //      $candidate_field_slug
    //      )
    // - - - - - - - - - - - - -
    // Is:-
    //      $candidate_field_slug
    //
    // a 1 to 64 character alphanumeric underscore string?
    //
    // RETURNS
    //      o   On SUCCESS
    //              TRUE
    //
    //      o   On FAILURE
    //              $error_message STRING
    // -------------------------------------------------------------------------

    $result = is_field_slug(
                    $selected_datasets_dmdd['parent_details']['type_specific_args']['parent_key_field_slug']
                    ) ;

    // -------------------------------------------------------------------------

    if ( is_string( $result ) ) {
        return $result ;
    }

    // =========================================================================
    // parent_dataset_slugs_by_value ?
    // =========================================================================

    if ( ! array_key_exists( 'parent_dataset_slugs_by_value' , $selected_datasets_dmdd['parent_details']['type_specific_args'] ) ) {

        return <<<EOT
PROBLEM:&nbsp; No <dataset-definition> + "parent_details" + "type_specific_args" + "parent_dataset_slugs_by_value"
For dataset:&nbsp; {$dataset_title}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

    }

    // -------------------------------------------------------------------------

    if ( ! is_array( $selected_datasets_dmdd['parent_details']['type_specific_args']['parent_dataset_slugs_by_value'] ) ) {

        return <<<EOT
PROBLEM:&nbsp; Bad <dataset-definition> + "parent_details" + "type_specific_args" + "parent_dataset_slugs_by_value" (array expected)
For dataset:&nbsp; {$dataset_title}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

    }

    // -------------------------------------------------------------------------

    foreach (   $selected_datasets_dmdd['parent_details']['type_specific_args']['parent_dataset_slugs_by_value']
                as
                $this_type => $this_dataset_slug
        ) {

        // ---------------------------------------------------------------------

        if (    trim( $this_dataset_slug ) !== ''
                &&
                ! array_key_exists( $this_dataset_slug , $all_application_dataset_definitions )
            ) {

            $safe_dataset_slug = htmlentities( $this_dataset_slug ) ;

            return <<<EOT
PROBLEM:&nbsp; Bad <dataset-definition> + "parent_details" + "type_specific_args" + "parent_dataset_slugs_by_value" (dataset slug "{$safe_dataset_slug}" not recognised/supported)
For dataset:&nbsp; {$dataset_title}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        }

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // LOOP over the CHILD dataset records, to find the ORPHANED ones
    // (if any)...
    // =========================================================================

    $parent_type_field_slug =
        $selected_datasets_dmdd['parent_details']['type_specific_args']['parent_type_field_slug']
        ;

    // -------------------------------------------------------------------------

    $parent_key_field_slug =
        $selected_datasets_dmdd['parent_details']['type_specific_args']['parent_key_field_slug']
        ;

    // -------------------------------------------------------------------------

    $parent_dataset_slugs_by_type =
        $selected_datasets_dmdd['parent_details']['type_specific_args']['parent_dataset_slugs_by_value']
        ;

    // -------------------------------------------------------------------------

    $orphaned_record_indices = array() ;

    // -------------------------------------------------------------------------

    $loaded_parent_datasets = array() ;

    // -------------------------------------------------------------------------

    foreach ( $child_dataset_records as $this_child_index => $this_child_data ) {

        // ---------------------------------------------------------------------

        if ( ! array_key_exists(
                    $parent_type_field_slug     ,
                    $this_child_data
                    )
            ) {

            return <<<EOT
PROBLEM:&nbsp; No "{$parent_type_field_slug}" field (in child record)
For dataset:&nbsp; {$child_dataset_title}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        }

        // ---------------------------------------------------------------------

        if ( ! array_key_exists(
                    $parent_key_field_slug      ,
                    $this_child_data
                    )
            ) {

            return <<<EOT
PROBLEM:&nbsp; No "{$parent_key_field_slug}" field (in child record)
For dataset:&nbsp; {$child_dataset_title}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        }

        // ---------------------------------------------------------------------

        $parent_type = $this_child_data[ $parent_type_field_slug ] ;

        // ---------------------------------------------------------------------
        // Records with an unrecognised/unsupported "parent_type" are
        // treated as ORPHANED records...
        // ---------------------------------------------------------------------

        if ( ! array_key_exists(
                    $parent_type                    ,
                    $parent_dataset_slugs_by_type
                    )
            ) {
            $orphaned_record_indices[] = $this_child_index ;
            continue ;
        }

        // ---------------------------------------------------------------------

        $parent_dataset_slug = $parent_dataset_slugs_by_type[ $parent_type ] ;

        // ---------------------------------------------------------------------
        // Load the PARENT dataset, if necessary...
        // ---------------------------------------------------------------------

        if ( ! array_key_exists( $parent_dataset_slug , $loaded_parent_datasets ) ) {

            // -------------------------------------------------------------------------
            // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\
            // get_dataset_title_records_key_field_slug_and_record_indices_by_key(
            //      $all_application_dataset_definitions    ,
            //      $dataset_slug
            //      )
            // - - - - - - - - - - - - - - - - - - - - - - -
            // RETURNS
            //      o   On SUCCESS
            //              ARRAY(
            //                  $dataset_title                  STRING
            //                  $dataset_records                ARRAY
            //                  $array_storage_key_field_slug   STRING
            //                  $record_indices_by_key          ARRAY
            //                  )
            //
            //      o   On FAILURE
            //              $error_message STRING
            // -------------------------------------------------------------------------

            $result = get_dataset_title_records_key_field_slug_and_record_indices_by_key(
                            $all_application_dataset_definitions    ,
                            $parent_dataset_slug
                            ) ;

            // -----------------------------------------------------------------

            if ( is_string( $result ) ) {
                return $result ;
            }

            // -----------------------------------------------------------------

            list(
                $parent_dataset_title               ,
                $parent_dataset_records             ,
                $parent_dataset_key_field_slug      ,
                $parent_record_indices_by_key
                ) = $result ;

            // -----------------------------------------------------------------

            $loaded_parent_datasets[ $parent_dataset_slug ] = array(
                'title'                     =>  $parent_dataset_title               ,
                'records'                   =>  $parent_dataset_records             ,
                'key_field_slug'            =>  $parent_dataset_key_field_slug      ,
                'record_indices_by_key'     =>  $parent_record_indices_by_key
                ) ;

            // -----------------------------------------------------------------

        }

        // ---------------------------------------------------------------------
        // Get the parent record's key...
        // ---------------------------------------------------------------------

        $parent_key = $this_child_data[ $parent_key_field_slug ] ;

        // ---------------------------------------------------------------------
        // We'll class child records with an invalid parent key as
        // ORPHANED records...
        // ---------------------------------------------------------------------

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
        // ---------------------------------------------------------------------------

        if ( is_record_key( $parent_key ) !== TRUE ) {
            $orphaned_record_indices[] = $this_child_index ;
            continue ;
        }

        // ---------------------------------------------------------------------
        // Parent record exists ?
        // ---------------------------------------------------------------------

        if ( ! array_key_exists(
                    $parent_key                                                                 ,
                    $loaded_parent_datasets[ $parent_dataset_slug ]['record_indices_by_key']
                    )
            ) {
            $orphaned_record_indices[] = $this_child_index ;
        }

        // ---------------------------------------------------------------------
        // Repeat with the next child record (if there is one)...
        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // SUCCESS!
    // =========================================================================

    return $orphaned_record_indices ;

    // =========================================================================
    // That's that!
    // =========================================================================

}

// =============================================================================
// get_orphaned_records_table_html()
// =============================================================================

function get_orphaned_records_table_html(
    $all_application_dataset_definitions    ,
    $caller_apps_includes_dir               ,
    $selected_datasets_dmdd                 ,
    $dataset_records                        ,
    $dataset_slug                           ,
    $dataset_title                          ,
    $question_front_end                     ,
    $orphaned_record_indices                ,
    $data_for
    ) {

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

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $selected_datasets_dmdd ) ;

    // =========================================================================
    // If NO orphaned records, return a:-
    //      "NO orphaned records"
    //
    // message...
    // =========================================================================

    if ( count( $orphaned_record_indices ) < 1 ) {

        return <<<EOT
This dataset has NO ORPHANED RECORDS...
EOT;

    }

    // =========================================================================
    // Get the dataset's "key field slug"...
    // =========================================================================

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\
    // get_dataset_key_field_slug(
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

    // -------------------------------------------------------------------------

    if ( is_array( $key_field_slug ) ) {
        return $key_field_slug ;
    }

    // =========================================================================
    // Get the output table column titles and slugs (from the array storage
    // record structure)...
    // =========================================================================

    $columns_titles_by_field_slug = array() ;

    // -------------------------------------------------------------------------

    foreach ( $selected_datasets_dmdd['array_storage_record_structure'] as $this_array_storage_field ) {

        // ---------------------------------------------------------------------
        // Here we should have (eg):-
        //
        //      $this_array_storage_field = array(
        //          [slug]          => parent_key
        //          [value_from]    => Array(
        //                                  [method] => post
        //                                  [instance] => parent_key
        //                                  )
        //          [constraints]   => Array(
        //                                  [0] => Array(
        //                                              [method] => unique-key
        //                                              )
        //                                  )
        //          )
        //
        // ---------------------------------------------------------------------

//pr( $this_array_storage_field ) ;

        $columns_titles_by_field_slug[ $this_array_storage_field['slug'] ] =
            \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_stringUtils\to_title( $this_array_storage_field['slug'] )
            ;

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // Dump the orphaned records into an HTML table...
    // =========================================================================

    // -------------------------------------------------------------------------
    // Table Header
    // -------------------------------------------------------------------------

    $table_header_cols = '' ;

    $comma = '' ;

    // -------------------------------------------------------------------------

    foreach ( $columns_titles_by_field_slug as $this_field_slug => $this_column_title ) {

        $table_header_cols .= <<<EOT
{$comma}<th>{$this_column_title}</th>
EOT;

        $comma = "\n" ;

    }

    // -------------------------------------------------------------------------

    $table_header_cols .= <<<EOT
{$comma}<th>Action</th>
EOT;

    // -------------------------------------------------------------------------
    // Table Body
    // -------------------------------------------------------------------------

    $table_rows = '' ;

    $outer_comma = '' ;

    // -------------------------------------------------------------------------

    foreach ( $orphaned_record_indices as $this_dataset_record_index ) {

        // ---------------------------------------------------------------------

        $this_dataset_record = $dataset_records[ $this_dataset_record_index ] ;

        // ---------------------------------------------------------------------

        $data_cols = '' ;

        $inner_comma = '' ;

        // ---------------------------------------------------------------------

        foreach ( $columns_titles_by_field_slug as $this_field_slug => $this_column_title ) {

            $data_cols .= <<<EOT
{$inner_comma}<td>{$this_dataset_record[$this_field_slug]}</td>
EOT;

            $inner_comma = "\n" ;

        }

        // ---------------------------------------------------------------------

        $data_cols .= <<<EOT
{$inner_comma}<td><a
    href="javascript:void()"
    style="text-decoration:none"
    onclick="greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager_questionDeleteRecord(this,'{$this_dataset_record[ $key_field_slug ]}')"
    >delete</a></td>
EOT;

        // ---------------------------------------------------------------------

        $table_rows .= <<<EOT
{$outer_comma}<tr>{$data_cols}</tr>
EOT;

        $outer_comma = "\n" ;

        // ---------------------------------------------------------------------

    }

    // -------------------------------------------------------------------------
    // The Complete Table
    // -------------------------------------------------------------------------

    $output_table = <<<EOT
<table border="1" cellpadding="2" cellspacing="0">
<tr>{$table_header_cols}</tr>
{$table_rows}
</table>
EOT;

    // =========================================================================
    // SUCCESS!
    // =========================================================================

    return $output_table ;

    // =========================================================================
    // That's that!
    // =========================================================================

}

// =============================================================================
// delete_orphaned_records()
// =============================================================================

function delete_orphaned_records(
    $all_application_dataset_definitions    ,
    $caller_apps_includes_dir               ,
    $selected_datasets_dmdd                 ,
    &$dataset_records                       ,
    $dataset_slug                           ,
    $dataset_title                          ,
    $question_front_end                     ,
    $orphaned_record_indices
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

    // =========================================================================
    // DELETE the ORPHANED RECORDS from $dataset_records...
    // =========================================================================

    foreach ( $orphaned_record_indices as $this_dataset_record_index ) {
        unset( $dataset_records[ $this_dataset_record_index ] ) ;
    }

    // =========================================================================
    // SAVE the updated dataset back to disk...
    // =========================================================================

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_arrayStorage\save_numerically_indexed(
    //      $dataset_name                       ,
    //      $array_to_save                      ,
    //      $question_die_on_error = FALSE
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - - - -
    // Saves the specified numerically-indexed PHP array.
    //
    // RETURNS
    //      o   On SUCCESS
    //          - - - - -
    //          TRUE
    //
    //      o   On FAILURE
    //          - - - - -
    //          $error message STRING
    // -------------------------------------------------------------------------

    $question_die_on_error = FALSE ;

    // -------------------------------------------------------------------------

    return \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_arrayStorage\save_numerically_indexed(
                $dataset_slug               ,
                $dataset_records            ,
                $question_die_on_error
                ) ;

    // =========================================================================
    // That's that!
    // =========================================================================

}

// =============================================================================
// That's that!
// =============================================================================

