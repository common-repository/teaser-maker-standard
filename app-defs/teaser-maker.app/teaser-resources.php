<?php

// *****************************************************************************
// TASER-Mker.APP / TEASER-RESOURCES.PHP
// (C) 2014 Peter Newman. All Rights Reserved.
// *****************************************************************************

    namespace greatKiwi_byFernTec_teaserMaker_std_v0x1x114_datasetDef_teasers ;

// =============================================================================
// get_category_selector_options()
// =============================================================================

function get_category_selector_options(
    $home_page_title                        ,
    $caller_apps_includes_dir               ,
    $all_application_dataset_definitions    ,
    $dataset_slug                           ,
    $selected_datasets_dmdd                 ,
    $dataset_title                          ,
    $dataset_records                        ,
    $record_indices_by_key                  ,
    $question_adding                        ,
    $field_number                           ,
    $field_details                          ,
    $the_record                             ,
    $the_records_index                      ,
    $array_storage_field_slugs              ,
    $extra_args
    ) {

    // -------------------------------------------------------------------------
    // get_options_for_document_section_selector(
    //      $home_page_title                        ,
    //      $caller_apps_includes_dir               ,
    //      $all_application_dataset_definitions    ,
    //      $dataset_slug                           ,
    //      $selected_datasets_dmdd                 ,
    //      $dataset_title                          ,
    //      $dataset_records                        ,
    //      $record_indices_by_key                  ,
    //      $question_adding                        ,
    //      $field_number                           ,
    //      $field_details                          ,
    //      $the_record                             ,
    //      $the_records_index                      ,
    //      $array_storage_field_slugs              ,
    //      $extra_args
    // - - - - - - - - - - - - - - - - - - - - - - -
    // Returns a "select" control "options" array - as required by Zebra Forms.
    //
    // The returned array is like (eg):-
    //
    //      array(
    //          "Option 1 Text"
    //          "Option 2 Text"
    //          ...
    //          )
    //
    //      array(
    //          "option 1 value"    =>  "Option 1 Text"
    //          "option 2 value"    =>  "Option 2 Text"
    //          ...
    //          )
    //
    //      array(
    //          "Option Group 1 Title"  =>  array(
    //              "option A value"    =>  "Option A Text"
    //              "option B value"    =>  "Option B Text"
    //              ...
    //              )
    //          "Option Group 2 Title"  =>  array(
    //              "option M value"    =>  "Option M Text"
    //              "option N value"    =>  "Option N Text"
    //              ...
    //              )
    //          ...
    //          )
    //
    // RETURNS
    //      o   On SUCCESS!
    //          - - - - - -
    //          array(
    //              $ok = TRUE          ,
    //              ARRAY $options
    //              )
    //
    //      o   On FAILURE!
    //          - - - - - -
    //          array(
    //              $ok = FALSE             ,
    //              $error_message STRING
    //              )
    // -------------------------------------------------------------------------

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( \func_get_args() ) ;

//  return array(
//              TRUE            ,
//              array(
//                  'Option 1 Text'     ,
//                  'Option 2 Text'
//                  )
//              ) ;

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $dataset_records = Array(
    //
    //          [0] => Array(
    //                      [created_server_datetime_UTC]       => 1394153232
    //                      [last_modified_server_datetime_UTC] => 1394153232
    //                      [key]                               => 5319171085fbc
    //                      [parent_key]                        => 531812f122157
    //                      [parent_is]                         => document
    //                      [title]                             => Intro 2
    //                      [description]                       =>
    //                      [description_format]                => none
    //                      [image_url]                         =>
    //                      [sequence_number]                   => 10
    //                      )
    //
    //          [1] => Array(
    //                      [created_server_datetime_UTC]       => 1394164355
    //                      [last_modified_server_datetime_UTC] => 1394164355
    //                      [key]                               => 53194283b436f
    //                      [parent_key]                        => 531812f122157
    //                      [parent_is]                         => document
    //                      [title]                             => Chapter 1
    //                      [description]                       =>
    //                      [description_format]                => none
    //                      [image_url]                         =>
    //                      [sequence_number]                   => 20
    //                      )
    //
    //          )
    //
    // -------------------------------------------------------------------------

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $dataset_records ) ;

    // =========================================================================
    // Init...
    // =========================================================================

    $ns = __NAMESPACE__ ;
    $fn = __FUNCTION__ ;

    // -------------------------------------------------------------------------

    $success = TRUE ;
    $failure = FALSE ;

    // =========================================================================
    // ERROR CHECKING...
    // =========================================================================

    if ( $dataset_slug !== 'teasers' ) {

        $msg = <<<EOT
PROBLEM:&nbsp; Bad "dataset_slug" ("teasers" expected)
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        return array(
                    $failure    ,
                    $msg
                    ) ;

    }

    // =========================================================================
    // Get the SECTION RECORDS (and record indices by key)...
    // =========================================================================

//  $teaser_category_records = $dataset_records ;

//  $teaser_category_record_indices_by_key = $record_indices_by_key ;

    // =========================================================================
    // Load the TEASER CATEGORY records...
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

    $teaser_category_records =
        \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_arrayStorage\load_numerically_indexed(
            'teaser_categories'         ,
            $question_die_on_error
            ) ;

    // -------------------------------------------------------------------------

    if ( is_string( $teaser_category_records ) ) {

        return array(
                    $failure                    ,
                    $teaser_category_records
                    ) ;

    }

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $document_records = Array(
    //
    //          [0] => Array(
    //                      [created_server_datetime_UTC]       => 1394086641
    //                      [last_modified_server_datetime_UTC] => 1394086641
    //                      [key]                               => 531812f122157
    //                      [title]                             => Teaser Maker User Manual
    //                      [description]                       =>
    //                      [description_format]                => none
    //                      [image_url]                         =>
    //                      [sequence_number]                   => 10
    //                      )
    //
    //          )
    //
    // -------------------------------------------------------------------------

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $document_records ) ;

    // =========================================================================
    // Create the TYPE KEY LIST (to create the type key tree from)...
    // =========================================================================

    $type_key_list = array() ;

//  // -------------------------------------------------------------------------
//  // DOCUMENTS...
//  // -------------------------------------------------------------------------
//
//  foreach ( $document_records as $this_index => $this_document ) {
//
//      // ---------------------------------------------------------------------
//
//      $type_key_list[] = array(
//          'type'                  =>  'document'                          ,
//          'key'                   =>  $this_document['key']               ,
//          'parent_type'           =>  ''                                  ,
//          'parent_key'            =>  ''                                  ,
//          'primary_sort_value'    =>  $this_document['sequence_number']   ,
//          'secondary_sort_value'  =>  $this_document['title']
//          ) ;
//
//      // ---------------------------------------------------------------------
//
//  }

    // -------------------------------------------------------------------------
    // TEASER CATEGORIES...
    // -------------------------------------------------------------------------

    foreach ( $teaser_category_records as $this_index => $this_teaser_category ) {

        // ---------------------------------------------------------------------

        if ( $this_teaser_category['parent_key'] === '' ) {
            $parent_type = '' ;

        } else {
            $parent_type = 'teaser-category' ;

        }

        // ---------------------------------------------------------------------

        $type_key_list[] = array(
            'type'                  =>  'teaser-category'                           ,
            'key'                   =>  $this_teaser_category['key']                ,
            'parent_type'           =>  $parent_type                                ,
            'parent_key'            =>  $this_teaser_category['parent_key']         ,
            'primary_sort_value'    =>  $this_teaser_category['sequence_number']    ,
            'secondary_sort_value'  =>  $this_teaser_category['title']
            ) ;

        // ---------------------------------------------------------------------

    }

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $type_key_list ) ;

    // =========================================================================
    // Create the type key TREE (from the type key LIST)...
    // =========================================================================

    require_once( $caller_apps_includes_dir . '/dataset-manager/type-key-tree-support.php' ) ;

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\create_type_key_tree(
    //      $type_key_list
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // Converts the input "type key list" into a "type key tree".
    //
    // ---
    //
    // The input $type_key_tree is like (eg):-
    //
    //      $type_key_list = array(
    //
    //          [0] => Array(
    //                      [type]                  => document
    //                      [key]                   => 531812f122157
    //                      [parent_type]           =>
    //                      [parent_key]            =>
    //                      [primary_sort_value]    => 10
    //                      [secondary_sort_value]  => Teaser Maker User Manual
    //                      )
    //
    //          [1] => Array(
    //                      [type]                  => section
    //                      [key]                   => 5319171085fbc
    //                      [parent_type]           => document
    //                      [parent_key]            => 531812f122157
    //                      [primary_sort_value]    => 10
    //                      [secondary_sort_value]  => Intro 2
    //                      )
    //
    //          [2] => Array(
    //                      [type]                  => section
    //                      [key]                   => 53194283b436f
    //                      [parent_type]           => document
    //                      [parent_key]            => 531812f122157
    //                      [primary_sort_value]    => 20
    //                      [secondary_sort_value]  => Chapter 1
    //                      )
    //
    //          [3] => Array(
    //                      [type]                  => section
    //                      [key]                   => 5319791c35a4e
    //                      [parent_type]           => section
    //                      [parent_key]            => 53194283b436f
    //                      [primary_sort_value]    => 10
    //                      [secondary_sort_value]  => Child of Chapter 1
    //                      )
    //
    //          )
    //
    // ---
    //
    // The output $type_key_tree is like (eg):-
    //
    //      $type_key_tree = array(
    //
    //          [document-531812f122157] => Array(
    //              [type]                  => document
    //              [key]                   => 531812f122157
    //              [parent_type]           =>
    //              [parent_key]            =>
    //              [primary_sort_value]    => 10
    //              [secondary_sort_value]  => Teaser Maker User Manual
    //              [ancestor_type_keys]    =>
    //              [descendants]           => Array(
    //
    //                  [section-5319171085fbc] => Array(
    //                      [type]                  => section
    //                      [key]                   => 5319171085fbc
    //                      [parent_type]           => document
    //                      [parent_key]            => 531812f122157
    //                      [primary_sort_value]    => 10
    //                      [secondary_sort_value]  => Intro 2
    //                      [ancestor_type_keys]    => Array(
    //                                                      [0] => document-531812f122157
    //                                                      )
    //                      [descendants]           => Array()
    //                      )
    //
    //                  [section-53194283b436f] => Array(
    //                      [type]                  => section
    //                      [key]                   => 53194283b436f
    //                      [parent_type]           => document
    //                      [parent_key]            => 531812f122157
    //                      [primary_sort_value]    => 20
    //                      [secondary_sort_value]  => Chapter 1
    //                      [ancestor_type_keys]    => Array(
    //                                                      [0] => document-531812f122157
    //                                                      )
    //                      [descendants]           => Array(
    //
    //                          [section-5319791c35a4e] => Array(
    //                              [type]                  => section
    //                              [key]                   => 5319791c35a4e
    //                              [parent_type]           => section
    //                              [parent_key]            => 53194283b436f
    //                              [primary_sort_value]    => 10
    //                              [secondary_sort_value]  => Child of Chapter 1
    //                              [ancestor_type_keys]    => Array(
    //                                                              [0] => section-53194283b436f
    //                                                              [1] => document-531812f122157
    //                                                              )
    //                              [descendants]               => Array()
    //                              )
    //
    //                          )
    //
    //                      )
    //
    //                  )
    //
    //              )
    //
    //          ...
    //
    //          )
    //
    // ---
    //
    // The output $type_key_tree is like (eg):-
    //
    //      $ancestry_by_type_key = array(
    //
    //          [document-531812f122157] => Array()
    //
    //          [section-5319171085fbc] => Array(
    //              [0] => document-531812f122157
    //              )
    //
    //          [section-53194283b436f] => Array(
    //              [0] => document-531812f122157
    //              )
    //
    //          [section-5319791c35a4e] => Array(
    //              [0] => document-531812f122157
    //              [1] => section-53194283b436f
    //              )
    //
    //          )
    //
    // ---
    //
    // RETURNS
    //      o   On SUCCESS!
    //              array(
    //                  $type_key_tree          ,
    //                  $ancestry_by_type_key
    //                  )
    //
    //      o   On FAILURE
    //              $error_message STRING
    // -------------------------------------------------------------------------

    $result = \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\create_type_key_tree(
                    $type_key_list
                    ) ;

    // -------------------------------------------------------------------------

    if ( is_string( $result ) ) {

        return array(
                    $failure    ,
                    $result
                    ) ;

    }

    // -------------------------------------------------------------------------

    list(
        $type_key_tree          ,
        $ancestry_by_type_key
        ) = $result ;

    // -------------------------------------------------------------------------

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $type_key_tree ) ;

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $ancestry_by_type_key ) ;

    // =========================================================================
    // Load the TEASER CATEGORY record indices by key...
    // =========================================================================

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

    $dataset_title  = 'Teaser Categories' ;
    $key_field_slug = 'key' ;

    // -------------------------------------------------------------------------

    $teaser_category_record_indices_by_key =
        \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\get_dataset_record_indices_by_key(
            $dataset_title              ,
            $teaser_category_records    ,
            $key_field_slug
            ) ;

    // -------------------------------------------------------------------------

    if ( is_string( $teaser_category_record_indices_by_key ) ) {

        return array(
                    $failure                            ,
                    $teaser_category_record_indices_by_key
                    ) ;

    }

    // =========================================================================
    // Create and return the output OPTIONS list...
    // =========================================================================

    $options = array() ;

    // -------------------------------------------------------------------------

    //      $type_key_tree = array(
    //
    //          [document-531812f122157] => Array(
    //              [type]                  => document
    //              [key]                   => 531812f122157
    //              [parent_type]           =>
    //              [parent_key]            =>
    //              [primary_sort_value]    => 10
    //              [secondary_sort_value]  => Teaser Maker User Manual
    //              [ancestor_type_keys]    =>
    //              [descendants]           => Array(
    //
    //                  [section-5319171085fbc] => Array(
    //                      [type]                  => section
    //                      [key]                   => 5319171085fbc
    //                      [parent_type]           => document
    //                      [parent_key]            => 531812f122157
    //                      [primary_sort_value]    => 10
    //                      [secondary_sort_value]  => Intro 2
    //                      [ancestor_type_keys]    => Array(
    //                                                      [0] => document-531812f122157
    //                                                      )
    //                      [descendants]           => Array()
    //                      )
    //
    //                  [section-53194283b436f] => Array(
    //                      [type]                  => section
    //                      [key]                   => 53194283b436f
    //                      [parent_type]           => document
    //                      [parent_key]            => 531812f122157
    //                      [primary_sort_value]    => 20
    //                      [secondary_sort_value]  => Chapter 1
    //                      [ancestor_type_keys]    => Array(
    //                                                      [0] => document-531812f122157
    //                                                      )
    //                      [descendants]           => Array(
    //
    //                          [section-5319791c35a4e] => Array(
    //                              [type]                  => section
    //                              [key]                   => 5319791c35a4e
    //                              [parent_type]           => section
    //                              [parent_key]            => 53194283b436f
    //                              [primary_sort_value]    => 10
    //                              [secondary_sort_value]  => Child of Chapter 1
    //                              [ancestor_type_keys]    => Array(
    //                                                              [0] => section-53194283b436f
    //                                                              [1] => document-531812f122157
    //                                                              )
    //                              [descendants]               => Array()
    //                              )
    //
    //                          )
    //
    //                      )
    //
    //                  )
    //
    //              )
    //
    //          ...
    //
    //          )

    // -------------------------------------------------------------------------

    //      array(
    //          "Option Group 1 Title"  =>  array(
    //              "option A value"    =>  "Option A Text"
    //              "option B value"    =>  "Option B Text"
    //              ...
    //              )
    //          "Option Group 2 Title"  =>  array(
    //              "option M value"    =>  "Option M Text"
    //              "option N value"    =>  "Option N Text"
    //              ...
    //              )
    //          ...
    //          )

    // -------------------------------------------------------------------------

    $level = 1 ;

    // -------------------------------------------------------------------------

    if ( $question_adding ) {
        $selected_teaser_category_key = NULL ;

    } else {
        $selected_teaser_category_key = $the_record['key'] ;

    }

    // -------------------------------------------------------------------------

    foreach ( $type_key_tree as $this_type_key => $this_type_key_data ) {

        // ---------------------------------------------------------------------

        $this_record = $teaser_category_records[
                                    $teaser_category_record_indices_by_key[
                                        $this_type_key_data['key']
                                        ]
                                    ] ;

        // ---------------------------------------------------------------------

        $options[ $this_record['title'] ] = array(
            $this_type_key_data['key']  =>  $this_record['title']
            ) ;

        // ---------------------------------------------------------------------

        $title_so_far = $this_record['title'] ;

        // ---------------------------------------------------------------------

        add_sub_tree_options(
            $this_type_key_data['descendants']          ,
            $level                                      ,
            $this_record['title']                       ,
            $title_so_far                               ,
            $teaser_category_records                    ,
            $teaser_category_record_indices_by_key      ,
            $selected_teaser_category_key               ,
            $options
            ) ;

        // ---------------------------------------------------------------------

    }

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $options ) ;

    // -------------------------------------------------------------------------
    // bool natcasesort ( array &$array )
    // - - - - - - - - - - - - - - - - -
    // natcasesort() is a case insensitive version of natsort().
    //
    // This function implements a sort algorithm that orders alphanumeric
    // strings in the way a human being would while maintaining key/value
    // associations. This is described as a "natural ordering".
    //
    // PARAMETERS
    //
    //      array
    //          The input array.
    //
    // Returns TRUE on success or FALSE on failure.
    //
    // EXAMPLE
    //
    //      Standard sorting
    //      ----------------
    //      Array(
    //          [0] => IMG0.png
    //          [1] => IMG3.png
    //          [2] => img1.png
    //          [3] => img10.png
    //          [4] => img12.png
    //          [5] => img2.png
    //      )
    //
    //      Natural order sorting (case-insensitive)
    //      ----------------------------------------
    //      Array(
    //          [0] => IMG0.png
    //          [4] => img1.png
    //          [3] => img2.png
    //          [5] => IMG3.png
    //          [2] => img10.png
    //          [1] => img12.png
    //          )
    //
    // (PHP 4, PHP 5)
    // -------------------------------------------------------------------------

