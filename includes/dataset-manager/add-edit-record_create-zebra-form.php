<?php

// *****************************************************************************
// DATASET-MANAGER / ADD-EDIT-RECORD_CREATE-ZEBRA-FORM.PHP
// (C) 2013 Peter Newman. All Rights Reserved.
// *****************************************************************************

    namespace greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager ;

// =============================================================================
// create_zebra_form_object_instance()
// =============================================================================

function create_zebra_form_object_instance(
    $home_page_title                                            ,
    $caller_apps_includes_dir                                   ,
    $all_application_dataset_definitions                        ,
    $dataset_slug                                               ,
    $question_front_end                                         ,
    $display_options    = array()                               ,
    $submission_options = array()                               ,
    $selected_datasets_dmdd                                     ,
    $dataset_title                                              ,
    $dataset_records                                            ,
    $record_indices_by_key                                      ,
    $question_adding                                            ,
    $form_slug_underscored                                      ,
    $array_storage_field_indices_to_base64_encode_pre_check
    ) {

    // -------------------------------------------------------------------------
    // create_zebra_form_object_instance(
    //      $home_page_title                                            ,
    //      $caller_apps_includes_dir                                   ,
    //      $all_application_dataset_definitions                        ,
    //      $dataset_slug                                               ,
    //      $question_front_end                                         ,
    //      $display_options    = array()                               ,
    //      $submission_options = array()                               ,
    //      $selected_datasets_dmdd                                     ,
    //      $dataset_title                                              ,
    //      $dataset_records                                            ,
    //      $record_indices_by_key                                      ,
    //      $question_adding                                            ,
    //      $form_slug_underscored                                      ,
    //      $array_storage_field_indices_to_base64_encode_pre_check
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // RETURNS
    //      o   On SUCCESS!
    //              array(
    //                  $zebra_form (= reference to Zebra Form object instance)
    //                  $selected_datasets_dmdd_updated
    //                  )
    //
    //      o   On FAILURE
    //              $error_message STRING
    // -------------------------------------------------------------------------

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $selected_datasets_dmdd = Array(
    //
    //          [dataset_slug]              => categories
    //          [dataset_name_singular]     => category
    //          [dataset_name_plural]       => categories
    //          [dataset_title_singular]    => Category
    //          [dataset_title_plural]      => Categories
    //          [basepress_dataset_handle]  => Array(
    //              [nice_name]     => researchAssistant_byFernTec_categories
    //              [unique_key]    => 6934fccc-c552-46b0-8db5-87a022f7c...af7adf54
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
    //                              [data_field_slug]   => project_title
    //                              [value_from]        => Array(
    //                                  [method]    => foreign-field
    //                                  [instance]  => title
    //                                  [args]      => Array(
    //                                                      [parent_key] => projects
    //                                                      )
    //                                  )
    //                              )
    //
    //                  [1] => Array(
    //                              [data_field_slug]   => title
    //                              [value_from]        => Array(
    //                                  [method]    => array-storage-field-slug
    //                                  [instance]  => title
    //                                  )
    //                      )
    //
    //                  [2] => Array(
    //                          [data_field_slug]       =>
    //                          [value_from]            => Array(
    //                              [method]    => special-type
    //                              [instance]  => action
    //                              )
    //                          )
    //
    //                  )
    //
    //              [rows_per_page]                         => 10
    //              [default_data_field_slug_to_orderby]    => title
    //              [default_order]                         => asc
    //              [actions]                               => Array(
    //                                                              [edit]      => edit
    //                                                              [delete]    => delete
    //                                                              )
    //              [action_separator]                      =>
    //
    //              )
    //
    //          [zebra_form] => Array(
    //
    //              [form_specs] => Array(
    //                  [name]                  => add_edit_category
    //                  [method]                => POST
    //                  [action]                =>
    //                  [attributes]            => Array(
    //                      [target] => _parent
    //                      )
    //                  [clientside_validation] => 1
    //                  )
    //
    //              [field_specs] => Array(
    //
    //                  [0] => Array(
    //                              [form_field_name]       => parent_key
    //                              [zebra_control_type]    => select
    //                              [label]                 => Project
    //                              [value_from]            => Array(
    //                                  [add] => Array(
    //                                      [method]    => literal
    //                                      [args]      =>
    //                                      )
    //
    //                                  [edit] => Array(
    //                                      [method]    => array-storage-field-slug
    //                                      [args]      => parent_key
    //                                      )
    //                                  )
    //                              [attributes] => Array()
    //                              [rules] => Array(
    //                                  [required] => Array(
    //                                      [0] => error
    //                                      [1] => Field is required
    //                                      )
    //                                  )
    //                              [type_specific_args] => Array(
    //                                  [options_getter_function] => Array(
    //                                      [function_name] => \researchAssistant_byFernTec_datasetManagerDatasetDefs_categories\get_options_for_project_selector
    //                                      [extra_args] =>
    //                                      )
    //                                  )
    //                              [constraints] => Array(
    //                                  [0] => Array(
    //                                              [method] => unique-key
    //                                              )
    //                                  )
    //                              )
    //
    //                  ...
    //
    //                  [5] => Array(
    //                              [form_field_name]       => cancel
    //                              [zebra_control_type]    => button
    //                              [label]                 => Cancel
    //                              [attributes]            => Array(
    //                                  [onclick] => window.parent.location.href="http://localhost/plugdev/wp-admin//admin.php?page=researchAssistant&action=manage-dataset&dataset_slug=categories"
    //                                  )
    //                              [rules]                 => Array()
    //                              [type_specific_args]    => Array(
    //                                  [caption]   => Cancel
    //                                  [type]      => button
    //                                  )
    //                              [constraints] => Array()
    //                              )
    //
    //                  )
    //
    //              [focus_field_slug] => 1
    //
    //              [checked_defaulted_ok] => 1
    //
    //              )
    //
    //          [array_storage_record_structure] => Array(
    //
    //              [0] => Array(
    //                          [slug]       => created_server_datetime_UTC
    //                          [value_from] => Array(
    //                              [method] => created-server-datetime-utc
    //                              )
    //                          )
    //
    //              ...
    //
    //              [6] => Array(
    //                          [slug]       => notes_slash_comments
    //                          [value_from] => Array(
    //                              [method] => post
    //                              [instance] => notes_slash_comments
    //                              )
    //                          )
    //
    //              [checked_defaulted_ok] => 1
    //
    //              )
    //
    //          [array_storage_key_field_slug] => key
    //
    //          )
    //
    // -------------------------------------------------------------------------

//\greatKiwi_basepressLogger\pr( $selected_datasets_dmdd ) ;

    // =========================================================================
    // Init.
    // =========================================================================

    $ns = __NAMESPACE__ ;
    $fn = __FUNCTION__ ;

    // =========================================================================
    // LOAD Zebra Forms...
    // =========================================================================

    require_once( $caller_apps_includes_dir . '/Zebra_Form-master/Zebra_Form.php' ) ;

    // =========================================================================
    // Zebra-Form field types and their parameters:-
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

    // =========================================================================
    // Get the ARRAY STORAGE FIELD SLUGS...
    // =========================================================================

    $array_storage_field_slugs = array() ;

    foreach ( $selected_datasets_dmdd['array_storage_record_structure'] as $this_field ) {

        //  TODO Error Checking ???

        $array_storage_field_slugs[] = $this_field['slug'] ;

    }

    // =========================================================================
    // Make the FORM...
    // =========================================================================

    // -------------------------------------------------------------------------
    // void __construct ( string $name , [ string $method = 'POST'] , [ string $action = ''] , [ array $attributes = ''] )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // Initializes the form.
    //
    //      $form = new Zebra_Form('myform');
    //
    // PARAMETERS
    //
    //      string  $name
    //                  Name of the form
    //
    //      string  $method
    //                  (Optional) Specifies which HTTP method will be used to
    //                  submit the form data set.
    //
    //                  Possible (case-insensitive) values are POST and GET
    //
    //                  Default is POST
    //
    //      string  $action
    //                  (Optional) An URI to where to submit the form data set.
    //
    //                  If left empty, the form will submit to itself.
    //
    //                  You should *always* submit the form to itself, or
    //                  server-side validation will not take place and you will
    //                  have a great security risk. Submit the form to itself,
    //                  let it do the server-side validation, and then redirect
    //                  accordingly!
    //
    //      array   $attributes
    //                  (Optional) An array of attributes valid for a <form> tag
    //                  (i.e. style)
    //
    //                  Note that the following attributes are automatically set
    //                  when the control is created and should not be altered
    //                  manually:
    //
    //                      action, method, enctype, name
    // -------------------------------------------------------------------------

    // -------------------------------------------------------------------------
    // $selected_datasets_dmdd['zebra_form']['form_specs'] = Array(
    //      [name]                  => add_edit_project
    //      [method]                => POST
    //      [action]                =>
    //      [attributes]            => Array()
    //      [clientside_validation] => 1
    //      )
    // -------------------------------------------------------------------------

    // -------------------------------------------------------------------------
    // Instantiate the form...
    // -------------------------------------------------------------------------

    $form_specs = $selected_datasets_dmdd['zebra_forms'][ $form_slug_underscored ]['form_specs'] ;

    // -------------------------------------------------------------------------

    $zebra_form = new \Zebra_Form(
                    $form_specs['name']             ,
                    $form_specs['method']           ,
                    $form_specs['action']           ,
                    $form_specs['attributes']
                    ) ;

    // =========================================================================
    // GET the RECORD TO BE EDITED (if necessary)...
    // =========================================================================

    if ( $question_adding ) {

        // =====================================================================
        // ADDING
        // =====================================================================

        $the_record        = NULL ;
        $the_records_index = NULL ;

        // ---------------------------------------------------------------------

    } else {

        // =====================================================================
        // EDITING
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
            return $result ;
        }

        // ---------------------------------------------------------------------

        list(
            $the_record             ,
            $the_records_index
            ) = $result ;

//echo '<br />' ;
//foreach ( $the_record as $name => $value ) {
//    echo '<br />' , $name , ' --- ' , $value , ' --- ' , gettype( $value ) ;
//}
//echo '<br />' ;

        // =====================================================================
        // Do any BASE 64 DECODING required...
        // =====================================================================

        foreach ( $selected_datasets_dmdd['array_storage_record_structure'] as $field_index => $field_data ) {

            // -----------------------------------------------------------------

            if ( ! is_array( $field_data ) ) {
                continue ;
                    //  Skip the:-
                    //      "checked_defaulted_ok"
                    //  field.
            }

            // -----------------------------------------------------------------

            if ( ! array_key_exists( $field_data['slug'] , $the_record ) ) {

                $field_number = $field_index + 1 ;

                $safe_field_slug = htmlentities( $field_data['slug'] ) ;

                return <<<EOT
PROBLEM base64 decoding field value:&nbsp; No field# {$field_number} ("{$safe_field_slug}") in record to be edited
Dataset:&nbsp; "{$dataset_title}"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

            }

            // -----------------------------------------------------------------

            if ( in_array( $field_index , $array_storage_field_indices_to_base64_encode_pre_check , TRUE ) ) {
                $the_record[ $field_data['slug'] ] = base64_decode( $the_record[ $field_data['slug'] ] ) ;
            }

            // -----------------------------------------------------------------

        }

        // ---------------------------------------------------------------------

//pr( $the_record ) ;

    }

    // =========================================================================
    // Define the Zebra Form controls that have no "default value"...
    // =========================================================================

//  $zebra_controls_with_no_default_value = array(
//                                              'submit'        ,
//                                              'button'
//                                              ) ;

    // =========================================================================
    // ADD the ZEBRA FORM FIELDS (to the form definition)...
    // =========================================================================

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $selected_datasets_dmdd['zebra_forms'][ $form_slug_underscored ]['field_specs'] = array(
    //
    //          array(
    //              'form_field_name'       =>  'category_key'              ,
    //              'zebra_control_type'    =>  'select'                    ,
    //              'label'                 =>  'Project &amp; Category'    ,
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
    //                      'function_name' =>  '\\researchAssistant_byFernTec_datasetManagerDatasetDefs_reference_urls\\get_options_for_project_selector'  ,
    //                      'extra_args'    =>  NULL
    //                      )
    //                  )
    //              )   ,
    //
    //          array(
    //              'form_field_name'       =>  'title'     ,
    //              'zebra_control_type'    =>  'text'      ,
    //              'label'                 =>  'Title'     ,
    //              'default_value'         =>  NULL        ,
    //              'attributes'            =>  array()     ,
    //              'rules'                 =>  array(
    //                  'required'  =>  array(
    //                                      'error'             ,   // variable to add the error message to
    //                                      'Field is required'     // error message if value doesn't validate
    //                                      )
    //                  )
    //              )   ,
    //
    //          array(
    //              'form_field_name'       =>  'notes_slash_comments'      ,
    //              'zebra_control_type'    =>  'textarea'                  ,
    //              'label'                 =>  'Project Notes/Comments'    ,
    //              'default_value'         =>  NULL                        ,
    //              'attributes'            =>  array()                     ,
    //              'rules'                 =>  array()
    //              )   ,
    //
    //          array(
    //              'form_field_name'       =>  'save_me'                   ,
    //              'zebra_control_type'    =>  'submit'                    ,
    //              'label'                 =>  NULL                        ,
    //              'default_value'         =>  NULL                        ,
    //              'attributes'            =>  array()                     ,
    //              'rules'                 =>  array()
    //              'type_specific_args'    =>  array(
    //                  'caption'       =>  'Submit'
    //                  )
    //              )   ,
    //
    //          array(
    //              'form_field_name'           =>  'cancel'                    ,
    //              'zebra_control_type'        =>  'button'                    ,
    //              'label'                     =>  NULL                        ,
    //              'default_value'             =>  NULL                        ,
    //              'attributes'                =>  array(
    //                                                  'onclick'   =>  'location.href="' . $cancel_href . '"'
    //                                                  )   ,
    //              'rules'                     =>  array()                     ,
    //              'type_specific_args'        =>  array(
    //                  'caption'       =>  '<span style="position:relative; top:-6px">Cancel</span>'    ,
    //                  'type'          =>  'button'
    //                  )
    //              )
    //
    //          )
    //
    // -------------------------------------------------------------------------

    foreach ( $selected_datasets_dmdd['zebra_forms'][ $form_slug_underscored ]['field_specs'] as $zebra_form_field_index => $zebra_form_field_details ) {

        // ---------------------------------------------------------------------

        $zebra_form_field_number = $zebra_form_field_index + 1 ;

        $field_title = \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_stringUtils\to_title( $zebra_form_field_details['form_field_name'] ) ;

        // =====================================================================
        // Field ERROR CHECKING and DEFAULTS...
        // =====================================================================

        //  See:  check-and-default-zebra-form-definition.php

        // :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
        // ADD this field ?
        // :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

        // ---------------------------------------------------------------------
        // Here we should have (eg):-
        //
        //      $zebra_form_field_details = Array(
        //          [form_field_name]       => email
        //          [zebra_control_type]    => text
        //          [label]                 => Email
        //          [attributes]            => Array()
        //          [rules]                 => Array(
        //              [required] => Array(
        //                  [0] => error
        //                  [1] => Field is required
        //                  )
        //              )
        //          [display_options]       => Array(
        //              [question_show_me_function_name] => \greatKiwi_byFernTec_basepressUsers_v0x1_datasetDef_users\question_show_email
        //              )
        //          [value_from] => Array(
        //              [add] => Array(
        //                  [method]    => literal
        //                  [args]      =>
        //                  )
        //              [edit] => Array(
        //                  [method]    => array-storage-field-slug
        //                  [args]      => email
        //                  )
        //              )
        //          [type_specific_args]    => Array()
        //          [constraints]           => Array()
        //          )
        //
        // ---------------------------------------------------------------------

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $zebra_form_field_details ) ;

        // ---------------------------------------------------------------------

        if (    array_key_exists( 'display_options' , $zebra_form_field_details )
                &&
                is_array( $zebra_form_field_details['display_options'] )
                &&
                array_key_exists( 'question_show_me_function_name' , $zebra_form_field_details['display_options'] )
                &&
                is_string( $zebra_form_field_details['display_options']['question_show_me_function_name'] )
                &&
                trim( $zebra_form_field_details['display_options']['question_show_me_function_name'] ) !== ''
                &&
                strlen( $zebra_form_field_details['display_options']['question_show_me_function_name'] ) <= 512
                &&
                function_exists( $zebra_form_field_details['display_options']['question_show_me_function_name'] )
            ) {

            // -------------------------------------------------------------------------
            // my_custom_question_show_me_function(
            //      $home_page_title                        ,
            //      $caller_apps_includes_dir               ,
            //      $all_application_dataset_definitions    ,
            //      $dataset_slug                           ,
            //      $question_front_end                     ,
            //      $display_options                        ,
            //      $submission_options                     ,
            //      $selected_datasets_dmdd                 ,
            //      $dataset_title                          ,
            //      $dataset_records                        ,
            //      $record_indices_by_key                  ,
            //      $question_adding                        ,
            //      $zebra_form_field_index                 ,
            //      $zebra_form_field_number                ,
            //      $zebra_form_field_details
            //      )
            // - - - - - - - - - - - - - - - - - - - - - - -
            // RETURNS
            //      o   On SUCCESS!
            //          - - - - - -
            //          TRUE or FALSE
            //
            //      o   On FAILURE!
            //          - - - - - -
            //          $error_message STRING
            // -------------------------------------------------------------------------

            $result = $zebra_form_field_details['display_options']['question_show_me_function_name'](
                            $home_page_title                        ,
                            $caller_apps_includes_dir               ,
                            $all_application_dataset_definitions    ,
                            $dataset_slug                           ,
                            $question_front_end                     ,
                            $display_options                        ,
                            $submission_options                     ,
                            $selected_datasets_dmdd                 ,
                            $dataset_title                          ,
                            $dataset_records                        ,
                            $record_indices_by_key                  ,
                            $question_adding                        ,
                            $zebra_form_field_index                 ,
                            $zebra_form_field_number                ,
                            $zebra_form_field_details
                            ) ;

            // -----------------------------------------------------------------

            if ( is_string( $result ) ) {
                return $result ;
            }

            // -----------------------------------------------------------------

            if ( $result !== TRUE ) {
                continue ;
                    //  Skip this field
            }

            // -----------------------------------------------------------------

        }

        // :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
        // ADD the FIELD (to the FORM definition...
        // :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

        // =====================================================================
        // Create the standard:-
        //      $field_args
        //
        // (with the values used by most Zebra Form field types).
        //
        // NOTE!
        // -----
        // We'll add to or replace the standard values with the Zebra Form
        // field type specific values - as required - below...
        // =====================================================================

        $zebra_form_add_field_args = array() ;

        // ---------------------------------------------------------------------
        // id
        // ---------------------------------------------------------------------

        $zebra_form_add_field_args['id'] = $zebra_form_field_details['form_field_name'] ;

        // ---------------------------------------------------------------------
        // default
        // ---------------------------------------------------------------------

        if ( ! in_array(
                    $zebra_form_field_details['zebra_control_type']     ,
                    get_zebra_controls_with_no_default_value()          ,
                    TRUE
                    )
            ) {

            // -------------------------------------------------------------------------
            // get_field_value_for_zebra_form(
            //      $home_page_title                        ,
            //      $caller_apps_includes_dir               ,
            //      $all_application_dataset_definitions    ,
            //      $dataset_slug                           ,
            //      $selected_datasets_dmdd                 ,
            //      $dataset_title                          ,
            //      $dataset_records                        ,
            //      $record_indices_by_key                  ,
            //      $question_adding                        ,
            //      $zebra_form_field_number                ,
            //      $zebra_form_field_details               ,
            //      $the_record                             ,
            //      $the_records_index                      ,
            //      $array_storage_field_slugs
            //      )
            // - - - - - - - - - - - - - - - - - - - - - - -
            // RETURNS
            //      o   On SUCCESS!
            //          - - - - - -
            //          array(
            //              $ok = TRUE                      ,
            //              $field_value <any PHP type>
            //              )
            //
            //      o   On FAILURE!
            //          - - - - - -
            //          array(
            //              $ok = FALSE             ,
            //              $error_message STRING
            //              )
            // -------------------------------------------------------------------------

            $result = get_field_value_for_zebra_form(
                            $home_page_title                        ,
                            $caller_apps_includes_dir               ,
                            $all_application_dataset_definitions    ,
                            $dataset_slug                           ,
                            $selected_datasets_dmdd                 ,
                            $dataset_title                          ,
                            $dataset_records                        ,
                            $record_indices_by_key                  ,
                            $question_adding                        ,
                            $zebra_form_field_number                ,
                            $zebra_form_field_details               ,
                            $the_record                             ,
                            $the_records_index                      ,
                            $array_storage_field_slugs
                            ) ;

            // -----------------------------------------------------------------

            list( $ok , $field_value ) = $result ;

            // -----------------------------------------------------------------

            if ( $ok !== TRUE ) {
                return $field_value ;
            }

            // -----------------------------------------------------------------

            $zebra_form_add_field_args['default'] = $field_value ;

            // -----------------------------------------------------------------

        }

        // ---------------------------------------------------------------------
        // atttributes
        // ---------------------------------------------------------------------

        if ( array_key_exists( 'attributes' , $zebra_form_field_details ) ) {
            $zebra_form_add_field_args['attributes'] = $zebra_form_field_details['attributes'] ;

        } else {
            $zebra_form_add_field_args['attributes'] = array() ;

        }

        // ---------------------------------------------------------------------
        // dynamic_atttributes
        // ---------------------------------------------------------------------

        // ---------------------------------------------------------------------
        // Here we should have (eg):-
        //
        //      $zebra_form_field_details['dynamic_attributes'] = array(
        //          'onclick'       =>  array(
        //              'function_name'     =>  $get_cancel_button_onclick_attribute_value_function_name    ,
        //              'extra_args'        =>  NULL
        //              )
        //          )
        //
        // ---------------------------------------------------------------------

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $zebra_form_field_details ) ;

        if ( array_key_exists( 'dynamic_attributes' , $zebra_form_field_details ) ) {

            // -----------------------------------------------------------------

            if ( ! is_array( $zebra_form_field_details['dynamic_attributes'] ) ) {

                return <<<EOT
PROBLEM: Bad Zebra Form field "dynamic_attributes" (array expected)
For dataset:&nbsp; "{$dataset_title}"
and Zebra Form field:&nbsp; {$field_title}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

            }

            // -----------------------------------------------------------------

            $attribute_number = 1 ;

            // -----------------------------------------------------------------

            foreach ( $zebra_form_field_details['dynamic_attributes'] as $attribute_name => $attribute_details ) {

//          get_attribute_value_function_name ) {

                // -------------------------------------------------------------

                if (    ! is_string( $attribute_name )
                        ||
                        trim( $attribute_name ) === ''
                    ) {

                    return <<<EOT
PROBLEM: Bad Zebra Form field "dynamic_attributes" + attribute# {$attribute_number} + &lt;attribute_name&gt;" (non-blank string expected)
For dataset:&nbsp; "{$dataset_title}"
and Zebra Form field:&nbsp; {$field_title}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

                }

                // -------------------------------------------------------------

                $safe_attribute_name = htmlentities( $attribute_name ) ;

                // -------------------------------------------------------------

                if ( ! is_array( $attribute_details ) ) {

                    return <<<EOT
PROBLEM: Bad Zebra Form field "dynamic_attributes" + attribute# {$attribute_number} ("{$safe_attribute_name}") (array expected)
For dataset:&nbsp; "{$dataset_title}"
and Zebra Form field:&nbsp; {$field_title}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

                }

                // -------------------------------------------------------------

                if ( ! array_key_exists( 'function_name' , $attribute_details ) ) {

                    return <<<EOT
PROBLEM: Bad Zebra Form field "dynamic_attributes" + attribute# {$attribute_number} ("{$safe_attribute_name}" - no "function_name")
For dataset:&nbsp; "{$dataset_title}"
and Zebra Form field:&nbsp; {$field_title}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

                }

                // -------------------------------------------------------------

                if (    ! is_string( $attribute_details['function_name'] )
                        ||
                        trim( $attribute_details['function_name'] ) === ''
                    ) {

                    return <<<EOT
PROBLEM: Bad Zebra Form field "dynamic_attributes" + attribute# {$attribute_number} ("{$safe_attribute_name}") + "function_name" (non-blank string expected)
For dataset:&nbsp; "{$dataset_title}"
and Zebra Form field:&nbsp; {$field_title}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

                }

                // -------------------------------------------------------------

                if ( ! function_exists( $attribute_details['function_name'] ) ) {

                    return <<<EOT
PROBLEM: Bad Zebra Form field "dynamic_attributes" + attribute# {$attribute_number} ("{$safe_attribute_name}") + "function_name" (no such function)
For dataset:&nbsp; "{$dataset_title}"
and Zebra Form field:&nbsp; {$field_title}
and attribute:&nbsp; {$safe_attribute_name}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

                }

                // -------------------------------------------------------------

                if ( array_key_exists( 'extra_args' , $attribute_details ) ) {
                    $extra_args = $attribute_details['extra_args'] ;

                } else {
                    $extra_args = NULL ;

                }

                // -------------------------------------------------------------------------
                // <my_custom_get_attribute_value_function>(
                //      $home_page_title                                            ,
                //      $caller_apps_includes_dir                                   ,
                //      $all_application_dataset_definitions                        ,
                //      $dataset_slug                                               ,
                //      $question_front_end                                         ,
                //      $display_options                                            ,
                //      $submission_options                                         ,
                //      $selected_datasets_dmdd                                     ,
                //      $dataset_title                                              ,
                //      $dataset_records                                            ,
                //      $record_indices_by_key                                      ,
                //      $question_adding                                            ,
                //      $form_slug_underscored                                      ,
                //      $array_storage_field_indices_to_base64_encode_pre_check     ,
                //      $zebra_form_field_number                                    ,
                //      $zebra_form_field_details                                   ,
                //      $the_record                                                 ,
                //      $the_records_index                                          ,
                //      $array_storage_field_slugs                                  ,
                //      $extra_args
                //      )
                // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
                // RETURNS
                //      o   On SUCCESS!
                //              $attribute_value STRING
                //
                //      o   On FAILURE!
                //              ARRAY( $error_message STRING )
                // -------------------------------------------------------------------------

                $result = $attribute_details['function_name'](
                                $home_page_title                                            ,
                                $caller_apps_includes_dir                                   ,
                                $all_application_dataset_definitions                        ,
                                $dataset_slug                                               ,
                                $question_front_end                                         ,
                                $display_options                                            ,
                                $submission_options                                         ,
                                $selected_datasets_dmdd                                     ,
                                $dataset_title                                              ,
                                $dataset_records                                            ,
                                $record_indices_by_key                                      ,
                                $question_adding                                            ,
                                $form_slug_underscored                                      ,
                                $array_storage_field_indices_to_base64_encode_pre_check     ,
                                $zebra_form_field_number                                    ,
                                $zebra_form_field_details                                   ,
                                $the_record                                                 ,
                                $the_records_index                                          ,
                                $array_storage_field_slugs                                  ,
                                $extra_args
                                ) ;

                // -------------------------------------------------------------

                if ( is_array( $result ) ) {
                    return $result[0] ;
                }

                // -------------------------------------------------------------

                $zebra_form_add_field_args['attributes'][ $attribute_name ] =
                    $result
                    ;

                // -------------------------------------------------------------

                $attribute_number++ ;

                // -------------------------------------------------------------

            }

            // -----------------------------------------------------------------

        }

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $zebra_form_add_field_args ) ;

        // ---------------------------------------------------------------------
        // onfocus / onblur
        // ---------------------------------------------------------------------

        $onfocus = <<<EOT
greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager_addEditRecord_zebraForm_onfocus(this)
EOT;

        // ---------------------------------------------------------------------

        if ( isset( $zebra_form_add_field_args['attributes']['onfocus'] ) ) {
            $zebra_form_add_field_args['attributes']['onfocus'] += ';' + $onfocus ;

        } else {
            $zebra_form_add_field_args['attributes']['onfocus'] = $onfocus ;

        }

        // ---------------------------------------------------------------------

        $onblur = <<<EOT
greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager_addEditRecord_zebraForm_onblur(this)
EOT;

        // ---------------------------------------------------------------------

        if ( isset( $zebra_form_add_field_args['attributes']['onblur'] ) ) {
            $zebra_form_add_field_args['attributes']['onblur'] += ';' + $onblur ;

        } else {
            $zebra_form_add_field_args['attributes']['onblur'] = $onblur ;

        }

        // ---------------------------------------------------------------------

//\greatKiwi_basepressLogger\pr( $zebra_form_add_field_args ) ;

        // =====================================================================
        // Create the standard:-
        //      $zebra_form_field_label_args
        //
        // (with the values used by most Zebra Form field types).
        //
        // NOTE!
        // -----
        // We'll add to or replace the standard values with the Zebra Form
        // field type specific values - as required - below...
        // =====================================================================

        // -------------------------------------------------------------------------
        // void __construct ( string $id , string $attach_to , mixed $caption , [ array $attributes = ''] )
        // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
        // Add an <LABEL> control to the form.
        //
        // Do not instantiate this class directly! Use the add() method instead!
        //
        // PARAMETERS
        //
        //      string  $id
        //          Unique name to identify the control in the form.
        //
        //          This is the name of the variable to be used in the template
        //          file, containing the generated HTML for the control.  Eg; in a
        //          template file, in order to print the generated HTML for a
        //          control named "my_label", one would use:
        //
        //              echo $my_label;
        //
        //      string  $attach_to
        //          The id attribute of the control to attach the note to.
        //
        //          Notice that this must be the "id" attribute of the control you
        //          are attaching the label to, and not the "name" attribute!
        //
        //          This is important as while most of the controls have their id
        //          attribute set to the same value as their name attribute, for
        //          checkboxes, selects and radio buttons this is different.
        //
        //          Exception to the rule:
        //
        //              o   Just like in the case of notes, if you want a master
        //                  label, a label that is attached to a group of
        //                  checkboxes/radio buttons rather than individual
        //                  controls, this attribute must instead refer to the name
        //                  of the controls (which, for groups of checkboxes/radio
        //                  buttons, is one and the same). This is important because
        //                  if the group of checkboxes/radio buttons have the
        //                  required rule set, this is the only way in which the
        //                  "required" symbol (the red asterisk) will be attached to
        //                  the master label instead of being attached to the first
        //                  checkbox/radio button from the group.
        //
        //      mixed   $caption
        //          Caption of the label.
        //
        //          Putting a $ (dollar) sign before a character will turn that
        //          specific character into the accesskey. If you need the dollar
        //          sign in the label, escape it with \ (backslash)
        //
        //      array   $attributes
        //          (Optional) An array of attributes valid for label elements
        //          (style, etc)
        //
        //          Must be specified as an associative array, in the form of
        //          attribute => value.
        //
        //          SPECIAL ATTRIBUTE:
        //
        //          When setting the special attribute inside to true, the label
        //          will appear inside the control is attached to (if the control
        //          the label is attached to is a textbox or a textarea) and will
        //          disappear when the control will receive focus. When the "inside"
        //          attribute is set to TRUE, the label will not be available in the
        //          template file as it will be contained by the control the label
        //          is attached to!
        //
        //              $form->add('label', 'my_label', 'my_control', 'My Label:', array('inside' => true));
        //
        //          Sometimes, when using floats, the inside-labels will not be
        //          correctly positioned as jQuery will return invalid numbers for
        //          the parent element's position; If this is the case, make sure
        //          you enclose the form in a div with position:relative to fix this
        //          issue.
        //
        //          See set_attributes() on how to set attributes, other than
        //          through the constructor.
        //
        //          The following attributes are automatically set when the control
        //          is created and should not be altered manually:
        //
        //              id, for
        // -------------------------------------------------------------------------

        $zebra_form_field_label_args = array(
            'id'            =>  'label_for_' . $zebra_form_field_details['form_field_name']     ,
            'attach_to'     =>  $zebra_form_add_field_args['id']                                ,
            'caption'       =>  $zebra_form_field_details['label']                              ,
            'attributes'    =>  array()
            ) ;

        // =====================================================================
        // Create the:-
        //      $zebra_form_field_note_args
        //
        // (if necessary)...
        // =====================================================================

        // -------------------------------------------------------------------------
        // void __construct ( string $id , string $attach_to , string $caption , [ array $attributes = ''] )
        // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
        // Adds a "note" to the form, attached to a control.
        //
        // Do not instantiate this class directly! Use the add() method instead!
        //
        //      string  $id
        //          Unique name to identify the control in the form.
        //
        //          This is the name of the variable to be used in the template
        //          file, containing the generated HTML for the control.
        //
        //          // in a template file, in order to print the generated HTML
        //          // for a control named "my_note", one would use:
        //          echo $my_note;
        //
        //      string  $attach_to
        //          The id attribute of the control to attach the note to.
        //
        //          Notice that this must be the "id" attribute of the control you
        //          are attaching the label to, and not the "name" attribute!
        //
        //          This is important as while most of the controls have their id
        //          attribute set to the same value as their name attribute, for
        //          checkboxes, selects and radio buttons this is different.
        //
        //          Exception to the rule:
        //
        //              Just like in the case of labels, if you want a master note,
        //              a note that is attached to a group of checkboxes/radio
        //              buttons rather than individual controls, this attribute must
        //              instead refer to the name of the controls (which, for groups
        //              of checkboxes/radio buttons, is one and the same).
        //
        //      string  $caption
        //          Content of the note (can be both plain text and/or HTML)
        //
        //      array   $attributes
        //          (Optional) An array of attributes valid for div elements (style,
        //          etc)
        //
        //          Must be specified as an associative array, in the form of
        //          attribute => value.
        //
        //              // setting the "style" attribute
        //              $obj = $form->add(
        //                  'note',
        //                  'note_my_text',
        //                  'my_text',
        //                  array(
        //                      'style' => 'width:250px'
        //                  )
        //              );
        //
        //          See set_attributes() on how to set attributes, other than
        //          through the constructor.
        //
        //          The following attributes are automatically set when the control
        //          is created and should not be altered manually:
        //              class
        // -------------------------------------------------------------------------

        unset( $zebra_form_field_note_args ) ;

        // ---------------------------------------------------------------------

        if (    array_key_exists( 'help_text' , $zebra_form_field_details )
                &&
                $zebra_form_field_details['help_text'] !== NULL
            ) {

            // -----------------------------------------------------------------

            if ( ! is_string( $zebra_form_field_details['help_text'] ) ) {

                return <<<EOT
PROBLEM: Bad "help_text" (string expected)
For dataset:&nbsp; "{$dataset_title}"
and Zebra Form field:&nbsp; {$field_title}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

            }

            // -----------------------------------------------------------------

            if ( trim( $zebra_form_field_details['help_text'] ) !== '' ) {

                $caption = <<<EOT
<div style="margin-bottom:0.35em; font-size:120%; color:#333333">{$zebra_form_field_details['help_text']}</div>
EOT;

                $zebra_form_field_note_args = array(
                    'id'            =>  'note_for_' . $zebra_form_field_details['form_field_name']      ,
                    'attach_to'     =>  $zebra_form_add_field_args['id']                                ,
                    'caption'       =>  $caption                                                        ,
                    'attributes'    =>  array()
                    ) ;

            }

            // -----------------------------------------------------------------

        }

        // =====================================================================
        // ADD the FIELD proper (overridding any of the default Zebra Form
        // field properties, as required)...
        // =====================================================================

        if ( $zebra_form_field_details['zebra_control_type'] === 'text' ) {

            // :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
            // TEXT...
            // :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

            // ---------------------------------------------------------------------
            // void __construct ( string $id , [ string $default = ''] , [ array $attributes = ''] )
            //  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -
            // Adds an <input type="text"> control to the form.
            //
            // Do not instantiate this class directly! Use the add() method instead!
            //
            // PARAMETERS
            //
            //      string  $id
            //          Unique name to identify the control in the form.
            //
            //          The control's name attribute will be the same as the id
            //          attribute!
            //
            //          This is the name to be used when referring to the control's
            //          value in the POST/GET superglobals, after the form is
            //          submitted.
            //
            //          This is also the name of the variable to be used in custom
            //          template files, in order to display the control.  Ie; in a
            //          template file, in order to print the generated HTML for a
            //          control named "my_text", one would use:
            //
            //              echo $my_text;
            //
            //      string  $default
            //          (Optional) Default value of the text box.
            //
            //      array   $attributes
            //          (Optional) An array of attributes valid for input controls
            //          (size, readonly, style, etc)
            //
            //          Must be specified as an associative array, in the form of
            //          attribute => value.
            //
            //          There's a special data-prefix attribute that you can use to
            //          add uneditable prefixes to input fields (text, images, or
            //          plain HTML), as seen in the image below. It works by
            //          injecting an absolutely positioned element into the DOM,
            //          right after the parent element, and then positioning it on
            //          the left side of the parent element and adjusting the width
            //          and the left padding of the parent element, so it looks like
            //          the prefix is part of the parent element.
            //
            //          If the prefix is plain text or HTML code, it will be
            //          contained in a <div> tag having the class
            //          Zebra_Form_Input_Prefix; if the prefix is a path to an
            //          image, it will be an <img> tag having the class
            //          Zebra_Form_Input_Prefix.
            //
            //          For anything other than plain text, you must use CSS to set
            //          the width and height of the prefix, or it will not be
            //          correctly positioned because when the image is not cached by
            //          the browser the code taking care of centering the image will
            //          be executed before the image is loaded by the browser and it
            //          will not know the image's width and height!
            //
            //          // add simple text
            //          // style the text through the Zebra_Form_Input_Prefix class
            //          $form->add('text', 'my_text', '', array('data-prefix' => 'http://'));
            //          $form->add('text', 'my_text', '', array('data-prefix' => '(+1 917)'));
            //
            //          // add images
            //          // set the image's width and height through the img.Zebra_Form_Input_Prefix class
            //          // in your CSS or the image will not be correctly positioned!
            //          $form->add('text', 'my_text', '', array('data-prefix' => 'img:path/to/image'));
            //
            //          // add html - useful when using sprites
            //          // again, make sure that you set somewhere the width and height of the prefix!
            //          $form->add('text', 'my_text', '', array('data-prefix' => '<div class="sprite image1"></div>'));
            //          $form->add('text', 'my_text', '', array('data-prefix' => '<div class="sprite image2"></div>'));
            //
            //          See set_attributes() on how to set attributes, other than
            //          through the constructor.
            //
            //          The following attributes are automatically set when the
            //          control is created and should not be altered manually:
            //
            //              type, id, name, value, class
            // ---------------------------------------------------------------------

            // -----------------------------------------------------------------
            // ADD the FIELD...
            // -----------------------------------------------------------------

            $zebra_form->add(   'label'                                         ,
                                $zebra_form_field_label_args['id']              ,
                                $zebra_form_field_label_args['attach_to']       ,
                                $zebra_form_field_label_args['caption']         ,
                                $zebra_form_field_label_args['attributes']
                                ) ;

            // -----------------------------------------------------------------

            if ( isset( $zebra_form_field_note_args ) ) {

                $zebra_form->add(   'note'                                          ,
                                    $zebra_form_field_note_args['id']               ,
                                    $zebra_form_field_note_args['attach_to']        ,
                                    $zebra_form_field_note_args['caption']          ,
                                    $zebra_form_field_note_args['attributes']
                                    ) ;

            }

            // -----------------------------------------------------------------

            $field_obj = $zebra_form->add(  'text'                                      ,
                                            $zebra_form_add_field_args['id']            ,
                                            $zebra_form_add_field_args['default']       ,
                                            $zebra_form_add_field_args['attributes']
                                            ) ;
                                            //  Returns a reference to the newly created object

            // -----------------------------------------------------------------

            if (    isset( $zebra_form_field_details['rules'] )
                    &&
                    is_array( $zebra_form_field_details['rules'] )
                ) {
                $field_obj->set_rule( $zebra_form_field_details['rules'] ) ;
            }

            // -----------------------------------------------------------------

        } elseif ( $zebra_form_field_details['zebra_control_type'] === 'password' ) {

            // :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
            // PASSWORD...
            // :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

            // -------------------------------------------------------------------------
            // void __construct ( string $id , [ string $default = ''] , [ array $attributes = ''] )
            // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
            // Adds an <input type="password"> control to the form.
            //
            // Do not instantiate this class directly! Use the add() method instead!
            //
            //      string  $id
            //          Unique name to identify the control in the form.
            //
            //          The control's name attribute will be the same as the id attribute!
            //
            //          This is the name to be used when referring to the control's
            //          value in the POST/GET superglobals, after the form is submitted.
            //
            //          This is also the name of the variable to be used in custom
            //          template files, in order to display the control.
            //
            //          // in a template file, in order to print the generated HTML
            //          // for a control named "my_password", one would use:
            //              echo $my_password;
            //
            //      string  $default    (Optional) Default value of the password field.
            //
            //      array   $attributes
            //          (Optional) An array of attributes valid for input controls
            //          (size, readonly, style, etc)
            //
            //          Must be specified as an associative array, in the form of
            //          attribute => value.
            //
            //              // setting the "disabled" attribute
            //              $obj = $form->add(
            //                  'password',
            //                  'my_password',
            //                  '',
            //                  array(
            //                      'disabled' => 'disabled'
            //                  )
            //              );
            //
            //          There's a special data-prefix attribute that you can use to add
            //          uneditable prefixes to input fields (text, images, or plain
            //          HTML), as seen in the image below. It works by injecting an
            //          absolutely positioned element into the DOM, right after the
            //          parent element, and then positioning it on the left side of the
            //          parent element and adjusting the width and the left padding of
            //          the parent element, so it looks like the prefix is part of the
            //          parent element.
            //
            //          If the prefix is plain text or HTML code, it will be contained
            //          in a <div> tag having the class Zebra_Form_Input_Prefix; if the
            //          prefix is a path to an image, it will be an <img> tag having the
            //          class Zebra_Form_Input_Prefix.
            //
            //          For anything other than plain text, you must use CSS to set the
            //          width and height of the prefix, or it will not be correctly
            //          positioned because when the image is not cached by the browser
            //          the code taking care of centering the image will be executed
            //          before the image is loaded by the browser and it will not know
            //          the image's width and height!
            //
            //              // add simple text
            //              // style the text through the Zebra_Form_Input_Prefix class
            //              $form->add('password', 'my_password', '', array('data-prefix' => 'Hash:'));
            //
            //              // add images
            //              // set the image's width and height through the img.Zebra_Form_Input_Prefix class
            //              // in your CSS or the image will not be correctly positioned!
            //              $form->add('password', 'my_password', '', array('data-prefix' => 'img:path/to/image'));
            //
            //              // add html - useful when using sprites
            //              // again, make sure that you set somewhere the width and height of the prefix!
            //              $form->add('password', 'my_password', '', array('data-prefix' => '<div class="sprite image1"></div>'));
            //              $form->add('password', 'my_password', '', array('data-prefix' => '<div class="sprite image2"></div>'));
            //
            //          See set_attributes() on how to set attributes, other than
            //          through the constructor.
            //
            //          The following attributes are automatically set when the control
            //          is created and should not be altered manually:
            //
            //              type, id, name, value, class
            // -------------------------------------------------------------------------

            // -----------------------------------------------------------------
            // ADD the FIELD...
            // -----------------------------------------------------------------

            $zebra_form->add(   'label'                                         ,
                                $zebra_form_field_label_args['id']              ,
                                $zebra_form_field_label_args['attach_to']       ,
                                $zebra_form_field_label_args['caption']         ,
                                $zebra_form_field_label_args['attributes']
                                ) ;

            // -----------------------------------------------------------------

            if ( isset( $zebra_form_field_note_args ) ) {

                $zebra_form->add(   'note'                                          ,
                                    $zebra_form_field_note_args['id']               ,
                                    $zebra_form_field_note_args['attach_to']        ,
                                    $zebra_form_field_note_args['caption']          ,
                                    $zebra_form_field_note_args['attributes']
                                    ) ;

            }

            // -----------------------------------------------------------------

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $zebra_form_add_field_args ) ;

            $field_obj = $zebra_form->add(  'password'                                  ,
                                            $zebra_form_add_field_args['id']            ,
                                            $zebra_form_add_field_args['default']       ,
                                            $zebra_form_add_field_args['attributes']
                                            ) ;
                                            //  Returns a reference to the newly created object

            // -----------------------------------------------------------------

            if (    isset( $zebra_form_field_details['rules'] )
                    &&
                    is_array( $zebra_form_field_details['rules'] )
                ) {
                $field_obj->set_rule( $zebra_form_field_details['rules'] ) ;
            }

            // -----------------------------------------------------------------

        } elseif ( $zebra_form_field_details['zebra_control_type'] === 'textarea' ) {

            // :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
            // TEXTAREA...
            // :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

            // ---------------------------------------------------------------------
            // void __construct ( string $id , [ string $default = ''] , [ array $attributes = ''] )
            // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
            // Adds an <textarea> control to the form.
            //
            // Do not instantiate this class directly! Use the add() method instead!
            //
            // PARAMETERS
            //
            //      string  $id
            //          Unique name to identify the control in the form.
            //
            //          The control's name attribute will be the same as the id
            //          attribute!
            //
            //          This is the name to be used when referring to the
            //          control's value in the POST/GET superglobals, after the
            //          form is submitted.
            //
            //          This is also the name of the variable to be used in
            //          custom template files, in order to display the control.
            //          Ie; in a template file, in order to print the generated
            //          HTML for a control named "my_textarea", one would use:
            //
            //              echo $my_textarea;
            //
            //      string  $default
            //          (Optional) Default value of the textarea.
            //
            //      array   $attributes
            //          (Optional) An array of attributes valid for textarea
            //          controls (rows, cols, style, etc)
            //
            //          Must be specified as an associative array, in the form
            //          of attribute => value.
            //
            //          See set_attributes() on how to set attributes, other
            //          than through the constructor.
            //
            //          The following attributes are automatically set when the
            //          control is created and should not be altered manually:
            //
            //              id, name, class
            // ---------------------------------------------------------------------

            $zebra_form->add(   'label'                                         ,
                                $zebra_form_field_label_args['id']              ,
                                $zebra_form_field_label_args['attach_to']       ,
                                $zebra_form_field_label_args['caption']         ,
                                $zebra_form_field_label_args['attributes']
                                ) ;

            // -----------------------------------------------------------------

            if ( isset( $zebra_form_field_note_args ) ) {

                $zebra_form->add(   'note'                                          ,
                                    $zebra_form_field_note_args['id']               ,
                                    $zebra_form_field_note_args['attach_to']        ,
                                    $zebra_form_field_note_args['caption']          ,
                                    $zebra_form_field_note_args['attributes']
                                    ) ;

            }

            // -----------------------------------------------------------------

            $field_obj = $zebra_form->add(  'textarea'                                  ,
                                            $zebra_form_add_field_args['id']            ,
                                            $zebra_form_add_field_args['default']       ,
                                            $zebra_form_add_field_args['attributes']
                                            ) ;
                                            //  Returns a reference to the newly created object

            // -----------------------------------------------------------------

            if (    isset( $zebra_form_field_details['rules'] )
                    &&
                    is_array( $zebra_form_field_details['rules'] )
                ) {
                $field_obj->set_rule( $zebra_form_field_details['rules'] ) ;
            }

            // -----------------------------------------------------------------

        } elseif ( $zebra_form_field_details['zebra_control_type'] === 'checkbox' ) {

            // :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
            // CHECKBOX...
            // :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

            // -----------------------------------------------------------------
            // Here we should have (eg):-
            //
            //      $zebra_form_field_details = array(
            //          [form_field_name]       => enabled
            //          [zebra_control_type]    => checkbox
            //          [label]                 => Enabled ?
            //          [help_text]             => You can disable the use of this Gadget, if you want to.
            //          [attributes]            => Array()
            //          [rules]                 => Array()
            //          [type_specific_args]    => Array(
            //                                          [defaults_checked]  =>  TRUE    //  Defaults to FALSE
            //                                          [value]             =>  'on'    //  Defaults to "1"
            //                                          )
            //          [value_from]            => Array(
            //              [add] => Array(
            //                          [method] => literal
            //                          [args]   =>
            //                          )
            //              [edit] => Array(
            //                          [method] => array-storage-field-slug
            //                          [args]   => enabled
            //                          )
            //              )
            //          [constraints]           => Array()
            //          )
            //
            //      $zebra_form_add_field_args = Array(
            //          [id]         => enabled
            //          [default]    =>
            //          [attributes] => Array(
            //              [onfocus] => greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager_addEditRecord_zebraForm_onfocus(this)
            //              [onblur]  => greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager_addEditRecord_zebraForm_onblur(this)
            //              )
            //          )
            //
            // -----------------------------------------------------------------

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $zebra_form_field_details ) ;
//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $zebra_form_add_field_args ) ;

            // -------------------------------------------------------------------------
            // void __construct ( string $id , mixed $value , [ array $attributes = ''] )
            // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
            // Adds an <input type="checkbox"> control to the form.
            //
            // Do not instantiate this class directly! Use the add() method instead!
            //
            //      // single checkbox
            //      $obj = $form->add('checkbox', 'my_checkbox', 'my_checkbox_value');
            //
            //      // multiple checkboxes
            //      // notice that is "checkboxes" instead of "checkbox"
            //      // checkboxes values will be "0", "1" and "2", respectively, and will be available in a custom template like
            //      // "mycheckbox_0", "mycheckbox_1" and "mycheckbox_2".
            //      // label controls will be automatically created having the names "label_mycheckbox_0", "label_mycheckbox_1" and
            //      // "label_mycheckbox_2" (label + underscore + control name + underscore + value with anything else other than
            //      // letters and numbers replaced with an underscore)
            //      // $obj is a reference to the first checkbox
            //      $obj = $form->add('checkboxes', 'mycheckbox',
            //          array(
            //              'Value 1',
            //              'Value 2',
            //              'Value 3'
            //          )
            //      );
            //
            //      // multiple checkboxes with specific indexes
            //      // checkboxes values will be "v1", "v2" and "v3", respectively, and will be available in a custom template like
            //      // "mycheckbox_v1", "mycheckbox_v2" and "mycheckbox_v3".
            //      // label controls will be automatically created having the names "label_mycheckbox_v1", "label_mycheckbox_v2" and
            //      // "label_mycheckbox_v3" (label + underscore + control name + underscore + value with anything else other than
            //      // letters and numbers replaced with an underscore)
            //      $obj = $form->add('checkboxes', 'mycheckbox',
            //          array(
            //              'v1' => 'Value 1',
            //              'v2' => 'Value 2',
            //              'v3' => 'Value 3'
            //          )
            //      );
            //
            //      // multiple checkboxes with preselected value
            //      // "Value 2" will be the preselected value
            //      // note that for preselecting values you must use the actual indexes of the values, if available, (like
            //      // in the current example) or the default, zero-based index, otherwise (like in the next example)
            //      $obj = $form->add('checkboxes', 'mycheckbox',
            //          array(
            //              'v1'    =>  'Value 1',
            //              'v2'    =>  'Value 2',
            //              'v3'    =>  'Value 3'
            //          ),
            //          'v2'    // note the index!
            //      );
            //
            //      // "Value 2" will be the preselected value.
            //      // note that for preselecting values you must use the actual indexes of the values, if available, (like
            //      // in the example above) or the default, zero-based index, otherwise (like in the current example)
            //      $obj = $form->add('checkboxes', 'mycheckbox',
            //          array(
            //              'Value 1',
            //              'Value 2',
            //              'Value 3'
            //          ),
            //          1    // note the index!
            //      );
            //
            //      // multiple checkboxes with multiple preselected values
            //      $obj = $form->add('checkboxes', 'mycheckbox[]',
            //          array(
            //              'v1'    =>  'Value 1',
            //              'v2'    =>  'Value 2',
            //              'v3'    =>  'Value 3'
            //          ),
            //          array('v1', 'v2')
            //      );
            //
            //      // custom classes (or other attributes) can also be added to all of the elements by specifying a 4th argument;
            //      // this needs to be specified in the same way as you would by calling <a href="../Generic/Zebra_Form_Control.html#methodset_attributes">set_attributes()</a> method:
            //      $obj = $form->add('checkboxes', 'mycheckbox[]',
            //          array(
            //              '1' =>  'Value 1',
            //              '2' =>  'Value 2',
            //              '3' =>  'Value 3',
            //          ),
            //          '', // no default value
            //          array('class' => 'my_custom_class')
            //      );
            //
            // By default, for checkboxes, radio buttons and select boxes, the library
            // will prevent the submission of other values than those declared when
            // creating the form, by triggering the error: "SPAM attempt detected!".
            // Therefore, if you plan on adding/removing values dynamically, from
            // JavaScript, you will have to call the disable_spam_filter() method to
            // prevent that from happening!
            //
            //      string  $id
            //          Unique name to identify the control in the form.
            //
            //          $id needs to be suffixed with square brackets if there are more
            //          checkboxes sharing the same name, so that PHP treats them as an
            //          array!
            //
            //          The control's name attribute will be as indicated by $id
            //          argument while the control's id attribute will be $id, stripped
            //          of square brackets (if any), followed by an underscore and
            //          followed by $value with all the spaces replaced by underscores.
            //
            //          So, if the $id arguments is "my_checkbox" and the $value
            //          argument is "value 1", the control's id attribute will be
            //          my_checkbox_value_1.
            //
            //          This is the name to be used when referring to the control's
            //          value in the POST/GET superglobals, after the form is submitted.
            //
            //          This is also the name of the variable to be used in custom
            //          template files, in order to display the control.
            //
            //              // in a template file, in order to print the generated HTML
            //              // for a control named "my_checkbox" and having the value of
            //              // "value 1", one would use:
            //              echo $my_checkbox_value_1;
            //
            //          Note that when adding the required rule to a group of checkboxes
            //          (checkboxes sharing the same name), it is sufficient to add the
            //          rule to the first checkbox!
            //
            //      mixed   $value  Value of the checkbox.
            //
            //      array   $attributes
            //          (Optional) An array of attributes valid for input controls
            //          (disabled, readonly, style, etc)
            //
            //          Must be specified as an associative array, in the form of
            //          attribute => value.
            //
            //              // setting the "checked" attribute
            //              $obj = $form->add(
            //                          'checkbox',
            //                          'my_checkbox',
            //                          'v1',
            //                          array(
            //                              'checked' => 'checked'
            //                          )
            //                      ) ;
            //
            //          See set_attributes() on how to set attributes, other than
            //          through the constructor.
            //
            //          The following attributes are automatically set when the control
            //          is created and should not be altered manually:
            //
            //              type, id, name, value, class
            //
            // -------------------------------------------------------------------------

            $zebra_form->add(   'label'                                         ,
                                $zebra_form_field_label_args['id']              ,
                                $zebra_form_field_label_args['attach_to']       ,
                                $zebra_form_field_label_args['caption']         ,
                                $zebra_form_field_label_args['attributes']
                                ) ;

            // -----------------------------------------------------------------

            if ( isset( $zebra_form_field_note_args ) ) {

                $zebra_form->add(   'note'                                          ,
                                    $zebra_form_field_note_args['id']               ,
                                    $zebra_form_field_note_args['attach_to']        ,
                                    $zebra_form_field_note_args['caption']          ,
                                    $zebra_form_field_note_args['attributes']
                                    ) ;

            }

            // -----------------------------------------------------------------
            // NOTE!
            // -----
            // 1.   CHECKBOX VALUES:-
            //      o   Are stored in the ARRAY STORAGE RECORD as:-
            //              TRUE or FALSE
            //      o   Have the value "1" in the submitted form - but only if
            //          the checkbox IS checked.  If the checkbox ISN'T checked,
            //          then the checkbox ISN'T returned in the submitted form.
            //
            // 2.   The field value currently stored in:-
            //          $zebra_form_add_field_args['default']
            //
            //      is the TRUE/FALSE value from the ARRAY STORAGE RECORD.
            // -----------------------------------------------------------------

