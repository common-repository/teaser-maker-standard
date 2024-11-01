<?php

// *****************************************************************************
// STANDARD-DATASET-MANAGER / DELETE-RECORD.PHP
// (C) 2013 Peter Newman. All Rights Reserved.
// *****************************************************************************

    namespace greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager ;

// =============================================================================
// delete_record()
// =============================================================================

function delete_record(
    $caller_app_slash_plugins_global_namespace      ,
    $home_page_title                                ,
    $caller_apps_includes_dir                       ,
    $all_application_dataset_definitions            ,
    $top_level_dataset_slug                         ,
    $question_front_end
    ) {

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\delete_record(
    //      $caller_app_slash_plugins_global_namespace      ,
    //      $home_page_title                                ,
    //      $caller_apps_includes_dir                       ,
    //      $all_application_dataset_definitions            ,
    //      $top_level_dataset_slug                         ,
    //      $question_front_end
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - - -
    // Deletes the specified record - then returns to the dataset management
    // screen.
    //
    // $all_application_dataset_definitions should be like (eg):-
    //
    //      $all_application_dataset_definitions = Array(
    //
    //          [projects] => Array(    //  <== "dataset_slug"
    //              ...
    //              [dataset_slug]              =>  'projects'
    //              [dataset_name_singular]     =>  'project'
    //              [dataset_name_plural]       =>  'projects'
    //              [dataset_title_singular]    =>  'Project'
    //              [dataset_title_plural]      =>  'Projects'
    //              [basepress_dataset_handle]  =>  array(...)
    //              ...
    //      //      'parent_details'                            =>  array(
    //      //          'type'                  =>  'none'              ,
    //      //          'type_specific_args'    =>  <any_PHP_value>     //  (this key and value, if specified,  are IGNORED)
    //      //          )
    //      //          //  This dataset's records have NO PARENT.  They may however
    //      //          //  have CHILDREN (see "child_dataset_slugs", below).
    //              ...
    //      //      'parent_details'                            =>  array(
    //      //          'type'                  =>  'single-parent-key-field'   .
    //      //          'type_specific_args'    =>  array(
    //      //              'parent_dataset_slug'                       =>  'xxx'   ,
    //      //              'parent_dataset_key_field_slug'             =>  'yyy'
    //      //              )
    //      //          )
    //      //          //  This dataset's records ***may*** optionally have a PARENT.
    //      //          //  o   "parent_dataset_slug" must be a non-empty string.
    //      //          //  o   The array storage record's:-
    //      //          //          "<parent_dataset_key_field_slug>"
    //      //          //      field may contain either:-
    //      //          //          --  The empty string (in which case, this child
    //      //          //              record has NO parent), or;
    //      //          //          --  A "record key" from the parent dataset.
    //      //          //
    //      //          //  The dataset records may have CHILDREN too (see
    //      //          //  "child_dataset_slugs", below).
    //              ...
    //      //      'parent_details'                            =>  array(
    //      //          'type'                  =>  'parent-type-and-key-fields'
    //      //          'type_specific_args'    =>  array(
    //      //              'parent_type_field_slug'            =>  'parent_is'     ,
    //      //              'parent_key_field_slug'             =>  'parent_key'    ,
    //      //              'parent_dataset_slugs_by_value'     =>  array(
    //      //                  'document'  =>  'documents'     ,
    //      //                  'section'   =>  'sections'
    //      //                  )
    //      //              )
    //      //          )
    //      //          //  This dataset's records ***may*** optionally have a PARENT.
    //      //          //  o   If the "parent_type_field_slug" field contains the
    //      //          //      empty string, then this record has NO parent (and
    //      //          //      the "parent_key_field_slug" field in IGNORED).
    //      //          //  o   If the "parent_type_field_slug" field contains a
    //      //          //      non-empty string, then the:-
    //      //          //          "parent_dataset_slugs_by_value"
    //      //          //      field maps values in the "parent_type_field_slug"
    //      //          //      field, to the dataset the record belongs to.
    //      //          //
    //      //          //  The dataset records may have CHILDREN too (see
    //      //          //  "child_dataset_slugs", below).
    //              ...
    //      //      'parent_details'                            =>  array(
    //      //          'type'                  =>  'separate-parent-key-fields'
    //      //          'type_specific_args'    =>  array(
    //      //              'parent_dataset_slugs_by_key_field_slug'    =>  array(
    //      //                  'document_key'  =>  'documents'     ,
    //      //                  'section_key'   =>  'sections'
    //      //                  )
    //      //          )
    //      //          //  This dataset's records ***may*** optionally have a PARENT.
    //      //          //  o   If ALL of the "parent dataset key" fields contain
    //      //          //      the empty string, then the record concerned has
    //      //          //      NO parent.
    //      //          //  o   If exactly ONE of the "parent dataset key" fields
    //      //          //      contains a non-empty string value, then the record
    //      //          //      concerned has the parent specified.
    //      //          //  o   If MORE THAN ONE of the "parent dataset key" fields
    //      //          //      has a non-empty string value, then it's an ERROR.
    //      //          //
    //      //          //  The dataset records may have CHILDREN too (see
    //      //          //  "child_dataset_slugs", below).
    //              ...
    //              'child_dataset_slugs'                       =>  array( 'shots' )
    //              ...
    //              )
    //
    //          ...
    //
    //          )
    //
    // NOTE!
    // =====
    // 1.   The record(s) to be deleted are specified in $_GET, as follows:-
    //                                                                                   t
    //          $_GET = array(
    //                      ...
    //                      [dataset_slug]  =>  projects
    //                      [record_key]    =>  "xxx" --or-- "*a*l*l*"
    //                      ...
    //                      )
    //
    //      Where "record_key" =="*a*l*l*" means delete ALL the records in the
    //      specified dataset.
    //
    // 2.   Any records owned by the records being deleted will also be deleted.
    //
    //      The records that a record being deleted owns are specified by the:-
    //          "parent_details" and;
    //          "child_dataset_slugs"
    //
    //      fields in each datasets definition.
    //
    // 3.   The:-
    //          <dataset-definition>['parent_details']
    //      field is used when processing ORPHANED RECORDS too (see:-
    //      "orphaned-records.php").
    //
    // RETURNS:-
    //      Nothing
    // -------------------------------------------------------------------------

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //                                                                                   t
    //      $_GET = array(
    //                  [page]          =>  appName
    //                  [action]        =>  delete-record
    //                  [application]   =>  research-assistant
    //                  [dataset_slug]  =>  projects
    //                  [record_key]    =>  "xxx" --or-- "*a*l*l*"
    //                  )
    //
    // -------------------------------------------------------------------------

//pr( $_GET ) ;

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
    $fn = __FUNCTION__  ;

    // =========================================================================
    // Get the specified dataset's DATASET MANAGER DATASET DEFINITION...
    // =========================================================================

    $top_level_datasets_dmdd = $all_application_dataset_definitions[ $top_level_dataset_slug ] ;
                                    //  dmdd = Dataset Manager Dataset Definition

    // =========================================================================
    // Get the ERROR PAGE TITLE and DATASET TITLE (for use in error messages)...
    // =========================================================================

    $error_page_title = 'Delete Record' ;

    // -------------------------------------------------------------------------

    if (    isset( $top_level_datasets_dmdd['dataset_title_plural'] )
            &&
            is_string( $top_level_datasets_dmdd['dataset_title_plural'] )
            &&
            trim( $top_level_datasets_dmdd['dataset_title_plural'] ) !== ''
        ) {
        $top_level_dataset_title = $top_level_datasets_dmdd['dataset_title_plural'] ;

    } else {
        $top_level_dataset_title = to_title( $top_level_dataset_slug ) ;

    }

    // =========================================================================
    // ERROR CHECKING...
    // =========================================================================

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //                                                                                   t
    //      $_GET = array(
    //                  [page]          =>  appName
    //                  [action]        =>  delete-record
    //                  [application]   =>  research-assistant
    //                  [dataset_slug]  =>  projects
    //                  [record_key]    =>  "xxx" --or-- "*a*l*l*"
    //                  )
    //
    // -------------------------------------------------------------------------

    // -------------------------------------------------------------------------
    // Get the GET VARIABLE NAME for the record to be edited's "key"...
    // -------------------------------------------------------------------------

    $key_field_get_var_name = 'record_key' ;

    // -------------------------------------------------------------------------
    // Is that GET VARIABLE present ?
    // -------------------------------------------------------------------------

    if ( ! isset( $_GET[ $key_field_get_var_name ] ) ) {

        $msg = <<<EOT
PROBLEM Deleting Dataset Record(s):&nbsp; No "record_key"
For dataset:&nbsp; "{$top_level_dataset_title}"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        echo standard_dataset_manager_error(
                $error_page_title           ,
                $msg                        ,
                $caller_apps_includes_dir   ,
                $question_front_end
                ) ;

        exit() ;

    }

    // -------------------------------------------------------------------------
    // page ?
    // -------------------------------------------------------------------------

    //  TODO

    // -------------------------------------------------------------------------
    // action ?
    // -------------------------------------------------------------------------

    //  TODO

    // -------------------------------------------------------------------------
    // application ?
    // -------------------------------------------------------------------------

    //  TODO

    // -------------------------------------------------------------------------
    // Does the "key", specified by the "key" GET VARIABLE, look valid ?
    // -------------------------------------------------------------------------

    if ( $_GET[ $key_field_get_var_name ] !== '*a*l*l*' ) {

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

            $msg = <<<EOT
PROBLEM Deleting Dataset Record(s):&nbsp; Bad "record_key"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

            echo standard_dataset_manager_error(
                    $error_page_title           ,
                    $msg                        ,
                    $caller_apps_includes_dir   ,
                    $question_front_end
                    ) ;

            exit() ;

            // -----------------------------------------------------------------

        }

        // ---------------------------------------------------------------------

    }

    // -------------------------------------------------------------------------
    // dataset_slug ?
    // -------------------------------------------------------------------------

    if ( ! array_key_exists( 'dataset_slug' , $_GET ) ) {

        $msg = <<<EOT
PROBLEM Deleting Dataset Record(s):&nbsp; No "dataset_slug"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        echo standard_dataset_manager_error(
                $error_page_title           ,
                $msg                        ,
                $caller_apps_includes_dir   ,
                $question_front_end
                ) ;

        exit() ;

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
                    $_GET['dataset_slug']                   ,
                    $all_application_dataset_definitions
                    ) ;

    // -------------------------------------------------------------------------

    if ( is_string( $result ) ) {

        echo standard_dataset_manager_error(
                $error_page_title           ,
                $result                     ,
                $caller_apps_includes_dir   ,
                $question_front_end
                ) ;

        exit() ;

    }

    // -------------------------------------------------------------------------

    if ( $_GET['dataset_slug'] !== $top_level_dataset_slug ) {

        $msg = <<<EOT
PROBLEM Deleting Dataset Record(s):&nbsp; "dataset_slug" mismatch
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        echo standard_dataset_manager_error(
                $error_page_title           ,
                $msg                        ,
                $caller_apps_includes_dir   ,
                $question_front_end
                ) ;

        exit() ;

    }

    // =========================================================================
    // LOAD the (TOP LEVEL) DATASET TITLE, RECORDS, KEY FIELD SLUG and
    // RECORD INDICES BY KEY (from array storage)...
    // =========================================================================

    require_once( $caller_apps_includes_dir . '/array-storage.php' ) ;

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
                    $top_level_dataset_slug
                    ) ;

    // -------------------------------------------------------------------------

    if ( is_string( $result ) ) {

        echo standard_dataset_manager_error(
                $error_page_title           ,
                $result                     ,
                $caller_apps_includes_dir   ,
                $question_front_end
                ) ;

        exit() ;

    }

    // -------------------------------------------------------------------------

    list(
        $top_level_dataset_title            ,
        $top_level_dataset_records          ,
        $top_level_key_field_slug           ,
        $top_level_record_indices_by_key
        ) = $result ;

    // =========================================================================
    // Init the various top level variables used...
    //      $record_keys_to_delete__by_dataset_slug
    // =========================================================================

    $record_keys_to_delete__by_dataset_slug = array(
        $top_level_dataset_slug     =>  array()
        ) ;
        //  NOTE!
        //  =====
        //  We collect the keys to delete in this array.  And do the actual
        //  record deletion only once all the records to delete have been
        //  identified.
        //
        //  This prevents getting a half-deleted record tree - should an
        //  error occur while identifying the records to delete.

    // -------------------------------------------------------------------------

    $loaded_datasets = array(

        $top_level_dataset_slug =>  array(
            'title'                 =>  $top_level_dataset_title            ,
            'records'               =>  $top_level_dataset_records          ,
            'key_field_slug'        =>  $top_level_key_field_slug           ,
            'record_indices_by_key' =>  $top_level_record_indices_by_key
            )

        ) ;

    // -------------------------------------------------------------------------

    $validated_datasets = array() ;
        //  This is like (eg):-
        //
        //      $validated_datasets = array(
        //          "<dataset_slug_1>"  =>  <dataset_dmdd_1>        ,
        //          "<dataset_slug_2>"  =>  <dataset_dmdd_2>        ,
        //          ...
        //          "<dataset_slug_N>"  =>  <dataset_dmdd_N>
        //          )

    // -------------------------------------------------------------------------

    $validated_type_specific_args = array() ;
        //  This is like (eg):-
        //
        //      $validated_type_specific_args = array(
        //          "<dataset_slug_1>"      ,
        //          "<dataset_slug_2>"      ,
        //          ...
        //          "<dataset_slug_N>"
        //          )

    // =========================================================================
    // DELETE the specified RECORD/RECORDS...
    // =========================================================================

    // -------------------------------------------------------------------------
    // delete_records_children(
    //      $caller_apps_includes_dir                   ,
    //      $all_application_dataset_definitions        ,
    //      $question_front_end                         ,
    //      $parent_dataset_dmdd                        ,
    //      $parent_dataset_slug                        ,
    //      $parent_dataset_title                       ,
    //      $parent_record_key                          ,
    //      &$validated_datasets                        ,
    //      &$validated_type_specific_args              ,
    //      &$loaded_datasets                           ,
    //      &$record_keys_to_delete__by_dataset_slug
    //      ) {
    // - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // Delete the specified dataset record's children (if it has any) - along
    // with their children recursively.
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

    if ( $_GET[ $key_field_get_var_name ] === '*a*l*l*' ) {

        // =====================================================================
        // DELETE ***ALL*** DATASET RECORDS (from the top level dataset)...
        // =====================================================================

        $parent_dataset_dmdd  = $top_level_datasets_dmdd ;
        $parent_dataset_slug  = $top_level_dataset_slug           ;
        $parent_dataset_title = $top_level_dataset_title          ;

        // ---------------------------------------------------------------------

        foreach ( $top_level_record_indices_by_key as $parent_record_key => $parent_record_index ) {

            // -----------------------------------------------------------------
            // DELETE the specified RECORD...
            // -----------------------------------------------------------------

            $record_keys_to_delete__by_dataset_slug[
                $top_level_dataset_slug
                ][] = $parent_record_key ;

            // -----------------------------------------------------------------
            // DELETE the record's CHILDREN (if it has any)...
            // -----------------------------------------------------------------

            $result = delete_records_children(
                            $caller_apps_includes_dir                   ,
                            $all_application_dataset_definitions        ,
                            $question_front_end                         ,
                            $parent_dataset_dmdd                        ,
                            $parent_dataset_slug                        ,
                            $parent_dataset_title                       ,
                            $parent_record_key                          ,
                            $validated_datasets                         ,
                            $validated_type_specific_args               ,
                            $loaded_datasets                            ,
                            $record_keys_to_delete__by_dataset_slug
                            ) ;

            // -----------------------------------------------------------------

            if ( is_string( $result ) ) {

                echo standard_dataset_manager_error(
                        $error_page_title           ,
                        $result                     ,
                        $caller_apps_includes_dir   ,
                        $question_front_end
                        ) ;

                exit() ;

            }

            // -----------------------------------------------------------------

        }

        // ---------------------------------------------------------------------

    } else {

        // =====================================================================
        // DELETE ***SINGLE*** DATASET RECORD...
        // =====================================================================

        // ---------------------------------------------------------------------
        // Does the "key", specified by the "key" GET VARIABLE, point to an
        // existing dataset record ?
        // ---------------------------------------------------------------------

        if ( ! array_key_exists( $_GET[ $key_field_get_var_name ] , $top_level_record_indices_by_key ) ) {

            $msg = <<<EOT
PROBLEM Deleting Dataset Record(s):&nbsp; Bad "record_key" (no such record)
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

            echo standard_dataset_manager_error(
                    $error_page_title           ,
                    $msg                        ,
                    $caller_apps_includes_dir   ,
                    $question_front_end
                    ) ;

            exit() ;

        }

        // ---------------------------------------------------------------------
        // DELETE the specified RECORD...
        // ---------------------------------------------------------------------

        $record_keys_to_delete__by_dataset_slug[
            $top_level_dataset_slug
            ][] = $_GET[ $key_field_get_var_name ] ;

        // ---------------------------------------------------------------------
        // DELETE the record's CHILDREN (if it has any)...
        // ---------------------------------------------------------------------

        // -------------------------------------------------------------------------
        // delete_records_children(
        //      $caller_apps_includes_dir                   ,
        //      $all_application_dataset_definitions        ,
        //      $question_front_end                         ,
        //      $parent_dataset_dmdd                        ,
        //      $parent_dataset_slug                        ,
        //      $parent_dataset_title                       ,
        //      $parent_record_key                          ,
        //      &$validated_datasets                        ,
        //      &$validated_type_specific_args              ,
        //      &$loaded_datasets                           ,
        //      &$record_keys_to_delete__by_dataset_slug
        //      ) {
        // - - - - - - - - - - - - - - - - - - - - - - - - - - -
        // Delete the specified dataset record's children (if it has any) - along
        // with their children recursively.
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

        $parent_dataset_dmdd  = $top_level_datasets_dmdd            ;
        $parent_dataset_slug  = $top_level_dataset_slug             ;
        $parent_dataset_title = $top_level_dataset_title            ;
        $parent_record_key    = $_GET[ $key_field_get_var_name ]    ;

        // ---------------------------------------------------------------------

        $result = delete_records_children(
                        $caller_apps_includes_dir                   ,
                        $all_application_dataset_definitions        ,
                        $question_front_end                         ,
                        $parent_dataset_dmdd                        ,
                        $parent_dataset_slug                        ,
                        $parent_dataset_title                       ,
                        $parent_record_key                          ,
                        $validated_datasets                         ,
                        $validated_type_specific_args               ,
                        $loaded_datasets                            ,
                        $record_keys_to_delete__by_dataset_slug
                        ) ;

        // ---------------------------------------------------------------------

        if ( is_string( $result ) ) {

            echo standard_dataset_manager_error(
                    $error_page_title           ,
                    $result                     ,
                    $caller_apps_includes_dir   ,
                    $question_front_end
                    ) ;

            exit() ;

        }

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // DO the RECORD DELETIONS proper...
    // =========================================================================

/*
foreach ( $record_keys_to_delete__by_dataset_slug as $this_dataset_slug => $record_keys_to_delete ) {

    $temp = array_flip( $record_keys_to_delete ) ;

    $temp = array_flip( $temp ) ;

    $temp = array_flip( $temp ) ;

    foreach ( $temp as $key => $junk ) {

        $temp[ $key ] = $loaded_datasets[ $this_dataset_slug ]['records'][
                            $loaded_datasets[ $this_dataset_slug ]['record_indices_by_key'][ $key ]
                            ]['title'] ;

    }

    $record_keys_to_delete__by_dataset_slug[ $this_dataset_slug ] = $temp ;

}

\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\pr( $record_keys_to_delete__by_dataset_slug ) ;

exit() ;
*/

    foreach ( $record_keys_to_delete__by_dataset_slug as $this_dataset_slug => $record_keys_to_delete ) {
  
        // ---------------------------------------------------------------------
  
        $updated_dataset_records =
            $loaded_datasets[ $this_dataset_slug ]['records']
            ;
  
        // ---------------------------------------------------------------------
  
        $this_record_indices_by_key =
            $loaded_datasets[ $this_dataset_slug ]['record_indices_by_key']
            ;
  
        // ---------------------------------------------------------------------
  
        foreach ( $record_keys_to_delete as $this_record_key ) {
  
            unset( $updated_dataset_records[
                        $this_record_indices_by_key[
                            $this_record_key
                            ]
                        ] ) ;
  
        }
  
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
  
        // ---------------------------------------------------------------------
  
        $result = \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_arrayStorage\save_numerically_indexed(
                        $this_dataset_slug              ,
                        $updated_dataset_records        ,
                        $question_die_on_error
                        ) ;
  
        // ---------------------------------------------------------------------
  
        if ( is_string( $result ) ) {
  
            echo standard_dataset_manager_error(
                    $error_page_title           ,
                    $result                     ,
                    $caller_apps_includes_dir   ,
                    $question_front_end
                    ) ;
  
            exit() ;
  
        }
  
        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // RETURN to the "RETURN TO" page (= DATASET MANAGEMENT page, by
    // default)...
    // =========================================================================

    $allowed_return_tos = array(
        'show-view'         ,
        'manage-dataset'
        ) ;

    // -------------------------------------------------------------------------

    if (    isset( $_GET['return_to'] )
            &&
            trim( $_GET['return_to'] ) !== ''
            &&
            strlen( $_GET['return_to'] ) <= 64
            &&
            in_array( $_GET['return_to'] , $allowed_return_tos , TRUE )
        ) {

        $return_to = $_GET['return_to'] ;

    } else {

        $return_to = 'manage-dataset' ;

    }

    // -------------------------------------------------------------------------

    if ( $return_to === 'manage-dataset' ) {

        // ---------------------------------------------------------------------

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
                    $top_level_dataset_slug
                    ) ;

        // ---------------------------------------------------------------------

    } elseif ( $return_to === 'show-view' ) {

        // ---------------------------------------------------------------------

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

        // ---------------------------------------------------------------------

        $url = get_show_view_url(
                    $caller_apps_includes_dir   ,
                    $question_front_end         ,
                    $view_slug
                    ) ;

        // ---------------------------------------------------------------------

    } else {

        // ---------------------------------------------------------------------

        $safe_return_to = htmlentities( $return_to ) ;

        $msg = <<<EOT
PROBLEM:&nbsp; Unrecognised/unsupported "return_to" ("{$safe_return_to}")
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        echo standard_dataset_manager_error(
                $error_page_title           ,
                $msg                        ,
                $caller_apps_includes_dir   ,
                $question_front_end
                ) ;

        exit() ;

        // ---------------------------------------------------------------------

    }

    // -------------------------------------------------------------------------

    if ( is_array( $url ) ) {

        echo standard_dataset_manager_error(
                $error_page_title           ,
                $url[0]                     ,
                $caller_apps_includes_dir   ,
                $question_front_end
                ) ;

        exit() ;

    }

    // -------------------------------------------------------------------------

    echo <<<EOT
<script type="text/javascript">
location.href = '{$url}' ;
</script>
EOT;

    // =========================================================================
    // That's that!
    // =========================================================================

}