//  $temp = $options ;
//
//  // -------------------------------------------------------------------------
//
//  if ( natcasesort( $temp ) === TRUE ) {
//      $options = $temp ;
//  }

    // -------------------------------------------------------------------------

    return array(
                $success    ,
                $options
                ) ;

    // =========================================================================
    // That's that!
    // =========================================================================

}

// =============================================================================
// add_sub_tree_options()
// =============================================================================

function add_sub_tree_options(
    $descendants                                ,
    $level                                      ,
    $top_level_title                            ,
    $title_so_far                               ,
    $teaser_category_records                    ,
    $teaser_category_record_indices_by_key      ,
    $selected_teaser_category_key               ,
    &$options
    ) {

    // -------------------------------------------------------------------------

//  $indent = str_repeat( '-' , $level * 8 ) ;

    // -------------------------------------------------------------------------

    foreach ( $descendants as $this_type_key => $this_type_key_data ) {

        // ---------------------------------------------------------------------

        if ( $this_type_key === $selected_teaser_category_key ) {

            continue ;
                //  When EDITING, a section's parent can't be itself or any
                //  of it's own descendants.  So we DON'T list these
                //  elements.

        }

        // ---------------------------------------------------------------------

        $this_record = $teaser_category_records[
                            $teaser_category_record_indices_by_key[
                                $this_type_key_data['key']
                                ]
                            ] ;

        // ---------------------------------------------------------------------

        $new_title_so_far =
            $title_so_far .
            ' &nbsp;&raquo;&nbsp; ' .
            $this_record['title']
            ;

        // ---------------------------------------------------------------------

        $options[ $top_level_title ][ $this_type_key_data['key'] ] =
            $new_title_so_far
            ;

        // ---------------------------------------------------------------------

        add_sub_tree_options(
            $this_type_key_data['descendants']          ,
            $level + 1                                  ,
            $top_level_title                            ,
            $new_title_so_far                           ,
            $teaser_category_records                    ,
            $teaser_category_record_indices_by_key      ,
            $selected_teaser_category_key               ,
            $options
            ) ;

        // ---------------------------------------------------------------------

    }

    // -------------------------------------------------------------------------

}