//pr( $zebra_form_add_field_args ) ;

            if (    ! $question_adding
                    &&
                    ! is_bool( $zebra_form_add_field_args['default'] )
                ) {

//              $field_title = to_title( $zebra_form_field_details['form_field_name'] ) ;

//echo '<br />' , $zebra_form_add_field_args['default'] , ' --- ' , gettype( $zebra_form_add_field_args['default'] ) ;

                return <<<EOT
PROBLEM: Bad "{$field_title}" field (in array storage record) (TRUE or FALSE expected)
For dataset:&nbsp; "{$dataset_title}"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

            }

            // -----------------------------------------------------------------

            $question_checkbox_checked = FALSE ;    //  Default
            $checkbox_value            = '1'   ;    //  Default

            // -----------------------------------------------------------------

            if ( $question_adding ) {

                // -------------------------------------------------------------
                // Adding...
                // -------------------------------------------------------------

                if ( array_key_exists( 'type_specific_args' , $zebra_form_field_details ) ) {

                    // ---------------------------------------------------------

                    if ( ! is_array( $zebra_form_field_details['type_specific_args'] ) ) {

                        return <<<EOT
PROBLEM: Bad Zebra Form field "type_specific_args" (array expected)
For dataset:&nbsp; "{$dataset_title}"
and Zebra Form field:&nbsp; {$field_title}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

                    }

                    // ---------------------------------------------------------
                    // defaults_checked ?
                    // ---------------------------------------------------------

                    if ( array_key_exists( 'defaults_checked' , $zebra_form_field_details['type_specific_args'] ) ) {

                        // -----------------------------------------------------

                        if ( ! is_bool( $zebra_form_field_details['type_specific_args']['defaults_checked'] ) ) {

                            return <<<EOT
PROBLEM: Bad Zebra Form field "type_specific_args" + "defaults_checked" (TRUE or FALSE expected)
For dataset:&nbsp; "{$dataset_title}"
and Zebra Form field:&nbsp; {$field_title}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

                        }

                        // -----------------------------------------------------

                        if ( $zebra_form_field_details['type_specific_args']['defaults_checked'] === TRUE ) {
                            $question_checkbox_checked = TRUE ;
                        }

                        // -----------------------------------------------------

                    }

                    // ---------------------------------------------------------
                    // value ?
                    // ---------------------------------------------------------

                    if ( array_key_exists( 'value' , $zebra_form_field_details['type_specific_args'] ) ) {

                        // -----------------------------------------------------

                        if ( ! is_string( $zebra_form_field_details['type_specific_args']['value'] ) ) {

                            return <<<EOT
PROBLEM: Bad Zebra Form field "type_specific_args" + "value" (string expected)
For dataset:&nbsp; "{$dataset_title}"
and Zebra Form field:&nbsp; {$field_title}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

                        }

                        // -----------------------------------------------------

                        $checkbox_value = $zebra_form_field_details['type_specific_args']['value'] ;

                        // -----------------------------------------------------

                    }

                    // ---------------------------------------------------------

                }

                // -------------------------------------------------------------

            } else {

                // -------------------------------------------------------------
                // Editing...
                // -------------------------------------------------------------

                if ( $zebra_form_add_field_args['default'] === TRUE ) {
                    $question_checkbox_checked = TRUE;
                }

                // -------------------------------------------------------------

            }

            // -----------------------------------------------------------------

            if ( $question_checkbox_checked === TRUE ) {
                $zebra_form_add_field_args['attributes']['checked'] = 'checked' ;
            }

            // -----------------------------------------------------------------

            $field_obj = $zebra_form->add(  'checkbox'                                  ,
                                            $zebra_form_add_field_args['id']            ,
                                            $checkbox_value                             ,
                                            $zebra_form_add_field_args['attributes']
                                            ) ;
                                            //  Returns a reference to the newly created object

            // -----------------------------------------------------------------

            if (    isset( $zebra_form_field_details['rules'] )
                    &&
                    is_array( $zebra_form_field_details['rules'] )
                ) {
                $field_obj->set_rule( $zebra_form_field_details['rules'] ) ;
            }

            // -----------------------------------------------------------------

        } elseif ( $zebra_form_field_details['zebra_control_type'] === 'radios' ) {

            // :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
            // RADIOS...
            // :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

            // -------------------------------------------------------------------------
            // void __construct ( string $id , mixed $value , [ array $attributes = ''] )
            // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
            // Adds an <input type="radio"> control to the form.
            //
            // Do not instantiate this class directly! Use the add() method instead!
            //
            //      // single radio button
            //      $obj = $form->add('radio', 'myradio', 'my_radio_value');
            //
            //      // multiple radio buttons
            //      // notice that is "radios" instead of "radio"
            //      // radio buttons' values will be "0", "1" and "2", respectively, and will be available in a custom template like
            //      // "myradio_0", "myradio_1" and "myradio_2".
            //      // label controls will be automatically created having the names "label_myradio_0", "label_myradio_1" and
            //      // "label_myradio_2" (label + underscore + control name + underscore + value with anything else other than
            //      // letters and numbers replaced with an underscore)
            //      // $obj is a reference to the first radio button
            //      $obj = $form->add('radios', 'myradio',
            //          array(
            //              'Value 1',
            //              'Value 2',
            //              'Value 3'
            //          )
            //      );
            //
            //      // multiple radio buttons with specific indexes
            //      // radio buttons' values will be "v1", "v2" and "v3", respectively, and will be available in a custom template
            //      // like "myradio_v1", "myradio_v2" and "myradio_v3".
            //      // label controls will be automatically created having the names "label_myradio_v1", "label_myradio_v2" and
            //      // "label_myradio_v3" (label + underscore + control name + underscore + value with anything else other than
            //      // letters and numbers replaced with an underscore)
            //      $obj = $form->add('radios', 'myradio',
            //          array(
            //              'v1' => 'Value 1',
            //              'v2' => 'Value 2',
            //              'v3' => 'Value 3'
            //          )
            //      );
            //
            //      // multiple radio buttons with preselected value
            //      // "Value 2" will be the preselected value
            //      // note that for preselecting values you must use the actual indexes of the values, if available, (like
            //      // in the current example) or the default, zero-based index, otherwise (like in the next example)
            //      $obj = $form->add('radios', 'myradio',
            //          array(
            //              'v1'    =>  'Value 1',
            //              'v2'    =>  'Value 2',
            //              'v3'    =>  'Value 3'
            //          ),
            //          'v2'    // note the index!
            //      );
            //
            //      // "Value 2" will be the preselected value.
            //      // note that for preselecting values you must use the actual indexes of the values, if available, (like
            //      // in the example above) or the default, zero-based index, otherwise (like in the current example)
            //      $obj = $form->add('radios', 'myradio',
            //          array(
            //              'Value 1',
            //              'Value 2',
            //              'Value 3'
            //          ),
            //          1    // note the index!
            //      );
            //
            //      // custom classes (or other attributes) can also be added to all of the elements by specifying a 4th argument;
            //      // this needs to be specified in the same way as you would by calling <a href="../Generic/Zebra_Form_Control.html#methodset_attributes">set_attributes()</a> method:
            //      $obj = $form->add('radios', 'myradio',
            //          array(
            //              '1' =>  'Value 1',
            //              '2' =>  'Value 2',
            //              '3' =>  'Value 3',
            //          ),
            //          '', // no default value
            //          array('class' => 'my_custom_class')
            //      );
            //
            // By default, for checkboxes, radio buttons and select boxes, the library
            // will prevent the submission of other values than those declared when
            // creating the form, by triggering the error: "SPAM attempt detected!".
            // Therefore, if you plan on adding/removing values dynamically, from
            // JavaScript, you will have to call the disable_spam_filter() method to
            // prevent that from happening!
            //
            //      string  $id
            //          Unique name to identify the control in the form.
            //
            //          The control's name attribute will be as indicated by $id
            //          argument while the control's id attribute will be $id followd by
            //          an underscore and followed by $value with all the spaces
            //          replaced by underscores.
            //
            //          So, if the $id arguments is "my_radio" and the $value argument
            //          is "value 1", the control's id attribute will be
            //          my_radio_value_1.
            //
            //          This is the name to be used when referring to the control's
            //          value in the POST/GET superglobals, after the form is submitted.
            //
            //          This is also the name of the variable to be used in custom
            //          template files, in order to display the control.
            //
            //              // in a template file, in order to print the generated HTML
            //              // for a control named "my_radio" and having the value of
            //              // "value 1", one would use:
            //              echo $my_radio_value_1;
            //
            //          Note that when adding the required rule to a group of radio
            //          buttons (radio buttons sharing the same name), it is sufficient
            //          to add the rule to the first radio button!
            //
            //      mixed   $value
            //          Value of the radio button.
            //
            //      array   $attributes
            //          (Optional) An array of attributes valid for input controls
            //          (disabled, readonly, style, etc)
            //
            //          Must be specified as an associative array, in the form of
            //          attribute => value.
            //
            //              // setting the "checked" attribute
            //              $obj = $form->add(
            //                  'radio',
            //                  'my_radio',
            //                  'v1',
            //                  array(
            //                      'checked' => 'checked'
            //                  )
            //              );
            //
            //          See set_attributes() on how to set attributes, other than
            //          through the constructor.
            //
            //          The following attributes are automatically set when the control
            //          is created and should not be altered manually:
            //
            //              type, id, name, value, class
            // -------------------------------------------------------------------------

            $zebra_form->add(   'label'                                         ,
                                $zebra_form_field_label_args['id']              ,
                                $zebra_form_field_label_args['attach_to']       ,
                                $zebra_form_field_label_args['caption']         ,
                                $zebra_form_field_label_args['attributes']
                                ) ;

            // -----------------------------------------------------------------

            if ( isset( $zebra_form_field_note_args ) ) {

                $zebra_form->add(   'note'                                          ,
                                    $zebra_form_field_note_args['id']               ,
                                    $zebra_form_field_note_args['attach_to']        ,
                                    $zebra_form_field_note_args['caption']          ,
                                    $zebra_form_field_note_args['attributes']
                                    ) ;

            }

            // -----------------------------------------------------------------
            // Here we should have (eg):-
            //
            //      $zebra_form_field_details['type_specific_args'] = Array(
            //          [radios] => Array(
            //                          [post] => Post
            //                          [page] => Page
            //                          )
            //                      )
            //
            // -----------------------------------------------------------------

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\pr( $zebra_form_field_details['type_specific_args'] ) ;

            // -----------------------------------------------------------------
            // We use the following "value" format:-
            //
            //      // multiple radio buttons with preselected value
            //      // "Value 2" will be the preselected value
            //      // note that for preselecting values you must use the actual indexes of the values, if available, (like
            //      // in the current example) or the default, zero-based index, otherwise (like in the next example)
            //      $obj = $form->add('radios', 'myradio',
            //          array(
            //              'v1'    =>  'Value 1',
            //              'v2'    =>  'Value 2',
            //              'v3'    =>  'Value 3'
            //          ),
            //          'v2'    // note the index!
            //      );
            //
            // -----------------------------------------------------------------

            $field_obj = $zebra_form->add(  'radios'                                                    ,
                                            $zebra_form_add_field_args['id']                            ,
                                            $zebra_form_field_details['type_specific_args']['radios']   ,
                                            $zebra_form_add_field_args['default']                       ,
                                            $zebra_form_add_field_args['attributes']
                                            ) ;
                                            //  Returns a reference to the newly created object

            // -----------------------------------------------------------------

            if (    isset( $zebra_form_field_details['rules'] )
                    &&
                    is_array( $zebra_form_field_details['rules'] )
                ) {
                $field_obj->set_rule( $zebra_form_field_details['rules'] ) ;
            }

            // -----------------------------------------------------------------

        } elseif ( $zebra_form_field_details['zebra_control_type'] === 'submit' ) {

            // :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
            // SUBMIT...
            // :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

            // -------------------------------------------------------------------------
            // void __construct ( string $id , string $caption , [ array $attributes = ''] )
            // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
            // Adds an <input type="submit"> control to the form.
            //
            // Do not instantiate this class directly! Use the add() method instead!
            //
            // PARAMETERS
            //
            //      string  $id
            //          Unique name to identify the control in the form.
            //
            //          The control's name attribute will be the same as the id attribute!
            //
            //          This is the name to be used when referring to the control's
            //          value in the POST/GET superglobals, after the form is submitted.
            //
            //          This is also the name of the variable to be used in custom
            //          template files, in order to display the control.  Ie; in a
            //          template file, in order to print the generated HTML for a
            //          control named "my_submit", one would use:
            //
            //              echo $my_submit;
            //
            //      string  $caption
            //          Caption of the submit button control.
            //
            //      array   $attributes
            //          (Optional) An array of attributes valid for input controls
            //          (size, readonly, style, etc)
            //
            //          Must be specified as an associative array, in the form of
            //          attribute => value.
            //
            //          See set_attributes() on how to set attributes, other than
            //          through the constructor.
            //
            //          The following attributes are automatically set when the control
            //          is created and should not be altered manually:
            //
            //              type, id, name, value, class
            // -------------------------------------------------------------------------

            if ( isset( $zebra_form_field_details['type_specific_args']['caption'] ) ) {

                if ( $zebra_form_field_details['type_specific_args']['caption'] === NULL ) {

                    $zebra_form_add_field_args['caption'] = to_title( $zebra_form_field_details['form_field_name'] ) ;

                } elseif (  ! is_string( $zebra_form_field_details['type_specific_args']['caption'] )
                            ||
                            trim( $zebra_form_field_details['type_specific_args']['caption'] ) === ''
                    ) {

                    return <<<EOT
PROBLEM: Bad "cape_specific_args" + "caption" - for field# {$zebra_form_field_number} (non-empty string or NULL expected)
For field:&nbsp; {$zebra_form_field_details['form_field_name']}
Of dataset:&nbsp; "{$dataset_title}"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

                }

                $zebra_form_add_field_args['caption'] = $zebra_form_field_details['type_specific_args']['caption'] ;

            } else {

                $zebra_form_add_field_args['caption'] = to_title( $zebra_form_field_details['form_field_name'] ) ;

            }

            // -----------------------------------------------------------------

            $zebra_form->add(   'submit'                                    ,
                                $zebra_form_add_field_args['id']            ,
                                $zebra_form_add_field_args['caption']       ,
                                $zebra_form_add_field_args['attributes']
                                ) ;
                                //  Returns a reference to the newly created object

            // -----------------------------------------------------------------

        } elseif ( $zebra_form_field_details['zebra_control_type'] === 'button' ) {

            // :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
            // BUTTON...
            // :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

            // -------------------------------------------------------------------------
            // void __construct ( string $id , string $caption , [ string $type = 'button'] , [ array $attributes = ''] )
            // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
            // Adds an <input type="button"> control to the form.
            //
            // Do not instantiate this class directly! Use the add() method instead!
            //
            // PARAMETERS
            //
            //      string  $id
            //          Unique name to identify the control in the form.
            //
            //          The control's name attribute will be the same as the id
            //          attribute!
            //
            //          This is the name to be used when referring to the control's
            //          value in the POST/GET superglobals, after the form is submitted.
            //
            //          This is also the name of the variable to be used in custom
            //          template files, in order to display the control.  Ie; In a
            //          template file, in order to print the generated HTML for a
            //          control named "my_button", one would use:
            //
            //              echo $my_button;
            //
            //      string  $caption
            //          Caption of the button control.
            //
            //          Can be HTML.
            //
            //      array   $attributes
            //          (Optional) An array of attributes valid for input controls
            //          (size, readonly, style, etc)
            //
            //          Must be specified as an associative array, in the form of
            //          attribute => value.
            //
            //          See set_attributes() on how to set attributes, other than
            //          through the constructor.
            //
            //          The following attributes are automatically set when the control
            //          is created and should not be altered manually:
            //
            //              id, name, class
            //
            //      string  $type
            //          (Optional) Type of the button: button, submit or reset.
            //
            //          Default is "button".
            // -------------------------------------------------------------------------

            if ( isset( $zebra_form_field_details['type_specific_args']['caption'] ) ) {

                if ( $zebra_form_field_details['type_specific_args']['caption'] === NULL ) {

                    $zebra_form_add_field_args['caption'] = to_title( $zebra_form_field_details['form_field_name'] ) ;

                } elseif (  ! is_string( $zebra_form_field_details['type_specific_args']['caption'] )
                            ||
                            trim( $zebra_form_field_details['type_specific_args']['caption'] ) === ''
                    ) {

                    return <<<EOT
PROBLEM: Bad "cape_specific_args" + "caption" - for field# {$zebra_form_field_number} (non-empty string or NULL expected)
For field:&nbsp; {$zebra_form_field_details['form_field_name']}
Of dataset:&nbsp; "{$dataset_title}"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

                }

                $zebra_form_add_field_args['caption'] = $zebra_form_field_details['type_specific_args']['caption'] ;

            } else {

                $zebra_form_add_field_args['caption'] = to_title( $zebra_form_field_details['form_field_name'] ) ;

            }

            // -----------------------------------------------------------------

            if ( isset( $zebra_form_field_details['type_specific_args']['type'] ) ) {

                if ( $zebra_form_field_details['type_specific_args']['type'] === NULL ) {

                    $zebra_form_add_field_args['type'] = 'button' ;

                } elseif (  ! is_string( $zebra_form_field_details['type_specific_args']['type'] )
                            ||
                            ! in_array(
                                    $zebra_form_field_details['type_specific_args']['type']    ,
                                    array( 'submit' , 'reset' , 'button' )          ,
                                    TRUE
                                    )
                    ) {

                    return <<<EOT
PROBLEM: Bad "type_specific_args" + "type" - for field# {$zebra_form_field_number} ("submit", "reset" or "button" expected)
For field:&nbsp; {$zebra_form_field_details['form_field_name']}
Of dataset:&nbsp; "{$dataset_title}"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

                }

                $zebra_form_add_field_args['type'] = $zebra_form_field_details['type_specific_args']['type'] ;

            } else {

                $zebra_form_add_field_args['type'] = to_title( $zebra_form_field_details['form_field_name'] ) ;

            }

            // -----------------------------------------------------------------

            $zebra_form->add(   'button'                                    ,
                                $zebra_form_add_field_args['id']            ,
                                $zebra_form_add_field_args['caption']       ,
                                $zebra_form_add_field_args['type']          ,
                                $zebra_form_add_field_args['attributes']
                                ) ;
                                //  Returns a reference to the newly created object

            // -----------------------------------------------------------------

        } elseif ( $zebra_form_field_details['zebra_control_type'] === 'select' ) {

            // =================================================================
            // SELECT...
            // =================================================================

            // -------------------------------------------------------------------------
            // void __construct ( string $id , [ mixed $default = ''] , [ array $attributes = ''] , [ string $default_other = ''] )
            // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
            // Adds a <SELECT> control to the form.
            //
            // Do not instantiate this class directly! Use the add() method instead!
            //
            // By default, unless the multiple attribute is set, the control will have a
            // default first option added automatically inviting users to select one of
            // the available options. Default value for English is "- select -" taken
            // from the language file - see the language() method. If you don't want it
            // or want to set it at runtime, set the overwrite argument to TRUE when
            // calling the add_options() method.
            //
            //      // create a new form
            //      $form = new Zebra_Form('my_form');
            //
            //      // single-option select box
            //      $obj = $form->add('select', 'my_select');
            //
            //      // add selectable values with default indexes
            //      // values will be "0", "1" and "2", respectively
            //      // a default first value, "- select -" (language dependent) will also be added
            //      $obj->add_options(array(
            //          'Value 1',
            //          'Value 2',
            //          'Value 3'
            //      ));
            //
            //      // single-option select box
            //      $obj = $form->add('select', 'my_select2');
            //
            //      // add selectable values with specific indexes
            //      // values will be "v1", "v2" and "v3", respectively
            //      // a default first value, "- select -" (language dependent) will also be added
            //      $obj->add_options(array(
            //          'v1' => 'Value 1',
            //          'v2' => 'Value 2',
            //          'v3' => 'Value 3'
            //      ));
            //
            //      // single-option select box with the second value selected
            //      $obj = $form->add('select', 'my_select3', 'v2');
            //
            //      // add selectable values with specific indexes
            //      // values will be "v1", "v2" and "v3", respectively
            //      // also, overwrite the language-specific default first value (notice the boolean TRUE at the end)
            //      $obj->add_options(array(
            //          ''   => '- select a value -',
            //          'v1' => 'Value 1',
            //          'v2' => 'Value 2',
            //          'v3' => 'Value 3'
            //      ), true);
            //
            //      // multi-option select box with the first two options selected
            //      $obj = $form->add('select', 'my_select4[]', array('v1', 'v2'), array('multiple' => 'multiple'));
            //
            //      // add selectable values with specific indexes
            //      // values will be "v1", "v2" and "v3", respectively
            //      $obj->add_options(array(
            //          'v1' => 'Value 1',
            //          'v2' => 'Value 2',
            //          'v3' => 'Value 3'
            //      ));
            //
            // By default, for checkboxes, radio buttons and select boxes, the library
            // will prevent the submission of other values than those declared when
            // creating the form, by triggering the error: "SPAM attempt detected!".
            // Therefore, if you plan on adding/removing values dynamically, from
            // JavaScript, you will have to call the disable_spam_filter() method to
            // prevent that from happening!
            //
            // PARAMETERS
            //
            //      string  $id
            //          Unique name to identify the control in the form.
            //
            //          The control's name attribute will be as specified by the $id
            //          argument. The id attribute will be as specified by the $id
            //          argument but with square brackets trimmed off (if any).
            //
            //          This is the name to be used when referring to the control's
            //          value in the POST/GET superglobals, after the form is submitted.
            //
            //          This is also the name of the variable (again, with square
            //          brackets trimmed off if it's the case) to be used in the
            //          template file, containing the generated HTML for the control.
            //
            //          Ie, in a template file, in order to print the generated HTML for
            //          a control named "my_select", one would use:
            //              echo $my_select;
            //
            //      mixed   $default
            //          (Optional) Default selected option.
            //
            //          This argument can also be an array in case the multiple
            //          attribute is set and multiple options need to be preselected by
            //          default.
            //
            //      array   $attributes
            //          (Optional) An array of attributes valid for select controls
            //          (multiple, readonly, style, etc)
            //
            //          Must be specified as an associative array, in the form of
            //          attribute => value.
            //
            //              // setting the "multiple" attribute
            //              $obj = $form->add(
            //                  'select',
            //                  'my_select',
            //                  '',
            //                  array(
            //                      'multiple' => 'multiple'
            //                  )
            //              );
            //
            //          SPECIAL ATTRIBUTE
            //
            //          When setting the special attribute other to true, a textbox
            //          control will be automatically created having the name [id]_other
            //          where [id] is the select control's id attribute. The text box
            //          will be hidden until the user selects the automatically added
            //          Other... option (language dependent) from the selectable
            //          options. The option's value will be other. If the template is
            //          not automatically generated you will have to manually add the
            //          automatically generated control to the template.
            //
            //          See set_attributes() on how to set attributes, other than
            //          through the constructor.
            //
            //          The following attributes are automatically set when the control
            //          is created and should not be altered manually:
            //              id, name
            //
            //      string  $default_other
            //          The default value in the "other" field (if the "other" attribute
            //          is set to true, see above)
            //
            // METHODS
            //
            //      void add_options ( array $options , [ boolean $overwrite = false] )
            //
            //          Adds options to the select box control
            //
            //          If the "multiple" attribute is not set, the first option will be
            //          always considered as the "nothing is selected" state of the
            //          control!
            //
            //      Parameters:
            //
            //          array   $options
            //              An associative array of options where the key is the value
            //              of the option and the value is the actual text to be
            //              displayed for the option.
            //
            //              OPTION GROUPS can be set by giving an array of associative
            //              arrays as argument:
            //
            //                  // add as groups:
            //                  $obj->add_options(array(
            //                      'group' => array('option 1', 'option 2')
            //                  ));
            //
            //          boolean     $overwrite
            //              (Optional) By default, succesive calls of this method will
            //              appended the options given as arguments to the already
            //              existing options.
            //
            //              Setting this argument to TRUE will instead overwrite the
            //              previously existing options.
            //
            //              Default is FALSE
            // -------------------------------------------------------------------------

            // ---------------------------------------------------------------------------------
            // Here we should have (eg):-
            //
            //      $zebra_form_field_details = array(
            //              'form_field_name'       =>  'category_key'              ,
            //              'zebra_control_type'    =>  'select'                    ,
            //              'label'                 =>  'Project &amp; Category'    ,
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
            //                      'function_name' =>  '\\researchAssistant_byFernTec_datasetManagerDatasetDefs_reference_urls\\get_options_for_project_selector'  ,
            //                      'extra_args'    =>  NULL
            //                      )
            //                  )
            //              )
            //
            // ---------------------------------------------------------------------------------

            // -------------------------------------------------------------------------
            // <options_getter_function>(
            //      $home_page_title                        ,
            //      $caller_apps_includes_dir               ,
            //      $all_application_dataset_definitions    ,
            //      $dataset_slug                           ,
            //      $selected_datasets_dmdd                 ,
            //      $dataset_title                          ,
            //      $dataset_records                        ,
            //      $record_indices_by_key                  ,
            //      $question_adding                        ,
            //      $zebra_form_field_number                           ,
            //      $zebra_form_field_details                          ,
            //      $the_record                             ,
            //      $the_records_index                      ,
            //      $array_storage_field_slugs              ,
            //      $extra_args
            //      )
            // - - - - - - - - - - - - - - - - - - - - - - -
            // Returns the SELECT tag options for the specified record and field
            //
            // NOTE!
            // -----
            // $the_record and $the_records_index are both NULL when
            // $question_adding is TRUE
            //
            // RETURNS
            //      o   On SUCCESS!
            //          - - - - - -
            //          array(
            //              $ok = TRUE                      ,
            //              $field_value <any PHP type>
            //              )
            //
            //      o   On FAILURE!
            //          - - - - - -
            //          array(
            //              $ok = FALSE             ,
            //              $error_message STRING
            //              )
            // -------------------------------------------------------------------------

            $options = array() ;

            // -----------------------------------------------------------------

            if (    isset( $zebra_form_field_details['type_specific_args'] )
                    &&
                    is_array( $zebra_form_field_details['type_specific_args'] )
                    &&
                    isset( $zebra_form_field_details['type_specific_args']['options_getter_function'] )
                    &&
                    is_array( $zebra_form_field_details['type_specific_args']['options_getter_function'] )
                    &&
                    isset( $zebra_form_field_details['type_specific_args']['options_getter_function']['function_name'] )
                    &&
                    is_string( $zebra_form_field_details['type_specific_args']['options_getter_function']['function_name'] )
                ) {

                // -------------------------------------------------------------

                if ( ! function_exists( $zebra_form_field_details['type_specific_args']['options_getter_function']['function_name'] ) ) {

                    return <<<EOT
PROBLEM: Bad "zebra_form" + "type_specific_args" + "options_getter_function" + "function_name" - for field# {$zebra_form_field_number} (function not found)
For field:&nbsp; {$zebra_form_field_details['form_field_name']}
Of dataset:&nbsp; "{$dataset_title}"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

                }

                // -------------------------------------------------------------

                $extra_args = array() ;

                // -------------------------------------------------------------

                if (    isset( $zebra_form_field_details['type_specific_args']['options_getter_function']['extra_args'] )
                        &&
                        is_array( $zebra_form_field_details['type_specific_args']['options_getter_function']['extra_args'] )
                    ) {
                    $extra_args = $zebra_form_field_details['type_specific_args']['options_getter_function']['extra_args'] ;
                }

                // -------------------------------------------------------------

                $result = $zebra_form_field_details['type_specific_args']['options_getter_function']['function_name'](
                                $home_page_title                        ,
                                $caller_apps_includes_dir               ,
                                $all_application_dataset_definitions    ,
                                $dataset_slug                           ,
                                $selected_datasets_dmdd                 ,
                                $dataset_title                          ,
                                $dataset_records                        ,
                                $record_indices_by_key                  ,
                                $question_adding                        ,
                                $zebra_form_field_number                ,
                                $zebra_form_field_details               ,
                                $the_record                             ,
                                $the_records_index                      ,
                                $array_storage_field_slugs              ,
                                $extra_args
                                ) ;

                // -------------------------------------------------------------

                list( $ok , $options ) = $result ;

                // -------------------------------------------------------------

                if ( $ok !== TRUE ) {
                    return $options ;
                }

                // -------------------------------------------------------------

            }

            // -------------------------------------------------------------------------

            $zebra_form_add_field_args['default_other'] = '' ;

            // -----------------------------------------------------------------

            $zebra_form->add(   'label'                                         ,
                                $zebra_form_field_label_args['id']              ,
                                $zebra_form_field_label_args['attach_to']       ,
                                $zebra_form_field_label_args['caption']         ,
                                $zebra_form_field_label_args['attributes']
                                ) ;

            // -----------------------------------------------------------------

            if ( isset( $zebra_form_field_note_args ) ) {

                $zebra_form->add(   'note'                                          ,
                                    $zebra_form_field_note_args['id']               ,
                                    $zebra_form_field_note_args['attach_to']        ,
                                    $zebra_form_field_note_args['caption']          ,
                                    $zebra_form_field_note_args['attributes']
                                    ) ;

            }

            // -----------------------------------------------------------------
            // NOTE!
            // =====
            //      <zebra_form_field_details> +
            //          "type_specific_args" +
            //          "selected_value_conversions_for_select_control"
            //
            // This should be set when an array storage field valid should
            // be converted to some other "selected value" for the select
            // control.
            //
            // FOR EXAMPLE:-
            //
            // The select control's "options_getter_function" creates a
            // select control like (eg):-
            //
            //      <select name="favourite_colour">
            //          <option value=""        >Please choose your favourite colour...</option>
            //          <option value="none"    >(none)</option>
            //          <option value="red"     >Red</option>
            //          <option value="green"   >Green</option>
            //          <option value="blue"    >Blue</option>
            //      </select>
            //
            // And we define:-
            //
            //      <zebra_form_field_details>['type_specific_args']['selected_value_conversions_for_select_control'] =
            //
            //          array(
            //              'add'   =>  array()     ,
            //              'edit'  =>  array(
            //                              ''  =>  'none'
            //                              )
            //              )
            //
            // So when the array storage record is being ADDED, the selected
            // option is:-
            //      "Please choose your favourite colour..."
            //
            // But if we now EDIT the record, and the array storage field
            // has the value "", the selected value will be:-
            //      "(none)"
            //
            // NOTE that the array storage field should have a "value_from"
            // function defined - that converts the submitted value "none"
            // back to "" for storage in the dataset.
            // -----------------------------------------------------------------

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $zebra_form_field_details ) ;

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $zebra_form_add_field_args ) ;

            if (    array_key_exists( 'type_specific_args' , $zebra_form_field_details )
                    &&
                    is_array( $zebra_form_field_details['type_specific_args'] )
                    &&
                    array_key_exists(
                        'selected_value_conversions_for_select_control'     ,
                        $zebra_form_field_details['type_specific_args']
                        )
                    &&
                    is_array( $zebra_form_field_details['type_specific_args']['selected_value_conversions_for_select_control'] )
                ) {

                // -------------------------------------------------------------

                if ( $question_adding ) {
                    $add_edit = 'add' ;

                } else {
                    $add_edit = 'edit' ;

                }

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $add_edit ) ;

                // -------------------------------------------------------------

                if (    array_key_exists(
                            $add_edit           ,
                            $zebra_form_field_details['type_specific_args']['selected_value_conversions_for_select_control']
                            )
                        &&
                        array_key_exists(
                            $zebra_form_add_field_args['default']       ,
                            $zebra_form_field_details['type_specific_args']['selected_value_conversions_for_select_control'][ $add_edit ]
                            )
                    ) {

                    $zebra_form_add_field_args['default'] =
                        $zebra_form_field_details['type_specific_args']['selected_value_conversions_for_select_control'][ $add_edit ][
                            $zebra_form_add_field_args['default']
                            ] ;

                }

                // -------------------------------------------------------------

            }

            // -----------------------------------------------------------------

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $zebra_form_add_field_args ) ;

            $field_obj = $zebra_form->add(  'select'                                        ,
                                            $zebra_form_add_field_args['id']                ,
                                            $zebra_form_add_field_args['default']           ,
                                            $zebra_form_add_field_args['attributes']        ,
                                            $zebra_form_add_field_args['default_other']
                                            ) ;
                                            //  Returns a reference to the newly created object

            // -----------------------------------------------------------------

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $options ) ;

            $field_obj->add_options( $options ) ;

            // -----------------------------------------------------------------

            if (    isset( $zebra_form_field_details['rules'] )
                    &&
                    is_array( $zebra_form_field_details['rules'] )
                ) {
                $field_obj->set_rule( $zebra_form_field_details['rules'] ) ;
            }

            // -----------------------------------------------------------------

        } elseif ( $zebra_form_field_details['zebra_control_type'] === 'hidden' ) {

            // :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
            // HIDDEN...
            // :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

            // ---------------------------------------------------------------------
            // void __construct ( string $id , [ string $default = ''] )
            // - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
            // Adds an <input type="hidden"> control to the form.
            //
            // Do not instantiate this class directly! Use the add() method
            // instead!
            //
            // PARAMETERS
            //
            //      string  $id
            //          Unique name to identify the control in the form.
            //
            //          The control's name attribute will be the same as the id
            //          attribute!
            //
            //          This is the name to be used when referring to the
            //          control's value in the POST/GET superglobals, after the
            //          form is submitted.
            //
            //          Hidden controls are automatically rendered when the
            //          render() method is called!
            //
            //          Do not print them in template files!
            //
            //      string  $default
            //          (Optional) Default value of the text box.
            // ---------------------------------------------------------------------

            // -----------------------------------------------------------------
            // ADD the FIELD...
            // -----------------------------------------------------------------

            $field_obj = $zebra_form->add(  'hidden'                                    ,
                                            $zebra_form_add_field_args['id']            ,
                                            $zebra_form_add_field_args['default']
                                            ) ;
                                            //  Returns a reference to the newly created object

            // -----------------------------------------------------------------

            if (    isset( $zebra_form_field_details['rules'] )
                    &&
                    is_array( $zebra_form_field_details['rules'] )
                ) {
                $field_obj->set_rule( $zebra_form_field_details['rules'] ) ;
            }

            // -----------------------------------------------------------------

        } else {

            // =================================================================
            // ERROR
            // =================================================================

            return <<<EOT
PROBLEM: Unrecognised/unsupported "zebra_control_type" ("{$zebra_form_field_details['zebra_control_type']}") - for field# {$zebra_form_field_number}
For field:&nbsp; {$zebra_form_field_details['form_field_name']}
Of dataset:&nbsp; "{$dataset_title}"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

            // -----------------------------------------------------------------

        }

        // ---------------------------------------------------------------------

