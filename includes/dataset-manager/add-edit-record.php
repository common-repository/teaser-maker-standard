<?php

// *****************************************************************************
// DATASET-MANAGER / ADD-EDIT-RECORD.PHP
// (C) 2013 Peter Newman. All Rights Reserved.
// *****************************************************************************

    namespace greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager ;

// =============================================================================
// add_edit_record()                                                                      sf
// =============================================================================

function add_edit_record(
    $caller_app_slash_plugins_global_namespace      ,
    $home_page_title                                ,
    $caller_apps_includes_dir                       ,
    $all_application_dataset_definitions            ,
    $dataset_slug                                   ,
    $question_front_end                             ,
    $display_options    = array()                   ,
    $submission_options = array()
    ) {

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\add_edit_record(
    //      $caller_app_slash_plugins_global_namespace      ,
    //      $home_page_title                                ,
    //      $caller_apps_includes_dir                       ,
    //      $all_application_dataset_definitions            ,
    //      $dataset_slug                                   ,
    //      $question_front_end                             ,
    //      $display_options    = array()                   ,
    //      $submission_options = array()
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - - - -
    // Outputs a screen for adding or editing a record to/of the specified
    // dataset.
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
    //              )
    //
    //          ...
    //
    //          )
    //
    // RETURNS:-
    //      Nothing
    // -------------------------------------------------------------------------

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //                                                                                   t
    //      $_GET = array(
    //                  [page]          =>  protoPress
    //                  [action]        =>  add-record
    //                  [dataset_slug]  =>  projects
    //                  )
    //
    //      --OR--
    //
    //      $_GET = array(
    //                  [page]          =>  protoPress
    //                  [action]        =>  edit-record
    //                  [dataset_slug]  =>  projects
    //                  [record_key]    =>  "xxx"
    //                  )
    //
    // -------------------------------------------------------------------------

//pr( $_GET ) ;

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $display_options = Array(
    //
    // -------------------------------------------------------------------------

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $display_options ) ;

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $all_application_dataset_definitions = Array(
    //
    //          [projects] => Array(
    //
    //              [dataset_slug]              => projects
    //              [dataset_name_singular]     => project
    //              [dataset_name_plural]       => projects
    //              [dataset_title_singular]    => Project
    //              [dataset_title_plural]      => Projects
    //              [basepress_dataset_handle]  => Array(
    //                  [nice_name] => protoPress_byFernTec_projects
    //                  [unique_key] => d2562b23-3c20-4368-92c4-2b6cd3fa722b-4d1e2f6c-bfd7-4d6d-a151-7710ac09802d-55672840-63d3-11e3-949a-0800200c9a66-627c9d30-63d3-11e3-949a-0800200c9a66
    //                  [version] => 0.1
    //                  )
    //
    //              [zebra_form] => Array(
    //
    //                  [form_specs] => Array(
    //                      [name]                  => add_edit_project
    //                      [method]                => POST
    //                      [action]                =>
    //                      [attributes]            => Array()
    //                      [clientside_validation] => 1
    //                      )
    //
    //                  [field_specs] => Array(
    //
    //                      [title] => Array(
    //                                      [type]               => text
    //                                      [label]              => Project Title
    //                                      [type_specific_args] => Array(
    //                                                                  [id]         =>
    //                                                                  [default]    =>
    //                                                                  [attributes] => Array()
    //                                                                  )
    //                                      )
    //
    //                      [notes_slash_comments] => Array(
    //                                      [type]               => textarea
    //                                      [label]              => Project Notes/Comments
    //                                      [type_specific_args] => Array(
    //                                                                  [id]         =>
    //                                                                  [default]    =>
    //                                                                  [attributes] => Array()
    //                                                                  )
    //                                      )
    //
    //                      [save_me] => Array(
    //                                      [type]               => submit
    //                                      [label]              => Submit
    //                                      [type_specific_args] => Array(
    //                                                                  [id]         =>
    //                                                                  [default]    =>
    //                                                                  [attributes] => Array()
    //                                                                  )
    //                                      )
    //
    //                      )
    //
    //
    //                  'focus_field_slug'  =>  'title'
    //
    //                  )
    //
    //              )
    //
    // -------------------------------------------------------------------------

//pr( $all_application_dataset_definitions ) ;

    // =========================================================================
    // Init.
    // =========================================================================

    $ns = __NAMESPACE__ ;
    $fn = __FUNCTION__ ;

    // =========================================================================
    // ADD or EDIT ?
    // =========================================================================

    if ( $_GET['action'] === 'add-record' ) {
        $question_adding = TRUE ;
        $adding_editing  = 'Adding' ;

    } else {
        $question_adding = FALSE ;
        $adding_editing  = 'Editing' ;

    }

    // =========================================================================
    // Get the specified dataset's DATASET MANAGER DATASET DEFINITION...
    // =========================================================================

    $selected_datasets_dmdd = $all_application_dataset_definitions[ $dataset_slug ] ;
                                    //  dmdd = Dataset Manager Dataset Definition

    // =========================================================================
    // Get the ERROR PAGE TITLE and DATASET TITLE (for use in error messages)...
    // =========================================================================

    if ( $question_adding ) {
        $error_page_title = 'Add Record' ;

    } else {
        $error_page_title = 'Edit Record' ;

    }

    // -------------------------------------------------------------------------

    if (    isset( $selected_datasets_dmdd['dataset_title_plural'] )
            &&
            is_string( $selected_datasets_dmdd['dataset_title_plural'] )
            &&
            trim( $selected_datasets_dmdd['dataset_title_plural'] ) !== ''
        ) {
        $dataset_title = $selected_datasets_dmdd['dataset_title_plural'] ;

    } else {
        $dataset_title = to_title( $dataset_slug ) ;

    }

    // =========================================================================
    // LOAD the DATASET RECORDS (from array storage)...
    // =========================================================================

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

    $question_die_on_error = FALSE ;

    $dataset_records = \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_arrayStorage\load_numerically_indexed(
                            $dataset_slug               ,
                            $question_die_on_error
                            ) ;

    // -------------------------------------------------------------------------

    if ( is_string( $dataset_records ) ) {

        return standard_dataset_manager_error(
                    $error_page_title           ,
                    $dataset_records            ,
                    $caller_apps_includes_dir   ,
                    $question_front_end
                    ) ;

    }

//pr( $dataset_records ) ;

    // =========================================================================
    // GET/CHECK the dataset records KEY FIELD SLUG...
    // =========================================================================

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

    $key_field_slug = get_dataset_key_field_slug(
                        $all_application_dataset_definitions    ,
                        $dataset_slug
                        ) ;

    // -------------------------------------------------------------------------

    if ( is_array( $key_field_slug ) ) {

        return standard_dataset_manager_error(
                    $error_page_title           ,
                    $key_field_slug[0]          ,
                    $caller_apps_includes_dir   ,
                    $question_front_end
                    ) ;

    }

    // =========================================================================
    // GET the DATASET's RECORD INDICES BY KEY...
    // =========================================================================

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\get_dataset_record_indices_by_key(
    //      $dataset_title      ,
    //      $dataset_records    ,
    //      $key_field_slug
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // RETURNS:-
    //      o   (array) $record_indices_by_key on SUCCESS
    //      o   (string) $error_message on FAILURE
    // -------------------------------------------------------------------------

    $record_indices_by_key = get_dataset_record_indices_by_key(
                                $dataset_title      ,
                                $dataset_records    ,
                                $key_field_slug
                                ) ;

    // -------------------------------------------------------------------------

    if ( is_string( $record_indices_by_key ) ) {

        return standard_dataset_manager_error(
                    $error_page_title           ,
                    $record_indices_by_key      ,
                    $caller_apps_includes_dir   ,
                    $question_front_end
                    ) ;

    }

    // =========================================================================
    // Get the "form_slug_underscored" of the form to use,,,
    // =========================================================================

    require_once( dirname( __FILE__ ) . '/get-check-form-slug-underscored.php' ) ;

    // -------------------------------------------------------------------------
    // get_check_form_slug_underscored(
    //      $caller_app_slash_plugins_global_namespace      ,
    //      $home_page_title                                ,
    //      $caller_apps_includes_dir                       ,
    //      $all_application_dataset_definitions            ,
    //      $dataset_slug                                   ,
    //      $question_front_end                             ,
    //      $display_options                                ,
    //      $submission_options                             ,
    //      $selected_datasets_dmdd                         ,
    //      $dataset_title
    //      ) {
    // - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // RETURNS
    //      o   On SUCCESS
    //              $form_slug_underscored STRING
    //
    //      o   On FAILURE
    //              ARRAY $error_message STRING )
    // -------------------------------------------------------------------------

    $form_slug_underscored = get_check_form_slug_underscored(
                                $caller_app_slash_plugins_global_namespace      ,
                                $home_page_title                                ,
                                $caller_apps_includes_dir                       ,
                                $all_application_dataset_definitions            ,
                                $dataset_slug                                   ,
                                $question_front_end                             ,
                                $display_options                                ,
                                $submission_options                             ,
                                $selected_datasets_dmdd                         ,
                                $dataset_title
                                ) ;

    // -------------------------------------------------------------------------

    if ( is_array( $form_slug_underscored ) ) {

        return standard_dataset_manager_error(
                    $error_page_title           ,
                    $form_slug_underscored[0]   ,
                    $caller_apps_includes_dir   ,
                    $question_front_end
                    ) ;

    }

    // =========================================================================
    // Check/Default the Zebra Form Definition...
    // =========================================================================

    require_once( dirname( __FILE__ ) . '/check-and-default-zebra-form-definition.php' ) ;

    // -------------------------------------------------------------------------
    // check_and_default_zebra_form_definition(
    //      $caller_app_slash_plugins_global_namespace      ,
    //      $home_page_title                                ,
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
    //          o   ...['zebra_forms'][ $form_slug_underscored ]['checked_defaulted_ok'] = TRUE
    //          o   With the remaining "zebra_form" elements defaulted as
    //              required
    //
    //      On FAILURE!
    //      - - - - - -
    //      $error_message STRING
    // -------------------------------------------------------------------------

    $result = check_and_default_zebra_form_definition(
                    $caller_app_slash_plugins_global_namespace      ,
                    $home_page_title                                ,
                    $caller_apps_includes_dir                       ,
                    $all_application_dataset_definitions            ,
                    $dataset_slug                                   ,
                    $selected_datasets_dmdd                         ,
                    $dataset_title                                  ,
                    $dataset_records                                ,
                    $record_indices_by_key                          ,
                    $question_adding                                ,
                    $form_slug_underscored
                    ) ;

    // -------------------------------------------------------------------------

    if ( is_string( $result ) ) {

        return standard_dataset_manager_error(
                    $error_page_title           ,
                    $result                     ,
                    $caller_apps_includes_dir   ,
                    $question_front_end
                    ) ;

    }

    // =========================================================================
    // BASE64 ENCODING ?
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

        return standard_dataset_manager_error(
                    $error_page_title                                               ,
                    $pre_check_base64_encoded_array_storage_field_indices_by_slug   ,
                    $caller_apps_includes_dir                                       ,
                    $question_front_end
                    ) ;

    }

    // =========================================================================
    // LOAD ZEBRA FORMs...
    // =========================================================================

    require_once( $caller_apps_includes_dir . '/Zebra_Form-master/Zebra_Form.php' ) ;

    // =========================================================================
    // CREATE the ZEBRA FORM object instance...
    // =========================================================================

    require_once( dirname( __FILE__ ) . '/add-edit-record_create-zebra-form.php' ) ;

    // -------------------------------------------------------------------------
    // create_zebra_form_object_instance(
    //      $home_page_title                                                ,
    //      $caller_apps_includes_dir                                       ,
    //      $all_application_dataset_definitions                            ,
    //      $dataset_slug                                                   ,
    //      $question_front_end                                             ,
    //      $display_options    = array()                                   ,
    //      $submission_options = array()                                   ,
    //      $selected_datasets_dmdd                                         ,
    //      $dataset_title                                                  ,
    //      $dataset_records                                                ,
    //      $record_indices_by_key                                          ,
    //      $question_adding                                                ,
    //      $form_slug_underscored                                          ,
    //      $pre_check_base64_encoded_array_storage_field_indices_by_slug
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // RETURNS
    //      o   On SUCCESS!
    //              array(
    //                  $zebra_form_obj (= reference to Zebra Form object instance)
    //                  $selected_datasets_dmdd_updated
    //                  )
    //
    //      o   On FAILURE
    //              $error_message STRING
    // -------------------------------------------------------------------------

    $result = create_zebra_form_object_instance(
                    $home_page_title                                                ,
                    $caller_apps_includes_dir                                       ,
                    $all_application_dataset_definitions                            ,
                    $dataset_slug                                                   ,
                    $question_front_end                                             ,
                    $display_options                                                ,
                    $submission_options                                             ,
                    $selected_datasets_dmdd                                         ,
                    $dataset_title                                                  ,
                    $dataset_records                                                ,
                    $record_indices_by_key                                          ,
                    $question_adding                                                ,
                    $form_slug_underscored                                          ,
                    $pre_check_base64_encoded_array_storage_field_indices_by_slug
                    ) ;

//pr( $result ) ;

    // -------------------------------------------------------------------------

    if ( is_string( $result ) ) {

        return standard_dataset_manager_error(
                    $error_page_title           ,
                    $result                     ,
                    $caller_apps_includes_dir   ,
                    $question_front_end
                    ) ;

    }

    // -------------------------------------------------------------------------

    list(
        $zebra_form_obj             ,
        $selected_datasets_dmdd
        ) = $result ;

    // =========================================================================
    // WordPress Magic Quotes...
    // =========================================================================

    require_once( $caller_apps_includes_dir . '/wordpress-magic-quotes.php' ) ;

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

    // =========================================================================
    // Base64 encode the specified fields ("pre-check")...
    // =========================================================================

    $post_values_base64_encoded_pre_check_by_post_slug = array() ;

    // -------------------------------------------------------------------------

    if ( count( $_POST ) > 0 ) {

        // ---------------------------------------------------------------------

//pr( $_POST ) ;

        // ---------------------------------------------------------------------

        $array_storage_field_indices_to_base64_encode_pre_check =
            array_values(
                $pre_check_base64_encoded_array_storage_field_indices_by_slug
                ) ;

        // ---------------------------------------------------------------------

        foreach ( $array_storage_field_indices_to_base64_encode_pre_check as $field_index ) {

            // -----------------------------------------------------------------

            $field_data = $selected_datasets_dmdd['array_storage_record_structure'][ $field_index ] ;

            // -----------------------------------------------------------------

            if (    array_key_exists( 'value_from' , $field_data )
                    &&
                    is_array( $field_data['value_from'] )
                    &&
                    array_key_exists( 'method' , $field_data['value_from'] )
                    &&
                    array_key_exists( 'instance' , $field_data['value_from'] )
                    &&
                    $field_data['value_from']['method'] === 'post'
                    &&
                    is_string( $field_data['value_from']['instance'] )
                    &&
                    $field_data['value_from']['instance'] !== ''
                    &&
                    array_key_exists( $field_data['value_from']['instance'] , $_POST )
                ) {

                if ( \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_wordpressMagicQuotes\question_magic_quotes_gpc() ) {

                    $_POST[ $field_data['value_from']['instance'] ] =
                        \stripslashes( $_POST[ $field_data['value_from']['instance'] ] )
                        ;

                }

                $post_values_base64_encoded_pre_check_by_post_slug[
                    $field_data['value_from']['instance']
                    ] = $_POST[ $field_data['value_from']['instance'] ] ;

                $_POST[ $field_data['value_from']['instance'] ] =
                    base64_encode(
                        $_POST[ $field_data['value_from']['instance'] ]
                        ) ;

                continue ;

            }

            // -----------------------------------------------------------------

            $field_number = $field_index + 1 ;

            $safe_field_slug = htmlentities( $field_data['slug'] ) ;

            $msg = <<<EOT
PROBLEM:&nbsp; Can't base64 encode array storage field# {$field_number} ("{$safe_field_slug}") - (bad array storage field data)
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

            return standard_dataset_manager_error(
                        $error_page_title           ,
                        $msg                        ,
                        $caller_apps_includes_dir   ,
                        $question_front_end
                        ) ;

            // -----------------------------------------------------------------

        }

        // ---------------------------------------------------------------------

//pr( $_POST ) ;

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // VALIDATE the form...
    // =========================================================================

    // -------------------------------------------------------------------------
    // boolean validate ()
    // - - - - - - - - - -
    // This method performs the server-side validation of all the form's
    // controls, making sure that all the values comply to the rules set for
    // these controls through the set_rule() method.
    //
    // Only by calling this method will the form's controls update their values.
    // If this method is not called, all the controls will preserve their
    // default values after submission even if these values were altered prior
    // to submission.
    //
    // This method must be called before the render() method or error messages
    // will not be available.
    //
    // After calling this method, if there are file controls on the form, you
    // might want to check for the existence of the $file_upload property to see
    // the details of uploaded files and take actions accordingly.
    //
    // Client-side validation is done on the "onsubmit" event of the form. See
    // clientside_validation() for more information on client-side validation.
    //
    // Returns TRUE if every rule was obeyed, FALSE if not.
    // -------------------------------------------------------------------------

    if ( count( $_POST ) > 0 ) {

        // :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
        //  "ZEBRA FORM" SUBMISSION HANDLING
        // :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

        $zebra_form_happy = $zebra_form_obj->validate() ;

        // ---------------------------------------------------------------------

        if ( $zebra_form_happy === TRUE ) {

            // :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
            // "STANDARD DATASET MANAGER" SUBMISSION HANDLING
            // :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

            // =================================================================
            // STANDARD or CUSTOM SUBMISSION HANDLER ?
            // =================================================================

            // -----------------------------------------------------------------
            // Here we should have (eg):-
            //
            //      $submission_options = array(
            //          'custom_submission_handler_function_name'   =>  $custom_submission_handler_function_name
            //          )
            //
            // -----------------------------------------------------------------

            if (    is_array( $submission_options )
                    &&
                    array_key_exists( 'custom_submission_handler_function_name' , $submission_options )
                    &&
                    is_string( $submission_options['custom_submission_handler_function_name'] )
                ) {

                // =============================================================
                // CUSTOM SUBMISSION HANDLER
                // =============================================================

                if (    trim( $submission_options['custom_submission_handler_function_name'] ) === ''
                        ||
                        strlen( $submission_options['custom_submission_handler_function_name'] ) > 512
                    ) {

                    $msg = <<<EOT
PROBLEM:&nbsp; Bad "custom_submission_handler_function_name" (1 to 512 character string expected)
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

                    return standard_dataset_manager_error(
                                $error_page_title           ,
                                $msg                        ,
                                $caller_apps_includes_dir   ,
                                $question_front_end
                                ) ;

                }

                // -------------------------------------------------------------

                if ( ! function_exists( $submission_options['custom_submission_handler_function_name'] ) ) {

                    $msg = <<<EOT
PROBLEM:&nbsp; Bad "custom_submission_handler_function_name" (no such function)
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

                    return standard_dataset_manager_error(
                                $error_page_title           ,
                                $msg                        ,
                                $caller_apps_includes_dir   ,
                                $question_front_end
                                ) ;

                }

                // -------------------------------------------------------------------------
                // my_custom_submission_handler(
                //      $caller_app_slash_plugins_global_namespace      ,
                //      $home_page_title                                ,
                //      $caller_apps_includes_dir                       ,
                //      $all_application_dataset_definitions            ,
                //      $dataset_slug                                   ,
                //      $question_front_end                             ,
                //      $display_options                                ,
                //      $submission_options                             ,
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

                $result = $submission_options['custom_submission_handler_function_name'](
                                $caller_app_slash_plugins_global_namespace      ,
                                $home_page_title                                ,
                                $caller_apps_includes_dir                       ,
                                $all_application_dataset_definitions            ,
                                $dataset_slug                                   ,
                                $question_front_end                             ,
                                $display_options                                ,
                                $submission_options                             ,
                                $selected_datasets_dmdd                         ,
                                $dataset_title                                  ,
                                $dataset_records                                ,
                                $record_indices_by_key                          ,
                                $key_field_slug                                 ,
                                $question_adding                                ,
                                $zebra_form_obj                                 ,
                                $form_slug_underscored
                                ) ;

                // -------------------------------------------------------------

            } else {

                // =============================================================
                // STANDARD ADD/EDIT RECORD SUBMISSION HANDLER
                // =============================================================

                require_once( dirname( __FILE__ ) . '/add-edit-record_submission-handler.php' ) ;

                // -------------------------------------------------------------------------
                // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\handle_zebra_form_submission(
                //      $caller_app_slash_plugins_global_namespace      ,
                //      $home_page_title                                ,
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

                $result = handle_zebra_form_submission(
                            $caller_app_slash_plugins_global_namespace      ,
                            $home_page_title                                ,
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
                            ) ;

                // -------------------------------------------------------------

            }

            // =================================================================
            // Handle any SUBMISSION HANDLER ERROR...
            // =================================================================

            $question_redisplay_form = FALSE ;

            // -----------------------------------------------------------------

            if ( is_array( $result ) ) {

                // -------------------------------------------------------------

                list(
                    $error_message      ,
                    $error_field_slug
                    ) = $result ;

                // -------------------------------------------------------------

                $ignore_case_FALSE = FALSE ;

                // -------------------------------------------------------------

                if ( \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_stringUtils\starts_with( $error_message , '--ZEBRA--' , $ignore_case_FALSE ) ) {

                    // -------------------------------------------------------------------------
                    // void add_error ( string $error_block , string $error_message )
                    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
                    // Appends a message to an already existing error block
                    //
                    //      // create a new form
                    //      $form = new Zebra_Form('my_form');
                    //
                    //      // add a text control to the form
                    //      $obj = $form->add('text', 'my_text');
                    //
                    //      // make the text field required
                    //      $obj->set_rule(
                    //              'required' => array(
                    //                  'error',            // variable to add the error message to
                    //                  'Field is required' // error message if value doesn't validate
                    //                  )
                    //              ) ;
                    //
                    //      // don't forget to always call this method before rendering the form
                    //      if ($form->validate()) {
                    //
                    //          // for the purpose of this example, we will do a custom
                    //          // validation after calling the "validate" method. for custom
                    //          // validations, using the "custom" rule is recommended instead
                    //
                    //          // check if value's is between 1 and 10
                    //          if (    $_POST['my_text'] < 1
                    //                  ||
                    //                  $_POST['my_text'] > 10
                    //              ) {
                    //              $form->add_error(   'error' ,
                    //                                  'Value must be an integer between 1 and 10!'
                    //                                  ) ;
                    //
                    //          } else {
                    //
                    //              // put code here that is to be executed when the form values are ok
                    //
                    //          }
                    //
                    //      }
                    //
                    //      // output the form using an automatically generated template
                    //      $form->render();
                    //
                    // PARAMETERS
                    //
                    //      string  $error_block    The name of the error block to append the
                    //                              error message to (also the name of the PHP
                    //                              variable that will be available in the
                    //                              template file).
                    //
                    //      string  $error_message  The error message to append to the error
                    //                              block.
                    // -------------------------------------------------------------------------

                    $zebra_form_obj->add_error(
                                    'error'                                     ,
                                    substr( $error_message , strlen( '--ZEBRA--' ) )
                                    ) ;

                    // ---------------------------------------------------------

                    $question_redisplay_form = TRUE ;

                    // ---------------------------------------------------------

                } else {

                    // ---------------------------------------------------------

                    return standard_dataset_manager_error(
                                $error_page_title           ,
                                $error_message              ,
                                $caller_apps_includes_dir   ,
                                $question_front_end
                                ) ;

                    // ---------------------------------------------------------

                }

                // -------------------------------------------------------------

            }

            // -----------------------------------------------------------------

        } else {

            // -----------------------------------------------------------------

            $question_redisplay_form = TRUE ;
                //  Because Zebra Form wasn't happy (with the submission)

            // -----------------------------------------------------------------

        }

        // =====================================================================
        // RETURN TO WHERE-EVER (if requested/required)...
        // =====================================================================

        if ( $question_redisplay_form !== TRUE ) {

            // =================================================================
            // Does $SUBMISSION_OPTIONS have any instructions as to where we
            // should return to ?
            // =================================================================

            // -----------------------------------------------------------------
            // Here we should have (eg):-
            //
            //      $submission_options = array(
            //          'return_to'     =>  array(
            //                                  'function_name' =>  $get_return_to_url_function_name
            //                                  )
            //                              )
            //          )
            //
            // -----------------------------------------------------------------

            if (    is_array( $submission_options )
                    &&
                    array_key_exists( 'return_to' , $submission_options )
                ) {

                // =============================================================
                // $SUBMISSION_OPTIONS['RETURN_TO']...
                // =============================================================

                if ( ! is_array( $submission_options['return_to'] ) ) {

                    $msg = <<<EOT
PROBLEM:&nbsp; Bad "submission_options" + "return_to" (array expected)
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

                    return standard_dataset_manager_error(
                                $error_page_title           ,
                                $msg                        ,
                                $caller_apps_includes_dir   ,
                                $question_front_end
                                ) ;

                }

                // -------------------------------------------------------------

                if ( ! array_key_exists( 'function_name' , $submission_options['return_to'] ) ) {

                    $msg = <<<EOT
PROBLEM:&nbsp; Bad "submission_options" + "return_to" (no "function_name")
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

                    return standard_dataset_manager_error(
                                $error_page_title           ,
                                $msg                        ,
                                $caller_apps_includes_dir   ,
                                $question_front_end
                                ) ;

                }

                // -------------------------------------------------------------

                if (    ! is_string( $submission_options['return_to']['function_name'] )
                        ||
                        trim( $submission_options['return_to']['function_name'] ) === ''
                        ||
                        strlen( $submission_options['return_to']['function_name'] ) > 512
                    ) {

                    $msg = <<<EOT
PROBLEM:&nbsp; Bad "submission_options" + "return_to" + "function_name" (1 to 512 character string expected)
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

                    return standard_dataset_manager_error(
                                $error_page_title           ,
                                $msg                        ,
                                $caller_apps_includes_dir   ,
                                $question_front_end
                                ) ;

                }

                // -------------------------------------------------------------

                if ( ! function_exists( $submission_options['return_to']['function_name'] ) ) {

                    $msg = <<<EOT
PROBLEM:&nbsp; Bad "submission_options" + "return_to" + "function_name" (no such function)
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

                    return standard_dataset_manager_error(
                                $error_page_title           ,
                                $msg                        ,
                                $caller_apps_includes_dir   ,
                                $question_front_end
                                ) ;

                }

                // -------------------------------------------------------------------------
                // my_custom_get_return_to_url_function(
                //      $caller_app_slash_plugins_global_namespace      ,
                //      $home_page_title                                ,
                //      $caller_apps_includes_dir                       ,
                //      $all_application_dataset_definitions            ,
                //      $dataset_slug                                   ,
                //      $question_front_end                             ,
                //      $display_options                                ,
                //      $submission_options                             ,
                //      $selected_datasets_dmdd                         ,
                //      $dataset_title                                  ,
                //      $dataset_records                                ,
                //      $record_indices_by_key                          ,
                //      $key_field_slug                                 ,
                //      $question_adding                                ,
                //      $zebra_form_obj
                //      )
                // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
                // RETURNS
                //      o   On SUCCESS!
                //              $url STRING
                //
                //      o   On FAILURE
                //              array( $error_message STRING )
                // -------------------------------------------------------------------------

                $url = $submission_options['return_to']['function_name'](
                            $caller_app_slash_plugins_global_namespace      ,
                            $home_page_title                                ,
                            $caller_apps_includes_dir                       ,
                            $all_application_dataset_definitions            ,
                            $dataset_slug                                   ,
                            $question_front_end                             ,
                            $display_options                                ,
                            $submission_options                             ,
                            $selected_datasets_dmdd                         ,
                            $dataset_title                                  ,
                            $dataset_records                                ,
                            $record_indices_by_key                          ,
                            $key_field_slug                                 ,
                            $question_adding                                ,
                            $zebra_form_obj
                            ) ;

                // -------------------------------------------------------------

                if ( is_array( $url ) ) {

                    return standard_dataset_manager_error(
                                $error_page_title           ,
                                $url[0]                     ,
                                $caller_apps_includes_dir   ,
                                $question_front_end
                                ) ;

                }

                // -------------------------------------------------------------

            } else {

                // =============================================================
                // RETURN to the "RETURN TO" page (= DATASET MANAGEMENT page,
                // by default)...
                // =============================================================

                $allowed_get_return_tos = array(
                    'show-view'         ,
                    'manage-dataset'
                    ) ;

                // -------------------------------------------------------------

                if (    isset( $_GET['return_to'] )
                        &&
                        trim( $_GET['return_to'] ) !== ''
                        &&
                        strlen( $_GET['return_to'] ) <= 64
                        &&
                        in_array( $_GET['return_to'] , $allowed_get_return_tos , TRUE )
                    ) {

                    // ---------------------------------------------------------

                    $return_to = $_GET['return_to'] ;

                    // ---------------------------------------------------------

                } else {

                    // =========================================================
                    // If we get here, then we return to the DEFAULT return to
                    // page.  Which is either:-
                    //
                    //      o   The PLUGIN HOME PAGE - if the dataset is in
                    //          "single record mode", or:-
                    //
                    //      o   The "MANAGE DATASET" page, otherwise.
                    // =========================================================

                    if (    array_key_exists( 'question_single_record_mode' , $selected_datasets_dmdd )
                            &&
                            $selected_datasets_dmdd['question_single_record_mode'] === TRUE
                        ) {
                        $return_to = 'plugin-home-page' ;

                    } else {
                        $return_to = 'manage-dataset' ;

                    }

                    // ---------------------------------------------------------

                }

                // -------------------------------------------------------------

                if ( $return_to === 'manage-dataset' ) {

                    // ---------------------------------------------------------

                    require_once( dirname( __FILE__ ) . '/get-dataset-urls.php' ) ;

                    // -------------------------------------------------------------------------
                    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\get_manage_dataset_url(
                    //      $caller_apps_includes_dir   ,
                    //      $question_front_end         ,
                    //      $dataset_slug = NULL
                    //      )
                    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
                    // Returns the "manage-dataset" URL.
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

                    $url = get_manage_dataset_url(
                                $caller_apps_includes_dir   ,
                                $question_front_end         ,
                                $dataset_slug
                                ) ;

                    // ---------------------------------------------------------

                } elseif ( $return_to === 'plugin-home-page' ) {

                    // -------------------------------------------------------------------------
                    // get_home_page_url(
                    //      $caller_apps_includes_dir   ,
                    //      $question_front_end
                    //      )
                    // - - - - - - - - - - - - - - - - -
                    // RETURNS
                    //      o   On SUCCESS!
                    //              $home_page_url STRING
                    //
                    //      o   On FAILURE!
                    //              ARRAY( $error_message STRING )
                    // -------------------------------------------------------------------------

                    $url = get_home_page_url(
                                $caller_apps_includes_dir   ,
                                $question_front_end
                                ) ;

                    // ---------------------------------------------------------

                } elseif ( $return_to === 'show-view' ) {

                    // ---------------------------------------------------------

                    require_once( dirname( __FILE__ ) . '/get-view-urls.php' ) ;

                    // -------------------------------------------------------------------------
                    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\get_show_view_url(
                    //      $caller_apps_includes_dir   ,
                    //      $question_front_end         ,
                    //      $view_slug = NULL
                    //      )
                    // - - - - - - - - - - - - - - - - - - - - - - - - - - -
                    // Returns the "show-view" URL.
                    //
                    // If $view_slug is NULL, then we use:-
                    //      $_GET['view_slug']
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

                    $view_slug = NULL ;

                    // -------------------------------------------------------------

                    $url = get_show_view_url(
                                $caller_apps_includes_dir   ,
                                $question_front_end         ,
                                $view_slug
                                ) ;

                    // ---------------------------------------------------------

                } else {

                    // ---------------------------------------------------------

                    $safe_return_to = htmlentities( $return_to ) ;

                    $msg = <<<EOT
PROBLEM:&nbsp; Unrecognised/unsupported "return_to" ("{$safe_return_to}")
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

                    return standard_dataset_manager_error(
                                $error_page_title           ,
                                $msg                        ,
                                $caller_apps_includes_dir   ,
                                $question_front_end
                                ) ;

                    // ---------------------------------------------------------

                }

                // -------------------------------------------------------------

                if ( is_array( $url ) ) {

                    return standard_dataset_manager_error(
                                $error_page_title           ,
                                $url[0]                     ,
                                $caller_apps_includes_dir   ,
                                $question_front_end
                                ) ;

                }

                // -------------------------------------------------------------

            }

            // -----------------------------------------------------------------

            echo <<<EOT
<script type="text/javascript">
window.parent.location.href = '{$url}' ;
</script>
EOT;

            // -----------------------------------------------------------------

        }

        // =====================================================================
        // Fall through to RE-DISPLAY THE FORM...
        // =====================================================================

    }

    // =========================================================================
    // If the form is being re-displayed after a submission handler error -
    // then reset any $_POST values that were base64 encoded before the
    // submission handler was run...
    // =========================================================================

    if (    isset( $question_redisplay_form )
            &&
            $question_redisplay_form === TRUE
            &&
            count( $post_values_base64_encoded_pre_check_by_post_slug ) > 0
        ) {

        // ---------------------------------------------------------------------

        foreach ( $post_values_base64_encoded_pre_check_by_post_slug as $post_slug => $original_post_value ) {
            $_POST[ $post_slug ] = $original_post_value ;
        }

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // RENDER the form...
    // =========================================================================

    // -------------------------------------------------------------------------
    // mixed render ( [ string $template = ''] , [ boolean $return = false] , [ array $variables = ''] )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // Returns or displays the rendered form.
    //
    // PARAMETERS
    //
    //      string  $template
    //          The output of the form can be generated automatically, can be
    //          given from a template file or can be generated programmatically
    //          by a callback function.
    //
    //          For the automatically generated template there are two options:
    //
    //              o   when $template is an empty string or is "*vertical", the
    //                  script will automatically generate an output where the
    //                  labels are above the controls and controls come one
    //                  under another (vertical view)
    //
    //              o   when $template is "*horizontal", the script will
    //                  automatically generate an output where the labels are
    //                  positioned to the left of the controls while the
    //                  controls come one under another (horizontal view)
    //
    //          When templates are user-defined, $template needs to be a string
    //          representing the path/to/the/template.php.
    //
    //          The template file itself must be a plain PHP file where all the
    //          controls added to the form (except for the hidden controls,
    //          which are handled automatically) will be available as variables
    //          with the names as described in the documentation for each of the
    //          controls. Also, error messages will be available as described at
    //          set_rule().
    //
    //          A special variable will also be available in the template file -
    //          a variable with the name of the form and being an associative
    //          array containing all the controls added to the form, as objects.
    //
    //          The template file must not contain the <form> and </form> tags,
    //          nor any of the <hidden> controls added to the form as these are
    //          generated automatically!
    //
    //          There is a third method of generating the output and that is
    //          programmatically, through a callback function. In this case
    //          $template needs to be the name of an existing function.
    //
    //          The function will be called with two arguments:
    //
    //          o   an associative array with the form's controls' ids and their
    //              respective generated HTML, ready for echo-ing (except for
    //              the hidden controls which will still be handled
    //              automatically);
    //
    //              note that this array will also contain variables assigned
    //              through the assign() method as well as any server-side error
    //              messages, as you would in a custom template (see set_rule()
    //              method and read until the second highlighted box, inclusive)
    //
    //          o   an associative array with all the controls added to the
    //              form, as objects
    //
    //          THE USER FUNCTION MUST RETURN THE GENERATED OUTPUT!
    //
    //      boolean     $return
    //          (Optional) If set to TRUE, the output will be returned instead
    //          of being printed to the screen.
    //
    //          Default is FALSE.
    //
    //      array   $variables
    //          (Optional) An associative array in the form of "variable_name"
    //          => "value" representing variable names and their associated
    //          values, to be made available in custom template files.
    //
    //          This represents a quicker alternative for assigning many
    //          variables at once instead of calling the assign() method for
    //          each variable.
    // -------------------------------------------------------------------------

    $template  = '' ;
    $return    = TRUE ;
    $variables = array() ;

    // -------------------------------------------------------------------------

    $add_edit_form = $zebra_form_obj->render( $template , $return , $variables ) ;

    // -------------------------------------------------------------------------
    // For WordPress Admin section, restrict the form width to 98%...
    // -------------------------------------------------------------------------

//    $add_edit_form = <<<EOT
//<div style="width:98%">{$add_edit_form}</div>
//EOT;
        //  Now we restrict the IFRAME to 98%

    // -------------------------------------------------------------------------
    // Add any "inline_scripts_or_other_html"...
    // -------------------------------------------------------------------------

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $selected_datasets_dmdd ) ;
//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $selected_datasets_dmdd['zebra_form'] ) ;

    if (    array_key_exists( 'inline_scripts_or_other_html' , $selected_datasets_dmdd['zebra_forms']['default'] )
            &&
            is_string( $selected_datasets_dmdd['zebra_forms']['default']['inline_scripts_or_other_html'] )
            &&
            trim( $selected_datasets_dmdd['zebra_forms']['default']['inline_scripts_or_other_html'] ) !== ''
        ) {
        $add_edit_form .= "\n" . trim( $selected_datasets_dmdd['zebra_forms']['default']['inline_scripts_or_other_html'] ) ;
    }

    // -------------------------------------------------------------------------
    // Add ONFOCUS / ONBLUR HANDLERS (to highlight the currently selected
    // field's background)...
    // -------------------------------------------------------------------------

//      el.parentNode.style.backgroundColor = '#E4F9EB' ;   //  Light Green
//      el.parentNode.style.backgroundColor = '#F9E4F2' ;   //  Light Pink
//      el.parentNode.style.backgroundColor = '#F9EBE4' ;   //  Light Orange
//      el.parentNode.style.backgroundColor = '#C8F3EB' ;   //  Light Cyan

    $add_edit_form .= "\n" . <<<EOT
<script type="text/javascript">
    function greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager_addEditRecord_zebraForm_onfocus(el) {
//      el.parentNode.greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager_addEditRecord_zebraForm_oldBg = el.parentNode.style.backgroundColor ;
//      el.parentNode.style.backgroundColor = '#D6F6F0' ;   //  Light Cyan
        var ancestor ;
        if ( el.type === 'radio' ) {
            ancestor = el.parentNode.parentNode ;
        } else {
            ancestor = el.parentNode ;
        }
        ancestor.greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager_addEditRecord_zebraForm_oldBg = ancestor.style.backgroundColor ;
        ancestor.style.backgroundColor = '#D6F6F0' ;   //  Light Cyan
    }
    function greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager_addEditRecord_zebraForm_onblur(el) {
        if ( typeof el.parentNode.greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager_addEditRecord_zebraForm_oldBg !== undefined ) {
//          el.parentNode.style.backgroundColor = el.parentNode.greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager_addEditRecord_zebraForm_oldBg ;
//          delete el.parentNode.greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager_addEditRecord_zebraForm_oldBg ;
            var ancestor ;
            if ( el.type === 'radio' ) {
                ancestor = el.parentNode.parentNode ;
            } else {
                ancestor = el.parentNode ;
            }
            ancestor.style.backgroundColor = ancestor.greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager_addEditRecord_zebraForm_oldBg ;
            delete ancestor.greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager_addEditRecord_zebraForm_oldBg ;
        }
    }
</script>
EOT;

    // -------------------------------------------------------------------------
    // Focus the field to start editing with.  If NO focus field was specified,
    // focus the first field...
    // -------------------------------------------------------------------------

    $no_error_focus_field_slug = '' ;

    // -------------------------------------------------------------------------

    if (    (   isset( $selected_datasets_dmdd['zebra_forms'][ $form_slug_underscored ]['focus_field_slug'] )
                ||
                $selected_datasets_dmdd['zebra_forms'][ $form_slug_underscored ]['focus_field_slug'] === NULL
            )
            &&
            $selected_datasets_dmdd['zebra_forms'][ $form_slug_underscored ]['focus_field_slug'] !== FALSE
        ) {

        // ---------------------------------------------------------------------

        $form_field_names = array() ;

        foreach( $selected_datasets_dmdd['zebra_forms'][ $form_slug_underscored ]['field_specs'] as $this_field_spec ) {
            $form_field_names[] = $this_field_spec['form_field_name'] ;
        }

        // ---------------------------------------------------------------------

        if ( count( $form_field_names ) > 0 ) {

            // -----------------------------------------------------------------

            if (    is_string( $selected_datasets_dmdd['zebra_forms'][ $form_slug_underscored ]['focus_field_slug'] )
                    &&
                    in_array(
                        $selected_datasets_dmdd['zebra_forms'][ $form_slug_underscored ]['focus_field_slug']   ,
                        $form_field_names                                           ,
                        TRUE
                        )
                ) {

                $no_error_focus_field_slug = $selected_datasets_dmdd['zebra_forms'][ $form_slug_underscored ]['focus_field_slug'] ;

            } else {

                $no_error_focus_field_slug = $form_field_names[0] ;

            }

            // -----------------------------------------------------------------

        }

        // ---------------------------------------------------------------------

    }

    // -------------------------------------------------------------------------

//  if (    $no_error_focus_field_slug !== ''
//          &&
//          isset( $selected_datasets_dmdd['zebra_forms'][ $form_slug_underscored ]['field_specs'][ $no_error_focus_field_slug ]['type_specific_args']['id'] )
//          &&
//          is_string( $selected_datasets_dmdd['zebra_forms'][ $form_slug_underscored ]['field_specs'][ $no_error_focus_field_slug ]['type_specific_args']['id'] )
//          &&
//          ctype_graph( $selected_datasets_dmdd['zebra_forms'][ $form_slug_underscored ]['field_specs'][ $no_error_focus_field_slug ]['type_specific_args']['id'] )
//      ) {
//      $no_error_focus_field_id = $selected_datasets_dmdd['zebra_forms'][ $form_slug_underscored ]['field_specs'][ $no_error_focus_field_slug ]['type_specific_args']['id'] ;
//
//  } else {
//      $no_error_focus_field_id = '' ;
//
//  }

    // -------------------------------------------------------------------------

    if (    isset( $selected_datasets_dmdd['zebra_forms'][ $form_slug_underscored ]['form_specs']['name'] )
            &&
            is_string( $selected_datasets_dmdd['zebra_forms'][ $form_slug_underscored ]['form_specs']['name'] )
            &&
            trim( $selected_datasets_dmdd['zebra_forms'][ $form_slug_underscored ]['form_specs']['name'] ) !== ''
        ) {
        $form_name = $selected_datasets_dmdd['zebra_forms'][ $form_slug_underscored ]['form_specs']['name'] ;

    } else {
        $form_name = '' ;

    }

    // -------------------------------------------------------------------------

    if (    isset( $error_field_slug )
            &&
            is_string( $error_field_slug )
            &&
            trim( $error_field_slug ) !== ''
        ) {

        if ( $form_name !== '' ) {

            $jQuery_selector_for_field_that_caused_error = <<<EOT
form[name="{$form_name}"] input[name="{$error_field_slug}"]
EOT;

        } else {

            $jQuery_selector_for_field_that_caused_error = <<<EOT
input[name="{$error_field_slug}"]
EOT;

        }

        $set_class_for_field_that_caused_error = <<<EOT
error_inputs = jQuery( '{$jQuery_selector_for_field_that_caused_error}' ) ;
if ( typeof error_inputs === 'object' && error_inputs.length > 0 ) {
    error_inputs.addClass( 'error' ) ;
}
EOT;

    } else {

        $set_class_for_field_that_caused_error = '' ;

    }

    // -------------------------------------------------------------------------

    if ( $form_name !== '' ) {

        $jQuery_selector_get_all_class_equals_error_inputs = <<<EOT
form[name="{$form_name}"] input[class~="error"]
EOT;

    } else {
        $jQuery_selector_get_all_class_equals_error_inputs = 'input[class~="error"]' ;

    }

    // -------------------------------------------------------------------------

    $add_edit_form .= <<<EOT
<script type="text/javascript">
    function greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager_addEditRecord_zebraForm_focus() {
        var error_inputs ;
        {$set_class_for_field_that_caused_error}
        error_inputs = jQuery( '{$jQuery_selector_get_all_class_equals_error_inputs}' ) ;
        if ( typeof error_inputs === 'object' && error_inputs.length > 0 ) {
            error_inputs[0].focus() ;
        } else {
            if ( '{$no_error_focus_field_slug}' !== '' ) {
                document.getElementById( '{$no_error_focus_field_slug}' ).focus() ;
            }
        }
    }
    greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager_addEditRecord_zebraForm_focus() ;
</script>
EOT;

    // =========================================================================
    // If there are any "radio" buttons to be listed vertically, add the
    // necessary Javascript to the form...
    // =========================================================================

    // -------------------------------------------------------------------------
    // NOTE!
    // -----
    // By default, Zebra Form listed a bunch of "radios" ACROSS the page.
    //
    // We list them DOWN the page by using Javascript to insert a "<br />" tag
    // in front of all but the first "radio" button.
    // -------------------------------------------------------------------------

    // -------------------------------------------------------------------------
    // NOTE!
    // -----
    // Here we should have (eg):-
    //
    //      $selected_datasets_dmdd['zebra_form'] = array(
    //
    //          'form_specs'    =>  array(
    //                                  'name'                      =>  'add_edit_teaser_settings'  ,
    //                                  'method'                    =>  'POST'                      ,
    //                                  'action'                    =>  ''                          ,
    //                                  'attributes'                =>  array()                     ,
    //                                  'clientside_validation'     =>  TRUE
    //                                  )   ,
    //
    //          'field_specs'   =>  array(
    //
    //              ...
    //
    //              array(
    //                  'form_field_name'       =>  'selected_layout_slug'      ,
    //                  'zebra_control_type'    =>  'radios'                    ,
    //                  'label'                 =>  'Layout/Style/Scripts'      ,
    //                  'help_text'             =>  'xxx'                       ,
    //                  'attributes'            =>  array(
    //                                                  'style'     =>  'margin-left:1.5em'
    //                                                  )                       ,
    //                  'rules'                 =>  array()                     ,
    //                  'type_specific_args'    =>  array(
    //                      'radios'    =>  array(
    //                          'p-and-h-tags-down-the-page'        =>  '<b>P and H Tags - Down the Page</b> (default)'        ,
    //                          'p-and-h-tags-floating'             =>  '<b>P and H Tags - Floating</b>'                       ,
    //                          'div-and-span-tags-down-the-page'   =>  '<b>DIV and SPAN Tags - Down the Page</b>'             ,
    //                          'div-and-span-tags-floating'        =>  '<b>DIV and SPAN Tags - Floating</b>'                  ,
    //                          'custom'                            =>  '<b>Custom</b> (see below)'
    //                          )   ,
    //                      'question_vertical'     =>  TRUE
    //                      )
    //                  )
    //
    //              ...
    //
    //              )
    //
    //          )
    //
    // -------------------------------------------------------------------------

    // -------------------------------------------------------------------------
    // NOTE!
    // -----
    // Here we should have (eg):-
    //
    //      <form   name="add_edit_teaser_settings"
    //              id="add_edit_teaser_settings"
    //              action="/plugdev/wp-admin/...&amp;record_key=5344d9dc6dfb1"
    //              method="post"
    //              target="_parent"
    //              class="Zebra_Form"
    //              >
    //
    //          <div class="hidden">
    //              ...
    //          </div>
    //
    //          <div class="row">
    //
    //              <label id="label_for_selected_layout_slug">Layout/Style/Scripts</label>
    //
    //              <div class="note" id="note_for_selected_layout_slug">
    //                  <div style="margin-bottom:0.35em; font-size:120%; color:#333333">
    //                      Select the HTML (layouts), CSS (styles) and Javascript (scripts)
    //                      you want the teasers displayed with.&nbsp; This can be one of
    //                      the four built-in Layouts/Styles/Scripts.&nbsp; Or some custom
    //                      HTML, CSS and Javascript you've created yourself.
    //                  </div>
    //              </div>
    //
    //              <div class="cell">
    //                  <input  type="radio"
    //                          name="selected_layout_slug"
    //                          id="selected_layout_slug_p-and-h-tags-down-the-page"
    //                          value="p-and-h-tags-down-the-page"
    //                          class="control radio"
    //                          style="margin-left:1.5em"
    //                          onfocus="greatKiwi_byFernTec..._zebraForm_onfocus(this)"
    //                          onblur="greatKiwi_byFernTec_..._zebraForm_onblur(this)"
    //                          >
    //              </div>
    //              <div class="cell">
    //                  <label  for="selected_layout_slug_p-and-h-tags-down-the-page"
    //                          id="label_selected_layout_slug_p-and-h-tags-down-the-page"
    //                          class="option"
    //                          ><b>P and H Tags - Down the Page</b> (default)</label>
    //              </div>
    //              <div class="clear"></div>
    //
    //              <div class="cell">
    //                  <input  type="radio"
    //                          name="selected_layout_slug"
    //                          id="selected_layout_slug_p-and-h-tags-floating"
    //                          value="p-and-h-tags-floating"
    //                          class="control radio"
    //                          style="margin-left:1.5em"
    //                          onfocus="greatKiwi_byFernTec_...zebraForm_onfocus(this)"
    //                          onblur="greatKiwi_byFernTec_...zebraForm_onblur(this)"
    //                          checked="checked"
    //                          >
    //              </div>
    //              <div class="cell">
    //                  <label  for="selected_layout_slug_p-and-h-tags-floating"
    //                          id="label_selected_layout_slug_p-and-h-tags-floating"
    //                          class="option"
    //                          ><b>P and H Tags - Floating</b></label>
    //              </div>
    //              <div class="clear"></div>
    //
    //              ...
    //
    //          </div>
    //
    //          ...
    //
    //      </form>
    //
    // -------------------------------------------------------------------------

    $vertical_radio_field_names = array() ;

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr(
//    $selected_datasets_dmdd['zebra_forms'][ $form_slug_underscored ]
//    ) ;

    foreach ( $selected_datasets_dmdd['zebra_forms'][ $form_slug_underscored ]['field_specs'] as $zebra_field_index => $zebra_field_data ) {

        if (    $zebra_field_data['zebra_control_type'] === 'radios'
                &&
                array_key_exists( 'type_specific_args' , $zebra_field_data )
                &&
                array_key_exists( 'question_vertical' , $zebra_field_data['type_specific_args'] )
                &&
                $zebra_field_data['type_specific_args']['question_vertical'] === TRUE
            ) {

            $vertical_radio_field_names[] = $zebra_field_data['form_field_name'] ;

        }

    }

    // -------------------------------------------------------------------------

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $vertical_radio_field_names ) ;

    if ( count( $vertical_radio_field_names ) > 0 ) {

        // ---------------------------------------------------------------------

        $commands = '' ;

        // ---------------------------------------------------------------------

        foreach ( $vertical_radio_field_names as $radio_name ) {
            $commands .= <<<EOT
teaserMaker_std_v0x1x114_make_zebra_radios_vertical('{$radio_name}') ;\n
EOT;
        }

        // ---------------------------------------------------------------------

        $add_edit_form .= <<<EOT
<script type="text/javascript">
    function teaserMaker_std_v0x1x114_make_zebra_radios_vertical( radio_name ) {
return ;
//alert(radio_name);
        var the_radios = jQuery( 'form#{$form_name} input[type="radio"][name="' + radio_name + '"]' ) ;
        var i , j = the_radios.length ;
//alert( j ) ;
        for ( i=1 ; i<j ; i++ ) {
alert( the_radios[i] )
//          the_radios[i].style.backgroundColor = '#FFFF00' ;
//          the_radios[i].style.border = '1px solid #000000' ;
//          the_radios[i].style.display = 'none' ;
            the_radios[i].parentNode.innerHTML = '<br />' + the_radios[i].parentNode.innerHTML ;
//          jQuery( the_radios[i] ).css( 'backgroundColor' , '#FFFF00' ) ;
        }
    }
    {$commands}
</script>
EOT;

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // Get the URL of the DIR that Zebra Form is in...
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

    $zebra_form_master_dir_path = $caller_apps_includes_dir . '/Zebra_Form-master' ;

    // -------------------------------------------------------------------------

    $zebra_form_master_dir_url =
        \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_pathUtils\wp_path2url( $zebra_form_master_dir_path ) ;

    // -------------------------------------------------------------------------

    if ( is_array( $zebra_form_master_dir_url ) ) {

        return standard_dataset_manager_error(
                    $home_page_title                    ,
                    $zebra_form_master_dir_url[0]       ,
                    $caller_apps_includes_dir           ,
                    $question_front_end
                    ) ;

    }

    // =========================================================================

/*
    if (    isset( $question_redisplay_form )
            &&
            $question_redisplay_form === TRUE
        ) {

        $leave_iframe = <<<EOT
<script type="text/javascript">
//  window.parent.document = document ;
    window.parent.window.parent.document.getElementById( 'greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager_addEditForm_iframe' ).style.visibility = 'visible' ;
</script>
EOT;

    } else {

        $leave_iframe = '' ;

    }
*/

    // =========================================================================
    // Create the HTML for the page to go in the IFRAME...
    // =========================================================================

    // -------------------------------------------------------------------------
    // NOTE!
    // =====
    // We display the form proper in an IFRAME.  To stop the WordPress and
    // theme CSS and Javascript from interfering with the Zebra Form CSS
    // and Javascript.
    // -------------------------------------------------------------------------

    $includes_url = rtrim( includes_url() , '/' ) ;

//pr( $includes_url ) ;

    // -------------------------------------------------------------------------

    $iframe_page_html = <<<EOT
<!DOCTYPE html>
<html>

    <head>
        <title>Manage "{$dataset_title}" Table</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="{$zebra_form_master_dir_url}/public/css/zebra_form.css">
        <script type="text/javascript" src="{$includes_url}/js/jquery/jquery.js"></script>
        <script type="text/javascript" src="{$zebra_form_master_dir_url}/public/javascript/zebra_form.js"></script>
        <style type="text/css">
            /* Fix up the "Cancel" button's styling... (Mozilla on Ubuntu) */
/*          form.Zebra_Form button#cancel {
                font-size: 111%;
                color: #000000;
            }
            form.Zebra_Form button#cancel:hover {
                color: #FFFFFF;
            }   */
        </style>
    </head>
    <body style="font-family:sans-serif; font-size:13px">
{$add_edit_form}
    </body>
</html>
EOT;

    // =========================================================================
    // SAVE the page in the BASEPRESS PAGE CACHE...
    // =========================================================================

    require_once( $caller_apps_includes_dir . '/wordpress-page-cache.php' ) ;

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_wordpressPageCache\set_page(
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

    // -------------------------------------------------------------------------
    // <plugin_root_dir>/apps-api.php
    // - - - - - - - - - - - - - - -
    // Defines:-
    //
    //      get_plugin_root_dir_basename_raw()
    //
    //      get_plugin_slug_dashed()
    //      get_plugin_slug_underscored()
    //      get_plugin_title()
    //      get_plugin_camel_name()
    //      get_plugin_version_raw()
    //      get_plugin_version_alnum()
    //
    //      get_plugin_root_dir()
    //      convert_root_relative_plugin_pathspec_2_absolute()
    //      get_plugins_app_defs_dir()
    //      get_plugins_includes_dir()
    //      get_single_apps_dot_app_dir()
    //      get_core_plugapp_dirs()
    //
    // All in the:-
    //      greatKiwi_byFernTec_teaserMaker_std_v0x1x114_appsAPI
    // namespace.
    //
    // And where:-
    //      get_core_plugapp_dirs()
    //
    // returns:-
    //      array(
    //          'plugin_root_dir'                   =>  "xxx"   ,
    //          'plugins_includes_dir'              =>  "xxx"   ,
    //          'plugins_app_defs_dir'              =>  "xxx"   ,
    //          'dataset_manager_includes_dir'      =>  "xxx"   ,
    //          'apps_dot_app_dir'                  =>  "xxx"   ,
    //          'apps_plugin_stuff_dir'             =>  "xxx"
    //          )
    // -------------------------------------------------------------------------

//      $fn = <<<EOT
//  \\{$caller_app_slash_plugins_global_namespace}\\get_caller_app_slash_plugins_unique_name
//  EOT;
//
//  $page_name =    $fn() .
//                  '-great-kiwi-standard-dataset-manager-add-edit-form'
//                  ;

    $page_name =    \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_appsAPI\get_plugin_slug_dashed() .
                    '-great-kiwi-standard-dataset-manager-add-edit-form'
                    ;

    $question_session_specific    = TRUE ;
    $question_remote_ip_specific  = TRUE ;
    $question_user_agent_specific = TRUE ;
    $question_page_key            = TRUE ;

    // -------------------------------------------------------------------------

    $page_key = \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_wordpressPageCache\set_page(
                    $page_name                      ,
                    $question_session_specific      ,
                    $question_remote_ip_specific    ,
                    $question_user_agent_specific   ,
                    $question_page_key              ,
                    $iframe_page_html
                    ) ;

    // -------------------------------------------------------------------------

    if ( is_array( $page_key ) ) {

        return standard_dataset_manager_error(
                    $home_page_title                ,
                    $page_key[0]                    ,
                    $caller_apps_includes_dir       ,
                    $question_front_end
                    ) ;

    }

    // =========================================================================
    // Get the URL of the CACHED PAGE...
    // =========================================================================

//  require_once( $caller_apps_includes_dir . '/path-utils.php' ) ;

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

    $iframe_src_url =
        \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_pathUtils\wp_path2url( $iframe_src_path ) ;

    // -------------------------------------------------------------------------

    if ( is_array( $iframe_src_url ) ) {

        return standard_dataset_manager_error(
                    $home_page_title                ,
                    $iframe_src_url[0]              ,
                    $caller_apps_includes_dir       ,
                    $question_front_end
                    ) ;

    }

    // =========================================================================
    // "RAW MODE" BUTTON ?
    // =========================================================================

    if ( function_exists( '\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\is_raw_mode_for_forms' ) ) {

        // ---------------------------------------------------------------------

        if ( \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\is_raw_mode_for_forms() === TRUE ) {
            $raw_mode_is   = 'ON'  ;
            $turn_raw_mode = 'OFF' ;
            $onclick       = 'great_kiwi_dataset_manager_raw_mode_for_forms_OFF(this)' ;

        } else {
            $raw_mode_is   = 'OFF' ;
            $turn_raw_mode = 'ON'  ;
            $onclick       = 'great_kiwi_dataset_manager_raw_mode_for_forms_ON(this)' ;

        }

        // ---------------------------------------------------------------------

        $js_dir_url = \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_appsAPI\get_js_url() ;

        // ---------------------------------------------------------------------

        $left_margin = 'margin-left:3em;' ;

        // ---------------------------------------------------------------------

        $raw_mode_button = <<<EOT
<a  href="javascript:void()"
    onclick="{$onclick}"
    style="{$left_margin}padding:3px 10px; background-color:#F1F1F1; font-size: 110%; font-weight:normal; text-decoration:none; text-align:left; position:relative; top:-0.15em"
    >Raw Mode is {$raw_mode_is}; Turn it {$turn_raw_mode}</a>
<script type="text/javascript"
        src="{$js_dir_url}/scottHamperCookies.js"
        ></script>
<script type="text/javascript">
    function great_kiwi_dataset_manager_raw_mode_for_forms_ON( a_el ) {
        scottHamperCookies.set( 'gk_dm_rawMode_forForms' , '1' ) ;
        location.reload( true ) ;
    }
    function great_kiwi_dataset_manager_raw_mode_for_forms_OFF( a_el ) {
        scottHamperCookies.set( 'gk_dm_rawMode_forForms' , '0' ) ;
        location.reload( true ) ;
    }
</script>
EOT;

        // ---------------------------------------------------------------------

    } else {

        $raw_mode_button = '' ;

    }

    // =========================================================================
    // DISPLAY the PAGE...
    // =========================================================================

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $display_options = Array(
    //          [question_show_email]           => TRUE | FALSE
    //          [question_show_page_header]     => TRUE | FALSE
    //          [question_show_table_header]    => TRUE | FALSE
    //          )
    //
    // -------------------------------------------------------------------------

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $display_options ) ;

    $question_show_page_header  = TRUE ;
    $question_show_table_header = TRUE ;

    // -------------------------------------------------------------------------

    if ( is_array( $display_options ) ) {

        // ---------------------------------------------------------------------

        if (    array_key_exists( 'question_show_page_header' , $display_options )
                &&
                is_bool( $display_options['question_show_page_header'] )
            ) {
            $question_show_page_header = $display_options['question_show_page_header'] ;
        }

        // ---------------------------------------------------------------------

        if (    array_key_exists( 'question_show_table_header' , $display_options )
                &&
                is_bool( $display_options['question_show_table_header'] )
            ) {
            $question_show_table_header = $display_options['question_show_table_header'] ;
        }

        // ---------------------------------------------------------------------

    }

    // -------------------------------------------------------------------------

    if ( $question_show_page_header ) {

        if (    isset( $_GET['view_title'] )
                &&
                trim( $_GET['view_title'] ) !== ''
                &&
                strip_tags( $_GET['view_title'] ) === $_GET['view_title']
            ) {
            $page_title = htmlentities( $_GET['view_title'] ) ;

        } else {
            $page_title = 'Manage ' . $selected_datasets_dmdd['dataset_title_plural'] ;

        }

    } else {
        $page_title = '' ;

    }

    // -------------------------------------------------------------------------

    if ( $question_show_table_header ) {

        // ---------------------------------------------------------------------

        if (    isset( $_GET['return_to'] )
                &&
                trim( $_GET['return_to'] ) !== ''
                &&
                \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_stringUtils\ctype_alphanumeric_underscore_dash( $_GET['return_to'] )
                &&
                isset( $_GET['view_slug'] )
                &&
                trim( $_GET['view_slug'] ) !== ''
                &&
                \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_stringUtils\ctype_alphanumeric_underscore_dash( $_GET['view_slug'] )
            ) {

            // -----------------------------------------------------------------

            require_once( dirname( __FILE__ ) . '/get-view-urls.php' ) ;

            // -------------------------------------------------------------------------
            // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\get_show_view_url(
            //      $caller_apps_includes_dir   ,
            //      $question_front_end         ,
            //      $view_slug = NULL
            //      )
            // - - - - - - - - - - - - - - - - - - - - - - - - - - -
            // Returns the "show-view" URL.
            //
            // If $view_slug is NULL, then we use:-
            //      $_GET['view_slug']
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

            $page_title_href = get_show_view_url(
                                    $caller_apps_includes_dir   ,
                                    $question_front_end         ,
                                    $_GET['view_slug']
                                    ) ;

            // -----------------------------------------------------------------

        } else {

            // -----------------------------------------------------------------

            require_once( dirname( __FILE__ ) . '/get-dataset-urls.php' ) ;

            // -------------------------------------------------------------------------
            // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\get_manage_dataset_url(
            //      $caller_apps_includes_dir   ,
            //      $question_front_end         ,
            //      $dataset_slug = NULL
            //      )
            // - - - - - - - - - - - - - - - - -
            // Returns the "manage-dataset" URL.
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

            $page_title_href = get_manage_dataset_url(
                                    $caller_apps_includes_dir   ,
                                    $question_front_end         ,
                                    NULL
                                    ) ;

            // -----------------------------------------------------------------

        }

        // ---------------------------------------------------------------------

        if ( is_array( $page_title_href ) ) {

            return standard_dataset_manager_error(
                        $home_page_title                ,
                        $page_title_href[0]             ,
                        $caller_apps_includes_dir       ,
                        $question_front_end
                        ) ;

        }

        // ---------------------------------------------------------------------

    }

    // -------------------------------------------------------------------------

    if ( $question_show_table_header ) {

        // ---------------------------------------------------------------------

        $sub_page_title = '' ;

        // ---------------------------------------------------------------------

        if ( $question_adding ) {
            $field_name = 'custom_form_title_add' ;
        } else {
            $field_name = 'custom_form_title_edit' ;
        }

        // ---------------------------------------------------------------------

        if (    array_key_exists( $field_name , $selected_datasets_dmdd['zebra_forms'][ $form_slug_underscored ]['form_specs'] )
                &&
                is_string( $selected_datasets_dmdd['zebra_forms'][ $form_slug_underscored ]['form_specs'][ $field_name ] )
                &&
                trim( $selected_datasets_dmdd['zebra_forms'][ $form_slug_underscored ]['form_specs'][ $field_name ] ) !== ''
            ) {

            $sub_page_title = trim( $selected_datasets_dmdd['zebra_forms'][ $form_slug_underscored ]['form_specs'][ $field_name ] ) ;

        } else {

            if ( $question_adding ) {
                $sub_page_title = 'Add ' . $selected_datasets_dmdd['dataset_title_singular']  ;
            } else {
                $sub_page_title = 'Edit ' . $selected_datasets_dmdd['dataset_title_singular']  ;
            }

        }

        // ---------------------------------------------------------------------

    }

    // -------------------------------------------------------------------------

    $buttons_right = $raw_mode_button ;

    // -------------------------------------------------------------------------

    if (    $question_show_page_header
            &&
            $question_show_table_header
        ) {

        echo get_sub_page_header(
                $page_title                 ,
                $page_title_href            ,
                $sub_page_title             ,
                $caller_apps_includes_dir   ,
                $question_front_end         ,
                $buttons_right
                ) ;

    } elseif ( $question_show_page_header ) {

        echo get_sub_page_header(
                $page_title                 ,
                $page_title_href            ,
                $sub_page_title             ,
                $caller_apps_includes_dir   ,
                $question_front_end         ,
                $buttons_right
                ) ;

    }

    // -------------------------------------------------------------------------

    $min_iframe_height_in_px = 800 ;

    // -------------------------------------------------------------------------

//  style="border:1px solid #000000"

    echo <<<EOT
<iframe
    id="greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager_addEditForm_iframe"
    src="{$iframe_src_url}"
    width="98%"
    height="{$min_iframe_height_in_px}"
    frameborder="0"
    ></iframe>
<br />
<br />
<script type="text/javascript">
    function teaserMaker_std_v0x1x114_adjust_iframe_height() {
        var iframe_el = document.getElementById(
            'greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager_addEditForm_iframe'
            ) ;
        if ( iframe_el ) {
            var iframe_document = iframe_el.contentWindow.document ;
            if ( ! iframe_document ) {
                iframe_document = iframe_el.contentDocument.document ;
            }
            if ( ! iframe_document ) {
                iframe_document = iframe_el.contentDocument ;
            }
//alert( 'Form name: "{$form_name}"' ) ;
            if ( iframe_document && '{$form_name}' !== '' ) {
//              var iframe_document_height = Math.max(
//                  iframe_document.body.scrollHeight               ,
//                  iframe_document.documentElement.scrollHeight    ,
//                  iframe_document.body.offsetHeight               ,
//                  iframe_document.documentElement.offsetHeight    ,
//                  {$min_iframe_height_in_px}
//                  ) ;
//              iframe_el.style.height = ( iframe_document_height ) + 'px' ;
//              var new_iframe_height = jQuery( iframe_document ).find( form#{$form_name} ).
                var form_el = iframe_document.getElementById( '{$form_name}' ) ;
//alert( form_el ) ;
                if ( form_el ) {
                    var new_iframe_height = Math.max(
                        form_el.scrollHeight        ,
                        form_el.offsetHeight        ,
                        {$min_iframe_height_in_px}
                        ) ;
//alert( new_iframe_height ) ;
                    iframe_el.style.height = ( new_iframe_height + 30 ) + 'px' ;
                }
            }
        }
    }
    setTimeout( "teaserMaker_std_v0x1x114_adjust_iframe_height()" , 1000 ) ;
</script>
EOT;
        //  NOTE!
        //  -----
        //  The id="greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager_addEditForm_iframe" is
        //  so that we can hide the IFRAME before submitting it - to avoid
        //  the flash of content when the submitted page returns - but
        //  before it redirects the page containing the IFRAME to the
        //  dataset records listing page.

    // =========================================================================
    // That's that!
    // =========================================================================

}

// =============================================================================
// get_record_to_be_edited()
// =============================================================================

function get_record_to_be_edited(
    $dataset_records        ,
    $record_indices_by_key  ,
    $dataset_title
    ) {

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

    // -------------------------------------------------------------------------
    // Init...
    // -------------------------------------------------------------------------

    $ns = __NAMESPACE__ ;
    $fn = __FUNCTION__ ;

    // -------------------------------------------------------------------------
    // Get the GET VARIABLE NAME for the record to be edited's "key"...
    // -------------------------------------------------------------------------

    $key_field_get_var_name = 'record_key' ;

    // -------------------------------------------------------------------------
    // Is that GET VARIABLE present ?
    // -------------------------------------------------------------------------

    if ( ! isset( $_GET[ $key_field_get_var_name ] ) ) {

        return <<<EOT
PROBLEM Editing Dataset Record:&nbsp; No "record_key"
For dataset:&nbsp; "{$dataset_title}"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

    }

    // -------------------------------------------------------------------------
    // Does the "key", specified by the "key" GET VARIABLE, look valid ?
    // -------------------------------------------------------------------------

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
                $_GET[ $key_field_get_var_name ]
                )
        ) {

        return <<<EOT
PROBLEM editing dataset record:&nbsp; Bad "record_key"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

    }

    // -------------------------------------------------------------------------
    // Does the "key", specified by the "key" GET VARIABLE, point to an
    // existing dataset record ?
    // -------------------------------------------------------------------------

    if ( ! array_key_exists( $_GET[ $key_field_get_var_name ] , $record_indices_by_key ) ) {

        return <<<EOT
PROBLEM Editing Dataset Record:&nbsp; Bad "record_key" (no such record)
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

    }

    // -------------------------------------------------------------------------
    // OK; we've found the record to be edited...
    // -------------------------------------------------------------------------

    return array(
                $dataset_records[ $record_indices_by_key[ $_GET[ $key_field_get_var_name ] ] ]      ,
                $record_indices_by_key[ $_GET[ $key_field_get_var_name ] ]
                ) ;

    // -------------------------------------------------------------------------

}

// =============================================================================
// That's that!
// =============================================================================