// =============================================================================
// get_parent_type_key_for_select_box()
// =============================================================================

function get_parent_type_key_for_select_box(
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
    ) {

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

    $success = TRUE ;
    $failure = FALSE ;

    // -------------------------------------------------------------------------

    if ( $question_adding ) {

        return array(
                    $success    ,
                    ''
                    ) ;

    }

    // -------------------------------------------------------------------------

    if ( $the_record['parent_is'] === 'document' ) {
        $parent_type_key = 'd-' . $the_record['parent_key'] ;

    } else {
        $parent_type_key = 's-' . $the_record['parent_key'] ;

    }

    // -------------------------------------------------------------------------

    return array(
                $success            ,
                $parent_type_key
                ) ;

    // -------------------------------------------------------------------------

}

// =============================================================================
// get_parent_key()
// =============================================================================

function get_parent_key(
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
    $array_storage_field_slug               ,
    $extra_args
    ) {

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

    // ---------------------------------------------------------------------
    // NOTE!
    // -----
    // We get the parent_key from:-
    //
    //      $_POST['parent_key']
    //
    // where this is one of:-
    //
    //      o   'd-<document-key>'
    //      o   's-<section-key>'
    // ---------------------------------------------------------------------

    if ( ! array_key_exists( 'parent_key' , $_POST ) ) {

        return <<<EOT
PROBLEM:&nbsp; No "parent_key"
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_datasetDef_sections\\get_parent_key()
EOT;

    }

    // -------------------------------------------------------------------------

    if ( strlen( $_POST['parent_key'] ) < 3 ) {

        return <<<EOT
PROBLEM:&nbsp; Bad "parent_key"
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_datasetDef_sections\\get_parent_key()
EOT;

    }

    // -------------------------------------------------------------------------

    $prefix = substr( $_POST['parent_key'] , 0 , 2 ) ;

    // -------------------------------------------------------------------------

    if (    $prefix === 'd-'
            ||
            $prefix === 's-'
        ) {
        $field_value = substr( $_POST['parent_key'] , 2 ) ;
        return array( $field_value ) ;
    }

    // -------------------------------------------------------------------------

    return <<<EOT
PROBLEM:&nbsp; Bad "parent_key"
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_datasetDef_sections\\get_parent_key()
EOT;

    // -------------------------------------------------------------------------

}