//      $zebra_form_field_details['type_specific_args'] = $field_args ;

//      $selected_datasets_dmdd['zebra_forms'][ $form_slug_underscored ]['field_specs'][ $zebra_form_field_details['form_field_name'] ] = $zebra_form_field_details ;

        // =====================================================================
        // Repeat with the NEXT FIELD (if there is one)...
        // =====================================================================

    }

    // =========================================================================
    // SUCCESS!
    // =========================================================================

    return array(
                $zebra_form                 ,
                $selected_datasets_dmdd
                ) ;

    // =========================================================================
    // That's that!
    // =========================================================================

}

// =============================================================================
// get_field_value_for_zebra_form()
// =============================================================================

function get_field_value_for_zebra_form(
    $home_page_title                        ,
    $caller_apps_includes_dir               ,
    $all_application_dataset_definitions    ,
    $dataset_slug                           ,
    $selected_datasets_dmdd                 ,
    $dataset_title                          ,
    $dataset_records                        ,
    $record_indices_by_key                  ,
    $question_adding                        ,
    $zebra_form_field_number                ,
    $zebra_form_field_details               ,
    $the_record                             ,
    $the_records_index                      ,
    $array_storage_field_slugs
    ) {

    // -------------------------------------------------------------------------
    // get_field_value_for_zebra_form(
    //      $home_page_title                        ,
    //      $caller_apps_includes_dir               ,
    //      $all_application_dataset_definitions    ,
    //      $dataset_slug                           ,
    //      $selected_datasets_dmdd                 ,
    //      $dataset_title                          ,
    //      $dataset_records                        ,
    //      $record_indices_by_key                  ,
    //      $question_adding                        ,
    //      $zebra_form_field_number                ,
    //      $zebra_form_field_details               ,
    //      $the_record                             ,
    //      $the_records_index                      ,
    //      $array_storage_field_slugs
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - -
    // RETURNS
    //      o   On SUCCESS!
    //          - - - - - -
    //          array(
    //              $ok = TRUE                      ,
    //              $field_value <any PHP type>
    //              )
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
    //
    //      $zebra_form_field_details = Array(
    //          [form_field_name]       =>  pathspec
    //          [zebra_control_type]    =>  text
    //          [label]                 =>  Pathspec
    //          [attributes]            =>  Array()
    //          [rules]                 =>  Array(
    //              [required] => Array(
    //                  [0] => error
    //                  [1] => Field is required
    //                  )
    //              )
    //          [value_from]            => Array(
    //              [add] => Array(
    //                  [method]    => literal
    //                  [args]      =>
    //                  )
    //
    //              [edit] => Array(
    //                  [method]    => array-storage-field-slug
    //                  [args]      => pathspec
    //                  )
    //              )
    //          [type_specific_args]    => Array()
    //          [constraints]           => Array()
    //          )
    //
    // -------------------------------------------------------------------------

//pr( $the_record , 'the_record' ) ;

//if ( $zebra_form_field_details['form_field_name'] === 'enabled' ) {
//    echo '<br />' ;
//    foreach ( $the_record as $name => $value ) {
//        echo '<br />' , $name , ' --- ' , $value , ' --- ' , gettype( $value ) ;
//    }
//    echo '<br />' ;
//}

//pr( $zebra_form_field_details ) ;

//\greatKiwi_basepressLogger\pr( $zebra_form_field_details , '$zebra_form_field_details' ) ;

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      o   If ADDING a Record
    //              $the_record = NULL
    //
    //      o   If EDITING a Record
    //              $the_record = array(...)
    // -------------------------------------------------------------------------

    // =========================================================================
    // Init. the local variables used (to make the code clearer)...
    // =========================================================================

    $ns = __NAMESPACE__ ;
    $fn = __FUNCTION__ ;

    // -------------------------------------------------------------------------

    $success = TRUE  ;
    $failure = FALSE ;

    // =========================================================================
    // Ignore the Zebra Form controls that have no "default value"...
    // =========================================================================

    if ( in_array(
                $zebra_form_field_details['zebra_control_type']     ,
                get_zebra_controls_with_no_default_value()          ,
                TRUE
                )
        ) {

        return array( $success , NULL ) ;
                    //  The returned value is a dummy value which is ignored.

     }

    // =========================================================================
    // If the form HAS been submitted, then we get the field value from the
    // submitted value...
    // =========================================================================

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $_POST ) ;

    if ( count( $_POST ) > 0 ) {

        // ---------------------------------------------------------------------

        if ( ! array_key_exists(
                    $zebra_form_field_details['form_field_name']        ,
                    $_POST
                    )
            ) {

            // -----------------------------------------------------------------

            if ( $zebra_form_field_details['zebra_control_type'] === 'checkbox' ) {

                return array(
                            $success    ,
                            FALSE
                            ) ;

            } elseif ( $zebra_form_field_details['zebra_control_type'] === 'radios' ) {

                return array(
                            $success    ,
                            ''      //  Ie; NO value is currently selected
                            ) ;

            }

            // -----------------------------------------------------------------

            $msg = <<<EOT
PROBLEM:&nbsp; No "{$zebra_form_field_details['form_field_name']}" (in submitted data)
For dataset:&nbsp; "{$dataset_title}"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

            // -----------------------------------------------------------------

            return array(
                        $failure    ,
                        $msg
                        ) ;

            // -----------------------------------------------------------------

        }

        // ---------------------------------------------------------------------

        if ( $zebra_form_field_details['zebra_control_type'] === 'checkbox' ) {

            // -------------------------------------------------------------------------
            // Here we should have (eg):-
            //
            //      $zebra_form_field_details = Array(
            //          [form_field_name]       => enabled
            //          [zebra_control_type]    => checkbox
            //          [label]                 => Enabled ?
            //          [help_text]             => You can permanently disable this Gadget (eg; because it's under development, buggy, or no longer needed), if you want to.
            //          [attributes]            => Array()
            //          [rules]                 => Array()
            //          [type_specific_args]    => Array(
            //                                          [defaults_checked] => 1
            //                                          )
            //          [value_from]            => Array(
            //                                          [add] => Array(
            //                                                      [method] => literal
            //                                                      [args]   =>
            //                                                      )
            //                                          [edit] => Array(
            //                                                      [method] => array-storage-field-slug
            //                                                      [args]   => enabled
            //                                                      )
            //                                          )
            //          [constraints]           => Array()
            //          )
            //
            // -------------------------------------------------------------------------

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $zebra_form_field_details ) ;

            $expected_value = '1' ;

            // -----------------------------------------------------------------

            if (    array_key_exists( 'type_specific_args' , $zebra_form_field_details )
                    &&
                    is_array( $zebra_form_field_details['type_specific_args'] )
                    &&
                    array_key_exists( 'value' , $zebra_form_field_details['type_specific_args'] )
                ) {

                // -------------------------------------------------------------

                if ( ! is_string( $zebra_form_field_details['type_specific_args']['value'] ) ) {

                    // ---------------------------------------------------------

                    $safe_field_name = htmlentities( $zebra_form_field_details['form_field_name'] ) ;

                    $msg = <<<EOT
PROBLEM:&nbsp; Bad "type_specific_args" + "value" (string expected)
For dataset:&nbsp; "{$dataset_title}"
and Zebra Form field# {$zebra_form_field_number}:&nbsp; "{$safe_field_name}"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

                    // ---------------------------------------------------------

                    return array(
                                $failure    ,
                                $msg
                                ) ;

                    // ---------------------------------------------------------

                }

                // -------------------------------------------------------------

                $expected_value = $zebra_form_field_details['type_specific_args']['value'] ;

                // -------------------------------------------------------------

            }

            // -----------------------------------------------------------------

            if ( $_POST[ $zebra_form_field_details['form_field_name'] ] !== $expected_value ) {

                // -------------------------------------------------------------

                $msg = <<<EOT
PROBLEM:&nbsp; Bad "{$zebra_form_field_details['form_field_name']}" (unexpected value in submitted data)
For dataset:&nbsp; "{$dataset_title}"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

                // -------------------------------------------------------------

                return array(
                            $failure    ,
                            $msg
                            ) ;

                // -------------------------------------------------------------

            }

            // -----------------------------------------------------------------

            return array(
                        $success                                                    ,
                        TRUE
                        ) ;

            // -----------------------------------------------------------------

        }

        // ---------------------------------------------------------------------

