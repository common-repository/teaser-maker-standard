<?php

// *****************************************************************************
// DATASET-MANAGER / ADD-EDIT-RECORD_SUBMISSION-HANDLER.PHP
// (C) 2013 Peter Newman. All Rights Reserved.
// *****************************************************************************

    namespace greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager ;

// =============================================================================
// handle_zebra_form_submission()
// =============================================================================

function handle_zebra_form_submission(
    $caller_app_slash_plugins_global_namespace      ,
    $dataset_manager_home_page_title                ,
    $caller_apps_includes_dir                       ,
    $all_application_dataset_definitions            ,
    $dataset_slug                                   ,
    $selected_datasets_dmdd                         ,
    $dataset_title                                  ,
    $dataset_records                                ,
    $record_indices_by_key                          ,
    $key_field_slug                                 ,
    $question_adding                                ,
    $zebra_form_obj                                 ,
    $form_slug_underscored
    ) {

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\handle_zebra_form_submission(
    //      $caller_app_slash_plugins_global_namespace      ,
    //      $dataset_manager_home_page_title                ,
    //      $caller_apps_includes_dir                       ,
    //      $all_application_dataset_definitions            ,
    //      $dataset_slug                                   ,
    //      $selected_datasets_dmdd                         ,
    //      $dataset_title                                  ,
    //      $dataset_records                                ,
    //      $record_indices_by_key                          ,
    //      $key_field_slug                                 ,
    //      $question_adding                                ,
    //      $zebra_form_obj                                 ,
    //      $form_slug_underscored
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // RETURNS
    //      o   On SUCCESS!
    //              TRUE
    //
    //      o   On FAILURE
    //              array(
    //                  $error_message    STRING
    //                  $error_field_slug STRING
    //                  )
    //          NOTE! If the error is a generic one - that belongs to no
    //                specific field - then $error_field_slug will be the empty
    //                string.
    // -------------------------------------------------------------------------

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $selected_datasets_dmdd = Array(
    //
    //          [dataset_slug] => categories
    //          [dataset_name_singular]     => category
    //          [dataset_name_plural]       => categories
    //          [dataset_title_singular]    => Category
    //          [dataset_title_plural]      => Categories
    //          [basepress_dataset_handle]  => Array(
    //              [nice_name]     => researchAssistant_byFernTec_categories
    //              [unique_key]    => 6934fccc-c552-46b0-8db5-87a02...d9af7adf54
    //              [version]       => 0.1
    //              )
    //
    //          [dataset_records_table] => Array(
    //
    //              [columns] => Array(
    //
    //                  [0] => Array(
    //                              [column_title]                  => Project
    //                              [data_field_slug]               => project_title
    //                              [question_sortable]             => 1
    //                              [data_field_slug_to_sort_by]    =>
    //                              [column_slug]                   =>
    //                              )
    //
    //                  [1] => Array(
    //                              [column_title]                  => Title
    //                              [data_field_slug]               => title
    //                              [question_sortable]             => 1
    //                              [data_field_slug_to_sort_by]    =>
    //                              [column_slug]                   =>
    //                              )
    //
    //                  [2] => Array(
    //                              [column_title]                  => Action
    //                              [data_field_slug]               => action
    //                              [question_sortable]             =>
    //                              [column_slug]                   =>
    //                              )
    //
    //                  )
    //
    //              [data_field_defs] => Array(
    //
    //                  [0] => Array(
    //                              [data_field_slug]       => project_title
    //                              [value_from]            => Array(
    //                                                              [method]    => foreign-field
    //                                                              [instance]  => title
    //                                                              [args]      => Array(
    //                                                                              [parent_key] => projects
    //                                                                              )
    //                                                              )
    //                              [treatments]            => Array()
    //                              [treatment_function]    =>
    //                              )
    //
    //                  [1] => Array(
    //                              [data_field_slug]       => title
    //                              [value_from]            => Array(
    //                                  [method]    => array-storage-field-slug
    //                                  [instance]  => title
    //                                  )
    //                              [treatments]            =>
    //                              [treatment_function]    =>
    //                              )
    //
    //                  [2] => Array(
    //                              [data_field_slug]       =>
    //                              [value_from]            => Array(
    //                                  [method]    => special-type
    //                                  [instance]  => action
    //                                  )
    //                              )
    //
    //                  )
    //
    //              [rows_per_page]                         => 10
    //              [default_data_field_slug_to_orderby]    => title
    //              [default_order]                         => asc
    //              [actions]                               => Array(
    //                                                              [edit]   => edit
    //                                                              [delete] => delete
    //                                                              )
    //              [action_separator]                      =>
    //
    //              )
    //
    //          [zebra_form] => Array(
    //
    //              [form_specs] => Array(
    //                                  [name]                  => add_edit_category
    //                                  [method]                => POST
    //                                  [action]                =>
    //                                  [attributes]            => Array(
    //                                                                  [target] => _parent
    //                                                                  )
    //                                  [clientside_validation] => 1
    //                                  )
    //
    //              [field_specs] => Array(
    //
    //                  [0] => Array(
    //                              [form_field_name]       => parent_key
    //                              [zebra_control_type]    => select
    //                              [label]                 => Project
    //                              [value_from]            =>
    //                              [attributes]            => Array()
    //                              [rules]                 => Array(
    //                                  [required] => Array(
    //                                      [0] => error
    //                                      [1] => Field is required
    //                                      )
    //                                  )
    //                              [type_specific_args]    => Array(
    //                                  [options_getter_function] => Array(
    //                                      [function_name] => \researchAssistant_byFernTec_datasetManagerDatasetDefs_categories\get_options_for_project_selector
    //                                      [extra_args] =>
    //                                      )
    //                                  )
    //                              [constraints] => Array(
    //                                  [0] => Array(
    //                                              [type] => unique-key
    //                                              )
    //                                  )
    //                              )
    //
    //                  ...
    //
    //                  [5] => Array(
    //                              [form_field_name]       => cancel
    //                              [zebra_control_type]    => button
    //                              [label]                 =>
    //                              [attributes]            => Array(
    //                                  [onclick] => window.parent.location.href="http://localhost/plugdev/wp-admin//admin.php?page=researchAssistant&action=manage-dataset&dataset_slug=categories"
    //                                  )
    //                              [rules]                 => Array()
    //                              [type_specific_args]    => Array(
    //                                                              [caption]   => Cancel
    //                                                              [type]      => button
    //                                                              )
    //                              )
    //
    //                  )
    //
    //              [focus_field_slug] => 1
    //
    //              )
    //
    //          [array_storage_record_structure]    => Array(
    //
    //              [0] => Array(
    //                          [slug]          => created_server_datetime_UTC
    //                          [value_from]    => Array(
    //                                                  [method]    => created-server-datetime-utc
    //                                                  )
    //                          )
    //
    //              ...
    //
    //              [6] => Array(
    //                          [slug]          => notes_slash_comments
    //                          [value_from]    => Array(
    //                                                  [method]    => post
    //                                                  [instance]  => notes_slash_comments
    //                                                  )
    //
    //                          )
    //
    //              )
    //
    //          [array_storage_key_field_slug] => key
    //
    //          )
    //
    // -------------------------------------------------------------------------

//pr( $selected_datasets_dmdd ) ;

//pr( $_POST ) ;

    // =========================================================================
    // Some useful shortcuts...
    // =========================================================================

    $ns = __NAMESPACE__ ;
    $fn = __FUNCTION__  ;

    // -------------------------------------------------------------------------

    if ( $question_adding ) {
        $adding_editing = 'Adding' ;

    } else {
        $adding_editing = 'Editing' ;

    }

    // -------------------------------------------------------------------------

    $no_error_field_slug = '' ;

    // -------------------------------------------------------------------------

    $zebra_form_definition = $selected_datasets_dmdd['zebra_forms'][ $form_slug_underscored ] ;

    // =========================================================================
    // CHECK the:-
    //      $selected_datasets_dmdd
    // variables that are used...
    // =========================================================================

    require_once( dirname( __FILE__ ) . '/check-and-default-array-storage-record-structure.php' ) ;

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
    //          o   ...['array_storage_record_structure']['checked_defaulted_ok']
    //                  = TRUE
    //          o   The individual fields will have had any required default
    //              values set.
    //
    //      On FAILURE!
    //      - - - - - -
    //      $error_message STRING
    // -------------------------------------------------------------------------

    $result = check_and_default_array_storage_record_structure(
                    $caller_app_slash_plugins_global_namespace      ,
                    $dataset_manager_home_page_title                ,
                    $caller_apps_includes_dir                       ,
                    $all_application_dataset_definitions            ,
                    $selected_datasets_dmdd                         ,
                    $dataset_records                                ,
                    $dataset_title                                  ,
                    $dataset_slug
                    ) ;

    // -------------------------------------------------------------------------

    if ( is_string( $result ) ) {
        return array( $result , $no_error_field_slug ) ;
    }

    // =========================================================================
    // GET the field's POST VAR NAMES BY SLUG...
    // =========================================================================

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
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
    //          //                  'method'    =>  'literal'                   ,
    //          //                  'instance'  =>  <any-PHP-scalar-value>
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

    $post_var_names_by_slug = array() ;

    // -------------------------------------------------------------------------

    foreach ( $selected_datasets_dmdd['array_storage_record_structure'] as $this_index => $array_storage_field_details ) {

        // =====================================================================
        // checked_defaulted_ok ?
        // =====================================================================

        if ( $this_index === 'checked_defaulted_ok' ) {
            continue ;
        }

        // -----------------------------------------------------------------

        if ( array_key_exists( $array_storage_field_details['slug'] , $post_var_names_by_slug ) ) {

            $msg = <<<EOT
PROBLEM {$adding_editing} Dataset Record:&nbsp; Duplicate field slug "{$array_storage_field_details['slug']}" - in dataset's "array_storage_record_structure"
For dataset:&nbsp; "{$dataset_title}"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

            return array( $msg , $no_error_field_slug ) ;

        }

        // =====================================================================
        // Any "post_var_name" ?
        // =====================================================================

        if ( $array_storage_field_details['value_from']['method'] === 'post' ) {

            // -----------------------------------------------------------------

            if ( ! array_key_exists( 'instance' , $array_storage_field_details['value_from'] ) ) {

                $msg = <<<EOT
PROBLEM {$adding_editing} Dataset Record:&nbsp; Bad "array_storage_record_structure" + "value_from" (no "instance")
For dataset:&nbsp; "{$dataset_title}"
and field (slug):&nbsp; "{$array_storage_field_details['slug']}"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

                return array( $msg , $no_error_field_slug ) ;

            }

            // -----------------------------------------------------------------

            if (    ! is_string( $array_storage_field_details['value_from']['instance'] )
                    ||
                    trim( $array_storage_field_details['value_from']['instance'] ) === ''
                    ||
                    ! \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_stringUtils\ctype_varname( $array_storage_field_details['value_from']['instance'] )
                    ||
                    strlen( $array_storage_field_details['value_from']['instance'] ) > 64
                ) {

                $msg = <<<EOT
PROBLEM {$adding_editing} Dataset Record:&nbsp; Bad "array_storage_record_structure" + "value_from" + "instance" (1 to 64 character variable name type string expected)
For dataset:&nbsp; "{$dataset_title}"
and field (slug):&nbsp; "{$array_storage_field_details['slug']}"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

                return array( $msg , $no_error_field_slug ) ;

            }

            // -----------------------------------------------------------------

            $post_var_names_by_slug[ $array_storage_field_details['slug'] ] =
                $array_storage_field_details['value_from']['instance']
                ;

            // -----------------------------------------------------------------

        }

        // =====================================================================
        // Repeat with the next field in:-
        //      array_storage_record_structure
        //
        // (if there is one)...
        // =====================================================================

    }

    // =========================================================================
    // GET the "CHECKBOX" and "RADIOS" type ZEBRA FORM FIELDS...
    // =========================================================================

    // -------------------------------------------------------------------------
    // NOTE!
    // =====
    // These are required because CHECKBOX and RADIO fields behave differently
    // from other form fields.  Eg:-
    //      o   Their name=value is submitted if the checkbox is ticked
    //      o   Their name=value ISN'T submitted if the checkbox is ISN'T
    //          ticked
    // -------------------------------------------------------------------------

    $zebra_form_field_indices_of_checkbox_type_zebra_form_fields = array() ;

    $zebra_form_field_indices_of_radios_type_zebra_form_fields = array() ;

    // -------------------------------------------------------------------------

    foreach ( $zebra_form_definition['field_specs'] as $this_zebra_form_field_index => $this_zebra_form_field_details ) {

        if ( $this_zebra_form_field_details['zebra_control_type'] === 'checkbox' ) {
            $zebra_form_field_indices_of_checkbox_type_zebra_form_fields[] = $this_zebra_form_field_index ;
        }

        if ( $this_zebra_form_field_details['zebra_control_type'] === 'radios' ) {
            $zebra_form_field_indices_of_radios_type_zebra_form_fields[] = $this_zebra_form_field_index ;
        }

    }

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $zebra_form_field_indices_of_checkbox_type_zebra_form_fields ) ;
//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $zebra_form_field_indices_of_radios_type_zebra_form_fields ) ;

    // =========================================================================
    // ADD/UPDATE the RECORD...
    // =========================================================================

    if ( $question_adding ) {

        // =====================================================================
        // ADD
        // =====================================================================

        $the_record = array() ;

        // ---------------------------------------------------------------------

        foreach ( $selected_datasets_dmdd['array_storage_record_structure'] as $this_index => $array_storage_field_details ) {

            // -----------------------------------------------------------------

            if ( $this_index === 'checked_defaulted_ok' ) {
                continue ;
            }

            // -----------------------------------------------------------------
            // Here we should have (eg):-
            //
            //      $array_storage_field_details = array(
            //          'slug'          =>  'created_server_datetime_UTC'      ,
            //          'value_from'    =>  array(
            //                                  'method'    =>  'created-server-datetime-utc'
            //                                  )
            //          )
            //
            //      --OR--
            //
            //      $array_storage_field_details = array(
            //          'slug'          =>  'parent_key'    ,
            //          'value_from'    =>  array(
            //                                  'method'    =>  'post'          ,
            //                                  'instance'  =>  'parent_key'
            //                                  )
            //          )
            //
            // -----------------------------------------------------------------

            // =================================================================
            // GET the FIELD VALUE...
            // =================================================================

            // -------------------------------------------------------------------------
            // get_array_storage_field_value(
            //      $dataset_manager_home_page_title                                ,
            //      $caller_apps_includes_dir                                       ,
            //      $all_application_dataset_definitions                            ,
            //      $dataset_slug                                                   ,
            //      $selected_datasets_dmdd                                         ,
            //      $zebra_form_definition                                          ,
            //      $dataset_title                                                  ,
            //      $dataset_records                                                ,
            //      $record_indices_by_key                                          ,
            //      $key_field_slug                                                 ,
            //      $question_adding                                                ,
            //      $adding_editing                                                 ,
            //      $zebra_form_obj                                                 ,
            //      $array_storage_field_details                                    ,
            //      $zebra_form_field_indices_of_checkbox_type_zebra_form_fields    ,
            //      $zebra_form_field_indices_of_radios_type_zebra_form_fields
            //      )
            // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
            //      o   On SUCCESS!
            //          - - - - - -
            //          array(
            //              $ok = TRUE                      ,
            //              $field_value (any PHP type)     ,
            //              $question_change
            //              )
            //              NOTE!
            //              -----
            //              If $question_change is anything but TRUE, then the array
            //              storage field SHOULDN'T be updated with the returned
            //              $field_value.  For example, if you're editing a record
            //              identified by some unique "key", then that "key" field
            //              should never (usually) be updated.  It's a unique
            //              identifier for the record - assigned when the record is
            //              first created - and remaining unchanged till the record
            //              is destroyed.
            //
            //      o   On FAILURE!
            //          - - - - - -
            //          array(
            //              $ok = FALSE             ,
            //              $error_message STRING
            //              )
            // -------------------------------------------------------------------------

            $result = get_array_storage_field_value(
                            $dataset_manager_home_page_title                                ,
                            $caller_apps_includes_dir                                       ,
                            $all_application_dataset_definitions                            ,
                            $dataset_slug                                                   ,
                            $selected_datasets_dmdd                                         ,
                            $zebra_form_definition                                          ,
                            $dataset_title                                                  ,
                            $dataset_records                                                ,
                            $record_indices_by_key                                          ,
                            $key_field_slug                                                 ,
                            $question_adding                                                ,
                            $adding_editing                                                 ,
                            $zebra_form_obj                                                 ,
                            $array_storage_field_details                                    ,
                            $zebra_form_field_indices_of_checkbox_type_zebra_form_fields    ,
                            $zebra_form_field_indices_of_radios_type_zebra_form_fields
                            ) ;

            // -----------------------------------------------------------------

            if ( count( $result ) === 3 ) {
                list( $ok , $field_value , $question_change ) = $result ;

            } else {
                list( $ok , $error_message ) = $result ;

            }

            // -----------------------------------------------------------------

            if ( $ok === FALSE ) {
                return array( $error_message , $array_storage_field_details['slug'] ) ;
            }

            // =================================================================
            // SET/CHANGE the ARRAY STORAGE FIELD's VALUE ?
            // =================================================================

            if ( $question_change ) {

                // =============================================================
                // Handle any (ARRAY STORAGE) CONSTRAINTS...
                // =============================================================

                // -------------------------------------------------------------------------
                // handle_array_storage_constraints(
                //      $caller_apps_includes_dir       ,
                //      $dataset_title                  ,
                //      $dataset_records                ,
                //      $array_storage_field_details    ,
                //      $question_adding                ,
                //      $new_or_existing_field_value    ,
                //      $record_being_editeds_index
                //      )
                // - - - - - - - - - - - - - - - - - - -
                // RETURNS
                //      o   On SUCCESS!
                //          - - - - - -
                //          TRUE
                //
                //      o   On FAILURE!
                //          - - - - - -
                //          $error_message STRING
                // -------------------------------------------------------------------------

                $record_being_editeds_index = NULL ;

                // -------------------------------------------------------------

                $result = handle_array_storage_constraints(
                                $caller_apps_includes_dir       ,
                                $dataset_title                  ,
                                $dataset_records                ,
                                $array_storage_field_details    ,
                                $question_adding                ,
                                $field_value                    ,
                                $record_being_editeds_index
                                ) ;

                // -------------------------------------------------------------

                if ( is_string( $result ) ) {
                    return array( $result , $array_storage_field_details['slug'] ) ;
                }

                // =============================================================
                // Set the field value...
                // =============================================================

                $the_record[ $array_storage_field_details['slug'] ] = $field_value ;

//echo '<br />ADDING: ' , $array_storage_field_details['slug'] , ' --- "' , $field_value , '" --- ' , gettype( $field_value ) ;

                // -------------------------------------------------------------

            }

            // =================================================================
            // Repeat with the next:-
            //      array_storage_record_structure
            //
            // field (if there is one)...
            // =================================================================

        }

        // =====================================================================
        // Append the new record to the dataset...
        // =====================================================================

        $dataset_records[] = $the_record ;

        // ---------------------------------------------------------------------

    } else {

        // =====================================================================
        // EDIT
        // =====================================================================

        // -------------------------------------------------------------------------
        // get_record_to_be_edited(
        //      $dataset_records        ,
        //      $record_indices_by_key  ,
        //      $dataset_title
        //      )
        // - - - - - - - - - - - - - - -
        // Returns the record to be edited.  Assumes that $_GET['record_key']
        // points to the required record in the dataset.
        //
        // ONLY works if we're EDITING a record !!!
        //
        // RETURNS:-
        //      o   On SUCCESS!
        //          - - - - - -
        //          array(
        //              ARRAY $record_to_be_edited          ,
        //              INT   $record_to_be_edited_index
        //              )
        //
        //          Where $record_to_be_edited_index is the record's (0-based)
        //          index in:-
        //              $dataset_records
        //
        //      o   On FAILURE!
        //          - - - - - -
        //          $error_message STRING
        // -------------------------------------------------------------------------

        $result = get_record_to_be_edited(
                        $dataset_records        ,
                        $record_indices_by_key  ,
                        $dataset_title
                        ) ;

        // ---------------------------------------------------------------------

        if ( is_string( $result ) ) {
            return array( $result , $no_error_field_slug ) ;
        }

        // ---------------------------------------------------------------------

        list(
            $the_record             ,
            $the_records_index
            ) = $result ;

        // =====================================================================
        // UPDATE THE RECORD'S FIELDS, one by one...
        // =====================================================================

        foreach ( $selected_datasets_dmdd['array_storage_record_structure'] as $this_index => $array_storage_field_details ) {

            // -----------------------------------------------------------------

            if ( $this_index === 'checked_defaulted_ok' ) {
                continue ;
            }

            // -----------------------------------------------------------------
            // Here we should have (eg):-
            //
            //      $array_storage_field_details = array(
            //          'slug'          =>  'created_server_datetime_UTC'      ,
            //          'value_from'    =>  array(
            //                                  'method'    =>  'created-server-datetime-utc'
            //                                  )
            //          )
            //
            //      --OR--
            //
            //      $array_storage_field_details = array(
            //          'slug'          =>  'parent_key'    ,
            //          'value_from'    =>  array(
            //                                  'method'    =>  'post'          ,
            //                                  'instance'  =>  'parent_key'
            //                                  )
            //          )
            //
            // -----------------------------------------------------------------

            // =================================================================
            // GET the FIELD VALUE...
            // =================================================================

            // -------------------------------------------------------------------------
            // get_array_storage_field_value(
            //      $dataset_manager_home_page_title                                ,
            //      $caller_apps_includes_dir                                       ,
            //      $all_application_dataset_definitions                            ,
            //      $dataset_slug                                                   ,
            //      $selected_datasets_dmdd                                         ,
            //      $zebra_form_definition                                          ,
            //      $dataset_title                                                  ,
            //      $dataset_records                                                ,
            //      $record_indices_by_key                                          ,
            //      $key_field_slug                                                 ,
            //      $question_adding                                                ,
            //      $adding_editing                                                 ,
            //      $zebra_form_obj                                                 ,
            //      $array_storage_field_details                                    ,
            //      $zebra_form_field_indices_of_checkbox_type_zebra_form_fields    ,
            //      $zebra_form_field_indices_of_radios_type_zebra_form_fields
            //      )
            // - - - - - - - - - - - - - - - - - - - - - - -
            //      o   On SUCCESS!
            //          - - - - - -
            //          array(
            //              $ok = TRUE                      ,
            //              $field_value (any PHP type)     ,
            //              $question_change
            //              )
            //              NOTE!
            //              -----
            //              If $question_change is anything but TRUE, then the array
            //              storage field SHOULDN'T be updated with the returned
            //              $field_value.  For example, if you're editing a record
            //              identified by some unique "key", then that "key" field
            //              should never (usually) be updated.  It's a unique
            //              identifier for the record - assigned when the record is
            //              first created - and remaining unchanged till the record
            //              is destroyed.
            //
            //      o   On FAILURE!
            //          - - - - - -
            //          array(
            //              $ok = FALSE             ,
            //              $error_message STRING
            //              )
            // -------------------------------------------------------------------------

            $result = get_array_storage_field_value(
                            $dataset_manager_home_page_title                                ,
                            $caller_apps_includes_dir                                       ,
                            $all_application_dataset_definitions                            ,
                            $dataset_slug                                                   ,
                            $selected_datasets_dmdd                                         ,
                            $zebra_form_definition                                          ,
                            $dataset_title                                                  ,
                            $dataset_records                                                ,
                            $record_indices_by_key                                          ,
                            $key_field_slug                                                 ,
                            $question_adding                                                ,
                            $adding_editing                                                 ,
                            $zebra_form_obj                                                 ,
                            $array_storage_field_details                                    ,
                            $zebra_form_field_indices_of_checkbox_type_zebra_form_fields    ,
                            $zebra_form_field_indices_of_radios_type_zebra_form_fields
                            ) ;

            // -----------------------------------------------------------------

            if ( count( $result ) === 3 ) {
                list( $ok , $field_value , $question_change ) = $result ;

            } else {
                list( $ok , $error_message ) = $result ;

            }

            // -----------------------------------------------------------------

            if ( $ok === FALSE ) {
                return array( $error_message , $array_storage_field_details['slug'] ) ;
            }

            // =================================================================
            // SET/CHANGE the ARRAY STORAGE FIELD's VALUE ?
            // =================================================================

            if ( $question_change ) {

                // =============================================================
                // Handle any (ARRAY STORAGE) CONSTRAINTS...
                // =============================================================

                // -------------------------------------------------------------------------
                // handle_array_storage_constraints(
                //      $caller_apps_includes_dir       ,
                //      $dataset_title                  ,
                //      $dataset_records                ,
                //      $array_storage_field_details    ,
                //      $question_adding                ,
                //      $new_or_existing_field_value    ,
                //      $record_being_editeds_index
                //      )
                // - - - - - - - - - - - - - - - - - - -
                // RETURNS
                //      o   On SUCCESS!
                //          - - - - - -
                //          TRUE
                //
                //      o   On FAILURE!
                //          - - - - - -
                //          $error_message STRING
                // -------------------------------------------------------------------------

                $record_being_editeds_index = $the_records_index ;

                // -------------------------------------------------------------

                $result = handle_array_storage_constraints(
                                $caller_apps_includes_dir       ,
                                $dataset_title                  ,
                                $dataset_records                ,
                                $array_storage_field_details    ,
                                $question_adding                ,
                                $field_value                    ,
                                $record_being_editeds_index
                                ) ;

                // -------------------------------------------------------------

                if ( is_string( $result ) ) {
                    return array( $result , $array_storage_field_details['slug'] ) ;
                }

                // =============================================================
                // Set the field value...
                // =============================================================

                $the_record[ $array_storage_field_details['slug'] ] = $field_value ;

//echo '<br />EDITING: ' , $array_storage_field_details['slug'] , ' --- "' , $field_value , '" --- ' , gettype( $field_value ) ;

                // -------------------------------------------------------------

            }

            // =================================================================
            // Repeat with the next:-
            //      array_storage_record_structure
            //
            // field (if there is one)...
            // =================================================================

        }

        // ====================================================================-
        // Write the updated record back to the dataset...
        // ====================================================================-

        $dataset_records[ $the_records_index ] = $the_record ;

        // ---------------------------------------------------------------------

    }

//$temp = $the_record ;
//$temp['original_clipped_text'] .= ' --- <b>Hello World</b>' ;

//pr( $temp ) ;

    // =========================================================================
    // SAVE the updated DATASET RECORDS...
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

    $result = \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_arrayStorage\save_numerically_indexed(
                    $selected_datasets_dmdd['dataset_slug']     ,
                    $dataset_records                            ,
                    $question_die_on_error
                    ) ;

    // -------------------------------------------------------------------------

    if ( is_string( $result ) ) {
        return array( $result , $no_error_field_slug ) ;
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
// get_array_storage_field_value()
// =============================================================================

function get_array_storage_field_value(
    $dataset_manager_home_page_title                                ,
    $caller_apps_includes_dir                                       ,
    $all_application_dataset_definitions                            ,
    $dataset_slug                                                   ,
    $selected_datasets_dmdd                                         ,
    $zebra_form_definition                                          ,
    $dataset_title                                                  ,
    $dataset_records                                                ,
    $record_indices_by_key                                          ,
    $key_field_slug                                                 ,
    $question_adding                                                ,
    $adding_editing                                                 ,
    $zebra_form_obj                                                 ,
    $array_storage_field_details                                    ,
    $zebra_form_field_indices_of_checkbox_type_zebra_form_fields    ,
    $zebra_form_field_indices_of_radios_type_zebra_form_fields
    ) {

    // -------------------------------------------------------------------------
    // get_array_storage_field_value(
    //      $dataset_manager_home_page_title                                ,
    //      $caller_apps_includes_dir                                       ,
    //      $all_application_dataset_definitions                            ,
    //      $dataset_slug                                                   ,
    //      $selected_datasets_dmdd                                         ,
    //      $zebra_form_definition                                          ,
    //      $dataset_title                                                  ,
    //      $dataset_records                                                ,
    //      $record_indices_by_key                                          ,
    //      $key_field_slug                                                 ,
    //      $question_adding                                                ,
    //      $adding_editing                                                 ,
    //      $zebra_form_obj                                                 ,
    //      $array_storage_field_details                                    ,
    //      $zebra_form_field_indices_of_checkbox_type_zebra_form_fields    ,
    //      $zebra_form_field_indices_of_radios_type_zebra_form_fields
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    //      o   On SUCCESS!
    //          - - - - - -
    //          array(
    //              $ok = TRUE                      ,
    //              $field_value (any PHP type)     ,
    //              $question_change
    //              )
    //              NOTE!
    //              -----
    //              If $question_change is anything but TRUE, then the array
    //              storage field SHOULDN'T be updated with the returned
    //              $field_value.  For example, if you're editing a record
    //              identified by some unique "key", then that "key" field
    //              should never (usually) be updated.  It's a unique
    //              identifier for the record - assigned when the record is
    //              first created - and remaining unchanged till the record
    //              is destroyed.
    //
    //      o   On FAILURE!
    //          - - - - - -
    //          array(
    //              $ok = FALSE             ,
    //              $error_message STRING
    //              )
    // -------------------------------------------------------------------------

    // -------------------------------------------------------------------------
    // Here we should have (eg):-

    // -------------------------------------------------------------------------

    // =========================================================================
    // Support Routines...
    // =========================================================================

    require_once( dirname( __FILE__ ) . '/standard-field-values.php' ) ;

    // =========================================================================
    // Init. the output variables...
    // =========================================================================

    $ns = __NAMESPACE__ ;
    $fn = __FUNCTION__  ;

    // -------------------------------------------------------------------------

    $success = TRUE  ;
    $failure = FALSE ;

    // -------------------------------------------------------------------------

    $question_change = TRUE ;
        //  Override this for field methods that assume the field values
        //  are assigned at "add" time only.

    // =========================================================================
    // Processing is "METHOD" dependent...
    // =========================================================================

    if ( $array_storage_field_details['value_from']['method'] === 'created-server-datetime-utc' ) {

        // =====================================================================
        // $array_storage_field_details['value_from'] = array(
        //      'method'    =>  'created-server-datetime-utc'
        //      //  "instance" and "args", if specified, are IGNORED
        //      )
        // =====================================================================

//      $field_value = time() ;
        $field_value = get_server_datetime_UTC() ;

        // ---------------------------------------------------------------------

        if ( ! $question_adding ) {
            $question_change = FALSE ;
        }

        // ---------------------------------------------------------------------

    } elseif ( $array_storage_field_details['value_from']['method'] === 'last-modified-server-datetime-utc' ) {

        // =====================================================================
        // $array_storage_field_details['value_from'] = array(
        //      'method'    =>  'last-modified-server-datetime-utc'
        //      //  "instance" and "args", if specified, are IGNORED
        //      )
        // =====================================================================

//      $field_value = time() ;
        $field_value = get_server_datetime_UTC() ;

        // ---------------------------------------------------------------------

    } elseif ( $array_storage_field_details['value_from']['method'] === 'created-server-micro-datetime-utc' ) {

        // =====================================================================
        // $array_storage_field_details['value_from'] = array(
        //      'method'    =>  'created-server-micro-datetime-utc'
        //      //  "instance" and "args", if specified, are IGNORED
        //      )
        // =====================================================================

        // ---------------------------------------------------------------------
        // NOTE!
        // -----
        // "Micro" dates/times are expressed as floats like (eg):-
        //
        //      12.34 = 12 seconds and 340 microseconds
        //
        // "micro" = 1 millionth
        // ---------------------------------------------------------------------

        // -------------------------------------------------------------------------
        // mixed microtime ([ bool $get_as_float = false ] )
        // - - - - - - - - - - - - - - - - - - - - - - - - -
        // microtime() returns the current Unix timestamp with microseconds. This
        // function is only available on operating systems that support the
        // gettimeofday() system call.
        //
        //      get_as_float
        //          If used and set to TRUE, microtime() will return a float instead
        //          of a string, as described in the return values section below.
        //
        // By default, microtime() returns a string in the form "msec sec", where
        // sec is the number of seconds since the Unix epoch (0:00:00 January 1,1970
        // GMT), and msec measures microseconds that have elapsed since sec and is
        // also expressed in seconds.
        //
        // If get_as_float is set to TRUE, then microtime() returns a float, which
        // represents the current time in seconds since the Unix epoch accurate to
        // the nearest microsecond.
        //
        // (PHP 4, PHP 5)
        //
        // CHANGELOG
        //      Version     Description
        //      5.0.0       The get_as_float parameter was added.
        // -------------------------------------------------------------------------

//      if ( function_exists( 'microtime' ) ) {
//          list( $usec , $sec ) = explode( chr(32) , microtime() ) ;
//          $field_value = (float) $usec + (float) $sec ;
//              //  Getting the microtime() as float this way works in both
//              //  PHP 4 and 5.
//
//      } else {
//          $field_value = (float) time() ;
//
//      }

        // ---------------------------------------------------------------------

        $field_value = get_server_micro_datetime_UTC() ;

        // ---------------------------------------------------------------------

        if ( ! $question_adding ) {
            $question_change = FALSE ;
        }

        // ---------------------------------------------------------------------

    } elseif ( $array_storage_field_details['value_from']['method'] === 'last-modified-server-micro-datetime-utc' ) {

        // =====================================================================
        // $array_storage_field_details['value_from'] = array(
        //      'method'    =>  'last-modified-server-micro-datetime-utc'
        //      //  "instance" and "args", if specified, are IGNORED
        //      )
        // =====================================================================

        // ---------------------------------------------------------------------
        // NOTE!
        // -----
        // "Micro" dates/times are expressed as floats like (eg):-
        //
        //      12.34 = 12 seconds and 340 microseconds
        //
        // "micro" = 1 millionth
        // ---------------------------------------------------------------------

//      if ( function_exists( 'microtime' ) ) {
//          list( $usec , $sec ) = explode( chr(32) , microtime() ) ;
//          $field_value = (float) $usec + (float) $sec ;
//              //  Getting the microtime() as float this way works in both
//              //  PHP 4 and 5.
//
//      } else {
//          $field_value = (float) time() ;
//
//      }

        // ---------------------------------------------------------------------

        $field_value = get_server_micro_datetime_UTC() ;

        // ---------------------------------------------------------------------

    } elseif ( $array_storage_field_details['value_from']['method'] === 'unique-key' ) {

        // =====================================================================
        // $array_storage_field_details['value_from'] = array(
        //      array(
        //          'method'    =>  'unique-key'
        //          //  "instance" and "args", if specified, are IGNORED
        //          )
        // =====================================================================

        // -------------------------------------------------------------------------
        // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\
        // get_unique_record_key_for_dataset(
        //      $record_indices_by_key
        //      )
        // - - - - - - - - - - - - - - - - -
        // RETURNS
        //      o   On SUCCESS
        //              $record_key STRING
        //
        //      o   On FAILURE
        //              ARRAY( $error_message STRING )
        // -------------------------------------------------------------------------

        $field_value =  get_unique_record_key_for_dataset(
                            $record_indices_by_key
                            ) ;

        // ---------------------------------------------------------------------

        if ( is_array( $field_value ) ) {

            return array(
                        $failure            ,
                        $field_value[0]
                        ) ;

        }

        // ---------------------------------------------------------------------

        if ( ! $question_adding ) {
            $question_change = FALSE ;
        }

        // ---------------------------------------------------------------------

    } elseif ( $array_storage_field_details['value_from']['method'] === 'literal' ) {

        // =====================================================================
        // $array_storage_field_details['value_from'] = array(
        //      'method'    =>  'literal'                   ,
        //      'instance'  =>  <any-PHP-scalar- value>
        //      //  "args", if specified, is IGNORED
        //      )
        // =====================================================================

        if ( ! isset( $array_storage_field_details['value_from']['instance'] ) ) {

            $msg = <<<EOT
PROBLEM {$adding_editing} Dataset Record:&nbsp; Bad "array_storage_record_structure" + "value_from" (method "literal" requires "instance")
For dataset:&nbsp; "{$dataset_title}"
and field (slug):&nbsp; "{$array_storage_field_details['slug']}"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

            return array( $failure , $msg ) ;

        }

        // ---------------------------------------------------------------------

        if ( ! is_scalar( $array_storage_field_details['value_from']['instance'] ) ) {

            $msg = <<<EOT
PROBLEM {$adding_editing} Dataset Record:&nbsp; Bad "array_storage_record_structure" + "value_from" + "instance" (scalar value - INT, STRING, BOOL or FLOAT - expected)
For dataset:&nbsp; "{$dataset_title}"
and field (slug):&nbsp; "{$array_storage_field_details['slug']}"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

            return array( $failure , $msg ) ;

        }

        // ---------------------------------------------------------------------

        $field_value = $array_storage_field_details['value_from']['instance'] ;

        // ---------------------------------------------------------------------

    } elseif ( $array_storage_field_details['value_from']['method'] === 'get' ) {

        // =====================================================================
        // $array_storage_field_details['value_from'] = array(
        //      array(
        //          'method'    =>  'get'               ,
        //          'instance'  =>  '<get-var-name>'
        //          //  If "instance" is unspecified - or is anything but a
        //          //  non-empty string, then '<get-var-name>' defaults to
        //          //  the field's "slug"
        //          //  "args", if specified, is IGNORED
        //          )
        // =====================================================================

        // ---------------------------------------------------------------------
        // NOTE!
        // =====
        // CHECKBOX fields are a special case.  They WON'T be submitted - and
        // placed into $_GET or $_POST (acc. to the form METHOD) - unless the
        // checkbox is CHECKED.
        //
        // Hence we must detect this - and default the field value to TRUE or
        // FALSE accordingly...
        // ---------------------------------------------------------------------

        if ( count( $zebra_form_field_indices_of_checkbox_type_zebra_form_fields ) > 0 ) {

            // -------------------------------------------------------------------------
            // is_array_storage_field_a_checkbox_type_field(
            //      $selected_datasets_dmdd                                         ,
            //      $zebra_form_definition                                          ,
            //      $dataset_slug                                                   ,
            //      $dataset_title                                                  ,
            //      $array_storage_field_details                                    ,
            //      $zebra_form_field_indices_of_checkbox_type_zebra_form_fields    ,
            //      $get_post
            //      )
            // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
            // RETURNS
            //      o   On SUCCESS!
            //              array(
            //                  $question_checkbox_type_field BOOL          ,
            //                  $expected_checkbox_value STRING or NULL
            //                  )
            //
            //      o   On FAILURE!
            //              $error_message STRING
            // -------------------------------------------------------------------------

            $get_post = 'get' ;

            $result = is_array_storage_field_a_checkbox_type_field(
                            $selected_datasets_dmdd                                         ,
                            $zebra_form_definition                                          ,
                            $dataset_slug                                                   ,
                            $dataset_title                                                  ,
                            $array_storage_field_details                                    ,
                            $zebra_form_field_indices_of_checkbox_type_zebra_form_fields    ,
                            $get_post
                            ) ;

            // -----------------------------------------------------------------

            if ( is_string( $result ) ) {
                return array( $failure , $result ) ;
            }

            // -----------------------------------------------------------------

            list(
                $question_checkbox_type_field   ,
                $expected_checkbox_value
                ) = $result ;

            // -----------------------------------------------------------------

        } else {

            // -----------------------------------------------------------------

            $question_checkbox_type_field = FALSE ;
            $expected_checkbox_value      = NULL  ;

            // -----------------------------------------------------------------

        }

        // ---------------------------------------------------------------------
        // NOTE!
        // =====
        // RADIO fields are a special case.  They WON'T be submitted - and
        // placed into $_GET or $_POST (acc. to the form METHOD) - unless one
        // radio in the group (of radios with the name name) is CHECKED.
        //
        // Hence we must detect this - and default the field value to it's
        // default accordingly...
        // ---------------------------------------------------------------------

        if ( count( $zebra_form_field_indices_of_radios_type_zebra_form_fields ) > 0 ) {

            // -------------------------------------------------------------------------
            // is_array_storage_field_a_radios_type_field(
            //      $selected_datasets_dmdd                                         ,
            //      $zebra_form_definition                                          ,
            //      $dataset_slug                                                   ,
            //      $dataset_title                                                  ,
            //      $array_storage_field_details                                    ,
            //      $zebra_form_field_indices_of_radios_type_zebra_form_fields      ,
            //      $get_post
            //      )
            // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
            // RETURNS
            //      o   On SUCCESS!
            //          - - - - - -
            //          TRUE or FALSE
            //
            //      o   On FAILURE!
            //          $error_message STRING
            // -------------------------------------------------------------------------

            $get_post = 'get' ;

            $question_radios_type_field = is_array_storage_field_a_radios_type_field(
                                                $selected_datasets_dmdd                                         ,
                                                $zebra_form_definition                                          ,
                                                $dataset_slug                                                   ,
                                                $dataset_title                                                  ,
                                                $array_storage_field_details                                    ,
                                                $zebra_form_field_indices_of_radios_type_zebra_form_fields      ,
                                                $get_post
                                                ) ;

            // -----------------------------------------------------------------

            if ( is_string( $question_radios_type_field ) ) {
                return array( $failure , $question_radios_type_field ) ;
            }

            // -----------------------------------------------------------------

        } else {

            // -----------------------------------------------------------------

            $question_radios_type_field = FALSE ;

            // -----------------------------------------------------------------

        }

        // -------------------------------------------------------------------------
        // get_slash_check_get_post_server_or_cookie_field_value(
        //      $dataset_title                  ,
        //      $array_storage_field_details    ,
        //      $_WHATEVER                      ,
        //      $whatever                       ,
        //      $adding_editing                 ,
        //      $question_checkbox_type_field   ,
        //      $question_radios_type_field     ,
        //      $expected_checkbox_value
        //      )
        // - - - - - - - - - - - - - - - - - - - - - - - - - - -
        // NOTE!
        // =====
        // The returned CHECKBOX type field values are TRUE or FALSE.
        // All other returned field values are STRINGS.
        //
        // RETURNS
        //      o   On SUCCESS!
        //          - - - - - -
        //          $field_value (BOOL or STRING)
        //
        //      o   On FAILURE!
        //          - - - - - -
        //          array( $error_message STRING )
        // -------------------------------------------------------------------------

        $field_value = get_slash_check_get_post_server_or_cookie_field_value(
                            $dataset_title                  ,
                            $array_storage_field_details    ,
                            $_GET                           ,
                            'get'                           ,
                            $adding_editing                 ,
                            $question_checkbox_type_field   ,
                            $question_radios_type_field     ,
                            $expected_checkbox_value
                            ) ;

        // ---------------------------------------------------------------------

        if ( is_array( $field_value ) ) {
            return array( $failure , $field_value[0] ) ;
        }

        // ---------------------------------------------------------------------

    } elseif ( $array_storage_field_details['value_from']['method'] === 'post' ) {

        // =====================================================================
        // $array_storage_field_details['value_from'] = array(
        //      array(
        //          'method'    =>  'post'               ,
        //          'instance'  =>  '<post-var-name>'
        //          //  If "instance" is unspecified - or is anything but a
        //          //  non-empty string, then '<post-var-name>' defaults to
        //          //  the field's "slug"
        //          //  "args", if specified, is IGNORED
        //          )
        // =====================================================================

        // ---------------------------------------------------------------------
        // NOTE!
        // =====
        // CHECKBOX fields are a special case.  They WON'T be submitted - and
        // placed into $_GET or $_POST (acc. to the form METHOD) - unless the
        // checkbox is CHECKED.
        //
        // Hence we must detect this - and default the field value to TRUE or
        // FALSE accordingly...
        // ---------------------------------------------------------------------

        if ( count( $zebra_form_field_indices_of_checkbox_type_zebra_form_fields ) > 0 ) {

            // -------------------------------------------------------------------------
            // is_array_storage_field_a_checkbox_type_field(
            //      $selected_datasets_dmdd                                         ,
            //      $zebra_form_definition                                          ,
            //      $dataset_slug                                                   ,
            //      $dataset_title                                                  ,
            //      $array_storage_field_details                                    ,
            //      $zebra_form_field_indices_of_checkbox_type_zebra_form_fields    ,
            //      $get_post
            //      )
            // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
            // RETURNS
            //      o   On SUCCESS!
            //              array(
            //                  $question_checkbox_type_field BOOL          ,
            //                  $expected_checkbox_value STRING or NULL
            //                  )
            //
            //      o   On FAILURE!
            //              $error_message STRING
            // -------------------------------------------------------------------------

            $get_post = 'post' ;

            $result = is_array_storage_field_a_checkbox_type_field(
                            $selected_datasets_dmdd                                         ,
                            $zebra_form_definition                                          ,
                            $dataset_slug                                                   ,
                            $dataset_title                                                  ,
                            $array_storage_field_details                                    ,
                            $zebra_form_field_indices_of_checkbox_type_zebra_form_fields    ,
                            $get_post
                            ) ;

            // -----------------------------------------------------------------

            if ( is_string( $result ) ) {
                return array( $failure , $result ) ;
            }

            // -----------------------------------------------------------------

            list(
                $question_checkbox_type_field   ,
                $expected_checkbox_value
                ) = $result ;

            // -----------------------------------------------------------------

        } else {

            // -----------------------------------------------------------------

            $question_checkbox_type_field = FALSE ;
            $expected_checkbox_value      = NULL  ;

            // -----------------------------------------------------------------

        }

        // ---------------------------------------------------------------------
        // NOTE!
        // =====
        // RADIO fields are a special case.  They WON'T be submitted - and
        // placed into $_GET or $_POST (acc. to the form METHOD) - unless one
        // radio in the group (of radios with the name name) is CHECKED.
        //
        // Hence we must detect this - and default the field value to it's
        // default accordingly...
        // ---------------------------------------------------------------------

        if ( count( $zebra_form_field_indices_of_radios_type_zebra_form_fields ) > 0 ) {

            // -------------------------------------------------------------------------
            // is_array_storage_field_a_radios_type_field(
            //      $selected_datasets_dmdd                                         ,
            //      $zebra_form_definition                                          ,
            //      $dataset_slug                                                   ,
            //      $dataset_title                                                  ,
            //      $array_storage_field_details                                    ,
            //      $zebra_form_field_indices_of_radios_type_zebra_form_fields      ,
            //      $get_post
            //      )
            // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
            // RETURNS
            //      o   On SUCCESS!
            //          - - - - - -
            //          TRUE or FALSE
            //
            //      o   On FAILURE!
            //          $error_message STRING
            // -------------------------------------------------------------------------

            $get_post = 'post' ;

            $question_radios_type_field = is_array_storage_field_a_radios_type_field(
                                                $selected_datasets_dmdd                                         ,
                                                $zebra_form_definition                                          ,
                                                $dataset_slug                                                   ,
                                                $dataset_title                                                  ,
                                                $array_storage_field_details                                    ,
                                                $zebra_form_field_indices_of_radios_type_zebra_form_fields      ,
                                                $get_post
                                                ) ;

            // -----------------------------------------------------------------

            if ( is_string( $question_radios_type_field ) ) {
                return array( $failure , $question_radios_type_field ) ;
            }

            // -----------------------------------------------------------------

        } else {

            // -----------------------------------------------------------------

            $question_radios_type_field = FALSE ;

            // -----------------------------------------------------------------

        }

        // -------------------------------------------------------------------------
        // get_slash_check_get_post_server_or_cookie_field_value(
        //      $dataset_title                  ,
        //      $array_storage_field_details    ,
        //      $_WHATEVER                      ,
        //      $whatever                       ,
        //      $adding_editing                 ,
        //      $question_checkbox_type_field   ,
        //      $question_radios_type_field     ,
        //      $expected_checkbox_value
        //      )
        // - - - - - - - - - - - - - - - - - - - - - - - - - - -
        // NOTE!
        // =====
        // The returned CHECKBOX type field values are TRUE or FALSE.
        // All other returned field values are STRINGS.
        //
        // RETURNS
        //      o   On SUCCESS!
        //          - - - - - -
        //          $field_value (BOOL or STRING)
        //
        //      o   On FAILURE!
        //          - - - - - -
        //          array( $error_message STRING )
        // -------------------------------------------------------------------------

        $field_value = get_slash_check_get_post_server_or_cookie_field_value(
                            $dataset_title                  ,
                            $array_storage_field_details    ,
                            $_POST                          ,
                            'post'                          ,
                            $adding_editing                 ,
                            $question_checkbox_type_field   ,
                            $question_radios_type_field     ,
                            $expected_checkbox_value
                            ) ;

        // ---------------------------------------------------------------------

        if ( is_array( $field_value ) ) {
            return array( $failure , $field_value[0] ) ;
        }

        // ---------------------------------------------------------------------

    } elseif ( $array_storage_field_details['value_from']['method'] === 'server' ) {

        // =====================================================================
        // $array_storage_field_details['value_from'] = array(
        //      array(
        //          'method'    =>  'server'               ,
        //          'instance'  =>  '<server-var-name>'
        //          //  If "instance" is unspecified - or is anything but a
        //          //  non-empty string, then '<server-var-name>' defaults to
        //          //  the field's "slug"
        //          //  "args", if specified, is IGNORED
        //          )
        // =====================================================================

        // -------------------------------------------------------------------------
        // get_slash_check_get_post_server_or_cookie_field_value(
        //      $dataset_title                  ,
        //      $array_storage_field_details    ,
        //      $_WHATEVER                      ,
        //      $whatever                       ,
        //      $adding_editing                 ,
        //      $question_checkbox_type_field   ,
        //      $question_radios_type_field
        //      )
        // - - - - - - - - - - - - - - - - - - - - - - - - - - -
        // NOTE!
        // =====
        // The returned CHECKBOX type field values are TRUE or FALSE.
        // All other returned field values are STRINGS.
        //
        // RETURNS
        //      o   On SUCCESS!
        //          - - - - - -
        //          $field_value (BOOL or STRING)
        //
        //      o   On FAILURE!
        //          - - - - - -
        //          array( $error_message STRING )
        // -------------------------------------------------------------------------

        $question_checkbox_type_field = FALSE ;
        $question_radios_type_field   = FALSE ;
        $expected_checkbox_value      = NULL  ;

        // ---------------------------------------------------------------------

        $field_value = get_slash_check_get_post_server_or_cookie_field_value(
                            $dataset_title                  ,
                            $array_storage_field_details    ,
                            $_SERVER                        ,
                            'server'                        ,
                            $adding_editing                 ,
                            $question_checkbox_type_field   ,
                            $question_radios_type_field     ,
                            $expected_checkbox_value
                            ) ;

        // ---------------------------------------------------------------------

        if ( is_array( $field_value ) ) {
            return array( $failure , $field_value[0] ) ;
        }

        // ---------------------------------------------------------------------

    } elseif ( $array_storage_field_details['value_from']['method'] === 'cookie' ) {

        // =====================================================================
        // $array_storage_field_details['value_from'] = array(
        //      array(
        //          'method'    =>  'cookie'               ,
        //          'instance'  =>  '<cookie-var-name>'
        //          //  If "instance" is unspecified - or is anything but a
        //          //  non-empty string, then '<cookie-var-name>' defaults to
        //          //  the field's "slug"
        //          //  "args", if specified, is IGNORED
        //          )
        // =====================================================================

        // -------------------------------------------------------------------------
        // get_slash_check_get_post_server_or_cookie_field_value(
        //      $dataset_title                  ,
        //      $array_storage_field_details    ,
        //      $_WHATEVER                      ,
        //      $whatever                       ,
        //      $adding_editing                 ,
        //      $question_checkbox_type_field   ,
        //      $question_radios_type_field
        //      )
        // - - - - - - - - - - - - - - - - - - - - - - - - - - -
        // NOTE!
        // =====
        // The returned CHECKBOX type field values are TRUE or FALSE.
        // All other returned field values are STRINGS.
        //
        // RETURNS
        //      o   On SUCCESS!
        //          - - - - - -
        //          $field_value (BOOL or STRING)
        //
        //      o   On FAILURE!
        //          - - - - - -
        //          array( $error_message STRING )
        // -------------------------------------------------------------------------

        $question_checkbox_type_field = FALSE ;
        $question_radios_type_field   = FALSE ;
        $expected_checkbox_value      = NULL  ;

        // ---------------------------------------------------------------------

        $field_value = get_slash_check_get_post_server_or_cookie_field_value(
                            $dataset_title                  ,
                            $array_storage_field_details    ,
                            $_COOKIE                        ,
                            'cookie'                        ,
                            $adding_editing                 ,
                            $question_checkbox_type_field   ,
                            $question_radios_type_field     ,
                            $expected_checkbox_value
                            ) ;

        // ---------------------------------------------------------------------

        if ( is_array( $field_value ) ) {
            return array( $failure , $field_value[0] ) ;
        }

        // ---------------------------------------------------------------------

    } elseif ( $array_storage_field_details['value_from']['method'] === 'function' ) {

        // =====================================================================
        // $array_storage_field_details['value_from'] = array(
        //      array(
        //          'method'    =>  'function'                                          ,
        //          'instance'  =>  '<function-name-including-namespace-if-necessary>'  ,
        //          'args'      =>  <any-PHP-value>
        //          )
        // =====================================================================

        if ( ! isset( $array_storage_field_details['value_from']['instance'] ) ) {

            $msg = <<<EOT
PROBLEM {$adding_editing} Dataset Record:&nbsp; Bad "array_storage_record_structure" + "value_from" (method "function" requires "instance")
For dataset:&nbsp; "{$dataset_title}"
and field (slug):&nbsp; "{$array_storage_field_details['slug']}"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

            return array( $failure , $msg ) ;

        }

        // ---------------------------------------------------------------------

        if (    ! is_string( $array_storage_field_details['value_from']['instance'] )
                ||
                trim( $array_storage_field_details['value_from']['instance'] ) === ''
                ||
                ! ctype_graph( $array_storage_field_details['value_from']['instance'] )
                ||
                strlen( $array_storage_field_details['value_from']['instance'] ) > 255
            ) {

            $msg = <<<EOT
PROBLEM {$adding_editing} Dataset Record:&nbsp; Bad "array_storage_record_structure" + "value_from" + "instance" (1 to 255 character function name - with optional namespace prefix - expected)
For dataset:&nbsp; "{$dataset_title}"
and field (slug):&nbsp; "{$array_storage_field_details['slug']}"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

            return array( $failure , $msg ) ;

        }

        // ---------------------------------------------------------------------

        if ( ! function_exists( $array_storage_field_details['value_from']['instance'] ) ) {

            $msg = <<<EOT
PROBLEM {$adding_editing} Dataset Record:&nbsp; Bad "array_storage_record_structure" + "value_from" + "instance" (function not found)
For dataset:&nbsp; "{$dataset_title}"
and field (slug):&nbsp; "{$array_storage_field_details['slug']}"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

            return array( $failure , $msg ) ;

        }

        // ---------------------------------------------------------------------

        if ( isset( $array_storage_field_details['value_from']['args'] ) ) {
            $extra_args = $array_storage_field_details['value_from']['args'] ;

        } else {
            $extra_args = NULL ;

        }

        // ---------------------------------------------------------------------
        // Array Storage Get Field Value Function
        // - - - - - - - - - - - - - - - - - - -
        // Is like:-
        //
        //      $field_value = $array_storage_field_details['value_from']['instance'](
        //                          $dataset_manager_home_page_title        ,
        //                          $caller_apps_includes_dir               ,
        //                          $all_application_dataset_definitions    ,
        //                          $dataset_slug                           ,
        //                          $selected_datasets_dmdd                 ,
        //                          $dataset_title                          ,
        //                          $dataset_records                        ,
        //                          $record_indices_by_key                  ,
        //                          $key_field_slug                         ,
        //                          $question_adding                        ,
        //                          $zebra_form_obj                         ,
        //                          $array_storage_field_slug               ,
        //                          $extra_args
        //                          )
        //
        // RETURNS
        //      o   On SUCCESS!
        //          - - - - - -
        //          array( $field_value )
        //          Where $field_value can be any PHP data type
        //
        //      o   On FAILURE!
        //          - - - - - -
        //          $error_message STRING
        // ---------------------------------------------------------------------

        $result = $array_storage_field_details['value_from']['instance'](
                        $dataset_manager_home_page_title        ,
                        $caller_apps_includes_dir               ,
                        $all_application_dataset_definitions    ,
                        $dataset_slug                           ,
                        $selected_datasets_dmdd                 ,
                        $dataset_title                          ,
                        $dataset_records                        ,
                        $record_indices_by_key                  ,
                        $key_field_slug                         ,
                        $question_adding                        ,
                        $zebra_form_obj                         ,
                        $array_storage_field_details['slug']    ,
                        $extra_args
                        ) ;

        // ---------------------------------------------------------------------

        if ( is_string( $result ) ) {
            return array( $failure , $result ) ;
        }

        // ---------------------------------------------------------------------

        $field_value = $result[0] ;

        // ---------------------------------------------------------------------

    } else {

        // =====================================================================
        // ERROR!
        // =====================================================================

        $field_type = htmlentities( $array_storage_field_details['value_from']['method'] ) ;

        $msg = <<<EOT
PROBLEM Adding Dataset Record:&nbsp; Unrecognised/unsupported "array_storage_record_structure" + "value_from" + "method" ("{$field_type}")
For dataset:&nbsp; "{$dataset_title}"
and field (slug):&nbsp; "{$array_storage_field_details['slug']}"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        return array( $failure , $msg ) ;

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // SUCCESS!
    // =========================================================================

    return array( $success , $field_value , $question_change ) ;

    // =========================================================================
    // That's that!
    // =========================================================================

}

// =============================================================================
// get_slash_check_get_post_server_or_cookie_field_value()
// =============================================================================

function get_slash_check_get_post_server_or_cookie_field_value(
    $dataset_title                  ,
    $array_storage_field_details    ,
    $_WHATEVER                      ,
    $whatever                       ,
    $adding_editing                 ,
    $question_checkbox_type_field   ,
    $question_radios_type_field     ,
    $expected_checkbox_value
    ) {

    // -------------------------------------------------------------------------
    // get_slash_check_get_post_server_or_cookie_field_value(
    //      $dataset_title                  ,
    //      $array_storage_field_details    ,
    //      $_WHATEVER                      ,
    //      $whatever                       ,
    //      $adding_editing                 ,
    //      $question_checkbox_type_field   ,
    //      $question_radios_type_field     ,
    //      $expected_checkbox_value
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // NOTE!
    // =====
    // The returned CHECKBOX type field values are TRUE or FALSE.
    // All other returned field values are STRINGS.
    //
    // RETURNS
    //      o   On SUCCESS!
    //          - - - - - -
    //          $field_value (BOOL or STRING)
    //
    //      o   On FAILURE!
    //          - - - - - -
    //          array( $error_message STRING )
    // -------------------------------------------------------------------------

    $ns = __NAMESPACE__ ;
    $fn = __FUNCTION__  ;

    // -------------------------------------------------------------------------

    if ( ! isset( $array_storage_field_details['value_from']['instance'] ) ) {

        $msg = <<<EOT
PROBLEM {$adding_editing} Dataset Record:&nbsp; Bad "array_storage_record_structure" + "value_from" (method "{$whatever}" requires "instance")
For dataset:&nbsp; "{$dataset_title}"
and field (slug):&nbsp; "{$array_storage_field_details['slug']}"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        return array( $msg ) ;

    }

    // -------------------------------------------------------------------------

    if (    ! is_string( $array_storage_field_details['value_from']['instance'] )
            ||
            trim( $array_storage_field_details['value_from']['instance'] ) === ''
            ||
            ! \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_stringUtils\ctype_varname( $array_storage_field_details['value_from']['instance'] )
            ||
            strlen( $array_storage_field_details['value_from']['instance'] ) > 64
        ) {

        $msg = <<<EOT
PROBLEM {$adding_editing} Dataset Record:&nbsp; Bad "array_storage_record_structure" + "value_from" + "instance" (1 to 64 character variable name like string expected)
For dataset:&nbsp; "{$dataset_title}"
and field (slug):&nbsp; "{$array_storage_field_details['slug']}"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        return array( $msg ) ;

    }

    // -------------------------------------------------------------------------

    if ( ! array_key_exists(
                $array_storage_field_details['value_from']['instance']    ,
                $_WHATEVER
                )
        ) {

        // ---------------------------------------------------------------------

        if ( $question_checkbox_type_field ) {
            return FALSE ;
            //  A CHECKBOX field that's NOT present in the submitted form is a
            //  checkbox that ISN'T ticked.
            //
            //  And is stored as field value FALSE in the ARRAY storage
            //  record.

        }

        // ---------------------------------------------------------------------

        if ( $question_radios_type_field ) {

            // -----------------------------------------------------------------

            if ( ! array_key_exists( 'default' , $array_storage_field_details['value_from'] ) ) {

                $msg = <<<EOT
PROBLEM {$adding_editing} Dataset Record:&nbsp; Bad "array_storage_record_structure" + "value_from" (no "default" specified for "radios" type field)
For dataset:&nbsp; "{$dataset_title}"
and field (slug):&nbsp; "{$array_storage_field_details['slug']}"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

                return array( $msg ) ;

            }

            // -----------------------------------------------------------------

            if ( ! is_string( $array_storage_field_details['value_from']['default'] ) ) {

                $msg = <<<EOT
PROBLEM {$adding_editing} Dataset Record:&nbsp; Bad "array_storage_record_structure" + "value_from" + "default" (string expected)
For dataset:&nbsp; "{$dataset_title}"
and field (slug):&nbsp; "{$array_storage_field_details['slug']}"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

                return array( $msg ) ;

            }

            // -----------------------------------------------------------------

            return $array_storage_field_details['value_from']['default'] ;

            // -----------------------------------------------------------------

        }

        // ---------------------------------------------------------------------

        $instance = htmlentities( $array_storage_field_details['value_from']['instance'] ) ;

        $whatever_uc = strtoupper( $whatever ) ;

        $msg = <<<EOT
PROBLEM {$adding_editing} Dataset Record:&nbsp; Bad "array_storage_record_structure" + "value_from" + "instance" (no {$whatever_uc} variable named "{$instance}")
For dataset:&nbsp; "{$dataset_title}"
and field (slug):&nbsp; "{$array_storage_field_details['slug']}"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        return array( $msg ) ;

    }

    // -------------------------------------------------------------------------

    if ( $question_checkbox_type_field ) {

        // ---------------------------------------------------------------------

        if ( $_WHATEVER[ $array_storage_field_details['value_from']['instance'] ] !== $expected_checkbox_value ) {

            $safe_whatever_field_name = htmlentities( $array_storage_field_details['value_from']['instance'] ) ;

            $msg = <<<EOT
PROBLEM:&nbsp; Unexpected checkbox field value
For dataset:&nbsp; "{$dataset_title}"
and field:&nbsp; "{$safe_whatever_field_name}"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

            return array( $msg ) ;

        }

        // ---------------------------------------------------------------------

        return TRUE ;
            //  A CHECKBOX field that IS present in the submitted form is a
            //  checkbox that IS ticked.
            //
            //  And is stored as field value TRUE in the ARRAY storage
            //  record.

        // ---------------------------------------------------------------------

    }

    // -------------------------------------------------------------------------

    $field_value = $_WHATEVER[ $array_storage_field_details['value_from']['instance'] ] ;

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_wordpressMagicQuotes\
    // question_magic_quotes_gpc()
    // - - - - - - - - - - - - - -
    // RETURNS
    //      o   TRUE if $_GET, $_POST and $_COOKIE values have had
    //          "addslashes()" done to them (and thus, need to be run
    //          through "stripslashes()" before use).
    //      o   FALSE otherwise.
    // -------------------------------------------------------------------------

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_wordpressMagicQuotes\
    // question_magic_quotes_server()
    // - - - - - - - - - - - - - - -
    // RETURNS
    //      o   TRUE if $_SERVER values have had "addslashes()" done to them
    //          (and thus, need to be run through "stripslashes()" before use).
    //      o   FALSE otherwise.
    // -------------------------------------------------------------------------

    if (    in_array( $whatever , array( 'get' , 'post' , 'cookie' ) , TRUE )
            &&
            \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_wordpressMagicQuotes\question_magic_quotes_gpc()
        ) {
        return \stripslashes( $field_value ) ;

    } elseif (  $whatever === 'server'
                &&
                \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_wordpressMagicQuotes\question_magic_quotes_server()
        ) {
        return \stripslashes( $field_value ) ;

    }

    // -------------------------------------------------------------------------

    return $field_value ;

    // -------------------------------------------------------------------------

}

// =============================================================================
// handle_array_storage_constraints()
// =============================================================================

function handle_array_storage_constraints(
    $caller_apps_includes_dir       ,
    $dataset_title                  ,
    $dataset_records                ,
    $array_storage_field_details    ,
    $question_adding                ,
    $new_or_existing_field_value    ,
    $record_being_editeds_index
    ) {

    // -------------------------------------------------------------------------
    // handle_array_storage_constraints(
    //      $caller_apps_includes_dir       ,
    //      $dataset_title                  ,
    //      $dataset_records                ,
    //      $array_storage_field_details    ,
    //      $question_adding                ,
    //      $new_or_existing_field_value    ,
    //      $record_being_editeds_index
    //      )
    // - - - - - - - - - - - - -
    // RETURNS
    //      o   On SUCCESS!
    //          - - - - - -
    //          TRUE
    //
    //      o   On FAILURE!
    //          - - - - - -
    //          $error_message STRING
    //
    //          NOTE!
    //          =====
    //          If the error message string begins with "--ZEBRA--", then it's
    //          assumed to be a "friendly" error message - that should be
    //          displayed at the top of the (re-displayed) Zebra Form.
    // -------------------------------------------------------------------------

    // =========================================================================
    // Anything to do ?
    // =========================================================================

    if ( ! isset( $array_storage_field_details['constraints'] ) ) {
        return TRUE ;
    }

    // =========================================================================
    // YES!
    // =========================================================================

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $array_storage_field_details['constraints'] = array(
    //
    //          //  An ARRAY containing zero or more sub-arrays, as follows:-
    //
    //          array(
    //              'method'    =>  'unique'
    //              //  "instance" and "args", if specified, are ignored
    //              )
    //
    //          array(
    //              'method'    =>  'unique-case-insensitively'
    //              //  "instance" and "args", if specified, are ignored
    //              )
    //
    //          array(
    //              'method'    =>  'unique-key'
    //              //  "instance" and "args", if specified, are ignored
    //              )
    //
    //          array(
    //              'method'    =>  'unique-key-or-empty-string'
    //              //  "instance" and "args", if specified, are ignored
    //              )
    //
    //          array(
    //              'method'    =>  'unique-key-or-some-other-string'
    //              'instance'  =>  "other_string"
    //                              --OR--
    //                              array(
    //                                  'other-str-1'   ,
    //                                  'other-str-2'   ,
    //                                  ...
    //                                  )
    //              //  "args", if specified, is ignored
    //              )
    //
    //          array(
    //              'method'    =>  'in-array-strict'
    //              'instance'  =>  array(...)
    //              //  "args", if specified, is ignored
    //              )
    //
    //          array(
    //              'method'    =>  'in-array-not-strict'
    //              'instance'  =>  array(...)
    //              //  "args", if specified, is ignored
    //              )
    //
    //          array(
    //              'method'    =>  'custom'
    //              'instance'  =>  '<function name, including namespace prefix
    //                              if necessary>'
    //              'args'      =>  Any PHP value (including typically a PHP
    //                              object or associative array of
    //                              name=value pairs), that you want to pass
    //                              to the custom function.  If NOT
    //                              specified, NULL will be passed.
    //              )
    //
    //          array(
    //              'method'    =>  'email-address'
    //              'instance'  =>  'strict' | 'not-strict' (default)
    //              //  "args", if specified, is ignored
    //              )
    //
    //          array(
    //              'method'    =>  'bool'
    //              //  "instance" and "args", if specified, are ignored
    //              )
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
    // Some useful shortcuts...
    // =========================================================================

    if ( $question_adding ) {
        $adding_editing = 'Adding' ;

    } else {
        $adding_editing = 'Editing' ;

    }

    // =========================================================================
    // Check the constrants...
    // =========================================================================

    if ( ! is_array( $array_storage_field_details['constraints'] ) ) {

        return <<<EOT
PROBLEM {$adding_editing} Dataset Record:&nbsp; Bad "array_storage_record_structure" + "constraints" (not an array)
For dataset:&nbsp; "{$dataset_title}"
and field (slug):&nbsp; "{$array_storage_field_details['slug']}"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

    }

    // -------------------------------------------------------------------------

    foreach ( $array_storage_field_details['constraints'] as $this_index => $this_constraint ) {

        // ---------------------------------------------------------------------

        $constraint_number = $this_index + 1 ;

        // ---------------------------------------------------------------------

        if ( ! is_array( $this_constraint ) ) {

            return <<<EOT
PROBLEM {$adding_editing} Dataset Record:&nbsp; Bad "array_storage_record_structure" + "constraints" - for constraint# {$constraint_number} (not an array)
For dataset:&nbsp; "{$dataset_title}"
and field (slug):&nbsp; "{$array_storage_field_details['slug']}"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        }

        // ---------------------------------------------------------------------

        if ( ! isset( $this_constraint['method'] ) ) {

            return <<<EOT
PROBLEM {$adding_editing} Dataset Record:&nbsp; No "array_storage_record_structure" + "constraints"  + "method" - for constraint# {$constraint_number}
For dataset:&nbsp; "{$dataset_title}"
and field (slug):&nbsp; "{$array_storage_field_details['slug']}"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        }

        // ---------------------------------------------------------------------

        if (    ! is_string( $this_constraint['method'] )
                ||
                trim( $this_constraint['method'] ) === ''
                ||
                ! \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_stringUtils\ctype_alphanumeric_underscore_dash( $this_constraint['method'] )
                ||
                strlen( $this_constraint['method'] ) > 64
            ) {

            return <<<EOT
PROBLEM {$adding_editing} Dataset Record:&nbsp; Bad "array_storage_record_structure" + "constraints"  + "method" - for constraint# {$constraint_number} (1 to 64 character alphanumeric underscore dash type string expected)
For dataset:&nbsp; "{$dataset_title}"
and field (slug):&nbsp; "{$array_storage_field_details['slug']}"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        }

        // ---------------------------------------------------------------------

        if ( $this_constraint['method'] === 'unique' ) {

            // =================================================================
            // FIELD CONSTRAINT = "UNIQUE"
            // =================================================================

            // -----------------------------------------------------------------
            // In other words, there may be max. one record that
            // has any given value.
            // -----------------------------------------------------------------

            foreach ( $dataset_records as $this_record_index => $this_record ) {

                // -------------------------------------------------------------

                if (    isset( $this_record[ $array_storage_field_details['slug'] ] )
                        &&
                        $this_record[ $array_storage_field_details['slug'] ] == $new_or_existing_field_value
                    ) {

                    // ---------------------------------------------------------

                    if (    $question_adding
                            ||
                            $record_being_editeds_index !== $this_record_index
                        ) {

                        // -----------------------------------------------------

/*
                        $safe_field_value = htmlentities( $new_or_existing_field_value ) ;

                        return <<<EOT
PROBLEM {$adding_editing} Dataset Record:&nbsp; "{$array_storage_field_details['slug']}" field value ("{$safe_field_value}") NOT UNIQUE (a record with this value already exists).
For dataset:&nbsp; "{$dataset_title}"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;
*/

                        // -----------------------------------------------------

                        $field_title = \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_stringUtils\to_title( $array_storage_field_details['slug'] ) ;

                        // -----------------------------------------------------

/*
                        $msg = <<<EOT
--ZEBRA--Please enter UNIQUE "{$field_title}"
EOT;
*/

                        // -----------------------------------------------------

                        return <<<EOT
--ZEBRA--A record with the {$field_title} "{$new_or_existing_field_value}" already exists.&nbsp; Please enter another {$field_title}...
EOT;

                        // -----------------------------------------------------

                    }

                    // ---------------------------------------------------------

                }

                // -------------------------------------------------------------

            }

            // -----------------------------------------------------------------

        } elseif ( $this_constraint['method'] === 'unique-case-insensitively' ) {

            // =================================================================
            // FIELD CONSTRAINT = "UNIQUE-CASE-INSENSITIVELY"
            // =================================================================

            // -----------------------------------------------------------------
            // In other words, there may be max. one record that
            // has any given value.
            // -----------------------------------------------------------------

            $new_or_existing_field_value_lc = strtolower( $new_or_existing_field_value ) ;

            // -----------------------------------------------------------------

            foreach ( $dataset_records as $this_record_index => $this_record ) {

                // -------------------------------------------------------------

                if (    isset( $this_record[ $array_storage_field_details['slug'] ] )
                        &&
                        strtolower( $this_record[ $array_storage_field_details['slug'] ] ) === $new_or_existing_field_value_lc
                    ) {

                    // ---------------------------------------------------------

                    if (    $question_adding
                            ||
                            $record_being_editeds_index !== $this_record_index
                        ) {

                        // -----------------------------------------------------

/*
                        $safe_field_value = htmlentities( $new_or_existing_field_value ) ;

                        return <<<EOT
PROBLEM {$adding_editing} Dataset Record:&nbsp; "{$array_storage_field_details['slug']}" field value ("{$safe_field_value}") NOT UNIQUE (a record with this value already exists).
For dataset:&nbsp; "{$dataset_title}"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;
*/

                        // -----------------------------------------------------

                        $field_title = \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_stringUtils\to_title( $array_storage_field_details['slug'] ) ;

                        // -----------------------------------------------------

/*
                        $msg = <<<EOT
--ZEBRA--Please enter UNIQUE "{$field_title}"
EOT;
*/

                        // -----------------------------------------------------

                        return <<<EOT
--ZEBRA--A record with the {$field_title} "{$new_or_existing_field_value}" already exists.&nbsp; Please enter another {$field_title} (that differs from any existing {$field_title} by more than just case)...
EOT;

                        // -----------------------------------------------------

                    }

                    // ---------------------------------------------------------

                }

                // -------------------------------------------------------------

            }

            // -----------------------------------------------------------------

        } elseif ( $this_constraint['method'] === 'unique-key' ) {

            // =================================================================
            // FIELD CONSTRAINT = "UNIQUE-KEY"
            // =================================================================

            // -------------------------------------------------------------------------
            // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\
            // is_record_key(
            //      $candidate_record_key
            //      )
            // - - - - - - - - - - - - - - - - -
            // Is the input string a record key like (eg):-
            //
            //      3f2504e0-4f89-11d3-9a0c-0305e82c3301-1400040711-0-1
            //      3f2504e0-4f89-11d3-9a0c-0305e82c3301-1400040711-999977-2147483647
            //      etc
            //
            // RETURNS
            //      o   On SUCCESS
            //              TRUE
            //
            //      o   On FAILURE
            //              FALSE
            // ---------------------------------------------------------------------------

            if ( ! is_record_key( $new_or_existing_field_value ) ) {

                // -------------------------------------------------------------

                $field_title =
                    \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_stringUtils\to_title(
                        $array_storage_field_details['slug']
                        ) ;

                // --------------------------------------------------------------

                return <<<EOT
--ZEBRA--"{$field_title}" must be a Standard Dataset Manager "unique key"
EOT;

                // --------------------------------------------------------------

            }

            // ------------------------------------------------------------------

        } elseif ( $this_constraint['method'] === 'unique-key-or-empty-string' ) {

            // =================================================================
            // FIELD CONSTRAINT = "UNIQUE-KEY-OR-EMPTY-STRING"
            // =================================================================

            // -------------------------------------------------------------------------
            // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\
            // is_record_key(
            //      $candidate_record_key
            //      )
            // - - - - - - - - - - - - - - - - -
            // Is the input string a record key like (eg):-
            //
            //      3f2504e0-4f89-11d3-9a0c-0305e82c3301-1400040711-0-1
            //      3f2504e0-4f89-11d3-9a0c-0305e82c3301-1400040711-999977-2147483647
            //      etc
            //
            // RETURNS
            //      o   On SUCCESS
            //              TRUE
            //
            //      o   On FAILURE
            //              FALSE
            // ---------------------------------------------------------------------------

            // -----------------------------------------------------------------
            // The field value should be a record key like (eg):-
            //      3f2504e0-4f89-11d3-9a0c-0305e82c3301-1400040711-0-1
            //      3f2504e0-4f89-11d3-9a0c-0305e82c3301-1400040711-999977-2147483647
            //      etc
            //
            // Though an empty string is also allowed.  This copes with (for
            // example), a category tree.  where the root catagories have NO
            // parent - and thus their "parent category key"s are the empty
            // string.
            // -----------------------------------------------------------------

            $field_title =
                \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_stringUtils\to_title(
                    $array_storage_field_details['slug']
                    ) ;

            // -----------------------------------------------------------------

            $err_msg = <<<EOT
--ZEBRA--"{$field_title}" must be either; a Standard Dataset Manager "unique key", or; the empty string.
EOT;

            // -----------------------------------------------------------------

            if ( ! is_string( $new_or_existing_field_value ) ) {
                return $err_msg ;
            }

            // -----------------------------------------------------------------

            if ( $new_or_existing_field_value !== '' ) {

                // -------------------------------------------------------------

                if ( ! is_record_key( $new_or_existing_field_value ) ) {
                    return $err_msg ;
                }

                // --------------------------------------------------------------

            }

            // ------------------------------------------------------------------

        } elseif ( $this_constraint['method'] === 'unique-key-or-some-other-string' ) {

            // =================================================================
            // FIELD CONSTRAINT = "UNIQUE-KEY-OR-SOME-OTHER-STRING"
            // =================================================================

            // -------------------------------------------------------------------------
            // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\
            // is_record_key(
            //      $candidate_record_key
            //      )
            // - - - - - - - - - - - - - - - - -
            // Is the input string a record key like (eg):-
            //
            //      3f2504e0-4f89-11d3-9a0c-0305e82c3301-1400040711-0-1
            //      3f2504e0-4f89-11d3-9a0c-0305e82c3301-1400040711-999977-2147483647
            //      etc
            //
            // RETURNS
            //      o   On SUCCESS
            //              TRUE
            //
            //      o   On FAILURE
            //              FALSE
            // ---------------------------------------------------------------------------

            // -----------------------------------------------------------------
            // The field value should be a record key like (eg):-
            //      3f2504e0-4f89-11d3-9a0c-0305e82c3301-1400040711-0-1
            //      3f2504e0-4f89-11d3-9a0c-0305e82c3301-1400040711-999977-2147483647
            //      etc
            //
            // Though another string is also allowed.  As specified by the
            // "instance" parameter.
            // -----------------------------------------------------------------

            // -----------------------------------------------------------------
            // Here we should have:-
            //
            //      array(
            //          'method'    =>  'unique-key-or-some-other-string'
            //          'instance'  =>  "other_string"
            //                          --OR--
            //                          array(
            //                              'other-str-1'   ,
            //                              'other-str-2'   ,
            //                              ...
            //                              )
            //          //  "args", if specified, is ignored
            //          )
            //
            // -----------------------------------------------------------------

            $field_title =
                \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_stringUtils\to_title(
                    $array_storage_field_details['slug']
                    ) ;

            // -----------------------------------------------------------------

            $err_msg = <<<EOT
--ZEBRA--"{$field_title}" must be either; a Standard Dataset Manager "unique key", or; some pre-defined string.
EOT;

            // -----------------------------------------------------------------

            if ( ! is_string( $new_or_existing_field_value ) ) {
                return $err_msg ;
            }

            // -----------------------------------------------------------------

            if ( ! is_record_key( $new_or_existing_field_value ) ) {

                // -------------------------------------------------------------

                if ( ! array_key_exists( 'instance' , $this_constraint ) ) {

                    return <<<EOT
PROBLEM:&nbsp; No "instance" (for the "{$field_title}" field, array storage constraint)
In dataset:&nbsp; "{$dataset_title}"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

                }

                // -------------------------------------------------------------

                if ( is_string( $this_constraint['instance'] ) ) {

                    if ( $new_or_existing_field_value !== $this_constraint['instance'] ) {
                        return $err_msg ;
                    }

                } elseif ( is_array( $this_constraint['instance'] ) ) {

                    if ( ! in_array( $new_or_existing_field_value , $this_constraint['instance'] ) ) {
                        return $err_msg ;
                    }

                } else {

                    return <<<EOT
PROBLEM: Bad "instance" (for the "{$field_title}" field, array storage constraint - string or array expected)
In dataset:&nbsp; "{$dataset_title}"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

                }

                // -----------------------------------------------------------------

            }

            // -----------------------------------------------------------------

        } elseif ( $this_constraint['method'] === 'in-array-strict' ) {

            // =================================================================
            // FIELD CONSTRAINT = "IN-ARRAY-STRICT"
            // =================================================================

            if ( ! isset( $this_constraint['instance'] ) ) {

                return <<<EOT
PROBLEM {$adding_editing} Dataset Record:&nbsp; No "array_storage_record_structure" + "constraints"  + "instance" - for constraint# {$constraint_number}
For dataset:&nbsp; "{$dataset_title}"
and field (slug):&nbsp; "{$array_storage_field_details['slug']}"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

            }

            // -----------------------------------------------------------------

            if ( ! is_array( $this_constraint['instance'] ) ) {

                return <<<EOT
PROBLEM {$adding_editing} Dataset Record:&nbsp; Bad "array_storage_record_structure" + "constraints"  + "instance" - for constraint# {$constraint_number} (array expected)
For dataset:&nbsp; "{$dataset_title}"
and field (slug):&nbsp; "{$array_storage_field_details['slug']}"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

            }

            // -----------------------------------------------------------------

            if ( ! in_array( $new_or_existing_field_value , $this_constraint['instance'] , TRUE ) ) {

                // -------------------------------------------------------------

                $field_title = \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_stringUtils\to_title( $array_storage_field_details['slug'] ) ;

                // --------------------------------------------------------------

                $new_or_existing_field_value = htmlentities( $new_or_existing_field_value ) ;

                // --------------------------------------------------------------

                return <<<EOT
--ZEBRA--Bad "{$field_title}" ("{$new_or_existing_field_value}" isn't a recognised/supported value for this field)
EOT;

                // --------------------------------------------------------------

            }

            // -----------------------------------------------------------------

        } elseif ( $this_constraint['method'] === 'unix-timestamp' ) {

            // =================================================================
            // FIELD CONSTRAINT = "UNIX-TIMESTAMP"
            // =================================================================

            $new_or_existing_field_value_str = (string) $new_or_existing_field_value ;

            // -----------------------------------------------------------------

            if (    ! is_scalar( $new_or_existing_field_value )
                    ||
                    trim( $new_or_existing_field_value_str ) === ''
                    ||
                    ! ctype_digit( $new_or_existing_field_value_str )
                    ||
                    strlen( $new_or_existing_field_value_str ) > 32
                ) {

                // -------------------------------------------------------------

                $field_title = \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_stringUtils\to_title( $array_storage_field_details['slug'] ) ;

                // --------------------------------------------------------------

                $new_or_existing_field_value = htmlentities( $new_or_existing_field_value ) ;

                // --------------------------------------------------------------

                return <<<EOT
--ZEBRA--Bad "{$field_title}" ("{$new_or_existing_field_value}" - a Unix Timestamp was expected)
EOT;

                // --------------------------------------------------------------

            }

            // -----------------------------------------------------------------

        } elseif ( $this_constraint['method'] === 'unix-timestamp-with-microseconds' ) {

            // =================================================================
            // FIELD CONSTRAINT = "UNIX-TIMESTAMP-WITH-MICROSECONDS"
            // =================================================================

            // -----------------------------------------------------------------
            // NOTE!
            // -----
            // "Micro" dates/times are expressed as floats like (eg):-
            //
            //      12.34 = 12 seconds and 340,000 microseconds
            //
            // "micro" = 1 millionth
            // -----------------------------------------------------------------

            $new_or_existing_field_value_str = (string) $new_or_existing_field_value ;

            // -----------------------------------------------------------------

            $field_title = \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_stringUtils\to_title( $array_storage_field_details['slug'] ) ;

            // -----------------------------------------------------------------

            $unix_timestamp_with_microseconds_error_message = <<<EOT
--ZEBRA--Bad "{$field_title}" ("{$new_or_existing_field_value}" - a Unix Timestamp in float format with optional microseconds was expected : Please enter (eg;) "12.34" = 12 seconds and 340,000 microseconds)
EOT;

            // -----------------------------------------------------------------

            $ignore_case = TRUE ;

            // -----------------------------------------------------------------

            if ( \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_stringUtils\contains( $new_or_existing_field_value_str , '.' , $ignore_case ) ) {

                // -------------------------------------------------------------
                // "12.34" expected...
                // -------------------------------------------------------------

                $parts = explode( '.' , $new_or_existing_field_value_str ) ;

                // -------------------------------------------------------------

                if (    count( $parts ) !== 2
                        ||
                        ! ctype_digit( $parts[0] )
                        ||
                        strlen( $parts[0] ) > 11
                        ||
                        ! ctype_digit( $parts[1] )
                        ||
                        strlen( $parts[1] ) > 6
                    ) {
                    return $unix_timestamp_with_microseconds_error_message ;
                }

                // -------------------------------------------------------------

            } else {

                // -------------------------------------------------------------
                // "1234" expected...
                // -------------------------------------------------------------

                if (    trim( $new_or_existing_field_value_str ) === ''
                        ||
                        strlen( $new_or_existing_field_value_str ) > 11
                        ||
                        ! ctype_digit( $new_or_existing_field_value_str )
                    ) {
                    return $unix_timestamp_with_microseconds_error_message ;
                }

                // -------------------------------------------------------------

            }

            // -----------------------------------------------------------------

        } elseif ( $this_constraint['method'] === 'custom' ) {

            // =================================================================
            // FIELD CONSTRAINT = "CUSTOM" (FUNCTION)
            // =================================================================

            // -----------------------------------------------------------------
            // Here we should have (eg):-
            //
            //      $this_constraint = array(
            //          'method'    =>  'custom'
            //          'instance'  =>  '<function name, including namespace
            //                          prefix if necessary>'
            //          'args'      =>  Any PHP value (including typically a PHP
            //                          object or associative array of
            //                          name=value pairs), that you want to pass
            //                          to the custom function.  If NOT
            //                          specified, NULL will be passed.
            //          )
            //
            // -----------------------------------------------------------------

            if ( ! array_key_exists( 'instance' , $this_constraint ) ) {

                return <<<EOT
PROBLEM {$adding_editing} Dataset Record:&nbsp; No "array_storage_record_structure" + "constraints"  + "instance" - for constraint# {$constraint_number}
For dataset:&nbsp; "{$dataset_title}"
and field (slug):&nbsp; "{$array_storage_field_details['slug']}"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

            }

            // -----------------------------------------------------------------

            if (    ! is_string( $this_constraint['instance'] )
                    ||
                    trim( $this_constraint['instance'] ) === ''
                    ||
                    strlen( $this_constraint['instance'] ) > 512
                ) {

                return <<<EOT
PROBLEM {$adding_editing} Dataset Record:&nbsp; Bad "array_storage_record_structure" + "constraints"  + "instance" - for constraint# {$constraint_number} (1 to 512 character string expected)
For dataset:&nbsp; "{$dataset_title}"
and field (slug):&nbsp; "{$array_storage_field_details['slug']}"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

            }

            // -----------------------------------------------------------------

            if ( ! function_exists( $this_constraint['instance'] ) ) {

                return <<<EOT
PROBLEM {$adding_editing} Dataset Record:&nbsp; Bad "array_storage_record_structure" + "constraints"  + "instance" - for constraint# {$constraint_number} (no such function)
For dataset:&nbsp; "{$dataset_title}"
and field (slug):&nbsp; "{$array_storage_field_details['slug']}"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

            }

            // -------------------------------------------------------------------------
            // <my_custom_field_value_checker_function>(
            //      $caller_apps_includes_dir       ,
            //      $dataset_title                  ,
            //      $dataset_records                ,
            //      $array_storage_field_details    ,
            //      $question_adding                ,
            //      $new_or_existing_field_value    ,
            //      $record_being_editeds_index     ,
            //      $custom_args
            //      )
            // - - - - - - - - - - - - -
            // RETURNS
            //      o   On SUCCESS!
            //          - - - - - -
            //          TRUE
            //
            //      o   On FAILURE!
            //          - - - - - -
            //          $error_message STRING
            //
            //          NOTE!
            //          =====
            //          If the error message string begins with "--ZEBRA--", then it's
            //          assumed to be a "friendly" error message - that should be
            //          displayed at the top of the (re-displayed) Zebra Form.
            // -------------------------------------------------------------------------

            if ( ! array_key_exists( 'args' , $this_constraint ) ) {
                $custom_args = NULL ;

            } else {
                $custom_args = $this_constraint['args'] ;

            }

            // -----------------------------------------------------------------

            $result = $this_constraint['instance'](
                            $caller_apps_includes_dir       ,
                            $dataset_title                  ,
                            $dataset_records                ,
                            $array_storage_field_details    ,
                            $question_adding                ,
                            $new_or_existing_field_value    ,
                            $record_being_editeds_index     ,
                            $custom_args
                            ) ;

            // -----------------------------------------------------------------

            if ( is_string( $result ) ) {
                return $result ;
            }

            // -----------------------------------------------------------------

        } elseif ( $this_constraint['method'] === 'email' ) {

            // =================================================================
            // FIELD CONSTRAINT = "EMAIL"
            // =================================================================

            // -----------------------------------------------------------------
            // Here we should have (eg):-
            //
            //      $this_constraint = array(
            //          'method'    =>  'email'
            //          'instance'  =>  'strict' (must pass all available email tests)
            //                          --OR--
            //                          'loose' (is accepted so long as it passes at
            //                                  least one email test).
            //          //  "args", if specified, is ignored
            //          )
            //
            // -----------------------------------------------------------------

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $this_constraint ) ;

            $question_strict = FALSE ;
                //  Must pass at least one test...

            // -----------------------------------------------------------------

            if (    array_key_exists( 'instance' , $this_constraint )
                    &&
                    $this_constraint['instance'] === 'strict'
                ) {
                $question_strict = TRUE ;
                    //  Must pass ALL (available) email tests...
            }

            // -----------------------------------------------------------------

            $question_loose = ! $question_strict ;

            $number_tests_available = 0 ;

            $number_tests_passed = 0 ;

            $bad_email = <<<EOT
--ZEBRA--Invalid email address<br />Please try again...
EOT;

            // -----------------------------------------------------------------
            // FILTER_VALIDATE_EMAIL
            // -----------------------------------------------------------------

            // -------------------------------------------------------------------------
            // mixed filter_var ( mixed $variable [, int $filter = FILTER_DEFAULT [, mixed $options ]] )
            // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
            // Filters a variable with a specified filter
            //
            //      variable
            //          Value to filter.
            //
            //      filter
            //          The ID of the filter to apply. The Types of filters manual page
            //          lists the available filters.
            //
            //      options
            //          Associative array of options or bitwise disjunction of flags. If
            //          filter accepts options, flags can be provided in "flags" field
            //          of array. For the "callback" filter, callable type should be
            //          passed. The callback must accept one argument, the value to be
            //          filtered, and return the value after filtering/sanitizing it.
            //
            //          // for filters that accept options, use this format
            //          $options = array(
            //              'options' => array(
            //                  'default' => 3, // value to return if the filter fails
            //                  // other options here
            //                  'min_range' => 0
            //              ),
            //              'flags' => FILTER_FLAG_ALLOW_OCTAL,
            //          );
            //          $var = filter_var('0755', FILTER_VALIDATE_INT, $options);
            //
            //          // for filter that only accept flags, you can pass them directly
            //          $var = filter_var('oops', FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
            //
            //          // for filter that only accept flags, you can also pass as an array
            //          $var = filter_var('oops', FILTER_VALIDATE_BOOLEAN,
            //                            array('flags' => FILTER_NULL_ON_FAILURE));
            //
            //          // callback validate filter
            //          function foo($value)
            //          {
            //              // Expected format: Surname, GivenNames
            //              if (strpos($value, ", ") === false) return false;
            //              list($surname, $givennames) = explode(", ", $value, 2);
            //              $empty = (empty($surname) || empty($givennames));
            //              $notstrings = (!is_string($surname) || !is_string($givennames));
            //              if ($empty || $notstrings) {
            //                  return false;
            //              } else {
            //                  return $value;
            //              }
            //          }
            //          $var = filter_var('Doe, Jane Sue', FILTER_CALLBACK, array('options' => 'foo'));
            //
            // Returns the filtered data, or FALSE if the filter fails.
            //
            // (PHP 5 >= 5.2.0)
            // -------------------------------------------------------------------------

            if ( function_exists( '\\filter_var' ) ) {

                $number_tests_available++ ;

                if ( \filter_var( $new_or_existing_field_value , FILTER_VALIDATE_EMAIL ) !== FALSE ) {

                    if ( $question_loose ) {
                        continue ;          //  Valid email
                    }

                    $number_tests_passed++ ;

                }

            }

            // -----------------------------------------------------------------
            //  /**
            //  Validate an email address.
            //  Provide email address (raw input)
            //  Returns true if the email address has the email
            //  address format and the domain exists.
            //  */
            //
            //  /*
            //  From:   Linux Journal, Issue 158
            //          "Validate an E-Mail Address with PHP, the Right Way"
            //          Douglas Lovell
            //          Jun 01, 2007
            //
            //          http://www.linuxjournal.com/article/9585?page=0,0
            //  */
            // -----------------------------------------------------------------

            require_once( $caller_apps_includes_dir . '/validEmail-douglasLovell.php' ) ;

            // -----------------------------------------------------------------

            if ( function_exists( '\\validEmail' ) ) {

                $number_tests_available++ ;

                if ( \validEmail( $new_or_existing_field_value ) ) {

                    if ( $question_loose ) {
                        continue ;          //  Valid email
                    }

                    $number_tests_passed++ ;

                }

            }

            // -----------------------------------------------------------------

            if ( $number_tests_available === 0 ) {

                return <<<EOT
PROBLEM {$adding_editing} Dataset Record:&nbsp; Can't validate "email" field (no email validation routines available)
For dataset:&nbsp; "{$dataset_title}"
and field (slug):&nbsp; "{$array_storage_field_details['slug']}"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

            }

            // -----------------------------------------------------------------

            if ( $number_tests_passed >= $number_tests_available ) {
                continue ;          //  Valid email

            } elseif ( $number_tests_passed === 0 ) {
                return $bad_email ;

            }

            // -----------------------------------------------------------------
            // At least one - but NOT all available - tests passed...
            // -----------------------------------------------------------------

            if ( $question_strict ) {
                return $bad_email ;
            }

            // -----------------------------------------------------------------

            continue ;          //  Valid email

            // -----------------------------------------------------------------

        } elseif ( $this_constraint['method'] === 'bool' ) {

            // =================================================================
            // FIELD CONSTRAINT = "BOOL"
            // =================================================================

            // -----------------------------------------------------------------
            // Here we should have (eg):-
            //
            //      $this_constraint = array(
            //          'method'    =>  'bool'
            //          //  "instance" and "args", if specified, are ignored
            //          )
            //
            // -----------------------------------------------------------------

            if (    $new_or_existing_field_value !== '0'
                    &&
                    $new_or_existing_field_value !== '1'
                ) {

                $safe_new_or_existing_field_value = htmlentities( $new_or_existing_field_value ) ;

                return <<<EOT
--ZEBRA--Bad "{$field_title}" ("{$safe_new_or_existing_field_value}" - "0" or "1" was expected)
EOT;

            }

            // -----------------------------------------------------------------

            continue ;          //  Valid bool

            // -----------------------------------------------------------------

        } else {

            // =================================================================
            // ERROR
            // =================================================================

            $constraint_method = htmlentities( $this_constraint['method'] ) ;

            return <<<EOT
PROBLEM {$adding_editing} Dataset Record:&nbsp; Unrecognised/unsupported "array_storage_record_structure" + "constraints" + "method" - for constraint# {$constraint_number} ("{$constraint_method}")
For dataset:&nbsp; "{$dataset_title}"
and field (slug):&nbsp; "{$array_storage_field_details['slug']}"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

            // -----------------------------------------------------------------

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
// is_array_storage_field_a_checkbox_type_field()
// =============================================================================

/*
function is_array_storage_field_a_checkbox_type_field(
    $selected_datasets_dmdd                                         ,
    $zebra_form_definition                                          ,
    $dataset_slug                                                   ,
    $dataset_title                                                  ,
    $array_storage_field_details                                    ,
    $zebra_form_field_indices_of_checkbox_type_zebra_form_fields    ,
    $get_post
    ) {

    // -------------------------------------------------------------------------
    // is_array_storage_field_a_checkbox_type_field(
    //      $selected_datasets_dmdd                                         ,
    //      $zebra_form_definition                                          ,
    //      $dataset_slug                                                   ,
    //      $dataset_title                                                  ,
    //      $array_storage_field_details                                    ,
    //      $zebra_form_field_indices_of_checkbox_type_zebra_form_fields    ,
    //      $get_post
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // RETURNS
    //      o   On SUCCESS!
    //          - - - - - -
    //          TRUE or FALSE
    //
    //      o   On FAILURE!
    //          $error_message STRING
    // -------------------------------------------------------------------------

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $selected_datasets_dmdd = array(
    //
    //          ...
    //
    //          ['array_storage_record_structure'] => array(
    //
    //              array(
    //                  'slug'          =>  'created_server_micro_datetime_UTC'      ,
    //                  'value_from'    =>  array(
    //                                          'method'    =>  'created-server-micro-datetime-utc'
    //                                          )   ,
    //                  'constraints'   =>  array(
    //                                          array(
    //                                              'method'    =>  'unix-timestamp-with-microseconds'
    //                                              )
    //                                          )
    //                  )   ,
    //
    //              ...
    //
    //              array(
    //                  'slug'          =>  'key'       ,
    //                  'value_from'    =>  array(
    //                                          'method'    =>  'unique-key'
    //                                          )   ,
    //                  'constraints'   =>  array(
    //                                          array(
    //                                              'method'    =>  'unique-key'
    //                                              )
    //                                          )
    //                  )   ,
    //
    //              array(
    //                  'slug'          =>  'pathspec'                      ,
    //                  'value_from'    =>  array(
    //                                          'method'    =>  'post'          ,
    //                                          'instance'  =>  'pathspec'
    //                                          )   ,
    //                  'constraints'   =>  array()
    //                  )   ,
    //
    //              ...
    //
    //              )   ,
    //
    //          ...
    //
    //          ['zebra_form'] => array(
    //
    //              'form_specs'    =>  array(
    //                                      'name'                      =>  'add_edit_plugin_component'     ,
    //                                      'method'                    =>  'POST'                          ,
    //                                      'action'                    =>  ''                              ,
    //                                      'attributes'                =>  array()                         ,
    //                                      'clientside_validation'     =>  TRUE
    //                                      )   ,
    //
    //              'field_specs'   =>  array(
    //
    //                  array(
    //                      'form_field_name'       =>  'pathspec'          ,
    //                      'zebra_control_type'    =>  'text'              ,
    //                      'label'                 =>  'Pathspec'          ,
    //                      'attributes'            =>  array()             ,
    //                      'rules'                 =>  array(
    //                          'required'  =>  array(
    //                                              'error'             ,   // variable to add the error message to
    //                                              'Field is required'     // error message if value doesn't validate
    //                                              )
    //                          )
    //                      )   ,
    //
    //                  array(
    //                      'form_field_name'       =>  'save_me'       ,
    //                      'zebra_control_type'    =>  'submit'        ,
    //                      'label'                 =>  NULL            ,
    //                      'attributes'            =>  array()         ,
    //                      'rules'                 =>  array()         ,
    //                      'type_specific_args'    =>  array(
    //                          'caption'   =>  'Submit'
    //                          )
    //                      )   ,
    //
    //                  )   ,
    //
    //              'focus_field_slug'  =>  'pathspec'
    //
    //              )
    //
    //          ...
    //
    //          )
    //
    // -------------------------------------------------------------------------

//pr( func_get_args() ) ;

//pr( $selected_datasets_dmdd['array_storage_record_structure'] ) ;

//pr( $selected_datasets_dmdd['zebra_forms'][ $form_slug_underscored ]['field_specs'] ) ;

//pr( $array_storage_field_details ) ;

//exit() ;

    // -------------------------------------------------------------------------

    $target_form_field_name_from_instance = NULL ;

    if (    isset( $array_storage_field_details['value_from'] )
            &&
            isset( $array_storage_field_details['value_from']['method'] )
            &&
            strtolower( $array_storage_field_details['value_from']['method'] ) === strtolower( $get_post )
            &&
            isset( $array_storage_field_details['value_from']['instance'] )
            &&
            is_string( $array_storage_field_details['value_from']['instance'] )
            &&
            trim( $array_storage_field_details['value_from']['instance'] ) !== ''
            &&
            strlen( $array_storage_field_details['value_from']['instance'] ) <= 64
            &&
            \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_stringUtils\ctype_varname( $array_storage_field_details['value_from']['instance'] )
        ) {
        $target_form_field_name_from_instance = $array_storage_field_details['value_from']['instance'] ;
    }

    // -------------------------------------------------------------------------

    $target_form_field_name_from_slug = NULL ;

    if (    isset( $array_storage_field_details['slug'] )
            &&
            is_string( $array_storage_field_details['slug'] )
            &&
            trim( $array_storage_field_details['slug'] ) !== ''
            &&
            strlen( $array_storage_field_details['slug'] ) <= 64
            &&
            \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_stringUtils\ctype_varname( $array_storage_field_details['slug'] )
        ) {
        $target_form_field_name_from_slug = $array_storage_field_details['slug'] ;
    }

    // -------------------------------------------------------------------------

    foreach ( $zebra_form_field_indices_of_checkbox_type_zebra_form_fields as $zebra_form_field_index ) {

        // ---------------------------------------------------------------------

        $zebra_form_field_details = $zebra_form_definition['field_specs'][ $zebra_form_field_index ] ;

        // ---------------------------------------------------------------------

        if (    isset( $zebra_form_field_details['form_field_name'] )
                &&
                is_string( $zebra_form_field_details['form_field_name'] )
            ) {

            // -----------------------------------------------------------------

            if (    $zebra_form_field_details['form_field_name'] === $target_form_field_name_from_instance
                    ||
                    $zebra_form_field_details['form_field_name'] === $target_form_field_name_from_slug
                ) {
                return TRUE ;
            }

            // -----------------------------------------------------------------

        }

        // ---------------------------------------------------------------------

    }

    // -------------------------------------------------------------------------

    return FALSE ;

    // -------------------------------------------------------------------------

}
*/

// =============================================================================
// is_array_storage_field_a_checkbox_type_field()
// =============================================================================

function is_array_storage_field_a_checkbox_type_field(
    $selected_datasets_dmdd                                         ,
    $zebra_form_definition                                          ,
    $dataset_slug                                                   ,
    $dataset_title                                                  ,
    $array_storage_field_details                                    ,
    $zebra_form_field_indices_of_checkbox_type_zebra_form_fields    ,
    $get_post
    ) {

    // -------------------------------------------------------------------------
    // is_array_storage_field_a_checkbox_type_field(
    //      $selected_datasets_dmdd                                         ,
    //      $zebra_form_definition                                          ,
    //      $dataset_slug                                                   ,
    //      $dataset_title                                                  ,
    //      $array_storage_field_details                                    ,
    //      $zebra_form_field_indices_of_checkbox_type_zebra_form_fields    ,
    //      $get_post
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // RETURNS
    //      o   On SUCCESS!
    //              array(
    //                  $question_checkbox_type_field BOOL          ,
    //                  $expected_checkbox_value STRING or NULL
    //                  )
    //
    //      o   On FAILURE!
    //              $error_message STRING
    // -------------------------------------------------------------------------

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $selected_datasets_dmdd = array(
    //
    //          ...
    //
    //          ['array_storage_record_structure'] => array(
    //
    //              array(
    //                  'slug'          =>  'created_server_micro_datetime_UTC'      ,
    //                  'value_from'    =>  array(
    //                                          'method'    =>  'created-server-micro-datetime-utc'
    //                                          )   ,
    //                  'constraints'   =>  array(
    //                                          array(
    //                                              'method'    =>  'unix-timestamp-with-microseconds'
    //                                              )
    //                                          )
    //                  )   ,
    //
    //              ...
    //
    //              array(
    //                  'slug'          =>  'key'       ,
    //                  'value_from'    =>  array(
    //                                          'method'    =>  'unique-key'
    //                                          )   ,
    //                  'constraints'   =>  array(
    //                                          array(
    //                                              'method'    =>  'unique-key'
    //                                              )
    //                                          )
    //                  )   ,
    //
    //              array(
    //                  'slug'          =>  'pathspec'                      ,
    //                  'value_from'    =>  array(
    //                                          'method'    =>  'post'          ,
    //                                          'instance'  =>  'pathspec'
    //                                          )   ,
    //                  'constraints'   =>  array()
    //                  )   ,
    //
    //              ...
    //
    //              )   ,
    //
    //          ...
    //
    //          ['zebra_form'] => array(
    //
    //              'form_specs'    =>  array(
    //                                      'name'                      =>  'add_edit_plugin_component'     ,
    //                                      'method'                    =>  'POST'                          ,
    //                                      'action'                    =>  ''                              ,
    //                                      'attributes'                =>  array()                         ,
    //                                      'clientside_validation'     =>  TRUE
    //                                      )   ,
    //
    //              'field_specs'   =>  array(
    //
    //                  array(
    //                      'form_field_name'       =>  'pathspec'          ,
    //                      'zebra_control_type'    =>  'text'              ,
    //                      'label'                 =>  'Pathspec'          ,
    //                      'attributes'            =>  array()             ,
    //                      'rules'                 =>  array(
    //                          'required'  =>  array(
    //                                              'error'             ,   // variable to add the error message to
    //                                              'Field is required'     // error message if value doesn't validate
    //                                              )
    //                          )
    //                      )   ,
    //
    //                  array(
    //                      'form_field_name'       =>  'save_me'       ,
    //                      'zebra_control_type'    =>  'submit'        ,
    //                      'label'                 =>  NULL            ,
    //                      'attributes'            =>  array()         ,
    //                      'rules'                 =>  array()         ,
    //                      'type_specific_args'    =>  array(
    //                          'caption'   =>  'Submit'
    //                          )
    //                      )   ,
    //
    //                  )   ,
    //
    //              'focus_field_slug'  =>  'pathspec'
    //
    //              )
    //
    //          ...
    //
    //          )
    //
    // -------------------------------------------------------------------------

//pr( func_get_args() ) ;

//pr( $selected_datasets_dmdd['array_storage_record_structure'] ) ;

//pr( $selected_datasets_dmdd['zebra_forms'][ $form_slug_underscored ]['field_specs'] ) ;

//pr( $array_storage_field_details ) ;

//exit() ;

    // -------------------------------------------------------------------------

    $ns = __NAMESPACE__ ;
    $fn = __FUNCTION__  ;

    // -------------------------------------------------------------------------

    $target_form_field_name_from_instance = NULL ;

    // -------------------------------------------------------------------------

    if (    isset( $array_storage_field_details['value_from'] )
            &&
            isset( $array_storage_field_details['value_from']['method'] )
            &&
            strtolower( $array_storage_field_details['value_from']['method'] ) === strtolower( $get_post )
            &&
            isset( $array_storage_field_details['value_from']['instance'] )
            &&
            is_string( $array_storage_field_details['value_from']['instance'] )
            &&
            trim( $array_storage_field_details['value_from']['instance'] ) !== ''
            &&
            strlen( $array_storage_field_details['value_from']['instance'] ) <= 64
            &&
            \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_stringUtils\ctype_varname( $array_storage_field_details['value_from']['instance'] )
        ) {
        $target_form_field_name_from_instance = $array_storage_field_details['value_from']['instance'] ;
    }

    // -------------------------------------------------------------------------

    $target_form_field_name_from_slug = NULL ;

    // -------------------------------------------------------------------------

    if (    isset( $array_storage_field_details['slug'] )
            &&
            is_string( $array_storage_field_details['slug'] )
            &&
            trim( $array_storage_field_details['slug'] ) !== ''
            &&
            strlen( $array_storage_field_details['slug'] ) <= 64
            &&
            \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_stringUtils\ctype_varname( $array_storage_field_details['slug'] )
        ) {
        $target_form_field_name_from_slug = $array_storage_field_details['slug'] ;
    }

    // -------------------------------------------------------------------------

    foreach ( $zebra_form_field_indices_of_checkbox_type_zebra_form_fields as $zebra_form_field_index ) {

        // ---------------------------------------------------------------------

        $zebra_form_field_details = $zebra_form_definition['field_specs'][ $zebra_form_field_index ] ;

        // ---------------------------------------------------------------------

        if (    isset( $zebra_form_field_details['form_field_name'] )
                &&
                is_string( $zebra_form_field_details['form_field_name'] )
            ) {

            // -----------------------------------------------------------------

            if (    $zebra_form_field_details['form_field_name'] === $target_form_field_name_from_instance
                    ||
                    $zebra_form_field_details['form_field_name'] === $target_form_field_name_from_slug
                ) {

                // -------------------------------------------------------------

                $expected_value = '1' ;     //  The default

                // -------------------------------------------------------------

                if (    array_key_exists( 'type_specific_args' , $zebra_form_field_details )
                        &&
                        is_array( $zebra_form_field_details['type_specific_args'] )
                        &&
                        array_key_exists( 'value' , $zebra_form_field_details['type_specific_args'] )
                    ) {

                    // ---------------------------------------------------------

                    if ( ! is_string( $zebra_form_field_details['type_specific_args']['value'] ) ) {

                        // -----------------------------------------------------

                        $safe_field_name = htmlentities( $zebra_form_field_details['form_field_name'] ) ;

                        $zebra_form_field_number = $zebra_form_field_index + 1 ;

                        return <<<EOT
PROBLEM:&nbsp; Bad "type_specific_args" + "value" (string expected)
For dataset:&nbsp; "{$dataset_title}"
and Zebra Form field# {$zebra_form_field_number}:&nbsp; "{$safe_field_name}"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

                        // -----------------------------------------------------

                    }

                    // ---------------------------------------------------------

                    $expected_value = $zebra_form_field_details['type_specific_args']['value'] ;

                    // ---------------------------------------------------------

                }

                // -------------------------------------------------------------

                return array(
                            TRUE                ,
                            $expected_value
                            ) ;

                // -------------------------------------------------------------

            }

            // -----------------------------------------------------------------

        }

        // ---------------------------------------------------------------------

    }

    // -------------------------------------------------------------------------

    return array(
                FALSE   ,
                NULL
                ) ;

    // -------------------------------------------------------------------------

}

// =============================================================================
// is_array_storage_field_a_radios_type_field()
// =============================================================================

function is_array_storage_field_a_radios_type_field(
    $selected_datasets_dmdd                                         ,
    $zebra_form_definition                                          ,
    $dataset_slug                                                   ,
    $dataset_title                                                  ,
    $array_storage_field_details                                    ,
    $zebra_form_field_indices_of_radios_type_zebra_form_fields      ,
    $get_post
    ) {

    // -------------------------------------------------------------------------
    // is_array_storage_field_a_radios_type_field(
    //      $selected_datasets_dmdd                                         ,
    //      $zebra_form_definition                                          ,
    //      $dataset_slug                                                   ,
    //      $dataset_title                                                  ,
    //      $array_storage_field_details                                    ,
    //      $zebra_form_field_indices_of_radios_type_zebra_form_fields      ,
    //      $get_post
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // RETURNS
    //      o   On SUCCESS!
    //          - - - - - -
    //          TRUE or FALSE
    //
    //      o   On FAILURE!
    //          $error_message STRING
    // -------------------------------------------------------------------------

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $selected_datasets_dmdd = array(
    //
    //          ...
    //
    //          ['array_storage_record_structure'] => array(
    //
    //              array(
    //                  'slug'          =>  'created_server_micro_datetime_UTC'      ,
    //                  'value_from'    =>  array(
    //                                          'method'    =>  'created-server-micro-datetime-utc'
    //                                          )   ,
    //                  'constraints'   =>  array(
    //                                          array(
    //                                              'method'    =>  'unix-timestamp-with-microseconds'
    //                                              )
    //                                          )
    //                  )   ,
    //
    //              ...
    //
    //              array(
    //                  'slug'          =>  'key'       ,
    //                  'value_from'    =>  array(
    //                                          'method'    =>  'unique-key'
    //                                          )   ,
    //                  'constraints'   =>  array(
    //                                          array(
    //                                              'method'    =>  'unique-key'
    //                                              )
    //                                          )
    //                  )   ,
    //
    //              array(
    //                  'slug'          =>  'pathspec'                      ,
    //                  'value_from'    =>  array(
    //                                          'method'    =>  'post'          ,
    //                                          'instance'  =>  'pathspec'
    //                                          )   ,
    //                  'constraints'   =>  array()
    //                  )   ,
    //
    //              ...
    //
    //              )   ,
    //
    //          ...
    //
    //          ['zebra_form'] => array(
    //
    //              'form_specs'    =>  array(
    //                                      'name'                      =>  'add_edit_plugin_component'     ,
    //                                      'method'                    =>  'POST'                          ,
    //                                      'action'                    =>  ''                              ,
    //                                      'attributes'                =>  array()                         ,
    //                                      'clientside_validation'     =>  TRUE
    //                                      )   ,
    //
    //              'field_specs'   =>  array(
    //
    //                  array(
    //                      'form_field_name'       =>  'pathspec'          ,
    //                      'zebra_control_type'    =>  'text'              ,
    //                      'label'                 =>  'Pathspec'          ,
    //                      'attributes'            =>  array()             ,
    //                      'rules'                 =>  array(
    //                          'required'  =>  array(
    //                                              'error'             ,   // variable to add the error message to
    //                                              'Field is required'     // error message if value doesn't validate
    //                                              )
    //                          )
    //                      )   ,
    //
    //                  array(
    //                      'form_field_name'       =>  'save_me'       ,
    //                      'zebra_control_type'    =>  'submit'        ,
    //                      'label'                 =>  NULL            ,
    //                      'attributes'            =>  array()         ,
    //                      'rules'                 =>  array()         ,
    //                      'type_specific_args'    =>  array(
    //                          'caption'   =>  'Submit'
    //                          )
    //                      )   ,
    //
    //                  )   ,
    //
    //              'focus_field_slug'  =>  'pathspec'
    //
    //              )
    //
    //          ...
    //
    //          )
    //
    // -------------------------------------------------------------------------

//pr( func_get_args() ) ;

//pr( $selected_datasets_dmdd['array_storage_record_structure'] ) ;

//pr( $selected_datasets_dmdd['zebra_form']['field_specs'] ) ;

//pr( $array_storage_field_details ) ;

//exit() ;

    // -------------------------------------------------------------------------

    $target_form_field_name_from_instance = NULL ;

    if (    isset( $array_storage_field_details['value_from'] )
            &&
            isset( $array_storage_field_details['value_from']['method'] )
            &&
            strtolower( $array_storage_field_details['value_from']['method'] ) === strtolower( $get_post )
            &&
            isset( $array_storage_field_details['value_from']['instance'] )
            &&
            is_string( $array_storage_field_details['value_from']['instance'] )
            &&
            trim( $array_storage_field_details['value_from']['instance'] ) !== ''
            &&
            strlen( $array_storage_field_details['value_from']['instance'] ) <= 64
            &&
            \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_stringUtils\ctype_varname( $array_storage_field_details['value_from']['instance'] )
        ) {
        $target_form_field_name_from_instance = $array_storage_field_details['value_from']['instance'] ;
    }

    // -------------------------------------------------------------------------

    $target_form_field_name_from_slug = NULL ;

    if (    isset( $array_storage_field_details['slug'] )
            &&
            is_string( $array_storage_field_details['slug'] )
            &&
            trim( $array_storage_field_details['slug'] ) !== ''
            &&
            strlen( $array_storage_field_details['slug'] ) <= 64
            &&
            \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_stringUtils\ctype_varname( $array_storage_field_details['slug'] )
        ) {
        $target_form_field_name_from_slug = $array_storage_field_details['slug'] ;
    }

    // -------------------------------------------------------------------------

    foreach ( $zebra_form_field_indices_of_radios_type_zebra_form_fields as $zebra_form_field_index ) {

        // ---------------------------------------------------------------------

        $zebra_form_field_details = $zebra_form_definition['field_specs'][ $zebra_form_field_index ] ;

        // ---------------------------------------------------------------------

        if (    isset( $zebra_form_field_details['form_field_name'] )
                &&
                is_string( $zebra_form_field_details['form_field_name'] )
            ) {

            // -----------------------------------------------------------------

            if (    $zebra_form_field_details['form_field_name'] === $target_form_field_name_from_instance
                    ||
                    $zebra_form_field_details['form_field_name'] === $target_form_field_name_from_slug
                ) {
                return TRUE ;
            }

            // -----------------------------------------------------------------

        }

        // ---------------------------------------------------------------------

    }

    // -------------------------------------------------------------------------

    return FALSE ;

    // -------------------------------------------------------------------------

}

// =============================================================================
// That's that!
// =============================================================================