// =============================================================================
// get_parent_is()
// =============================================================================

function get_parent_is(
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
    $array_storage_field_slug               ,
    $extra_args
    ) {

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

    // ---------------------------------------------------------------------
    // NOTE!
    // -----
    // We get the parent_key from:-
    //
    //      $_POST['parent_key']
    //
    // where this is one of:-
    //
    //      o   'd-<document-key>'
    //      o   's-<section-key>'
    // ---------------------------------------------------------------------

    if ( ! array_key_exists( 'parent_key' , $_POST ) ) {

        return <<<EOT
PROBLEM:&nbsp; No "parent_key"
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_datasetDef_sections\\get_parent_is()
EOT;

    }

    // -------------------------------------------------------------------------

    if ( strlen( $_POST['parent_key'] ) < 3 ) {

        return <<<EOT
PROBLEM:&nbsp; Bad "parent_key"
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_datasetDef_sections\\get_parent_is()
EOT;

    }

    // -------------------------------------------------------------------------

    $prefix = substr( $_POST['parent_key'] , 0 , 2 ) ;

    // -------------------------------------------------------------------------

    if ( $prefix === 'd-' ) {
        $field_value = 'document' ;
        return array( $field_value ) ;

    } elseif ( $prefix === 's-' ) {
        $field_value = 'section' ;
        return array( $field_value ) ;

    }

    // -------------------------------------------------------------------------

    return <<<EOT
PROBLEM:&nbsp; Bad "parent_key"
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_datasetDef_sections\\get_parent_is()
EOT;

    // -------------------------------------------------------------------------

}

// =============================================================================
// get_ancestors_slash_title_column_value()
// =============================================================================