//if ( $zebra_form_field_details['form_field_name'] === 'enabled' ) {
//    echo '<br />RETURNING FROM POST: ' , $_POST[ $zebra_form_field_details['form_field_name'] ] , ' --- ' , gettype( $_POST[ $zebra_form_field_details['form_field_name'] ] ) ;
//}

        return array(
                    $success                                                    ,
                    $_POST[ $zebra_form_field_details['form_field_name'] ]
                    ) ;

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // If the form HASN'T been submitted, then we get the field value from the
    // Zebra Form field's "value_from" variable...
    // =========================================================================

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $zebra_form_field_details['value_from'] = array(
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
    //                                              'function_name' =>  <function name, including namespace prefix if necessary>
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
    //                                              'function_name' =>  <function name, including namespace prefix if necessary>
    //                                              'extra_args'    =>  <the extra args (if any), required by this function>
    //                                              )
    //                          )
    //
    //          )
    //
    // -------------------------------------------------------------------------

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $zebra_form_field_details['value_from'] ) ;

    // -------------------------------------------------------------------------

    if ( $question_adding ) {
        $add_edit = 'add' ;

    } else {
        $add_edit = 'edit' ;

    }

    // -------------------------------------------------------------------------

    $method_and_args = $zebra_form_field_details['value_from'][ $add_edit ] ;