// =============================================================================
// delete_records_children()
// =============================================================================

function delete_records_children(
    $caller_apps_includes_dir                   ,
    $all_application_dataset_definitions        ,
    $question_front_end                         ,
    $parent_dataset_dmdd                        ,
    $parent_dataset_slug                        ,
    $parent_dataset_title                       ,
    $parent_record_key                          ,
    &$validated_datasets                        ,
    &$validated_type_specific_args              ,
    &$loaded_datasets                           ,
    &$record_keys_to_delete__by_dataset_slug
    ) {

    // -------------------------------------------------------------------------
    // delete_records_children(
    //      $caller_apps_includes_dir                       ,
    //      $all_application_dataset_definitions            ,
    //      $question_front_end                             ,
    //      $parent_dataset_dmdd                            ,
    //      $parent_dataset_slug                            ,
    //      $parent_dataset_title                           ,
    //      $parent_record_key                              ,
    //      &$validated_datasets                            ,
    //      &$validated_type_specific_args                  ,
    //      &$loaded_datasets                               ,
    //      &$record_keys_to_delete__by_dataset_slug
    //      ) {
    // - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // Delete the specified dataset record's children (if it has any) - along
    // with their children recursively.
    //
    // Here we should have (eg):-
    //
    //      $loaded_datasets = array(
    //          '<this_dataset_slug>' =>  array(
    //              'title'                 =>  "xxx"           ,
    //              'records'               =>  array(...)      ,
    //              'key_field_slug'        =>  "yyy"           ,
    //              'record_indices_by_key' =>  array(...)
    //              )   ,
    //          ...
    //      )
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

/*
echo '<br /><br />Deleting children of: ' ;
echo '<br />DATASET: ' , $parent_dataset_title , ' (' , count( $loaded_datasets[ $parent_dataset_slug ]['records'] ) , ' records)' ;
$record_title = $loaded_datasets[ $parent_dataset_slug ]['records'][
                    $loaded_datasets[ $parent_dataset_slug ]['record_indices_by_key'][ $parent_record_key ]
                    ]['title'] ;
echo '<br />RECORD: ' , $record_title ;
*/

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\pr( $record_keys_to_delete__by_dataset_slug ) ;

    // =========================================================================
    // Init.
    // =========================================================================

    $ns = __NAMESPACE__ ;
    $fn = __FUNCTION__  ;

    // =========================================================================
    // ANY CHILDREN to delete ?
    // =========================================================================

    if (    ! isset( $parent_dataset_dmdd['child_dataset_slugs'] )
            ||
            ! is_array( $parent_dataset_dmdd['child_dataset_slugs'] )
            ||
            count( $parent_dataset_dmdd['child_dataset_slugs'] ) < 1
        ) {
        return TRUE ;
    }

    // =========================================================================
    // Loop over the child datasets...
    // =========================================================================

    foreach ( $parent_dataset_dmdd['child_dataset_slugs'] as $child_dataset_slug ) {

//echo '<br /><br />Checking CHILD dataset: ' , $child_dataset_slug ;

        // =====================================================================
        // ERROR CHECKING...
        // =====================================================================

        if ( ! array_key_exists( $child_dataset_slug , $validated_datasets ) ) {

            // -----------------------------------------------------------------
            // child_dataset_slug OK ?
            // -----------------------------------------------------------------

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
                            $child_dataset_slug                     ,
                            $all_application_dataset_definitions
                            ) ;

            // -----------------------------------------------------------------

            if ( is_string( $result ) ) {
                return $result ;
            }

            // -----------------------------------------------------------------
            // Get the $child_dataset_dmdd...
            // -----------------------------------------------------------------

            $child_dataset_dmdd = $all_application_dataset_definitions[ $child_dataset_slug ] ;

            // -----------------------------------------------------------------
            // Get the $child_dataset_title...
            // -----------------------------------------------------------------

            if (    isset( $child_dataset_dmdd['dataset_title_plural'] )
                    &&
                    is_string( $child_dataset_dmdd['dataset_title_plural'] )
                    &&
                    trim( $child_dataset_dmdd['dataset_title_plural'] ) !== ''
                    &&
                    strlen( $child_dataset_dmdd['dataset_title_plural'] ) <= 64
                    &&
                    strip_tags( $child_dataset_dmdd['dataset_title_plural'] ) === $child_dataset_dmdd['dataset_title_plural']
                ) {
                $child_dataset_title = htmlentities( $child_dataset_dmdd['dataset_title_plural'] ) ;

            } else {
                $child_dataset_title = to_title( $child_dataset_slug ) ;

            }

            // =================================================================
            // Determine how the child dataset records are to be deleted.  And
            // then delete them accordingly...
            //
            // NOTE!
            // -----
            // The "parent_details" field in the child dataset's definition
            // specifies how the parent's child records (to be deleted) are
            // identified.
            // =================================================================

            // -----------------------------------------------------------------
            // NOTE!
            // =====
            // The "parent_details" field should be one of the follwing:-
            //
            //      o   <child_dataset_definition>['parent_details']    =>  array(
            //              'type'                  =>  'none'              ,
            //              'type_specific_args'    =>  <any_PHP_value>     //  (this key and value, if specified,  are IGNORED)
            //              )
            //              //  This dataset's records have NO PARENT.  They may however
            //              //  have CHILDREN (see "child_dataset_slugs", below).
            //
            //      o   <child_dataset_definition>['parent_details']    =>  array(
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
            //
            //      o   <child_dataset_definition>['parent_details']    =>  array(
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
            //
            //      o   <child_dataset_definition>['parent_details']    =>  array(
            //              'type'                  =>  'separate-parent-key-fields'
            //              'type_specific_args'    =>  array(
            //                  'parent_dataset_slugs_by_key_field_slug'    =>  array(
            //                      'document_key'  =>  'documents'     ,
            //                      'section_key'   =>  'sections'
            //                      )
            //              )
            //              //  This dataset's records ***may*** optionally have a PARENT.
            //              //  o   If ALL of the "parent dataset key" fields contain
            //              //      the empty string, then the record concerned has
            //              //      NO parent.
            //              //  o   If exactly ONE of the "parent dataset key" fields
            //              //      contains a non-empty string value, then the record
            //              //      concerned has the parent specified.
            //              //  o   If MORE THAN ONE of the "parent dataset key" fields
            //              //      has a non-empty string value, then it's an ERROR.
            //              //
            //              //  The dataset records may have CHILDREN too (see
            //              //  "child_dataset_slugs", below).
            //          ...
            //          'child_dataset_slugs'                       =>  array( 'shots' )
            //          ...
            //          )
            //
            // -----------------------------------------------------------------

            // -----------------------------------------------------------------
            // parent_details ?
            // -----------------------------------------------------------------

            if ( ! array_key_exists( 'parent_details' , $child_dataset_dmdd ) ) {

                return <<<EOT
PROBLEM:&nbsp; No "parent_details"
For dataset:&nbsp; {$child_dataset_title}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

            }

            // -----------------------------------------------------------------

            if ( ! is_array( $child_dataset_dmdd['parent_details'] ) ) {

                return <<<EOT
PROBLEM:&nbsp; Bad "parent_details" (array expected)
For dataset:&nbsp; {$child_dataset_title}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

            }

            // -----------------------------------------------------------------
            // parent_details + type ?
            // -----------------------------------------------------------------

            if ( ! array_key_exists( 'type' , $child_dataset_dmdd['parent_details'] ) ) {

                return <<<EOT
PROBLEM:&nbsp; No "parent_details" + "type"
For dataset:&nbsp; {$child_dataset_title}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

            }

            // -----------------------------------------------------------------

            if (    ! is_string( $child_dataset_dmdd['parent_details']['type'] )
                    ||
                    trim( $child_dataset_dmdd['parent_details']['type'] ) === ''
                ) {

                return <<<EOT
PROBLEM:&nbsp; Bad "parent_details" + "type" (non-empty string expected)
For dataset:&nbsp; {$child_dataset_title}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

            }

            // -----------------------------------------------------------------
            // "type" = "none" not allowed !
            // -----------------------------------------------------------------

            if ( $child_dataset_dmdd['parent_details']['type'] === 'none' ) {

                return <<<EOT
PROBLEM:&nbsp; Bad Bad "parent_details" + "type" ("none" not allowed - because this is inconsistent with the parent dataset's "child_dataset_slugs")
For dataset:&nbsp; {$child_dataset_title}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

            }

            // -----------------------------------------------------------------
            // parent_details + type_specific_args ?
            // -----------------------------------------------------------------

            if ( ! array_key_exists( 'type_specific_args' , $child_dataset_dmdd['parent_details'] ) ) {

                return <<<EOT
PROBLEM:&nbsp; No "parent_details" + "type_specific_args"
For dataset:&nbsp; {$child_dataset_title}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

            }

            // -----------------------------------------------------------------

            if ( ! is_array( $child_dataset_dmdd['parent_details']['type_specific_args'] ) ) {

                return <<<EOT
PROBLEM:&nbsp; Bad "parent_details" + "type_specific_args" (array expected)
For dataset:&nbsp; {$child_dataset_title}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

            }

            // -----------------------------------------------------------------

            $validated_datasets[ $child_dataset_slug ] = $child_dataset_dmdd ;
                //  This is like (eg):-
                //
                //      $validated_datasets = array(
                //          "<dataset_slug_1>"  =>  <dataset_dmdd_1>        ,
                //          "<dataset_slug_2>"  =>  <dataset_dmdd_2>        ,
                //          ...
                //          "<dataset_slug_N>"  =>  <dataset_dmdd_N>
                //          )

            // -----------------------------------------------------------------

        }

        // =====================================================================
        // LOAD the CHILD DATASET RECORDS (if necessary)...
        // =====================================================================

        if ( ! array_key_exists( $child_dataset_slug , $loaded_datasets ) ) {

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
                            $child_dataset_slug
                            ) ;

            // -----------------------------------------------------------------

            if ( is_string( $result ) ) {
                return $result ;
            }

            // -----------------------------------------------------------------

            list(
                $child_dataset_title            ,
                $child_dataset_records          ,
                $child_key_field_slug           ,
                $child_record_indices_by_key
                ) = $result ;

            // -----------------------------------------------------------------

            $loaded_datasets[ $child_dataset_slug ] = array(
                'title'                     =>  $child_dataset_title            ,
                'records'                   =>  $child_dataset_records          ,
                'key_field_slug'            =>  $child_key_field_slug           ,
                'record_indices_by_key'     =>  $child_record_indices_by_key
                ) ;

            // -----------------------------------------------------------------

        }

        // =====================================================================
        // Do the type specific deleting...
        // =====================================================================

        $child_dataset_dmdd =
            $validated_datasets[ $child_dataset_slug ]
            ;

        // ---------------------------------------------------------------------

        $child_dataset_title =
            $loaded_datasets[ $child_dataset_slug ]['title']
            ;

        // ---------------------------------------------------------------------

        if ( $child_dataset_dmdd['parent_details']['type'] === 'single-parent-key-field' ) {

            // -------------------------------------------------------------------------
            // delete_records_children__by_single_parent_key_field(
            //      $caller_apps_includes_dir                   ,
            //      $all_application_dataset_definitions        ,
            //      $question_front_end                         ,
            //      $parent_dataset_dmdd                        ,
            //      $parent_dataset_slug                        ,
            //      $parent_dataset_title                       ,
            //      $parent_record_key                          ,
            //      &$validated_datasets                        ,
            //      &$validated_type_specific_args              ,
            //      &$loaded_datasets                           ,
            //      &$record_keys_to_delete__by_dataset_slug    ,
            //      $child_dataset_slug                         ,
            //      $child_dataset_dmdd                         ,
            //      $child_dataset_title
            //      )
            // - - - - - - - - - - - - - - - - - - - - - - - - - - -
            // RETURNS
            //      o   On SUCCESS
            //              TRUE
            //
            //      o   On FAILURE
            //              $error_message STRING
            // -------------------------------------------------------------------------

            $result = delete_records_children__by_single_parent_key_field(
                            $caller_apps_includes_dir                   ,
                            $all_application_dataset_definitions        ,
                            $question_front_end                         ,
                            $parent_dataset_dmdd                        ,
                            $parent_dataset_slug                        ,
                            $parent_dataset_title                       ,
                            $parent_record_key                          ,
                            $validated_datasets                         ,
                            $validated_type_specific_args               ,
                            $loaded_datasets                            ,
                            $record_keys_to_delete__by_dataset_slug     ,
                            $child_dataset_slug                         ,
                            $child_dataset_dmdd                         ,
                            $child_dataset_title
                            ) ;

            // -----------------------------------------------------------------

            if ( is_string( $result ) ) {
                return $result ;
            }

            // -----------------------------------------------------------------

        } elseif ( $child_dataset_dmdd['parent_details']['type'] === 'parent-type-and-key-fields' ) {

            // -------------------------------------------------------------------------
            // delete_records_children__by_parent_type_and_key_fields(
            //      $caller_apps_includes_dir                   ,
            //      $all_application_dataset_definitions        ,
            //      $question_front_end                         ,
            //      $parent_dataset_dmdd                        ,
            //      $parent_dataset_slug                        ,
            //      $parent_dataset_title                       ,
            //      $parent_record_key                          ,
            //      &$validated_datasets                        ,
            //      &$validated_type_specific_args              ,
            //      &$loaded_datasets                           ,
            //      &$record_keys_to_delete__by_dataset_slug    ,
            //      $child_dataset_slug                         ,
            //      $child_dataset_dmdd                         ,
            //      $child_dataset_title
            //      )
            // - - - - - - - - - - - - - - - - - - - - - - - - - - -
            // RETURNS
            //      o   On SUCCESS
            //              TRUE
            //
            //      o   On FAILURE
            //              $error_message STRING
            // -------------------------------------------------------------------------

            $result = delete_records_children__by_parent_type_and_key_fields(
                            $caller_apps_includes_dir                   ,
                            $all_application_dataset_definitions        ,
                            $question_front_end                         ,
                            $parent_dataset_dmdd                        ,
                            $parent_dataset_slug                        ,
                            $parent_dataset_title                       ,
                            $parent_record_key                          ,
                            $validated_datasets                         ,
                            $validated_type_specific_args               ,
                            $loaded_datasets                            ,
                            $record_keys_to_delete__by_dataset_slug     ,
                            $child_dataset_slug                         ,
                            $child_dataset_dmdd                         ,
                            $child_dataset_title
                            ) ;

            // -----------------------------------------------------------------

            if ( is_string( $result ) ) {
                return $result ;
            }

            // -----------------------------------------------------------------

//      } elseif ( $child_dataset_dmdd['parent_details']['type'] === 'separate-parent-key-fields' ) {

            //  TODO

        } else {

            // -----------------------------------------------------------------
            // ERROR
            // -----------------------------------------------------------------

            $safe_parent_details_type =
                htmlentities( $child_dataset_dmdd['parent_details']['type'] )
                ;

            // -----------------------------------------------------------------

            return <<<EOT
PROBLEM:&nbsp; Unrecognised/unsupported "parent_details" + "type" ("{$safe_parent_details_type}")
For dataset:&nbsp; {$child_dataset_title}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

            // -----------------------------------------------------------------

        }

        // =====================================================================
        // Repeat with the next child dataset (if there is one)...
        // =====================================================================

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
// delete_records_children__by_single_parent_key_field()
// =============================================================================

function delete_records_children__by_single_parent_key_field(
    $caller_apps_includes_dir                   ,
    $all_application_dataset_definitions        ,
    $question_front_end                         ,
    $parent_dataset_dmdd                        ,
    $parent_dataset_slug                        ,
    $parent_dataset_title                       ,
    $parent_record_key                          ,
    &$validated_datasets                        ,
    &$validated_type_specific_args              ,
    &$loaded_datasets                           ,
    &$record_keys_to_delete__by_dataset_slug    ,
    $child_dataset_slug                         ,
    $child_dataset_dmdd                         ,
    $child_dataset_title
    ) {

    // -------------------------------------------------------------------------
    // delete_records_children__by_single_parent_key_field(
    //      $caller_apps_includes_dir                   ,
    //      $all_application_dataset_definitions        ,
    //      $question_front_end                         ,
    //      $parent_dataset_dmdd                        ,
    //      $parent_dataset_slug                        ,
    //      $parent_dataset_title                       ,
    //      $parent_record_key                          ,
    //      &$validated_datasets                        ,
    //      &$validated_type_specific_args              ,
    //      &$loaded_datasets                           ,
    //      &$record_keys_to_delete__by_dataset_slug    ,
    //      $child_dataset_slug                         ,
    //      $child_dataset_dmdd                         ,
    //      $child_dataset_title
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // RETURNS
    //      o   On SUCCESS
    //              TRUE
    //
    //      o   On FAILURE
    //              $error_message STRING
    // -------------------------------------------------------------------------

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      <child_dataset_definition>['parent_details']    =>  array(
    //          'type'                  =>  'single-parent-key-field'   ,
    //          'type_specific_args'    =>  array(
    //              'parent_dataset_slug'                       =>  'xxx'   ,
    //              'parent_dataset_key_field_slug'             =>  'yyy'
    //              )
    //          )
    //
    // Where:-
    //      o   This dataset's records ***may*** optionally have a PARENT.
    //
    //      o   "parent_dataset_slug" must be a non-empty string.
    //
    //      o   The array storage record's:-
    //              "<parent_dataset_key_field_slug>"
    //          field may contain either:-
    //              --  The empty string (in which case, this child
    //                  record has NO parent), or;
    //              --  A "record key" from the parent dataset.
    //
    //      o   The dataset records may have CHILDREN too (see
    //          "child_dataset_slugs", below).
    //
    // -------------------------------------------------------------------------

    // =========================================================================
    // Init.
    // =========================================================================

    $ns = __NAMESPACE__ ;
    $fn = __FUNCTION__  ;

    // =========================================================================
    // ERROR CHECKING
    // =========================================================================

    if ( ! in_array( $child_dataset_slug , $validated_type_specific_args , TRUE ) ) {

        // ---------------------------------------------------------------------
        // parent_dataset_slug ?
        // ---------------------------------------------------------------------

        if ( ! array_key_exists( 'parent_dataset_slug' , $child_dataset_dmdd['parent_details']['type_specific_args'] ) ) {

            return <<<EOT
PROBLEM:&nbsp; No "parent_details" + "type_specific_args" + "parent_dataset_slug"
For dataset:&nbsp; {$child_dataset_title}
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
                        $child_dataset_dmdd['parent_details']['type_specific_args']['parent_dataset_slug']  ,
                        $all_application_dataset_definitions
                        ) ;

        // ---------------------------------------------------------------------

        if ( is_string( $result ) ) {
            return $result ;
        }

        // ---------------------------------------------------------------------
        // parent_dataset_key_field_slug ?
        // ---------------------------------------------------------------------

        if ( ! array_key_exists( 'parent_dataset_key_field_slug' , $child_dataset_dmdd['parent_details']['type_specific_args'] ) ) {

            return <<<EOT
PROBLEM:&nbsp; No "parent_details" + "type_specific_args" + "parent_dataset_key_field_slug"
For dataset:&nbsp; {$child_dataset_title}
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
                        $child_dataset_dmdd['parent_details']['type_specific_args']['parent_dataset_key_field_slug']
                        ) ;

        // ---------------------------------------------------------------------

        if ( is_string( $result ) ) {
            return $result ;
        }

        // ---------------------------------------------------------------------
        // Validated OK!
        // ---------------------------------------------------------------------

        $validated_type_specific_args[] = $child_dataset_slug ;
            //  This is like (eg):-
            //
            //      $validated_type_specific_args = array(
            //          "<dataset_slug_1>"      ,
            //          "<dataset_slug_2>"      ,
            //          ...
            //          "<dataset_slug_N>"
            //          )

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // DELETE the CHILD dataset records that belong to the parent dataset
    // record...
    // =========================================================================

    // -------------------------------------------------------------------------
    // Simplify the variables used (and the following code)...
    // -------------------------------------------------------------------------

    $parent_key_field_slug =
        $child_dataset_dmdd['parent_details']['type_specific_args']['parent_dataset_key_field_slug']
        ;

    // -------------------------------------------------------------------------

    $child_key_field_slug =
        $loaded_datasets[ $child_dataset_slug ]['key_field_slug']
        ;

    // -------------------------------------------------------------------------
    // Loop over the child dataset records...
    // -------------------------------------------------------------------------

    foreach ( $loaded_datasets[ $child_dataset_slug ]['records'] as $this_child_record ) {

        // ---------------------------------------------------------------------
        // Does the child record have a "parent_key_field_slug" field ?
        // ---------------------------------------------------------------------

        if ( ! array_key_exists(
                    $parent_key_field_slug      ,
                    $this_child_record
                    )
            ) {

            return <<<EOT
PROBLEM:&nbsp; No "{$parent_key_field_slug}" field (in child record)
For dataset:&nbsp; {$child_dataset_title}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        }

        // ---------------------------------------------------------------------
        // Get the key of the child record's parent...
        // ---------------------------------------------------------------------

        $this_parent_key = $this_child_record[ $parent_key_field_slug ] ;

        // ---------------------------------------------------------------------
        // If parent key is the empty string, then this child record DOESN'T
        // belong to the parent record to be deleted...
        // ---------------------------------------------------------------------

        if ( $this_parent_key === '' ) {
            continue ;
        }

        // ---------------------------------------------------------------------
        // If child record's parent key === the parent record key to be
        // deleted, then delete this record...
        // ---------------------------------------------------------------------

        if ( $this_parent_key === $parent_record_key ) {

            // -----------------------------------------------------------------
            // DELETE this CHILD dataset record...
            // -----------------------------------------------------------------

            if ( ! array_key_exists(
                        $child_dataset_slug                         ,
                        $record_keys_to_delete__by_dataset_slug
                        )
                ) {
                $record_keys_to_delete__by_dataset_slug[ $child_dataset_slug ] = array() ;
            }

            // -----------------------------------------------------------------

            $record_keys_to_delete__by_dataset_slug[ $child_dataset_slug ][] =
                $this_child_record[ $child_key_field_slug ]
                ;

            // -----------------------------------------------------------------
            // RECURSE !!!
            // -----------------------------------------------------------------

            // -------------------------------------------------------------------------
            // delete_records_children(
            //      $caller_apps_includes_dir                   ,
            //      $all_application_dataset_definitions        ,
            //      $question_front_end                         ,
            //      $parent_dataset_dmdd                        ,
            //      $parent_dataset_slug                        ,
            //      $parent_dataset_title                       ,
            //      $parent_record_key                          ,
            //      &$validated_datasets                        ,
            //      &$validated_type_specific_args              ,
            //      &$loaded_datasets                           ,
            //      &$record_keys_to_delete__by_dataset_slug
            //      )
            // - - - - - - - - - - - - - - - - - - - - - - - - -
            // Delete the specified dataset record's children (if it has any) - along
            // with their children recursively.
            //
            // Here we should have (eg):-
            //
            //      $loaded_datasets = array(
            //          '<this_dataset_slug>' =>  array(
            //              'title'                 =>  "xxx"           ,
            //              'records'               =>  array(...)      ,
            //              'key_field_slug'        =>  "yyy"           ,
            //              'record_indices_by_key' =>  array(...)
            //              )   ,
            //          ...
            //      )
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

            $_parent_dataset_dmdd  = $child_dataset_dmdd                         ;
            $_parent_dataset_slug  = $child_dataset_slug                         ;
            $_parent_dataset_title = $child_dataset_title                        ;
            $_parent_record_key    = $this_child_record[ $child_key_field_slug ] ;

            // -----------------------------------------------------------------

            $result = delete_records_children(
                            $caller_apps_includes_dir                       ,
                            $all_application_dataset_definitions            ,
                            $question_front_end                             ,
                            $_parent_dataset_dmdd                           ,
                            $_parent_dataset_slug                           ,
                            $_parent_dataset_title                          ,
                            $_parent_record_key                             ,
                            $validated_datasets                             ,
                            $validated_type_specific_args                   ,
                            $loaded_datasets                                ,
                            $record_keys_to_delete__by_dataset_slug
                            ) ;

            // -----------------------------------------------------------------

            if ( is_string( $result ) ) {
                return $result ;
            }

            // -----------------------------------------------------------------

        }

        // ---------------------------------------------------------------------
        // Repeat with the next child dataset record (if there is one)...
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
// delete_records_children__by_parent_type_and_key_fields()
// =============================================================================

function delete_records_children__by_parent_type_and_key_fields(
    $caller_apps_includes_dir                   ,
    $all_application_dataset_definitions        ,
    $question_front_end                         ,
    $parent_dataset_dmdd                        ,
    $parent_dataset_slug                        ,
    $parent_dataset_title                       ,
    $parent_record_key                          ,
    &$validated_datasets                        ,
    &$validated_type_specific_args              ,
    &$loaded_datasets                           ,
    &$record_keys_to_delete__by_dataset_slug    ,
    $child_dataset_slug                         ,
    $child_dataset_dmdd                         ,
    $child_dataset_title
    ) {

    // -------------------------------------------------------------------------
    // delete_records_children__by_parent_type_and_key_fields(
    //      $caller_apps_includes_dir                   ,
    //      $all_application_dataset_definitions        ,
    //      $question_front_end                         ,
    //      $parent_dataset_dmdd                        ,
    //      $parent_dataset_slug                        ,
    //      $parent_dataset_title                       ,
    //      $parent_record_key                          ,
    //      &$validated_datasets                        ,
    //      &$validated_type_specific_args              ,
    //      &$loaded_datasets                           ,
    //      &$record_keys_to_delete__by_dataset_slug    ,
    //      $child_dataset_slug                         ,
    //      $child_dataset_dmdd                         ,
    //      $child_dataset_title
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // RETURNS
    //      o   On SUCCESS
    //              TRUE
    //
    //      o   On FAILURE
    //              $error_message STRING
    // -------------------------------------------------------------------------

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      <child_dataset_definition>['parent_details'] = array(
    //          'type'                  =>  'parent-type-and-key-fields'
    //          'type_specific_args'    =>  array(
    //              'parent_type_field_slug'            =>  'parent_is'     ,
    //              'parent_key_field_slug'             =>  'parent_key'    ,
    //              'parent_dataset_slugs_by_value'     =>  array(
    //                  'document'  =>  'documents'     ,
    //                  'section'   =>  'sections'
    //                  )
    //              )
    //          )
    //
    // Where:-
    //
    //      o   This dataset's records ***may*** optionally have a PARENT.
    //
    //      o   If the "parent_type_field_slug" field contains the empty string,
    //          then this record has NO parent (and the "parent_key_field_slug"
    //          field in IGNORED).
    //
    //      o   If the "parent_type_field_slug" field contains a non-empty
    //          string, then the:-
    //
    //              "parent_dataset_slugs_by_value"
    //
    //          field maps values in the "parent_type_field_slug" field to the
    //          dataset the record belongs to.
    //
    //      o   The dataset records may have CHILDREN too (see
    //          "child_dataset_slugs").
    // -------------------------------------------------------------------------

    // =========================================================================
    // Init.
    // =========================================================================

    $ns = __NAMESPACE__ ;
    $fn = __FUNCTION__  ;

    // =========================================================================
    // ERROR CHECKING
    // =========================================================================

    if ( ! in_array( $child_dataset_slug , $validated_type_specific_args , TRUE ) ) {

        // ---------------------------------------------------------------------
        // parent_type_field_slug ?
        // ---------------------------------------------------------------------

        if ( ! array_key_exists( 'parent_type_field_slug' , $child_dataset_dmdd['parent_details']['type_specific_args'] ) ) {

            return <<<EOT
PROBLEM:&nbsp; No "parent_details" + "type_specific_args" + "parent_type_field_slug"
For dataset:&nbsp; {$child_dataset_title}
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
                        $child_dataset_dmdd['parent_details']['type_specific_args']['parent_type_field_slug']
                        ) ;

        // ---------------------------------------------------------------------

        if ( is_string( $result ) ) {
            return $result ;
        }

        // ---------------------------------------------------------------------
        // parent_key_field_slug ?
        // ---------------------------------------------------------------------

        if ( ! array_key_exists( 'parent_key_field_slug' , $child_dataset_dmdd['parent_details']['type_specific_args'] ) ) {

            return <<<EOT
PROBLEM:&nbsp; No "parent_details" + "type_specific_args" + "parent_key_field_slug"
For dataset:&nbsp; {$child_dataset_title}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        }

        // ---------------------------------------------------------------------

        $result = is_field_slug(
                        $child_dataset_dmdd['parent_details']['type_specific_args']['parent_key_field_slug']
                        ) ;

        // ---------------------------------------------------------------------

        if ( is_string( $result ) ) {
            return $result ;
        }

        // ---------------------------------------------------------------------
        // parent_dataset_slugs_by_value ?
        // ---------------------------------------------------------------------

        if ( ! array_key_exists( 'parent_dataset_slugs_by_value' , $child_dataset_dmdd['parent_details']['type_specific_args'] ) ) {

            return <<<EOT
PROBLEM:&nbsp; No "parent_details" + "type_specific_args" + "parent_dataset_slugs_by_value"
For dataset:&nbsp; {$child_dataset_title}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        }

        // ---------------------------------------------------------------------

        if (    ! is_array( $child_dataset_dmdd['parent_details']['type_specific_args']['parent_dataset_slugs_by_value'] )
                ||
                count( $child_dataset_dmdd['parent_details']['type_specific_args']['parent_dataset_slugs_by_value'] ) < 1
            ) {

            return <<<EOT
PROBLEM:&nbsp; Bad "parent_details" + "type_specific_args" + "parent_dataset_slugs_by_value" (non-empty array expected)
For dataset:&nbsp; {$child_dataset_title}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        }

        // ---------------------------------------------------------------------
        // Validated OK!
        // ---------------------------------------------------------------------

        $validated_type_specific_args[] = $child_dataset_slug ;
            //  This is like (eg):-
            //
            //      $validated_type_specific_args = array(
            //          "<dataset_slug_1>"      ,
            //          "<dataset_slug_2>"      ,
            //          ...
            //          "<dataset_slug_N>"
            //          )

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // DELETE the CHILD dataset records that belong to the parent dataset
    // record...
    // =========================================================================

    // -------------------------------------------------------------------------
    // Simplify the variables used (and the following code)...
    // -------------------------------------------------------------------------

    $parent_type_field_slug =
        $child_dataset_dmdd['parent_details']['type_specific_args']['parent_type_field_slug']
        ;

    // -------------------------------------------------------------------------

    $parent_key_field_slug =
        $child_dataset_dmdd['parent_details']['type_specific_args']['parent_key_field_slug']
        ;

    // -------------------------------------------------------------------------

    $child_key_field_slug =
        $loaded_datasets[ $child_dataset_slug ]['key_field_slug']
        ;

    // -------------------------------------------------------------------------

    $target_parent_type = '' ;

    foreach (   $child_dataset_dmdd['parent_details']['type_specific_args']['parent_dataset_slugs_by_value']
                as
                $this_parent_type => $this_dataset_slug
        ) {

        if ( $this_dataset_slug === $parent_dataset_slug ) {
            $target_parent_type = $this_parent_type ;
            break ;
        }

    }

//echo '<br />' , $target_parent_type ;

    // -------------------------------------------------------------------------
    // Loop over the child dataset records...
    // -------------------------------------------------------------------------

    foreach ( $loaded_datasets[ $child_dataset_slug ]['records'] as $this_child_record ) {

        // ---------------------------------------------------------------------
        // Does the child record have a "parent_type_field_slug" field ?
        // ---------------------------------------------------------------------

        if ( ! array_key_exists(
                    $parent_type_field_slug     ,
                    $this_child_record
                    )
            ) {

            return <<<EOT
PROBLEM:&nbsp; No "{$parent_type_field_slug}" field (in child record)
For dataset:&nbsp; {$child_dataset_title}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        }

        // ---------------------------------------------------------------------
        // Is this child record owned by the parent dataset ?
        // ---------------------------------------------------------------------

        if ( $this_child_record[ $parent_type_field_slug ] !== $target_parent_type ) {
            continue ;
        }

        // ---------------------------------------------------------------------
        // Does the child record have a "parent_key_field_slug" field ?
        // ---------------------------------------------------------------------

        if ( ! array_key_exists(
                    $parent_key_field_slug      ,
                    $this_child_record
                    )
            ) {

            return <<<EOT
PROBLEM:&nbsp; No "{$parent_key_field_slug}" field (in child record)
For dataset:&nbsp; {$child_dataset_title}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        }

        // ---------------------------------------------------------------------
        // Get the key of the child record's parent...
        // ---------------------------------------------------------------------

        $this_parent_key = $this_child_record[ $parent_key_field_slug ] ;

        // ---------------------------------------------------------------------
        // If parent key is the empty string, then this child record DOESN'T
        // belong to the parent record to be deleted...
        // ---------------------------------------------------------------------

        if ( $this_parent_key === '' ) {
            continue ;
        }

        // ---------------------------------------------------------------------
        // If child record's parent key === the parent record key to be
        // deleted, then delete this record...
        // ---------------------------------------------------------------------

        if ( $this_parent_key === $parent_record_key ) {

            // -----------------------------------------------------------------
            // DELETE this CHILD dataset record...
            // -----------------------------------------------------------------

            if ( ! array_key_exists(
                        $child_dataset_slug                         ,
                        $record_keys_to_delete__by_dataset_slug
                        )
                ) {
                $record_keys_to_delete__by_dataset_slug[ $child_dataset_slug ] = array() ;
            }

            // -----------------------------------------------------------------

            $record_keys_to_delete__by_dataset_slug[ $child_dataset_slug ][] =
                $this_child_record[ $child_key_field_slug ]
                ;

            // -----------------------------------------------------------------
            // RECURSE !!!
            // -----------------------------------------------------------------

            // -------------------------------------------------------------------------
            // delete_records_children(
            //      $caller_apps_includes_dir                   ,
            //      $all_application_dataset_definitions        ,
            //      $question_front_end                         ,
            //      $parent_dataset_dmdd                        ,
            //      $parent_dataset_slug                        ,
            //      $parent_dataset_title                       ,
            //      $parent_record_key                          ,
            //      &$validated_datasets                        ,
            //      &$validated_type_specific_args              ,
            //      &$loaded_datasets                           ,
            //      &$record_keys_to_delete__by_dataset_slug
            //      )
            // - - - - - - - - - - - - - - - - - - - - - - - - -
            // Delete the specified dataset record's children (if it has any) - along
            // with their children recursively.
            //
            // Here we should have (eg):-
            //
            //      $loaded_datasets = array(
            //          '<this_dataset_slug>' =>  array(
            //              'title'                 =>  "xxx"           ,
            //              'records'               =>  array(...)      ,
            //              'key_field_slug'        =>  "yyy"           ,
            //              'record_indices_by_key' =>  array(...)
            //              )   ,
            //          ...
            //      )
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

            $_parent_dataset_dmdd  = $child_dataset_dmdd                         ;
            $_parent_dataset_slug  = $child_dataset_slug                         ;
            $_parent_dataset_title = $child_dataset_title                        ;
            $_parent_record_key    = $this_child_record[ $child_key_field_slug ] ;

            // -----------------------------------------------------------------

            $result = delete_records_children(
                            $caller_apps_includes_dir                       ,
                            $all_application_dataset_definitions            ,
                            $question_front_end                             ,
                            $_parent_dataset_dmdd                           ,
                            $_parent_dataset_slug                           ,
                            $_parent_dataset_title                          ,
                            $_parent_record_key                             ,
                            $validated_datasets                             ,
                            $validated_type_specific_args                   ,
                            $loaded_datasets                                ,
                            $record_keys_to_delete__by_dataset_slug
                            ) ;

            // -----------------------------------------------------------------

            if ( is_string( $result ) ) {
                return $result ;
            }

            // -----------------------------------------------------------------

        }

        // ---------------------------------------------------------------------
        // Repeat with the next child dataset record (if there is one)...
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
// That's that!
// =============================================================================