function get_ancestors_slash_title_column_value(
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
    &$loaded_datasets
    ) {

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

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $custom_get_table_data_function_data  = Array(
    //
    //          [type_key_tree] => Array(
    //
    //              [document-531b3c7423408] => Array(
    //                  [type]                  => document
    //                  [key]                   => 531b3c7423408
    //                  [parent_type]           =>
    //                  [parent_key]            =>
    //                  [primary_sort_value]    =>
    //                  [secondary_sort_value]  => Another Document
    //                  [ancestor_type_keys]    =>
    //                  [descendants]           => Array(
    //
    //                      [section-531b3c9501765] => Array(
    //                          [type]                  => section
    //                          [key]                   => 531b3c9501765
    //                          [parent_type]           => document
    //                          [parent_key]            => 531b3c7423408
    //                          [primary_sort_value]    =>
    //                          [secondary_sort_value]  => Coutevald
    //                          [ancestor_type_keys]    => Array(
    //                              [0] => document-531b3c7423408
    //                              )
    //                          [descendants]           => Array()
    //                          )
    //
    //                      [section-531af5831a885] => Array(
    //                          [type]                  => section
    //                          [key]                   => 531af5831a885
    //                          [parent_type]           => document
    //                          [parent_key]            => 531b3c7423408
    //                          [primary_sort_value]    =>
    //                          [secondary_sort_value]  => Send grapndchild of chapter 1
    //                          [ancestor_type_keys]    => Array(
    //                              [0] => document-531b3c7423408
    //                              )
    //                          [descendants]           => Array()
    //                          )
    //
    //                      )
    //
    //                  )
    //
    //              [document-531812f122157] => Array(
    //                  [type]                  => document
    //                  [key]                   => 531812f122157
    //                  [parent_type]           =>
    //                  [parent_key]            =>
    //                  [primary_sort_value]    => 10
    //                  [secondary_sort_value]  => Teaser Maker User Manual
    //                  [ancestor_type_keys]    =>
    //                  [descendants]           => Array(
    //
    //                      [section-53194283b436f] => Array(
    //                          [type]                  => section
    //                          [key]                   => 53194283b436f
    //                          [parent_type]           => document
    //                          [parent_key]            => 531812f122157
    //                          [primary_sort_value]    => 10
    //                          [secondary_sort_value]  => Chapter 1
    //                          [ancestor_type_keys]    => Array(
    //                              [0] => document-531812f122157
    //                              )
    //                          [descendants]           => Array(
    //
    //                              [section-531af52b33e67] => Array(
    //                                  [type]                  => section
    //                                  [key]                   => 531af52b33e67
    //                                  [parent_type]           => section
    //                                  [parent_key]            => 53194283b436f
    //                                  [primary_sort_value]    =>
    //                                  [secondary_sort_value]  => 2nd child of cjhapter 1
    //                                  [ancestor_type_keys]    => Array(
    //                                      [0] => section-53194283b436f
    //                                      [1] => document-531812f122157
    //                                      )
    //                                  [descendants]           => Array()
    //                                  )
    //
    //                              [section-531b3bfcc16cb] => Array(
    //                                  [type]                  => section
    //                                  [key]                   => 531b3bfcc16cb
    //                                  [parent_type]           => section
    //                                  [parent_key]            => 53194283b436f
    //                                  [primary_sort_value]    =>
    //                                  [secondary_sort_value]  => Gkneeflick
    //                                  [ancestor_type_keys]    => Array(
    //                                      [0] => section-53194283b436f
    //                                      [1] => document-531812f122157
    //                                      )
    //                                  [descendants]           => Array()
    //                                  )
    //
    //                              [section-5319791c35a4e] => Array(
    //                                  [type]                  => section
    //                                  [key]                   => 5319791c35a4e
    //                                  [parent_type]           => section
    //                                  [parent_key]            => 53194283b436f
    //                                  [primary_sort_value]    => 10
    //                                  [secondary_sort_value]  => Child of Chapter 1
    //                                  [ancestor_type_keys]    => Array(
    //                                      [0] => section-53194283b436f
    //                                      [1] => document-531812f122157
    //                                      )
    //                                  [descendants]           => Array(
    //
    //                                      [section-531af557d6010] => Array(
    //                                          [type]                  => section
    //                                          [key]                   => 531af557d6010
    //                                          [parent_type]           => section
    //                                          [parent_key]            => 5319791c35a4e
    //                                          [primary_sort_value]    =>
    //                                          [secondary_sort_value]  => grandchils of chaper 1
    //                                          [ancestor_type_keys]    => Array(
    //                                              [0] => section-5319791c35a4e
    //                                              [1] => section-53194283b436f
    //                                              [2] => document-531812f122157
    //                                              )
    //                                          [descendants]           => Array()
    //                                          )
    //
    //                                      )
    //
    //                                  )
    //
    //                              )
    //
    //                          )
    //
    //                      [section-5319171085fbc] => Array(
    //                          [type]                  => section
    //                          [key]                   => 5319171085fbc
    //                          [parent_type]           => document
    //                          [parent_key]            => 531812f122157
    //                          [primary_sort_value]    => 10
    //                          [secondary_sort_value]  => Intro 2
    //                          [ancestor_type_keys]    => Array(
    //                              [0] => document-531812f122157
    //                              )
    //                          [descendants]           => Array()
    //                          )
    //
    //                      )
    //
    //                  )
    //
    //              )
    //
    //          [ancestry_by_type_key] => Array(
    //
    //              [document-531812f122157]    => Array()
    //
    //              [document-531b3c7423408]    => Array()
    //
    //              [section-5319171085fbc]     => Array(
    //                  [0] => document-531812f122157
    //                  )
    //
    //              [section-53194283b436f]     => Array(
    //                  [0] => document-531812f122157
    //                  )
    //
    //              [section-5319791c35a4e]     => Array(
    //                  [0] => document-531812f122157
    //                  [1] => section-53194283b436f
    //                  )
    //
    //              [section-531af52b33e67]     => Array(
    //                  [0] => document-531812f122157
    //                  [1] => section-53194283b436f
    //                  )
    //
    //              [section-531af557d6010]     => Array(
    //                  [0] => document-531812f122157
    //                  [1] => section-53194283b436f
    //                  [2] => section-5319791c35a4e
    //                  )
    //
    //              [section-531af5831a885]     => Array(
    //                  [0] => document-531b3c7423408
    //                  )
    //
    //              [section-531b3bfcc16cb]     => Array(
    //                  [0] => document-531812f122157
    //                  [1] => section-53194283b436f
    //                  )
    //
    //              [section-531b3c9501765]     => Array(
    //                  [0] => document-531b3c7423408
    //                  )
    //
    //              )
    //
    //          [key_of_first_section_in_tree_order]    =>  531b3c9501765
    //
    //          [last_displayed_ancestors_part]         =>
    //
    //          )
    //
    // -------------------------------------------------------------------------

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $custom_get_table_data_function_data ) ;

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $this_column_def = Array(
    //          [base_slug]                     =>  parent_key
    //          [label]                         =>  Document / Section
    //          [question_sortable]             =>  1
    //          [raw_value_from]                =>  Array(
    //                                                  [method]    => custom-function
    //                                                  [instance]  => \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_datasetDef_sections\get_document_slash_section_for_slash_from_parent_key
    //                                                  )
    //          [display_treatments]            =>  Array()
    //          [sort_treatments]               =>  Array()
    //          [data_field_slug_to_display]    =>  parent_key
    //          [data_field_slug_to_sort_by]    =>  parent_key
    //          [header_halign]                 =>  center
    //          [header_valign]                 =>  middle
    //          [data_halign]                   =>  center
    //          [data_valign]                   =>  middle
    //          [width_in_percent]              =>  16.666666666667
    //          )
    //
    // -------------------------------------------------------------------------

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $this_column_def ) ;

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $this_dataset_record_data = Array(
    //          [created_server_datetime_UTC]       =>  1394153232
    //          [last_modified_server_datetime_UTC] =>  1394153232
    //          [key]                               =>  5319171085fbc
    //          [parent_key]                        =>  531812f122157
    //          [parent_is]                         =>  document
    //          [title]                             =>  Intro 2
    //          [description]                       =>
    //          [description_format]                =>  none
    //          [image_url]                         =>
    //          [sequence_number]                   =>  10
    //          )
    //
    // -------------------------------------------------------------------------

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $this_dataset_record_data ) ;

    // =========================================================================
    // Init.
    // =========================================================================

    $ns = __NAMESPACE__ ;
    $fn = __FUNCTION__  ;

    // =========================================================================
    // Support Routines...
    // =========================================================================

    require_once( $caller_apps_includes_dir . '/dataset-manager/type-key-tree-support.php' ) ;

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\
    // explode_type_key(
    //      $type_key
    //      )
    // - - - - - - - - -
    // Separates an "type key" like (eg):-
    //      "document-e5dab930-4504-4fef-98d4-fff1b4dd7249-1400645620-97543-34"
    //
    // into it's "type" and "key" components.  Eg:-
    //      $type_key_type = "document"
    //      $type_key_key  = "e5dab930-4504-4fef-98d4-fff1b4dd7249-1400645620-97543-34"
    //
    // RETURNS
    //      ARRAY(
    //          $type_key_type      ,
    //          $type_key_key
    //          )
    // -------------------------------------------------------------------------

    // =========================================================================
    // ERROR CHECKING...
    // =========================================================================

    if ( $dataset_slug !== 'sections' ) {

        $msg = <<<EOT
PROBLEM:&nbsp; Bad "dataset_slug" ("sections" expected)
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        return array( $msg ) ;

    }

    // =========================================================================
    // NOTE!
    // -----
    // The ancestor records that we need to create the:-
    //      "Parent Document / Section"
    //
    // title, are defined in:-
    //      $custom_get_table_data_function_data['ancestry_by_type_key']
    //
    // Ie:-
    //
    //      $custom_get_table_data_function_data['ancestry_by_type_key'] = Array(
    //
    //          [document-531812f122157]    => Array()
    //
    //          [document-531b3c7423408]    => Array()
    //
    //          [section-5319171085fbc]     => Array(
    //              [0] => document-531812f122157
    //              )
    //
    //          [section-53194283b436f]     => Array(
    //              [0] => document-531812f122157
    //              )
    //
    //          [section-5319791c35a4e]     => Array(
    //              [0] => document-531812f122157
    //              [1] => section-53194283b436f
    //              )
    //
    //          [section-531af52b33e67]     => Array(
    //              [0] => document-531812f122157
    //              [1] => section-53194283b436f
    //              )
    //
    //          [section-531af557d6010]     => Array(
    //              [0] => document-531812f122157
    //              [1] => section-53194283b436f
    //              [2] => section-5319791c35a4e
    //              )
    //
    //          [section-531af5831a885]     => Array(
    //              [0] => document-531b3c7423408
    //              )
    //
    //          [section-531b3bfcc16cb]     => Array(
    //              [0] => document-531812f122157
    //              [1] => section-53194283b436f
    //              )
    //
    //          [section-531b3c9501765]     => Array(
    //              [0] => document-531b3c7423408
    //              )
    //
    //          )
    //
    // =========================================================================

    // =========================================================================
    // Get the current section's "type_key"...
    // =========================================================================

    $this_sections_type_key =
        'section-' . $this_dataset_record_data['key']
        ;

    // =========================================================================
    // Get this section's ancestor type-keys...
    // =========================================================================

    if ( ! array_key_exists(
                $this_sections_type_key                                          ,
                $custom_get_table_data_function_data['ancestry_by_type_key']
                )
        ) {

        $msg = <<<EOT
PROBLEM:&nbsp; Can't find current section's "type key" - in "custom_get_table_data_function_data" + "ancestry_by_type_key"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        return array( $msg ) ;

    }

    // -------------------------------------------------------------------------

    $this_sections_ancestor_type_keys =
        $custom_get_table_data_function_data['ancestry_by_type_key'][
            $this_sections_type_key
        ] ;

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $this_sections_ancestor_type_keys = Array(
    //              [0] => document-531812f122157
    //              [1] => section-53194283b436f
    //              [2] => section-5319791c35a4e
    //              )
    //
    // (Though the array could have any number of elements - including none.)
    // -------------------------------------------------------------------------

    // =========================================================================
    // LOAD the "DOCUMENTS" dataset (if it's NEEDED, and NOT already loaded)...
    // =========================================================================

    if (    count( $this_sections_ancestor_type_keys ) > 0
            &&
            ! array_key_exists( 'documents' , $loaded_datasets )
        ) {

        // -------------------------------------------------------------------------
        // load_dataset(
        //      $all_application_dataset_definitions    ,
        //      $caller_apps_includes_dir               ,
        //      &$loaded_datasets                       ,
        //      $dataset_slug                           ,
        //      $dataset_key_field_slug = NULL          ,
        //      $dataset_title = NULL                   ,
        //      $dataset_records = NULL                 ,
        //      $record_indices_by_key = NULL
        //      )
        // - - - - - - - - - - - - - - - - - - -
        // Adds the specified dataset to $loaded_datasets.
        //
        // NOTE!
        // =====
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
        //      o   TRUE on SUCCESS
        //      o   $error_message STRING on FAILURE
        // -------------------------------------------------------------------------

        $_dataset_slug           = 'documents' ;
        $_dataset_key_field_slug = 'key'       ;
        $_dataset_title          = 'Documents' ;
        $_dataset_records        = NULL        ;
        $_record_indices_by_key  = NULL        ;

        // ---------------------------------------------------------------------

        $result = \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\load_dataset(
                        $all_application_dataset_definitions    ,
                        $caller_apps_includes_dir               ,
                        $loaded_datasets                        ,
                        $_dataset_slug                          ,
                        $_dataset_key_field_slug                ,
                        $_dataset_title                         ,
                        $_dataset_records                       ,
                        $_record_indices_by_key
                        ) ;

        // ---------------------------------------------------------------------

        if ( is_string( $result ) ) {
            return array( $result ) ;
        }

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // LOAD the "SECTIONS" dataset (if it's NEEDED, and NOT already loaded)...
    // =========================================================================

    if (    count( $this_sections_ancestor_type_keys ) > 1
            &&
            ! array_key_exists( 'sections' , $loaded_datasets )
        ) {

        // -------------------------------------------------------------------------
        // load_dataset(
        //      $all_application_dataset_definitions    ,
        //      $caller_apps_includes_dir               ,
        //      &$loaded_datasets                       ,
        //      $dataset_slug                           ,
        //      $dataset_key_field_slug = NULL          ,
        //      $dataset_title = NULL                   ,
        //      $dataset_records = NULL                 ,
        //      $record_indices_by_key = NULL
        //      )
        // - - - - - - - - - - - - - - - - - - -
        // Adds the specified dataset to $loaded_datasets.
        //
        // NOTE!
        // =====
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
        //      o   TRUE on SUCCESS
        //      o   $error_message STRING on FAILURE
        // -------------------------------------------------------------------------

        $_dataset_slug           = 'sections' ;
        $_dataset_key_field_slug = 'key'      ;
        $_dataset_title          = 'Sections' ;
        $_dataset_records        = NULL       ;
        $_record_indices_by_key  = NULL       ;

        // ---------------------------------------------------------------------

        $result = \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\load_dataset(
                        $all_application_dataset_definitions    ,
                        $caller_apps_includes_dir               ,
                        $loaded_datasets                        ,
                        $_dataset_slug                          ,
                        $_dataset_key_field_slug                ,
                        $_dataset_title                         ,
                        $_dataset_records                       ,
                        $_record_indices_by_key
                        ) ;

        // ---------------------------------------------------------------------

        if ( is_string( $result ) ) {
            return array( $result ) ;
        }

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // Create the "Section Ancestors / Title" string...
    // =========================================================================

    // -------------------------------------------------------------------------
    // Ancestor part
    // -------------------------------------------------------------------------

    $ancestors_part = '' ;

    $comma = '' ;

    // -------------------------------------------------------------------------

    foreach ( $this_sections_ancestor_type_keys as $this_ancestor_type_key ) {

        // ---------------------------------------------------------------------

        if ( $ancestors_part !== '' ) {
            break ;
                //  Show ONLY the Document Title!
        }

        // ---------------------------------------------------------------------

        list(
            $type   ,
            $key
            ) = \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\explode_type_key(
                    $this_ancestor_type_key
                    ) ;

        // ---------------------------------------------------------------------

        if ( $type === 'document' ) {

            $title = $loaded_datasets['documents']['records'][
                            $loaded_datasets['documents']['record_indices_by_key'][
                                $key
                                ]
                            ]['title']
                            ;

        } elseif ( $type === 'section' ) {

            $title = $loaded_datasets['sections']['records'][
                            $loaded_datasets['sections']['record_indices_by_key'][
                                $key
                                ]
                            ]['title']
                            ;

        }

        // ---------------------------------------------------------------------

        $ancestors_part .= $comma . $title ;

        // ---------------------------------------------------------------------

        $comma = ' &nbsp;&raquo;&nbsp; ' ;

        // ---------------------------------------------------------------------

    }

    // -------------------------------------------------------------------------

    $ancestors_part .= '&nbsp; /' ;

    // -------------------------------------------------------------------------
    // Section Title part...
    // -------------------------------------------------------------------------

    $mdashes = str_repeat( '&mdash;&nbsp;&nbsp;' , count( $this_sections_ancestor_type_keys ) ) ;

    // -------------------------------------------------------------------------

    $section_title_part = <<<EOT
&nbsp;&nbsp;&nbsp;<b>{$mdashes}{$this_dataset_record_data['title']}</b>
EOT;

    // =========================================================================
    // Reset:-
    //      $custom_get_table_data_function_data['last_displayed_ancestors_part']
    //
    // if it's the FIRST section to be listed...
    // =========================================================================

    if ( $this_dataset_record_data['key'] === $custom_get_table_data_function_data['key_of_first_section_in_tree_order'] ) {
        $custom_get_table_data_function_data['last_displayed_ancestors_part'] = NULL ;
    }

    // =========================================================================
    // Figure out what to return...
    //
    // Taking into account that if the preceding section's ancestor part is the
    // same as this section's ancestor part, then we return just the section
    // title part.
    // =========================================================================

    if ( $ancestors_part === $custom_get_table_data_function_data['last_displayed_ancestors_part'] ) {
        $out = $section_title_part ;

    } else {
        $out = <<<EOT
<big><b style="background-color:#DDFFDD; color:#6F6F6F; padding:0 0.33em; display:inline-block"
    >{$ancestors_part}</b></big><br />{$section_title_part}
EOT;

    }

    // =========================================================================
    // Update:-
    //      $custom_get_table_data_function_data['last_displayed_ancestors_part']
    // =========================================================================

    $custom_get_table_data_function_data['last_displayed_ancestors_part'] = $ancestors_part ;

    // =========================================================================
    // SUCCESS!
    // =========================================================================

    return $out ;

    // =========================================================================
    // That's that!
    // =========================================================================

}

// =============================================================================
// my_pre_get_sections_table_data_function()
// =============================================================================

function my_pre_get_sections_table_data_function(
    $dataset_slug                           ,
    $dataset_title                          ,
    $question_front_end                     ,
    $caller_apps_includes_dir               ,
    &$all_application_dataset_definitions   ,
    &$selected_datasets_dmdd                ,
    &$dataset_records                       ,
    &$loaded_datasets
    ) {

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

    // =========================================================================
    // Init.
    // =========================================================================

    $ns = __NAMESPACE__ ;
    $fn = __FUNCTION__  ;

    // =========================================================================
    // ERROR CHECKING...
    // =========================================================================

    if ( $dataset_slug !== 'sections' ) {

        return <<<EOT
PROBLEM:&nbsp; Bad "dataset_slug" ("sections" expected)
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

    }

    // =========================================================================
    // Load the SECTIONS dataset (unless it's already loaded)...
    // =========================================================================

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\load_dataset(
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

    $_dataset_slug           = 'sections'       ;
    $_dataset_key_field_slug = 'key'            ;
    $_dataset_title          = 'Sections'       ;
    $_dataset_records        = $dataset_records ;
    $_record_indices_by_key  = NULL             ;

    // -------------------------------------------------------------------------

    $ok = \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\load_dataset(
            $all_application_dataset_definitions    ,
            $caller_apps_includes_dir               ,
            $loaded_datasets                        ,
            $_dataset_slug                          ,
            $_dataset_key_field_slug                ,
            $_dataset_title                         ,
            $_dataset_records                       ,
            $_record_indices_by_key
            ) ;

    // -------------------------------------------------------------------------

    if ( is_string( $ok ) ) {
        return $ok ;
    }

    // =========================================================================
    // Load the DOCUMENTS dataset (unless it's already loaded)...
    // =========================================================================

    $_dataset_slug           = 'documents'      ;
    $_dataset_key_field_slug = 'key'            ;
    $_dataset_title          = 'Documents'      ;
    $_dataset_records        = NULL             ;
    $_record_indices_by_key  = NULL             ;

    // -------------------------------------------------------------------------

    $ok = \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\load_dataset(
            $all_application_dataset_definitions    ,
            $caller_apps_includes_dir               ,
            $loaded_datasets                        ,
            $_dataset_slug                          ,
            $_dataset_key_field_slug                ,
            $_dataset_title                         ,
            $_dataset_records                       ,
            $_record_indices_by_key
            ) ;

    // -------------------------------------------------------------------------

    if ( is_string( $ok ) ) {
        return $ok ;
    }

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $loaded_datasets = Array(
    //
    //          [sections] => Array(
    //              [title]                 => Sections
    //              [records]               => Array(
    //                  [0] => Array(
    //                      [created_server_datetime_UTC] => 1394153232
    //                      [last_modified_server_datetime_UTC] => 1394153232
    //                      [key] => 5319171085fbc
    //                      [parent_key] => 531812f122157
    //                      [parent_is] => document
    //                      [title] => Intro 2
    //                      [description] =>
    //                      [description_format] => none
    //                      [image_url] =>
    //                      [sequence_number] => 10
    //                      )
    //                  ...
    //                  [7] => Array(
    //                      [created_server_datetime_UTC] => 1394293909
    //                      [last_modified_server_datetime_UTC] => 1394293909
    //                      [key] => 531b3c9501765
    //                      [parent_key] => 531b3c7423408
    //                      [parent_is] => document
    //                      [title] => Coutevald
    //                      [description] =>
    //                      [description_format] => none
    //                      [image_url] =>
    //                      [sequence_number] =>
    //                      )
    //                  )
    //              [key_field_slug]        => key
    //              [record_indices_by_key] => Array(
    //                  [5319171085fbc] => 0
    //                  [53194283b436f] => 1
    //                  [5319791c35a4e] => 2
    //                  [531af52b33e67] => 3
    //                  [531af557d6010] => 4
    //                  [531af5831a885] => 5
    //                  [531b3bfcc16cb] => 6
    //                  [531b3c9501765] => 7
    //                  )
    //              )
    //
    //          [documents] => Array(
    //              [title]                 => Documents
    //              [records]               => Array(
    //                  [0] => Array(
    //                      [created_server_datetime_UTC]       => 1394086641
    //                      [last_modified_server_datetime_UTC] => 1394086641
    //                      [key]                               => 531812f122157
    //                      [title]                             => Teaser Maker User Manual
    //                      [description]                       =>
    //                      [description_format]                => none
    //                      [image_url]                         =>
    //                      [sequence_number]                   => 10
    //                      )
    //                  [1] => Array(
    //                      [created_server_datetime_UTC]       => 1394293876
    //                      [last_modified_server_datetime_UTC] => 1394293876
    //                      [key]                               => 531b3c7423408
    //                      [title]                             => Another Document
    //                      [description]                       =>
    //                      [description_format]                => none
    //                      [image_url]                         =>
    //                      [sequence_number]                   =>
    //                      )
    //                  )
    //              [key_field_slug]        => key
    //              [record_indices_by_key] => Array(
    //                  [531812f122157] => 0
    //                  [531b3c7423408] => 1
    //                  )
    //              )
    //
    //          )
    //
    // -------------------------------------------------------------------------

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $loaded_datasets ) ;

    // =========================================================================
    // Create the TYPE KEY LIST (to create the type key tree from)...
    // =========================================================================

    $type_key_list = array() ;

    // -------------------------------------------------------------------------
    // DOCUMENTS...
    // -------------------------------------------------------------------------

    foreach ( $loaded_datasets['documents']['records'] as $this_index => $this_document ) {

        // ---------------------------------------------------------------------

        $type_key_list[] = array(
            'type'                  =>  'document'                          ,
            'key'                   =>  $this_document['key']               ,
            'parent_type'           =>  ''                                  ,
            'parent_key'            =>  ''                                  ,
            'primary_sort_value'    =>  $this_document['sequence_number']   ,
            'secondary_sort_value'  =>  $this_document['title']
            ) ;

        // ---------------------------------------------------------------------

    }

    // -------------------------------------------------------------------------
    // SECTIONS...
    // -------------------------------------------------------------------------

    foreach ( $loaded_datasets['sections']['records'] as $this_index => $this_section ) {

        // ---------------------------------------------------------------------

        $type_key_list[] = array(
            'type'                  =>  'section'                           ,
            'key'                   =>  $this_section['key']                ,
            'parent_type'           =>  $this_section['parent_is']          ,
            'parent_key'            =>  $this_section['parent_key']         ,
            'primary_sort_value'    =>  $this_section['sequence_number']    ,
            'secondary_sort_value'  =>  $this_section['title']
            ) ;

        // ---------------------------------------------------------------------

    }

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $type_key_list ) ;

    // =========================================================================
    // Create the type key TREE (from the type key LIST)...
    // =========================================================================

    require_once( $caller_apps_includes_dir . '/dataset-manager/type-key-tree-support.php' ) ;

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\create_type_key_tree(
    //      $type_key_list
    //      )
    // - - - - - - - - - - -
    // Converts the input "type key list" into a "type key tree".
    //
    // ---
    //
    // The input $type_key_tree is like (eg):-
    //
    //      $type_key_list = array(
    //
    //          [0] => Array(
    //                      [type]                  => document
    //                      [key]                   => 531812f122157
    //                      [parent_type]           =>
    //                      [parent_key]            =>
    //                      [primary_sort_value]    => 10
    //                      [secondary_sort_value]  => Teaser Maker User Manual
    //                      )
    //
    //          [1] => Array(
    //                      [type]                  => section
    //                      [key]                   => 5319171085fbc
    //                      [parent_type]           => document
    //                      [parent_key]            => 531812f122157
    //                      [primary_sort_value]    => 10
    //                      [secondary_sort_value]  => Intro 2
    //                      )
    //
    //          [2] => Array(
    //                      [type]                  => section
    //                      [key]                   => 53194283b436f
    //                      [parent_type]           => document
    //                      [parent_key]            => 531812f122157
    //                      [primary_sort_value]    => 20
    //                      [secondary_sort_value]  => Chapter 1
    //                      )
    //
    //          [3] => Array(
    //                      [type]                  => section
    //                      [key]                   => 5319791c35a4e
    //                      [parent_type]           => section
    //                      [parent_key]            => 53194283b436f
    //                      [primary_sort_value]    => 10
    //                      [secondary_sort_value]  => Child of Chapter 1
    //                      )
    //
    //          )
    //
    // ---
    //
    // The output $type_key_tree is like (eg):-
    //
    //      $type_key_tree = array(
    //
    //          [document-531812f122157] => Array(
    //              [type]                  => document
    //              [key]                   => 531812f122157
    //              [parent_type]           =>
    //              [parent_key]            =>
    //              [primary_sort_value]    => 10
    //              [secondary_sort_value]  => Teaser Maker User Manual
    //              [ancestor_type_keys]    =>
    //              [descendants]           => Array(
    //
    //                  [section-5319171085fbc] => Array(
    //                      [type]                  => section
    //                      [key]                   => 5319171085fbc
    //                      [parent_type]           => document
    //                      [parent_key]            => 531812f122157
    //                      [primary_sort_value]    => 10
    //                      [secondary_sort_value]  => Intro 2
    //                      [ancestor_type_keys]    => Array(
    //                                                      [0] => document-531812f122157
    //                                                      )
    //                      [descendants]           => Array()
    //                      )
    //
    //                  [section-53194283b436f] => Array(
    //                      [type]                  => section
    //                      [key]                   => 53194283b436f
    //                      [parent_type]           => document
    //                      [parent_key]            => 531812f122157
    //                      [primary_sort_value]    => 20
    //                      [secondary_sort_value]  => Chapter 1
    //                      [ancestor_type_keys]    => Array(
    //                                                      [0] => document-531812f122157
    //                                                      )
    //                      [descendants]           => Array(
    //
    //                          [section-5319791c35a4e] => Array(
    //                              [type]                  => section
    //                              [key]                   => 5319791c35a4e
    //                              [parent_type]           => section
    //                              [parent_key]            => 53194283b436f
    //                              [primary_sort_value]    => 10
    //                              [secondary_sort_value]  => Child of Chapter 1
    //                              [ancestor_type_keys]    => Array(
    //                                                              [0] => section-53194283b436f
    //                                                              [1] => document-531812f122157
    //                                                              )
    //                              [descendants]               => Array()
    //                              )
    //
    //                          )
    //
    //                      )
    //
    //                  )
    //
    //              )
    //
    //          ...
    //
    //          )
    //
    // ---
    //
    // The output $type_key_tree is like (eg):-
    //
    //      $ancestry_by_type_key = array(
    //
    //          [document-531812f122157] => Array()
    //
    //          [section-5319171085fbc] => Array(
    //              [0] => document-531812f122157
    //              )
    //
    //          [section-53194283b436f] => Array(
    //              [0] => document-531812f122157
    //              )
    //
    //          [section-5319791c35a4e] => Array(
    //              [0] => document-531812f122157
    //              [1] => section-53194283b436f
    //              )
    //
    //          )
    //
    // ---
    //
    // RETURNS
    //      o   On SUCCESS!
    //              array(
    //                  $type_key_tree          ,
    //                  $ancestry_by_type_key
    //                  )
    //
    //      o   On FAILURE
    //              $error_message STRING
    // -------------------------------------------------------------------------

    $result = \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\create_type_key_tree(
                    $type_key_list
                    ) ;

    // -------------------------------------------------------------------------

    if ( is_string( $result ) ) {
        return $result ;
    }

    // -------------------------------------------------------------------------

    list(
        $type_key_tree          ,
        $ancestry_by_type_key
        ) = $result ;

    // -------------------------------------------------------------------------

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $type_key_tree ) ;

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $ancestry_by_type_key ) ;

    // =========================================================================
    // Sort the SECTION records in TREE order...
    // =========================================================================

    $new_section_records_list = array() ;

    $key_of_first_section_in_tree_order = '' ;

    // -------------------------------------------------------------------------

    foreach ( $type_key_tree as $this_document_type_key => $this_documents_data ) {

        // ---------------------------------------------------------------------

        add_sections_tree_to_new_section_records_list(
            $this_documents_data['descendants']                         ,
            $loaded_datasets['sections']['records']                     ,
            $loaded_datasets['sections']['record_indices_by_key']       ,
            $new_section_records_list                                   ,
            $key_of_first_section_in_tree_order
            ) ;

        // ---------------------------------------------------------------------

    }

    // -------------------------------------------------------------------------

    $dataset_records = $new_section_records_list ;

    // =========================================================================
    // Return the custom "get dataset records table data"...
    // =========================================================================

    return array(
                'type_key_tree'                         =>  $type_key_tree                          ,
                'ancestry_by_type_key'                  =>  $ancestry_by_type_key                   ,
                'key_of_first_section_in_tree_order'    =>  $key_of_first_section_in_tree_order     ,
                'last_displayed_ancestors_part'         =>  NULL
                ) ;

    // =========================================================================
    // That's that!
    // =========================================================================

}

// =============================================================================
// add_sections_tree_to_new_section_records_list()
// =============================================================================

function add_sections_tree_to_new_section_records_list(
    $sub_tree                               ,
    $section_records                        ,
    $section_record_indices_by_key          ,
    &$new_section_records_list              ,
    &$key_of_first_section_in_tree_order
    ) {

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $sub_tree = array(
    //
    //          [section-5319171085fbc] => Array(
    //              [type]                  => section
    //              [key]                   => 5319171085fbc
    //              [parent_type]           => document
    //              [parent_key]            => 531812f122157
    //              [primary_sort_value]    => 10
    //              [secondary_sort_value]  => Intro 2
    //              [ancestor_type_keys]    => Array(
    //                                              [0] => document-531812f122157
    //                                              )
    //              [descendants]           => Array()
    //              )
    //
    //          [section-53194283b436f] => Array(
    //              [type]                  => section
    //              [key]                   => 53194283b436f
    //              [parent_type]           => document
    //              [parent_key]            => 531812f122157
    //              [primary_sort_value]    => 20
    //              [secondary_sort_value]  => Chapter 1
    //              [ancestor_type_keys]    => Array(
    //                                              [0] => document-531812f122157
    //                                              )
    //              [descendants]           => Array(
    //
    //                  [section-5319791c35a4e] => Array(
    //                      [type]                  => section
    //                      [key]                   => 5319791c35a4e
    //                      [parent_type]           => section
    //                      [parent_key]            => 53194283b436f
    //                      [primary_sort_value]    => 10
    //                      [secondary_sort_value]  => Child of Chapter 1
    //                      [ancestor_type_keys]    => Array(
    //                                                      [0] => section-53194283b436f
    //                                                      [1] => document-531812f122157
    //                                                      )
    //                      [descendants]               => Array()
    //                      )
    //
    //                  )
    //
    //              )
    //
    //          ...
    //
    //          )
    //
    // -------------------------------------------------------------------------

    foreach ( $sub_tree as $this_sections_type_key => $this_sections_type_key_data ) {

        // ---------------------------------------------------------------------

        if ( $key_of_first_section_in_tree_order === '' ) {

            $key_of_first_section_in_tree_order =
                $this_sections_type_key_data['key']
                ;

        }

        // ---------------------------------------------------------------------

        $new_section_records_list[] =
            $section_records[
                $section_record_indices_by_key[
                    $this_sections_type_key_data['key']
                    ]
                ] ;

        // ---------------------------------------------------------------------

        add_sections_tree_to_new_section_records_list(
            $this_sections_type_key_data['descendants']     ,
            $section_records                                ,
            $section_record_indices_by_key                  ,
            $new_section_records_list                       ,
            $key_of_first_section_in_tree_order
            ) ;

        // ---------------------------------------------------------------------

    }

    // -------------------------------------------------------------------------

}

// =============================================================================
// That's that!
// =============================================================================