//pr( $method_and_args ) ;

    // -------------------------------------------------------------------------

    if ( $method_and_args['method'] === 'array-storage-field-slug' ) {

        // =====================================================================
        // METHOD = ARRAY-STORAGE-FIELD-SLUG
        // =====================================================================

        if ( ! is_array( $the_record ) ) {

            // -----------------------------------------------------------------

            $msg = <<<EOT
PROBLEM: Bad "the_record" (array expected)
For field:&nbsp; {$zebra_form_field_details['form_field_name']}
Of dataset:&nbsp; "{$dataset_title}"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

            // -----------------------------------------------------------------

            return array(
                        $failure    ,
                        $msg
                        ) ;

            // -----------------------------------------------------------------

        }

        // ---------------------------------------------------------------------

//      if ( ! array_key_exists( $zebra_form_field_details['form_field_name'] , $the_record ) ) {

        if ( ! array_key_exists( $method_and_args['args'] , $the_record ) ) {

            // -----------------------------------------------------------------

            $msg = <<<EOT
PROBLEM: Bad "the_record" OR Zebra Form field definition (record contains NO "{$method_and_args['args']}" field)
For dataset:&nbsp; "{$dataset_title}"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

            // -----------------------------------------------------------------

            return array(
                        $failure    ,
                        $msg
                        ) ;

            // -----------------------------------------------------------------

//          return array(
//                      $success    ,
//                      ''
//                      ) ;

            // -----------------------------------------------------------------

        }

        // ---------------------------------------------------------------------

//if ( $zebra_form_field_details['form_field_name'] === 'enabled' ) {
//    echo '<br />RETURNING FROM RECORD: ' , $the_record[ $method_and_args['args'] ] , ' --- ' , gettype( $the_record[ $method_and_args['args'] ] ) ;
//}

        return array(
                    $success                                    ,
                    $the_record[ $method_and_args['args'] ]
                    ) ;

        // ---------------------------------------------------------------------

    } elseif ( $method_and_args['method'] === 'literal' ) {

        // =====================================================================
        // METHOD = LITERAL
        // =====================================================================

        return array(
                    $success                    ,
                    $method_and_args['args']
                    ) ;

        // ---------------------------------------------------------------------

    } elseif ( $method_and_args['method'] === 'function' ) {

        // =====================================================================
        // METHOD = FUNCTION
        // =====================================================================

        // -------------------------------------------------------------------------
        // <get_field_value_function>(
        //      $home_page_title                        ,
        //      $caller_apps_includes_dir               ,
        //      $all_application_dataset_definitions    ,
        //      $dataset_slug                           ,
        //      $selected_datasets_dmdd                 ,
        //      $dataset_title                          ,
        //      $dataset_records                        ,
        //      $record_indices_by_key                  ,
        //      $question_adding                        ,
        //      $zebra_form_field_number                ,
        //      $zebra_form_field_details               ,
        //      $the_record                             ,
        //      $the_records_index                      ,
        //      $array_storage_field_slugs              ,
        //      $extra_args
        //      )
        // - - - - - - - - - - - - - - - - - - - - - - -
        // Returns the specified field's value (for display in a Zebra Forms
        // based "add/edit record" form).
        //
        // NOTE!
        // -----
        // $the_record and $the_records_index are both NULL when
        // $question_adding is TRUE
        //
        // RETURNS
        //      o   On SUCCESS!
        //          - - - - - -
        //          array(
        //              $ok = TRUE                      ,
        //              $field_value <any PHP type>
        //              )
        //
        //      o   On FAILURE!
        //          - - - - - -
        //          array(
        //              $ok = FALSE             ,
        //              $error_message STRING
        //              )
        // -------------------------------------------------------------------------

        return $method_and_args['args']['function_name'](
                    $home_page_title                        ,
                    $caller_apps_includes_dir               ,
                    $all_application_dataset_definitions    ,
                    $dataset_slug                           ,
                    $selected_datasets_dmdd                 ,
                    $dataset_title                          ,
                    $dataset_records                        ,
                    $record_indices_by_key                  ,
                    $question_adding                        ,
                    $zebra_form_field_number                ,
                    $zebra_form_field_details               ,
                    $the_record                             ,
                    $the_records_index                      ,
                    $array_storage_field_slugs              ,
                    $method_and_args['args']['extra_args']
                    ) ;

        // ---------------------------------------------------------------------

    } else {

        // =====================================================================
        // ERROR
        // =====================================================================

        $msg = <<<EOT
PROBLEM: Unrecognised/unsupported "value_from" + "{$add_edit}" + "method" - for field# {$zebra_form_field_number}
For field:&nbsp; {$zebra_form_field_details['form_field_name']}
Of dataset:&nbsp; "{$dataset_title}"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        // ---------------------------------------------------------------------

        return array(
                    $failure    ,
                    $msg
                    ) ;

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // That's that!
    // =========================================================================

}

// =============================================================================
// That's that!
// =============================================================================

