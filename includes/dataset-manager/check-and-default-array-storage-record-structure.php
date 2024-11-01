<?php

// *****************************************************************************
// DATASET-MANAGER / CHECK-AND-DEFAULT-ARRAY-STORAGE-RECORD-STRUCTURE.PHP
// (C) 2013 Peter Newman. All Rights Reserved
// *****************************************************************************

    namespace greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager ;

// =============================================================================
// check_and_default_array_storage_record_structure()
// =============================================================================

function check_and_default_array_storage_record_structure(
    $caller_app_slash_plugins_global_namespace      ,
    $dataset_manager_home_page_title                ,
    $caller_apps_includes_dir                       ,
    &$all_application_dataset_definitions           ,
    &$selected_datasets_dmdd                        ,
    $dataset_records                                ,
    $dataset_title                                  ,
    $dataset_slug
    ) {

    // -------------------------------------------------------------------------
    // check_and_default_array_storage_record_structure(
    //      $caller_app_slash_plugins_global_namespace      ,
    //      $dataset_manager_home_page_title                ,
    //      $caller_apps_includes_dir                       ,
    //      &$all_application_dataset_definitions           ,
    //      &$selected_datasets_dmdd                        ,
    //      $dataset_records                                ,
    //      $dataset_title                                  ,
    //      $dataset_slug
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // Checks for:-
    //      $selected_datasets_dmdd['array_storage_record_structure']
    //
    // defaulting it and it's members as necessary.
    //
    // On successful return, we know that:-
    //      $selected_datasets_dmdd['array_storage_record_structure']
    //
    // is like:-
    //
    //      $selected_datasets_dmdd['array_storage_record_structure'] = array(
    //          'checked_defaulted_ok'  =>  TRUE    ,
    //          array(
    //              'slug'          =>  '<1 to 64 character variable name like string>'
    //              'value_from'    =>  array(
    //                                      'method'    =>  '<1 to 64 character alphanumeric underscore dash like string>'
    //                                      ...0 to 2 more args...
    //                                      )
    //              )
    //          ...
    //          )
    //
    // So for all fields:-
    //      o   "slug" is set and valid
    //      o   "value_from" is an array - with at least a "method" element.
    //          Where the method name looks to be valid.
    //
    // However:-
    //      o   Whether or not the field's method name is recognised/supported,
    //          and;
    //      o   Whether or not the field's "instance" and "args" elements are
    //          supplied and valid for the method concerned, has NOT been
    //          checked.
    //
    // RETURNS:-
    //      On SUCCESS!
    //      - - - - - -
    //      TRUE
    //      And the caller's:-
    //          $all_application_dataset_definitions, and;
    //          $selected_datasets_dmdd
    //      have been updated as follows:-
    //          o   ...['array_storage_record_structure']['checked_defaulted_ok'] = TRUE
    //          o   With the remaining "array_storage_record_structure"
    //              elements defaulted as required
    //
    //      On FAILURE!
    //      - - - - - -
    //      $error_message STRING
    // -------------------------------------------------------------------------

    // -------------------------------------------------------------------------
    // $selected_datasets_dmdd['array_storage_record_structure'] should be
    // like (eg):-
    //
    //      $selected_datasets_dmdd['array_storage_record_structure'] = array(
    //
    //          // ---------------------------------------------------------------------
    //          //
    //          //  'slug'  MUST be specified (variable name type string)
    //          //
    //          //  'value_from'    OPTIONAL
    //          //
    //          //      o   If specified, must be one of:-
    //          //
    //          //          #   array(
    //          //                  'method'    =>  'created-server-datetime-utc'
    //          //                  //  "instance" and "args", if specified, are IGNORED
    //          //                  )
    //          //
    //          //          #   array(
    //          //                  'method'    =>  'last-modified-server-datetime-utc'
    //          //                  //  "instance" and "args", if specified, are IGNORED
    //          //                  )
    //          //
    //          //          #   array(
    //          //                  'method'    =>  'unique-key'
    //          //                  //  "instance" and "args", if specified, are IGNORED
    //          //                  )
    //          //
    //          //          #   array(
    //          //                  'method'    =>  'literal'           ,
    //          //                  'instance'  =>  <any-PHP-value>
    //          //                  //  "args", if specified, is IGNORED
    //          //                  )
    //          //
    //          //          #   array(
    //          //                  'method'    =>  'get'               ,
    //          //                  'instance'  =>  '<get-var-name>'
    //          //                  //  If "instance" is unspecified - or is anything but a
    //          //                  //  non-empty string, then '<get-var-name>' defaults to
    //          //                  //  the field's "slug"
    //          //                  //  "args", if specified, is IGNORED
    //          //                  )
    //          //
    //          //          #   array(
    //          //                  'method'    =>  'post'              ,
    //          //                  'instance'  =>  '<post-var-name>'
    //          //                  //  If "instance" is unspecified - or is anything but a
    //          //                  //  non-empty string, then '<post-var-name>' defaults to
    //          //                  //  the field's "slug"
    //          //                  //  "args", if specified, is IGNORED
    //          //                  )
    //          //
    //          //          #   array(
    //          //                  'method'    =>  'server'                ,
    //          //                  'instance'  =>  '<server-var-name>'
    //          //                  //  If "instance" is unspecified - or is anything but a
    //          //                  //  non-empty string, then '<server-var-name>' defaults to
    //          //                  //  the field's "slug"
    //          //                  //  "args", if specified, is IGNORED
    //          //                  )
    //          //
    //          //          #   array(
    //          //                  'method'    =>  'cookie'                ,
    //          //                  'instance'  =>  '<cookie-var-name>'
    //          //                  //  If "instance" is unspecified - or is anything but a
    //          //                  //  non-empty string, then '<cookie-var-name>' defaults to
    //          //                  //  the field's "slug"
    //          //                  //  "args", if specified, is IGNORED
    //          //                  )
    //          //
    //          //          #   array(
    //          //                  'method'    =>  'function'                                          ,
    //          //                  'instance'  =>  '<function-name-including-namespace-if-necessary>'  ,
    //          //                  'args'      =>  <any-PHP-value>
    //          //                                  Though if multiple values are to be
    //          //                                  supplied, will usually be an
    //          //                                  associative array.  Eg:-
    //          //                                      array(
    //          //                                          'name_1'        =>  <value_1>
    //          //                                          'name_2'        =>  <value_2>
    //          //                                          ...                 ...
    //          //                                          'name_N'        =>  <value_N>
    //          //                                          )
    //          //                  )
    //          //
    //          //      o   If NOT specified, the field's value will be set to the
    //          //          empty string.
    //          //
    //          // ---------------------------------------------------------------------
    //
    //          array(
    //              'slug'          =>  'created_server_datetime_UTC'      ,
    //              'value_from'    =>  array(
    //                                      'method'    =>  'created-server-datetime-utc'
    //                                      )
    //              )   ,
    //
    //          array(
    //              'slug'          =>  'last_modified_server_datetime_UTC'    ,
    //              'value_from'    =>  array(
    //                                      'method'    =>  'last-modified-server-datetime-utc'
    //                                      )
    //              )   ,
    //
    //          array(
    //              'slug'          =>  'key'       ,
    //              'value_from'    =>  array(
    //                                      'method'    =>  'unique-key'
    //                                      )
    //              )   ,
    //
    //          array(
    //              'slug'          =>  'parent_key'    ,
    //              'value_from'    =>  array(
    //                                      'method'    =>  'post'          ,
    //                                      'instance'  =>  'parent_key'
    //                                      )
    //              )   ,
    //
    //          array(
    //              'slug'          =>  'parent_is'     ,       //  "project" or "category"
    //              'value_from'    =>  array(
    //                                      'method'    =>  'post'          ,
    //                                      'instance'  =>  'parent_is'
    //                                      )
    //              )   ,
    //
    //          array(
    //              'slug'          =>  'title'         ,
    //              'value_from'    =>  array(
    //                                      'method'    =>  'post'      ,
    //                                      'instance'  =>  'title'
    //                                      )
    //              )   ,
    //
    //          array(
    //              'slug'          =>  'notes_slash_comments'      ,
    //              'value_from'    =>  array(
    //                                      'method'    =>  'post'                      ,
    //                                      'instance'  =>  'notes_slash_comments'
    //                                      )
    //              )
    //
    //          ) ;
    //
    //
    // -------------------------------------------------------------------------

    // =========================================================================
    // ISSET ?
    // =========================================================================

    if (    $selected_datasets_dmdd['array_storage_record_structure'] === NULL
            ||
            ! isset( $selected_datasets_dmdd['array_storage_record_structure'] )
        ) {

        return <<<EOT
PROBLEM:&nbsp; No "array storage record structure"
For dataset:&nbsp; "{$dataset_title}"
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\check_and_default_array_storage_record_structure()
EOT;

    }

    // =========================================================================
    // IS_ARRAY ?
    // =========================================================================

    if ( ! is_array( $selected_datasets_dmdd['array_storage_record_structure'] ) ) {

        return <<<EOT
PROBLEM:&nbsp; Bad "array storage record structure" (not an array)
For dataset:&nbsp; "{$dataset_title}"
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\check_and_default_array_storage_record_structure()
EOT;

    }

    // =========================================================================
    // ALREADY CHECKED AND DEFAULTED OK ?
    // =========================================================================

    if (    isset( $selected_datasets_dmdd['array_storage_record_structure']['checked_defaulted_ok'] )
            &&
            $selected_datasets_dmdd['array_storage_record_structure']['checked_defaulted_ok'] === TRUE
        ) {
        return TRUE ;
    }

    // =========================================================================
    // Init. the checked/defaulted version...
    // =========================================================================

    $new_array_storage_record_structure =
        $selected_datasets_dmdd['array_storage_record_structure']
        ;

    // =========================================================================
    // Do the CHECK/DEFAULT PROPER...
    // =========================================================================

    foreach ( $selected_datasets_dmdd['array_storage_record_structure'] as $this_index => $this_field ) {

        // ---------------------------------------------------------------------

        $field_number = $this_index + 1 ;

        // =====================================================================
        // IS_ARRAY ?
        // =====================================================================

        if ( ! is_array( $this_field ) ) {

            return <<<EOT
PROBLEM:&nbsp; Bad "array storage record structure" field# {$field_number} (not an array)
For dataset:&nbsp; "{$dataset_title}"
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\check_and_default_array_storage_record_structure()
EOT;

        }

        // =====================================================================
        // slug ?
        // =====================================================================

        if ( ! array_key_exists( 'slug' , $this_field ) ) {

            return <<<EOT
PROBLEM:&nbsp; Bad "array storage record structure" field# {$field_number} (no "slug")
For dataset:&nbsp; "{$dataset_title}"
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\check_and_default_array_storage_record_structure()
EOT;

        }

        // ---------------------------------------------------------------------

        if (    ! is_string( $this_field['slug'] )
                ||
                trim( $this_field['slug'] ) === ''
                ||
                ! \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_stringUtils\ctype_varname( $this_field['slug'] )
                ||
                strlen( $this_field['slug'] ) > 64
            ) {

            return <<<EOT
PROBLEM:&nbsp; Bad "array storage record structure" field# {$field_number} (bad "slug" - must be 1 to 64 character, variable name like string)
For dataset:&nbsp; "{$dataset_title}"
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\check_and_default_array_storage_record_structure()
EOT;

        }

        // =====================================================================
        // value_from ?
        // =====================================================================

        // ---------------------------------------------------------------------
        // DEFAULTS to:
        //      array(
        //          'method'    =>  'literal'   ,
        //          'instance'  =>  ''
        //          )
        // ---------------------------------------------------------------------

        if ( ! array_key_exists( 'value_from' , $this_field ) ) {

            $new_array_storage_record_structure[ $this_index ] =
                array(
                    'method'    =>  'literal'   ,
                    'instance'  =>  ''
                    ) ;

            continue ;

        }

        // ---------------------------------------------------------------------

        if ( ! is_array( $this_field['value_from'] ) ) {

            return <<<EOT
PROBLEM:&nbsp; Bad "array storage record structure" field# {$field_number} (bad "value_from" - array expected)
For dataset:&nbsp; "{$dataset_title}"
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\check_and_default_array_storage_record_structure()
EOT;

        }

        // ---------------------------------------------------------------------

        if (    count( $this_field['value_from'] ) < 1
                ||
                count( $this_field['value_from'] ) > 3
            ) {

            return <<<EOT
PROBLEM:&nbsp; Bad "array storage record structure" field# {$field_number} (bad "value_from" - 1 to 3 element array expected)
For dataset:&nbsp; "{$dataset_title}"
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\check_and_default_array_storage_record_structure()
EOT;

        }

        // ---------------------------------------------------------------------
        // method ?
        // ---------------------------------------------------------------------

        if ( ! array_key_exists( 'method' , $this_field['value_from'] ) ) {

            return <<<EOT
PROBLEM:&nbsp; Bad "array storage record structure" field# {$field_number} (no "value_from" + "method")
For dataset:&nbsp; "{$dataset_title}"
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\check_and_default_array_storage_record_structure()
EOT;

        }

        // ---------------------------------------------------------------------

        if (    ! is_string( $this_field['value_from']['method'] )
                ||
                trim( $this_field['value_from']['method'] ) === ''
                ||
                ! \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_stringUtils\ctype_alphanumeric_underscore_dash( $this_field['value_from']['method'] )
                ||
                strlen( $this_field['value_from']['method'] ) > 64
            ) {

            return <<<EOT
PROBLEM:&nbsp; Bad "array storage record structure" field# {$field_number} (bad "value_from" + "method" - 1 to 64 character alphanumeric, underscore, dash only string expected)
For dataset:&nbsp; "{$dataset_title}"
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\check_and_default_array_storage_record_structure()
EOT;

        }

        // =====================================================================
        // Check the NEXT FIELD (if there is one)...
        // =====================================================================

    }

    // =========================================================================
    // SUCCESS!
    // =========================================================================

    $new_array_storage_record_structure['checked_defaulted_ok'] = TRUE ;

    // -------------------------------------------------------------------------

    $selected_datasets_dmdd['array_storage_record_structure'] =
        $new_array_storage_record_structure
        ;

    // -------------------------------------------------------------------------

    $all_application_dataset_definitions[ $dataset_slug ]['array_storage_record_structure'] =
        $new_array_storage_record_structure
        ;

    // -------------------------------------------------------------------------

    return TRUE ;

    // =========================================================================
    // That's that!
    // =========================================================================

}

// =============================================================================
// That's that!
// =============================================================================

