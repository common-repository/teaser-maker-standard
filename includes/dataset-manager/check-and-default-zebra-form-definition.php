<?php

// *****************************************************************************
// DATASET-MANAGER / CHECK-AND-DEFAULT-ZEBRA-FORM-DEFINITION.PHP
// (C) 2013 Peter Newman. All Rights Reserved.
// *****************************************************************************

    namespace greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager ;

// =============================================================================
// check_and_default_zebra_form_definition()
// =============================================================================

function check_and_default_zebra_form_definition(
    $caller_app_slash_plugins_global_namespace      ,
    $dataset_manager_home_page_title                ,
    $caller_apps_includes_dir                       ,
    &$all_application_dataset_definitions           ,
    $dataset_slug                                   ,
    &$selected_datasets_dmdd                        ,
    $dataset_title                                  ,
    $dataset_records                                ,
    $record_indices_by_key                          ,
    $question_adding                                ,
    $form_slug_underscored
    ) {

    // -------------------------------------------------------------------------
    // check_and_default_zebra_form_definition(
    //      $caller_app_slash_plugins_global_namespace      ,
    //      $dataset_manager_home_page_title                ,
    //      $caller_apps_includes_dir                       ,
    //      &$all_application_dataset_definitions           ,
    //      $dataset_slug                                   ,
    //      &$selected_datasets_dmdd                        ,
    //      $dataset_title                                  ,
    //      $dataset_records                                ,
    //      $record_indices_by_key                          ,
    //      $question_adding                                ,
    //      $form_slug_underscored
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // Checks:-
    //      $selected_datasets_dmdd['zebra_forms'][ $form_slug_underscored ]
    //
    // defaulting it and it's members as necessary.
    //
    // RETURNS:-
    //      On SUCCESS!
    //      - - - - - -
    //      TRUE
    //      And the caller's:-
    //          $all_application_dataset_definitions, and;
    //          $selected_datasets_dmdd
    //      have been updated as follows:-
    //          o   ...['zebra_forms']['checked_defaulted_ok'] = TRUE
    //          o   With the remaining "zebra_forms" elements defaulted as
    //              required
    //
    //      On FAILURE!
    //      - - - - - -
    //      $error_message STRING
    // -------------------------------------------------------------------------

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $selected_datasets_dmdd['zebra_forms'][ $form_slug_underscored ] = array(
    //
    //          'form_specs'    =>  array(
    //                                  'name'                      =>  'add_edit_category'         ,
    //                                  'method'                    =>  'POST'                      ,
    //                                  'action'                    =>  ''                          ,
    //                                  'attributes'                =>  array()                     ,
    //                                  'clientside_validation'     =>  TRUE
    //                                  )   ,
    //
    //          'field_specs'   =>  array(
    //
    //              // -----------------------------------------------------------------------------
    //              //  'value_from'    OPTIONAL
    //              //
    //              //      This tells us where the value displayed in the field comes from,
    //              //      whenever the field is displayed (on the form).
    //              //
    //              //      NOTE that:-
    //              //
    //              //      1.  You have to specify "value_from" separately, for the "add" and
    //              //          "edit" versions of the form.
    //              //
    //              //      2.  The following Zebra Form control types DON'T have values to be
    //              //          set:-
    //              //              o   "submit"
    //              //              o   "button"
    //              //
    //              //          So there's NO need to specify "value_from" for fields with these
    //              //          control types.  And if you do specify "value_from", it will be
    //              //          IGNORED.
    //              //
    //              //      o   If specified, "value_from" should be like:-
    //              //
    //              //              array(
    //              //                  'add'   =>  array(
    //              //                                  'method'    =>  'array_storage_field_slug'
    //              //                                  'args'      =>  '<array storage field slug to get value from>'
    //              //                                                  //  (NULL or not specified means use "form_field_name")
    //              //                              -OR-
    //              //                                  'method'    =>  'literal' (The DEFAULT "add" value is the empty string)
    //              //                                  'args'      =>  <some PHP (scalar) value>
    //              //                              -OR-
    //              //                                  'method'    =>  'function'
    //              //                                  'args'      =>  array(
    //              //                                                      'function_name' =>  <function name, including namespace prefix if necessary>
    //              //                                                      'extra_args'    =>  <the extra args (if any), required by this function>
    //              //                                  )   ,
    //              //                  'edit'  =>  array(
    //              //                                  'method'    =>  'array_storage_field_slug' (This is the DEFAULT)
    //              //                                  'args'      =>  '<array storage field slug to get value from>'
    //              //                                                  //  (NULL or not specified means use "form_field_name")
    //              //                              -OR-
    //              //                                  'method'    =>  'literal'
    //              //                                  'args'      =>  <some PHP (scalar) value>
    //              //                              -OR-
    //              //                                  'method'    =>  'function'
    //              //                                  'args'      =>  array(
    //              //                                                      'function_name' =>  <function name, including namespace prefix if necessary>
    //              //                                                      'extra_args'    =>  <the extra args (if any), required by this function>
    //              //                                  )
    //              //                  )
    //              //
    //              //      o   If "value_from_from" - or any of it's components:-
    //              //              a)  ISN'T specified,
    //              //              b)  is NULL, or;
    //              //              c)  is the empty array(),
    //              //
    //              //          then things DEFAULT as follows:-
    //              //
    //              //              array(
    //              //                  'add'   =>  array(
    //              //                                  'method'    =>  'literal'   ,
    //              //                                  'args'      =>  ''
    //              //                                  )   ,
    //              //                  'edit'  =>  array(
    //              //                                  'method'    =>  'array-storage-field-slug'      ,
    //              //                                  'args'      =>  <field's "form_field_name">
    //              //                                  )
    //              //                  )
    //              //
    //              // -----------------------------------------------------------------------------
    //
    //              // -----------------------------------------------------------------------------
    //              //      'constraints'       OPTIONAL
    //              //
    //              //          NOTE!
    //              //          =====
    //              //          These are the "contraints" that apply when SAVING a submitted
    //              //          Zebra Form.
    //              //
    //              //          If specified, must be an ARRAY containing zero or more sub-arrays.
    //              //          Eg:-
    //              //
    //              //              array(
    //              //
    //              //                  array(
    //              //                      'method'    =>  'unique'
    //              //                      //  "instance" and "args", if specified, are ignored
    //              //                      )
    //              //
    //              //                  array(
    //              //                      'method'    =>  'unique-case-insensitively'
    //              //                      //  "instance" and "args", if specified, are ignored
    //              //                      )
    //              //
    //              //                  array(
    //              //                      'method'    =>  'unique-key'
    //              //                      //  "instance" and "args", if specified, are ignored
    //              //                      )
    //              //
    //              //                  array(
    //              //                      'method'    =>  'in-array-strict'
    //              //                      'instance'  =>  array(...)
    //              //                      //  "args", if specified, is ignored
    //              //                      )
    //              //
    //              //                  array(
    //              //                      'method'    =>  'in-array-not-strict'
    //              //                      'instance'  =>  array(...)
    //              //                      //  "args", if specified, is ignored
    //              //                      )
    //              //
    //              //                  array(
    //              //                      'method'    =>  'function'
    //              //                      'instance'  =>  '<function name, including namespace prefix if necessary>'
    //              //                      'args'      =>  (optional) If specified, should be either
    //              //                                      NULL or a possibly empty array.  NULL and
    //              //                                      not specified are converted to the empty
    //              //                                      array.
    //              //                      )
    //              //
    //              //                  )
    //              //
    //              //          If NOT specified, defaults to the empty array.
    //              // -----------------------------------------------------------------------------
    //
    //              array(
    //                  'form_field_name'       =>  'parent_key'                ,
    //                  'zebra_control_type'    =>  'select'                    ,
    //                  'label'                 =>  'Project'                   ,
    //                  'value_from'            =>  NULL                        ,
    //                  'attributes'            =>  array()                     ,
    //                  'rules'                 =>  array(
    //                      'required'  =>  array(
    //                                          'error'             ,   // variable to add the error message to
    //                                          'Field is required'     // error message if value doesn't validate
    //                                          )
    //                      )   ,
    //                  'type_specific_args'    =>  array(
    //                      'options_getter_function'   =>  array(
    //                          'function_name' =>  '\\researchAssistant_byFernTec_datasetManagerDatasetDefs_categories\\get_options_for_project_selector'  ,
    //                          'extra_args'    =>  NULL
    //                          )
    //                      )   ,
    //                  'constraints'           =>  array(
    //                                                  array(
    //                                                      'type'  =>  'unique-key'
    //                                                      )
    //                                                  )
    //                  )   ,
    //
    //              array(
    //                  'form_field_name'       =>  'parent_is'                 ,
    //                  'zebra_control_type'    =>  'hidden'                    ,
    //  //              'label'                 =>  NULL                        ,
    //                  'value_from'            =>  array(
    //                                                  'add'   =>  array(
    //                                                                  'method'    =>  'literal'   ,
    //                                                                  'args'      =>  'project'
    //                                                                  )   ,
    //                                                  'edit'  =>  array(
    //                                                                  'method'    =>  'array-storage-field-slug'  ,
    //                                                                  'args'      =>  NULL
    //                                                                  )
    //                                                  )   ,
    //                  'attributes'            =>  array()                     ,
    //                  'rules'                 =>  array(
    //                      'required'  =>  array(
    //                                          'error'             ,   // variable to add the error message to
    //                                          'Field is required'     // error message if value doesn't validate
    //                                          )
    //                      )   ,
    //                  'constraints'           =>  array(
    //                                                  array(
    //                                                      'type'  =>  'in-array-strict'      ,
    //                                                      'args'  =>  array( 'project' , 'category' )
    //                                                      )
    //                                                  )
    //                  )   ,
    //
    //              array(
    //                  'form_field_name'       =>  'title'             ,
    //                  'zebra_control_type'    =>  'text'              ,
    //                  'label'                 =>  'Title'             ,
    //                  'attributes'            =>  array()             ,
    //                  'rules'                 =>  array(
    //                      'required'  =>  array(
    //                                          'error'             ,   // variable to add the error message to
    //                                          'Field is required'     // error message if value doesn't validate
    //                                          )
    //                      )   ,
    //                  'constraints'           =>  array(
    //                                                  array(
    //                                                      'type'  =>  'unique-case-insensitively'
    //                                                      )
    //                                                  )   ,
    //                  'type_specific_args'    =>  array()
    //                  )   ,
    //
    //              array(
    //                  'form_field_name'       =>  'notes_slash_comments'      ,
    //                  'zebra_control_type'    =>  'textarea'                  ,
    //                  'label'                 =>  'Notes/Comments'            ,
    //                  'attributes'            =>  array()                     ,
    //                  'rules'                 =>  array()                     ,
    //                  'type_specific_args'    =>  array()
    //                  )   ,
    //
    //              array(
    //                  'form_field_name'       =>  'save_me'           ,
    //                  'zebra_control_type'    =>  'submit'            ,
    //                  'label'                 =>  NULL                ,
    //                  'attributes'            =>  array()             ,
    //                  'rules'                 =>  array()             ,
    //                  'type_specific_args'    =>  array(
    //                      'caption'       =>  'Submit'
    //                      )
    //                  )   ,
    //
    //              array(
    //                  'form_field_name'       =>  'cancel'                    ,
    //                  'zebra_control_type'    =>  'button'                    ,
    //                  'label'                 =>  NULL                        ,
    //                  'attributes'            =>  array(
    //                                                  'onclick'   =>  $onclick
    //                                                  )   ,
    //                  'rules'                 =>  array()                     ,
    //                  'type_specific_args'    =>  array(
    //                      'caption'       =>  'Cancel'    ,
    //                      'type'          =>  'button'
    //                      )
    //                  )
    //
    //              )   ,
    //
    //          'focus_field_slug'  =>  TRUE
    //
    //          ) ;
    //
    // -------------------------------------------------------------------------

//pr( $selected_datasets_dmdd['zebra_forms'] ) ;

    // =========================================================================
    // Init.
    // =========================================================================

    $ns = __NAMESPACE__ ;
    $fn = __FUNCTION__ ;

    // -------------------------------------------------------------------------

    $safe_form_slug_underscored = htmlentities( $form_slug_underscored ) ;

    // =========================================================================
    // ISSET ?
    // =========================================================================

    if ( ! array_key_exists( 'zebra_forms' , $selected_datasets_dmdd ) ) {

        return <<<EOT
PROBLEM:&nbsp; No "zebra_forms"
For dataset:&nbsp; "{$dataset_title}"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

    }

    // -------------------------------------------------------------------------

    if ( ! is_array( $selected_datasets_dmdd['zebra_forms'] ) ) {

        return <<<EOT
PROBLEM:&nbsp; Bad "zebra_forms" (array expected)
For dataset:&nbsp; "{$dataset_title}"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

    }

    // -------------------------------------------------------------------------

    if ( ! array_key_exists( $form_slug_underscored , $selected_datasets_dmdd['zebra_forms'] ) ) {

        return <<<EOT
PROBLEM:&nbsp; Form not found (there's no form called "{$safe_form_slug_underscored}", in "zebra_forms")
For dataset:&nbsp; "{$dataset_title}"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

    }

    // =========================================================================
    // IS_ARRAY ?
    // =========================================================================

    if ( ! is_array( $selected_datasets_dmdd['zebra_forms'][ $form_slug_underscored ] ) ) {

        return <<<EOT
PROBLEM:&nbsp; Bad form definition (not an array)
For form:&nbsp; "{$safe_form_slug_underscored}"
From dataset:&nbsp; "{$dataset_title}"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

    }


    // =========================================================================
    // ALREADY CHECKED AND DEFAULTED OK ?
    // =========================================================================

    if (    isset( $selected_datasets_dmdd['zebra_forms'][ $form_slug_underscored ]['checked_defaulted_ok'] )
            &&
            $selected_datasets_dmdd['zebra_forms'][ $form_slug_underscored ]['checked_defaulted_ok'] === TRUE
        ) {
        return TRUE ;
    }

    // =========================================================================
    // Init. the defaulted version of the form definition...
    // =========================================================================

    $defaulted_zebra_form = $selected_datasets_dmdd['zebra_forms'][ $form_slug_underscored ] ;

    // =========================================================================
    // CHECK/DEFAULT the "FORM_SPECS"...
    // =========================================================================

    if ( ! array_key_exists( 'form_specs' , $defaulted_zebra_form ) ) {

        return <<<EOT
PROBLEM:&nbsp; Bad form definition (no "form_specs")
For form:&nbsp; "{$safe_form_slug_underscored}"
From dataset:&nbsp; "{$dataset_title}"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

    }

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $defaulted_zebra_form['form_specs'] = Array(
    //          [name]                  => add_edit_project
    //          [method]                => POST
    //          [action]                =>
    //          [attributes]            => Array()
    //          [clientside_validation] => 1
    //          )
    //
    // -------------------------------------------------------------------------

    $form_specs = $defaulted_zebra_form['form_specs'] ;
        //  To make the following code a little simpler...

    // -------------------------------------------------------------------------
    // name ?
    // -------------------------------------------------------------------------

    if ( isset( $form_specs['name'] ) ) {

        // ---------------------------------------------------------------------

        if (    ! is_string( $form_specs['name'] )
                ||
                trim( $form_specs['name'] ) === ''
                ||
                ! \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_stringUtils\ctype_alphanumeric_underscore_dash( $form_specs['name'] )
                ||
                strlen( $form_specs['name'] ) > 64
            ) {

            return <<<EOT
PROBLEM: Bad "zebra_forms" + "{$safe_form_slug_underscored}" + "form_specs" + "name" (1 to 64 character alphanumeric, underscore dash type string expected)
For dataset:&nbsp; "{$dataset_title}"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        }

        // ---------------------------------------------------------------------

    } else {

        $defaulted_zebra_form['form_specs']['name'] =
//          'standard_dataset_manager_add_edit_record'
            $safe_form_slug_underscored
            ;

    }

    // -------------------------------------------------------------------------
    // method ?
    // -------------------------------------------------------------------------

    if ( isset( $form_specs['method'] ) ) {

        // ---------------------------------------------------------------------

        if (    ! is_string( $form_specs['method'] )
                ||
                ! in_array( strtoupper( $form_specs['method'] ) , array( 'POST' , 'GET' ) , TRUE )
            ) {

            return <<<EOT
PROBLEM: Bad "zebra_forms" + "{$safe_form_slug_underscored}" + "form_specs" + "method" (GET or POST expected - any case)
For dataset:&nbsp; "{$dataset_title}"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        }

        // ---------------------------------------------------------------------

    } else {

        $defaulted_zebra_form['form_specs']['method'] = 'POST' ;

    }

    // -------------------------------------------------------------------------
    // action ?
    // -------------------------------------------------------------------------

    if ( isset( $form_specs['action'] ) ) {

        // ----------------------------------------------------------------------

        if (    ! is_string( $form_specs['action'] )
                ||
                trim( $form_specs['action'] ) !== $form_specs['action']
            ) {

            return <<<EOT
PROBLEM: Bad "zebra_forms" + "{$safe_form_slug_underscored}" + "form_specs" + "action" (empty or non-empty string expected - with NO leading or trailing white space)
For dataset:&nbsp; "{$dataset_title}"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        }

        // ----------------------------------------------------------------------

    } else {

        $defaulted_zebra_form['form_specs']['action'] = '' ;

    }

    // -------------------------------------------------------------------------
    // attributes ?
    // -------------------------------------------------------------------------

    if ( isset( $form_specs['attributes'] ) ) {

        // ---------------------------------------------------------------------

        if ( $form_specs['attributes'] === NULL ) {

            $defaulted_zebra_form['form_specs']['attributes'] = array() ;

        } elseif ( ! is_array( $form_specs['attributes'] ) ) {

            return <<<EOT
PROBLEM: Bad "zebra_forms" + "{$safe_form_slug_underscored}" + "form_specs" + "attributes" (array expected)
For dataset:&nbsp; "{$dataset_title}"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        }

        // ---------------------------------------------------------------------

    } else {

        $defaulted_zebra_form['form_specs']['attributes'] = array() ;

    }

    // -------------------------------------------------------------------------
    // attributes + target
    // -------------------------------------------------------------------------

    if ( isset( $form_specs['attributes']['target'] ) ) {

        return <<<EOT
PROBLEM: Bad "zebra_forms" + "{$safe_form_slug_underscored}" + "form_specs" + "attributes" ("target" already defined)
For dataset:&nbsp; "{$dataset_title}"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

    } else {

        $defaulted_zebra_form['form_specs']['attributes']['target'] = '_parent' ;
            //  This is needed because the form is displayed in an IFRAME.
            //
            //  So when it's submitted:-
            //      target="_parent"
            //
            //  forces the response to be displayed in the page that contains
            //  the IFRAME (which is what we want).

    }

    // =========================================================================
    // Get the ARRAY STORAGE FIELD SLUGS...
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
    //          o   ...['array_storage_record_structure']['checked_defaulted_ok'] = TRUE
    //          o   With the remaining "array_storage_record_structure"
    //              elements defaulted as required
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
        return $result ;
    }

    // -------------------------------------------------------------------------

    $array_storage_field_slugs = array() ;

    // -------------------------------------------------------------------------

    foreach ( $selected_datasets_dmdd['array_storage_record_structure'] as $this_index => $this_field ) {
        if ( $this_index !== 'checked_defaulted_ok' ) {
            $array_storage_field_slugs[] = $this_field['slug'] ;
        }
    }

    // =========================================================================
    // "RAW MODE" ?
    // =========================================================================

    if (    function_exists( '\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\is_raw_mode_for_forms' )
            &&
            \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\is_raw_mode_for_forms() === TRUE
        ) {

        $defaulted_zebra_form['auto_create_field_specs'] = array(
            'include'           =>  'all'       ,
            'exclude'           =>  'none'      ,
            'submit_button'     =>  TRUE        ,
            'cancel_button'     =>  TRUE
            ) ;

        $defaulted_zebra_form['focus_field_slug'] = $array_storage_field_slugs[0] ;

    }

    // =========================================================================
    // AUTO-CREATE the FIELD SPECS ?
    // =========================================================================

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $defaulted_zebra_form['auto_create_field_specs'] = array(
    //          'include'           =>  array()     ,
    //          'exclude'           =>  array()     ,
    //          'submit_button'     =>  TRUE        ,
    //          'cancel_button'     =>  TRUE
    //          )
    //
    // -------------------------------------------------------------------------

    if (    array_key_exists( 'auto_create_field_specs' , $defaulted_zebra_form )
            &&
            is_array( $defaulted_zebra_form['auto_create_field_specs'] )
        ) {

        // -------------------------------------------------------------------------
        // auto_create_field_specs(
        //      $defaulted_zebra_form           ,
        //      $array_storage_field_slugs      ,
        //      $dataset_title                  ,
        //      $safe_form_slug_underscored
        //      )
        // - - - - - - - - - - - - - - - - - - -
        // RETURNS
        //      o   On SUCCESS!
        //              $auto_created_field_specs ARRAY
        //
        //      o   On FAILURE!
        //              $error_message STRING
        // -------------------------------------------------------------------------

        $auto_created_field_specs =
            auto_create_field_specs(
                $defaulted_zebra_form           ,
                $array_storage_field_slugs      ,
                $dataset_title                  ,
                $safe_form_slug_underscored
                ) ;

        // ---------------------------------------------------------------------

        if ( is_string( $auto_created_field_specs ) ) {
            return $auto_created_field_specs ;
        }

        // ---------------------------------------------------------------------

        $defaulted_zebra_form['field_specs'] = $auto_created_field_specs ;

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // CHECK/DEFAULT the "FIELD_SPECS"...
    // =========================================================================

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $selected_datasets_dmdd['zebra_forms'][ $form_slug_underscored ]['field_specs'] = array(
    //
    //          // -----------------------------------------------------------------------------
    //          //  'value_from'    OPTIONAL
    //          //
    //          //      This tells us where the value displayed in the field comes from,
    //          //      whenever the field is displayed (on the form).
    //          //
    //          //      NOTE that:-
    //          //
    //          //      1.  You have to specify "value_from" separately, for the "add" and
    //          //          "edit" versions of the form.
    //          //
    //          //      2.  The following Zebra Form control types DON'T have values to be
    //          //          set:-
    //          //              o   "submit"
    //          //              o   "button"
    //          //
    //          //          So there's NO need to specify "value_from" for fields with these
    //          //          control types.  And if you do specify "value_from", it will be
    //          //          IGNORED.
    //          //
    //          //      o   If specified, "value_from" should be like:-
    //          //
    //          //              array(
    //          //                  'add'   =>  array(
    //          //                                  'method'    =>  'array_storage_field_slug'
    //          //                                  'args'      =>  '<array storage field slug to get value from>'
    //          //                                                  //  (NULL or not specified means use "form_field_name")
    //          //                              -OR-
    //          //                                  'method'    =>  'literal' (The DEFAULT "add" value is the empty string)
    //          //                                  'args'      =>  <some PHP (scalar) value>
    //          //                              -OR-
    //          //                                  'method'    =>  'function'
    //          //                                  'args'      =>  array(
    //          //                                                      'function_name' =>  <function name, including namespace prefix if necessary>
    //          //                                                      'extra_args'    =>  <the extra args (if any), required by this function>
    //          //                                  )   ,
    //          //                  'edit'  =>  array(
    //          //                                  'method'    =>  'array_storage_field_slug' (This is the DEFAULT)
    //          //                                  'args'      =>  '<array storage field slug to get value from>'
    //          //                                                  //  (NULL or not specified means use "form_field_name")
    //          //                              -OR-
    //          //                                  'method'    =>  'literal'
    //          //                                  'args'      =>  <some PHP (scalar) value>
    //          //                              -OR-
    //          //                                  'method'    =>  'function'
    //          //                                  'args'      =>  array(
    //          //                                                      'function_name' =>  <function name, including namespace prefix if necessary>
    //          //                                                      'extra_args'    =>  <the extra args (if any), required by this function>
    //          //                                  )
    //          //                  )
    //          //
    //          //      o   If "value_from_from" - or any of it's components:-
    //          //              a)  ISN'T specified,
    //          //              b)  is NULL, or;
    //          //              c)  is the empty array(),
    //          //
    //          //          then things DEFAULT as follows:-
    //          //
    //          //              array(
    //          //                  'add'   =>  array(
    //          //                                  'method'    =>  'literal'   ,
    //          //                                  'args'      =>  ''
    //          //                                  )   ,
    //          //                  'edit'  =>  array(
    //          //                                  'method'    =>  'array-storage-field-slug'      ,
    //          //                                  'args'      =>  <field's "form_field_name">
    //          //                                  )
    //          //                  )
    //          //
    //          // -----------------------------------------------------------------------------
    //
    //          // -----------------------------------------------------------------------------
    //          //      'constraints'       OPTIONAL
    //          //
    //          //          NOTE!
    //          //          =====
    //          //          These are the "contraints" that apply when SAVING a submitted
    //          //          Zebra Form.
    //          //
    //          //          If specified, must be an ARRAY containing zero or more sub-arrays.
    //          //          Eg:-
    //          //
    //          //              array(
    //          //
    //          //                  array(
    //          //                      'method'    =>  'unique'
    //          //                      //  "instance" and "args", if specified, are ignored
    //          //                      )
    //          //
    //          //                  array(
    //          //                      'method'    =>  'unique-case-insensitively'
    //          //                      //  "instance" and "args", if specified, are ignored
    //          //                      )
    //          //
    //          //                  array(
    //          //                      'method'    =>  'unique-key'
    //          //                      //  "instance" and "args", if specified, are ignored
    //          //                      )
    //          //
    //          //                  array(
    //          //                      'method'    =>  'in-array-strict'
    //          //                      'instance'  =>  array(...)
    //          //                      //  "args", if specified, is ignored
    //          //                      )
    //          //
    //          //                  array(
    //          //                      'method'    =>  'in-array-not-strict'
    //          //                      'instance'  =>  array(...)
    //          //                      //  "args", if specified, is ignored
    //          //                      )
    //          //
    //          //                  array(
    //          //                      'method'    =>  'function'
    //          //                      'instance'  =>  '<function name, including namespace prefix if necessary>'
    //          //                      'args'      =>  (optional) If specified, should be either
    //          //                                      NULL or a possibly empty array.  NULL and
    //          //                                      not specified are converted to the empty
    //          //                                      array.
    //          //                      )
    //          //
    //          //                  )
    //          //
    //          //          If NOT specified, defaults to the empty array.
    //          // -----------------------------------------------------------------------------
    //
    //          array(
    //              'form_field_name'       =>  'parent_key'                ,
    //              'zebra_control_type'    =>  'select'                    ,
    //              'label'                 =>  'Project'                   ,
    //              'value_from'            =>  NULL                        ,
    //              'attributes'            =>  array()                     ,
    //              'rules'                 =>  array(
    //                  'required'  =>  array(
    //                                      'error'             ,   // variable to add the error message to
    //                                      'Field is required'     // error message if value doesn't validate
    //                                      )
    //                  )   ,
    //              'type_specific_args'    =>  array(
    //                  'options_getter_function'   =>  array(
    //                      'function_name' =>  '\\researchAssistant_byFernTec_datasetManagerDatasetDefs_categories\\get_options_for_project_selector'  ,
    //                      'extra_args'    =>  NULL
    //                      )
    //                  )   ,
    //              'constraints'           =>  array(
    //                                              array(
    //                                                  'type'  =>  'unique-key'
    //                                                  )
    //                                              )
    //              )   ,
    //
    //          array(
    //              'form_field_name'       =>  'parent_is'                 ,
    //              'zebra_control_type'    =>  'hidden'                    ,
    //  //          'label'                 =>  NULL                        ,
    //              'value_from'            =>  array(
    //                                              'add'   =>  array(
    //                                                              'method'    =>  'literal'   ,
    //                                                              'args'      =>  'project'
    //                                                              )   ,
    //                                              'edit'  =>  array(
    //                                                              'method'    =>  'array-storage-field-slug'  ,
    //                                                              'args'      =>  NULL
    //                                                              )
    //                                              )   ,
    //              'attributes'            =>  array()                     ,
    //              'rules'                 =>  array(
    //                  'required'  =>  array(
    //                                      'error'             ,   // variable to add the error message to
    //                                      'Field is required'     // error message if value doesn't validate
    //                                      )
    //                  )   ,
    //              'constraints'           =>  array(
    //                                              array(
    //                                                  'type'  =>  'in-array-strict'      ,
    //                                                  'args'  =>  array( 'project' , 'category' )
    //                                                  )
    //                                              )
    //              )   ,
    //
    //          array(
    //              'form_field_name'       =>  'title'             ,
    //              'zebra_control_type'    =>  'text'              ,
    //              'label'                 =>  'Title'             ,
    //              'attributes'            =>  array()             ,
    //              'rules'                 =>  array(
    //                  'required'  =>  array(
    //                                      'error'             ,   // variable to add the error message to
    //                                      'Field is required'     // error message if value doesn't validate
    //                                      )
    //                  )   ,
    //              'constraints'           =>  array(
    //                                              array(
    //                                                  'type'  =>  'unique-case-insensitively'
    //                                                  )
    //                                              )   ,
    //              'type_specific_args'    =>  array()
    //              )   ,
    //
    //          array(
    //              'form_field_name'       =>  'notes_slash_comments'      ,
    //              'zebra_control_type'    =>  'textarea'                  ,
    //              'label'                 =>  'Notes/Comments'            ,
    //              'attributes'            =>  array()                     ,
    //              'rules'                 =>  array()                     ,
    //              'type_specific_args'    =>  array()
    //              )   ,
    //
    //          array(
    //              'form_field_name'       =>  'save_me'           ,
    //              'zebra_control_type'    =>  'submit'            ,
    //              'label'                 =>  NULL                ,
    //              'attributes'            =>  array()             ,
    //              'rules'                 =>  array()             ,
    //              'type_specific_args'    =>  array(
    //                  'caption'       =>  'Submit'
    //                  )
    //              )   ,
    //
    //          array(
    //              'form_field_name'       =>  'cancel'                    ,
    //              'zebra_control_type'    =>  'button'                    ,
    //              'label'                 =>  NULL                        ,
    //              'attributes'            =>  array(
    //                                              'onclick'   =>  $onclick
    //                                              )   ,
    //              'rules'                 =>  array()                     ,
    //              'type_specific_args'    =>  array(
    //                  'caption'       =>  'Cancel'    ,
    //                  'type'          =>  'button'
    //                  )
    //              )
    //
    //          ) ;
    //
    // -------------------------------------------------------------------------

    if ( ! array_key_exists( 'field_specs' , $defaulted_zebra_form ) ) {

        return <<<EOT
PROBLEM:&nbsp; Bad Zebra form definition (no "field_specs")
For dataset:&nbsp; "{$dataset_title}"
and form:&nbsp; "{$safe_form_slug_underscored}"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

    }

    // -------------------------------------------------------------------------

    if ( ! is_array( $defaulted_zebra_form['field_specs'] ) ) {

        return <<<EOT
PROBLEM: Bad "zebra_forms" + "{$safe_form_slug_underscored}" + "field_specs" (array expected)
For dataset:&nbsp; "{$dataset_title}"
and form:&nbsp; "{$safe_form_slug_underscored}"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

    }

    // -------------------------------------------------------------------------

    $form_field_names_found = array() ;

    // -------------------------------------------------------------------------

    foreach ( $defaulted_zebra_form['field_specs'] as $field_index => $field_details ) {

        // =====================================================================
        // Field ERROR CHECKING...
        // =====================================================================

        $field_number = $field_index + 1 ;

        // ---------------------------------------------------------------------
        // field details ?
        // ---------------------------------------------------------------------

        if ( ! is_array( $field_details ) ) {

            return <<<EOT
PROBLEM: Bad "zebra_forms" + "{$safe_form_slug_underscored}" + "field_specs" - for field# {$field_number} (not an array)
For dataset:&nbsp; "{$dataset_title}"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        }

        // ---------------------------------------------------------------------
        // Variable to save the defaulted field details in...
        // ---------------------------------------------------------------------

        $defaulted_field_details = $field_details ;

        // ---------------------------------------------------------------------
        // form_field_name ? (required)
        // ---------------------------------------------------------------------

        if ( ! isset( $field_details['form_field_name'] ) ) {

            return <<<EOT
PROBLEM: Bad "zebra_forms" + "{$safe_form_slug_underscored}" + "field_specs" - for field# {$field_number} (no "form_field_name")
For dataset:&nbsp; "{$dataset_title}"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        }

        // ---------------------------------------------------------------------

        if (    ! is_string( $field_details['form_field_name'] )
                ||
                trim( $field_details['form_field_name'] ) === ''
                ||
                ! \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_stringUtils\ctype_varname( $field_details['form_field_name'] )
                ||
                strlen( $field_details['form_field_name'] ) > 64
            ) {

            return <<<EOT
PROBLEM: Bad "zebra_forms" + "{$safe_form_slug_underscored}" + "field_specs" + "form_field_name" - for field# {$field_number} (1 to 64 character, variable name like string expected)
For dataset:&nbsp; "{$dataset_title}"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        }

        // ---------------------------------------------------------------------

        $form_field_names_found[] = $field_details['form_field_name'] ;

        // ---------------------------------------------------------------------
        // zebra_control_type ? (required)
        // ---------------------------------------------------------------------

        if ( ! isset( $field_details['zebra_control_type'] ) ) {

            return <<<EOT
PROBLEM: Bad "zebra_forms" + "{$safe_form_slug_underscored}" + "field_specs" - for field# {$field_number} (no "zebra_control_type")
For field:&nbsp; {$field_details['form_field_name']}
Of dataset:&nbsp; "{$dataset_title}"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        }

        // ---------------------------------------------------------------------

        if (    ! is_string( $field_details['zebra_control_type'] )
                ||
                trim( $field_details['zebra_control_type'] ) === ''
                ||
                ! ctype_alpha( $field_details['zebra_control_type'] )
                ||
                strlen( $field_details['zebra_control_type'] ) > 32
            ) {

            return <<<EOT
PROBLEM: Bad "zebra_forms" + "{$safe_form_slug_underscored}" + "field_specs" + "zebra_control_type" - for field# {$field_number} (1 to 32 character string alphabetic expected)
For field:&nbsp; {$field_details['form_field_name']}
Of dataset:&nbsp; "{$dataset_title}"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        }

        // ---------------------------------------------------------------------
        // label ? (optional)
        // ---------------------------------------------------------------------

        if ( isset( $field_details['label'] ) ) {

            if ( $field_details['label'] === NULL ) {

                $defaulted_field_details['label'] =
                    \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_stringUtils\to_title( $field_details['form_field_name'] )
                    ;

            } elseif ( ! is_string( $field_details['label'] ) ) {

                return <<<EOT
PROBLEM: Bad "zebra_forms" + "{$safe_form_slug_underscored}" + "field_specs" + "label" - for field# {$field_number} (possibly empty string or NULL expected)
For field:&nbsp; {$field_details['form_field_name']}
Of dataset:&nbsp; "{$dataset_title}"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

            }

        } else {

            $defaulted_field_details['label'] =
                \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_stringUtils\to_title( $field_details['form_field_name'] )
                ;

        }

        // ---------------------------------------------------------------------
        // value_from ? (optional)
        // ---------------------------------------------------------------------

        // -------------------------------------------------------------------------
        // check_and_default_value_from(
        //      $dataset_title                  ,
        //      $field_number                   ,
        //      $array_storage_field_slugs      ,
        //      $safe_form_slug_underscored     ,
        //      &$field_details
        //      )
        // - - - - - - - - - - - - - - - - - - -
        // Defaults $field_details['value_from'] (and it's members) as required.
        //
        // RETURNS
        //      o   On SUCCESS
        //          TRUE
        //
        //      o   On FAILURE
        //          $error_message STRING
        // -------------------------------------------------------------------------

//      if ( ! in_array(
//                  $field_details['zebra_control_type']    ,
//                  $zebra_controls_with_no_default_value   ,
//                  TRUE
//                  )
//          ) {

            // -----------------------------------------------------------------

            $result = check_and_default_value_from(
                            $dataset_title                  ,
                            $field_number                   ,
                            $array_storage_field_slugs      ,
                            $safe_form_slug_underscored     ,
                            $defaulted_field_details
                            ) ;

            // -----------------------------------------------------------------

            if ( is_string( $result ) ) {
                return $result ;
            }

            // -----------------------------------------------------------------

//      }

        // ---------------------------------------------------------------------
        // attributes ?
        // ---------------------------------------------------------------------

        if ( isset( $field_details['attributes'] ) ) {

            if ( $field_details['attributes'] === NULL ) {

                $defaulted_field_details['attributes'] = array() ;

            } elseif ( ! is_array( $field_details['attributes'] ) ) {

                return <<<EOT
PROBLEM: Bad "zebra_forms" + "{$safe_form_slug_underscored}" + "field_specs" + "attributes" - for field# {$field_number} (possibly empty array or NULL expected)
For field:&nbsp; {$field_details['form_field_name']}
Of dataset:&nbsp; "{$dataset_title}"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

            }

        } else {

            $defaulted_field_details['attributes'] = array() ;

        }

        // ---------------------------------------------------------------------
        // rules ?
        // ---------------------------------------------------------------------

        if ( isset( $field_details['rules'] ) ) {

            if ( $field_details['rules'] === NULL ) {

                $defaulted_field_details['rules'] = array() ;

            } elseif ( ! is_array( $field_details['rules'] ) ) {

                return <<<EOT
PROBLEM: Bad "zebra_forms" + "{$safe_form_slug_underscored}" + "field_specs" + "rules" - for field# {$field_number} (possibly empty array or NULL expected)
For field:&nbsp; {$field_details['form_field_name']}
Of dataset:&nbsp; "{$dataset_title}"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

            }

        } else {

            $defaulted_field_details['rules'] = array() ;

        }

        // ---------------------------------------------------------------------
        // type_specific_args ?
        // ---------------------------------------------------------------------

        if ( isset( $field_details['type_specific_args'] ) ) {

            if ( $field_details['type_specific_args'] === NULL ) {

                $defaulted_field_details['type_specific_args'] = array() ;

            } elseif ( ! is_array( $field_details['type_specific_args'] ) ) {

                return <<<EOT
PROBLEM: Bad "zebra_forms" + "{$safe_form_slug_underscored}" + "field_specs" + "type_specific_args" - for field# {$field_number} (possibly empty array or NULL expected)
For field:&nbsp; {$field_details['form_field_name']}
Of dataset:&nbsp; "{$dataset_title}"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

            }

        } else {

            $defaulted_field_details['type_specific_args'] = array() ;

        }

        // ---------------------------------------------------------------------
        // constraints ?
        // ---------------------------------------------------------------------

        // -----------------------------------------------------------------------------
        //      'constraints'       OPTIONAL
        //
        //          NOTE!
        //          =====
        //          These are the "contraints" that apply when SAVING a submitted
        //          Zebra Form.
        //
        //          If specified, must be an ARRAY containing zero or more sub-arrays.
        //          Eg:-
        //
        //              array(
        //
        //                  array(
        //                      'method'    =>  'unique'
        //                      //  "instance" and "args", if specified, are ignored
        //                      )
        //
        //                  array(
        //                      'method'    =>  'unique-case-insensitively'
        //                      //  "instance" and "args", if specified, are ignored
        //                      )
        //
        //                  array(
        //                      'method'    =>  'unique-key'
        //                      //  "instance" and "args", if specified, are ignored
        //                      )
        //
        //                  array(
        //                      'method'    =>  'in-array-strict'
        //                      'instance'  =>  array(...)
        //                      //  "args", if specified, is ignored
        //                      )
        //
        //                  array(
        //                      'method'    =>  'in-array-not-strict'
        //                      'instance'  =>  array(...)
        //                      //  "args", if specified, is ignored
        //                      )
        //
        //                  array(
        //                      'method'    =>  'function'
        //                      'instance'  =>  '<function name, including namespace prefix if necessary>'
        //                      'args'      =>  (optional) If specified, should be either
        //                                      NULL or a possibly empty array.  NULL and
        //                                      not specified are converted to the empty
        //                                      array.
        //                      )
        //
        //                  )
        //
        //          If NOT specified, defaults to the empty array.
        // -----------------------------------------------------------------------------

        if ( isset( $field_details['constraints'] ) ) {

            if ( $field_details['constraints'] === NULL ) {

                $defaulted_field_details['constraints'] = array() ;

            } elseif ( is_array( $field_details['constraints'] ) ) {

                // -------------------------------------------------------------

                foreach ( $field_details['constraints'] as $constraint_index => $this_constraint ) {

                    // ---------------------------------------------------------

                    $constraint_number = $constraint_index + 1 ;

                    // ---------------------------------------------------------

                    if ( ! is_array( $this_constraint ) ) {

                        return <<<EOT
PROBLEM: Bad "zebra_forms" + "{$safe_form_slug_underscored}" + "field_specs" + "constraints" - for field# {$field_number} (constraint# {$constraint_number} is not an array)
For field:&nbsp; {$field_details['form_field_name']}
Of dataset:&nbsp; "{$dataset_title}"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

                    }

                    // ---------------------------------------------------------

                    if ( ! array_key_exists( 'method' , $this_constraint ) ) {

                        return <<<EOT
PROBLEM: Bad "zebra_forms" + "{$safe_form_slug_underscored}" + "field_specs" + "constraints" - for field# {$field_number} (constraint# {$constraint_number} has no "method")
For field:&nbsp; {$field_details['form_field_name']}
Of dataset:&nbsp; "{$dataset_title}"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

                    }

                    // ---------------------------------------------------------

                }

                // -------------------------------------------------------------

            } else {

                return <<<EOT
PROBLEM: Bad "zebra_forms" + "{$safe_form_slug_underscored}" + "field_specs" + "constraints" - for field# {$field_number} (possibly empty array or NULL expected)
For field:&nbsp; {$field_details['form_field_name']}
Of dataset:&nbsp; "{$dataset_title}"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

            }

        } else {

            $defaulted_field_details['constraints'] = array() ;

        }

//pr( $defaulted_field_details ) ;

        // =====================================================================
        // Save the defaulted field details...
        // =====================================================================

        $defaulted_zebra_form['field_specs'][ $field_index ] =
            $defaulted_field_details
            ;

        // =====================================================================
        // Repeat with the NEXT FIELD (if there is one)...
        // =====================================================================

    }

    // =========================================================================
    // CHECK/DEFAULT the "FOCUS_FIELD_SLUG"...
    // =========================================================================

    // -------------------------------------------------------------------------
    // $selected_datasets_dmdd['zebra_forms']['focus_field_slug'] = (one of)
    //
    //      o   TRUE  (Yes, focus the first (error) field)
    //
    //      o   FALSE (No, focus NO field)
    //
    //      o   NULL or not specified = defaults to TRUE (Focus the first
    //          (error) field)
    //
    //      o   "form_field_name" from
    //              $selected_datasets_dmdd['zebra_forms']['field_specs']
    //
    // -------------------------------------------------------------------------

    if ( isset( $defaulted_zebra_form['focus_field_slug'] ) ) {

        // ---------------------------------------------------------------------

        if ( $defaulted_zebra_form['focus_field_slug'] === NULL ) {

            $defaulted_zebra_form['focus_field_slug'] = TRUE ;

        } elseif ( is_string( $defaulted_zebra_form['focus_field_slug'] ) ) {

            if ( ! in_array(
                        $defaulted_zebra_form['focus_field_slug']   ,
                        $form_field_names_found                     ,
                        TRUE
                        )
                ) {

                return <<<EOT
PROBLEM: Bad "zebra_forms" + "{$safe_form_slug_underscored}" + "focus_field_slug" (no such "zebra_forms" + "{$safe_form_slug_underscored}" + "field_specs" + "form_field_name" has been defined)
For dataset:&nbsp; "{$dataset_title}"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

            }

        } elseif ( ! is_bool( $defaulted_zebra_form['focus_field_slug'] ) ) {

                return <<<EOT
PROBLEM: Bad "zebra_forms" + "{$safe_form_slug_underscored}" + "focus_field_slug" (TRUE, FALSE, NULL or valid "form_field_name" expected)
For dataset:&nbsp; "{$dataset_title}"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        }

        // ---------------------------------------------------------------------

    } else {

        $defaulted_zebra_form['focus_field_slug'] = TRUE ;

    }

    // =========================================================================
    // SUCCESS!
    // =========================================================================

    $defaulted_zebra_form['checked_defaulted_ok'] = TRUE ;

    $selected_datasets_dmdd['zebra_forms'][ $form_slug_underscored ] = $defaulted_zebra_form ;

    $all_application_dataset_definitions[ $dataset_slug ]['zebra_forms'][ $form_slug_underscored ] = $defaulted_zebra_form ;

    // -------------------------------------------------------------------------

    return TRUE ;

    // =========================================================================
    // That's that!
    // =========================================================================

}

// =============================================================================
// check_and_default_value_from()
// =============================================================================

function check_and_default_value_from(
    $dataset_title                  ,
    $field_number                   ,
    $array_storage_field_slugs      ,
    $safe_form_slug_underscored     ,
    &$field_details
    ) {

    // -------------------------------------------------------------------------
    // check_and_default_value_from(
    //      $dataset_title                  ,
    //      $field_number                   ,
    //      $array_storage_field_slugs      ,
    //      $safe_form_slug_underscored     ,
    //      &$field_details
    //      )
    // - - - - - - - - - - - - - - - - - - -
    // Defaults $field_details['value_from'] (and it's members) as required.
    //
    // RETURNS
    //      o   On SUCCESS
    //          TRUE
    //
    //      o   On FAILURE
    //          $error_message STRING
    // -------------------------------------------------------------------------

    // -------------------------------------------------------------------------
    //  'value_from'    OPTIONAL
    //
    //      This tells us where the value displayed in the field comes from,
    //      whenever the field is displayed (on the form).
    //
    //      NOTE that:-
    //
    //      1.  You have to specify "value_from" separately, for the "add" and
    //          "edit" versions of the form.
    //
    //      2.  The following Zebra Form control types DON'T have values to be
    //          set:-
    //              o   "submit"
    //              o   "button"
    //
    //          So there's NO need to specify "value_from" for fields with these
    //          control types.  And if you do specify "value_from", it will be
    //          IGNORED.
    //
    //      o   If specified, "value_from" should be like:-
    //
    //              array(
    //                  'add'   =>  array(
    //                                  'method'    =>  'array_storage_field_slug'
    //                                  'args'      =>  '<array storage field slug to get value from>'
    //                                                  //  (NULL or not specified means use "form_field_name")
    //                              -OR-
    //                                  'method'    =>  'literal' (The DEFAULT "add" value is the empty string)
    //                                  'args'      =>  <some PHP (scalar) value>
    //                              -OR-
    //                                  'method'    =>  'function'
    //                                  'args'      =>  array(
    //                                                      'function_name' =>  <function name, including namespace prefix if necessary>
    //                                                      'extra_args'    =>  <the extra args (if any), required by this function>
    //                                  )   ,
    //                  'edit'  =>  array(
    //                                  'method'    =>  'array_storage_field_slug' (This is the DEFAULT)
    //                                  'args'      =>  '<array storage field slug to get value from>'
    //                                                  //  (NULL or not specified means use "form_field_name")
    //                              -OR-
    //                                  'method'    =>  'literal'
    //                                  'args'      =>  <some PHP (scalar) value>
    //                              -OR-
    //                                  'method'    =>  'function'
    //                                  'args'      =>  array(
    //                                                      'function_name' =>  <function name, including namespace prefix if necessary>
    //                                                      'extra_args'    =>  <the extra args (if any), required by this function>
    //                                  )
    //                  )
    //
    //      o   If "value_from_from" - or any of it's components:-
    //              a)  ISN'T specified,
    //              b)  is NULL, or;
    //              c)  is the empty array(),
    //
    //          then things DEFAULT as follows:-
    //
    //              array(
    //                  'add'   =>  array(
    //                                  'method'    =>  'literal'   ,
    //                                  'args'      =>  ''
    //                                  )   ,
    //                  'edit'  =>  array(
    //                                  'method'    =>  'array-storage-field-slug'      ,
    //                                  'args'      =>  <field's "form_field_name">
    //                                  )
    //                  )
    //
    // -------------------------------------------------------------------------

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $field_details = Array(
    //          [form_field_name]       =>  pathspec
    //          [zebra_control_type]    =>  text
    //          [label]                 =>  Pathspec
    //          [attributes]            =>  Array()
    //          [rules]                 =>  Array(
    //                                          [required] => Array(
    //                                                          [0] => error
    //                                                          [1] => Field is required
    //                                                          )
    //                                          )
    //          )
    //
    // -------------------------------------------------------------------------

//pr( $field_details ) ;

    // =========================================================================
    // Init.
    // =========================================================================

    $ns = __NAMESPACE__ ;
    $fn = __FUNCTION__ ;

    // =========================================================================
    // Ignore the Zebra Form controls that have no "default value"...
    // =========================================================================

    if ( in_array(
                $field_details['zebra_control_type']            ,
                get_zebra_controls_with_no_default_value()      ,
                TRUE
                )
        ) {
        return TRUE ;
     }

    // =========================================================================
    // Set the DEFAULT VALUE WHEN ADDING'..
    // =========================================================================

    if ( $field_details['zebra_control_type'] === 'checkbox' ) {
        $default_when_adding = FALSE ;

    } else {
        $default_when_adding = '' ;

    }

    // =========================================================================
    // ISSET ?
    // =========================================================================

    if (    ! isset( $field_details['value_from'] )
            ||
            $field_details['value_from'] === NULL
            ||
            (   is_array( $field_details['value_from'] )
                &&
                count( $field_details['value_from'] ) === 0
                )
        ) {

        // ---------------------------------------------------------------------
        // Set the DEFAULT "value_from"...
        // ---------------------------------------------------------------------

        if ( ! in_array( $field_details['form_field_name'] , $array_storage_field_slugs , TRUE ) ) {

            return <<<EOT
PROBLEM: Can't default "zebra_forms" + "{$safe_form_slug_underscored}" + "field_specs" + "value_from" - for field# {$field_number} (because there's NO "{$field_details['form_field_name']}" field in the array storage record)
For field:&nbsp; {$field_details['form_field_name']}
Of form:&nbsp; {$safe_form_slug_underscored}
And dataset:&nbsp; "{$dataset_title}"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        }

        // ---------------------------------------------------------------------

        $field_details['value_from'] = array(
            'add'   =>  array(
                            'method'    =>  'literal'               ,
                            'args'      =>  $default_when_adding
                            )   ,
            'edit'  =>  array(
                            'method'    =>  'array-storage-field-slug'          ,
                            'args'      =>  $field_details['form_field_name']
                            )
            ) ;

        // ---------------------------------------------------------------------

        return TRUE ;

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // "value_from" must be an ARRAY...
    // =========================================================================

    if ( ! is_array( $field_details['value_from'] ) ) {

        return <<<EOT
PROBLEM: Bad "zebra_forms" + "{$safe_form_slug_underscored}" + "field_specs" + "value_from" - for field# {$field_number} (not an array)
For field:&nbsp; {$field_details['form_field_name']}
Of form:&nbsp; {$safe_form_slug_underscored}
And dataset:&nbsp; "{$dataset_title}"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

    }

    // -------------------------------------------------------------------------
    // check_and_default_value_from__method_and_args(
    //      $dataset_title                  ,
    //      $field_number                   ,
    //      $array_storage_field_slugs      ,
    //      $safe_form_slug_underscored     ,
    //      &$field_details                 ,
    //      $add_edit
    //      )
    // - - - - - - - - - - - - - - - - - - -
    // Checks and defaults:-
    //      $field_details['value_from']['add'] or;
    //      $field_details['value_from']['edit']
    //
    // (and it's members) as required.
    //
    // RETURNS
    //      o   On SUCCESS
    //          TRUE
    //
    //      o   On FAILURE
    //          $error_message STRING
    // -------------------------------------------------------------------------

    // =========================================================================
    // "value_from" + "add"
    // =========================================================================

    if ( isset( $field_details['value_from']['add'] ) ) {

        // ---------------------------------------------------------------------

        $add_edit = 'add' ;

        // ---------------------------------------------------------------------

        $result = check_and_default_value_from__method_and_args(
                        $dataset_title                  ,
                        $field_number                   ,
                        $array_storage_field_slugs      ,
                        $safe_form_slug_underscored     ,
                        $field_details                  ,
                        $add_edit
                        ) ;

        // ---------------------------------------------------------------------

        if ( is_string( $result ) ) {
            return $result ;
        }

        // ---------------------------------------------------------------------

    } else {

        // ---------------------------------------------------------------------
        // Set the DEFAULT 'add'...
        // --------------------------------------------------------------------

        $field_details['value_from']['add'] = array(
            'method'    =>  'literal'               ,
            'args'      =>  $default_when_adding
            ) ;

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // "value_from" + "edit"
    // =========================================================================

    if ( isset( $field_details['value_from']['edit'] ) ) {

        // ---------------------------------------------------------------------

        $add_edit = 'edit' ;

        // ---------------------------------------------------------------------

        $result = check_and_default_value_from__method_and_args(
                        $dataset_title                  ,
                        $field_number                   ,
                        $array_storage_field_slugs      ,
                        $safe_form_slug_underscored     ,
                        $field_details                  ,
                        $add_edit
                        ) ;

        // ---------------------------------------------------------------------

        if ( is_string( $result ) ) {
            return $result ;
        }

        // ---------------------------------------------------------------------

    } else {

        // ---------------------------------------------------------------------
        // Set the DEFAULT 'edit'...
        // ---------------------------------------------------------------------

        if ( ! in_array( $field_details['form_field_name'] , $array_storage_field_slugs , TRUE ) ) {

            return <<<EOT
PROBLEM: Can't default "zebra_forms" + "{$safe_form_slug_underscored}" + "field_specs" + "value_from" + "edit" - for field# {$field_number} (because there's NO "{$field_details['form_field_name']}" field in the array storage record)
For field:&nbsp; {$field_details['form_field_name']}
Of form:&nbsp; {$safe_form_slug_underscored}
And dataset:&nbsp; "{$dataset_title}"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        }

        // ---------------------------------------------------------------------

        $field_details['value_from']['edit'] = array(
            'method'    =>  'array-storage-field-slug'          ,
            'args'      =>  $field_details['form_field_name']
            ) ;

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
// check_and_default_value_from__method_and_args()
// =============================================================================

function check_and_default_value_from__method_and_args(
    $dataset_title                  ,
    $field_number                   ,
    $array_storage_field_slugs      ,
    $safe_form_slug_underscored     ,
    &$field_details                 ,
    $add_edit
    ) {

    // -------------------------------------------------------------------------
    // check_and_default_value_from__method_and_args(
    //      $dataset_title                  ,
    //      $field_number                   ,
    //      $array_storage_field_slugs      ,
    //      $safe_form_slug_underscored     ,
    //      &$field_details                 ,
    //      $add_edit
    //      )
    // - - - - - - - - - - - - - - - - - - -
    // Checks and defaults:-
    //      $field_details['value_from']['add'] or;
    //      $field_details['value_from']['edit']
    //
    // (and it's members) as required.
    //
    // RETURNS
    //      o   On SUCCESS
    //          TRUE
    //
    //      o   On FAILURE
    //          $error_message STRING
    // -------------------------------------------------------------------------

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $field_details['value_from'] = array(
    //
    //          'add'   =>  array(
    //                          'method'    =>  'array-storage-field-slug'
    //                          'args'      =>  "xxx" (array storage field slug to get value from)
    //                      -OR-
    //                          'method'    =>  'literal' (The DEFAULT "add" value is the empty string)
    //                          'args'      =>  <some literal value>
    //                      -OR-
    //                          'method'    =>  'function'
    //                          'args'      =>  array(
    //                                              'name'          =>  <function name, including namespace prefix if necessary>
    //                                              'extra_args'    =>  <the extra args (if any), required by this function>
    //                                              )
    //                          )
    //
    //          'edit'  =>  array(
    //                          'method'    =>  'array-storage-field-slug' (This is the DEFAULT)
    //                          'args'      =>  "xxx" (array storage field slug to get value from)
    //                      -OR-
    //                          'method'    =>  'literal'
    //                          'args'      =>  <some literal value>
    //                      -OR-
    //                          'method'    =>  'function'
    //                          'args'      =>  array(
    //                                              'name'          =>  <function name, including namespace prefix if necessary>
    //                                              'extra_args'    =>  <the extra args (if any), required by this function>
    //                                              )
    //                          )
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
    // ERROR CHECKING...
    // =========================================================================

    // -------------------------------------------------------------------------
    // "add/edit" must be an array...
    // -------------------------------------------------------------------------

    if ( ! is_array( $field_details['value_from'][ $add_edit ] ) ) {

        return <<<EOT
PROBLEM: Bad "zebra_forms" + "{$safe_form_slug_underscored}" + "field_specs" + "value_from" + "{$add_edit}" - for field# {$field_number} (not an array)
For field:&nbsp; {$field_details['form_field_name']}
Of form:&nbsp; {$safe_form_slug_underscored}
And dataset:&nbsp; "{$dataset_title}"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

    }

    // -------------------------------------------------------------------------
    // "add/edit" + "method" must be both present and a string...
    // -------------------------------------------------------------------------

    if ( ! isset( $field_details['value_from'][ $add_edit ]['method'] ) ) {

        return <<<EOT
PROBLEM: Bad "zebra_forms" + "{$safe_form_slug_underscored}" + "field_specs" + "value_from" + "{$add_edit}" - for field# {$field_number} (no "method")
For field:&nbsp; {$field_details['form_field_name']}
Of form:&nbsp; {$safe_form_slug_underscored}
And dataset:&nbsp; "{$dataset_title}"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

    }

    // -------------------------------------------------------------------------

    if (    ! is_string( $field_details['value_from'][ $add_edit ]['method'] )
            ||
            trim( $field_details['value_from'][ $add_edit ]['method'] ) === ''
        ) {

        return <<<EOT
PROBLEM: Bad "zebra_forms" + "{$safe_form_slug_underscored}" + "field_specs" + "value_from" + "{$add_edit}" + "method" - for field# {$field_number} (non-empty string expected)
For field:&nbsp; {$field_details['form_field_name']}
Of form:&nbsp; {$safe_form_slug_underscored}
And dataset:&nbsp; "{$dataset_title}"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

    }

    // -------------------------------------------------------------------------
    // Check "method" and "args"...
    // -------------------------------------------------------------------------

    if ( $field_details['value_from'][ $add_edit ]['method'] === 'array-storage-field-slug' ) {

        // =====================================================================
        // METHOD = ARRAY-STORAGE-FIELD-SLUG
        // =================================
        // "args" is required and must be an "array-storage-field-slug"...
        // =====================================================================

        if (    $field_details['value_from'][ $add_edit ]['args'] === NULL
                ||
                ! isset( $field_details['value_from'][ $add_edit ]['args'] )
            ) {

            $field_details['value_from'][ $add_edit ]['args'] =
                $field_details['form_field_name']
                ;

        }

        // ---------------------------------------------------------------------

        if (    ! isset( $field_details['value_from'][ $add_edit ]['args'] )
                ||
                ! in_array( $field_details['value_from'][ $add_edit ]['args'] , $array_storage_field_slugs , TRUE )
            ) {

            return <<<EOT
PROBLEM: Bad "zebra_forms" + "{$safe_form_slug_underscored}" + "field_specs" + "value_from" + "{$add_edit}" - for field# {$field_number} ("args" is required - and must be an `array storage field slug`)
For field:&nbsp; {$field_details['form_field_name']}
Of form:&nbsp; {$safe_form_slug_underscored}
And dataset:&nbsp; "{$dataset_title}"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        }

        // ---------------------------------------------------------------------

    } elseif ( $field_details['value_from'][ $add_edit ]['method'] === 'literal' ) {

        // =====================================================================
        // METHOD = LITERAL
        // ================
        // "args" is required and must be a PHP SCALAR type...
        // =====================================================================

        if (    ! isset( $field_details['value_from'][ $add_edit ]['args'] )
                ||
                ! is_scalar( $field_details['value_from'][ $add_edit ]['args'] )
            ) {

            return <<<EOT
PROBLEM: Bad "zebra_forms" + "{$safe_form_slug_underscored}" + "field_specs" + "value_from" + "{$add_edit}" + "args" - for field# {$field_number} (SCALAR value - ie; STRING, INT, BOOLEAN or FLOAT - expected)
For field:&nbsp; {$field_details['form_field_name']}
Of form:&nbsp; {$safe_form_slug_underscored}
And dataset:&nbsp; "{$dataset_title}"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        }

        // ---------------------------------------------------------------------

    } elseif ( $field_details['value_from'][ $add_edit ]['method'] === 'function' ) {

        // =====================================================================
        // METHOD = FUNCTION
        // =================
        // "args" is required and must be an array...
        // =====================================================================

        if (    ! isset( $field_details['value_from'][ $add_edit ]['args'] )
                ||
                ! is_array( $field_details['value_from'][ $add_edit ]['args'] )
            ) {

            return <<<EOT
PROBLEM: Bad "zebra_forms" + "{$safe_form_slug_underscored}" + "field_specs" + "value_from" + "{$add_edit}" + "args" - for field# {$field_number} (array expected)
For field:&nbsp; {$field_details['form_field_name']}
Of form:&nbsp; {$safe_form_slug_underscored}
And dataset:&nbsp; "{$dataset_title}"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        }

        // ---------------------------------------------------------------------
        // Which array has two members:-
        //      o   "function_name" (required)
        //      o   "extra_args"    (optional)
        // ---------------------------------------------------------------------

        if ( ! isset( $field_details['value_from'][ $add_edit ]['args']['function_name'] ) ) {

            return <<<EOT
PROBLEM: Bad "zebra_forms" + "{$safe_form_slug_underscored}" + "field_specs" + "value_from" + "{$add_edit}" + "args" - for field# {$field_number} (no "function_name")
For field:&nbsp; {$field_details['form_field_name']}
Of form:&nbsp; {$safe_form_slug_underscored}
And dataset:&nbsp; "{$dataset_title}"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        }

        // ---------------------------------------------------------------------

        if ( ! is_string( $field_details['value_from'][ $add_edit ]['args']['function_name'] ) ) {

            return <<<EOT
PROBLEM: Bad "zebra_forms" + "{$safe_form_slug_underscored}" + "field_specs" + "value_from" + "{$add_edit}" + "args" + "function_name" - for field# {$field_number} (function name string expected)
For field:&nbsp; {$field_details['form_field_name']}
Of form:&nbsp; {$safe_form_slug_underscored}
And dataset:&nbsp; "{$dataset_title}"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        }

        // ---------------------------------------------------------------------

        if ( ! function_exists( $field_details['value_from'][ $add_edit ]['args']['function_name'] ) ) {

            return <<<EOT
PROBLEM: Bad "zebra_forms" + "{$safe_form_slug_underscored}" + "field_specs" + "value_from" + "{$add_edit}" + "args" + "function_name" - for field# {$field_number} (function not found)
For field:&nbsp; {$field_details['form_field_name']}
Of form:&nbsp; {$safe_form_slug_underscored}
And dataset:&nbsp; "{$dataset_title}"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        }

        // ---------------------------------------------------------------------

        if (    ! isset( $field_details['value_from'][ $add_edit ]['args']['extra_args'] )
                ||
                $field_details['value_from'][ $add_edit ]['args']['extra_args'] === NULL
            ) {
            $field_details['value_from'][ $add_edit ]['args']['extra_args'] = array() ;
        }

        // ---------------------------------------------------------------------

    } else {

        // =====================================================================
        // ERROR
        // =====================================================================

        return <<<EOT
PROBLEM: Unrecognised/unsupported "zebra_forms" + "{$safe_form_slug_underscored}" + "field_specs" + "value_from" + "{$add_edit}" + "method" - for field# {$field_number}
For field:&nbsp; {$field_details['form_field_name']}
Of form:&nbsp; {$safe_form_slug_underscored}
And dataset:&nbsp; "{$dataset_title}"
Detected in:&nbsp; \\{$ns}\\{$fn}()
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
// auto_create_field_specs()
// =============================================================================

function auto_create_field_specs(
    $defaulted_zebra_form           ,
    $array_storage_field_slugs      ,
    $dataset_title                  ,
    $safe_form_slug_underscored
    ) {

    // -------------------------------------------------------------------------
    // auto_create_field_specs(
    //      $defaulted_zebra_form           ,
    //      $array_storage_field_slugs      ,
    //      $dataset_title                  ,
    //      $safe_form_slug_underscored
    //      )
    // - - - - - - - - - - - - - - - - - - -
    // RETURNS
    //      o   On SUCCESS!
    //              $auto_created_field_specs ARRAY
    //
    //      o   On FAILURE!
    //              $error_message STRING
    // -------------------------------------------------------------------------

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $defaulted_zebra_form['auto_create_field_specs'] = array(
    //
    //          'include'       =>  "all" (default)
    //                              --OR--
    //                              array(
    //                                  "<array-storage-field-slug-to-include-1>"
    //                                  "<array-storage-field-slug-to-include-2>"
    //                                  ...
    //                                  "<array-storage-field-slug-to-include-N>"
    //                                  )                                   ,
    //
    //          'exclude'       =>  "none" (default)
    //                              --OR--
    //                              array(
    //                                  "<array-storage-field-slug-to-exclude-1>"
    //                                  "<array-storage-field-slug-to-exclude-2>"
    //                                  ...
    //                                  "<array-storage-field-slug-to-exclude-N>"
    //                                  )                                   ,
    //
    //          'submit_button' =>  TRUE | FALSE | "<submit-button-text>"   ,
    //
    //          'cancel_button' =>  TRUE | FALSE | "<cancel-button-text>"
    //
    //          )
    //
    // All the above "auto_create_field_specs" array members are OPTIONAL.
    //
    // "submit_button" and "cancel_button" both default to FALSE.
    // -------------------------------------------------------------------------

    // =========================================================================
    // Init.
    // =========================================================================

    $ns = __NAMESPACE__ ;
    $fn = __FUNCTION__ ;

    // =========================================================================
    // include ?
    // =========================================================================

    if (    ! array_key_exists( 'include' , $defaulted_zebra_form['auto_create_field_specs'] )
            ||
            $defaulted_zebra_form['auto_create_field_specs']['include'] === 'all'
        ) {

        // ---------------------------------------------------------------------

        $include = $array_storage_field_slugs ;

        // ---------------------------------------------------------------------

    } elseif ( ! is_array( $defaulted_zebra_form['auto_create_field_specs']['include'] ) ) {

        // ---------------------------------------------------------------------

        return <<<EOT
PROBLEM: Bad "zebra_forms" + "{$safe_form_slug_underscored}" + "auto_create_field_specs" + "include" (array expected)
For dataset:&nbsp; {$dataset_title}
and form:&nbsp; {$safe_form_slug_underscored}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        // ---------------------------------------------------------------------

    } else {

        // ---------------------------------------------------------------------

        foreach ( $defaulted_zebra_form['auto_create_field_specs']['include'] as $candidate_array_storage_field_slug ) {

            if ( ! in_array( $candidate_array_storage_field_slug , $array_storage_field_slugs , TRUE ) ) {

                return <<<EOT
PROBLEM: Unrecognised array storage field slug in "zebra_forms" + "{$safe_form_slug_underscored}" + "auto_create_field_specs" + "include"
For dataset:&nbsp; {$dataset_title}
and form:&nbsp; {$safe_form_slug_underscored}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

            }

        }

        // ---------------------------------------------------------------------

        $include = $defaulted_zebra_form['auto_create_field_specs']['include'] ;

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // exclude ?
    // =========================================================================

    if (    ! array_key_exists( 'exclude' , $defaulted_zebra_form['auto_create_field_specs'] )
            ||
            $defaulted_zebra_form['auto_create_field_specs']['exclude'] === 'none'
        ) {

        // ---------------------------------------------------------------------

        $exclude = array() ;

        // ---------------------------------------------------------------------

    } elseif ( ! is_array( $defaulted_zebra_form['auto_create_field_specs']['exclude'] ) ) {

        // ---------------------------------------------------------------------

        return <<<EOT
PROBLEM: Bad "zebra_forms" + "{$safe_form_slug_underscored}" + "auto_create_field_specs" + "exclude" (array expected)
For dataset:&nbsp; {$dataset_title}
and form:&nbsp; {$safe_form_slug_underscored}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        // ---------------------------------------------------------------------

    } else {

        // ---------------------------------------------------------------------

        foreach ( $defaulted_zebra_form['auto_create_field_specs']['exclude'] as $candidate_array_storage_field_slug ) {

            if ( ! in_array( $candidate_array_storage_field_slug , $array_storage_field_slugs , TRUE ) ) {

                return <<<EOT
PROBLEM: Unrecognised array storage field slug in "zebra_forms" + "{$safe_form_slug_underscored}" + "auto_create_field_specs" + "exclude"
For dataset:&nbsp; {$dataset_title}
and form:&nbsp; {$safe_form_slug_underscored}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

            }

        }

        // ---------------------------------------------------------------------

        $exclude = $defaulted_zebra_form['auto_create_field_specs']['exclude'] ;

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // submit_button ?
    // =========================================================================

    if (    ! array_key_exists( 'submit_button' , $defaulted_zebra_form['auto_create_field_specs'] )
            ||
            $defaulted_zebra_form['auto_create_field_specs']['submit_button'] === TRUE
        ) {

        // ---------------------------------------------------------------------

        $submit_button_text = 'Submit' ;

        // ---------------------------------------------------------------------

    } elseif ( $defaulted_zebra_form['auto_create_field_specs']['submit_button'] === FALSE ) {

        // ---------------------------------------------------------------------

        $submit_button_text = '' ;

        // ---------------------------------------------------------------------

    } elseif (  ! is_string( $defaulted_zebra_form['auto_create_field_specs']['submit_button'] )
                ||
                trim( $defaulted_zebra_form['auto_create_field_specs']['submit_button'] ) === ''
        ) {

        // ---------------------------------------------------------------------

        return <<<EOT
PROBLEM: Bad "zebra_forms" + "{$safe_form_slug_underscored}" + "auto_create_field_specs" + "submit_button" (non-empty string expected)
For dataset:&nbsp; {$dataset_title}
and form:&nbsp; {$safe_form_slug_underscored}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        // ---------------------------------------------------------------------

    } else {

        // ---------------------------------------------------------------------

        $submit_button_text = $defaulted_zebra_form['auto_create_field_specs']['submit_button'] ;

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // cancel_button ?
    // =========================================================================

    if (    ! array_key_exists( 'cancel_button' , $defaulted_zebra_form['auto_create_field_specs'] )
            ||
            $defaulted_zebra_form['auto_create_field_specs']['cancel_button'] === TRUE
        ) {

        // ---------------------------------------------------------------------

        $cancel_button_text = 'Cancel' ;

        // ---------------------------------------------------------------------

    } elseif ( $defaulted_zebra_form['auto_create_field_specs']['cancel_button'] === FALSE ) {

        // ---------------------------------------------------------------------

        $cancel_button_text = '' ;

        // ---------------------------------------------------------------------

    } elseif (  ! is_string( $defaulted_zebra_form['auto_create_field_specs']['cancel_button'] )
                ||
                trim( $defaulted_zebra_form['auto_create_field_specs']['cancel_button'] ) === ''
        ) {

        // ---------------------------------------------------------------------

        return <<<EOT
PROBLEM: Bad "zebra_forms" + "{$safe_form_slug_underscored}" + "auto_create_field_specs" + "cancel_button" (non-empty string expected)
For dataset:&nbsp; {$dataset_title}
and form:&nbsp; {$safe_form_slug_underscored}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        // ---------------------------------------------------------------------

    } else {

        // ---------------------------------------------------------------------

        $cancel_button_text = $defaulted_zebra_form['auto_create_field_specs']['cancel_button'] ;

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // Create the new FIELD SPECS...
    // =========================================================================

    // -------------------------------------------------------------------------
    // Get the:-
    //      $pre_defined_zebra_form_field_indices_by_name
    // -------------------------------------------------------------------------

    $pre_defined_zebra_form_field_indices_by_name = array() ;

    // -------------------------------------------------------------------------

    if ( array_key_exists( 'field_specs' , $defaulted_zebra_form ) ) {

        // ---------------------------------------------------------------------

        if ( ! is_array( $defaulted_zebra_form['field_specs'] ) ) {

            return <<<EOT
PROBLEM: Bad "zebra_forms" + "{$safe_form_slug_underscored}" + "field_specs" (array expected)
For dataset:&nbsp; "{$dataset_title}"
and form:&nbsp; "{$safe_form_slug_underscored}"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        }

        // ---------------------------------------------------------------------

        foreach ( $defaulted_zebra_form['field_specs'] as $this_index => $this_field_spec ) {

            // -----------------------------------------------------------------

            $field_number = $this_index + 1 ;

            // -----------------------------------------------------------------

            if ( ! array_key_exists( 'form_field_name' , $this_field_spec ) ) {

                return <<<EOT
PROBLEM: Bad "zebra_forms" + "{$safe_form_slug_underscored}" + "field_specs" + field# {$field_number} (no "form_field_name")
For dataset:&nbsp; "{$dataset_title}"
and form:&nbsp; "{$safe_form_slug_underscored}"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

            }

            // -----------------------------------------------------------------

            if (    ! is_string( $this_field_spec['form_field_name'] )
                    ||
                    trim( $this_field_spec['form_field_name'] ) === ''
                ) {

                return <<<EOT
PROBLEM: Bad "zebra_forms" + "{$safe_form_slug_underscored}" + "field_specs" + field# {$field_number} + "form_field_name" (non-empty string expected)
For dataset:&nbsp; "{$dataset_title}"
and form:&nbsp; "{$safe_form_slug_underscored}"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

            }

            // -----------------------------------------------------------------

            $pre_defined_zebra_form_field_indices_by_name[ $this_field_spec['form_field_name'] ] = $this_index ;

            // -----------------------------------------------------------------

        }

        // ---------------------------------------------------------------------

    }

    // -------------------------------------------------------------------------
    // DON'T use the pre-defined form fields if Raw Mode is ON...
    // -------------------------------------------------------------------------

    if (    function_exists( '\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\is_raw_mode_for_forms' )
            &&
            \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\is_raw_mode_for_forms() === TRUE
        ) {

        $pre_defined_zebra_form_field_indices_by_name = array() ;

    }

    // -------------------------------------------------------------------------
    // Create the new field specs proper...
    // -------------------------------------------------------------------------

    $new_field_specs = array() ;

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

        if ( array_key_exists( $this_array_storage_field_slug , $pre_defined_zebra_form_field_indices_by_name ) ) {

            // -----------------------------------------------------------------

            $new_field_specs[] = $defaulted_zebra_form['field_specs'][
                                    $pre_defined_zebra_form_field_indices_by_name[
                                        $this_array_storage_field_slug
                                        ]
                                    ] ;

            // -----------------------------------------------------------------

            continue ;

            // -----------------------------------------------------------------

        }

        // ---------------------------------------------------------------------

        $new_field_specs[] = array(
            'form_field_name'       =>  $this_array_storage_field_slug      ,
            'zebra_control_type'    =>  'text'                              ,
            'attributes'            =>  array(
                                            'style'     =>  'width:98%'
                                            )
            ) ;

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // SUBMIT BUTTON ?
    // =========================================================================

    if ( $submit_button_text !== '' ) {

        // ---------------------------------------------------------------------

        $new_field_specs[] = array(
            'form_field_name'       =>  'save_me'       ,
            'zebra_control_type'    =>  'submit'        ,
            'label'                 =>  NULL            ,
            'attributes'            =>  array()         ,
            'rules'                 =>  array()         ,
            'type_specific_args'    =>  array(
                                            'caption'   =>  $submit_button_text
                                            )
            ) ;

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // CANCEL BUTTON ?
    // =========================================================================

    if ( $cancel_button_text !== '' ) {

        // ---------------------------------------------------------------------

        $get_cancel_button_onclick_attribute_value_function_name =
            '\\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager' .
            '\\get_cancel_button_onclick_attribute_value'
            ;

        // ---------------------------------------------------------------------

        $new_field_specs[] = array(
            'form_field_name'       =>  'cancel'        ,
            'zebra_control_type'    =>  'button'        ,
            'label'                 =>  NULL            ,
            'dynamic_attributes'    =>  array(
                'onclick'       =>  array(
                    'function_name'     =>  $get_cancel_button_onclick_attribute_value_function_name    ,
                    'extra_args'        =>  NULL
                    )
                )   ,
            'rules'                 =>  array()         ,
            'type_specific_args'    =>  array(
                                            'caption'       =>  $cancel_button_text     ,
                                            'type'          =>  'button'
                                            )
            ) ;

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // SUCCESS!
    // =========================================================================

    return $new_field_specs ;

    // =========================================================================
    // That's that!
    // =========================================================================

}

    // =========================================================================
    // Zebra-Form Field Types and Their Parameters
    // - - - - - - - - - - - - - - - - - - - - - -
    //
    //      button
    //          id
    //          caption
    //          attributes
    //          type = 'button'
    //
    //      captcha
    //          id
    //          attach_to
    //          $storage = 'cookie'
    //
    //      checkbox
    //          id
    //          value
    //          attributes
    //
    //      date
    //          id
    //          default
    //          attributes
    //
    //      file
    //          id
    //          attributes
    //
    //      hidden
    //          id
    //          default
    //
    //      image
    //          id
    //          src
    //          attributes
    //
    //      label
    //          id
    //          attach_to
    //          caption
    //          attributes
    //
    //      note
    //          id
    //          attach_to
    //          caption
    //          attributes
    //
    //      password
    //          id
    //          default
    //          attributes
    //
    //      radio
    //          id
    //          value
    //          attributes
    //
    //      reset
    //          id
    //          caption
    //          attributes
    //
    //      select
    //          id
    //          default
    //          attributes
    //          default_other
    //
    //      submit
    //          id
    //          caption
    //          attributes
    //
    //      text
    //          id
    //          default
    //          attributes
    //
    //      textarea
    //          id
    //          default
    //          attributes
    //
    //      time
    //          id
    //          default
    //          attributes
    //
    // =========================================================================

    // =========================================================================
    // Zebra-Form "Rules"
    // ------------------
    // See "set_rule()" method in the Zebra-Form docs for descriptions of the
    // individual rules...
    //
    //      alphabet
    //      alphanumeric
    //      captcha
    //      compare
    //      convert
    //      custom
    //      date
    //      datecompare
    //      dependencies
    //      digits
    //      email
    //      emails
    //      filesize
    //      filetype
    //      float
    //      image
    //      length
    //      number
    //      regexp
    //      required
    //      resize
    //      upload
    //      url
    //
    // =========================================================================

// =============================================================================
// That's that!
// =============================================================================

